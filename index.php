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
		<?php promo_banner(); ?>
		<section class="featured-products-menu" id="featured_products_menu">
			<div class="grid-container">
				<div class="grid-x grid-padding-x">
					<div class="large-12 cell">
						<ul class="menu horizontal expanded">
							<li class="menu-text">View Featured Products</li>
							<?php $product_cat = get_terms(array(
								'taxonomy' => 'product_cat',
								'hide_empty' => false,
								'number' => 5
								)); ?>
							<?php foreach ($product_cat as $cat) : ?>
								<li><a href="<?php echo get_home_url(); ?>/products/<?php echo $cat->slug; ?>"><?php echo $cat->name; ?></a></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
		</section>
		<section class="products" id="products">
			<div class="grid-container">
				<?php $args = array(
					'post_type' => 'product',
					'posts_per_page' => 10,
				); ?>
				<?php $product_loop = new WP_Query($args); ?>
				<?php if ($product_loop->have_posts()) : ?>
					<div class="grid-x grid-padding-x medium-up-4 large-up-4 align-stretch">
					<?php $n = 0; ?>
					<?php while ($product_loop->have_posts()) : $product_loop->the_post(); ?>
						<?php get_template_part('template-parts/products/home-loop'); ?>
						<?php if ($n == 5) : ?>
							<?php $deal_image = get_field('background_image', 'options'); ?>
							<div class="cell large-4 deal-banner-cell margin-bottom-small">
								<div class="deal-banner text-center" style="background-image: url('<?php echo $deal_image['sizes']['large']; ?>');">
									<h3><?php the_field('pre_headline', 'options'); ?></h3>
									<h2><?php the_field('main_headline', 'options'); ?></h2>
									<a href="<?php the_field('cta_link', 'options'); ?>"><?php the_field('call_to_action', 'options'); ?></a>
								</div>
							</div>
						<?php endif; ?>
						<?php ++$n; ?>
					<?php endwhile; ?>
					</div>
				<?php endif; ?>
				<div class="grid-x grid-padding-x">
					<div class="large-12 cell text-center">
						<a href="/products" class="button outline">View All</a>
					</div>
				</div>
			</div>
		</section>
		<section class="top-ten" id="top_ten">
			<h2 class="text-center">Weekly Top 10</h2>
		</section>
	</main>

<?php
get_footer();
