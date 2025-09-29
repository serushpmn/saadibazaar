<?php
/**
 * WooCommerce integration and customizations
 *
 * This file contains all WooCommerce related functionality,
 * hooks, filters, and customizations for the theme.
 *
 * @package Saadibazaar_Theme
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Return if WooCommerce is not active
if (!class_exists('WooCommerce')) {
    return;
}

/**
 * WooCommerce setup and theme support
 */
function saadibazaar_woocommerce_setup() {
    // Declare WooCommerce theme support
    add_theme_support('woocommerce', array(
        'thumbnail_image_width' => 300,
        'single_image_width'    => 600,
        'product_grid' => array(
            'default_rows'    => 4,
            'min_rows'        => 2,
            'default_columns' => 3,
            'min_columns'     => 1,
            'max_columns'     => 6,
        ),
    ));

    // Add support for WC product gallery features
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'saadibazaar_woocommerce_setup');

/**
 * Remove default WooCommerce wrappers
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

/**
 * Add custom WooCommerce wrappers
 */
function saadibazaar_woocommerce_wrapper_start() {
    echo '<div class="woocommerce-wrapper">';
}
add_action('woocommerce_before_main_content', 'saadibazaar_woocommerce_wrapper_start', 10);

function saadibazaar_woocommerce_wrapper_end() {
    echo '</div><!-- .woocommerce-wrapper -->';
}
add_action('woocommerce_after_main_content', 'saadibazaar_woocommerce_wrapper_end', 10);

/**
 * Change number of products per row
 */
function saadibazaar_woocommerce_loop_columns() {
    return get_theme_mod('saadibazaar_products_per_row', 3);
}
add_filter('loop_shop_columns', 'saadibazaar_woocommerce_loop_columns');

/**
 * Change number of products per page
 */
function saadibazaar_woocommerce_products_per_page() {
    return get_theme_mod('saadibazaar_products_per_page', 12);
}
add_filter('loop_shop_per_page', 'saadibazaar_woocommerce_products_per_page', 20);

/**
 * Remove WooCommerce breadcrumbs (we'll add our own)
 */
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

/**
 * Add custom breadcrumbs
 */
function saadibazaar_woocommerce_breadcrumb() {
    if (function_exists('woocommerce_breadcrumb')) {
        woocommerce_breadcrumb(array(
            'delimiter'   => ' <span class="breadcrumb-separator">></span> ',
            'wrap_before' => '<nav class="woocommerce-breadcrumb" aria-label="' . esc_attr__('breadcrumbs', 'saadibazaar-theme') . '">',
            'wrap_after'  => '</nav>',
            'before'      => '',
            'after'       => '',
            'home'        => _x('Home', 'breadcrumb', 'saadibazaar-theme'),
        ));
    }
}
add_action('woocommerce_before_main_content', 'saadibazaar_woocommerce_breadcrumb', 20);

/**
 * Customize WooCommerce product tabs
 */
function saadibazaar_woocommerce_product_tabs($tabs) {
    // Rename tabs
    if (isset($tabs['description'])) {
        $tabs['description']['title'] = __('Product Details', 'saadibazaar-theme');
    }
    
    if (isset($tabs['additional_information'])) {
        $tabs['additional_information']['title'] = __('Specifications', 'saadibazaar-theme');
    }
    
    // Reorder tabs
    if (isset($tabs['reviews'])) {
        $tabs['reviews']['priority'] = 30;
    }
    
    return $tabs;
}
add_filter('woocommerce_product_tabs', 'saadibazaar_woocommerce_product_tabs');

/**
 * Add quantity buttons to product pages
 */
function saadibazaar_add_quantity_buttons() {
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.woocommerce div.product form.cart .quantity').each(function() {
            var $qty = $(this).find('.qty');
            if ($qty.length && !$(this).find('.quantity-controls').length) {
                $(this).append('<div class="quantity-controls"><button type="button" class="minus">-</button><button type="button" class="plus">+</button></div>');
            }
        });
    });
    </script>
    <style>
    .quantity-controls {
        display: inline-block;
        vertical-align: top;
        margin-left: 10px;
    }
    .quantity-controls button {
        background: #2c5aa0;
        color: white;
        border: none;
        width: 30px;
        height: 30px;
        cursor: pointer;
        margin: 0 2px;
        border-radius: 3px;
    }
    .quantity-controls button:hover {
        background: #1a3b6b;
    }
    </style>
    <?php
}
add_action('woocommerce_single_product_summary', 'saadibazaar_add_quantity_buttons', 25);

/**
 * Customize WooCommerce messages
 */
