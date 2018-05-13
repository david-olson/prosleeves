<div class="cell product margin-bottom-small">
	<?php $product = wc_get_product($post->ID); ?>
	<article <?php post_class(); ?>>
		<div class="pad-full-small">
			<h2 class="h5"><?php the_title(); ?></h2>
			<img src="<?php the_post_thumbnail_url( ); ?>" alt="">
			<p class="price">$<?php echo $product->get_regular_price(); ?></p>
		</div>
		<div class="grid-x">
			<div class="medium-6 cell">
				<a href="<?php the_permalink(); ?>" class="button expanded no-mb">More Details</a>
			</div>
			<div class="medium-6 cell">
				<a href="<?php //echo $product->get_product_url(); ?>" class="button secondary expanded no-mb">Buy Now</a>
			</div>
		</div>

	</article>
</div>