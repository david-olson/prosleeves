<?php get_header(); ?>
<?php 
	$term = get_queried_object();
?>

	<?php team_topbar($term); ?>
	<?php promo_banner(); ?>
	<section class="products">
		<div class="grid-container">
			<div class="grid-x grid-margin-x large-up-4 medium-up-3">
				<?php get_team_product_categories($term); ?>		
			</div>
		</div>
	</section>
<?php get_footer(); ?>