<?php get_header(); ?>

<?php 

/**
 * Get Blog Posts and paginate
 * 
 */

$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

$args = array(
	'post_type' => 'post',
	'posts_per_page' => 12,
	'paged' => $paged,
);

$query = new WP_Query($args);

?>
<?php promo_banner(); ?>
<main>
	<section class="products">
		<div class="grid-container">
			<?php if ($query->have_posts()) : ?>		
				<?php while($query->have_posts()) : $query->the_post(); ?>
					<div class="grid-x grid-padding-x">
						<?php get_template_part('template-parts/blog-main'); ?>		
					</div>
				<?php endwhile; ?>
				<?php 
				$big = 999999999;
				
				$links = paginate_links(array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '?paged=%#%',
					'type' => 'list',
					'current' => max( 1, get_query_var('paged') ),
					'total' => $query->max_num_pages 
				));
				
				?>
				
				<div class="grid-x grid-padding-x">
					<div class="large-12 cell text-center">
						<ul class="pagination align-center pad-medium">
							<?php echo $links; ?>
						</ul>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php get_footer(); ?>