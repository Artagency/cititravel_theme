export function init() {

	var $mainSlider = document.querySelectorAll('.main-slider'),
		$mainBanner = document.querySelectorAll('.main-banner');
		// $offersSlider = document.querySelectorAll('.offers-slider');

	if($mainSlider) {
		$('.main-slider').slick({
			infinite: true,
			speed: 1000,
			slidesToShow: 1,
			autoplay: true,
			fade: true,
			useTransform: true,
			cssEase: 'cubic-bezier(0.75,0.25,0.25,1)',
			dots: true,
			arrows: false,
			prevArrow: '<span class="slick-prev"></span>',
			nextArrow: '<span class="slick-next"></span>'
		});
	}

	if($mainBanner) {
		$('.main-banner').on('lazyLoaded', function (e, slick, image, imageSource) {
		     var imageSource = image.attr('src'); //get source
		     var parentSlide = $(image).parent();
		     parentSlide.css('background-image','url("'+imageSource+'")').addClass('bg-cover'); //replace with background instead
		     image.attr('src',''); // remove source
		});

		$('.main-banner').slick({
			lazyLoad: 'ondemand',
			infinite: true,
			speed: 1000,
			slidesToShow: 1,
			autoplay: true,
			asNavFor: '.banner-thumbs',
			useTransform: true,
			fade: true,
			cssEase: 'cubic-bezier(0.75,0.25,0.25,1)',
			dots: true,
			arrows: true,
			prevArrow: '<span class="slick-prev"><i class="icon-arrow-left"></i></span>',
			nextArrow: '<span class="slick-next"><i class="icon-arrow-right"></i></span>'
		});

		$('.banner-thumbs').on('lazyLoaded', function (e, slick, image, imageSource) {
		     var imageSource = image.attr('src'); //get source
		     var parentSlide = $(image).parent();
		     parentSlide.css('background-image','url("'+imageSource+'")').addClass('bg-cover'); //replace with background instead
		     image.attr('src',''); // remove source
		});

		$('.banner-thumbs').slick({
			lazyLoad: 'ondemand',
			infinite: true,
			speed: 1000,
			slidesToShow: 4,
			slidesToScroll: 1,
			autoplay: false,
			asNavFor: '.main-banner',
			useTransform: true,
			cssEase: 'cubic-bezier(0.75,0.25,0.25,1)',
			dots: false,
			arrows: false,
			centerMode: true,
			focusOnSelect: true,
			prevArrow: '<span class="slick-prev"><i class="icon-arrow-left"></i></span>',
			nextArrow: '<span class="slick-next"><i class="icon-arrow-right"></i></span>'
		});

		$('#banner_container').ready(function() {
            jQuery.ajax({
                url: $('#banner_container').attr('data-href'),
                data: {
                    action: 'load_images', 
                    htlCode: $('#banner_container').attr('data-code'),
                    htlXCode: $('#banner_container').attr('data-xcode'),
                    tourOp: $('#banner_container').attr('data-tourop')
                },
                async: true,
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    if(result!=0) {
                        $('.banner-thumbs').empty(); 
                        $('.main-banner').empty(); 
                        $('.main-banner').slick('unslick');
                        $('.banner-thumbs').slick('unslick'); 
                        for(var i in result) {
                            $('.main-banner').append('<img data-lazy="'+result[i]+'" alt="" />');
                            $('.banner-thumbs').append('<img data-lazy="'+result[i]+'" alt="" />');
                        }

                        $('.main-banner').on('lazyLoaded', function (e, slick, image, imageSource) {
                             var imageSource = image.attr('data-lazy'); //get source
                             var parentSlide = $(image).parent();
                             parentSlide.css('background-image','url("'+imageSource+'")').addClass('bg-cover'); //replace with background instead
                        });

                        $('.main-banner').slick({
                            infinite: true,
                            speed: 1000,
                            slidesToShow: 1,
                            autoplay: true,
                            asNavFor: '.banner-thumbs',
                            useTransform: true,
                            fade: true,
                            cssEase: 'cubic-bezier(0.75,0.25,0.25,1)',
                            dots: true,
                            arrows: true,
                            prevArrow: '<span class="slick-prev"><i class="icon-arrow-left"></i></span>',
                            nextArrow: '<span class="slick-next"><i class="icon-arrow-right"></i></span>'
                        });

                        $('.main-banner').slick('slickRemove',0);

                        $('.banner-thumbs').on('lazyLoaded', function (e, slick, image, imageSource) {
                             var imageSource = image.attr('data-lazy'); //get source
                             var parentSlide = $(image).parent();
                             parentSlide.css('background-image','url("'+imageSource+'")').addClass('bg-cover'); //replace with background instead
                        });

                        $('.banner-thumbs').slick({
                            infinite: true,
                            speed: 1000,
                            slidesToShow: 4,
                            slidesToScroll: 1,
                            autoplay: false,
                            asNavFor: '.main-banner',
                            useTransform: true,
                            cssEase: 'cubic-bezier(0.75,0.25,0.25,1)',
                            dots: false,
                            arrows: false,
                            centerMode: true,
                            focusOnSelect: true,
                            prevArrow: '<span class="slick-prev"><i class="icon-arrow-left"></i></span>',
                            nextArrow: '<span class="slick-next"><i class="icon-arrow-right"></i></span>'
                        });

                        $('.banner-thumbs').slick('slickRemove',0);
                    }
                }
            });
            return false;
      	});
		
	}

	// if($offersSlider) {
	// 	$('.offers-slider').slick({
	// 		infinite: true,
	// 		speed: 1000,
	// 		slidesToShow: 3,
	// 		autoplay: false,
	// 		useTransform: true,
	// 		cssEase: 'cubic-bezier(0.75,0.25,0.25,1)',
	// 		dots: false,
	// 		arrows: true,
	// 		prevArrow: '<span class="slick-prev"><i class="icon-arrow-left"></i></span>',
	// 		nextArrow: '<span class="slick-next"><i class="icon-arrow-right"></i></span>',
	// 		// appendArrows: $('.offer-slider-arrows')
	// 	});
	// }

}