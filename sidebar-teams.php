<?php global $team_object, $product_cat, $wp; ?>
<?php 
	if (isset($_GET['taxonomy_product_cat']) && !empty($_GET['taxonomy_product_cat']) && empty($product_cat)) : 
		$product_cat = array();
		foreach($_GET['taxonomy_product_cat'] as $tax_pc) :
			array_push($product_cat, $tax_pc);
		endforeach;
	endif; 

	$shop_for_terms = array();
	if (isset($_GET['taxonomy_shop_for']) && !empty($_GET['taxonomy_shop_for'])) :
		
		foreach($_GET['taxonomy_shop_for'] as $tax_sf) :
			array_push($shop_for_terms, $tax_sf);
		endforeach;
	endif;

	$brand_terms = array();
	if (isset($_GET['taxonomy_brand']) && !empty($_GET['taxonomy_brand'])) : 
		foreach ($_GET['taxonomy_brand'] as $tax_brand) :
			array_push($brand_terms, $tax_brand);
		endforeach;
	endif;

?>
<aside class="sidebar team margin-bottom-small">
	<h3 class="filter-toggle"><span class="hide-for-large"><div class="hamburger hamburger--collapse"><span class="hamburger-box"><span class="hamburger-inner"></span></span></div> View </span>More Filters</h3>
	<form action="<?php echo home_url($wp->request); ?>" method="GET" class="filter-form">
		<div class="pad-full-small">
			<?php if (isset($team_object)) : ?>		
				<p>Viewing:</p> 
				<span class="label"><a href="<?php echo get_home_url(); ?>/products"><i class="fas fa-times-circle"></i></a> <?php echo $team_object->name; ?></span>
			<?php endif; ?>
			<h4>Shop For</h4>
			<hr>
			<?php $args = array(
				'taxonomy' => 'shop_for',
				'hide_empty' => false,
			); 
			?>
			<?php $shop_for = get_terms($args); ?>
			<ul class="menu vertical shop-for">
				<?php foreach ($shop_for as $sf) : ?>
					<li><label for="shop_for_<?php echo $sf->slug; ?>"><input id="shop_for_<?php echo $sf->slug; ?>" <?php if (in_array($sf->term_id, $shop_for_terms)) : ?>checked<?php endif; ?> type="checkbox" name="taxonomy_shop_for[]" value="<?php echo $sf->term_id; ?>"><?php echo $sf->name; ?></label></li>
				<?php endforeach; ?>
			</ul>
			<a href="#" class="shop-for-view-more margin-bottom-small"><i class="plus-minus"></i> <span>View More</span></a>
			<h4>Departments</h4>
			<hr>
			<?php
			$args = array(
				'taxonomy' => 'product_cat',
				'hide_empty' => false,
				'exclude' => 15
			);
			
			$departments = get_terms($args);
			
			?>
			<ul class="menu vertical departments">
				<?php foreach ($departments as $dept) : ?>
					<li><label for="department_<?php echo $dept->slug; ?>">
						<input type="checkbox" name="taxonomy_product_cat[]" id="department_<?php echo $dept->slug; ?>" value="<?php echo $dept->term_id; ?>"
						// <?php if (is_array($product_cat)) : if (in_array($dept->term_id, $product_cat)) : ?>checked<?php endif; ?><?php else : ?> <?php if ($product_cat == $dept->slug) : ?>checked<?php endif; endif; ?>> <?php echo $dept->name; ?></label>
					</li>
				<?php endforeach;?>	
				
			</ul>
			<a href="#" class="departments-view-more"><i class="plus-minus"></i>  <span>View More</span></a>
			<h4>Brands</h4>
			<hr>
			<?php 
				$args = array(
					'taxonomy' => 'brands',
					'hide_empty' => false
				);
			
				$brands = get_terms($args);
			?>
			
			<ul class="menu vertical brands">
				<?php foreach ($brands as $brand) : ?>
					<li><label for="brands_<?php echo $brand->slug; ?>"><input value="<?php echo $brand->term_id; ?>" id="brands_<?php echo $brand->slug; ?>" type="checkbox" <?php if (in_array($brand->term_id, $brand_terms)) : ?>checked<?php endif; ?> name="taxonomy_brand[]"> <?php echo $brand->name; ?></label></li>
				<?php endforeach; ?>		
			</ul>
			<a href="#" class="brands-view-more"><i class="plus-minus"></i>  <span>View More</span></a>
			<h4>Price Range</h4>
			<hr>
			<?php price_range_slider(); ?>	
		</div>
		<div class="grid-x">
			<div class="large-6 cell">
				<input type="submit" class="button expanded no-mb" value="Filter Products">
			</div>
			<div class="large-6 cell">
				<button class="button expanded secondary no-mb" type="button">Clear Filters</button>
			</div>
		</div>
	</form>
</aside>