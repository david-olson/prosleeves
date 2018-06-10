<?php get_header(); ?>

<?php $league = get_query_var( 'league' ); ?>
<?php $teams = get_terms(array(
	'taxonomy' => $league.'_teams',
	'hide_empty' => false
)); 
?>
<?php promo_banner(); ?>
<main id="content">
	<section class="products">
		<div class="grid-container">
			<div class="grid-x grid-margin-x large-up-6 medium-up-3 align-center">
				<?php foreach ($teams as $team) : ?>
					<div class="cell white-bg margin-bottom-small text-center hover-up">
						<a href="<?php echo get_home_url(); ?>/<?php echo $league; ?>/<?php echo $team->slug; ?>">
							<article class="pad-full-small">
								<?php $team_image = get_field('team_logo', $team); ?>
								<img src="<?php echo $team_image['sizes']['team_topbar_icon']; ?>" alt="<?php echo $team->name; ?> Logo">
							</article>
							<button class="button expanded no-mb" type="button"><?php echo $team->name; ?></button>
						</a>
					</div>
				<?php endforeach; ?>		
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>