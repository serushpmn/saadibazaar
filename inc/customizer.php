<?php
/**
 * Theme Customizer functionality
 *
 * This file contains all customizer settings and controls
 * for theme customization options.
 *
 * @package Saadibazaar_Theme
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 */
function saadibazaar_customize_register($wp_customize) {
    // Add theme options panel
    $wp_customize->add_panel('saadibazaar_theme_options', array(
        'title'       => __('Theme Options', 'saadibazaar-theme'),
        'description' => __('Customize your theme settings', 'saadibazaar-theme'),
        'priority'    => 30,
    ));

    // ===== COLORS SECTION =====
    $wp_customize->add_section('saadibazaar_colors', array(
        'title'    => __('Theme Colors', 'saadibazaar-theme'),
        'panel'    => 'saadibazaar_theme_options',
        'priority' => 10,
    ));

    // Primary Color
    $wp_customize->add_setting('saadibazaar_primary_color', array(
        'default'           => '#c7a343',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'saadibazaar_primary_color', array(
        'label'    => __('Primary Color', 'saadibazaar-theme'),
        'section'  => 'saadibazaar_colors',
        'settings' => 'saadibazaar_primary_color',
    )));

    // Secondary Color
    $wp_customize->add_setting('saadibazaar_secondary_color', array(
        'default'           => '#001e47',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'saadibazaar_secondary_color', array(
        'label'    => __('Secondary Color', 'saadibazaar-theme'),
        'section'  => 'saadibazaar_colors',
        'settings' => 'saadibazaar_secondary_color',
    )));

    // Text Color
    $wp_customize->add_setting('saadibazaar_text_color', array(
        'default'           => '#1c1c1c',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'saadibazaar_text_color', array(
        'label'    => __('Text Color', 'saadibazaar-theme'),
        'section'  => 'saadibazaar_colors',
        'settings' => 'saadibazaar_text_color',
    )));

    // ===== TYPOGRAPHY SECTION =====
    $wp_customize->add_section('saadibazaar_typography', array(
        'title'    => __('Typography', 'saadibazaar-theme'),
        'panel'    => 'saadibazaar_theme_options',
        'priority' => 20,
    ));

    // Font Family
    $wp_customize->add_setting('saadibazaar_font_family', array(
        'default'           => 'kalamehwebfanum',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('saadibazaar_font_family', array(
        'label'    => __('Font Family', 'saadibazaar-theme'),
        'section'  => 'saadibazaar_typography',
        'type'     => 'select',
        'choices'  => array(
            'kalamehwebfanum' => 'KalamehWebFaNum',
            'Inter'      => 'Inter',
            'Roboto'     => 'Roboto',
            'Open Sans'  => 'Open Sans',
            'Lato'       => 'Lato',
            'Montserrat' => 'Montserrat',
            'Poppins'    => 'Poppins',
        ),
    ));

    // Font Size
    $wp_customize->add_setting('saadibazaar_font_size', array(
        'default'           => '16',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('saadibazaar_font_size', array(
        'label'       => __('Base Font Size (px)', 'saadibazaar-theme'),
        'section'     => 'saadibazaar_typography',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 12,
            'max'  => 24,
            'step' => 1,
        ),
    ));

    // ===== LAYOUT SECTION =====
    $wp_customize->add_section('saadibazaar_layout', array(
        'title'    => __('Layout Options', 'saadibazaar-theme'),
        'panel'    => 'saadibazaar_theme_options',
        'priority' => 30,
    ));

    // Container Width
    $wp_customize->add_setting('saadibazaar_container_width', array(
        'default'           => '1200',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('saadibazaar_container_width', array(
        'label'       => __('Container Width (px)', 'saadibazaar-theme'),
        'section'     => 'saadibazaar_layout',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 960,
            'max'  => 1400,
            'step' => 10,
        ),
    ));

    // Sidebar Position
    $wp_customize->add_setting('saadibazaar_sidebar_position', array(
        'default'           => 'right',
        'sanitize_callback' => 'saadibazaar_sanitize_select',
    ));

    $wp_customize->add_control('saadibazaar_sidebar_position', array(
        'label'   => __('Sidebar Position', 'saadibazaar-theme'),
        'section' => 'saadibazaar_layout',
        'type'    => 'radio',
        'choices' => array(
            'left'  => __('Left', 'saadibazaar-theme'),
            'right' => __('Right', 'saadibazaar-theme'),
        ),
    ));

    // ===== WOOCOMMERCE SECTION =====
    if (class_exists('WooCommerce')) {
        $wp_customize->add_section('saadibazaar_woocommerce', array(
            'title'    => __('WooCommerce Settings', 'saadibazaar-theme'),
            'panel'    => 'saadibazaar_theme_options',
            'priority' => 40,
        ));

        // Products per row
        $wp_customize->add_setting('saadibazaar_products_per_row', array(
            'default'           => '3',
            'sanitize_callback' => 'absint',
        ));

        $wp_customize->add_control('saadibazaar_products_per_row', array(
            'label'   => __('Products per Row', 'saadibazaar-theme'),
            'section' => 'saadibazaar_woocommerce',
            'type'    => 'select',
            'choices' => array(
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
            ),
        ));

        // Products per page
        $wp_customize->add_setting('saadibazaar_products_per_page', array(
            'default'           => '12',
            'sanitize_callback' => 'absint',
        ));

        $wp_customize->add_control('saadibazaar_products_per_page', array(
            'label'       => __('Products per Page', 'saadibazaar-theme'),
            'section'     => 'saadibazaar_woocommerce',
            'type'        => 'number',
            'input_attrs' => array(
                'min'  => 4,
                'max'  => 48,
                'step' => 4,
            ),
        ));

        // Show sidebar on shop pages
        $wp_customize->add_setting('saadibazaar_shop_sidebar', array(
            'default'           => true,
            'sanitize_callback' => 'wp_validate_boolean',
        ));

        $wp_customize->add_control('saadibazaar_shop_sidebar', array(
            'label'   => __('Show Sidebar on Shop Pages', 'saadibazaar-theme'),
            'section' => 'saadibazaar_woocommerce',
            'type'    => 'checkbox',
        ));
    }

    // ===== FOOTER SECTION =====
    $wp_customize->add_section('saadibazaar_footer', array(
        'title'    => __('Footer Settings', 'saadibazaar-theme'),
        'panel'    => 'saadibazaar_theme_options',
        'priority' => 50,
    ));

    // Footer Text
    $wp_customize->add_setting('saadibazaar_footer_text', array(
        'default'           => __('&copy; 2024 Your Website. All rights reserved.', 'saadibazaar-theme'),
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('saadibazaar_footer_text', array(
        'label'   => __('Footer Copyright Text', 'saadibazaar-theme'),
        'section' => 'saadibazaar_footer',
        'type'    => 'textarea',
    ));

    // Show Footer Widgets
    $wp_customize->add_setting('saadibazaar_show_footer_widgets', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('saadibazaar_show_footer_widgets', array(
        'label'   => __('Show Footer Widgets', 'saadibazaar-theme'),
        'section' => 'saadibazaar_footer',
        'type'    => 'checkbox',
    ));

    // Make site title and tagline live preview
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';

    // Make header text color live preview
    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial('blogname', array(
            'selector'        => '.site-title a',
            'render_callback' => 'saadibazaar_customize_partial_blogname',
        ));
        $wp_customize->selective_refresh->add_partial('blogdescription', array(
            'selector'        => '.site-description',
            'render_callback' => 'saadibazaar_customize_partial_blogdescription',
        ));
    }
}
add_action('customize_register', 'saadibazaar_customize_register');

/**
 * Render the site title for the selective refresh partial.
 */
function saadibazaar_customize_partial_blogname() {
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 */
function saadibazaar_customize_partial_blogdescription() {
    bloginfo('description');
}

/**
 * Sanitize select fields
 */
function saadibazaar_sanitize_select($input, $setting) {
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control($setting->id)->choices;
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}

/**
 * Enqueue customizer preview scripts
 */
function saadibazaar_customize_preview_js() {
    wp_enqueue_script(
        'saadibazaar-customizer',
        get_template_directory_uri() . '/assets/js/customizer.js',
        array('customize-preview'),
        SAADIBAZAAR_THEME_VERSION,
        true
    );
}
add_action('customize_preview_init', 'saadibazaar_customize_preview_js');

/**
 * Output customizer styles
 */
function saadibazaar_customizer_css() {
    $primary_color = get_theme_mod('saadibazaar_primary_color', '#c7a343');
    $secondary_color = get_theme_mod('saadibazaar_secondary_color', '#001e47');
    $text_color = get_theme_mod('saadibazaar_text_color', '#1c1c1c');
    $font_family = get_theme_mod('saadibazaar_font_family', 'kalamehwebfanum');
    $font_size = get_theme_mod('saadibazaar_font_size', '16');
    $container_width = get_theme_mod('saadibazaar_container_width', '1200');
    
    $css = "
    :root {
        --primary-color: {$primary_color};
        --secondary-color: {$secondary_color};
        --text-color: {$text_color};
        --font-family: '{$font_family}', sans-serif;
        --font-size: {$font_size}px;
        --container-width: {$container_width}px;
    }
    
    body {
        font-family: var(--font-family);
        font-size: var(--font-size);
        color: var(--text-color);
    }
    
    .container {
        max-width: var(--container-width);
    }
    
    a, .site-title, .main-navigation a:hover,
    .woocommerce ul.products li.product .price,
    .woocommerce div.product .summary .price {
        color: var(--primary-color);
    }
    
    .btn-primary, .button, .woocommerce .button,
    .woocommerce ul.products li.product .button {
        background-color: var(--primary-color);
    }
    
    .btn-primary:hover, .button:hover, .woocommerce .button:hover,
    .woocommerce ul.products li.product .button:hover,
    a:hover {
        background-color: var(--secondary-color);
        color: var(--secondary-color);
    }
    ";
    
    wp_add_inline_style('saadibazaar-style', $css);
}
add_action('wp_enqueue_scripts', 'saadibazaar_customizer_css');