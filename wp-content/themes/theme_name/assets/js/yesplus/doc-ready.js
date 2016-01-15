//  ***********************
//  $$ Document ready
//  ***********************
$(function() {

	window.windowWidth = $(window).width();
	window.windowHeight = $(window).height();

	window.isiPhone = navigator.userAgent.toLowerCase().indexOf('iphone');
	window.isiPad = navigator.userAgent.toLowerCase().indexOf('ipad');
	window.isiPod = navigator.userAgent.toLowerCase().indexOf('ipod');

	// call custom functions on document ready
	// Any resize JS will also need to go in the debounce.js file
	if (window.windowWidth <= 640) {


	} else if (window.windowWidth > 640) {


	}

});
