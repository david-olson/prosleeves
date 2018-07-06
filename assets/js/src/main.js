$(document).ready(function() {
	$(document).foundation();

	$('.dropdown-pane').on('show.zf.dropdown', function() {
		$('.featured-product-slider').slick('setPosition');
		$(this).addClass('slide-in');
	});

	$('.dropdown-pane').on('hide.zf.dropdown', function() {
		$(this).removeClass('slide-in');
	});

	$('#mobile_menu').on('closed.zf.offcanvas', function() {
		$('#mobile_menu_toggle').removeClass('is-active');
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
		lazyLoad: 'progressive',
	});

	/**
	 * Match Height
	 * 
	 */
	
	$(window).on('load', function() {
		
	});

	$('.products').imagesLoaded().done(function() {
		$('.match-height').matchHeight({
			byRow: false
		});	
	});

	$(window).resize(function() {
		$('.match-height').matchHeight({
			byRow: false
		});
	});

	

	/**
	 * Filter Toggle
	 * 
	 */
	
	if ($(window).outerWidth() < 1024) {
		$('.filter-toggle').click(function() {
			$(this).find('.hamburger').toggleClass('is-active');
			$('.filter-form').slideToggle(300)
		});
	}

	/**
	 * Add padding on products for buttons
	 * 
	 */
	
	if ($(window).outerWidth() < 640) {
		var multiplier = 2;
		console.log(multiplier);
		$('article.product .price-row').css({
			bottom: ($('article.product').find('a.button').outerHeight() * 2) + 10 + 'px'
		});
	} else {
		var multiplier = 1;
		console.log(multiplier);
	}

	$('article.product').css({
		paddingBottom: ($(this).find('a.button').outerHeight() + $(this).find('p.price').outerHeight()) + 20 + 'px'
	});

	/**
	 * Sidebar View More
	 */
	
	var shopForHeight = $('ul.menu.shop-for').children('li').first().outerHeight();
	var totalShopForHeight = $('ul.menu.shop-for').children('li').length * shopForHeight;

	var departmentsHeight = $('ul.menu.departments li').first().outerHeight();
	var totalDepartmentsHeight = $('ul.menu.departments li').length * departmentsHeight;

	var brandsHeight = $('ul.menu.brands').children('li').first().outerHeight();
	var totalBrandsHeight = $('ul.menu.brands').children('li').length * brandsHeight;
	
	if ($(window).outerWidth() > 1024) {
		$('ul.menu.shop-for').css({
			maxHeight: (shopForHeight * 5) + 'px',
			overflow: 'hidden'
		});
		
		$('ul.menu.departments').css({
			maxHeight: (departmentsHeight * 5) + 'px',
			overflow: 'hidden'
		});
		
		$('ul.menu.brands').css({
			maxHeight: (brandsHeight * 5) + 'px',
			overflow: 'hidden'
		});	
	}


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

	/**
	 * Team Side bar slide up
	 * 
	 */
	
	$('.slide-up').click(function() {
		$(this).toggleClass('closed');
		$(this).siblings('.' + $(this).data('toggle') + '-holder').slideToggle(300);
	})


})