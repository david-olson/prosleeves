<?php
	$league = get_query_var( 'league' );
	$team = get_query_var('team');
	

	$team_object = get_term_by( 'slug', $team, $league.'_teams' );

	$additional_queries = array();

	if (isset($_GET['taxonomy_product_cat']) && !empty($_GET['taxonomy_product_cat'])) :
		$pc_terms = array();
		foreach ($_GET['taxonomy_product_cat'] as $tax_pc) :
			array_push($pc_terms, $tax_pc);
		endforeach;
		$tax_product_cat_query = array(
			'taxonomy' => 'product_cat',
			'field' => 'id',
			'terms' => $pc_terms
		); 
		array_push($additional_queries, $tax_product_cat_query);
	else :
		$product_cat = array();
		$product_cat[] = get_query_var('product_cat');
	endif; 
	
	if (isset($_GET['taxonomy_shop_for']) && !empty($_GET['taxonomy_shop_for'])) : 
		$sf_terms = array();
		foreach ($_GET['taxonomy_shop_for'] as $tax_sf) :
			array_push($sf_terms, $tax_sf);
		endforeach;
		$tax_shop_for_query = array(
			'taxonomy' => 'shop_for',
			'field' => 'id',
			'terms' => $sf_terms
		);
		array_push($additional_queries, $tax_shop_for_query);
	endif;

	if (isset($_GET['taxonomy_brand']) && !empty($_GET['taxonomy_brand'])) : 
		$brand_terms = array();
		foreach ($_GET['taxonomy_brand'] as $tax_brand) : 
			array_push($brand_terms, $tax_brand);
		endforeach;
		$tax_brand_query = array(
			'taxonomy' => 'shop_for',
			'field' => 'id',
			'terms' => $brand_terms
		);
		array_push($additional_queries, $tax_brand_query);
	endif;

?>
<?php get_header(); ?>
<?php team_topbar($team_object); ?>
<?php promo_banner(); ?>
<section class="products">
	<div class="grid-container">
		<div class="grid-x grid-padding-x">
			<div class="large-12 cell">
				<p class="breadcrumbs"><a href="<?php echo get_home_url(); ?>/<?php echo $league; ?>"><?php echo strtoupper($league); ?></a> / <a href="<?php echo get_home_url(); ?>/<?php echo $league; ?>/<?php echo $team; ?>"><?php echo $team_object->name; ?></a></p>
			</div>
		</div>
		<div class="grid-x grid-margin-x">
			<div class="large-3 cell">
				<?php get_sidebar('teams'); ?>
			</div>
			<div class="large-9 cell">
				<main>
					<?php 

					$paged = get_query_var( 'paged' );

					?>
					<?php team_category_products($team_object, array(), $additional_queries); ?>		
				</main>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>