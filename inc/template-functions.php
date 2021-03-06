<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package ProSleeves
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function prosleeves_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'prosleeves_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function prosleeves_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'prosleeves_pingback_header' );


if (function_exists('acf_add_options_page')) {
	$args = array(
		'page_title' => 'Mega Menu',
		'menu_title' => 'Mega Menu',
		'menu_slug' => 'mega-menu',
		'capability' => 'edit_posts',
		'position' => 4,
		'icon_url' => 'dashicons-editor-insertmore'
	);
	acf_add_options_page($args);

  $args_promo_banner = array(
    'page_title' => 'Promo Banner',
    'menu_title' => 'Promo Banner',
    'menu_slug' => 'promo-banner',
    'capability' => 'edit_posts',
    'position' => 4,
    'icon_url' => 'dashicons-pressthis'
  );

  acf_add_options_page($args_promo_banner);

  $deal_banner_area_args = array(
    'page_title' => 'Deal Banner',
    'menu_title' => 'Deal Banner',
    'menu_slug' => 'deal-banner',
    'capability' => 'edit_posts',
    'position' => 4,
    'icon_url' => 'dashicons-align-right'
  );

  acf_add_options_page($deal_banner_area_args);

  $hero_slider_args = array(
    'page_title' => 'Hero Slider',
    'menu_title' => 'Hero Slider',
    'menu_slug' => 'hero-slider',
    'capability' => 'edit_posts',
    'position' => 4,
    'icon_url' => 'dashicons-slides'
  );

  acf_add_options_page($hero_slider_args);

  $featured_products_menu_args = array(
    'page_title' => 'Featured Products',
    'menu_title' => 'Featured Products',
    'menu_slug' => 'featured-products',
    'capability' => 'edit_posts',
    'position' => 5,
    'icon_url' => 'dashicons-cart'
  );

  acf_add_options_page($featured_products_menu_args);

}

add_image_size( 'team_menu_icon', 20, 20, false );
add_image_size('team_topbar_icon', 400, 400, false);
add_image_size('product_loop_image', 300, 300, false);
add_image_size('hero', 1400, 400, true);

function HTMLToRGB($htmlCode)
  {
    if($htmlCode[0] == '#')
      $htmlCode = substr($htmlCode, 1);

    if (strlen($htmlCode) == 3)
    {
      $htmlCode = $htmlCode[0] . $htmlCode[0] . $htmlCode[1] . $htmlCode[1] . $htmlCode[2] . $htmlCode[2];
    }

    $r = hexdec($htmlCode[0] . $htmlCode[1]);
    $g = hexdec($htmlCode[2] . $htmlCode[3]);
    $b = hexdec($htmlCode[4] . $htmlCode[5]);

    return $b + ($g << 0x8) + ($r << 0x10);
  }

function RGBToHSL($RGB) {
    $r = 0xFF & ($RGB >> 0x10);
    $g = 0xFF & ($RGB >> 0x8);
    $b = 0xFF & $RGB;

    $r = ((float)$r) / 255.0;
    $g = ((float)$g) / 255.0;
    $b = ((float)$b) / 255.0;

    $maxC = max($r, $g, $b);
    $minC = min($r, $g, $b);

    $l = ($maxC + $minC) / 2.0;

    if($maxC == $minC)
    {
      $s = 0;
      $h = 0;
    }
    else
    {
      if($l < .5)
      {
        $s = ($maxC - $minC) / ($maxC + $minC);
      }
      else
      {
        $s = ($maxC - $minC) / (2.0 - $maxC - $minC);
      }
      if($r == $maxC)
        $h = ($g - $b) / ($maxC - $minC);
      if($g == $maxC)
        $h = 2.0 + ($b - $r) / ($maxC - $minC);
      if($b == $maxC)
        $h = 4.0 + ($r - $g) / ($maxC - $minC);

      $h = $h / 6.0; 
    }

    $h = (int)round(255.0 * $h);
    $s = (int)round(255.0 * $s);
    $l = (int)round(255.0 * $l);

    return (object) Array('hue' => $h, 'saturation' => $s, 'lightness' => $l);
  }

  function check_background_color($hex) {
  	$rgb = HTMLToRGB($hex);
  	$hsl = RGBToHSL($rgb);

  	if ($hsl->lightness > 200) {
  		echo 'light';
  	} else {
  		echo 'dark';
  	}
  }

/**
 * Add permastructs for interpreting products and taxonomy names
 */

function custom_query_vars_filter($vars) {
  $vars[] = 'team';
  $vars[] .= 'league';
  return $vars;
}

add_filter('query_vars', 'custom_query_vars_filter');

add_action('init', 'permalinks_init');

function permalinks_init() {
  $perma_struct = get_option( 'permalink_structure' );

  add_rewrite_rule('^(.*)/(.*)/products/(.*)/page/(.*)?$', 'index.php?league=$matches[1]&team=$matches[2]&product_cat=$matches[3]&paged=$matches[4]', 'top');
  add_rewrite_rule('^(.*)/(.*)/products/page/(.*)', 'index.php?league=$matches[1]&team=$matches[2]&paged=$matches[3]', 'top');
  add_rewrite_rule('^(.*)/(.*)/products/(.*)?$', 'index.php?league=$matches[1]&team=$matches[2]&product_cat=$matches[3]', 'top');

  add_rewrite_rule('^(.*)/(.*)/products', 'index.php?league=$matches[1]&team=$matches[2]', 'top');
  
  
  
  

  $mega_menu_leagues = get_field('menu_items', 'options');
  foreach ($mega_menu_leagues as $mm_l) :
    $tax = get_taxonomy($mm_l['item']);
    $slug = explode('_', $tax->name);
    if ($slug[0] == 'college') :
      add_rewrite_rule("^(ncaa)?$", 'index.php?league=college', 'top');
    else :
      add_rewrite_rule("^($slug[0])?$", 'index.php?league=$matches[1]', 'top');
    endif;
  endforeach;

}

function rewrite_team_templates() {

  if (is_tax('nfl_teams') || is_tax('college_teams') || is_tax('nhl_teams') || is_tax('nba_teams') || is_tax('mlb_teams')) :
    add_filter('template_include', function() {
      return get_template_directory() . '/taxonomy-nfl_teams.php';
    });
  endif;

  if (get_query_var('league')) :
    add_filter('template_include', function() {
      return get_template_directory() . '/template-league-overview.php';
    });
  endif;
  if (get_query_var('league') && get_query_var('team')) :
    add_filter('template_include', function() {
      return get_template_directory() . '/template-team-products.php';
    });
  endif;
  if (get_query_var('league') && get_query_var('team') && get_query_var('product_cat')) :
    add_filter('template_include', function() {
      return get_template_directory() . '/template-league-products.php';
    });
  endif;
  


}

add_action('template_redirect', 'rewrite_team_templates');

