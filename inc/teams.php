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
					<?php get_first_product_image($cat->term_id); ?>
					<h2><?php echo $cat->name; ?></h2>
					<a href="/nfl/<?php echo get_queried_object()->slug; ?>/<?php echo $cat->slug; ?>" class="button expanded">Shop All <?php echo $cat->count; ?> <?php echo $cat->name; ?></a>
				</article>
			</div>
		<?php
	endforeach;
}

function get_first_product_image($term_id) {

}