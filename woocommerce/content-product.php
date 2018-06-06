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
		if ($egg_data[0]['priceOld'] > $egg_data[0]['price']) :
			$price_drop = true;
		else :
			$price_drop = false;
		endif;
		$product_attributes = array();

		if ($egg_data[0]['merchant'] == 'Fanatics') :
			if ($egg_data[0]['extra']['powerranktop100'] == 'Yes' ) :
				$temp_array = array();
				$temp_array['icon'] = 'fa-fire';
				$temp_array['message'] = 'Hot Now!';
				array_push($product_attributes, $temp_array);
			endif;
		elseif ($egg_data[0]['merchant'] == 'Amazon.com') :

			if ($egg_data[0]['extra']['IsEligibleForSuperSaverShipping'] == 1) :
				$temp_array = array();
				$temp_array['icon'] = 'fa-truck';
				$temp_array['message'] = 'Value Shipping';
				array_push($product_attributes, $temp_array);
			endif;

		elseif ($egg_data[0]['domain'] == 'walmart.com') :
			if ($egg_data[0]['extra']['standardShipRate'] < 4) :
				$temp_array = array();
				$temp_array['icon'] = 'fa-truck';
				$temp_array['message'] = 'Value Shipping';
				array_push($product_attributes, $temp_array);
			endif;

			if ($egg_data[0]['extra']['shipToStore'] == 1) :
				$temp_array = array();
				$temp_array['icon'] = 'fa-box';
				$temp_array['message'] = 'Easy Store Pickup';
				array_push($product_attributes, $temp_array);
			endif;
		endif;
	else :
		$price_drop = false;

	endif;

	?>
	<div class="cell product margin-bottom-small <?php if ($price_drop) : ?>price-drop<?php endif; ?>">
		<?php $product = wc_get_product($post->ID); ?>
		<article <?php post_class('match-height'); ?>>
			<?php if ($price_drop) : ?>
				<div class="price-drop-banner">
					<h2>Price Drop</h2>
				</div>
			<?php endif; ?>
			<div class="pad-full-small">
				<h2 class="h6<?php if ($price_drop) : ?> price-drop-pad<?php endif; ?>">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h2>
				<div class="text-center">
					<?php if (isset($product_image_url)) : ?>
						<a href="<?php the_permalink(); ?>"><img src="<?php echo $product_image_url; ?>" alt="Image of <?php echo $product_title; ?>"></a>
					<?php else : ?>
						<?php if (has_post_thumbnail()) : ?>
							<a href="<?php the_permalink(); ?>"><img src="<?php the_post_thumbnail_url(); ?>" alt="Image of <?php the_title(); ?>"></a>
						<?php else : ?>
							<?php 
							$product_leagues = array();
							$leagues = get_field('menu_items', 'options');
							foreach ($leagues as $league) :
								$tax = get_taxonomy($league['item']);
								array_push($product_leagues, $tax);
							endforeach;
							$product_teams = array();
							foreach ($product_leagues as $p_league) : 
								$team = get_the_terms(get_the_ID(), $p_league->name);
								if ($team) :
									array_push($product_teams, $team);
								endif;	
							endforeach;
							$team_logo = get_field('team_logo', $product_teams[0][0]);
							?>
							<a href="<?php the_permalink(); ?>"><img class="text-center" src="<?php echo $team_logo['sizes']['large']; ?>" alt="Team logo for <?php echo $product_teams[0][0]->name; ?>"></a>
						<?php endif; ?>
					<?php endif; ?>
				</div>
				<div class="grid-x grid-padding-x price-row align-middle">
					<div class="medium-shrink cell">
						<p class="price">$<?php echo $product->get_regular_price(); ?></p>
					</div>
					<div class="medium-auto cell">
						<?php if (!empty($product_attributes)) : ?>
							<ul class="menu horizontal product-benefits">
								<?php foreach ($product_attributes as $pa) : ?>
									<li class="menu-text">
										<span class="has-tip" data-tooltip tabindex="1" title="<?php echo $pa['message']; ?>">
											<i class="fa-sm fas <?php echo $pa['icon']; ?>"></i>
										</span>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="grid-x button-row">
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
