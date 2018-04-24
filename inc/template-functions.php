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

}

add_image_size( 'team_menu_icon', 10, 10, false );

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
  	$rgb = HTMLToRGB($color);
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

  add_rewrite_rule('^(.*)/(.*)/products/(.*)?$', 'index.php?league=$matches[1]&team=$matches[2]&product_cat=$matches[3]', 'top');

}

function rewrite_team_templates() {
  if (get_query_var('league')) :
    add_filter('template_include', function() {
      return get_template_directory() . '/template-league-products.php';
    });
  endif;
}

add_action('template_redirect', 'rewrite_team_templates');