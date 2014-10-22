(function($) {
	var $window = $(window),
	    winW    = $window.width(),
	    $body   = $('body'),
	    isExh   = $body.hasClass('single-exhibition'),
	    $menu   = $('#main-menu'),
	    menuH   = $menu.height(),
	    $ssWrap = $('.ss-wrap');


	var mcSetSSControlPos = function(slides) {
		var flex = slides.data('flexslider'),
		    $item = typeof flex === 'object' ? flex.slides.eq(flex.currentSlide) : $('.item', slides),
		    $zoom = $item.find('.zoom'),
		    $info = isExh ? $('header.entry-title') : $item.find('.info'),
		    $img  = $item.find('img')
		    $ctrl = typeof flex === 'object' ? flex.directionNav.parent() : null;

		setTimeout(function() {
			var itemW = $item.width(),
			    imgW  = $img.width();
			    itemH = $item.height(),
			    imgH  = $img.height();

			if ( imgW < itemW ) {
				var dis = Math.round((itemW - imgW) / 2);
				$zoom.css('right', dis);
				$info.css('left', dis);

				if ( $ctrl ) {
					$ctrl.css({
						'width': imgW,
						'left' : dis
					});
				}
			}

			if ( imgH < itemH ) {
				var disH = Math.round((itemH - imgH) / 2);
				$info.css('top', disH);
				$item.css('top', disH);

				if ( $ctrl ) {
					$ctrl.css({
						'width': imgW,
						'left' : dis
					});
				}
			}

			$zoom.removeClass('visuallyhidden');
			if ( (isExh && $item.index() == 0) || !isExh )
				$info.removeClass('visuallyhidden');

			if ( $ctrl )
				$ctrl.removeClass('visuallyhidden');
		}, 600);
	},
	mcSetSSTitle = function( slides, isExhSS ) {
		var flex  = slides.data('flexslider'),
		    $item = typeof flex === 'object' ? flex.slides.eq(flex.currentSlide) : $('.item', slides),
		    $el   = slides.data( 'currTitle' ),
		    title = isExhSS ? $item.find('img').attr('title') : $item.find('h3').text();

		$el.attr('title', title).text( title );
	};


	var mcSetup = function() {
		// Menu
		$('ul.sub-menu', $menu).each(function() {
			var $sub = $(this);
			if ( $sub.parent().is('.current-menu-ancestor') ) {
				$sub.siblings('.parent').trigger('click');
			}
			else {
				$sub.addClass('visuallyhidden');
			}
		});

	}


	$(document).ready(function() {
		$('.parent', $menu).on('click', function(e) {
			var $el    = $(this),
			    $sub   = $el.siblings('.sub-menu'),
			    _menuH = menuH;

			if ( $sub.hasClass('visuallyhidden') || $el.parent().hasClass('current-menu-ancestor') ) {
				_menuH += $sub.removeClass('visuallyhidden').height();
			}
			else {
				$sub.toggleClass('visuallyhidden');
			}

			if ( winW < 1000 ) {
				$('.sub-menu', $menu).not($sub).addClass('visuallyhidden');
				$menu.height( _menuH );
			}
		});


		var $container = $('.grid-exhibitions > .items');
		$container.isotope({
			layoutMode : 'fitRows',
			// animationEngine : 'jquery',
			itemSelector : '.item-grid'
		});

		mcSetup();
	});

	$window.load(function() {
		document.documentElement.className = document.documentElement.className + ' ready';
		var $ssBlocks = $ssWrap.children('section'),
		    ssCount   = $ssBlocks.length;

		if ( ssCount ) {
			$ssBlocks.each(function() {
				var $ss      = $(this),
				    $ssItems = $ss.find('.item'),
				    isImages = $ss.hasClass('ss-images'),
				    isExhSS  = $ss.is('.ss-exhibitions');

				if ( isImages ) {
					var $cBox = $('a.zoom').colorbox({
						rel: 'prefetch',
						loop: true,
						maxWidth: '95%',
						maxHeight: '95%',
						opacity: .8,
						current: false,
						close: '<span class="visuallyhidden">Close</span>',
						title: function() {
							var title = ( isExhSS ) ? $(this).siblings('img').attr('title') :$(this).siblings('h3').text();
							return '<p title="'+title+'">'+title+'</p>';
						},
						onLoad: function() {
							$('#cboxClose').hide();
						},
						onCleanup: function() {
							$('#cboxPager, #cboxHead').remove();
						},
						onComplete: function() {
							$('#cboxPager, #cboxHead').remove();
							$('#cboxClose').show();

							var $el     = $(this),
									current = parseInt( $el.parent().data('index') ),
									pager   = '<div id="cboxPager">',
									$info   = $el.siblings('.info'),
									headTtl = ( isExhSS && $info.length ) ? headTtl = $info.find('h3').text() : headTtl = $('.entry-title h1').text();

							for ( var i = 0; i < $cBox.length; i++ ) {
								pager += '<a';
								if ( i === current )
									pager += ' class="selected"';
								pager +='><span class="visuallyhidden">'+(i+1)+'</span></a>';
							}
							pager += '</div>';

							$(pager).appendTo($('#cboxContent'))
								.on('click', 'a', function() {
									$cBox.eq( $(this).index() ).click();
								});

							$('#cboxContent').append('<div id="cboxHead">'+headTtl+'</div>');
						}
					});
				}
				else { // Video
					$('iframe', $ss).each(function() {
						$(this).data('ar', this.height/this.width).removeAttr('width').removeAttr('height');
					});
				}

				$ss.addClass('flexslider').flexslider({
					slideshow: false,
					keyboard: false,
					animationLoop: false,
					start: function(slides) {
						slides.data( 'currTitle', $('<p class="ss-title" />').insertAfter($('.flex-control-nav', slides).wrap('<div class="ss-current" />')) );
						mcSetSSTitle( slides, isExhSS );

						if ( slides.hasClass('ss-images') )
							mcSetSSControlPos( slides );
					},
					after: function(slides) {
						mcSetSSTitle( slides, isExhSS );

						if ( slides.hasClass('ss-images') )
							mcSetSSControlPos( slides );
					}
				});

				// Only one item
				if ( $ssItems.length === 1 ) {
					$ss.append('<div class="ss-current" />')
						.data( 'currTitle', $('<p class="ss-title" />').appendTo( $ss.find('div.ss-current') ) );
					mcSetSSTitle( $ss, isExhSS );

					if ( isImages ) {
						setTimeout(function() {
							mcSetSSControlPos($ss);
						}, 600);
					}
				}
			});

			if ( ssCount === 2 ) {
				$ssBlocks.not(':first-child').hide();
			}
		}

		// Temporarily hide prev/next buttons on click to reset the position
		$('ul.flex-direction-nav').on('click', 'a', function(e) {
			var $ctrl = $(e.delegateTarget),
			    $ss   = $ctrl.closest('section');

			if ( $ss.hasClass('ss-images') )
				$ctrl.add($ctrl.siblings('.slides').find('.zoom, .info')).addClass('visuallyhidden').removeAttr('style');

			if ( isExh )
				$('header.entry-title').addClass('visuallyhidden').removeAttr('style');
		});


		$('body.single-artist header.entry-title').on('click', 'a', function(e) {
			e.preventDefault();

			var $target = $( $(this).attr('href') );

			if ( ssCount === 2 && $target.is(':hidden') ) {
				$target.siblings(':visible').fadeOut('slow', function() {
					$target.fadeIn('slow');
				});
			}
			else {
				$('html, body').stop().animate({
					scrollTop: ( $target.offset().top - 20 )
				}, 600 );
			}
		});
	})
	.resize(function() {
		winW  = $window.width();
		menuH = $menu.removeAttr('style').height();

		mcSetup();

		if ( $ssWrap.length ) {
			// Reposition image slideshow control buttons
			var $ssImages = $('.ss-images', $ssWrap);
			if ( $ssImages.length ) {
				mcSetSSControlPos( $ssImages );
			}
		}
	});
})(jQuery);
