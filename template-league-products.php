<?php
	$league = get_query_var( 'league' );
	$team = get_query_var('team');
	$product_cat = array();
	$product_cat[] = get_query_var('product_cat');

	if (isset($_GET['order_by'])) :
		$order_by = $_GET['order_by'];
	endif;

	$team_object = get_term_by( 'slug', $team, $league.'_teams' );

	$additional_queries = array();

	$meta_queries = array(
		'relation' => 'AND'
	);

	if (isset($_GET['min_price']) && !empty($_GET['min_price'])) :
		$min_price_query = array(
			'key' => '_price',
			'value' => $_GET['min_price'],
			'compare' => '>=',
			'type' => 'NUMERIC'
		);
		array_push($meta_queries, $min_price_query);
	endif;

	if (isset($_GET['max_price']) && !empty($_GET['max_price'])) :
		$max_price_query = array(
			'key' => '_price',
			'value' => $_GET['max_price'],
			'compare' => '<=',
			'type' => 'NUMERIC'
		);
		array_push($meta_queries, $max_price_query);
	endif;

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
			'taxonomy' => 'brands',
			'field' => 'id',
			'terms' => $brand_terms
		);
		array_push($additional_queries, $tax_brand_query);
	endif;

	if (!empty($order_by)) :
		$order = explode('_', $order_by);
	else :
		$order = array();
		$order[] = 'date';
		$order[] = 'desc';
	endif;

	
?>
<?php get_header(); ?>
<?php team_topbar($team_object); ?>
<?php promo_banner(); ?>
<?php $category_overview = get_term_by('slug', $product_cat[0], 'product_cat'); ?>
<section class="products">
	<div class="grid-container">
		<div class="grid-x grid-padding-x align-middle">
			<div class="large-6 medium-6 cell">
				<p class="breadcrumbs no-mb"><a  href="<?php echo get_home_url(); ?>/<?php echo $league; ?>"><?php echo strtoupper($league); ?></a> / <a href="<?php echo get_home_url(); ?>/<?php echo $league; ?>/<?php echo $team; ?>"><?php echo $team_object->name; ?></a> / <a href="<?php echo get_home_url(); ?>/<?php echo $league; ?>/<?php echo $team; ?>/products/<?php echo $category_overview->slug; ?>"><?php echo $team_object->name; ?> <?php echo $category_overview->name; ?></a></p>
			</div>
			<div class="large-6 medium-6 cell">
				<form action="<?php echo home_url($wp->request); ?>" method="GET" class="pad-small">
						<div class="grid-x grid-padding-x align-right align-middle">
							<div class="medium-shrink cell">
								<h4 class="no-mb h5">Sort By:</h4>
							</div>
							<div class="medium-shrink cell">
								<select name="order_by" id="order_by" class="no-mb">
									<option value="date_desc" <?php if (isset($_GET['order_by']) && $_GET['order_by'] == 'date_desc') : ?>selected<?php endif; ?>>Date Added: Newest First</option>
									<option value="date_asc" <?php if (isset($_GET['order_by']) && $_GET['order_by'] == 'date_asc') : ?>selected<?php endif; ?>>Date Added: Oldest First</option>
									<option value="price_asc" <?php if (isset($_GET['order_by']) && $_GET['order_by'] == 'price_asc') : ?>selected<?php endif; ?>>Price: Low to High</option>
									<option value="price_desc" <?php if (isset($_GET['order_by']) && $_GET['order_by'] == 'price_desc') : ?>selected<?php endif; ?>>Price: High to Low</option>
									<option value="title_asc" <?php if (isset($_GET['order_by']) && $_GET['order_by'] == 'title_asc') : ?>selected<?php endif; ?>>Name: A to Z</option>
									<option value="title_desc" <?php if (isset($_GET['order_by']) && $_GET['order_by'] == 'title_desc') : ?>selected<?php endif; ?>>Name: Z to A</option>
								</select>
							</div>
							<?php foreach ($_GET as $key => $value) : ?>
								<?php if ($key !== 'order_by') : ?>
									<?php if (is_array($value)) : ?>
										<?php foreach ($value as $val) : ?>
											<input type="hidden" name="<?php echo $key; ?>[]" value="<?php echo $val; ?>">
										<?php endforeach; ?>
									<?php else : ?>
										<input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>">
									<?php endif; ?>
								<?php endif; ?>
							<?php endforeach; ?>
							<div class="medium-shrink cell">
								<input type="submit" value="Filter" class="button no-mb">
							</div>
						</div>
					</form>
			</div>
		</div>
		<div class="grid-x grid-margin-x">
			<div class="large-3 cell">
				<?php get_sidebar('teams'); ?>
			</div>
			<div class="large-9 cell">
				<main>
					<?php $paged = get_query_var( 'paged' ); ?>
					
					<?php team_category_products($team_object, $product_cat, $additional_queries, $meta_queries, $order); ?>		
				</main>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>