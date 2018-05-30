<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ProSleeves
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'prosleeves' ); ?></a>
<div class="off-canvas-wrapper">
<div class="off-canvas position-right side-nav" id="sidebar_menu" data-off-canvas>
	<ul class="menu vertical">
		<li><a href="<?php echo get_home_url(); ?>/about">About Us</a></li>
		<li><a href="<?php echo get_home_url(); ?>/legal">Legal</a></li>
		<li><a href="<?php echo get_home_url(); ?>/privacy-policy">Privacy Policy</a></li>
		<li><a href="<?php echo get_home_url(); ?>/site-map">Site Map</a></li>
		<li><a href="<?php echo get_home_url(); ?>/blog">Blog</a></li>
		<?php //if (is_user_logged_in()) : ?>
			<li><?php echo do_shortcode('[ti_wishlist_products_counter]'); ?></li>
		<?php //endif; ?>
	</ul>
</div>
<div class="off-canvas-content" data-off-canvas-content>
<header class="site-header" id="header">
	<div class="header-top">
		<div class="grid-container">
			<div class="grid-x grid-padding-x">
				<div class="large-4 cell">
					<?php echo do_shortcode('[wcas-search-form]'); ?>		
				</div>
				<div class="large-8 cell text-right">
					<ul class="menu horizontal align-right">
						<?php if (is_user_logged_in()) : ?>
							<?php $user = wp_get_current_user(); ?>
							<li><a href="<?php echo get_home_url(); ?>/my-account"><i class="fas fa-user fa-lg"></i>&nbsp; &nbsp;<?php echo $user->user_email; ?></a></li>
						<?php else : ?>
							<li><a href="<?php echo get_home_url(); ?>/my-account">Log In / Sign Up</a></li>
						<?php endif; ?>
						<?php $count = WC()->cart->cart_contents_count; ?>
						<li class="cart-holder"><a href="<?php echo get_home_url(); ?>/cart" class="cart"><i class="fas fa-shopping-cart fa-lg"></i>&nbsp; &nbsp;Cart <?php if ($count > 0) : echo '('.$count.')'; endif; ?></a></li>
						<li><a href="#" data-toggle="sidebar_menu"><i class="fas fa-bars fa-lg"></i></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="header-logo-tagline">
		<div class="grid-container">
			<div class="grid-x grid-padding-x align-middle">
				<div class="large-3 cell">
					<a href="<?php echo get_home_url(); ?>/"><img class="logo" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="Prosleeves - We've got you covered"></a>
				</div>
				<div class="large-9 cell">
					<h2 class="tagline">Price History, Price Alerts and Coupons for All Your Favorite Licensed Gear</h2>
				</div>
			</div>
		</div>
	</div>
	<nav>
			<ul class="menu leagues-menu horizontal expanded dropdown" data-dropdown-menu>
				<?php 
				// Foundation menu here 
				$taxes = array();
				$mega_menu = get_field('menu_items', 'options');
				foreach ($mega_menu as $mm) :
					$tax = get_taxonomy($mm['item']);
					array_push($taxes, $tax);
					?>
					<li class="mega-menu top-level">
						<?php //var_dump($mm); ?>
						<a href="#" data-toggle="<?php echo $tax->name; ?>"><span><img class="league-logo" src="<?php echo $mm['menu_logo']['sizes']['team_menu_icon']; ?>" alt=""> <?php echo $tax->label; ?></span></a>
						<div class="dropdown-pane bottom" id="<?php echo $tax->name; ?>" data-dropdown data-options="closeOnClick:true; hover: true; hoverPane: true;">
							<div class="grid-x grid-padding-x">
								<div class="large-8 cell">
									<?php $tax_terms = get_terms(array(
										'taxonomy' => $tax->name,
										'hide_empty' => false
										)); ?>
									<ul class="menu vertical align-left col-4 teams-menu">
										<?php foreach ($tax_terms as $tt) : ?>
											<?php //var_dump($tt); ?>
											<?php $team_logo = get_field('team_logo', 'category_'.$tt->term_id); ?>
											<li><a href="<?php echo get_home_url(); ?>/<?php echo $tax->rewrite['slug']; ?>/<?php echo $tt->slug; ?>"><img class="team-logo" src="<?php echo $team_logo['sizes']['team_menu_icon']; ?>" alt=""><?php echo $tt->name; ?></a></li>
										<?php endforeach; ?>		
									</ul>
								</div>
								<div class="large-4 cell vertical-rule-left">
									<h3 class="h5 red text-center">Featured Products</h3>
									<div class="featured-product-slider slick">
										<?php foreach($mm['featured_products'] as $product) : ?>
											<div class="slide text-center">
												<?php $image = get_the_post_thumbnail_url( $product['product']->ID, 'team_topbar_icon' ); ?>
												<a class="text-center" href="<?php the_permalink($product['product']->ID); ?>" title="View <?php echo $product['product']->post_title; ?>">
													<?php if (has_post_thumbnail($product['product']->ID)) : ?>
														<img src="<?php echo $image; ?>" alt="Image of <?php echo get_the_title($product['product']->ID); ?>">
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
															$team = get_the_terms($product['product']->ID, $p_league->name);
															if ($team) :
																array_push($product_teams, $team);
															endif;	
														endforeach;
														$team_logo = get_field('team_logo', $product_teams[0][0]);
														?>
														<img class="text-center" src="<?php echo $team_logo['sizes']['large']; ?>" alt="Team logo for <?php echo $product_teams[0][0]->name; ?>">
													<?php endif; ?>
													<h2 class="text-center"><?php echo $product['product']->post_title; ?></h2>
												</a>
											</div>
										<?php endforeach; ?>
									</div>
								</div>
							</div>
						</div>
					</li>
					<?php
				endforeach;
				?>
				<li class="our-products top-level"><a href="<?php echo get_home_url(); ?>/product-category/prosleeves"><img class="league-logo" src="<?php echo get_template_directory_uri(); ?>/assets/images/prosleeves-icon.svg" > Our Products</a></li>
			</ul>
	</nav>
</header>

	