function price_range_slider() {

    $max_price = get_posts( array(
        'posts_per_page' => 1,
        'meta_key' => '_price',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'post_type' => 'product'
    ) );

    $product = wc_get_product($max_price[0]->ID); 

    $max = $product->get_regular_price();

    wp_reset_postdata();

    $max = round($max, 0, PHP_ROUND_HALF_UP);

  if (isset($_GET['max_price']) && !empty($_GET['max_price'])) :
      $handle_max = $_GET['max_price'];
  else :
    $handle_max = $max;
    endif;

    if (isset($_GET['min_price']) && !empty($_GET['min_price'])) :
      $handle_min = $_GET['min_price'];
    else :
      $handle_min = 0;
    endif;



  ?>
    <div class="slider" data-start="0" data-slider data-initial-start="<?php echo $handle_min; ?>" data-initial-end="<?php echo $handle_max; ?>" data-end="<?php echo $max; ?>">
      <span class="slider-handle" data-slider-handle role="slider" tabindex="1" aria-controls="min_price"></span>
      <span class="slider-fill" data-slider-fill></span>
      <span class="slider-handle" data-slider-handle role="slider" tabindex="1" aria-controls="max_price"></span>
    </div>
    <div class="grid-x text-left">
      <div class="medium-6 cell">
        <span class="currency">$</span> <input class="price-input" type="number" name="min_price" id="min_price">
      </div>
      <div class="medium-6 cell text-right">
        <span class="currency">$</span> <input type="number" name="max_price" class="price-input" id="max_price">
      </div>
    </div>
  <?php
} 

/**
 * Add Price Alerts to My Account Area
 * 
 */

function prosleeves_account_menu_items($items) {
  $new = array('price-alerts' => __('Price Alerts', 'price-alerts'));
  $items = array_slice($items, 0, 3, true) + $new + array_slice($items, 3, count($items), true);
  // $items['price-alerts'] = __('Price Alerts', 'price-alerts');

  return $items;
}

add_filter('woocommerce_account_menu_items', 'prosleeves_account_menu_items', 10, 1);

/**
 * Add Price Alerts End Point
 */

function prosleeves_add_my_account_endpoint() {
  add_rewrite_endpoint( 'price-alerts', EP_PAGES );
}

add_action('init', 'prosleeves_add_my_account_endpoint');

/**
 * Add Price Alerts Content
 */

function prosleeves_price_alert_content() {
  global $wpdb;

  $user = wp_get_current_user();

  $price_alerts = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}cegg_price_alert WHERE email = '{$user->user_email}'");
  $_pf = new WC_Product_Factory();
  ob_start();

  ?>
  
  
  <?php if (count($price_alerts) > 0) : ?>
    <div class="white-bg shadow red-bd-top pad-full-small">
      <h1 class="h5">Here are the price alerts you have set up.</h1>
      <table class="pa-table unstriped">
        <thead>
          <tr>
            <th>Product</th>
            <th class="text-right">Desired Price</th>
            <th class="text-right">Alert Created</th>
            <th class="text-right">Alert Sent On</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($price_alerts as $alert) : ?>
            <?php $product = $_pf->get_product($alert->post_id); ?>
            <tr>
              <td><a href="<?php echo get_home_url(); ?>/products/<?php echo $product->get_slug(); ?>"><?php echo $product->get_name(); ?></a></td>
              <td class="text-right">$<?php echo $alert->price; ?></td>
              <td class="text-right"><?php echo date('l, M j, Y', strtotime($alert->create_date)); ?></td>
              <td class="text-right"><?php if ($alert->complet_date > 0) : ?><?php echo date('l, M j, Y', strtotime($alert->complet_date)); ?><?php else : ?>Not Sent Yet<?php endif; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else : ?>
    <div class="white-bg shadow red-bd-left pad-full-small">
      <p>You have not set up any price alerts yet.</p>
      </div>
  <?php endif; ?>

  <?php

  echo ob_get_clean();

}

add_action('woocommerce_account_price-alerts_endpoint', 'prosleeves_price_alert_content');

/**
 * Favorite teams
 */

add_action('woocommerce_edit_account_form', 'add_favorite_teams_to_form');

function add_favorite_teams_to_form() {
  $user_id = get_current_user_id();
  $fav_nfl = get_field('favorite_nfl_team', 'user_' . $user_id);
  $fav_ncaa = get_field('favorite_ncaa_team', 'user_' . $user_id);
  $fav_nhl = get_field('favorite_nhl_team', 'user_' . $user_id);
  $fav_nba = get_field('favorite_nba_team', 'user_' . $user_id);
  $fav_mlb = get_field('favorite_mlb_team', 'user_' . $user_id);

  $all_nfl = get_terms(array(
    'taxonomy' => 'nfl_teams',
    'hide_empty' => false
  ));
  $all_ncaa = get_terms(array(
    'taxonomy' => 'college_teams',
    'hide_empty' => false
  ));
  $all_nhl = get_terms(array(
    'taxonomy' => 'nhl_teams',
    'hide_empty' => false
  ));
  $all_nba = get_terms(array(
    'taxonomy' => 'nba_teams',
    'hide_empty' => false
  ));
  $all_mlb = get_terms(array(
    'taxonomy' => 'mlb_teams',
    'hide_empty' => false
  ));
  ?>
    
    <fieldset class="margin-bottom-small">
      <legend>Favorite Teams</legend>
      <div class="grid-x grid-padding-x">
        <div class="large-6 cell">
          <label for="fav_nfl">Favorite NFL Team
            <select name="fav_nfl" id="fav_nfl">
              <option value="0">Select a Team</option>
              <?php foreach ($all_nfl as $team) : ?>
                <option value="<?php echo $team->name; ?>" <?php if ($team->name == $fav_nfl) : ?>selected<?php endif; ?> ><?php echo $team->name; ?></option>
              <?php endforeach; ?>
            </select></label>
        </div>
        <?php if (!empty($all_ncaa)) : ?>
          <div class="large-6 cell">
            <label for="fav_ncaa">Favorite NCAA Team
              <select name="fav_ncaa" id="fav_ncaa">
                <option value="0">Select a Team</option>
                <?php foreach ($all_ncaa as $team) : ?>
                  <option value="<?php echo $team->name; ?>" <?php if ($team->name == $fav_ncaa) : ?>selected<?php endif; ?>><?php echo $team->name; ?></option>
                <?php endforeach; ?>
              </select>
            </label>
          </div>
        <?php endif; ?>
        <div class="large-6 cell">
          <label for="fav_nhl">Favorite NHL Team
            <select name="fav_nhl" id="fav_nhl">
              <option value="0">Select a Team</option>
              <?php foreach ($all_nhl as $team) : ?>
                <option value="<?php echo $team->name; ?>" <?php if ($team->name == $fav_nhl) : ?>selected<?php endif; ?>><?php echo $team->name; ?></option>
              <?php endforeach; ?>
            </select></label>
        </div>
        <div class="large-6 cell">
          <label for="fav_nba">Favorite NBA Team
            <select name="fav_nba" id="fav_nba">
              <option value="0">Select a Team</option>
              <?php foreach ($all_nba as $team) : ?>
                <option value="<?php echo $team->name; ?>" <?php if ($team->name == $fav_nba) : ?>selected<?php endif; ?>><?php echo $team->name; ?></option>
              <?php endforeach; ?>
            </select></label>
        </div>
        <div class="large-6 cell">
          <label for="fav_mlb">Favorite MLB Team
            <select name="fav_mlb" id="fav_mlb">
              <option value="0">Select a Team</option>
              <?php foreach ($all_mlb as $team) : ?>
                <option value="<?php echo $team->name; ?>" <?php if ($team->name == $fav_mlb) : ?>selected<?php endif; ?>><?php echo $team->name; ?></option>
              <?php endforeach; ?>
            </select></label>
        </div>
      </div>
    </fieldset>

  <?php

}

