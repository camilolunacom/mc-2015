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

$(function(){
  $('#menu-main a[href*="' + location.pathname.split("/")[1] + '"]').parent().addClass('current_page_item');
  if($('body').hasClass('single-post')){
    $('#menu-main a[href*="news"]').parent().addClass('current_page_item');
  }
});

//Gmaps
function loadMapScript() {
	var script = document.createElement("script");
	script.type = "text/javascript";
	script.src = "//maps.googleapis.com/maps/api/js?key=AIzaSyCrZ41krw8hACJ_MxtBKPRRzrtCEFyxrpA&sensor=false&callback=initializeMap";
	document.body.appendChild(script);
}

function initializeMap() {
  var la_galerie = new google.maps.LatLng(48.863943, 2.360240);
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

var isVertical = function($pic){
  var w = $pic.innerWidth();
  var h = $pic.innerHeight();
  
  if(w > h){
    return 'horizontal';
  }
  else if(w < h){
    return 'vertical';
  }
  else if(w == h){
    return 'square';
  }
}

var adjustImgs = function(){
  $('.owl-carousel figure .img img').each(function(){
    if(isVertical($(this)) == 'horizontal'){
      $(this).css({
        'height': 'auto',
        'width': '100%'
      });
    }
    else if(isVertical($(this)) == 'vertical'){
      $(this).css({
        'height': '100%',
        'width': 'auto'
      });
    }

    if($(this).innerHeight() > $(this).parent().innerHeight()){
      $(this).css({
        'height': '100%',
        'width': 'auto'
      });
    }

    else if($(this).innerWidth() > $(this).parent().innerWidth()){
      $(this).css({
        'height': 'auto',
        'width': '100%'
      });
    }
  });
}

$(window).on('load', function(){
	if($('.owl-carousel').length > 0){
		$('.owl-carousel').owlCarousel({
			dots: false,
      fluidSpeed: true,
			items: 1,
      lazyLoad: true,
			loop: true,
			nav: true,
			navContainer: '.gallery-controls',
			navText: ['<i class="icon-left"></i>', '<i class="icon-right"></i>'],
      onLoadedLazy: adjustImgs,
      smartSpeed: 1000
		});
	}
  adjustImgs();
  $('.loader').remove();
});

$(document).on('ready', function(){

	$( '.post-share .social-network' ).on( 'click', function(e){
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
    $('.exhibition-group').slideUp();
		$('.past-exhibition-year').on('click', function(e){
			e.preventDefault();
      if($(this).hasClass('active')){
        $(this).removeClass('active').siblings('.exhibition-group').slideUp(500);
      }
      else{
        $('.past-exhibition-year').removeClass('active');
        $('.exhibition-group').slideUp();
        $(this).addClass('active').siblings('.exhibition-group').slideDown(500);
      }
		});
		$('.exhibition-close').on('click', function(e){
			e.preventDefault();
			$(this).parent().slideUp(500);
			$('.past-exhibition-year').removeClass('active');
		});
	}

	if ($('#map-canvas').length > 0) {   
		loadMapScript();
	}

  var scrollTimeout;  // Global for any pending scrollTimeout

  $(window).scroll(function(){
    if(scrollTimeout){
      // clear the timeout, if one is pending
      clearTimeout(scrollTimeout);
      scrollTimeout = null;
    }
    scrollTimeout = setTimeout(scrollHandler, 1);
  });

  scrollHandler = function(){
    var ScrollTop = $(window).scrollTop();
    
    if(($('#menu-main').length > 0) && !isTouchDevice()){
      if(ScrollTop >= 70){
        $('.kc-ml-languages, .prod-team').fadeOut();
      }
      else{
        $('.kc-ml-languages, .prod-team').fadeIn();
      }
    }

    if($('article.artist').length > 0){
      //Page bottom detection
      if(!isTouchDevice()){
        var bottom_threshold = ScrollTop + $(window).height();
        var bottom_trigger = $(document).height() - $(window).height()/6;
        if(bottom_threshold >= bottom_trigger){
          $('.next-post-link, .prev-post-link').fadeIn();
        }
        else {
          $('.next-post-link, .prev-post-link').fadeOut();
        }
      }

      var sticky_trigger = $('.post-gallery').offset().top + $('.post-gallery').outerHeight(true) - $('header').outerHeight(true) - $('.post-title').outerHeight(true) + 60;
      if(ScrollTop >= sticky_trigger){
        $('article.artist').removeClass('sticky');
      }
      else{
        $('article.artist').addClass('sticky');
      }
    }

    if(($('#the-gallery').length > 0) && !isTouchDevice()){
      var pics_number = $('.the-gallery-pic').length;
      var sticky_trigger = $('.the-gallery-pic').outerHeight(true)*pics_number - $('header').outerHeight(true);
      if(ScrollTop >= sticky_trigger){
        $('#the-gallery').removeClass('sticky');
        $('.map').removeAttr('style');
      }
      else{
        $('#the-gallery').addClass('sticky');
        $('.map').css('margin-top', $('#the-gallery').outerHeight(true));
      }
    }
  };

  if($('article.artist').length > 0){
    $('article.artist').addClass('sticky');
  }

  if(($('#the-gallery').length > 0) && !isTouchDevice()){
    $('#the-gallery').addClass('sticky');
    $('.map').css('margin-top', $('#the-gallery').outerHeight(true));
  }

  //Random position for featured img in news
  if($('.news-item').length > 0){
    var min = 0;
    var max = 4;
    var position = [0, 20, 40, 60, 80];
    var random, prevRandom;
    var randomGenerator = function(min, max){
      var rand = Math.floor((Math.random() * (max - min + 1)) + min);
      return rand;
    }

    $('.news-item').each(function(){
      random = randomGenerator(min, max);
      while(random === prevRandom){
        random = randomGenerator(min, max);
      }
      prevRandom = random;

      $(this).css('background-position', position[random] + '% center');
    });
  }

  //Fullscreen for pictures
  if($('.post-gallery .owl-carousel').length > 0){
    var evt = (isTouchDevice() ? 'touchstart' : 'click');
    if(!screenfull.isFullscreen){
      $('.post-gallery .owl-carousel').on(evt, function(e){
        console.log(e.type);
        var $el = $(this).parent()[0];
        if(screenfull.enabled){
          screenfull.request($el);
        }
      });
    }
    $('.post-gallery .exit-fs').on(evt, function(){
      if(screenfull.enabled){
        screenfull.exit();
      }
    });
  }

  $(document).on(screenfull.raw.fullscreenchange, function(){
    setTimeout(function(){
      $('.owl-carousel').trigger('refresh.owl.carousel');
      adjustImgs();
    }, 200);
  });
});