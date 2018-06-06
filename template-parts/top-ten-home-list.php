<article class="white-bg margin-bottom-small pad-full-small top-ten-list">
	<div class="grid-x grid-padding-x align-middle">
	  <div class="medium-3 cell">
	    <div class="date">
	      <span><?php echo get_the_date('m'); ?></span>
	      <span><?php echo get_the_date('d'); ?></span>
	    </div>
	  </div>
	  <div class="medium-6 cell">
	    <h3 class="h5 no-mb"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	  </div>
	  <div class="medium-3 cell text-right">
	    <a href="<?php the_permalink(); ?>" class="button no-mb"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-right.svg" alt=""></a>
	  </div>
	</div>
</article> 