add_action('woocommerce_save_account_details', 'save_favorite_teams');

function save_favorite_teams($user_id) {
  if (isset($_POST['fav_nfl'])) : 
    $fav_nfl = htmlentities($_POST['fav_nfl']);
    update_field('favorite_nfl_team', $fav_nfl, 'user_'.$user_id);
  endif;
  if (isset($_POST['fav_ncaa'])) : 
    $fav_ncaa = htmlentities($_POST['fav_ncaa']);
    update_field('favorite_ncaa_team', $fav_ncaa, 'user_'.$user_id);
  endif;
  if (isset($_POST['fav_nhl'])) : 
    $fav_nhl = htmlentities($_POST['fav_nhl']);
    update_field('favorite_nhl_team', $fav_nhl, 'user_'.$user_id);
  endif;
  if (isset($_POST['fav_nba'])) : 
    $fav_nba = htmlentities($_POST['fav_nba']);
    update_field('favorite_nba_team', $fav_nba, 'user_'.$user_id);
  endif;
  if (isset($_POST['fav_mlb'])) : 
    $fav_mlb = htmlentities($_POST['fav_mlb']);
    update_field('favorite_mlb_team', $fav_mlb, 'user_'.$user_id);
  endif;

}

/**
 * Display Promo Banner
 *
 */

function promo_banner() {
  $message = get_field('promo_message', 'options');
  $expiration_date = get_field('promo_end_date', 'options');

  ?>
  <section class="promo-banner" id="promo_bar">
    <h2 class="h5"><?php echo $message; ?><?php if (!empty($expiration_date)) : ?> | Ends <?php echo $expiration_date; ?><?php endif; ?></h2>
  </section>
  <?php
}

/**
 * Ensure cart contents update on ajax add to cart
 * 
 */

function header_add_to_cart($fragments) {
  ob_start();

  $count = WC()->cart->cart_contents_count;

  ?>

  <a href="<?php echo get_home_url(); ?>/cart" class="cart"><i class="fas fa-shopping-cart fa-lg"></i>&nbsp; &nbsp;Cart (<?php echo $count; ?>)</a>
  
  <?php

  $fragments['a.cart'] = ob_get_clean();

  return $fragments;

}

add_filter('woocommerce_add_to_cart_fragments', 'header_add_to_cart');

/**
 * Footer top ten preview
 */

function the_top_ten_preview() {
  $args = array(
    'post_type' => 'post',
    'posts_per_page' => 3,
    'meta_query' => array(
      array(
        'key' => 'top_ten_post',
        'compare' => '=',
        'value' => '1'
      ),
    ),
  );

  $query = new WP_Query($args);

  if ($query->have_posts()) :
    ob_start();

    ?>

    <h3 class="text-center top-ten-title">Recent Top Ten Posts</h3>
    
    <?php

    while ($query->have_posts()) : $query->the_post();

      ?>
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
      <?php

    endwhile; 
    ?>
      <div class="text-center">
        <a href="<?php echo get_home_url(); ?>/blog" class="text-center">View More &gt;</a>
      </div>
    <?php

  endif;

  $results = ob_get_clean();

  echo $results;
}

/**
 * Top Ten Main Post for homepage footer
 * 
 */

function top_ten_main_post() {
  $args = array(
    'post_type' => 'post',
    'posts_per_page' => 1,
    'meta_query' => array(
      array(
        'key' => 'top_ten_post',
        'compare' => '=',
        'value' => '1'
      )
    )
  );

  $query = new WP_Query($args);

  if ($query->have_posts()) :
    ob_start();

    while ($query->have_posts()) : $query->the_post();
      get_template_part('template-parts/top-ten-home');
    endwhile;

    $results = ob_get_clean();
  endif;
  echo $results;

}

/**
 * Top Ten List for homepage footer
 * 
 */

function top_ten_home_list() {
  $args = array(
    'post_type' => 'post',
    'posts_per_page' => 4,
    'meta_query' => array(
      array(
        'key' => 'top_ten_post',
        'compare' => '=',
        'value' => '1'
      )
    ),
    'offset' => 1
  );
  $query = new WP_Query($args);

  if ($query->have_posts()) :
    ob_start();

    while ($query->have_posts()) : $query->the_post();
      get_template_part('template-parts/top-ten-home-list');
    endwhile;

    $results = ob_get_clean();
  endif;
  echo $results;
}

/**
 * Filtering for WooCommerce Template
 * 
 */

function prosleeves_get_filtering($q) {
  if (isset($_GET['taxonomy_product_cat']) || isset($_GET['taxonomy_shop_for']) || isset($_GET['taxonomy_brand']) || isset($_GET['order_by'])) :
    $tax_query = array(
      'relation' => 'AND'
    );
    if (isset($_GET['taxonomy_shop_for'])) : 
      $tax_sf = array(
        'taxonomy' => 'shop_for',
        'field' => 'id',
        'terms' => $_GET['taxonomy_shop_for']
      );
      array_push($tax_query, $tax_sf);
    endif;

    if (isset($_GET['taxonomy_product_cat'])) :
      $tax_pc = array(
        'taxonomy' => 'product_cat',
        'field' => 'id',
        'terms' => $_GET['taxonomy_product_cat'],
      );
      array_push($tax_query, $tax_pc);
    endif;

    if (isset($_GET['taxonomy_brand'])) : 
      $tax_brand = array(
        'taxonomy' => 'brands',
        'field' => 'id',
        'terms' => $_GET['taxonomy_brand'],
      );
      array_push($tax_query, $tax_brand);
    endif;
    $q->set('tax_query', $tax_query);
    if (isset($_GET['order_by'])) :
      $sort = explode('_', $_GET['order_by']);

      if ($sort[0] == 'title' || $sort[0] == 'date') :
        $q->set('orderby', $sort[0]);
        $q->set('order', $sort[1]);
      elseif ($sort[0] == 'price') :
        $q->set('orderby', 'meta_value_num');
        $q->set('order', $sort[1]);
        $q->set('meta_key', '_price'); 
      endif;
    endif;
  endif;
  
}

add_action('woocommerce_product_query', 'prosleeves_get_filtering');

/**
 * Get homepage hero area
 * 
 */

