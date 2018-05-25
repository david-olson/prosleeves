<article class="white-bg margin-bottom-small pad-full-small">
	<div class="grid-x grid-padding-x align-middle">
	  <div class="medium-3 cell">
	    <div class="date">
	      <?php echo get_the_date(); ?>
	    </div>
	  </div>
	  <div class="medium-6 cell">
	    <h3 class="h5 no-mb"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	  </div>
	  <div class="medium-3 cell text-right">
	    <a href="<?php the_permalink(); ?>" class="button no-mb">Read More</a>
	  </div>
	</div>
</article> 