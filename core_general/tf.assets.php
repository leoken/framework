<?php
/* 
* -------------------------------------
* Common Library of 3rd Party Assets
* -------------------------------------
*/

/* 
 Nivo Slider
 --------------------------------------
 v 2.6

 http://nivo.dev7studios.com
 
 License

 Copyright (c) 2011 Gilbert Pellegrom

 Permission is hereby granted, free of charge, to any person
 obtaining a copy of this software and associated documentation
 files (the "Software"), to deal in the Software without
 restriction, including without limitation the rights to use,
 copy, modify, merge, publish, distribute, sublicense, and/or sell
 copies of the Software, and to permit persons to whom the
 Software is furnished to do so, subject to the following
 conditions:

 The above copyright notice and this permission notice shall be
 included in all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 OTHER DEALINGS IN THE SOFTWARE.
 */

function tf_nivoslider_js() {
	wp_enqueue_script('nivoslider', TF_URL . '/assets/js/jquery.nivo.slider.js', array('jquery'));
	}
	
function tf_nivoslider_css() {
	wp_enqueue_style('nivoslider', TF_URL . '/assets/css/nivo-slider.css');
	}
	
/* 
 FancyBox
 --------------------------------------
 v 1.3.4

 http://fancybox.net/
 
 License

 http://jquery.org/license/
 */

function tf_fancybox_js() {
	wp_enqueue_script('fancybox', TF_URL . '/assets/js/jquery.fancybox-1.3.4.pack.js', array('jquery'));
	}
	
function tf_fancybox_css() {
	wp_enqueue_style('fancybox', TF_URL . '/assets/css/jquery.fancybox-1.3.4.css');
	}	

/* 
 bxSlider
 --------------------------------------
 v 3.0

 http://bxslider.com/
 
 License

 http://www.opensource.org/licenses/mit-license.php
 */	
 
 function tf_bxslider_js() {
	wp_enqueue_script('bxslider', TF_URL . '/assets/js/jquery.bxSlider.min.js', array('jquery'));
	}
	
?>