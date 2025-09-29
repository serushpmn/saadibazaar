<?php
/**
 * Theme setup functions
 *
 * This file contains all theme setup functionality including
 * theme supports, image sizes, menus, and other core features.
 *
 * @package Saadibazaar_Theme
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Set up theme defaults and registers support for various WordPress features.
 */
function saadibazaar_setup() {
    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title.
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support('post-thumbnails');

    // Set default thumbnail size
    set_post_thumbnail_size(300, 200, true);

    // Add additional image sizes
    add_image_size('saadibazaar-featured', 800, 400, true);
    add_image_size('saadibazaar-grid', 400, 300, true);
    add_image_size('saadibazaar-small', 150, 150, true);

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'saadibazaar-theme'),
        'footer'  => __('Footer Menu', 'saadibazaar-theme'),
    ));

    // Switch default core markup to output valid HTML5.
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Add theme support for Custom Logo.
    add_theme_support('custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ));

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for custom background
    add_theme_support('custom-background', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    ));

    // Add support for custom header
    add_theme_support('custom-header', array(
        'default-image'      => '',
        'default-text-color' => '000',
        'width'              => 1200,
        'height'             => 300,
        'flex-height'        => true,
        'flex-width'         => true,
    ));

    // Add WooCommerce support
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    // Add support for responsive embeds
    add_theme_support('responsive-embeds');

    // Add support for wide alignment
    add_theme_support('align-wide');

    // Add support for editor styles
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');

    // Set content width
    global $content_width;
    if (!isset($content_width)) {
        $content_width = 800;
    }
}
add_action('after_setup_theme', 'saadibazaar_setup');

/**
 * Default menu fallback
 */
function saadibazaar_default_menu() {
    echo '<ul id="primary-menu" class="menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . __('Home', 'saadibazaar-theme') . '</a></li>';
    
    if (class_exists('WooCommerce')) {
        echo '<li><a href="' . esc_url(wc_get_page_permalink('shop')) . '">' . __('Shop', 'saadibazaar-theme') . '</a></li>';
        echo '<li><a href="' . esc_url(wc_get_cart_url()) . '">' . __('Cart', 'saadibazaar-theme') . '</a></li>';
        echo '<li><a href="' . esc_url(wc_get_account_endpoint_url('dashboard')) . '">' . __('My Account', 'saadibazaar-theme') . '</a></li>';
    }
    
    // Show pages in menu if no menu is set
    $pages = get_pages(array('number' => 5, 'sort_column' => 'menu_order'));
    foreach ($pages as $page) {
        echo '<li><a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html($page->post_title) . '</a></li>';
    }
    
    echo '</ul>';
}

/**
 * Add custom image sizes to media library
 */
function saadibazaar_custom_image_sizes($sizes) {
    return array_merge($sizes, array(
        'saadibazaar-featured' => __('Featured Image', 'saadibazaar-theme'),
        'saadibazaar-grid'     => __('Grid Image', 'saadibazaar-theme'),
        'saadibazaar-small'    => __('Small Thumbnail', 'saadibazaar-theme'),
    ));
}
add_filter('image_size_names_choose', 'saadibazaar_custom_image_sizes');

/**
 * Custom excerpt length for different contexts
 */
function saadibazaar_custom_excerpt_length($length) {
    if (is_admin()) {
        return $length;
    }
    
    if (is_home() || is_archive()) {
        return 25;
    } elseif (is_search()) {
        return 15;
    }
    
    return $length;
}
add_filter('excerpt_length', 'saadibazaar_custom_excerpt_length', 999);

/**
 * Add body classes for different page types
 */
function saadibazaar_body_classes($classes) {
    // Add class for WooCommerce pages
    if (class_exists('WooCommerce')) {
        if (is_woocommerce() || is_cart() || is_checkout()) {
            $classes[] = 'woocommerce-page';
        }
        
        if (is_shop()) {
            $classes[] = 'woocommerce-shop';
        }
        
        if (is_product()) {
            $classes[] = 'woocommerce-product';
        }
    }
    
    // Add class for pages with sidebar
    if (is_active_sidebar('sidebar-1') && !is_page_template('page-fullwidth.php')) {
        $classes[] = 'has-sidebar';
    } else {
        $classes[] = 'no-sidebar';
    }
    
    return $classes;
}
add_filter('body_class', 'saadibazaar_body_classes');

/**
 * Pingback header
 */
function saadibazaar_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'saadibazaar_pingback_header');