function the_homepage_hero() {
  $layout = get_field('layout', 'options');

  if ($layout == 1) :
    $products = get_field('one_product', 'options');
    ?>
    <div class="hero-area">
      <div class="grid-x align-middle hero-cells">
        <?php if ($products['background_color_or_image'] == 'image') : ?>
          <div class="medium-12 cell <?php echo $products['overlay_color']; ?> overlay" style="background-image: url('<?php echo $products['background_image']['sizes']['large'] ;?>');">
            <a href="<?php echo $products['button_link']; ?>"><div class="grid-x grid-padding-x align-middle">
                <?php if ($products['alignment'] == 'left') : ?>
                  <div class="medium-5 medium-offset-6 cell text-right">
                    <h2><?php echo $products['headline']; ?></h2>
                    <p><?php echo $products['body_copy']; ?></p>
                    <button type="button" class="button"><?php echo $products['button_text']; ?></button>
                  </div>
                <?php elseif ($products['alignment'] == 'center') : ?>
                  <div class="medium-10 medium-offset-1 cell text-center medium-centered align-self-center" >
                    <div class="pad-full-small">
                      <h2><?php echo $products['headline']; ?></h2>
                      <p><?php echo $products['body_copy']; ?></p>
                      <button type="button" class="button"><?php echo $products['button_text']; ?></button>
                    </div>
                  </div>
                <?php elseif ($products['alignment'] == 'right') : ?>
                  <div class="medium-5 medium-offset-1 cell">
                    <h2><?php echo $products['headline']; ?></h2>
                    <p><?php echo $products['body_copy']; ?></p>
                    <button type="button" class="button"><?php echo $products['button_text']; ?></button>
                  </div>
                <?php endif; ?>
              </div></a>
          </div>
        <?php elseif ($products['background_color_or_image'] == 'color') : ?>
          <div class="medium-12 cell <?php check_background_color($products['background_color']); ?>" style="background-color: <?php echo $products['background_color']; ?>;">
            <a href="<?php echo $products['button_link']; ?>">
              <div class="grid-x grid-padding-x align-center align-middle">
                <?php if ($products['alignment'] == 'left') : ?>
                  <div class="medium-6 cell text-center">
                    <img src="<?php echo $products['image']['sizes']['team_topbar_icon']; ?>" alt="">
                  </div>
                  <div class="medium-5 cell text-right">
                    <h2><?php echo $products['headline']; ?></h2>
                    <p><?php echo $products['body_copy']; ?></p>
                    <button type="button" class="button"><?php echo $products['button_text']; ?></button>
                  </div>
                <?php elseif ($products['alignment'] == 'center') : ?>
                  <div class="medium-10 cell text-center" >
                    <div class="pad-full-small">
                      <h2><?php echo $products['headline']; ?></h2>
                      <img src="<?php echo $products['image']['sizes']['team_topbar_icon']; ?>" alt="">
                      <p><?php echo $products['body_copy']; ?></p>
                      <button type="button" class="button"><?php echo $products['button_text']; ?></button>
                    </div>
                  </div>
                <?php elseif ($products['alignment'] == 'right') : ?>
                  <div class="medium-5 medium-offset-1 cell">
                    <h2><?php echo $products['headline']; ?></h2>
                    <p><?php echo $products['body_copy']; ?></p>
                    <button type="button" class="button"><?php echo $products['button_text']; ?></button>
                  </div>
                  <div class="medium-6 cell text-center">
                    <img src="<?php echo $products['image']['sizes']['team_topbar_icon']; ?>" alt="">
                  </div>
                <?php endif; ?>
              </div>
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <?php
    $result = ob_get_clean();
  elseif ($layout == 2) :
    $products = get_field('two_products', 'options');
      ob_start();

      ?>
        <div class="hero-area">
         <div class="grid-x align-middle hero-cells">
          <div class="medium-7 cell align-self-stretch <?php if ($products['product_1_background_color_or_image'] == 'image') : ?><?php echo $products['product_1_overlay_color']; ?> overlay<?php else : ?><?php check_background_color($products['product_1_background_color']); ?><?php endif; ?>" <?php if (!empty($products['product_1_background_image'])) : ?>style="background-image: url('<?php echo $products['product_1_background_image']['sizes']['large'] ?>'); ?><?php else : ?>style="background-color: <?php echo $products['product_1_background_color']; ?>"<?php endif; ?>>
            <a href="<?php echo $products['product_1_button_link']; ?>">
              <div class="pad-full-small">
                <div class="grid-x grid-padding-x align-middle">
                  <?php if ($products['product_1_background_color_or_image'] == 'image') : ?>
                    <?php if ($products['product_1_layout'] == 'left') : ?>
                      <div class="medium-5 medium-offset-6 cell text-right">
                        <h2><?php echo $products['product_1_headline']; ?></h2>
                        <p><?php echo $products['product_1_body_copy']; ?></p>
                        <button type="button" class="button"><?php echo $products['product_1_button_text']; ?></button>
                      </div>
                    <?php elseif ($products['product_1_layout'] == 'center') : ?>
                      <div class="large-12 cell text-center">
                        <h2><?php echo $products['product_1_headline']; ?></h2>
                        <p><?php echo $products['product_1_body_copy']; ?></p>
                        <button type="button" class="button"><?php echo $products['product_1_button_text']; ?></button>
                      </div>
                    <?php elseif ($products['product_1_layout'] == 'right') : ?>
                      <div class="medium-5 medium-offset-1 cell">
                        <h2><?php echo $products['product_1_headline']; ?></h2>
                        <p><?php echo $products['product_1_body_copy']; ?></p>
                        <button type="button" class="button"><?php echo $products['product_1_button_text']; ?></button>
                      </div>
                    <?php endif; ?>
                  <?php elseif ($products['product_1_background_color_or_image'] == 'color') : ?>
                    <?php if ($products['product_1_layout'] == 'left') : ?>
                      <div class="medium-6 cell text-center">
                        <img src="<?php echo $products['product_1_image']['sizes']['team_topbar_icon']; ?>">
                      </div>
                      <div class="medium-6 cell text-right">
                        <h2><?php echo $products['product_1_headline']; ?></h2>
                        <p><?php echo $products['product_1_body_copy']; ?></p>
                        <button type="button" class="button"><?php echo $products['product_1_button_text']; ?></button>
                      </div>
                    <?php elseif ($products['product_1_layout'] == 'center') : ?>
                      <div class="large-12 cell text-center">
                        <h2><?php echo $products['product_1_headline']; ?></h2>
                        <img src="<?php echo $products['product_1_image']['sizes']['team_topbar_icon']; ?>" alt="">
                        <p><?php echo $products['product_1_body_copy']; ?></p>
                        <button type="button" class="button"><?php echo $products['product_1_button_text']; ?></button>
                      </div>
                    <?php elseif ($products['product_1_layout'] == 'right') : ?>
                      <div class="medium-6 cell">
                        <h2><?php echo $products['product_1_headline']; ?></h2>
                        <p><?php echo $products['product_1_body_copy']; ?></p>
                        <button type="button" class="button"><?php echo $products['product_1_button_text']; ?></button>
                      </div>
                      <div class="medium-6 cell text-right text-center">
                        <img src="<?php echo $products['product_1_image']['sizes']['team_topbar_icon']; ?>">
                      </div>
                    <?php endif; ?>
                  <?php endif; ?>
                </div>
              </div>
            </a>
          </div>
          <div class="medium-5 cell align-self-stretch <?php if ($products['product_2_background_color_or_image'] == 'image') : ?><?php echo $products['product_2_overlay_color']; ?> overlay<?php else : ?><?php check_background_color($products['product_2_background_color']); ?><?php endif; ?>" <?php if (!empty($products['product_2_background_image'])) : ?>style="background-image: url('<?php echo $products['product_2_background_image']['sizes']['large'] ?>'); ?><?php else : ?>style="background-color: <?php echo $products['product_2_background_color']; ?>"<?php endif; ?>>
            <a href="<?php echo $products['product_2_button_link']; ?>"><div class="pad-full-small">
                <div class="grid-x grid-padding-x align-middle">
                  <?php if ($products['product_2_background_color_or_image'] == 'image') : ?>
                    <?php if ($products['product_2_layout'] == 'left') : ?>
                      <div class="medium-5 medium-offset-6 cell text-right">
                        <h2><?php echo $products['product_2_headline']; ?></h2>
                        <p><?php echo $products['product_2_body_copy']; ?></p>
                        <button type="button" class="button"><?php echo $products['product_2_button_text']; ?></button>
                      </div>
                    <?php elseif ($products['product_2_layout'] == 'center') : ?>
                      <div class="large-12 cell text-center">
                        <h2><?php echo $products['product_2_headline']; ?></h2>
                        <p><?php echo $products['product_2_body_copy']; ?></p>
                        <button type="button" class="button"><?php echo $products['product_2_button_text']; ?></button>
                      </div>
                    <?php elseif ($products['product_2_layout'] == 'right') : ?>
                      <div class="medium-5 medium-offset-1 cell">
                        <h2><?php echo $products['product_2_headline']; ?></h2>
                        <p><?php echo $products['product_2_body_copy']; ?></p>
                        <button type="button" class="button"><?php echo $products['product_2_button_text']; ?></button>
                      </div>
                    <?php endif; ?>
                  <?php elseif ($products['product_2_background_color_or_image'] == 'color') : ?>
                    <?php if ($products['product_2_layout'] == 'left') : ?>
                      <div class="medium-6 cell text-center">
                        <img src="<?php echo $products['product_2_image']['sizes']['team_topbar_icon']; ?>">
                      </div>
                      <div class="medium-6 cell text-right">
                        <h2><?php echo $products['product_2_headline']; ?></h2>
                        <p><?php echo $products['product_2_body_copy']; ?></p>
                        <button type="button" class="button"><?php echo $products['product_2_button_text']; ?></button>
                      </div>
                    <?php elseif ($products['product_2_layout'] == 'center') : ?>
                      <div class="large-12 cell text-center">
                        <h2><?php echo $products['product_2_headline']; ?></h2>
                        <img src="<?php echo $products['product_2_image']['sizes']['team_topbar_icon']; ?>" alt="">
                        <p><?php echo $products['product_2_body_copy']; ?></p>
                        <button type="button" class="button"><?php echo $products['product_2_button_text']; ?></button>
                      </div>
                    <?php elseif ($products['product_2_layout'] == 'right') : ?>
                      <div class="medium-6 cell">
                        <h2><?php echo $products['product_2_headline']; ?></h2>
                        <p><?php echo $products['product_2_body_copy']; ?></p>
                        <button type="button" class="button"><?php echo $products['product_2_button_text']; ?></button>
                      </div>
                      <div class="medium-6 cell text-right text-center">
                        <img src="<?php echo $products['product_2_image']['sizes']['team_topbar_icon']; ?>">
                      </div>
                    <?php endif; ?>
                  <?php endif; ?>
                  
                 </div>
                </div>
              </div>
            </a>
        </div>
      </div>
      <?php

      $result = ob_get_clean();
  elseif ($layout == 3) : 
    $products = get_field('two_products', 'options'); 

    ob_start();

    ?>
      <div class="hero-area">
        <div class="grid-x align-middle hero-cells">
          <div class="medium-5 cell align-self-stretch <?php if ($products['product_1_background_color_or_image'] == 'image') : ?><?php echo $products['product_1_overlay_color']; ?> overlay<?php else : ?><?php check_background_color($products['product_1_background_color']); ?><?php endif; ?>" <?php if (!empty($products['product_1_background_image'])) : ?>style="background-image: url('<?php echo $products['product_1_background_image']['sizes']['large'] ?>'); ?><?php else : ?>style="background-color: <?php echo $products['product_1_background_color']; ?>"<?php endif; ?>>
            <a href="<?php echo $products['product_1_button_link']; ?>">
              <div class="pad-full-small">
                <div class="grid-x grid-padding-x align-middle">
                  <?php if ($products['product_1_background_color_or_image'] == 'image') : ?>
                    <?php if ($products['product_1_layout'] == 'left') : ?>
                      <div class="medium-5 medium-offset-6 cell text-right">
                        <h2><?php echo $products['product_1_headline']; ?></h2>
                        <p><?php echo $products['product_1_body_copy']; ?></p>
                        <button type="button" class="button"><?php echo $products['product_1_button_text']; ?></button>
                      </div>
                    <?php elseif ($products['product_1_layout'] == 'center') : ?>
                      <div class="large-12 cell text-center">
                        <h2><?php echo $products['product_1_headline']; ?></h2>
                        <p><?php echo $products['product_1_body_copy']; ?></p>
                        <button type="button" class="button"><?php echo $products['product_1_button_text']; ?></button>
                      </div>
                    <?php elseif ($products['product_1_layout'] == 'right') : ?>
                      <div class="medium-5 medium-offset-1 cell">
                        <h2><?php echo $products['product_1_headline']; ?></h2>
                        <p><?php echo $products['product_1_body_copy']; ?></p>
                        <button type="button" class="button"><?php echo $products['product_1_button_text']; ?></button>
                      </div>
                    <?php endif; ?>
                  <?php elseif ($products['product_1_background_color_or_image'] == 'color') : ?>
                    <?php if ($products['product_1_layout'] == 'left') : ?>
                      <div class="medium-6 cell text-center">
                        <img src="<?php echo $products['product_1_image']['sizes']['team_topbar_icon']; ?>">
                      </div>
                      <div class="medium-6 cell text-right">
                        <h2><?php echo $products['product_1_headline']; ?></h2>
                        <p><?php echo $products['product_1_body_copy']; ?></p>
                        <button type="button" class="button"><?php echo $products['product_1_button_text']; ?></button>
                      </div>
                    <?php elseif ($products['product_1_layout'] == 'center') : ?>
                      <div class="large-12 cell text-center">
                        <h2><?php echo $products['product_1_headline']; ?></h2>
                        <img src="<?php echo $products['product_1_image']['sizes']['team_topbar_icon']; ?>" alt="">
                        <p><?php echo $products['product_1_body_copy']; ?></p>
                        <button type="button" class="button"><?php echo $products['product_1_button_text']; ?></button>
                      </div>
                    <?php elseif ($products['product_1_layout'] == 'right') : ?>
                      <div class="medium-6 cell">
                        <h2><?php echo $products['product_1_headline']; ?></h2>
                        <p><?php echo $products['product_1_body_copy']; ?></p>
                        <button type="button" class="button"><?php echo $products['product_1_button_text']; ?></button>
                      </div>
                      <div class="medium-6 cell text-right text-center">
                        <img src="<?php echo $products['product_1_image']['sizes']['team_topbar_icon']; ?>">
                      </div>
                    <?php endif; ?>
                  <?php endif; ?>
                </div>
              </div>
            </a>
          </div>
          <div class="medium-7 cell align-self-stretch <?php if ($products['product_2_background_color_or_image'] == 'image') : ?><?php echo $products['product_2_overlay_color']; ?> overlay<?php else : ?><?php check_background_color($products['product_2_background_color']); ?><?php endif; ?>" <?php if (!empty($products['product_2_background_image'])) : ?>style="background-image: url('<?php echo $products['product_2_background_image']['sizes']['large']; ?>');"<?php else : ?>style="background-color: <?php echo $products['product_2_background_color']; ?>"<?php endif; ?>>
            <a href="<?php echo $products['product_2_button_link']; ?>">
              <div class="pad-full-small">
                <div class="grid-x grid-padding-x align-middle">
                  <?php if ($products['product_2_background_color_or_image'] == 'image') : ?>
                    <?php if ($products['product_2_layout'] == 'left') : ?>
                      <div class="medium-5 medium-offset-6 cell text-right">
                        <h2><?php echo $products['product_2_headline']; ?></h2>
                        <p><?php echo $products['product_2_body_copy']; ?></p>
                        <button type="button" class="button"><?php echo $products['product_2_button_text']; ?></button>
                      </div>
                    <?php elseif ($products['product_2_layout'] == 'center') : ?>
                      <div class="large-12 cell text-center">
                        <h2><?php echo $products['product_2_headline']; ?></h2>
                        <p><?php echo $products['product_2_body_copy']; ?></p>
                        <button type="button" class="button"><?php echo $products['product_2_button_text']; ?></button>
                      </div>
                    <?php elseif ($products['product_2_layout'] == 'right') : ?>
                      <div class="medium-5 medium-offset-1 cell">
                        <h2><?php echo $products['product_2_headline']; ?></h2>
                        <p><?php echo $products['product_2_body_copy']; ?></p>
                        <button type="button" class="button"><?php echo $products['product_2_button_text']; ?></button>
                      </div>
                    <?php endif; ?>
                  <?php elseif ($products['product_2_background_color_or_image'] == 'color') : ?>
                    <?php if ($products['product_2_layout'] == 'left') : ?>
                      <div class="medium-6 cell text-center">
                        <img src="<?php echo $products['product_2_image']['sizes']['team_topbar_icon']; ?>">
                      </div>
                      <div class="medium-6 cell text-right">
                        <h2><?php echo $products['product_2_headline']; ?></h2>
                        <p><?php echo $products['product_2_body_copy']; ?></p>
                        <button type="button" class="button"><?php echo $products['product_2_button_text']; ?></button>
                      </div>
                    <?php elseif ($products['product_2_layout'] == 'center') : ?>
                      <div class="large-12 cell text-center">
                        <h2><?php echo $products['product_2_headline']; ?></h2>
                        <img src="<?php echo $products['product_2_image']['sizes']['team_topbar_icon']; ?>" alt="">
                        <p><?php echo $products['product_2_body_copy']; ?></p>
                        <button type="button" class="button"><?php echo $products['product_2_button_text']; ?></button>
                      </div>
                    <?php elseif ($products['product_2_layout'] == 'right') : ?>
                      <div class="medium-6 cell">
                        <h2><?php echo $products['product_2_headline']; ?></h2>
                        <p><?php echo $products['product_2_body_copy']; ?></p>
                        <button type="button" class="button"><?php echo $products['product_2_button_text']; ?></button>
                      </div>
                      <div class="medium-6 cell text-right text-center">
                        <img src="<?php echo $products['product_2_image']['sizes']['team_topbar_icon']; ?>">
                      </div>
                    <?php endif; ?>
                  <?php endif; ?>
                  
                </div>
              </div>
            </a>
            </div>
        </div>
      </div>
    <?php

    $result = ob_get_clean();
  endif;
  echo $result;
}

