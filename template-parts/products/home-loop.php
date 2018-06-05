<?php

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
		<article <?php post_class('match-height'); ?>>
			<div class="pad-full-small">
				<h2 class="h6">
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
				<p class="price">$<?php echo $product->get_regular_price(); ?></p>
			</div>
			<div class="grid-x button-row">
				<div class="medium-6 cell">
					<a href="<?php the_permalink(); ?>" class="button expanded no-mb">More Details</a>
				</div>
				<div class="medium-6 cell relative">
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