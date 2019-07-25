import '../helpers/helpers';

import * as slickSliders from '../functions/slickSliders';
import * as googleMap from '../functions/googleMap';
import * as scrollEvent from '../eventHandlers/scrollEvent';
import * as Powertip from 'powertip';

import * as selectize from 'selectize';
// import * as daterangepicker from 'daterangepicker.js';
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

	var $lightgallery = $('.lightgallery'),
		$map = document.getElementById('map'),
		$mainSlider = document.querySelectorAll('.main-slider'),
		$powertip = document.querySelectorAll('.powertip'),
		$mainBanner = document.querySelectorAll('.main-banner');

	if($mainSlider || $mainBanner){
		slickSliders.init();
	}

	scrollEvent.init();

	$('.trigger-btn, .overlay-close').on('click', toggleOverlay);

	if($lightgallery.length) {
		$(".lightgallery").lightGallery({
			selector: 'this' 
		});
	}

	if($map) {
		googleMap.init();
	}

	if($powertip) {
		$('.powertip').powerTip({
			placement: 's',
			smartPlacement: true,
			offset: 0,
			fadeInTime: 100,
			fadeOutTime: 75
		});
	}

	$('input').iCheck({
		checkboxClass: 'icheckbox_square-blue',
		radioClass: 'iradio_square-blue',
		increaseArea: '20%',
	});

	$('.label-telefonicznie').on('click', function(){
		$('.row--inputs').find('input').iCheck('uncheck');
	});

	$("img[data-src], div[data-src], a[data-src]").Lazy({
		effect: "fadeIn",
        effectTime: 200,
        enableThrottle: true,
        throttle: 250,
        threshold: 200
	});

	$('#offer_preview').on('change', 'input,select', function() {
		$('body').addClass('loading');
	});

	// $('.data-wyjazdu-powrotu').daterangepicker({ autoApply : true });

	// $('.data-wyjazdu').on('apply.daterangepicker', function(ev, picker) {
	//     $(this).val(picker.startDate.format('DD.MM.YYYY'));
	//     var dataWyjazdu = $(this).val();

	//     var dataWyjazdu3tyg = moment(dataWyjazdu, 'DD.MM.YYYY').day(21).format('DD.MM.YYYY');
	//     $('.data-powrotu').val(picker.startDate.format('DD.MM.YYYY'));
	//     // $('.data-powrotu').data('daterangepicker').setEndDate(picker.startDate.format('DD.MM.YYYY'));
	// });
	// $('.data-powrotu').on('apply.daterangepicker', function(ev, picker) {
	//     $(this).val(picker.endDate.format('DD.MM.YYYY'));
	// });
	
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

	$('.regions-list').on('click', 'li .txt', function(){
		$(this).parent().toggleClass('active').find('.ul-cities').slideToggle();
	});

	$('.select-organizer').on('click', function(){
		$('.input-hld--organizer').addClass('active');
	});

	$('.close-select-organizer').on('click', function(){
		$('.input-hld--organizer').removeClass('active');
	});

	$('.search-more').on('click', function(e){
		e.preventDefault();
		e.stopPropagation();

		$('.row--advanced-search').slideToggle();

		$(this).toggleClass('active');
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

	$('.mobile-preventd').on('click', function(e){
		e.preventDefault();
		e.stopPropagation();
	});
	
	$(".mobile-preventd input").attr('readonly','readonly');

	$('.more-dates').on('click', function(e){
		e.preventDefault();
		e.stopPropagation();

		$('.popup-hld--tours').addClass('js-show');
	});

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

	if($('.page-content--main').length) {
		$('<a href="#" class="show-more">Czytaj więcej</a>').insertAfter('.page-content--main');

		$(document).find('.show-more').on('click', function(e){
			e.preventDefault();
			e.stopPropagation();
			
			$('.page-content--main').addClass('active');
			$(this).addClass('active');
		});
	}

	$('.filter-ul').on('click', 'a', function(e){

		var $self = $(this);

		$self.parents('ul').find('a').removeClass('active');

		$self.addClass('active');

		if($self.hasClass('list')) {
			e.preventDefault();
			e.stopPropagation();
			$('.row--columns').fadeOut(function(){
				$('.row--list').fadeIn();
			});
		} else if($self.hasClass('column')) {
			e.preventDefault();
			e.stopPropagation();

			$('.row--list').fadeOut(function(){
				$('.row--columns').fadeIn();
			});
		}
	});

	if($(window).width() > 600 && $(window).width() < 1100) {
		$('.main-navigation').find('.menu-item-has-children a').on('click', function(e){
			if($(this).parent().hasClass('no-click')) {
				e.preventDefault();
				e.stopPropagation();
			}
		});
	}

	$('.data-urodzenia').datepicker({ 
		dateFormat: 'dd.mm.yy', 
		changeMonth: true, 
		changeYear: true, 
		yearRange: "-80:+0", 
		// onChangeMonthYear: function () {
	 //        console.log('o');
	 //    }
	});

	$('.filter-ul-clicked').on('click', 'a', function(){
		$('body').addClass('loading');
	});

	$('body').removeClass('loading');
});

$(window).on('load', function(){
	// if($('.search-panel-small').length && $(window).width() > 768) {
	// 	var headerHeight = $('.header').height();

	// 	var sidebar = new StickySidebar('.search-panel-small-hld', {
	// 	    topSpacing: headerHeight,
	// 	    resizeSensor: true
	// 	});

	// 	$('.details-content-nav').on('click', 'a', function(){
	// 		sidebar.updateSticky();
	// 	});
	// }
});