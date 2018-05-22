<?php

/**
 * ProSleeves function for interacting with Team Taxonomies
 *
 * @package ProSleeves
 */

function get_team_product_categories($team) {
	$args = array(
		'post_type' => 'product',
		'tax_query' => array(
			'relation' => 'AND',
			array(
				'taxonomy' => $team->taxonomy,
				'field' => 'slug',
				'terms' => $team->slug
			)
		),
		'posts_per_page' => -1,
	);
	$check_against = new WP_Query($args);
	global $post;
	if ($check_against->have_posts()) :
		$check = array();
		while ($check_against->have_posts()) : $check_against->the_post();
			$product_terms = get_the_terms($post->cat_ID, 'product_cat');
			foreach ($product_terms as $term_cat) :
				if (!in_array($term_cat, $check)) :
					array_push($check, $term_cat);
				endif;
			endforeach;
		endwhile;
	endif;

	// var_dump($check);

	$team = get_queried_object();
	$league = explode('_', $team->taxonomy);
	if (isset($check)) :
		foreach ($check as $cat) :
			$count_args = array(
				'post_type' => 'product',
				'tax_query' => array(
					'relation' => 'AND',
					array(
						'taxonomy' => $team->taxonomy,
						'field' => 'slug',
						'terms' => $team->slug
					),
					array(
						'taxonomy' => 'product_cat',
						'field' => 'slug',
						'terms' => $cat->slug
					)
				)
			);
			$count_query = query_posts($count_args);
			global $wp_query;
			?>
				<div class="cell">
					<article class="taxonomy taxonomy-product_cat taxonomy-<?php echo $cat->slug; ?> text-center">
						<?php get_first_product_image($cat->slug, $team); ?>
						<h2><?php echo $cat->name; ?></h2>
						<a href="<?php bloginfo( 'url' ) ?>/<?php echo $league[0]; ?>/<?php echo $team->slug; ?>/products/<?php echo $cat->slug; ?>" class="<?php check_background_color(get_field('team_primary_color', $team)); ?> button expanded" style="background-color: <?php the_field('team_primary_color', $team); ?>">Shop All <?php echo $wp_query->found_posts; ?> <?php echo $cat->name; ?></a>
					</article>
				</div>
			<?php
		endforeach;
	else :
		echo '<div class="cell"><h3>No Products Found.</h3></div>';
	endif;
	wp_reset_postdata();
}

function get_first_product_image($product_cat_slug, $team) {
	$args = array(
		'post_type' => 'product',
		'tax_query' => array(
			'relation' => 'AND',
			array(
				'taxonomy' => $team->taxonomy,
				'field' => 'slug',
				'terms' => $team->slug
			),
			array(
				'taxonomy' => 'product_cat',
				'field' => 'slug',
				'terms' => $product_cat_slug,
			)
		),
		'posts_per_page' => 1,
	);

	$first_post = new WP_Query($args);

	if ($first_post->have_posts()) :
		while ($first_post->have_posts()) : $first_post->the_post();
			if (has_post_thumbnail()) :
			?>
				<img src="<?php the_post_thumbnail_url(); ?>" alt="Picture of a <?php echo $team->name; ?> clothing item.">
			<?
			else :
				$team_image = get_field('team_logo', $team);
				?>
				<img src="<?php echo $team_image['sizes']['team_topbar_icon']; ?>" alt="<?php echo $team->name; ?> Logo">
				<?php
			endif;
		endwhile;
	endif;
}

function team_category_products($team, $product_cat_slug = array(), $additional_query_vars = array()) {

	$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

	// var_dump($paged);
	// die();

	$args = array(
		'post_type' => 'product',
		'tax_query' => array(
			'relation' => 'AND',
			array(
				'taxonomy' => $team->taxonomy,
				'field' => 'term_id',
				'terms' => $team->term_id,
			),
		),
		'paged' => $paged,
		'posts_per_page' => 12
	);
	if (!empty($product_cat_slug)) : 
		$category_query = array(
			'taxonomy' => 'product_cat',
			'field' => 'slug', 
			'terms' => $product_cat_slug,
		);
		array_push($args['tax_query'], $category_query);
	endif;

	if (!empty($additional_query_vars)) :
		foreach ($additional_query_vars as $add_q) :
			// var_dump($value);
			array_push($args['tax_query'], $add_q);
		endforeach;
	endif;


	$products_query = new WP_Query($args);

	if ($products_query->have_posts()) : ?>

		<div class="grid-x grid-margin-x large-up-3">
			<?php
			while ($products_query->have_posts()) : $products_query->the_post();
				get_template_part( 'template-parts/products/home-loop' );
			endwhile;
			?>		
		</div>
		<div class="grid-x grid-padding-x">
			<div class="large-12 cell text-center">
				<ul class="pagination align-center">
					<?php
					$big = 999999999;

					echo paginate_links( array(
						'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format' => '?paged=%#%',
						'current' => max( 1, get_query_var('paged') ),
						'total' => $products_query->max_num_pages,
						'type' => 'list'
					) );
					?>
				</ul>
			</div>
		</div>
		<?php
	else :
		echo '<h2>No products were found matching your filters.</h2>';
	endif; 
	wp_reset_postdata();
}

function team_category_pagination() {
	global $products_query;

	$big = 999999999;

	echo paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $products_query->max_num_pages,
		'type' => 'list'
	) );
}

function team_topbar($term) {
	?>
		<section class="intro team-color-intro <?php check_background_color(get_field('team_primary_color', $term)); ?>" style="background-color: <?php the_field('team_primary_color', $term); ?>">
			<div class="grid-container">
				<div class="grid-x grid-padding-x">
					<div class="large-12 cell">
						<h1><?php echo $term->name; ?></h1>
					</div>
				</div>
			</div>
			<?php $team_image = get_field('team_logo', $term); ?>
			<img src="<?php echo $team_image['sizes']['team_topbar_icon']; ?>" class="team-logo" alt="">
		</section>
	<?php
}