<?php
/**
 * Enqueue scripts and styles
 *
 * This file handles all CSS and JavaScript enqueuing for the theme.
 *
 * @package Saadibazaar_Theme
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue scripts and styles for the front end
 */
function saadibazaar_scripts() {
    // Enqueue main theme stylesheet (contains all imports including fonts)
    wp_enqueue_style(
        'saadibazaar-style',
        get_stylesheet_uri(),
        array(),
        SAADIBAZAAR_THEME_VERSION
    );

    // Enqueue JavaScript
    wp_enqueue_script(
        'saadibazaar-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array('jquery'),
        SAADIBAZAAR_THEME_VERSION,
        true
    );

    // Enqueue comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    // Localize script for AJAX
    wp_localize_script('saadibazaar-main', 'saadibazaar_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('saadibazaar_nonce'),
        'strings'  => array(
            'loading' => __('Loading...', 'saadibazaar-theme'),
            'error'   => __('Something went wrong. Please try again.', 'saadibazaar-theme'),
        ),
    ));

    // Add RTL support
    if (is_rtl()) {
        wp_enqueue_style(
            'saadibazaar-rtl',
            get_template_directory_uri() . '/assets/css/rtl.css',
            array('saadibazaar-style'),
            SAADIBAZAAR_THEME_VERSION
        );
    }
}
add_action('wp_enqueue_scripts', 'saadibazaar_scripts');

/**
 * Enqueue admin scripts and styles
 */
function saadibazaar_admin_scripts($hook) {
    // Only load on theme customizer and relevant admin pages
    if ('customize.php' === $hook || 'themes.php' === $hook) {
        wp_enqueue_style(
            'saadibazaar-admin',
            get_template_directory_uri() . '/assets/css/admin.css',
            array(),
            SAADIBAZAAR_THEME_VERSION
        );

        wp_enqueue_script(
            'saadibazaar-admin',
            get_template_directory_uri() . '/assets/js/admin.js',
            array('jquery', 'customize-preview'),
            SAADIBAZAAR_THEME_VERSION,
            true
        );
    }
}
add_action('admin_enqueue_scripts', 'saadibazaar_admin_scripts');

/**
 * Enqueue editor styles
 */
function saadibazaar_editor_styles() {
    // Add custom fonts to editor
    add_editor_style('assets/css/fonts.css');
    
    // Add theme styles to editor
    add_editor_style('assets/css/editor-style.css');
}
add_action('admin_init', 'saadibazaar_editor_styles');

/**
 * Add preload for custom fonts
 */
function saadibazaar_resource_hints($urls, $relation_type) {
    if (wp_style_is('saadibazaar-style', 'queue') && 'preload' === $relation_type) {
        $urls[] = array(
            'href' => get_template_directory_uri() . '/assets/css/fonts/woff2/KalamehWebFaNum-Regular.woff2',
            'as' => 'font',
            'type' => 'font/woff2',
            'crossorigin',
        );
        $urls[] = array(
            'href' => get_template_directory_uri() . '/assets/css/fonts/woff2/KalamehWebFaNum-Bold.woff2',
            'as' => 'font',
            'type' => 'font/woff2',
            'crossorigin',
        );
    }
    return $urls;
}
add_filter('wp_resource_hints', 'saadibazaar_resource_hints', 10, 2);

/**
 * Remove unnecessary default styles
 */
function saadibazaar_dequeue_scripts() {
    // Remove WordPress block library CSS on frontend if not needed
    if (!is_admin() && !is_customize_preview()) {
        // Uncomment the line below if you don't use Gutenberg blocks on frontend
        // wp_dequeue_style('wp-block-library');
    }
}
add_action('wp_enqueue_scripts', 'saadibazaar_dequeue_scripts', 100);

/**
 * Add inline critical CSS
 */
function saadibazaar_inline_critical_css() {
    // Add critical CSS inline for above-the-fold content
    $critical_css = "
    body{font-family:'KalamehWebFaNum',Tahoma,Arial,sans-serif;direction:rtl;text-align:right}
    .site-header{background:#fff;border-bottom:1px solid #eee;padding:20px 0}
    .container{max-width:1200px;margin:0 auto;padding:0 20px}
    .site-branding{float:right}
    .main-navigation{float:left}
    ";
    
    echo '<style id="saadibazaar-critical-css">' . $critical_css . '</style>';
}
add_action('wp_head', 'saadibazaar_inline_critical_css', 1);

/**
 * Defer non-critical JavaScript
 */
function saadibazaar_defer_scripts($tag, $handle) {
    // Defer non-critical scripts
    if (in_array($handle, array('saadibazaar-main'))) {
        return str_replace(' src', ' defer src', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'saadibazaar_defer_scripts', 10, 2);