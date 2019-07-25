export function init() {

	var $map = document.getElementById('map');

	window.callInitGoogleOptions = function() {
		initGoogleOptions();
	};

	var loadAsyncScript = function() {
		var s = document.createElement('script');

		s.src = '//maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyDc0vCJDTFRC727aQe8KtdgGaMagRRO5kI&callback=callInitGoogleOptions';
		document.body.appendChild(s);
	};

	$(window).bind('load scroll', function(){
		var mapCanvasOffset = $('#map').offset().top - $(window).scrollTop() - 1000;

		if( $(window).scrollTop() > mapCanvasOffset && !$('body').is('.map-loaded') ) {

			$(document).trigger('load-map');
		}
	});
	
	$(document).on('load-map', function(){
		$('body').addClass('map-loaded');
		
		loadAsyncScript();
	});

	function initGoogleOptions() {
		var myLatLng = {lat: 52.419757, lng: 16.9168793},
			myOptions = {
	        	zoom: 13,
	        	center: myLatLng,
	        	scrollwheel: false,
                scaleControl: false,
                disableDefaultUI: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP
	        },
	        map = new google.maps.Map($map,myOptions),
	        locations = [
		      ['ul. Słowiańska 38A/B<br/>61-664 Poznań<br/>tel. 22 487 55 55', 52.429117, 16.9255624, 1],
		      ['ul. Libelta 1A<br/>61-706 Poznań<br/>tel. 22 487 55 55', 52.410178, 16.9214543, 2],
		      ['ul. Mielżyńskiego 14<br/>61-725 Poznań<br/>tel. 22 487 55 55', 52.408683, 16.9201933, 3]
		    ];
	        marker = new google.maps.Marker({
		    	position: myLatLng
		  	});

	  	for (var i = 0; i < locations.length; i++) {  
	      var marker = new google.maps.Marker({
	        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
	        map: map
	      });

		  var infowindow = new google.maps.InfoWindow({
	          content: locations[i][0]
		  });

          infowindow.open(map, marker);

	      google.maps.event.addListener(marker, 'click', (function(marker, i) {
	        return function() {
		        infowindow.open(map, marker);
	        }
	      })(marker, i));
	    }

	  	// marker.setMap(map);
	}
	
}