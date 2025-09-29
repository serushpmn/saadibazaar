<?php
/**
 * Functions and definitions for Saadibazaar Theme
 *
 * This file includes all theme setup functions and loads required files.
 *
 * @package Saadibazaar_Theme
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define theme constants
define('SAADIBAZAAR_THEME_VERSION', '1.0.0');
define('SAADIBAZAAR_THEME_DIR', get_template_directory());
define('SAADIBAZAAR_THEME_URL', get_template_directory_uri());

/**
 * Load all required theme files
 */
require_once SAADIBAZAAR_THEME_DIR . '/inc/setup.php';
require_once SAADIBAZAAR_THEME_DIR . '/inc/enqueue.php';
require_once SAADIBAZAAR_THEME_DIR . '/inc/customizer.php';
require_once SAADIBAZAAR_THEME_DIR . '/inc/woocommerce.php';

/**
 * After setup theme hook
 */
function saadibazaar_after_setup_theme() {
    // Make theme available for translation
    load_theme_textdomain('saadibazaar-theme', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'saadibazaar_after_setup_theme');

/**
 * Widgets initialization
 */
function saadibazaar_widgets_init() {
    register_sidebar(array(
        'name'          => __('Primary Sidebar', 'saadibazaar-theme'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here to appear in your sidebar.', 'saadibazaar-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Widget 1', 'saadibazaar-theme'),
        'id'            => 'footer-1',
        'description'   => __('Add widgets here to appear in the first footer widget area.', 'saadibazaar-theme'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Widget 2', 'saadibazaar-theme'),
        'id'            => 'footer-2',
        'description'   => __('Add widgets here to appear in the second footer widget area.', 'saadibazaar-theme'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Widget 3', 'saadibazaar-theme'),
        'id'            => 'footer-3',
        'description'   => __('Add widgets here to appear in the third footer widget area.', 'saadibazaar-theme'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'saadibazaar_widgets_init');

/**
 * Custom excerpt length
 */
function saadibazaar_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'saadibazaar_excerpt_length');

/**
 * Custom excerpt more link
 */
function saadibazaar_excerpt_more($more) {
    return ' <a href="' . get_permalink() . '" class="read-more">' . __('Read More', 'saadibazaar-theme') . '</a>';
}
add_filter('excerpt_more', 'saadibazaar_excerpt_more');