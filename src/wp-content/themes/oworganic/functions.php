<?php
/**
 * oworganic functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Oworganic
 * @since Oworganic 1.0.27
 */

define( 'OWORGANIC_THEME_VERSION', '1.0.27' );
define( 'OWORGANIC_DEMO_MODE', false );

if ( ! isset( $content_width ) ) {
	$content_width = 660;
}

if ( ! function_exists( 'oworganic_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Oworganic 1.0
 */
function oworganic_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on oworganic, use a find and replace
	 * to change 'oworganic' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'oworganic', get_template_directory() . '/languages' );

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
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 750, true );
	
	add_image_size( 'oworganic-shop-large', 850, 850, true );
	add_image_size( 'oworganic-shop-horizontal', 850, 410, true );
	add_image_size( 'oworganic-shop-small', 410, 410, true );
	add_image_size( 'oworganic-shop-gallery', 465, 400, true );
	add_image_size( 'oworganic-shop-special', 490, 360, true );
	add_image_size( 'oworganic-shop-thumbnail', 150, 150, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'oworganic' ),
		'mobile-primary' => esc_html__( 'Mobile Primary Menu', 'oworganic' ),
		'my-account' => esc_html__( 'My Account Menu', 'oworganic' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	add_theme_support( "woocommerce", array('gallery_thumbnail_image_width' => 170) );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	
	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

	$color_scheme  = oworganic_get_color_scheme();
	$default_color = trim( $color_scheme[0], '#' );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'oworganic_custom_background_args', array(
		'default-color'      => $default_color,
		'default-attachment' => 'fixed',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );

	// Enqueue editor styles.
	add_editor_style( 'css/style-editor.css' );
}
endif; // oworganic_setup
add_action( 'after_setup_theme', 'oworganic_setup' );


function oworganic_admin_enqueue_styles() {
	wp_enqueue_style( 'oworganic-webfont', get_template_directory_uri() . '/css/webfonts.css', array(), '1.0.0' );

	//load font awesome
	wp_enqueue_style( 'all-awesome', get_template_directory_uri() . '/css/all-awesome.css', array(), '5.11.2' );

	// load font themify icon
	wp_enqueue_style( 'font-themify', get_template_directory_uri() . '/css/themify-icons.css', array(), '1.0.0' );

	// load font flaticon icon
	wp_enqueue_style( 'font-flaticon', get_template_directory_uri() . '/css/flaticon.css', array(), '1.0.0' );

}
add_action( 'admin_enqueue_scripts', 'oworganic_admin_enqueue_styles', 100 );
/**
 * Enqueue styles.
 *
 * @since Oworganic 1.0
 */
function oworganic_enqueue_styles() {
	
	$main_font = oworganic_get_config('main_font');
	$main_font = !empty($main_font['font-family']) ? $main_font['font-family'] : 'NeutraTextTF';

	$heading_font = oworganic_get_config('heading_font');
	$heading_font = !empty($heading_font['font-family']) ? $heading_font['font-family'] : 'NeutraTextTF';

	if ( $main_font == 'NeutraTextTF' || $heading_font == 'NeutraTextTF' ) {
		wp_enqueue_style( 'oworganic-webfont', get_template_directory_uri() . '/css/webfonts.css', array(), '1.0.0' );
	}

	//load font awesome
	wp_enqueue_style( 'all-awesome', get_template_directory_uri() . '/css/all-awesome.css', array(), '5.11.2' );

	// load font themify icon
	wp_enqueue_style( 'font-themify', get_template_directory_uri() . '/css/themify-icons.css', array(), '1.0.0' );

	// load font flaticon icon
	wp_enqueue_style( 'font-flaticon', get_template_directory_uri() . '/css/flaticon.css', array(), '1.0.0' );
	
	// load animate version 3.6.0
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.css', array(), '3.6.0' );

	// load bootstrap style
	if( is_rtl() ){
		wp_enqueue_style( 'bootstrap-rtl', get_template_directory_uri() . '/css/bootstrap-rtl.css', array(), '3.2.0' );
	} else {
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '3.2.0' );
	}
	// slick
	wp_enqueue_style( 'slick', get_template_directory_uri() . '/css/slick.css', array(), '1.8.0' );
	// magnific-popup
	wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/css/magnific-popup.css', array(), '1.1.0' );
	// perfect scrollbar
	wp_enqueue_style( 'perfect-scrollbar', get_template_directory_uri() . '/css/perfect-scrollbar.css', array(), '0.6.12' );

	wp_enqueue_style( 'sliding-menu', get_template_directory_uri() . '/css/sliding-menu.min.css', array(), '0.3.0' );
	
	// main style
	wp_enqueue_style( 'oworganic-wc-quantity-increment', get_template_directory_uri() .'/css/wc-quantity-increment.css' );

	wp_enqueue_style( 'oworganic-woocommerce-smallscreen', get_template_directory_uri() .'/css/woocommerce-smallscreen.css' );

	wp_dequeue_style( 'woocommerce-smallscreen' );
	wp_enqueue_style( 'oworganic-template', get_template_directory_uri() . '/css/template.css', array(), '1.0' );
	
	$custom_style = oworganic_custom_styles();
	if ( !empty($custom_style) ) {
		wp_add_inline_style( 'oworganic-template', $custom_style );
	}
	wp_enqueue_style( 'oworganic-style', get_template_directory_uri() . '/style.css', array(), '1.0' );

	wp_deregister_style('yith-wcwl-font-awesome');
}
add_action( 'wp_enqueue_scripts', 'oworganic_enqueue_styles', 100 );
/**
 * Enqueue scripts.
 *
 * @since Oworganic 1.0
 */
