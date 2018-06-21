<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ProSleeves
 */

get_header();
?>

<main id="main" class="site-main">

<?php
while ( have_posts() ) : the_post();

	?>

	<section class="intro blog-intro" style="background-image: url('<?php the_post_thumbnail_url( 'hero' ); ?>');">
		<div class="grid-container">
			<div class="grid-x grid-padding-x">
				<div class="large-12 cell">
					<?php
						$categories = get_the_terms(get_the_ID(), 'category');
						$category_list = array();
						foreach ($categories as $category) : 
							$category_list[] = $category->name;
						endforeach;
						$post_cats = join(', ', $category_list);
					?>
					<p class="date-category no-mb"><?php echo get_the_date(); ?> | <?php echo $post_cats; ?> </p>
					<h1><?php the_title(); ?></h1>
				</div>
			</div>
		</div>
	</section>
	<div class="pad-medium">
		<div class="grid-container">
			<div class="grid-x grid-padding-x">
				<div class="large-9 cell">
					<article class="<?php post_class(); ?>">
						<?php the_content(); ?>
						<?php if (get_field('top_ten_post')) : ?>
							<ol class="top-ten-products">
								<?php if (have_rows('top_ten')) : ?>
									<?php while (have_rows('top_ten')) : the_row(); ?>
										<li>
											<?php $product = get_sub_field('product'); ?>
											<a href="<?php echo get_the_permalink( $product->ID ); ?>"><img src="<?php echo get_the_post_thumbnail_url( $product->ID, 'large'); ?>" alt="Photo of <?php echo $product->post_title; ?>"></a>
											<p><small><?php echo $product->post_title; ?></small></p>
											<h3><a href="<?php echo get_the_permalink( $product->ID ); ?>"><?php the_sub_field('headline'); ?></a></h3>
											<p><?php the_sub_field('description'); ?></p>
											<a href="<?php echo get_the_permalink( $product->ID ); ?>" class="button">View the Product</a>
										</li>
									<?php endwhile; ?>
								<?php endif; ?>
							</ol>
						<?php endif; ?>
					</article>
				</div>
				<div class="large-3 cell">
					<?php get_sidebar(); ?>
				</div>
			</div>
			<?php the_post_navigation();?>
		</div>
	</div>
	<?php

	

	// If comments are open or we have at least one comment, load up the comment template.
	// if ( comments_open() || get_comments_number() ) :
	// 	comments_template();
	// endif;

endwhile; // End of the loop.
?>

</main><!-- #main -->

<?php
get_footer();
