$(document).on('ready', function(){

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

	if($('.owl-carousel').length > 0){
		$('.owl-carousel').owlCarousel({
			autoHeight: true,
			dots: false,
			items: 1,
			loop: true,
			nav: true,
			navContainer: '.gallery-controls',
			navText: ['<i class="icon-left"></i>', '<i class="icon-right"></i>']
		});
	}
});