function oworganic_enqueue_scripts() {
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	// bootstrap
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '20150330', true );
	// slick
	wp_enqueue_script( 'slick', get_template_directory_uri() . '/js/slick.min.js', array( 'jquery' ), '1.8.0', true );
	// countdown
	wp_register_script( 'countdown', get_template_directory_uri() . '/js/countdown.js', array( 'jquery' ), '20150315', true );
	wp_localize_script( 'countdown', 'oworganic_countdown_opts', array(
		'days' => esc_html__('Days', 'oworganic'),
		'hours' => esc_html__('Hours', 'oworganic'),
		'mins' => esc_html__('Mins', 'oworganic'),
		'secs' => esc_html__('Secs', 'oworganic'),
	));
	
	// popup
	wp_enqueue_script( 'jquery-magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array( 'jquery' ), '1.1.0', true );
	// unviel
	wp_enqueue_script( 'jquery-unveil', get_template_directory_uri() . '/js/jquery.unveil.js', array( 'jquery' ), '1.1.0', true );
	// perfect scrollbar
	wp_enqueue_script( 'perfect-scrollbar', get_template_directory_uri() . '/js/perfect-scrollbar.jquery.min.js', array( 'jquery' ), '0.6.12', true );
	
	if ( oworganic_get_config('keep_header') ) {
		wp_enqueue_script( 'jquery-waypoints', get_template_directory_uri() . '/js/jquery.waypoints.min.js', array( 'jquery' ), '4.0.1', true );
		wp_enqueue_script( 'sticky', get_template_directory_uri() . '/js/sticky.min.js', array( 'jquery', 'jquery-waypoints' ), '4.0.1', true );
	}
	
	wp_enqueue_script( 'sliding-menu', get_template_directory_uri() . '/js/sliding-menu.min.js', array( 'jquery' ), '0.3.0', true );

	wp_enqueue_script( 'gsap', get_template_directory_uri() . '/js/gsap.min.js', array( 'jquery' ), '3.4.1', true );

	// main script
	wp_register_script( 'oworganic-functions', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150330', true );
	wp_localize_script( 'oworganic-functions', 'oworganic_opts', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'previous' => esc_html__('Previous', 'oworganic'),
		'next' => esc_html__('Next', 'oworganic'),
	));
	wp_enqueue_script( 'oworganic-functions' );
	
	wp_add_inline_script( 'oworganic-functions', "(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);" );
}
add_action( 'wp_enqueue_scripts', 'oworganic_enqueue_scripts', 1 );

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Oworganic 1.0
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function oworganic_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'oworganic_search_form_modify' );

/**
 * Function get opt_name
 *
 */
function oworganic_get_opt_name() {
	return 'oworganic_theme_options';
}
add_filter( 'apus_framework_get_opt_name', 'oworganic_get_opt_name' );


function oworganic_register_demo_mode() {
	if ( defined('OWORGANIC_DEMO_MODE') && OWORGANIC_DEMO_MODE ) {
		return true;
	}
	return false;
}
add_filter( 'apus_framework_register_demo_mode', 'oworganic_register_demo_mode' );

function oworganic_get_demo_preset() {
	$preset = '';
    if ( defined('OWORGANIC_DEMO_MODE') && OWORGANIC_DEMO_MODE ) {
        if ( isset($_REQUEST['_preset']) && $_REQUEST['_preset'] ) {
            $presets = get_option( 'apus_framework_presets' );
            if ( is_array($presets) && isset($presets[$_REQUEST['_preset']]) ) {
                $preset = sanitize_text_field($_REQUEST['_preset']);
            }
        } else {
            $preset = get_option( 'apus_framework_preset_default' );
        }
    }
    return $preset;
}

