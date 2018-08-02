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


if (has_term('prosleeves', 'product_cat')) :
	get_template_part( 'single-prosleeves' );
else :


get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
	<?php 

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

	$league = explode('_', $team[0]->taxonomy);

	global $post;

	$all_post_meta = get_post_meta($post->ID);

	foreach ($all_post_meta as $key => $value) :
		if (strpos($key, '_cegg') !== false && strpos($key, 'data') !== false) :
			$content_egg = $all_post_meta[$key];
		endif;
	endforeach;
	

	

	if (count($content_egg) > 0) :
		
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

		if (array_key_exists('description', $egg_data[0]) && !empty($egg_data[0]['description'])) :
			$product_description = $egg_data[0]['description'];
		elseif (array_key_exists('itemAttributes', $egg_data[0]['extra']) && array_key_exists('Feature', $egg_data[0]['extra']['itemAttributes'])) :
			$product_description = "<ul>\n";
			foreach ($egg_data[0]['extra']['itemAttributes']['Feature'] as $feature) :
				$product_description .= "<li>".$feature."</li>\n";
			endforeach;
			$product_description .= '</ul>';
		else :
			$product_description = get_the_excerpt();
		endif;

/*
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
		*/

	endif;
	?>
	<?php team_topbar($team[0]); ?>
	<section class="products">
		<div class="grid-container">
			<div class="grid-x grid-margin-x margin-bottom-small">
				<div class="large-12 cell">
					<p class="breadcrumbs"><a href="<?php echo get_home_url(); ?>/<?php echo $league[0] ?>"><?php echo strtoupper($league[0]); ?></a> / <a href="<?php echo get_home_url(); ?>/<?php echo $league[0]; ?>/<?php echo $team[0]->slug; ?>"><?php echo $team[0]->name; ?></a> / <?php echo $post->post_title; ?></p>
				</div>
				<div class="large-12 cell white-bg">
					<div class="pad-full-small">
						<div class="grid-x grid-padding-x align-middle">
							<div class="large-auto cell large-order-1 medium-order-2 small-order-2">
								<h1 class="h4">
									<?php the_title(); ?>
								</h1>
							</div>
							<div class="large-shrink cell text-right-large large-order-2 medium-order-1 small-order-1">
								<?php if ($average = $product->get_average_rating()) : ?>
									<div class="grid-x grid-padding-x">
										<div class="large-shrink cell">
											<h3 class="h5">Fan Style Rating:</h3>
										</div>
										<div class="large-auto cell">
											 <?php echo '<div class="star-rating" title="'.sprintf(__( 'Rated %s out of 5', 'woocommerce' ), $average).'"><span style="width:'.( ( $average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">'.$average.'</strong> '.__( 'out of 5', 'woocommerce' ).'</span></div>'; ?>
										</div>
									</div>
								<?php else : ?>
									<div class="grid-x grid-padding-x">
										<div class="large-12 cell">
											<h3 class="h5">No opinions or comments yet.</h3>
										</div>
									</div>		
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="grid-x grid-margin-x margin-bottom-medium">
				<div class="medium-6 cell large-order-1 medium-order-1 small-order-2 margin-bottom-small" id="main_content">
					<div class="pad-full-small white-bg margin-bottom-small">
						<?php //wc_get_template_part('woocommerce/single-product/product-image'); ?>
						<?php do_action( 'woocommerce_before_single_product_summary' ); ?>
						<?php if (count($content_egg) > 0) : ?>
							<p class="text-center"><small><a href="<?php echo $egg_data[0]['url']; ?>" target="_blank"><img src="/wp-content/plugins/content-egg/res/logos/<?php echo strtolower(str_replace('.', '-', $egg_data[0]['domain'])); ?>.png" style="max-width: 55px; margin-right: 10px; display: inline-block; vertical-align:middle;" alt=""> Click Here For Additional Images.</a></small></p>
						<?php endif; ?>
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
					<div class="pad-full-small white-bg margin-bottom-small" id="description">
						<h3 class="h4 red">Description</h3>
						<?php 
						$id = get_the_ID();
						$brands = get_the_terms($post, 'brands');
						$category = get_the_terms($post, 'product_cat');
						?>
						<p class="taxonomies"><?php if (count($content_egg) > 0) : ?>Brand: <?php echo $egg_data[0]['extra']['itemAttributes']['Brand']; ?><?php else : ?><?php if ($brands) : ?><span class="brands">Brand: <?php foreach ($brands as $brand) : echo $brand->name; endforeach; ?></span><?php endif; ?><?php endif; ?><?php if ($category) : ?> | Category: <span class="categories"><?php foreach ($category as $cat) : echo $cat->name; endforeach; ?></span><?php endif; ?></p>
						<?php //echo $product_description; ?>
						<?php the_content(); ?>
						<hr>
						<?php echo do_shortcode( '[ess_post]' ); ?>
					</div>
					<div class="pad-full-small white-bg margin-bottom-small" id="coupons">
						<?php

							if (count($content_egg) > 0) :
								if (strpos($egg_data[0]['domain'], 'amazon') !== false) :
									$brand_link = strtoupper(str_replace(' ', '+', $egg_data[0]['extra']['itemAttributes']['Brand']));
									$coupon_link = "https://www.amazon.com/hz/coupons/search/?ref=as_li_ss_tl&searchText=$brand_link&linkCode=ll2&tag=prosleeves-20&linkId=e8ddfd5a60aabe0eac79850ee42e6375";
								endif;
								if (strpos($egg_data[0]['domain'], 'fanatics')) :
									$coupon_link = "https://shareasale.com/r.cfm?b=31196&u=1551900&m=7124&urllink=www%2Efanatics%2Ecom%2Fcoupons%2F&afftrack=";
								endif;
								if (strpos($egg_data[0]['domain'], 'walmart')) : 
									$coupon_link = "http://linksynergy.walmart.com/deeplink?id=tgjO7MORl8U&mid=2149&murl=http%3A%2F%2Fwww.walmart.com%2Fstore%2Fcoupons";
								endif;

						?>
						<h3 class="h4 red">Check for the Latest Coupons</h3>
						<p><strong>Check out the latest coupons for <?php echo $egg_data[0]['extra']['itemAttributes']['Brand']; ?> products.</strong></p>
						<a href="<?php echo $coupon_link; ?>" class="button" target="_blank">Click Here</a>
						<?php endif; ?>
					</div>
					<div class="pad-full-small white-bg margin-bottom-small" id="price-alerts">
						<h3 class="h4 red">Price Alerts</h3>
						<?php echo do_shortcode( '[content-egg-block template=price_alert]' ); ?>
					</div>
					<div class="pad-full-small white-bg margin-bottom-small" id="price-history">
						<h3 class="h4 red">Price History</h3>
						<?php echo do_shortcode( '[content-egg-block template=price_history]' ); ?>
					</div>
					<div class="pad-full-small white-bg margin-bottom-small" id="reviews">
						<?php comments_template(); ?>
					</div>
				</div>
				<div class="medium-6 cell large-order-2 medium-order-2 small-order-1 margin-bottom-small" data-sticky-container>
					<div class="sticky" data-sticky data-margin-top="1" data-anchor="main_content">
						<div class="pad-full-small white-bg " >
							<?php wc_get_template_part('woocommerce/single-product/rating'); ?>
							<?php if (count($content_egg) > 0) : ?>
								<h1 class="h4">
									<?php the_title(); ?>											
								</h1>
								<div class="grid-x grid-padding-x">
									<div class="medium-shrink cell">
										<p><small>Available at <?php echo $egg_data[0]['domain']; ?></small></p>
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
								
							<?php else : ?>
								<h1 class="h4"><?php the_title(); ?></h1>
							<?php endif; ?>

							

							<?php
							//<div class="grid-x grid-padding-x">	 
								//<div class="medium-4 cell">
								//	<?php get_template_part('woocommerce/single-product/price');
								//</div>
								//<div class="medium-8 cell">
								//	<?php if (count($content_egg) > 0) : 
										//<a href="<?php echo $product_url; " target="_blank" class="button expanded">Buy Now</a>
									//<?php else :
										//<?php $affiliate_link = get_post_meta( get_the_ID(), '_product_url', true ); 
										//<a href="<?php echo $affiliate_link; " class="button expanded">Buy Now</a>
									//<?php endif; 
								//</div>
							//</div>
							//?>
							<hr>
							<?php echo do_shortcode( '[content-egg-block template=offers_logo]' ); ?>
						</div>
						<?php echo do_shortcode('[ti_wishlists_addtowishlist]'); ?>
										</div>
					</div>
			</div>
			<?php 
				// foreach ($content_egg as $data) :
				// 	$dump = unserialize($data->meta_value); 
				// 	var_dump($dump);
				// endforeach; 

			?>
			<?php //var_dump($egg_data); ?>
			<div class="grid-x grid-margin-x margin-bottom-small">
				<div class="large-12 cell">
					<h3 class="text-center"><b>Related Products</b></h3>
				</div>
			</div>
			<div class="grid-x grid-padding-x align-center medium-up-3 large-up-4">
				<?php $related_products = wc_get_related_products($post->ID, 4); ?>
					<?php $product = get_posts(array(
						'post__in' => $related_products,
						'post_type' => 'product',
						'posts' => 4
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
endif;
/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
