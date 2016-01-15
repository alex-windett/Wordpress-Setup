// define jQuery
jQuery(function($){
// start custom functions

Foundation.global.namespace = '';

$(document).foundation({
	accordion: {
		multi_expand: false,
		toggleable: true
	},
	offcanvas: {
		close_on_click: true
	},
	// tab: {
	// 	callback : function () {
	// 		destroyMasonry();
	// 		createMasonry();
	// 	}
	// },
	reveal: {
		animation: 'fade',
		animation_speed: 250,
		close_on_background_click: true
	}
});
// no writting in this file