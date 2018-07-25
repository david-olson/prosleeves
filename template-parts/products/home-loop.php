<?php

global $post;
$product = wc_get_product($post->ID);

	$all_post_meta = get_post_meta($post->ID);

	foreach ($all_post_meta as $key => $value) :
		if (strpos($key, '_cegg') !== false && strpos($key, 'data') !== false) :
			$content_egg = $all_post_meta[$key];
		endif;
	endforeach;

	if (count($content_egg) > 0 && $content_egg !== null && $content_egg !== false) :
		$egg_data = unserialize( $content_egg[0] );
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
			$price = $egg_data[0]['price'];
		else :
			$price_drop = false;
			$price = $product->get_regular_price();
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
		$price = $product->get_regular_price();
	endif;

	?>
	<div class="cell product margin-bottom-small <?php if ($price_drop) : ?>price-drop<?php endif; ?>">
		<article <?php post_class('match-height'); ?>>
			<?php if ($price_drop) : ?>
				<div class="price-drop-banner">
					<h2>Price Drop</h2>
				</div>
			<?php endif; ?>
			<div class="pad-full-small">
				
				<div class="text-center margin-bottom-small">
					<?php if (has_post_thumbnail()) : ?>
						<a href="<?php the_permalink(); ?>"><img src="<?php the_post_thumbnail_url('product_loop_image'); ?>" alt="Image of <?php the_title(); ?>"></a>
						
					<?php elseif (isset($product_image_url)) : ?>
						<a href="<?php the_permalink(); ?>"><img src="<?php echo $product_image_url; ?>" alt="Image of <?php echo $product_title; ?>"></a>
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
							<a href="<?php the_permalink(); ?>"><img class="text-center" src="<?php echo $team_logo['sizes']['product_loop_image']; ?>" alt="Team logo for <?php echo $product_teams[0][0]->name; ?>"></a>
					<?php endif; ?>
				</div>
				</div>
				<div class="grid-x price-row">
					<div class="medium-6 cell">
						<?php $brands = get_the_terms( $post->ID, 'brands' ); 
							$brands_array = [];
							if (!empty($brands)) :
								foreach ($brands as $brand) : 
									$brands_array[] = $brand->name;
								endforeach;
							endif;
							$brands_list = implode(', ', $brands_array);
						?>
						<p class="price"><small><?php echo $brands_list; ?></small></p>
					</div>
					<div class="medium-6 cell text-right">
						<?php if ($price > 0) : ?>
							<p class="price text-right">$<?php echo number_format($price, 2); ?></p>
						<?php else : ?>
							<p class="price text-right"><small>Currently Unavailable</small></p>
						<?php endif; ?>
					</div>
					<div class="medium-12 cell">
						<h2 class="h6<?php if ($price_drop) : ?> price-drop-pad<?php endif; ?>">
							<a href="<?php the_permalink(); ?>"><?php echo (strlen(get_the_title()) > 60) ? substr(get_the_title(), 0, 60).'...' : get_the_title(); ?></a>
						</h2>
					</div>
					<?php /*
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
					*/ ?>
				</div>
			
			<div class="grid-x button-row">
				<div class="large-6 cell">
					<a href="<?php the_permalink(); ?>" class="button secondary expanded no-mb">More Details</a>
				</div>
				<div class="large-6 cell relative">
					<?php if (has_term('prosleeves', 'product_cat')) : ?>
						<a href="/?add-to-cart=<?php the_ID(); ?>" data-quantity="1" data-product_id="<?php the_ID(); ?>" class="button alternate ajax_add_to_cart add_to_cart_button no-mb expanded">Add to Cart</a>
					<?php else : ?>
						<?php if (isset($product_url)) : ?>
							<a href="<?php echo $product_url; ?>" class="button expanded no-mb">Buy Now</a>
						<?php else : ?>
							<?php $affiliate_link = get_post_meta( get_the_ID(), '_product_url', true ); ?>
							<a href="<?php echo $affiliate_link; ?>" class="button expanded no-mb">Buy Now</a>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>

		</article>
	</div>