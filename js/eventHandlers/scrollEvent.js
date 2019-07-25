import {bindEvent} from '../eventHandlers/eventHandler';
var _throttle = require('lodash.throttle');

export function init() {

	// var searchPanel = $(".search-panel");

	// if(searchPanel.length) {
	// 	var sticky = searchPanel.offset().top;

	// 	function myFunction() {
	// 	  if (window.pageYOffset + 110 > sticky) {
	// 	    searchPanel.addClass("search-panel--sticky");
	// 	  } else {
	// 	    searchPanel.removeClass("search-panel--sticky");
	// 	  }
	// 	}
		
	// 	bindEvent(window, 'scroll', _throttle(myFunction, 0));
	// }

	function scrollInit() {
		if($(window).scrollTop() > 20) {
			$('.header').addClass("small-header");	
		} else {
			$('.header').removeClass("small-header");	
		}
	}

	bindEvent(window, 'scroll', _throttle(scrollInit, 0));
};