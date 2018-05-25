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
	});

	/**
	 * Top Ten Product Slider Blog
	 */
	
	$('.top-ten-slider').slick({
		slidesToShow: 1,
		infinite: true,
		arrows: true,
		dots: false,
	});

	/**
	 * Match Height
	 * 
	 */
	
	$('.match-height').matchHeight({
		byRow: false
	});

	/**
	 * Add padding on products for buttons
	 * 
	 */
	
	$('article.product').css({
		paddingBottom: $(this).find('.button').first().outerHeight() + 'px'
	});

})