/**
 * Update the Content on save
 * 
 */



function filter_post_data($data) {
  global $wpdb;
  $content_egg = $wpdb->get_results("SELECT * FROM {$wpdb->postmeta} WHERE post_id = $data and meta_key LIKE '_cegg%data%'");
  if ( ! wp_is_post_revision( $post_id ) ) {
    remove_action('save_post', 'filter_post_data');
    if (!empty($content_egg)) :
      $egg_data = unserialize( $content_egg[0]->meta_value );
      $egg_data = array_values($egg_data);
      $content = get_post_field('post_content', $data);

      $product = wc_get_product($data);
      if (empty($content)) :
        $post = array();
        $post['ID'] = $data;
        $description = $egg_data[0]['description'];
        $post['post_content'] = $description;
        if ($egg_data[0]['merchant'] == 'Amazon.com') :
          $list = '<ul>';
          foreach ($egg_data[0]['extra']['itemAttributes']['Feature'] as $feature) :
            $list .= "<li>$feature</li>\n"; 
          endforeach;
          $list .= "</ul>\n";
          $post['post_content'] .= "\n$list";

          

        endif;
        
        wp_update_post($post);
        
      endif;

      if ($egg_data[0]['merchant'] == 'Amazon.com') :
        if (empty($egg_data[0]['upc'])) :
          foreach ($egg_data[0]['features'] as $feat) :
            if ($feat['name'] == 'UPC') :
              $upc = $feat['value'];
            endif;
          endforeach;
        else :
          if (stripos( $egg_data['upc'], ';' )) :
            $upc = explode(';', $egg_data['upc']);
            $upc = $upc[0];
          endif;
        endif; 
        
        if (empty($product->get_sku())) :
          update_post_meta($data, '_sku', $upc);
        endif;
      else :

        $upc = $egg_data[0]['upc'];

        if (empty($product->get_sku())) :
          update_post_meta($data, '_sku', $upc);
        endif; 

      endif;
      
    endif;
    add_action('save_post', 'filter_post_data');
  }

  return $data;
  
}

