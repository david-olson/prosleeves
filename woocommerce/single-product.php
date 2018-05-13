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

$taxonomies = get_taxonomies( array(), $output = 'objects' );

if ($taxonomies) :

	foreach ($taxonomies as $tax) :
		$temp_terms = get_the_terms( $post, $tax->name );

		if (!empty($temp_terms)) :
			if (strpos($temp_terms[0]->taxonomy, 'teams')) :
				$team = $temp_terms;
			endif;
		endif;

	endforeach;
endif; 

get_header(); ?>
<?php team_topbar($team[0]); ?>
<?php while ( have_posts() ) : the_post(); ?>
	<section class="products">
		<div class="grid-container">
			<div class="grid-x grid-margin-x margin-bottom-small">
				<div class="large-12 cell white-bg">
					<div class="pad-full-small">
						<div class="grid-x grid-padding-x align-middle">
							<div class="large-auto cell">
								<h1 class="h3"><?php the_title(); ?></h1>
							</div>
							<div class="large-shrink cell text-right">
								<?php if ($average = $product->get_average_rating()) : ?>
								    <?php echo '<div class="star-rating" title="'.sprintf(__( 'Rated %s out of 5', 'woocommerce' ), $average).'"><span style="width:'.( ( $average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">'.$average.'</strong> '.__( 'out of 5', 'woocommerce' ).'</span></div>'; ?>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="grid-x grid-margin-x margin-bottom-medium">
				<div class="large-6 cell " id="main_content">
					<div class="pad-full-small white-bg margin-bottom-small">
						<?php wc_get_template_part('woocommerce/single-product/product-image'); ?>
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
					<div class="pad-full-small white-bg margin-bottom-small">
						<?php 
						$id = get_the_ID();
						$brands = get_the_terms($post, 'brands');
						$category = get_the_terms($post, 'product_cat');
						?>
						<p class="taxonomies"><?php if ($brands) : ?><span class="brands">Brand: <?php foreach ($brands as $brand) : echo $brand->name; endforeach; ?></span><?php endif; ?><?php if ($category) : ?> | Category: <span class="categories"><?php foreach ($category as $cat) : echo $cat->name; endforeach; ?><?php endif; ?></span></p>
						<?php the_excerpt(); ?>
						<hr>
						<ul class="menu horizontal">
							<li class="menu-text">Share this on Social:</li>
							<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
							<li><a href="#"><i class="fab fa-twitter"></i></a></li>
							<li><a href="#"><i class="fab fa-pinterest"></i></a></li>
						</ul>
					</div>
					<div class="pad-full-small white-bg margin-bottom-small">
						<?php echo do_shortcode( '[content-egg-block template=price_alert]' ); ?>
					</div>
					<div class="pad-full-small white-bg margin-bottom-small">
						<?php echo do_shortcode( '[content-egg-block template=price_history]' ); ?>
					</div>
					<div class="pad-full-small white-bg margin-bottom-small">
						<?php comments_template( ); ?>
					</div>
				</div>
				<div class="large-6 cell " data-sticky-container>
					<div class="sticky" data-sticky data-margin-top="1" data-anchor="main_content">
						<div class="pad-full-small white-bg " >
							<?php wc_get_template_part('woocommerce/single-product/rating'); ?>
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
							<?php echo do_shortcode( '[content-egg-block template=offers_logo]' ); ?>
						</div>
						<?php echo do_shortcode('[ti_wishlists_addtowishlist]'); ?>
										</div>
					</div>
			</div>
			<div class="grid-x grid-margin-x margin-bottom-small">
				<div class="large-12 cell">
					<h3 class="text-center"><b>Related Products</b></h3>
				</div>
			</div>
			<div class="grid-x grid-padding-x align-center large-up-4">
				<?php $related_products = wc_get_related_products($post->ID, 4); ?>
					<?php $product = get_posts(array(
						'post__in' => $related_products,
						'post_type' => 'product'
						)); ?>
					<?php foreach ($product as $p) :
						$post = $p;
						setup_postdata( $post );
						get_template_part( 'template-parts/products/home-loop' ); 
					endforeach; ?>

				<?php wp_reset_postdata(); ?>
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