function oworganic_get_config($name, $default = '') {
	global $oworganic_options;
    if ( isset($oworganic_options[$name]) ) {
        return $oworganic_options[$name];
    }
    return $default;
}

function oworganic_set_exporter_settings_option_keys($option_keys) {
	return array_merge($option_keys, array(
		'elementor_disable_color_schemes',
		'elementor_disable_typography_schemes',
		'elementor_allow_tracking',
		'elementor_cpt_support',
		'size_guides',
		'size_guides_enable',
		'size_guides_image',
		'apus_salespopup_settings',
		'woosuite_variation_swatches_option'
	));
}
add_filter( 'apus_exporter_ocdi_settings_option_keys', 'oworganic_set_exporter_settings_option_keys' );

function oworganic_disable_one_click_import() {
	return false;
}
add_filter('apus_frammework_enable_one_click_import', 'oworganic_disable_one_click_import');

function oworganic_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Default', 'oworganic' ),
		'id'            => 'sidebar-default',
		'description'   => esc_html__( 'Add widgets here to appear in your Sidebar.', 'oworganic' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );


	register_sidebar( array(
		'name'          => esc_html__( 'Blog sidebar', 'oworganic' ),
		'id'            => 'blog-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'oworganic' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name' 				=> esc_html__( 'Shop Sidebar', 'oworganic' ),
		'id' 				=> 'shop-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'oworganic' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	));

	register_sidebar( array(
		'name' 				=> esc_html__( 'Shop Filter Sidebar', 'oworganic' ),
		'id' 				=> 'shop-filter-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'oworganic' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	));

	register_sidebar( array(
		'name' 				=> esc_html__( 'Popup Newsletter', 'oworganic' ),
		'id' 				=> 'popup-newsletter',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'oworganic' ),
		'before_widget' => '<aside class="%2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	));

	register_sidebar( array(
		'name' 				=> esc_html__( 'Language Footer', 'oworganic' ),
		'id' 				=> 'language',
		'description'   => esc_html__( 'Add widgets here to appear in your Footer.', 'oworganic' ),
		'before_widget' => '<aside class="%2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="title"><span>',
		'after_title'   => '</span></h2>',
	));

	register_sidebar( array(
		'name' 				=> esc_html__( 'Header Mobile Bottom', 'oworganic' ),
		'id' 				=> 'header-mobile-bottom',
		'description'   => esc_html__( 'Add widgets here to appear in your header mobile.', 'oworganic' ),
		'before_widget' => '<aside class="%2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="title"><span>',
		'after_title'   => '</span></h2>',
	));
}
add_action( 'widgets_init', 'oworganic_widgets_init' );

function oworganic_get_load_plugins() {

	$plugins[] = array(
		'name'                     => esc_html__( 'Apus Framework For Themes', 'oworganic' ),
        'slug'                     => 'apus-framework',
        'required'                 => true ,
        'source'				   => get_template_directory() . '/inc/plugins/apus-framework.zip'
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'Elementor Page Builder', 'oworganic' ),
	    'slug'                     => 'elementor',
	    'required'                 => true,
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'Revolution Slider', 'oworganic' ),
        'slug'                     => 'revslider',
        'required'                 => true ,
        'source'				   => get_template_directory() . '/inc/plugins/revslider.zip'
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'Cmb2', 'oworganic' ),
	    'slug'                     => 'cmb2',
	    'required'                 => true,
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'MailChimp for WordPress', 'oworganic' ),
	    'slug'                     => 'mailchimp-for-wp',
	    'required'                 =>  true
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'Contact Form 7', 'oworganic' ),
	    'slug'                     => 'contact-form-7',
	    'required'                 => true,
	);

	// woocommerce plugins
	$plugins[] = array(
		'name'                     => esc_html__( 'Woocommerce', 'oworganic' ),
	    'slug'                     => 'woocommerce',
	    'required'                 => true,
	);

	$plugins[] = array(
        'name'     				   => esc_html__( 'WPC Smart Wishlist for WooCommerce', 'oworganic' ),
        'slug'     				   => 'woo-smart-wishlist',
        'required' 				   => false,
    );
    
    $plugins[] = array(
        'name'     				   => esc_html__( 'WPC Smart Compare for WooCommerce', 'oworganic' ),
        'slug'     				   => 'woo-smart-compare',
        'required' 				   => false,
    );
    
	$plugins[] = array(
		'name'                     => esc_html__( 'Apus Salespopup', 'oworganic' ),
        'slug'                     => 'apus-salespopup',
        'required'                 => true ,
        'source'				   => get_template_directory() . '/inc/plugins/apus-salespopup.zip'
	);

	$plugins[] = array(
        'name'                  => esc_html__( 'One Click Demo Import', 'oworganic' ),
        'slug'                  => 'one-click-demo-import',
        'required'              => false,
    );

	$config = array(
        'id'           => 'oworganic', 
        'default_path' => '', 
        'menu'         => 'tgmpa-install-plugins', 
        'has_notices'  => true, 
        'dismissable'  => true, 
        'dismiss_msg'  => '',  
        'is_automatic' => false, 
        'message'      => '', 
        'strings'      => array(
            'bulk_install' => esc_html__( 'Install Selected Plugins', 'oworganic' ),
        ),
    );

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'oworganic_get_load_plugins' );

