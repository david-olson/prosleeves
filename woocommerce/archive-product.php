<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
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
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

?>
<?php

if ( have_posts() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked wc_print_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action( 'woocommerce_before_shop_loop' );
	?>
	<?php promo_banner(); ?>
	 <section class="products"> 
	 	<div class="grid-container">
	 		<div class="grid-x grid-pading-x align-middle">
	 			<div class="large-6 cell">
	 				<p class="breadcrumbs no-mb">All Products</p>
	 			</div>
	 			<div class="large-6 medium-6 cell">
	 				<form action="<?php echo home_url($wp->request); ?>" method="GET" class="pad-small" id="orderby_form">
	 						<div class="grid-x grid-padding-x align-right align-middle">
	 							<div class="medium-shrink cell">
	 								<h4 class="no-mb h5">Filter: </h4>
	 							</div>
	 							<div class="medium-shrink cell">
	 								<select name="order_by" id="order_by" class="no-mb" onchange="document.getElementById('orderby_form').submit();">
	 									<option value="date_desc" <?php if (isset($_GET['order_by']) && $_GET['order_by'] == 'date_desc') : ?>selected<?php endif; ?>>Date Added: Newest First</option>
	 									<option value="date_asc" <?php if (isset($_GET['order_by']) && $_GET['order_by'] == 'date_asc') : ?>selected<?php endif; ?>>Date Added: Oldest First</option>
	 									<option value="price_asc" <?php if (isset($_GET['order_by']) && $_GET['order_by'] == 'price_asc') : ?>selected<?php endif; ?>>Price: Low to High</option>
	 									<option value="price_desc" <?php if (isset($_GET['order_by']) && $_GET['order_by'] == 'price_desc') : ?>selected<?php endif; ?>>Price: High to Low</option>
	 									<option value="title_asc" <?php if (isset($_GET['order_by']) && $_GET['order_by'] == 'title_asc') : ?>selected<?php endif; ?>>Name: A to Z</option>
	 									<option value="title_desc" <?php if (isset($_GET['order_by']) && $_GET['order_by'] == 'title_desc') : ?>selected<?php endif; ?>>Name: Z to A</option>
	 								</select>
	 							</div>
	 							<?php foreach ($_GET as $key => $value) : ?>
	 								<?php if ($key !== 'order_by') : ?>
	 									<?php if (is_array($value)) : ?>
	 										<?php foreach ($value as $val) : ?>
	 											<input type="hidden" name="<?php echo $key; ?>[]" value="<?php echo $val; ?>">
	 										<?php endforeach; ?>
	 									<?php else : ?>
	 										<input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>">
	 									<?php endif; ?>
	 								<?php endif; ?>
	 							<?php endforeach; ?>
	 							<noscript>
	 								<div class="medium-shrink cell">
	 									<input type="submit" value="Filter" class="button no-mb">
	 								</div>
	 							</noscript>
	 						</div>
	 					</form>
	 			</div>
	 		</div>
	 		<div class="grid-x grid-margin-x">
	 			<div class="large-3 cell">
	 				<?php get_sidebar('teams'); ?>
	 			</div>
	 			<div class="large-9 cell">
				
	 				<?php
	 			woocommerce_product_loop_start();
	 		
	 			if ( wc_get_loop_prop( 'total' ) ) { 
	 				while ( have_posts() ) {
	 					the_post();
	 		
	 					/**
	 					 * Hook: woocommerce_shop_loop.
	 					 *
	 					 * @hooked WC_Structured_Data::generate_product_data() - 10
	 					 */
	 					do_action( 'woocommerce_shop_loop' );
	 		
	 					wc_get_template_part( 'content', 'product' );
	 				}
	 			}
	 		
	 			woocommerce_product_loop_end();
	 			?>
	 				</div>
	 			</div>
	 	</div>
	</section>
	<?php 

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
// do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );
