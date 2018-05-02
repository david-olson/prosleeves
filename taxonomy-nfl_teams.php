<?php get_header(); ?>
<?php 
	$term = get_queried_object();
?>

	<?php team_topbar($term); ?>
	<section class="promo-banner">
		<h2 class="h5">Free shipping on all prosleeves products over $50 | Ends Monday</h2>
	</section>
	<section class="products">
		<div class="grid-container">
			<div class="grid-x grid-margin-x large-up-4 medium-up-3">
				<?php get_team_product_categories($term); ?>		
			</div>
		</div>
	</section>
<?php get_footer(); ?>