function saadibazaar_woocommerce_add_to_cart_message($message, $product_id) {
    $product = wc_get_product($product_id);
    $message = sprintf(
        '%s <a href="%s" class="button wc-forward">%s</a>',
        sprintf(__('"%s" has been added to your cart.', 'saadibazaar-theme'), $product->get_name()),
        esc_url(wc_get_cart_url()),
        __('View Cart', 'saadibazaar-theme')
    );
    return $message;
}
add_filter('wc_add_to_cart_message', 'saadibazaar_woocommerce_add_to_cart_message', 10, 2);

/**
 * Remove sidebar on single product pages
 */
function saadibazaar_woocommerce_remove_sidebar() {
    if (is_product()) {
        remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
    }
}
add_action('wp', 'saadibazaar_woocommerce_remove_sidebar');

/**
 * Customize shop page title
 */
function saadibazaar_woocommerce_shop_page_title($title) {
    if (is_shop()) {
        $title = get_theme_mod('saadibazaar_shop_title', __('Our Products', 'saadibazaar-theme'));
    }
    return $title;
}
add_filter('woocommerce_page_title', 'saadibazaar_woocommerce_shop_page_title');

/**
 * Add custom fields to product pages
 */
function saadibazaar_woocommerce_product_meta_start() {
    echo '<div class="product-meta-custom">';
}
add_action('woocommerce_single_product_summary', 'saadibazaar_woocommerce_product_meta_start', 21);

function saadibazaar_woocommerce_product_meta_end() {
    global $product;
    
    // Add custom product information
    if ($product->get_sku()) {
        echo '<span class="sku_wrapper">' . __('SKU:', 'saadibazaar-theme') . ' <span class="sku">' . $product->get_sku() . '</span></span>';
    }
    
    // Add stock status
    $availability = $product->get_availability();
    if ($availability['availability']) {
        echo '<span class="stock ' . esc_attr($availability['class']) . '">' . $availability['availability'] . '</span>';
    }
    
    echo '</div><!-- .product-meta-custom -->';
}
add_action('woocommerce_single_product_summary', 'saadibazaar_woocommerce_product_meta_end', 22);

/**
 * Customize related products
 */
function saadibazaar_woocommerce_related_products($args) {
    $args['posts_per_page'] = 4;
    $args['columns'] = 4;
    return $args;
}
add_filter('woocommerce_output_related_products_args', 'saadibazaar_woocommerce_related_products');

/**
 * Add sale badge customization
 */
function saadibazaar_woocommerce_sale_flash($html, $post, $product) {
    if ($product->is_on_sale()) {
        $percentage = '';
        if ($product->get_type() == 'simple' || $product->get_type() == 'external') {
            $regular_price = $product->get_regular_price();
            $sale_price = $product->get_sale_price();
            if ($regular_price && $sale_price) {
                $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
                $percentage = '-' . $percentage . '%';
            }
        }
        
        $html = '<span class="onsale">' . ($percentage ? $percentage : __('Sale!', 'saadibazaar-theme')) . '</span>';
    }
    return $html;
}
add_filter('woocommerce_sale_flash', 'saadibazaar_woocommerce_sale_flash', 10, 3);

/**
 * Customize cart fragments for AJAX add to cart
 */
function saadibazaar_woocommerce_add_to_cart_fragments($fragments) {
    ob_start();
    ?>
    <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
    <?php
    $fragments['span.cart-count'] = ob_get_clean();
    
    ob_start();
    ?>
    <span class="cart-total"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
    <?php
    $fragments['span.cart-total'] = ob_get_clean();
    
    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'saadibazaar_woocommerce_add_to_cart_fragments');

/**
 * Add cart icon to navigation
 */
function saadibazaar_add_cart_icon_to_nav($items, $args) {
    if ($args->theme_location == 'primary' && class_exists('WooCommerce')) {
        $cart_count = WC()->cart->get_cart_contents_count();
        $cart_url = wc_get_cart_url();
        
        $cart_icon = '<li class="menu-item-cart">
            <a href="' . esc_url($cart_url) . '" class="cart-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12L8.1 13h7.45c.75 0 1.41-.41 1.75-1.03L21.7 4H5.21l-.94-2H1zm16 16c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                </svg>
                <span class="cart-count">' . $cart_count . '</span>
            </a>
        </li>';
        
        $items .= $cart_icon;
    }
    
    return $items;
}
add_filter('wp_nav_menu_items', 'saadibazaar_add_cart_icon_to_nav', 10, 2);

/**
 * Enqueue WooCommerce specific styles
 */
function saadibazaar_woocommerce_styles() {
    if (is_woocommerce() || is_cart() || is_checkout() || is_account_page()) {
        wp_enqueue_style(
            'saadibazaar-woocommerce',
            get_template_directory_uri() . '/assets/css/woocommerce.css',
            array('saadibazaar-style'),
            SAADIBAZAAR_THEME_VERSION
        );
    }
}
add_action('wp_enqueue_scripts', 'saadibazaar_woocommerce_styles');