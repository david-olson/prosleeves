<?php
	$league = get_query_var( 'league' );
	$team = get_query_var('team');
	$product_cat = get_query_var('product_cat');

	$team_object = get_term_by( 'slug', $team, $league.'_teams' );
?>
<?php get_header(); ?>
<section class="intro team-color-intro <?php check_background_color(get_field('team_primary_color', 'category_'.$team_object->term_id)); ?>" style="background-color: <?php the_field('team_primary_color', 'category_'.$team_object->term_id); ?>">
	<div class="grid-container">
		<div class="grid-x grid-padding-x">
			<div class="large-12 cell">
				<h1><?php echo $team_object->name; ?></h1>
			</div>
		</div>
	</div>
</section>
<section class="promo-banner">
	
</section>
<section class="products">
	<div class="grid-container">
		<div class="grid-x grid-margin-x">
			<div class="large-3 cell">
				<aside class="sidebar">
					<h3>More Filters</h3>
					<p>Viewing:</p> 
					<span class="label"><?php echo $team_object->name; ?> <i class="fas fa-times"></i></span>
					<h4>Shop For</h4>
					<hr>
					<h4>Departments</h4>
					<hr>
					<h4>Brands</h4>
					<hr>
					<h4>Price Range</h4>
					<hr>
				</aside>
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