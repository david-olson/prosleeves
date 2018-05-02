<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<div <?php post_class('cell'); ?>>
	<?php $product = wc_get_product($post->ID); ?>
	<article <?php post_class(); ?>>
		<div class="pad-full-small">
			<h2 class="h5"><?php the_title(); ?></h2>
			<img src="<?php the_post_thumbnail_url( ); ?>" alt="">
			<p class="price">$<?php echo $product->get_regular_price(); ?></p>
		</div>
		<div class="grid-x">
			<div class="medium-6 cell">
				<a href="<?php the_permalink(); ?>" class="button expanded">More Details</a>
			</div>
			<div class="medium-6 cell">
				<a href="<?php echo $product->get_product_url(); ?>" class="button secondary expanded">Buy Now</a>
			</div>
		</div>

	</article>
</div>
