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
<div class="off-canvas position-right" id="sidebar_menu" data-off-canvas>
	<ul class="menu vertical">
		<li><a href="/about">About Us</a></li>
		<li><a href="/legal">Legal</a></li>
		<li><a href="/privacy-policy">Privacy Policy</a></li>
		<li><a href="/site-map">Site Map</a></li>
		<li><a href="/blog">Blog</a></li>
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
						<li><a href="<?php echo get_home_url(); ?>/my-account">Log In / Sign Up</a></li>
						<li><a href="<?php echo get_home_url(); ?>/cart">Cart</a></li>
						<li><a href="#" data-toggle="sidebar_menu"><i class="fas fa-bars"></i></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="header-logo-tagline">
		<div class="grid-container">
			<div class="grid-x grid-padding-x align-middle">
				<div class="large-4 cell">
					<a href="<?php echo get_home_url(); ?>/"><img class="logo" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="Prosleeves - We've got you covered"></a>
				</div>
				<div class="large-8 cell">
					<h2 class="tagline">Price History, Price Alerts and Coupons for All Your Favorite Licensed Gear</h2>
				</div>
			</div>
		</div>
	</div>
	<nav>
			<ul class="menu horizontal expanded dropdown" data-dropdown-menu>
				<?php 
				// Foundation menu here 
				$taxes = array();
				$mega_menu = get_field('menu_items', 'options');
				foreach ($mega_menu as $mm) :
					$tax = get_taxonomy($mm['item']);
					array_push($taxes, $tax);
					?>
					<li class="mega-menu">
						<?php //var_dump($mm); ?>
						<a href="#" data-toggle="<?php echo $tax->name; ?>"><img class="league-logo" src="<?php echo $mm['menu_logo']['sizes']['team_menu_icon']; ?>" alt=""> <?php echo $tax->label; ?></a>
						<div class="dropdown-pane bottom" id="<?php echo $tax->name; ?>" data-dropdown data-options="closeOnClick:true; hover: true; hoverPane: true;">
							<div class="grid-x grid-padding-x">
								<div class="large-8 cell">
									<?php $tax_terms = get_terms(array(
										'taxonomy' => $tax->name,
										'hide_empty' => false
										)); ?>
									<ul class="menu vertical align-left col-4">
										<?php foreach ($tax_terms as $tt) : ?>
											<?php //var_dump($tt); ?>
											<?php $team_logo = get_field('team_logo', 'category_'.$tt->term_id); ?>
											<li><a href="<?php echo get_home_url(); ?>/<?php echo $tax->rewrite['slug']; ?>/<?php echo $tt->slug; ?>"><img class="team-logo" src="<?php echo $team_logo['sizes']['team_menu_icon']; ?>" alt=""><?php echo $tt->name; ?></a></li>
										<?php endforeach; ?>		
									</ul>
								</div>
								<div class="large-4 cell">
									Slider Here
								</div>
							</div>
						</div>
					</li>
					<?php
				endforeach;
				?>
				<li><a href="#">Our Products</a></li>
			</ul>
	</nav>
</header>

	
