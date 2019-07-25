import '../helpers/helpers';

import * as slickSliders from '../functions/slickSliders';
import * as scrollEvent from '../eventHandlers/scrollEvent';

import * as selectize from 'selectize';
var moment = require('moment');
moment.locale('pl');

import * as Lazy from 'jquery-lazy';

document.addEventListener('DOMContentLoaded', function(){

	function toggleOverlay() {
		var overlay = $('.overlay');

		if(overlay.hasClass('open')) {
			overlay.removeClass('open');
			overlay.addClass('close');

			setTimeout(function(){
				overlay.removeClass('close');
			}, 250);

		} else if(!overlay.hasClass('close')) {
			overlay.addClass('open');
		}
	}

	var $mainSlider = document.querySelectorAll('.main-slider');

	if($mainSlider){
		slickSliders.init();
	}

	scrollEvent.init();

	$('.trigger-btn, .overlay-close').on('click', toggleOverlay);

	$('input').iCheck({
		checkboxClass: 'icheckbox_square-blue',
		radioClass: 'iradio_square-blue',
		increaseArea: '20%',
	});

	$("img[data-src], div[data-src], a[data-src]").Lazy({
		effect: "fadeIn",
        effectTime: 200,
        enableThrottle: true,
        throttle: 250,
        threshold: 200
	});
	
	$('.data-wyjazdu, .data-powrotu').datepicker({ 
		dateFormat: 'dd.mm.yy',
		minDate: 0
	});

	$('.data-wyjazdu').change(function() {
	  var date2 = $('.data-wyjazdu').datepicker('getDate'); 
	  date2.setDate(date2.getDate()+21); 
	  $('.data-powrotu').datepicker('setDate', date2);
	});

	$('.trip-direction').on('focusin', function(){
		$('.input-hld-tripdirection').addClass('active');
	});

	$('.close-trip-direction-hld, .input-hld-tripdirection .btn--choose').on('click', function(){
		$('.input-hld-tripdirection').removeClass('active');
	});

	$('.del-item').on('click', function(){
		$(this).parent().fadeOut('slow', function(){
			$(this).remove();
		});
	});

	$('.regions-list').on('click', 'li .txt', function(){
		$(this).parent().toggleClass('active').find('.ul-cities').slideToggle();
	});

	$('.trip-direction-inner input').on('ifChecked', function(e){
		if($(this).parent().parent().parent().children('ul').length) {
			$(this).parent().parent().parent().children('ul').find('input').iCheck('check');
		}
	});

	$('.trip-direction-inner input').on('ifUnchecked', function(e){
		if($(this).parent().parent().parent().children('ul').length) {
			$(this).parent().parent().parent().children('ul').find('input').iCheck('uncheck');
		}
	});

	$('.span-button--add').click(function(){
		$(this).addClass('active');
		$('.countries-col').find('.icheckbox_square-blue').iCheck('check');
	});

	$('.span-button--del').click(function(){
		$(this).addClass('active');
		$('.countries-col').find('.icheckbox_square-blue').iCheck('uncheck');
	});

	$('.close-btn, .popup-blank').on('click', function(){
		$('.popup-hld').removeClass('js-show');
	});

	$('.ask-question').on('click', function(){
		$('.popup-hld--question').addClass('js-show');
	});

	$('#overlay-menu').find('.menu-item-has-children a').on('click', function(e){
		if($(this).parent().hasClass('no-click')) {
			e.preventDefault();
			e.stopPropagation();
		}

		$(this).parent().toggleClass('active');

		$(this).parent().find('.sub-menu').first().slideToggle();
	});

	window.addEventListener('mouseup', function(event) {
		var inputHldTripDirection = $('.input-hld-tripdirection');

		if(!inputHldTripDirection.is(event.target) && inputHldTripDirection.has(event.target).length === 0) {
        	inputHldTripDirection.removeClass('active');
    	}
	});

	$('.mobile-preventd').on('click', function(e){
		e.preventDefault();
		e.stopPropagation();
	});
	
	$(".mobile-preventd input").attr('readonly','readonly');

	$(".tab-nav a").each(function(){
		var $self = $(this),
			rel = $self.attr('href');

		rel = rel.replace("#", "");

		$self.attr('href', rel)
	});

	$(".tabs").each(function() {
		var thisItem = $(this); 
		thisItem.find('.tab-content').removeClass('active');
		var rel = thisItem.find('.active a').attr('href');
		var rel2 = thisItem.find('a.active').attr('href');

		thisItem.find('.'+rel).addClass('active');
		thisItem.find('.'+rel2).addClass('active');
	});
	
	$(".tab-nav").on("click", "a", function() { 
		var thisItem = $(this); 
		var parentdiv = thisItem.parents('li').parent('ul').parent('div').parent('div');
		var rel = thisItem.attr('href');
		
		$(parentdiv).find(".tab-nav li").removeClass("active");
		thisItem.parents('li').addClass("active");
		
		$(parentdiv).find(".tab-container .tab-content").hide().removeClass('active');
		$(parentdiv).find(".tab-container ."+rel).fadeIn(500).addClass('active');

		return false;
	});

	if($(window).width() > 600 && $(window).width() < 1100) {
		$('.main-navigation').find('.menu-item-has-children a').on('click', function(e){
			if($(this).parent().hasClass('no-click')) {
				e.preventDefault();
				e.stopPropagation();
			}
		});
	}
});

$(window).on('load', function(){

});