$(document).ready(function() {
	$(document).foundation();

	$('.dropdown-pane').on('show.zf.dropdown', function() {
		console.log('open');
		$('.featured-product-slider').slick('setPosition');
	});

	/**
	 * Mega Nav Sliders
	 */
	
	$('.featured-product-slider').slick({
		slidesToShow: 2,
		slidesToScroll: 2,
		infinite: true,
		arrows: true,
		dots: true,
	})

})