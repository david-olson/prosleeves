<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ProSleeves
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<section class="products">
			<div class="grid-container"><?php if ( have_posts() ) : ?>
				
					<div class="pad-full-small white-bg margin-bottom-small">
						<div class="grid-x grid-padding-x">
							<div class="large-12 cell text-center"><header class="page-header">
									<?php
									the_archive_title( '<h1 class="page-title h4">', '</h1>' );
									the_archive_description( '<div class="archive-description">', '</div>' );
									?>
								</header><!-- .page-header --></div>
						</div>
					</div>
				
					<?php
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();
				
						/*
						 * Include the Post-Type-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
						 */
						get_template_part( 'template-parts/blog-main', get_post_type() );
				
					endwhile;
				
					the_posts_navigation();
				
				else :
				
					get_template_part( 'template-parts/content', 'none' );
				
				endif;
				?></div>
		</section>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
