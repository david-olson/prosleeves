<article <?php post_class( 'white-bg pad-full-small margin-bottom-small' ); ?>>
	<div class="grid-x grid-padding-x">
		<div class="large-6 cell">
			<h2><?php the_title(); ?></h2>
			<p class="date"><?php echo get_the_date(); ?></p>
			<?php the_excerpt(); ?>
			<a href="<?php the_permalink(); ?>" class="read-more">Read More &gt;</a>
		</div>
		<div class="large-6 cell">
			<div class="grid-x grid-margin-x large-up-3 medium-up-3">
				<?php if (have_rows('top_ten')) : ?>
					<?php while (have_rows('top_ten')) : the_row(); ?>
						<div class="cell product-cell">
							<a href="<?php echo get_the_permalink( get_sub_field('product')->ID); ?>"><img src="<?php echo get_the_post_thumbnail_url( get_sub_field('product')->ID, 'post-thumbnail' ); ?>" alt="Product image for <?php echo get_the_title(get_sub_field('product')->ID); ?>"></a>
						</div>
					<?php endwhile; ?>
				<?php endif; ?>
			</div>
			<div class="text-center pad-small">
				<a href="<?php the_permalink(); ?>" class="button outline">View All</a>
			</div>
		</div>
	</div>
</article>