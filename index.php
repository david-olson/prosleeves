<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ProSleeves
 */

get_header();
?>

	<main id="content">
		<section class="hero">
			<img src="http://placehold.it/1900x500" alt="">
			<!-- <div class="grid-x">
				<div class="large-4 cell">
					<img src="http://placehold.it/600x400" alt="">
				</div>
				<div class="large-8 cell">
					<img src="http://placehold.it/800x275" alt="">
				</div>
			</div> -->
		</section>
		<section class="promo-bar" id="promo_bar">
			<h3 class="text-center">Free Shipping | Ends Monday, March 5th</h3>
		</section>
		<section class="featured-products-menu" id="featured_products_menu">
			<div class="grid-container">
				<div class="grid-x grid-padding-x">
					<div class="large-12 cell">
						<ul class="menu horizontal expanded">
							<li class="menu-text">View Featured Products</li>
							<li><a href="#">Jerseys</a></li>
							<li><a href="#">Jerseys</a></li>
							<li><a href="#">Jerseys</a></li>
							<li><a href="#">Jerseys</a></li>
							<li><a href="#">Jerseys</a></li>
						</ul>
					</div>
				</div>
			</div>
		</section>
		<section class="products" id="products">
			
		</section>
		<section class="top-ten" id="top_ten">
			<h2 class="text-center">Weekly Top 10</h2>
		</section>
	</main>

<?php
get_footer();
