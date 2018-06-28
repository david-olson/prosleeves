<?php global $team_object, $product_cat, $wp, $league, $team, $product_cat; ?>
<?php 

	if (!empty($league) && !empty($team) && !empty($product_cat)) :
		$action_url =  get_home_url() . '/' . $league . '/' . $team . '/products/';
	else :
		$action_url = home_url($wp->request);
	endif;
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
	<form action="<?php echo $action_url ?>" method="GET" class="filter-form">
		<div class="pad-full-small">
			<?php if (isset($team_object)) : ?>		
				<p>Viewing:</p> 
				<span class="label"><a href="<?php echo get_home_url(); ?>/products"><i class="fas fa-times-circle"></i></a> <?php echo $team_object->name; ?></span>
			<?php endif; ?>
			<h4 class="slide-up slide-up-shop-for" data-toggle="shop-for">Shop For</h4>
			<hr>
			<?php 
			/*
			$args = array(
				'taxonomy' => 'shop_for',
				'hide_empty' => false,
			); 
			?>
			<?php $shop_for = get_terms($args); ?>
			<div class="shop-for-holder">
				<ul class="menu vertical shop-for">
					<?php foreach ($shop_for as $sf) : ?>
						<li><label for="shop_for_<?php echo $sf->slug; ?>"><input id="shop_for_<?php echo $sf->slug; ?>" <?php if (in_array($sf->term_id, $shop_for_terms)) : ?>checked<?php endif; ?> type="checkbox" name="taxonomy_shop_for[]" value="<?php echo $sf->term_id; ?>"><?php echo $sf->name; ?></label></li>
					<?php endforeach; ?>
				</ul>
				<a href="#" class="shop-for-view-more margin-bottom-small"><i class="plus-minus"></i> <span>View More</span></a>
			</div>
			<h4 class="slide-up slide-up-departments" data-toggle="departments">Departments</h4>
			<hr>
			*/ ?>
			<?php
			$args = array(
				'taxonomy' => 'product_cat',
				'hide_empty' => false,
				'exclude' => 15,
				'checked_on_top' => true
			);
			
			$departments = get_terms($args);
			$temp = array();
			foreach ($departments as $key => $dept) : 

				if (is_array($product_cat)) :
					foreach ($product_cat as $pc) :
						if ($dept->slug == $pc || $dept->term_id == $pc) :
							$temp[$key] = $dept;
							unset($departments[$key]);
							
						endif;
					endforeach;
				else :
					if ($dept->slug == $product_cat || $dept->term_id == $product_cat) :
						
						$temp[$key] = $dept;
						unset($departments[$key]);
						
					endif;
				endif;
				 $departments = $temp + $departments;
			endforeach;
			
			?>
			<div class="departments-holder">
				<ul class="menu vertical departments">
					<?php foreach ($departments as $dept) : ?>
						<li><label for="department_<?php echo $dept->slug; ?>">
							<input type="checkbox" name="taxonomy_product_cat[]" id="department_<?php echo $dept->slug; ?>" value="<?php echo $dept->term_id; ?>"
							 <?php if (is_array($product_cat)) : if (in_array($dept->slug, $product_cat) || in_array($dept->term_id, $product_cat)) : ?>checked<?php endif; ?><?php else : ?> <?php if ($product_cat == $dept->slug) : ?>checked<?php endif; endif; ?>> <?php echo $dept->name; ?></label>
						</li>
					<?php endforeach;?>	
					
				</ul>
				<a href="#" class="departments-view-more"><i class="plus-minus"></i>  <span>View More</span></a>
			</div>
			<h4 class="slide-up slide-up-brands" data-toggle="brands">Brands</h4>
			<hr>
			<?php 
				$args = array(
					'taxonomy' => 'brands',
					'hide_empty' => false
				);
			
				$brands = get_terms($args);
			?>
			
			<div class="brands-holder">
				<ul class="menu vertical brands">
					<?php foreach ($brands as $brand) : ?>
						<li><label for="brands_<?php echo $brand->slug; ?>"><input value="<?php echo $brand->term_id; ?>" id="brands_<?php echo $brand->slug; ?>" type="checkbox" <?php if (in_array($brand->term_id, $brand_terms)) : ?>checked<?php endif; ?> name="taxonomy_brand[]"> <?php echo $brand->name; ?></label></li>
					<?php endforeach; ?>		
				</ul>
				<a href="#" class="brands-view-more"><i class="plus-minus"></i>  <span>View More</span></a>
			</div>
			<h4>Price Range</h4>
			<hr>
			<?php price_range_slider(); ?>	
		</div>
		<?php if (isset($_GET['sort_by'])) : ?>
			<input type="hidden" name="sort_by" value="<?php echo $_GET['sort_by']; ?>">
		<?php endif; ?>
		<?php /* // This probably just needs to be $_GET['s'], possibly product type ?>
		<?php foreach ($_GET as $key => $value) : ?>
			<?php if ($key == 's' || $key == 'dgwt_wcas' || $key == 'post_type') : ?>
				<?php if (is_array($value)) : ?>
					<?php foreach ($value as $val) : ?>
						<input type="hidden" name="<?php echo $key; ?>[]" value="<?php echo $val; ?>">
					<?php endforeach; ?>
				<?php else : ?>
					<input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>">
				<?php endif; ?>
			<?php endif; ?>
		<?php endforeach; ?>
		<?php */ ?>
		<div class="grid-x">
			<div class="large-6 cell">
				<input type="submit" class="button expanded no-mb" value="Filter Products">
			</div>
			<div class="large-6 cell">
				<?php 
					$remove_params = explode('?', $_SERVER['REQUEST_URI'], 2);
				?>
				<a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $remove_params[0]; ?>" class="button expanded no-mb secondary">Clear Filters</a>
			</div>
		</div>
	</form>
</aside>