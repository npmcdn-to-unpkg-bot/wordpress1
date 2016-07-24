<?php
/**
 * Manataray functions and definitions
 */
global $siteUrl;
$siteUrl = site_url();

if (version_compare($GLOBALS['wp_version'], '4.4-alpha', '<')) {
    require get_template_directory() . '/inc/back-compat.php';
}

if (!function_exists('mantaray_setup')) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     *
     * Create your own mantaray_setup() function to override in a child theme.
     *
     * @since Twenty Sixteen 1.0
     */
    function mantaray_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Twenty Sixteen, use a find and replace
         * to change 'mantaray' to the name of your theme in all the template files
         */
        load_theme_textdomain('mantaray', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for custom logo.
         *
         *  @since Twenty Sixteen 1.2
         */
        add_theme_support('custom-logo', array(
            'height' => 240,
            'width' => 240,
            'flex-height' => true,
        ));

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(1200, 9999);

        // This theme uses wp_nav_menu() in two locations.
        register_nav_menus(array(
            'primary' => __('Primary Menu', 'mantaray'),
            'social' => __('Social Links Menu', 'mantaray'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        /*
         * Enable support for Post Formats.
         *
         * See: https://codex.wordpress.org/Post_Formats
         */
        add_theme_support('post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
            'gallery',
            'status',
            'audio',
            'chat',
        ));

        /*
         * This theme styles the visual editor to resemble the theme style,
         * specifically font, colors, icons, and column width.
         */
        add_editor_style(array('css/editor-style.css', mantaray_fonts_url()));

        // Indicate widget sidebars can use selective refresh in the Customizer.
        add_theme_support('customize-selective-refresh-widgets');
    }

endif; // mantaray_setup
add_action('after_setup_theme', 'mantaray_setup');

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since Twenty Sixteen 1.0
 */
function mantaray_content_width() {
  //  $GLOBALS['content_width'] = apply_filters('mantaray_content_width', 840);
}

add_action('after_setup_theme', 'mantaray_content_width', 0);

/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since Twenty Sixteen 1.0
 */
function mantaray_widgets_init() {
    register_sidebar(array(
        'name' => __('Sidebar', 'mantaray'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here to appear in your sidebar.', 'mantaray'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => __('Content Bottom 1', 'mantaray'),
        'id' => 'sidebar-2',
        'description' => __('Appears at the bottom of the content on posts and pages.', 'mantaray'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => __('Content Bottom 2', 'mantaray'),
        'id' => 'sidebar-3',
        'description' => __('Appears at the bottom of the content on posts and pages.', 'mantaray'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}

add_action('widgets_init', 'mantaray_widgets_init');

if (!function_exists('mantaray_fonts_url')) :

    /**
     * Register Google fonts for Twenty Sixteen.
     *
     * Create your own mantaray_fonts_url() function to override in a child theme.
     *
     * @since Twenty Sixteen 1.0
     *
     * @return string Google fonts URL for the theme.
     */
    function mantaray_fonts_url() {
        $fonts_url = '';
        $fonts = array();
        $subsets = 'latin,latin-ext';

        /* translators: If there are characters in your language that are not supported by Merriweather, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Merriweather font: on or off', 'mantaray')) {
            $fonts[] = 'Merriweather:400,700,900,400italic,700italic,900italic';
        }

        /* translators: If there are characters in your language that are not supported by Montserrat, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Montserrat font: on or off', 'mantaray')) {
            $fonts[] = 'Montserrat:400,700';
        }

        /* translators: If there are characters in your language that are not supported by Inconsolata, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Inconsolata font: on or off', 'mantaray')) {
            $fonts[] = 'Inconsolata:400';
        }

        if ($fonts) {
            $fonts_url = add_query_arg(array(
                'family' => urlencode(implode('|', $fonts)),
                'subset' => urlencode($subsets),
                    ), 'https://fonts.googleapis.com/css');
        }

        return $fonts_url;
    }

endif;

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Sixteen 1.0
 */
function mantaray_javascript_detection() {
    echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}

add_action('wp_head', 'mantaray_javascript_detection', 0);

/**
 * Enqueues scripts and styles.
 */
function mantaray_scripts() {
    // Add custom fonts, style and scripts.
    wp_enqueue_style('mantaray-fonts', mantaray_fonts_url(), array(), null);

    // Add all stylesheets.
    wp_enqueue_style('genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.4.1');
    wp_enqueue_style('flex-slider', get_template_directory_uri() . '/css/flexslider.css');
    wp_enqueue_style('google-fonts', 'http://fonts.googleapis.com/css?family=PT+Sans:400,700');
    wp_enqueue_style('jquery-ui', get_template_directory_uri() . '/css/jquery-ui.css');
    wp_enqueue_style('bxslider', get_template_directory_uri() . '/css/jquery.bxslider.css');
    wp_enqueue_style('fancybox', get_template_directory_uri() . '/css/jquery.fancybox.css');
    wp_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css');
    wp_enqueue_style('fullcalendar-css', get_stylesheet_directory_uri() . '/css/fullcalendar.min.css');
    wp_enqueue_script('moments', get_stylesheet_directory_uri() . '/js/moment.min.js', ['jquery'], '2.7.3', true);
    wp_enqueue_script('fullcalendar-js', get_stylesheet_directory_uri() . '/js/fullcalendar.min.js', ['jquery', 'moments'], '2.7.3', true);


    // Theme stylesheet.
    wp_enqueue_style('mantaray-style', get_stylesheet_uri());

    // Load the Internet Explorer specific stylesheet.
    wp_enqueue_style('mantaray-ie', get_template_directory_uri() . '/css/ie.css', array('mantaray-style'), '20160412');
    wp_style_add_data('mantaray-ie', 'conditional', 'lt IE 10');

    // Load the Internet Explorer 8 specific stylesheet.
    wp_enqueue_style('mantaray-ie8', get_template_directory_uri() . '/css/ie8.css', array('mantaray-style'), '20160412');
    wp_style_add_data('mantaray-ie8', 'conditional', 'lt IE 9');

    // Load the Internet Explorer 7 specific stylesheet.
    wp_enqueue_style('mantaray-ie7', get_template_directory_uri() . '/css/ie7.css', array('mantaray-style'), '20160412');
    wp_style_add_data('mantaray-ie7', 'conditional', 'lt IE 8');

    // Load the html5 shiv.
    wp_enqueue_script('mantaray-html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3');
    wp_script_add_data('mantaray-html5', 'conditional', 'lt IE 9');

    wp_enqueue_script('mantaray-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20160412', true);

    wp_enqueue_script('flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js');
    wp_enqueue_script('mantaray-slideshow', get_template_directory_uri() . '/js/slideshow.js', array('jquery'));
    wp_enqueue_script('jquery-ui', get_template_directory_uri() . '/js/jquery-ui.js', array('jquery'));
    wp_enqueue_script('bx-slider', get_template_directory_uri() . '/js/jquery.bxslider.min.js', array('jquery'));
    wp_enqueue_script('fancybox', get_template_directory_uri() . '/js/jquery.fancybox.js', array('jquery'));
    wp_enqueue_script('masonry', 'https://npmcdn.com/masonry-layout@4.0/dist/masonry.pkgd.min.js', array('jquery'));

//    if (is_page_template(['home-template.php','availability.php', 'reservation.php','sidebar.php'])) {
    wp_enqueue_script('validation', get_template_directory_uri() . '/js/jquery.validate.min.js', array('jquery'));
    // }

    if (is_page_template('reservation.php')) {
        wp_enqueue_script('additional-validation', get_template_directory_uri() . '/js/additional-methods.min.js', array('jquery'));
    }

    wp_enqueue_script('mantaray-custom-js', get_template_directory_uri() . '/js/custom.js', array('jquery'), 1, true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    if (is_singular() && wp_attachment_is_image()) {
        wp_enqueue_script('mantaray-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array('jquery'), '20160412');
    }

    wp_enqueue_script('mantaray-script', get_template_directory_uri() . '/js/functions.js', array('jquery'), '20160412', true);

    wp_localize_script('mantaray-script', 'screenReaderText', array(
        'expand' => __('expand child menu', 'mantaray'),
        'collapse' => __('collapse child menu', 'mantaray'),
    ));
}

add_action('wp_enqueue_scripts', 'mantaray_scripts');

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Twenty Sixteen 1.0
 *
 * @param array $classes Classes for the body element.
 * @return array (Maybe) filtered body classes.
 */
function mantaray_body_classes($classes) {
    // Adds a class of custom-background-image to sites with a custom background image.
    if (get_background_image()) {
        $classes[] = 'custom-background-image';
    }

    // Adds a class of group-blog to sites with more than 1 published author.
    if (is_multi_author()) {
        $classes[] = 'group-blog';
    }

    // Adds a class of no-sidebar to sites without active sidebar.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    return $classes;
}

add_filter('body_class', 'mantaray_body_classes');

/**
 * Converts a HEX value to RGB.
 *
 * @since Twenty Sixteen 1.0
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function mantaray_hex2rgb($color) {
    $color = trim($color, '#');

    if (strlen($color) === 3) {
        $r = hexdec(substr($color, 0, 1) . substr($color, 0, 1));
        $g = hexdec(substr($color, 1, 1) . substr($color, 1, 1));
        $b = hexdec(substr($color, 2, 1) . substr($color, 2, 1));
    } else if (strlen($color) === 6) {
        $r = hexdec(substr($color, 0, 2));
        $g = hexdec(substr($color, 2, 2));
        $b = hexdec(substr($color, 4, 2));
    } else {
        return array();
    }

    return array('red' => $r, 'green' => $g, 'blue' => $b);
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @since Twenty Sixteen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function mantaray_content_image_sizes_attr($sizes, $size) {
    $width = $size[0];

    840 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';

    if ('page' === get_post_type()) {
        840 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
    } else {
        840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
        600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
    }

    return $sizes;
}

add_filter('wp_calculate_image_sizes', 'mantaray_content_image_sizes_attr', 10, 2);

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @since Twenty Sixteen 1.0
 *
 * @param array $attr Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function mantaray_post_thumbnail_sizes_attr($attr, $attachment, $size) {
    if ('post-thumbnail' === $size) {
        is_active_sidebar('sidebar-1') && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
        !is_active_sidebar('sidebar-1') && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
    }
    return $attr;
}

add_filter('wp_get_attachment_image_attributes', 'mantaray_post_thumbnail_sizes_attr', 10, 3);

/**
 * Modifies tag cloud widget arguments to have all tags in the widget same font size.
 *
 * @since Twenty Sixteen 1.1
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array A new modified arguments.
 */
function mantaray_widget_tag_cloud_args($args) {
    $args['largest'] = 1;
    $args['smallest'] = 1;
    $args['unit'] = 'em';
    return $args;
}

add_filter('widget_tag_cloud_args', 'mantaray_widget_tag_cloud_args');

// custom code

/* Function name : pdf_posttype
 * Description : Custom post type to add pdf from backend.
 */
function pdf_posttype() {

    // Set UI labels for Custom Post Type
    $labels = array(
        'name' => _x('PDF', 'Post Type General Name', 'mantaray'),
        'singular_name' => _x('PDF', 'Post Type Singular Name', 'mantaray'),
        'menu_name' => __('PDF', 'mantaray'),
        'parent_item_colon' => __('Parent PDF', 'mantaray'),
        'all_items' => __('All PDF', 'mantaray'),
        'view_item' => __('View PDF', 'mantaray'),
        'add_new_item' => __('Add New PDF', 'mantaray'),
        'add_new' => __('Add New', 'mantaray'),
        'edit_item' => __('Edit PDF', 'mantaray'),
        'update_item' => __('Update PDF', 'mantaray'),
        'search_items' => __('Search PDF', 'mantaray'),
        'not_found' => __('Not Found', 'mantaray'),
        'not_found_in_trash' => __('Not found in Trash', 'mantaray'),
    );

    // Set other options for Custom Post Type

    $args = array(
        'label' => __('pdf', 'mantaray'),
        'description' => __('PDF for different languages.', 'mantaray'),
        'labels' => $labels,
        // Features this CPT supports in Post Editor
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'can_export' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'page',
    );

    register_post_type('pdf', $args);
}

// Hooking up our function to theme setup
add_action('init', 'pdf_posttype');


/* Function name : packages_posttype
 * Description : Custom post type to add packages from backend.
 */

function package_posttype() {

    // Set UI labels for Custom Post Type
    $labels = array(
        'name' => _x('Packages', 'Post Type General Name', 'mantaray'),
        'singular_name' => _x('Package', 'Post Type Singular Name', 'mantaray'),
        'menu_name' => __('Packages', 'mantaray'),
        'parent_item_colon' => __('Parent Package', 'mantaray'),
        'all_items' => __('All Packages', 'mantaray'),
        'view_item' => __('View Package', 'mantaray'),
        'add_new_item' => __('Add New Package', 'mantaray'),
        'add_new' => __('Add New', 'mantaray'),
        'edit_item' => __('Edit Package', 'mantaray'),
        'update_item' => __('Update Package', 'mantaray'),
        'search_items' => __('Search Package', 'mantaray'),
        'not_found' => __('Not Found', 'mantaray'),
        'not_found_in_trash' => __('Not found in Trash', 'mantaray'),
    );

    // Set other options for Custom Post Type

    $args = array(
        'label' => __('package', 'mantaray'),
        'description' => __('Package and specials.', 'mantaray'),
        'labels' => $labels,
        // Features this CPT supports in Post Editor
        'supports' => array('title', 'editor', 'thumbnail'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'can_export' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'page',
    );

    register_post_type('package', $args);
}

// Hooking up our function to theme setup
add_action('init', 'package_posttype');


/* Function name : room_posttype
 * Description : Custom post type to add rooms from backend.
 */

function room_posttype() {
    // Set UI labels for Custom Post Type
    $labels = array(
        'name' => _x('Rooms', 'Post Type General Name', 'mantaray'),
        'singular_name' => _x('Room', 'Post Type Singular Name', 'mantaray'),
        'menu_name' => __('Rooms', 'mantaray'),
        'parent_item_colon' => __('Parent Room', 'mantaray'),
        'all_items' => __('All Rooms', 'mantaray'),
        'view_item' => __('View Room', 'mantaray'),
        'add_new_item' => __('Add New Room', 'mantaray'),
        'add_new' => __('Add New', 'mantaray'),
        'edit_item' => __('Edit Room', 'mantaray'),
        'update_item' => __('Update Room', 'mantaray'),
        'search_items' => __('Search Room', 'mantaray'),
        'not_found' => __('Not Found', 'mantaray'),
        'not_found_in_trash' => __('Not found in Trash', 'mantaray'),
    );

    // Set other options for Custom Post Type

    $args = array(
        'label' => __('room', 'mantaray'),
        'description' => __('Guest rooms & Suites.', 'mantaray'),
        'labels' => $labels,
        // Features this CPT supports in Post Editor
        'supports' => array('title', 'editor', 'thumbnail'),
        'taxonomies' => array('room_type'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'can_export' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
    );
    register_post_type('room', $args);
}

$labels = array(
    'name' => _x('Room Types', 'taxonomy general name'),
    'menu_name' => __('Room Types'),
);
register_taxonomy('room_type', 'room', array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array('slug' => 'room_type'),
        )
);

$labels = array(
    'name' => _x('Dive Packages', 'taxonomy general name'),
    'menu_name' => __('Dive Packages')
);
register_taxonomy('dive_packages', 'room', array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array('slug' => 'dive_packages'),
        )
);

$labels = array(
    'name' => _x('Services', 'taxonomy general name'),
    'menu_name' => __('Services')
);

register_taxonomy('services', 'room', array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array('slug' => 'services'),
        )
);

$labels = array(
    'name' => _x('Floor', 'taxonomy general name'),
    'menu_name' => __('Floors')
);

register_taxonomy('floors', 'room', array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array('slug' => 'floors'),
        )
);


// Hooking up our function to theme setup
add_action('init', 'room_posttype');


/* Function name : room_posttype
 * Description : Custom post type to add rooms from backend.
 */

function slider_posttype() {
    // Set UI labels for Custom Post Type
    $labels = array(
        'name' => _x('Slider', 'Post Type General Name', 'mantaray'),
        'singular_name' => _x('Slider', 'Post Type Singular Name', 'mantaray'),
        'menu_name' => __('Slider', 'mantaray'),
        'parent_item_colon' => __('Parent Slider', 'mantaray'),
        'all_items' => __('All Images', 'mantaray'),
        'view_item' => __('View Images', 'mantaray'),
        'add_new_item' => __('Add New Image', 'mantaray'),
        'add_new' => __('Add New', 'mantaray'),
        'edit_item' => __('Edit Image', 'mantaray'),
        'update_item' => __('Update Image', 'mantaray'),
        'search_items' => __('Search Image', 'mantaray'),
        'not_found' => __('Not Found', 'mantaray'),
        'not_found_in_trash' => __('Not found in Trash', 'mantaray'),
    );

    // Set other options for Custom Post Type

    $args = array(
        'label' => __('slider', 'mantaray'),
        'description' => __('Front page slider', 'mantaray'),
        'labels' => $labels,
        // Features this CPT supports in Post Editor
        'supports' => array('title'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'can_export' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'page',
    );

    register_post_type('slider', $args);
}

// Hooking up our function to theme setup
add_action('init', 'slider_posttype');


/* Function name : calender_posttype
 * Description : Custom post type to add tide data in the calender from backend.
 */

function calender_posttype() {
    // Set UI labels for Custom Post Type
    $labels = array(
        'name' => _x('Calender', 'Post Type General Name', 'mantaray'),
        'singular_name' => _x('Calender', 'Post Type Singular Name', 'mantaray'),
        'menu_name' => __('Calender', 'mantaray'),
        'parent_item_colon' => __('Parent Calender', 'mantaray'),
        'all_items' => __('All Calender', 'mantaray'),
        'view_item' => __('View Calender', 'mantaray'),
        'add_new_item' => __('Add New Calender', 'mantaray'),
        'add_new' => __('Add New', 'mantaray'),
        'edit_item' => __('Edit Calender', 'mantaray'),
        'update_item' => __('Update Calender', 'mantaray'),
        'search_items' => __('Search Calender', 'mantaray'),
        'not_found' => __('Not Found', 'mantaray'),
        'not_found_in_trash' => __('Not found in Trash', 'mantaray'),
    );

    // Set other options for Custom Post Type

    $args = array(
        'label' => __('calender', 'mantaray'),
        'description' => __('Calender section to show tide table', 'mantaray'),
        'labels' => $labels,
        // Features this CPT supports in Post Editor
        'supports' => array('title', 'editor'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'can_export' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
    );

    register_post_type('calender', $args);
}

// Hooking up our function to theme setup
add_action('init', 'calender_posttype');

/* Function name : wallpaper_posttype
 * Description : Custom post type to add twallpaper from backend.
 */

function wallpaper_posttype() {
    // Set UI labels for Custom Post Type
    $labels = array(
        'name' => _x('Wallpaper', 'Post Type General Name', 'mantaray'),
        'singular_name' => _x('Wallpaper', 'Post Type Singular Name', 'mantaray'),
        'menu_name' => __('Wallpaper', 'mantaray'),
        'parent_item_colon' => __('Parent Wallpaper', 'mantaray'),
        'all_items' => __('All Wallpaper', 'mantaray'),
        'view_item' => __('View Wallpaper', 'mantaray'),
        'add_new_item' => __('Add New Wallpaper', 'mantaray'),
        'add_new' => __('Add New', 'mantaray'),
        'edit_item' => __('Edit Wallpaper', 'mantaray'),
        'update_item' => __('Update Wallpaper', 'mantaray'),
        'search_items' => __('Search Wallpaper', 'mantaray'),
        'not_found' => __('Not Found', 'mantaray'),
        'not_found_in_trash' => __('Not found in Trash', 'mantaray'),
    );

    // Set other options for Custom Post Type

    $args = array(
        'label' => __('wallpaper', 'mantaray'),
        'description' => __('Wallpaper section', 'mantaray'),
        'labels' => $labels,
        // Features this CPT supports in Post Editor
        'supports' => array('title', 'thumbnail'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 6,
        'can_export' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
    );

    register_post_type('wallpaper', $args);
}

// Hooking up our function to theme setup
add_action('init', 'wallpaper_posttype');

/* Function name : diving_posttype
 * Description : Custom post type to add diving custom posts from backend.
 */

function diving_posttype() {
    // Set UI labels for Custom Post Type
    $labels = array(
        'name' => _x('Diving Sites', 'Post Type General Name', 'mantaray'),
        'singular_name' => _x('Diving Sites', 'Post Type Singular Name', 'mantaray'),
        'menu_name' => __('Diving Sites', 'mantaray'),
        'parent_item_colon' => __('Parent Diving Sites', 'mantaray'),
        'all_items' => __('All Diving Sites', 'mantaray'),
        'view_item' => __('View Diving Sites', 'mantaray'),
        'add_new_item' => __('Add New Diving Sites', 'mantaray'),
        'add_new' => __('Add New', 'mantaray'),
        'edit_item' => __('Edit Diving Sites', 'mantaray'),
        'update_item' => __('Update Diving Sites', 'mantaray'),
        'search_items' => __('Search Diving Sites', 'mantaray'),
        'not_found' => __('Not Found', 'mantaray'),
        'not_found_in_trash' => __('Not found in Trash', 'mantaray'),
    );

    // Set other options for Custom Post Type

    $args = array(
        'label' => __('diving', 'mantaray'),
        'description' => __('Diving Sites section', 'mantaray'),
        'labels' => $labels,
        // Features this CPT supports in Post Editor
        'supports' => array('title','editor','thumbnail'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 7,
        'can_export' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
    );

    register_post_type('diving', $args);
}


// Hooking up our function to theme setup
add_action('init', 'diving_posttype');

// remove default p tag from content

remove_filter('the_content', 'wpautop');

// remove default p tag from custom field plugin content

remove_filter('acf_the_content', 'wpautop');


/* Function name : pdf_content
 * Description : filter content for PDF post types
 */

function pdf_content($content) {
    global $post;

    if ($post->post_type == 'pdf') {
        $old_content = $content;
        $xml_content = new SimpleXMLElement($old_content);
        $content = $xml_content['href'];

        return $content;
    } else {
        return $content;
    }
}

add_filter('the_content', 'pdf_content');



/* Function name : get_gallery_data
 * Description : get gallery data based on id
 */

function get_gallery_data($id = null) {

    global $wpdb, $siteUrl;
    $gallery_result = [];

    $result = $wpdb->get_results('SELECT t1.pid as total,t1.filename,t2.path,t2.title,t2.galdesc,t2.pageid FROM ' . $wpdb->prefix . 'ngg_pictures t1 INNER JOIN ' . $wpdb->prefix . 'ngg_gallery t2 ON  t1.galleryid = t2.gid WHERE t1.galleryid = ' . $id, ARRAY_A);

    $gallery_result['pageId'] = $result[0]['pageid'];
    $gallery_result['imgUrl'] = $siteUrl . '/' . $result[0]['path'] . '/' . $result[0]['filename'];
    $gallery_result['title'] = $result[0]['title'];
    $gallery_result['description'] = $result[0]['galdesc'];
    $gallery_result['count'] = count($result);

    return $gallery_result;
}

/* Function name : get_id_anywhere
 * Description : get id whether from anywhere whether inside or outside the loop.
 */

function get_id_anywhere() {
    if (in_the_loop()) {
        $post_id = get_the_ID();
    } else {
        /** @var $wp_query wp_query */
        global $wp_query;
        $post_id = $wp_query->get_queried_object_id();
    }
    return $post_id;
}

/* Function name : set_data_format
 * Description : set date format for reservation section.
 */

function set_data_format($post_date = null) {

    $reserve_date = [];
    $reserve_date['format'] = date("Y-m-d", strtotime($post_date));
    $date = date("d", strtotime($post_date));
    $time = strtotime($post_date);
    $month = date("F", $time);
    $year = date("Y", $time);
    $reserve_date['show'] = $month . ' ' . $date . ', ' . $year;

    return $reserve_date;
}

/* Function name : get_pdf
 * Description : get PDF for the footer section
 */

function get_pdf() {
    $pdf_args = array('post_type' => 'pdf', 'post_status' => 'publish', 'order' => 'ASC');
    $pdf_array = new WP_Query($pdf_args);
    remove_filter('the_content', 'wpautop');
    while ($pdf_array->have_posts()) : $pdf_array->the_post();
        if (has_post_thumbnail()) {
            echo "<li><a href=";
            the_content();
            echo ">";
            echo get_the_post_thumbnail();
            echo "</a></li>";
        }
    endwhile;
}

// add custom image sizes
add_image_size( 'wallpaper-small',1024,768,false);
add_image_size( 'wallpaper-medium',1280,960,false);
add_image_size( 'wallpaper-large',1600,1200,false);
add_image_size( 'wallpaper-extraLarge',2048,1536,false);

// include menu customization classes
require 'inc/classes/Menu_Customization.php';
require 'inc/classes/custom_nav_walker.php';
require 'inc/classes/mantaray_customizer.php';
