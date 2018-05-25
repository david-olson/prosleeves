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

}

add_image_size( 'team_menu_icon', 20, 20, false );
add_image_size('team_topbar_icon', 400, 400, false);

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
    add_rewrite_rule("^($slug[0])?$", 'index.php?league=$matches[1]', 'top');
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
  ?>
    <div class="slider" data-slider data-initial-start="0" data-end="350">
      <span class="slider-handle" data-slider-handle role="slider" tabindex="1"></span>
      <span class="slider-fill" data-slider-fill></span>
      <input type="hidden" name="price_range">
    </div>
  <?php
}

/**
 * Add Price Alerts to My Account Area
 * 
 */

function prosleeves_account_menu_items($items) {
  $items['price-alerts'] = __('Price Alerts', 'price-alerts');

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
  
  <p>Here are the price alerts you have set up.</p>
  <?php if (count($price_alerts) > 0) : ?>
    <table>
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
            <td class="text-right"><?php echo $alert->price; ?></td>
            <td class="text-right"><?php echo $alert->create_date; ?></td>
            <td class="text-right"><?php echo $alert->complet_date; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else : ?>
    <p>You have not set up any price alerts yet.</p>
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
              <?php foreach ($all_nfl as $team) : ?>
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
    <h2 class="h5"><?php echo $message; ?> | Ends <?php echo $expiration_date; ?></h2>
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
  if (isset($_GET['taxonomy_product_cat']) || isset($_GET['taxonomy_shop_for']) || isset($_GET['taxonomy_brand'])) :
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
        'taxonomy' => 'brand',
        'field' => 'id',
        'terms' => $_GET['taxonomy_brand'],
      );
      array_push($tax_query, $tax_brand);
    endif;
    $q->set('tax_query', $tax_query);
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

  elseif ($layout == 2) :
      ob_start();

      ?>
        <div class="hero-area">
        <div class="grid-x">
          <div class="medium-7 cell">
            <div class="grid-x grid-padding-x">
              <?php if ($products['product_1_layout'] == 'left') : ?>
                <div class="medium-6 cell">
                  <img src="<?php echo $products['product_1_image']['sizes']['large']; ?>">
                </div>
                <div class="medium-6 cell text-right">
                  <h2><?php echo $products['product_1_headline']; ?></h2>
                  <p><?php echo $products['product_1_body_copy']; ?></p>
                  <a href="<?php echo $products['product_1_button_link']; ?>" class="button"><?php echo $products['product_1_button_text']; ?></a>
                </div>
              <?php elseif ($products['product_1_layout'] == 'center') : ?>
                <div class="large-12 cell text-center">
                  <h2><?php echo $products['product_1_headline']; ?></h2>
                  <img src="<?php echo $products['product_1_image']['sizes']['large']; ?>" alt="">
                  <p><?php echo $products['product_1_body_copy']; ?></p>
                  <a href="<?php echo $products['product_1_button_link']; ?>" class="button"><?php echo $products['product_1_button_text']; ?></a>
                </div>
              <?php elseif ($products['product_1_layout'] == 'right') : ?>
                <div class="medium-6 cell">
                  <h2><?php echo $products['product_1_headline']; ?></h2>
                  <p><?php echo $products['product_1_body_copy']; ?></p>
                  <a href="<?php echo $products['product_1_button_link']; ?>" class="button"><?php echo $products['product_1_button_text']; ?></a>
                </div>
                <div class="medium-6 cell text-right">
                  <img src="<?php echo $products['product_1_image']['sizes']['large']; ?>">
                </div>
              <?php endif; ?>
              
            </div>
          </div>
          <div class="medium-5 cell">
            
          </div>
        </div>
      </div>
      <?php

      $result = ob_get_clean();
  elseif ($layout == 3) : 
    $products = get_field('two_products', 'options'); 

    ob_start();

    ?>
      <div class="hero-area">
        <div class="grid-x align-middle">
          <div class="medium-5 cell align-self-stretch" style="background-color: <?php echo $products['product_1_background_color']; ?>">
            <div class="pad-full-small">
              <div class="grid-x grid-padding-x align-middle">
                <?php if ($products['product_1_layout'] == 'left') : ?>
                  <div class="medium-6 cell">
                    <img src="<?php echo $products['product_1_image']['sizes']['large']; ?>">
                  </div>
                  <div class="medium-6 cell text-right">
                    <h2><?php echo $products['product_1_headline']; ?></h2>
                    <p><?php echo $products['product_1_body_copy']; ?></p>
                    <a href="<?php echo $products['product_1_button_link']; ?>" class="button"><?php echo $products['product_1_button_text']; ?></a>
                  </div>
                <?php elseif ($products['product_1_layout'] == 'center') : ?>
                  <div class="large-12 cell text-center">
                    <h2><?php echo $products['product_1_headline']; ?></h2>
                    <img src="<?php echo $products['product_1_image']['sizes']['large']; ?>" alt="">
                    <p><?php echo $products['product_1_body_copy']; ?></p>
                    <a href="<?php echo $products['product_1_button_link']; ?>" class="button"><?php echo $products['product_1_button_text']; ?></a>
                  </div>
                <?php elseif ($products['product_1_layout'] == 'right') : ?>
                  <div class="medium-6 cell">
                    <h2><?php echo $products['product_1_headline']; ?></h2>
                    <p><?php echo $products['product_1_body_copy']; ?></p>
                    <a href="<?php echo $products['product_1_button_link']; ?>" class="button"><?php echo $products['product_1_button_text']; ?></a>
                  </div>
                  <div class="medium-6 cell text-right">
                    <img src="<?php echo $products['product_1_image']['sizes']['large']; ?>">
                  </div>
                <?php endif; ?>
                
              </div>
            </div>
          </div>
          <div class="medium-7 cell align-self-stretch" style="background-color: <?php echo $products['product_2_background_color']; ?>">
            <div class="pad-full-small">
              <div class="grid-x grid-padding-x align-middle">
                <?php if ($products['product_2_layout'] == 'left') : ?>
                  <div class="medium-6 cell">
                    <img src="<?php echo $products['product_2_image']['sizes']['large']; ?>">
                  </div>
                  <div class="medium-6 cell text-right">
                    <h2><?php echo $products['product_2_headline']; ?></h2>
                    <p><?php echo $products['product_2_body_copy']; ?></p>
                    <a href="<?php echo $products['product_2_button_link']; ?>" class="button"><?php echo $products['product_2_button_text']; ?></a>
                  </div>
                <?php elseif ($products['product_2_layout'] == 'center') : ?>
                  <div class="large-12 cell text-center">
                    <h2><?php echo $products['product_2_headline']; ?></h2>
                    <img src="<?php echo $products['product_2_image']['sizes']['large']; ?>" alt="">
                    <p><?php echo $products['product_2_body_copy']; ?></p>
                    <a href="<?php echo $products['product_2_button_link']; ?>" class="button"><?php echo $products['product_2_button_text']; ?></a>
                  </div>
                <?php elseif ($products['product_2_layout'] == 'right') : ?>
                  <div class="medium-6 cell">
                    <h2><?php echo $products['product_2_headline']; ?></h2>
                    <p><?php echo $products['product_2_body_copy']; ?></p>
                    <a href="<?php echo $products['product_2_button_link']; ?>" class="button"><?php echo $products['product_2_button_text']; ?></a>
                  </div>
                  <div class="medium-6 cell text-right">
                    <img src="<?php echo $products['product_2_image']['sizes']['large']; ?>">
                  </div>
                <?php endif; ?>
                
              </div>
                        </div>
            </div>
        </div>
      </div>
    <?php

    $result = ob_get_clean();
  endif;
  echo $result;
}