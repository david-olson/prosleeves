<?php global $team_object, $product_cat; ?>
<aside class="sidebar team">
	<h3>More Filters</h3>
	<div class="pad-full-small">
		<p>Viewing:</p> 
		<span class="label"><i class="fas fa-times-circle"></i> <?php echo $team_object->name; ?></span>
		<h4>Shop For</h4>
		<hr>
		<?php $args = array(
			'taxonomy' => 'shop_for',
			'hide_empty' => false,
		); 
		?>
		<?php $shop_for = get_terms($args); ?>
		<ul class="menu vertical">
			<?php foreach ($shop_for as $sf) : ?>
				<li><label for="shop_for_<?php echo $sf->slug; ?>"><input id="shop_for_<?php echo $sf->slug; ?>" type="checkbox" name="shop_for[]" value="<?php echo $sf->term_id; ?>"><?php echo $sf->name; ?></label></li>
			<?php endforeach; ?>
				
		</ul>
		<h4>Departments</h4>
		<hr>
		<?php
		$args = array(
			'taxonomy' => 'product_cat',
			'hide_empty' => false,
		);

		$departments = get_terms($args);

		?>
		<ul class="menu vertical">
			<?php foreach ($departments as $dept) : ?>
				<li><label for="department_<?php echo $dept->slug; ?>">
					<input type="checkbox" name="department[]" id="department_<?php echo $dept->slug; ?>" value="<?php echo $dept->term_id; ?>" <?php if ($product_cat == $dept->slug) : ?>checked<?php endif; ?>> <?php echo $dept->name; ?></label>
				</li>
			<?php endforeach;?>		
		</ul>
		<h4>Brands</h4>
		<hr>
		<?php 
			$args = array(
				'taxonomy' => 'brands',
				'hide_empty' => false
			);

			$brands = get_terms($args);
		?>

		<ul class="menu vertical">
			<?php foreach ($brands as $brand) : ?>
				<li><label for="brands_<?php echo $brand->slug; ?>"><input value="<?php echo $brand->term_id; ?>" id="brands_<?php echo $brand->slug; ?>" type="checkbox" name="brand[]"> <?php echo $brand->name; ?></label></li>
			<?php endforeach; ?>		
		</ul>
		<h4>Price Range</h4>
		<hr>
		<?php price_range_slider(); ?>
	</div>
</aside>