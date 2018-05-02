<?php
	$league = get_query_var( 'league' );
	$team = get_query_var('team');
	$product_cat = get_query_var('product_cat');

	$team_object = get_term_by( 'slug', $team, $league.'_teams' );

	
?>
<?php get_header(); ?>
<?php team_topbar($team_object); ?>
<section class="promo-banner">
	<h2 class="h5">Free shipping on all prosleeves products over $50 | Ends Monday</h2>
</section>
<section class="products">
	<div class="grid-container">
		<div class="grid-x grid-margin-x">
			<div class="large-3 cell">
				<?php get_sidebar('teams'); ?>
			</div>
			<div class="large-9 cell">
				<main>
					<div class="grid-x grid-margin-x large-up-3">
						<?php team_category_products($team_object, $product_cat); ?>		
					</div>
				</main>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>