require get_template_directory() . '/inc/plugins/class-tgm-plugin-activation.php';
require get_template_directory() . '/inc/functions-helper.php';
require get_template_directory() . '/inc/functions-frontend.php';

/**
 * Implement the Custom Header feature.
 *
 */
require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/classes/megamenu.php';
require get_template_directory() . '/inc/classes/mobilemenu.php';
require get_template_directory() . '/inc/classes/mobileverticalmenu.php';

/**
 * Custom template tags for this theme.
 *
 */
require get_template_directory() . '/inc/template-tags.php';

if ( defined( 'APUS_FRAMEWORK_REDUX_ACTIVED' ) ) {
	require get_template_directory() . '/inc/vendors/redux-framework/redux-config.php';
	define( 'OWORGANIC_REDUX_FRAMEWORK_ACTIVED', true );
}
if( oworganic_is_cmb2_activated() ) {
	require get_template_directory() . '/inc/vendors/cmb2/page.php';
	require get_template_directory() . '/inc/vendors/cmb2/product.php';
	define( 'OWORGANIC_CMB2_ACTIVED', true );
}
if( oworganic_is_woocommerce_activated() ) {
	require get_template_directory() . '/inc/vendors/woocommerce/functions.php';
	require get_template_directory() . '/inc/vendors/woocommerce/functions-search.php';
	require get_template_directory() . '/inc/vendors/woocommerce/functions-redux-configs.php';
	require get_template_directory() . '/inc/vendors/woocommerce/functions-swatches.php';
	require get_template_directory() . '/inc/vendors/woocommerce/functions-brand.php';
	require get_template_directory() . '/inc/vendors/woocommerce/functions-categories.php';
	define( 'OWORGANIC_WOOCOMMERCE_ACTIVED', true );

	if ( oworganic_is_dokan_activated() ) {
		require get_template_directory() . '/inc/vendors/dokan/functions.php';
		require get_template_directory() . '/inc/vendors/dokan/functions-redux-configs.php';
	}
}

if( oworganic_is_apus_framework_activated() ) {
	function oworganic_init_widgets() {
		require get_template_directory() . '/inc/widgets/custom_menu.php';
		require get_template_directory() . '/inc/widgets/popup_newsletter.php';
		require get_template_directory() . '/inc/widgets/recent_post.php';
		require get_template_directory() . '/inc/widgets/search.php';
		require get_template_directory() . '/inc/widgets/socials.php';

		if( oworganic_is_woocommerce_activated() ) {
			require get_template_directory() . '/inc/widgets/woo-price-filter.php';
			require get_template_directory() . '/inc/widgets/woo-product-sorting.php';
			require get_template_directory() . '/inc/widgets/woo-layered-nav.php';
		}
	}
	add_action( 'widgets_init', 'oworganic_init_widgets' );
	define( 'OWORGANIC_FRAMEWORK_ACTIVED', true );
}


require get_template_directory() . '/inc/vendors/elementor/functions.php';
require get_template_directory() . '/inc/vendors/one-click-demo-import/functions.php';

function oworganic_register_post_types($post_types) {
	foreach ($post_types as $key => $post_type) {
		if ( $post_type == 'brand' || $post_type == 'testimonial' ) {
			unset($post_types[$key]);
		}
	}
	if ( !in_array('header', $post_types) ) {
		$post_types[] = 'header';
	}
	return $post_types;
}
add_filter( 'apus_framework_register_post_types', 'oworganic_register_post_types' );


/**
 * Customizer additions.
 *
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom Styles
 *
 */
require get_template_directory() . '/inc/custom-styles.php';