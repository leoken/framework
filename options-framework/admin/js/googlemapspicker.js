// GetLatLon
// Originally designed by Simon Willison ( http://www.getlatlon.com/ & http://simonwillison.net/ )
// Edited for WordPress / Options Framework

google.load('maps', '2'); // Load version 2 of the Maps API
 
function timezoneLoaded(obj) {
    var timezone = obj.timezoneId;
    if (!timezone) {
        return;
    }
    document.getElementById('timezone').innerHTML = timezone;
    document.getElementById('timezonep').style.display = 'block';
    // Find out what time it is there
    var s = document.createElement('script');
    s.src = "http://json-time.appspot.com/time.json?callback=timeLoaded&tz=" + timezone;
    s.type = 'text/javascript';
    document.getElementsByTagName('head')[0].appendChild(s);
}
 
function timeLoaded(obj) {
    if (obj.datetime) {
        document.getElementById('datetime').innerHTML = obj.datetime;
        document.getElementById('datetimep').style.display = 'block';        
    }
}
 
function updateLatLonFields(lat, lon) {
	oFormObject.elements["tf_googlemapspicker_lat"].value = lat;
	oFormObject.elements["tf_googlemapspicker_lon"].value = lon;
	}
 
function getOSMMapType() {
    // Usage: map.addMapType(getOSMMapType());
    var copyright = new GCopyrightCollection(
        '<a href="http://www.openstreetmap.org/">OpenStreetMap</a>'
    );
    copyright.addCopyright(
        new GCopyright(1, new GLatLngBounds(
            new GLatLng(-90, -180),
            new GLatLng(90, 180)
        ), 0, ' ')
    );
    var tileLayer = new GTileLayer(copyright, 1, 18, {
        tileUrlTemplate: 'http://tile.openstreetmap.org/{Z}/{X}/{Y}.png', 
        isPng: false
    });
    var mapType = new GMapType(
        [tileLayer], G_NORMAL_MAP.getProjection(), 'OSM'
    );
    return mapType;
}
 
function showMap() {
    window.gmap = new google.maps.Map2(document.getElementById('of_googlemapspicker'));
    gmap.addControl(new google.maps.LargeMapControl());
    gmap.addControl(new google.maps.MapTypeControl());
    gmap.addMapType(getOSMMapType());    
    gmap.enableContinuousZoom();
    gmap.enableScrollWheelZoom();
    
    var timer = null;
    
    google.maps.Event.addListener(gmap, "move", function() {
        var center = gmap.getCenter();
        updateLatLonFields(center.lat(), center.lng());
        
        // Wait a second, then figure out the timezone
        if (timer) {
            clearTimeout(timer);
            timer = null;
        }
        timer = setTimeout(function() {
            document.getElementById('timezonep').style.display = 'none';
            document.getElementById('datetimep').style.display = 'none';
            // Look up the timezone using geonames
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.src = "http://ws.geonames.org/timezoneJSON?lat=" + center.lat() +
                "&lng=" + center.lng() + "&callback=timezoneLoaded";
            document.getElementsByTagName("head")[0].appendChild(s);
        }, 1500);
        
    });
    google.maps.Event.addListener(gmap, "zoomend", function(oldZoom, newZoom) {
        document.getElementById("zoom").innerHTML = newZoom;
		oFormObject.elements["tf_googlemapspicker_zoom"].value = newZoom;
    });
    google.maps.Event.addDomListener(document.getElementById('crosshair'),
        'dblclick', function() {
            gmap.zoomIn();
        }
    );
    
	var storedlat: [];
	var storedlon: [];
	var storedzoom: [];
	
	
    // Pass default values or saved values
    gmap.setCenter(
        new google.maps.LatLng(storedlat, storedlon), storedzoom
    );
    
    /* If we have a best-guess for the user's location based on their IP, 
       show a "zoom to my location" link */
    if (google.loader.ClientLocation) {
        var link = document.createElement('a');
        link.onclick = function() {
            gmap.setCenter(
                new google.maps.LatLng(
                    google.loader.ClientLocation.latitude,
                    google.loader.ClientLocation.longitude
                ), 8
            );
            return false;
        }
        link.href = '#'
        link.appendChild(
            document.createTextNode('Zoom to my location (by IP)')
        );
        var form = document.getElementById('geocodeForm');
        var p = form.getElementsByTagName('p')[0];
        p.appendChild(link);
    }
    
    // Set up Geocoder
    window.geocoder = new google.maps.ClientGeocoder();
    
    // If query string was provided, geocode it
    var bits = window.location.href.split('?');
    if (bits[1]) {
        var location = decodeURI(bits[1]);
        document.getElementById('geocodeInput').value = location;
        geocode(location);
    }
    
    // Set up the form
    var geocodeForm = document.getElementById('geocodeForm');
    geocodeForm.onsubmit = function() {
        geocode(document.getElementById('geocodeInput').value);
        return false;
    }
}
 
var accuracyToZoomLevel = [
    1,  // 0 - Unknown location
    5,  // 1 - Country
    6,  // 2 - Region (state, province, prefecture, etc.)
    8,  // 3 - Sub-region (county, municipality, etc.)
    11, // 4 - Town (city, village)
    13, // 5 - Post code (zip code)
    15, // 6 - Street
    16, // 7 - Intersection
    17, // 8 - Address
    17  // 9 - Premise
];
 
function geocodeComplete(result) {
    if (result.Status.code != 200) {
        alert('Could not geocode "' + result.name + '"');
        return;
    }
    var placemark = result.Placemark[0]; // Only use first result
    var accuracy = placemark.AddressDetails.Accuracy;
    var zoomLevel = accuracyToZoomLevel[accuracy] || 1;
    var lon = placemark.Point.coordinates[0];
    var lat = placemark.Point.coordinates[1];
    gmap.setCenter(new google.maps.LatLng(lat, lon), zoomLevel);
}
 
function geocode(location) {
    geocoder.getLocations(location, geocodeComplete);
}
 
google.setOnLoadCallback(showMap);