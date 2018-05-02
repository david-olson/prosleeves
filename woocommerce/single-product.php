<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
		<section class="products">
			<div class="grid-container">
			<div class="grid-x grid-padding-x margin-bottom-small">
				<div class="large-12 cell white-bg">
					<div class="pad-full-small">
						<h1><?php the_title(); ?></h1>
					</div>
				</div>
			</div>
			<div class="grid-x grid-margin-x">
				<div class="large-6 cell ">
					<div class="pad-full-small white-bg margin-bottom-small">
						<?php get_template_part('woocommerce/single-product/product-image'); ?>	
						<?php get_template_part('woocommerce/single-product/product-thumbnails'); ?>	
					</div>
					<div class="pad-full-small white-bg margin-bottom-small">
						<ul class="menu">
							<li><a href="#description">Description</a></li>
							<li><a href="#coupons">Coupons</a></li>
							<li><a href="#price-alerts">Price Alerts</a></li>
							<li><a href="#price-history">Price History</a></li>
							<li><a href="#reviews">Reviews/Comments</a></li>
						</ul>
					</div>
				</div>
				<div class="large-6 cell ">
					<div class="pad-full-small white-bg">
						<?php get_template_part('woocommerce/single-product/rating'); ?>
						<h1><?php the_title(); ?></h1>
						<hr>
						<div class="grid-x grid-padding-x">
							<div class="large-4 cell">
								<?php get_template_part('woocommerce/single-product/price'); ?>
							</div>
							<div class="large-8 cell">
								<?php $affiliate_link = get_post_meta( get_the_ID(), '_product_url', true ); ?>
								<a href="<?php echo $affiliate_link; ?>" class="button expanded">Buy Now</a>
							</div>
						</div>
						<hr>
						Affiliate Info Here
					</div>

					<a href="#" class="button secondary expanded"><i class="fas fa-list-ul"></i> Add to Wishlist</a>
				</div>
			</div>
		
		<?php
			/**
			 * woocommerce_before_main_content hook.
			 *
			 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
			 * @hooked woocommerce_breadcrumb - 20
			 */
			do_action( 'woocommerce_before_main_content' );
		?>
		
			
		
				<?php //wc_get_template_part( 'content', 'single-product' ); ?>
		
			
		
		<?php
			/**
			 * woocommerce_after_main_content hook.
			 *
			 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
			 */
			do_action( 'woocommerce_after_main_content' );
		?>
		
		<?php
			/**
			 * woocommerce_sidebar hook.
			 *
			 * @hooked woocommerce_get_sidebar - 10
			 */
			//do_action( 'woocommerce_sidebar' );
		?>
			
	</div>
	</section>
	<?php endwhile; // end of the loop. ?>
<?php get_footer();

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
