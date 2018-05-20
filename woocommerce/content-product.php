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

global $wpdb, $post;
	

	$content_egg = $wpdb->get_results("SELECT * FROM {$wpdb->postmeta} WHERE post_id = $post->ID and meta_key LIKE '_cegg%data%'");


	if (count($content_egg) > 0 && $content_egg !== null && $content_egg !== false) :
		$egg_data = unserialize( $content_egg[0]->meta_value );
		$egg_data = array_values($egg_data);
		if (array_key_exists('title', $egg_data[0])) :
			$product_title = $egg_data[0]['title'];
		else : 
			$product_title = get_the_title();
		endif;
		if (array_key_exists('price', $egg_data[0])) : 
			$product_price = $egg_data[0]['price'];
		endif;
		if (array_key_exists('currency', $egg_data[0])) :
			$currency = $egg_data[0]['currency']; 
		endif;

		// Images
		// 
		
		if (array_key_exists('img', $egg_data[0])) :
			$product_image_url = $egg_data[0]['img'];
		endif;

		// URL
		
		if (array_key_exists('url', $egg_data[0])) :
			$product_url = $egg_data[0]['url']; 
		endif;


	endif;

	?>
	<div class="cell product margin-bottom-small">
		<?php $product = wc_get_product($post->ID); ?>
		<article <?php post_class(); ?>>
			<div class="pad-full-small">
				<h2 class="h6">
					<?php if (isset($product_title)) : ?>
						<?php echo $product_title; ?>
					<?php else : ?>
						<?php the_title(); ?>
					<?php endif; ?>		
				</h2>
				<?php if (isset($product_image_url)) : ?>
					<img src="<?php echo $product_image_url; ?>" alt="Image of <?php echo $product_title; ?>">
				<?php else : ?>
					<img src="<?php the_post_thumbnail_url(); ?>" alt="Image of <?php the_title(); ?>">
				<?php endif; ?>
				<?php if (isset($product_price)) : ?>
					<p class="price"><?php echo $currency . $product_price; ?></p>
				<?php else : ?>
					<p class="price">$<?php echo $product->get_regular_price(); ?></p>
				<?php endif; ?>
			</div>
			<div class="grid-x">
				<div class="medium-6 cell">
					<a href="<?php the_permalink(); ?>" class="button expanded no-mb">More Details</a>
				</div>
				<div class="medium-6 cell">
					<?php if (has_term('prosleeves', 'product_cat')) : ?>
						<a href="/?add-to-cart=<?php the_ID(); ?>" data-quantity="1" data-product_id="<?php the_ID(); ?>" class="button secondary alternate ajax_add_to_cart add_to_cart_button no-mb expanded">Add to Cart</a>
					<?php else : ?>
						<?php if (isset($product_url)) : ?>
							<a href="<?php echo $product_url; ?>" class="button secondary expanded no-mb">Buy Now</a>
						<?php else : ?>
							<?php $affiliate_link = get_post_meta( get_the_ID(), '_product_url', true ); ?>
							<a href="<?php echo $affiliate_link; ?>" class="button secondary expanded no-mb">Buy Now</a>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>

		</article>
	</div>
