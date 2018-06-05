$(document).ready(function() {
	$(document).foundation();

	$('.dropdown-pane').on('show.zf.dropdown', function() {
		$('.featured-product-slider').slick('setPosition');
		$(this).addClass('slide-in');
	});

	$('.dropdown-pane').on('hide.zf.dropdown', function() {
		$(this).removeClass('slide-in');
	})

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
		paddingBottom: ($(this).find('.button').first().outerHeight() + $(this).find('p.price').outerHeight()) + 'px'
	});

	/**
	 * Sidebar View More
	 */
	
	var shopForHeight = $('ul.menu.shop-for').children('li').first().outerHeight();
	var totalShopForHeight = $('ul.menu.shop-for').children('li').length * shopForHeight;
	
	$('ul.menu.shop-for').css({
		maxHeight: (shopForHeight * 5) + 'px',
		overflow: 'hidden'
	});


	$('.shop-for-view-more').click(function(e) {
		e.preventDefault();
		if ($(this).hasClass('open')) {
			$(this).removeClass('open');
			$('ul.menu.shop-for').css({
				maxHeight: (shopForHeight * 5) + 'px'
			});
			$(this).children('span').html('View More');	
		} else {
			$('ul.menu.shop-for').css({
				maxHeight: totalShopForHeight + 'px'
			});
			$(this).addClass('open');
			$(this).children('span').html('View Less');	
		}
		
	});

	var departmentsHeight = $('ul.menu.departments').children('li').first().outerHeight();
	var totalDepartmentsHeight = $('ul.menu.departments').children('li').length * departmentsHeight;

	$('ul.menu.departments').css({
		maxHeight: (departmentsHeight * 5) + 'px',
		overflow: 'hidden'
	});

	$('.departments-view-more').click(function(e) {
		e.preventDefault();
		if ($(this).hasClass('open')) {
			$(this).removeClass('open');
			$('ul.menu.departments').css({
				maxHeight: (departmentsHeight * 5) + 'px'
			});
			$(this).children('span').html('View More');	
		} else {
			$('ul.menu.departments').css({
				maxHeight: totalDepartmentsHeight + 'px'
			});
			$(this).addClass('open');
			$(this).children('span').html('View Less');	
		}
		
	});

	var brandsHeight = $('ul.menu.brands').children('li').first().outerHeight();
	var totalBrandsHeight = $('ul.menu.brands').children('li').length * brandsHeight;

	$('ul.menu.brands').css({
		maxHeight: (brandsHeight * 5) + 'px',
		overflow: 'hidden'
	});

	$('.brands-view-more').click(function(e) {
		e.preventDefault();
		if ($(this).hasClass('open')) {
			$(this).removeClass('open');
			$('ul.menu.brands').css({
				maxHeight: (brandsHeight * 5) + 'px'
			});
			$(this).children('span').html('View More');	
		} else {
			$('ul.menu.brands').css({
				maxHeight: totalBrandsHeight + 'px'
			});
			$(this).addClass('open');
			$(this).children('span').html('View Less');	
		}
		
	});


})