add_action('save_post', 'filter_post_data');

function from_our_blog() {
  $args = array(
    'posts_per_page' => 3,
  );

  $blog_footer = new WP_Query($args);

  if ($blog_footer->have_posts()) :
    while ($blog_footer->have_posts()) : $blog_footer->the_post(); 
        $categories = get_the_terms(get_the_ID(), 'category');
        $category_list = array();
        foreach ($categories as $category) : 
          $category_list[] = $category->name;
        endforeach;
        $post_cats = join(', ', $category_list);
      ?>
        <article>
          <h3 class="title h5"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
          <p><?php echo get_the_date(); ?> | <?php echo $post_cats; ?></p>
        </article>
      <?php
    endwhile; 
  endif;
}

function set_uncategorized_brand($post_id, $post) {
  if ('publish' == $post->post_status && $post->post_type === 'product') :
    $defaults = array(
      'brands' => array('unassigned')
    );
    $taxonomies = get_object_taxonomies( $post->post_type );
    foreach ((array) $taxonomies as $taxonomy) :
      $terms = wp_get_post_terms($post_id, $taxonomy);
      if (empty($terms) && array_key_exists($taxonomy, $defaults)) :
        wp_set_object_terms( $post_id, $defaults[$taxonomy], $taxonomy);
      endif;
    endforeach;
  endif;

  // global $wpdb;
  // $content_egg = $wpdb->get_results("SELECT * FROM {$wpdb->postmeta} WHERE post_id = $post_id and meta_key LIKE '_cegg%data%'");
  // $product = wc_get_product($post_id);

  // if (!empty($content_egg)) :
  //   $egg_data = unserialize( $content_egg[0]->meta_value );
  //   $egg_data = array_values($egg_data);


  //   if ($egg_data[0]['merchant'] == 'Amazon.com') :
  //     foreach ($egg_data[0]['features'] as $feat) :
  //       if ($feat['name'] == 'UPC') :
  //         $upc = $feat['value'];
  //       endif;
  //     endforeach; 
      
  //     if (empty($product->get_sku())) :
  //       update_post_meta($data, '_sku', $upc);
  //     endif;
  //   else :

  //     $upc = $egg_data[0]['upc'];

  //     if (empty($product->get_sku())) :
  //       update_post_meta($data, '_sku', $upc);
  //     endif; 

  //   endif;


  // endif;

}

