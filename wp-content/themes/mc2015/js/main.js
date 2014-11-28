la_carte = [
  {
    "elementType": "geometry.fill",
    "stylers": [
      {
      	"color": "#333333"
      }
    ]
  },
  {
    "elementType": "geometry.stroke",
    "stylers": [
      {
      	"color": "#111111"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "geometry.stroke",
    "stylers": [
      {
      	"color": "#000000"
      },
      {
      	"weight": 2
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "geometry.fill",
    "stylers": [
      {
      	"color": "#000000"
      }
    ]
  },
  {
  	"featureType": "road",
    "elementType": "labels.icon",
    "stylers": [
      {
      	"color": "#cccccc"
      },
      {
      	"weight": 0.9
      }
    ]
  },
  {
    "elementType": "labels.text",
    "stylers": [
      {
      	"color": "#cccccc"
      },
      {
      	"weight": 0.9
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "geometry.fill",
    "stylers": [
      {
      	"color": "#444444"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "geometry.fill",
    "stylers": [
      {
      	"color": "#333333"
      }
    ]
  },
  {
    "featureType": "poi.government",
    "elementType": "geometry.fill",
    "stylers": [
      {
      	"color": "#444444"
      }
    ]
  }
];

//Gmaps
function loadMapScript() {
	var script = document.createElement("script");
	script.type = "text/javascript";
	script.src = "//maps.googleapis.com/maps/api/js?key=AIzaSyCrZ41krw8hACJ_MxtBKPRRzrtCEFyxrpA&sensor=false&callback=initializeMap";
	document.body.appendChild(script);
}

function initializeMap() {
  var la_galerie = new google.maps.LatLng(48.860143, 2.366514);
  var drag = true;
  if(isTouchDevice()){
  	drag = false;
  }
  var mapOptions = {
    scrollwheel: false,
    zoom: 17,
    center: la_galerie,
    disableDefaultUI: true,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    draggable: drag
  }
  map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
  var marker = new google.maps.Marker({
    position: la_galerie,
    map: map,
    title: ''
  });

  map.setOptions({styles: la_carte});
}

var isTouchDevice = function(){
	return (('ontouchstart' in window) || (navigator.MaxTouchPoints > 0) || (navigator.msMaxTouchPoints > 0));
}

// Social Networks Helpers
var tweetWindow = function(url, text) {
	window.open( "http://twitter.com/share?url=" + encodeURIComponent(url) + "&text=" + encodeURIComponent(text) + "&count=none/", "tweet", "height=300,width=550,resizable=1" ); 
}

var faceWindow = function(url, title) {
	window.open( "http://www.facebook.com/sharer.php?u=" + encodeURIComponent(url) + "&t=" + encodeURIComponent(title), "facebook", "height=300,width=550,resizable=1" ); 
}

$(window).on('load', function(){
	if($('.owl-carousel').length > 0){
		$('.owl-carousel').owlCarousel({
			//autoHeight: true,
			dots: false,
			items: 1,
			loop: true,
			nav: true,
			navContainer: '.gallery-controls',
			navText: ['<i class="icon-left"></i>', '<i class="icon-right"></i>']
		});
	}
});

$(document).on('ready', function(){

	$( '.social-network' ).on( 'click', function(e){
		e.preventDefault();

		var text = $(e.target).attr('data-text'),
			url = $(e.target).attr('data-url');

		if( $(this).hasClass('facewindow') ){
			faceWindow( url, text );
		}

		if( $(this).hasClass('tweetwindow') ){
			tweetWindow( url, text );
		}
	});

	$('#hamburguer').on('click', function(){
		$('.navigation-menu').toggleClass('is-visible vertical-align');
	});

	$('.select-display li a').on('click', function(e){
		e.preventDefault();
		$('.select-display li').removeClass('active');
		$(this).parent().addClass('active');
		if(this.id == 'disp-thumb'){
			$('ul.artists, li.artist').removeClass('list');
			$('ul.artists, li.artist').addClass('thumb');
		}
		else if(this.id == 'disp-list'){
			$('ul.artists, li.artist').removeClass('thumb');
			$('ul.artists, li.artist').addClass('list');
		}
	});

	if($('.past-exhibition-year').length > 0){
		$('.past-exhibition-year').on('click', function(e){
			e.preventDefault();
			$('.past-exhibition-year').removeClass('active');
			$('.exhibition-group').slideUp();
			$(this).addClass('active').siblings('.exhibition-group').slideDown();
		});
		$('.exhibition-close').on('click', function(e){
			e.preventDefault();
			$(this).parent().slideUp();
			$('.past-exhibition-year').removeClass('active');
		});
	}

	if ($('#map-canvas').length > 0) {   
		loadMapScript();
	}
});