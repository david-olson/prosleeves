<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ProSleeves
 */

get_header();
?>

		<?php
		while ( have_posts() ) :
			the_post();

			?>
			<main id="content">
				<div class="grid-container">
					<div class="grid-x grid-padding-x align-center">
						<div class="large-10 cell">
							<div class="pad-medium"><?php the_content(); ?></div>
						</div>
					</div>
				</div>
			</main>
			<?php 

		endwhile; // End of the loop.
		?>
<?php
get_footer();
