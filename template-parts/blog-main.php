<div class="large-12 cell">
	<article <?php post_class('blog-post-main white-bg margin-bottom-small'); ?> id="post_<?php the_ID(); ?>">
		<div class="grid-x grid-padding-x">
			<div class="large-4 cell">
				<?php if (get_field('top_ten_post')) : ?>
					<div class="pad-full-small">
						<div class="top-ten-slider">
							<?php if (have_rows('top_ten')) : ?>
								<?php while (have_rows('top_ten')) : the_row(); ?>
									<div class="slide text-center">
										<?php $product_id = get_sub_field('product'); ?>
										<img data-lazy="<?php echo get_the_post_thumbnail_url( $product_id->ID, 'top_ten_slide'); ?>" alt="Photo of <?php echo get_the_title($product_id->ID); ?>">
										<h3 class="h5"><?php the_sub_field('headline'); ?></h3>
									</div>
								<?php endwhile; ?>
							<?php endif; ?>
						</div>
					</div>
				<?php else : ?>
					<?php if (has_post_thumbnail()) : ?>
						<img src="<?php the_post_thumbnail_url('blog_main_featured'); ?>" alt="<?php the_title(); ?>">
					<?php else : ?>
						<div class="blog-placeholder-featured"></div>
					<?php endif; ?>
				<?php endif; ?>
			</div>
			<div class="large-8 cell">
				<div class="pad-full-small">
					<?php
						$categories = get_the_terms(get_the_ID(), 'category');
						$category_list = array();
						foreach ($categories as $category) : 
							$category_list[] = $category->name;
						endforeach;
						$post_cats = join(', ', $category_list);
					?>
					<p class="date-category no-mb"><?php echo get_the_date(); ?> | <?php echo $post_cats; ?> </p>
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php the_excerpt(); ?>
					<a href="<?php the_permalink(); ?>" class="button">Read More</a>
				</div>
			</div>
		</div>
	</article>
</div>