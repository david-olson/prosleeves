<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ProSleeves
 */

?>
	
	<?php if (!is_home()) : ?>
		<section class="promo-blog">
			<div class="grid-x align-stretch">
				<?php if (is_page('blog')) : ?>
					<div class="large-12 cell">
						<?php $deal_image = get_field('background_image', 'options'); ?>
						<div class="deal-banner footer" style="background-image: url('<?php echo $deal_image['sizes']['large']; ?>');">
							<h3><?php the_field('pre_headline', 'options'); ?></h3>
							<h2><?php the_field('main_headline', 'options'); ?></h2>
							<a href="<?php the_field('cta_link', 'options'); ?>"><?php the_field('call_to_action', 'options'); ?></a>
						</div>
					</div>
				<?php else : ?>
					<div class="large-7 cell">
						<?php $deal_image = get_field('background_image', 'options'); ?>
						<div class="deal-banner footer" style="background-image: url('<?php echo $deal_image['sizes']['large']; ?>');">
							<h3><?php the_field('pre_headline', 'options'); ?></h3>
							<h2><?php the_field('main_headline', 'options'); ?></h2>
							<a href="<?php the_field('cta_link', 'options'); ?>"><?php the_field('call_to_action', 'options'); ?></a>
						</div>
					</div>
					<div class="large-5 cell dark-bg">
						<div class="pad-full-small"><?php the_top_ten_preview(); ?></div>
					</div>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

	<footer id="colophon" class="site-footer">
		<section class="categories">
			<div class="grid-container">
				<div class="grid-x grid-margin-x medium-up-5">
				<?php $mega_menu = get_field('menu_items', 'options'); ?>
				<?php foreach ($mega_menu as $menu_item) :
					$tax = get_taxonomy($menu_item['item']);
					$slug = explode('_', $tax->name);
					?>
					<div class="cell hover-up">
						<?php //var_dump($tax); ?>
						<a href="<?php echo get_home_url(); ?>/<?php echo $slug[0]; ?>">	
							<img src="<?php echo $menu_item['menu_logo']['sizes']['team_menu_icon']; ?>" alt="">
							<p class="text-center">Shop Now</p>
						</a>
					</div>
				<?php endforeach; ?>
				</div>
			</div>
		</section>
		<section class="company-info">
			<div class="grid-container">
				<div class="grid-x grid-padding-x">
					<div class="large-2 cell">
						<h4>ProSleeves LLC</h4>
						<ul class="menu vertical">
							<li><a href="<?php echo get_home_url(); ?>/about">About Us</a></li>
							<li><a href="<?php echo get_home_url(); ?>/legal">Terms and Conditions</a></li>
							<li><a href="<?php echo get_home_url(); ?>/privacy-policy">Privacy Policy</a></li>
							<li><a href="<?php echo get_home_url(); ?>/site-map">Site Map</a></li>
							<li><a href="<?php echo get_home_url(); ?>/blog">Blog</a></li>
						</ul>
					</div>
					<div class="large-3 cell">
						<h4>From Our Blog</h4>
						<?php //from our blog ?>
					</div>
					<div class="large-3 cell">
						<h4>On Social</h4>
						<ul class="menu social">
							<li><a href="/facebook"><i class="fab fa-facebook-f"></i></a></li>
							<li><a href="/instagram"><i class="fab fa-instagram"></i></a></li>
							<li><a href="/twitter"><i class="fab fa-twitter"></i></a></li>
						</ul>
					</div>
					<div class="large-4 cell">
						<h4>Mission Statement</h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit aut temporibus facilis molestias harum placeat odit soluta maiores officia praesentium? Provident asperiores quas quisquam quibusdam nisi quos, repellat obcaecati, perferendis amet! Temporibus ratione libero praesentium repudiandae illum consequatur. Ipsum, possimus.</p>
					</div>
				</div>
			</div>
		</section>
		<section class="sub-footer">
			<div class="grid-container">
				<div class="grid-x grid-padding-x">
					<div class="large-12 cell">
						<p class="text-center">A Prosleeves LLC Company</p>
					</div>
				</div>
			</div>
		</section>
	</footer><!-- #colophon -->
	</div>
</div>
<?php wp_footer(); ?>

</body>
</html>
