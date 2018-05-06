<?php get_header(); ?>

<?php $league = get_query_var( 'league' ); ?>
<?php $teams = get_terms(array(
	'taxonomy' => $league.'_teams',
	'hide_empty' => false
)); 
?>

<main id="content">
	<section class="products">
		<div class="grid-container">
			<div class="grid-x grid-margin-x large-up-6 align-center">
				<?php foreach ($teams as $team) : ?>
					<div class="cell white-bg margin-bottom-small text-center hover-up">
						<article class="pad-full-small">
							<?php $team_image = get_field('team_logo', $team); ?>
							<img src="<?php echo $team_image['sizes']['team_topbar_icon']; ?>" alt="<?php echo $team->name; ?> Logo">
						</article>
						<a class="button expanded no-mb" href="/<?php echo $league; ?>/<?php echo $team->slug; ?>"><?php echo $team->name; ?></a>
					</div>
				<?php endforeach; ?>		
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>