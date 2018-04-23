<?php get_header(); ?>

<section class="intro team-color-intro <?php check_background_color(get_field('team_primary_color')); ?>" style="background-color: <?php the_field('team_primary_color'); ?>">
	<div class="grid-container">
		<div class="grid-x grid-padding-x">
			<div class="large-12 cell">
				<h1><?php single_term_title(); ?></h1>
			</div>
		</div>
	</div>
</section>
<section class="promo-banner">
	
</section>
<section class="products">
	<div class="grid-container">
		<div class="grid-x grid-margin-x large-up-4 medium-up-3">
			<?php get_team_product_categories(); ?>		
		</div>
	</div>
</section>
<?php get_footer(); ?>