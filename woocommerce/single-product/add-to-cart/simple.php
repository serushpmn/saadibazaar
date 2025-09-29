<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * @package Saadibazaar_Theme
 * @since 1.0.0
 */

defined('ABSPATH') || exit;

global $product;

if (!$product->is_purchasable()) {
    return;
}

echo wc_get_stock_html($product); // WPCS: XSS ok.

if ($product->is_in_stock()) : ?>

    <?php do_action('woocommerce_before_add_to_cart_form'); ?>

    <form class="cart" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data'>
        <div class="add-to-cart-wrapper">
            <?php do_action('woocommerce_before_add_to_cart_button'); ?>

            <?php
            do_action('woocommerce_before_add_to_cart_quantity');

            woocommerce_quantity_input(
                array(
                    'min_value'   => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
                    'max_value'   => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
                    'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
                )
            );

            do_action('woocommerce_after_add_to_cart_quantity');
            ?>

            <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="single_add_to_cart_button button alt">
                <span class="add-to-cart-text"><?php echo esc_html($product->single_add_to_cart_text()); ?></span>
                <span class="loading-spinner" style="display: none;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" opacity="0.25"/>
                        <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                    </svg>
                </span>
            </button>

            <?php do_action('woocommerce_after_add_to_cart_button'); ?>
        </div>
    </form>

    <?php do_action('woocommerce_after_add_to_cart_form'); ?>

    <div class="product-trust-signals">
        <div class="trust-signal">
            <span class="trust-icon">🚚</span>
            <span class="trust-text"><?php _e('Free shipping on orders over $50', 'saadibazaar-theme'); ?></span>
        </div>
        <div class="trust-signal">
            <span class="trust-icon">🔒</span>
            <span class="trust-text"><?php _e('Secure checkout', 'saadibazaar-theme'); ?></span>
        </div>
        <div class="trust-signal">
            <span class="trust-icon">↩️</span>
            <span class="trust-text"><?php _e('Easy returns', 'saadibazaar-theme'); ?></span>
        </div>
    </div>

<?php endif; ?>