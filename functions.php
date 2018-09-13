<?php
/**
 * ProSleeves functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ProSleeves
 */

if ( ! function_exists( 'prosleeves_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function prosleeves_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on ProSleeves, use a find and replace
		 * to change 'prosleeves' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'prosleeves', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'prosleeves' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'prosleeves_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'prosleeves_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function prosleeves_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'prosleeves_content_width', 640 );
}
add_action( 'after_setup_theme', 'prosleeves_content_width', 0 );


if (!is_admin()) add_action("wp_enqueue_scripts", "my_jquery_enqueue", 25);
function my_jquery_enqueue() {
   wp_deregister_script('jquery');
   wp_register_script('jquery', "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js", false, null);
   wp_enqueue_script('jquery');
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function prosleeves_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'prosleeves' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'prosleeves' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar(array(
		'name' => 'Footer Area',
		'id' => 'footer_area',
		'description' => 'Add widgets here.',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
	));
}
add_action( 'widgets_init', 'prosleeves_widgets_init' );

/**
 * Enqueue scripts and styles.
 */



function prosleeves_scripts() {
	$cache_buster = date('YmdHis');
	wp_enqueue_style( 'prosleeves-style', get_template_directory_uri() . '/assets/css/build/app.min.css', array(), $cache_buster );

	wp_enqueue_script( 'prosleeves-vendors', get_template_directory_uri() . '/assets/js/build/vendors.min.js', array(), $cache_buster, true );

	wp_enqueue_script( 'prosleeves-scripts', get_template_directory_uri() . '/assets/js/build/main.min.js', array(), $cache_buster, true );

	wp_enqueue_script('font-awesome', 'https://use.fontawesome.com/releases/v5.0.8/js/all.js', array(), array(), true); 
	wp_enqueue_style('fonts', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700,700i');

}
add_action( 'wp_enqueue_scripts', 'prosleeves_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
/**
 * Team additions.
 */
require get_template_directory() . '/inc/teams.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Load PW Bulk Edit Results Button
 */
function custom_pw_bulk_edit_results_buttons() {
    ?>
    <div>
        <button id="pwbe-open-all-tabs-button" class="button button-secondary"><i class='fa fa-external-link fa-fw' aria-hidden='true'></i> <?php _e( 'Open all checked products in a new tab', 'pw-bulk-edit' ); ?></button>
    </div>
    <script>
        jQuery(function() {
            jQuery('#pwbe-open-all-tabs-button').click(function(e) {
                jQuery('.pwbe-product-checkbox').each(function(index) {
                    var checkbox = jQuery(this);
                    if (checkbox.prop('checked')) {
                        var postId = checkbox.closest('.pwbe-product-tr').find('.pwbe-product-checkbox').val();
                        if (postId) {
                            var url = '<?php echo admin_url('post.php?action=edit&post='); ?>' + postId;
                            window.open(url, '_blank');
                        }
                    }
                });

                e.preventDefault();
                return false;
            });
        });
    </script>
    <?php
}
add_action( 'pw_bulk_edit_results_buttons', 'custom_pw_bulk_edit_results_buttons' );

/**
 * Load PW Bulk Edit Column Filters
 */
function pw_bulk_edit_custom_columns( $columns ) {
    $show_columns = array(
        __( 'Product name', 'woocommerce' ),
        __( 'Type', 'woocommerce' ),
        __( 'Status', 'woocommerce' ),
        __( 'Regular price', 'woocommerce' ),
        __( 'Sale price', 'woocommerce' ),
        __( 'Sale start date', 'woocommerce' ),
        __( 'Sale end date', 'woocommerce' ),
        // __( 'Product description', 'woocommerce' ),
        // __( 'Short description', 'woocommerce' ),
        // __( 'Variation description', 'woocommerce' ),
        __( 'SKU', 'woocommerce' ),
        // __( 'Vendor', 'yith' ),
        __( 'Categories', 'woocommerce' ),
        // __( 'Tags', 'woocommerce' ),
        // __( 'Brands', 'woocommerce' ),
        // __( 'Tax status', 'woocommerce' ),
        // __( 'Tax class', 'woocommerce' ),
        // __( 'Weight', 'woocommerce' ),
        // __( 'Length', 'woocommerce' ),
        // __( 'Width', 'woocommerce' ),
        // __( 'Height', 'woocommerce' ),
        // __( 'Shipping class', 'woocommerce' ),
        // __( 'Manage stock', 'woocommerce' ),
        // __( 'Stock quantity', 'woocommerce' ),
        // __( 'Allow backorders', 'woocommerce' ),
        // __( 'Stock status', 'woocommerce' ),
        // __( 'Sold individually', 'woocommerce' ),
        // __( 'Virtual', 'woocommerce' ),
        // __( 'Downloadable', 'woocommerce' ),
        // __( 'Download limit', 'woocommerce' ),
        // __( 'Download expiry', 'woocommerce' ),
        // __( 'Purchase note', 'woocommerce' ),
        // __( 'Menu order', 'woocommerce' ),
        // __( 'Catalog visibility', 'woocommerce' ),
        // __( 'Featured', 'woocommerce' ),
        __( 'ID', 'woocommerce' ),
    );

    $filtered_columns = array();
    foreach ( $columns as $column ) {
        if ( in_array( $column['name'], $show_columns ) ) {
            $filtered_columns[] = $column;
        }
    }

    return $filtered_columns;
}
add_filter( 'pwbe_product_columns', 'pw_bulk_edit_custom_columns' );