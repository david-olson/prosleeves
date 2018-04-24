<?php

/**
 * ProSleeves function for interacting with Team Taxonomies
 *
 * @package ProSleeves
 */

function get_team_product_categories() {
	$cats = get_terms(array(
		'taxonomy' => 'product_cat'
	));

	foreach ($cats as $cat) :
		?>
			<div class="cell">
				<article class="taxonomy taxonomy-product_cat taxonomy-<?php echo $cat->slug; ?>">
					<?php //get_first_product_image($cat->term_id); ?>
					<h2><?php echo $cat->name; ?></h2>
					<a href="/nfl/<?php echo get_queried_object()->slug; ?>/products/<?php echo $cat->slug; ?>" class="button expanded">Shop All <?php echo $cat->count; ?> <?php echo $cat->name; ?></a>
				</article>
			</div>
		<?php
	endforeach;
}

function get_first_product_image($term_id) {

}

function team_category_products($team, $product_cat_slug) {

	$args = array(
		'post_type' => 'product',
		'tax_query' => array(
			'relation' => 'AND',
			array(
				'taxonomy' => $team->taxonomy,
				'field' => 'term_id',
				'terms' => $team->term_id,
			),
			array(
				'taxonomy' => 'product_cat',
				'field' => 'slug',
				'terms' => $product_cat_slug
			)
		)
	);

	$products = new WP_Query($args);

	if ($products->have_posts()) :
		while ($products->have_posts()) : $products->the_post();
			get_template_part( 'template-parts/products/home-loop' );
		endwhile;
	else :
		echo 'None';
	endif; 
}