add_action( 'save_post', 'set_uncategorized_brand', 100, 2 );

/**
 * Image Sprites for Team Logos
 * 
 */

add_action('edited_nfl_teams', 'create_sprite_from_logos', 10, 2);
add_action('created_nfl_teams', 'create_sprite_from_logos', 10, 2);

add_action('delete_nfl_teams', 'sprite_deleted', 10, 4);

add_action('edited_college_teams', 'create_sprite_from_logos', 10, 2);
add_action('created_college_teams', 'create_sprite_from_logos', 10, 2);

add_action('delete_college_teams', 'sprite_deleted', 10, 4);

add_action('edited_nhl_teams', 'create_sprite_from_logos', 10, 2);
add_action('created_nhl_teams', 'create_sprite_from_logos', 10, 2);

add_action('delete_nhl_teams', 'sprite_deleted', 10, 4);

add_action('edited_nba_teams', 'create_sprite_from_logos', 10, 2);
add_action('created_nba_teams', 'create_sprite_from_logos', 10, 2);

add_action('delete_nba_teams', 'sprite_deleted', 10, 4);

add_action('edited_mlb_teams', 'create_sprite_from_logos', 10, 2);
add_action('created_mlb_teams', 'create_sprite_from_logos', 10, 2);

add_action('delete_mlb_teams', 'sprite_deleted', 10, 4);

function sprite_deleted($term_id, $tt_id, $deleted_term, $object_ids) {
  $term = $deleted_term;
  $tax_slug = $term->taxonomy;
  $tax_terms = get_terms(array(
    'taxonomy' => $tax_slug,
    'hide_empty' => false,
  ));

  $team_logos = array();

  $n = 0;

  $stylesheet = '';
  $upload = wp_upload_dir();
  $upload_dir = $upload['basedir'];
  $upload_path = $upload_dir . '/assets/images/sprites';
  $upload_url = $upload[ 'baseurl' ];
  $upload_url = str_replace( 'http://', 'https://', $upload_url );
  $stylesheet .= "header nav ul.menu li a.team-link.$tax_slug:before, div.mobile-menu ul.menu li.league .team a.team-link.$tax_slug:before { background-image: url('$upload_url/assets/images/sprites/" . $tax_slug . "_sprite.png') }\n";
  foreach ($tax_terms as $tt) : 
    $image = get_field('team_logo', 'category_' . $tt->term_id);
    array_push($team_logos, array(
      'url' => $image['sizes']['team_menu_icon'],
      'offset' => $n,
    ));

    $stylesheet .= ".team-link.$tt->slug:before { background-position: 0px -".$n."px }\n";
    $n += 20;
    
  endforeach;

  $background = imagecreatetruecolor(20, $n);

  
  $color = imagecolorallocatealpha($background, 0, 0, 0, 127);
  imagecolortransparent($background, $color); 
  imagefill($background, 0, 0, $color);

  
  if (!is_dir($upload_path)) :
    wp_mkdir_p($upload_path);
  endif;

  $sprite = $upload_dir . '/assets/images/sprites/' . $tax_slug . '_sprite.png';

  foreach ($team_logos as $tl) :
    $tmp = imagecreatefrompng($tl['url']);
    imagecopy($background, $tmp, 0, $tl['offset'], 0, 0, 20, 20);
    imagedestroy($tmp);
  endforeach;
  imagesavealpha($background, true);

  imagepng($background, $sprite);

  $stylesheet_path = $upload_dir . '/assets/images/sprites/' . $tax_slug . '_styles.css';
  $handle = fopen($stylesheet_path, 'w');
  fwrite($handle, $stylesheet);
  fclose($handle);
}

function create_sprite_from_logos($term_id, $tt_id) {

  $upload = wp_upload_dir();
  $upload_dir = $upload['basedir'];
  $upload_path = $upload_dir . '/assets/images/sprites';
  if (!is_dir($upload_path)) :
    wp_mkdir_p($upload_path);
  endif;
  $term = get_term($term_id);
  $tax_slug = $term->taxonomy;
  $tax_terms = get_terms(array(
    'taxonomy' => $tax_slug,
    'hide_empty' => false,
  ));

  $team_logos = array();

  $n = 0;

  $stylesheet = '';
  $upload_url = $upload[ 'baseurl' ];
  $upload_url = str_replace( 'http://', 'https://', $upload_url );
  $stylesheet .= "header nav ul.menu li a.team-link.$tax_slug:before, div.mobile-menu ul.menu li.league .team a.team-link.$tax_slug:before { background-image: url('$upload_url/assets/images/sprites/" . $tax_slug . "_sprite.png') }\n";
  foreach ($tax_terms as $tt) : 
    $image = get_field('team_logo', 'category_' . $tt->term_id);
    array_push($team_logos, array(
      'url' => $image['sizes']['team_menu_icon'],
      'offset' => $n,
      'width' => $image['sizes']['team_menu_icon-width'],
      'height' => $image['sizes']['team_menu_icon-height']
    ));
    
    $tt_name_lower = strtolower(str_replace(' ', '-', $tt->name));
    $stylesheet .= ".team-link.$tt->slug:before { background-position: 0px -".$n."px }\n";
    $stylesheet .= ".team-link.$tt_name_lower:before { background-position: 0px -".$n."px }\n";
    $n += 20;
    
  endforeach;

  $background = imagecreatetruecolor(20, $n);

  $color = imagecolorallocatealpha($background, 0, 0, 0, 127);
  imagecolortransparent($background, $color); 
  imagefill($background, 0, 0, $color);

  $sprite = $upload_dir . '/assets/images/sprites/' . $tax_slug . '_sprite.png';

  foreach ($team_logos as $tl) :
    if ($tl['width'] !== 20 || $tl['height'] !== 20) : 
      $tmp = imagecreatetruecolor(20, 20);
      $color = imagecolorallocatealpha($tmp, 0, 0, 0, 127);
      imagecolortransparent($tmp, $color);
      imagefill($tmp, 0, 0, $color);
      $tmp_pre = imagecreatefrompng($tl['url']);
      $offset_w = (20 - $tl['width']) / 2;
      $offset_h = (20 - $tl['height']) / 2;
      imagecopy($tmp, $tmp_pre, $offset_w, $offset_h, 0, 0, $tl['width'], $tl['height']);
    else :
      $tmp = imagecreatefrompng($tl['url']);
    endif;
    imagecopy($background, $tmp, 0, $tl['offset'], 0, 0, 20, 20);
    imagedestroy($tmp);
  endforeach;

  imagesavealpha($background, true);

  imagepng($background, $sprite);

  $stylesheet_path = $upload_dir . '/assets/images/sprites/' . $tax_slug . '_styles.css';
  $handle = fopen($stylesheet_path, 'w');
  fwrite($handle, $stylesheet);
  fclose($handle);

}

