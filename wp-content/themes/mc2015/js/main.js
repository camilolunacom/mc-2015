$(document).on('ready', function(){
	$('#hamburguer').on('click', function(){
		$('.navigation-menu').toggleClass('is-visible vertical-align');
	});
});