/**
 * Add Custom Taxonomies to WC Import
 * 
 */

/**
 * Register Custom taxonomies in the importer
 *
 * @param  array $options
 * @return  array $options
 */

function prosleeves_map_columns($options) {
  $options['nfl_teams'] = __('NFL Teams', 'prosleeves');
  $options['college_teams'] = __('NCAA Teams', 'prosleeves');
  $options['nhl_teams'] = __('NHL Teams', 'prosleeves');
  $options['nba_teams'] = __('NBA Teams', 'prosleeves');
  $options['mlb_teams'] = __('MLB Teams', 'prosleeves');
  $options['brands'] = __('Brands', 'prosleeves');
  $options['shop_for'] = __('Shop For', 'prosleeves');

  return $options;
}

add_filter('woocommerce_csv_product_import_mapping_options', 'prosleeves_map_columns');

/**
 * Add automatic mapping support for custom columns
 * 
 * @param  array $columns
 * @return array $columns
 */

function prosleeves_add_columns_to_mapping_screen($columns) {
  $columns[__('NFL Teams', 'prosleeves')] = 'nfl_teams';
  $columns[__('NCAA Teams', 'prosleeves')] = 'college_teams';
  $columns[__('NHL Teams', 'prosleeves')] = 'nhl_teams';
  $columns[__('NBA Teams', 'prosleeves')] = 'nba_teams';
  $columns[__('MLB Teams', 'prosleeves')] = 'mlb_teams';
  $columns[__('Brands', 'prosleeves')] = 'brands';
  $columns[__('Shop For', 'prosleeves')] = 'shop_for';

  return $columns;
}

add_filter('woocommerce_csv_product_import_mapping_default_columns', 'prosleeves_add_columns_to_mapping_screen');

/**
 * Decode data items and parse JSON IDs
 *
 * @param array $parsed_data
 * @param  WC_Product_CSV_Importer $importer
 *
 * @return  array
 */

// function prosleeves_parse_taxonomy_json($parsed_data, $importer) {
//   if (!empty($parsed_data['nfl_teams'])) {
//     $data = json_decode($parsed_data['nfl_teams'], true);
//     unset($parsed_data['nfl_teams']);

//     if (is_array($data)) {
//       $parsed_data['nfl_teams'] = array();
//       foreach ($data as $term_id) {
//         $parsed_data['nfl_teams'][] = $term_id;
//       }
//     }
//   }

//   if (!empty($parsed_data['college_teams'])) {
//     $data = json_decode($parsed_data['college_teams'], true);
//     unset($parsed_data['college_teams']);

//     if (is_array($data)) {
//       $parsed_data['college_teams'] = array();
//       foreach ($data as $term_id) {
//         $parsed_data['college_teams'][] = $term_id;
//       }
//     }
//   }
  
//   if (!empty($parsed_data['nhl_teams'])) {
//     $data = json_decode($parsed_data['nhl_teams'], true);
//     unset($parsed_data['nhl_teams']);

//     if (is_array($data)) {
//       $parsed_data['nhl_teams'] = array();
//       foreach ($data as $term_id) {
//         $parsed_data['nhl_teams'][] = $term_id;
//       }
//     }
//   }
  
//   if (!empty($parsed_data['nba_teams'])) {
//     $data = json_decode($parsed_data['nba_teams'], true);
//     unset($parsed_data['nba_teams']);

//     if (is_array($data)) {
//       $parsed_data['nba_teams'] = array();
//       foreach ($data as $term_id) {
//         $parsed_data['nba_teams'][] = $term_id;
//       }
//     }
//   }
  
//   if (!empty($parsed_data['mlb_teams'])) {
//     $data = json_decode($parsed_data['mlb_teams'], true);
//     unset($parsed_data['mlb_teams']);

//     if (is_array($data)) {
//       $parsed_data['mlb_teams'] = array();
//       foreach ($data as $term_id) {
//         $parsed_data['mlb_teams'][] = $term_id;
//       }
//     }
//   }
  
//   if (!empty($parsed_data['brands'])) {
//     $data = json_decode($parsed_data['brands'], true);
//     unset($parsed_data['brands']);

//     if (is_array($data)) {
//       $parsed_data['brands'] = array();
//       foreach ($data as $term_id) {
//         $parsed_data['brands'][] = $term_id;
//       }
//     }
//   }

//   if (!empty($parsed_data['shop_for'])) {
//     $data = json_decode($parsed_data['shop_for'], true);
//     unset($parsed_data['shop_for']);

//     if (is_array($data)) {
//       $parsed_data['shop_for'] = array();
//       foreach ($data as $term_id) {
//         $parsed_data['shop_for'][] = $term_id;
//       }
//     }
//   }

//   return $parsed_data;
// }

// add_filter('woocommerce_product_importer_parsed_data', 'prosleeves_parse_taxonomy_json', 10, 2);


/**
 * Set Taxonomy
 *
 * @param  array  $parsed_data
 * @return   array
 */
function prosleeves_set_taxonomy($product, $data) {
  if (is_a($product, 'WC_Product')) {
    if (!empty($data['nfl_teams'])) {
      wp_set_object_terms($product->get_id(), $data['nfl_teams'], 'nfl_teams');
    }

    if (!empty($data['college_teams'])) {
      wp_set_object_terms($product->get_id(), $data['college_teams'], 'college_teams');
    }

    if (!empty($data['nhl_teams'])) {
      wp_set_object_terms($product->get_id(), $data['nhl_teams'], 'nhl_teams');
    }

    if (!empty($data['nba_teams'])) {
      wp_set_object_terms($product->get_id(), $data['nba_teams'], 'nba_teams');
    }

    if (!empty($data['mlb_teams'])) {
      wp_set_object_terms($product->get_id(), $data['mlb_teams'], 'mlb_teams');
    }

    if (!empty($data['shop_for'])) {
      wp_set_object_terms($product->get_id(), $data['shop_for'], 'shop_for');
    }

    if (!empty($data['brands'])) {
      wp_set_object_terms($product->get_id(), $data['brands'], 'brands');
    }

  }
  return $product;
}

add_filter('woocommerce_product_import_inserted_product_object', 'prosleeves_set_taxonomy', 10, 2);

