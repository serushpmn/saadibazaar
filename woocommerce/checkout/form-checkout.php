<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * @package Saadibazaar_Theme
 * @since 1.0.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'saadibazaar-theme')));
    return;
}
?>

<div class="checkout-wrapper">
    <div class="checkout-header">
        <h1 class="checkout-title"><?php _e('Checkout', 'saadibazaar-theme'); ?></h1>
        <p class="checkout-description"><?php _e('Complete your purchase', 'saadibazaar-theme'); ?></p>
    </div>

    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

        <div class="checkout-form-wrapper">
            <div class="checkout-billing-shipping">
                <?php if ($checkout->get_checkout_fields()) : ?>

                    <?php do_action('woocommerce_checkout_before_customer_details'); ?>

                    <div class="customer-details" id="customer_details">
                        <div class="billing-fields">
                            <?php do_action('woocommerce_checkout_billing'); ?>
                        </div>

                        <div class="shipping-fields">
                            <?php do_action('woocommerce_checkout_shipping'); ?>
                        </div>
                    </div>

                    <?php do_action('woocommerce_checkout_after_customer_details'); ?>

                <?php endif; ?>
            </div>

            <div class="checkout-order-review">
                <div class="order-review-wrapper">
                    <h3 id="order_review_heading"><?php esc_html_e('Your order', 'saadibazaar-theme'); ?></h3>

                    <?php do_action('woocommerce_checkout_before_order_review'); ?>

                    <div id="order_review" class="woocommerce-checkout-review-order">
                        <?php do_action('woocommerce_checkout_order_review'); ?>
                    </div>

                    <?php do_action('woocommerce_checkout_after_order_review'); ?>

                    <div class="checkout-trust-signals">
                        <div class="trust-signal">
                            <span class="trust-icon">🔒</span>
                            <span class="trust-text"><?php _e('Secure SSL encryption', 'saadibazaar-theme'); ?></span>
                        </div>
                        <div class="trust-signal">
                            <span class="trust-icon">🚚</span>
                            <span class="trust-text"><?php _e('Free shipping available', 'saadibazaar-theme'); ?></span>
                        </div>
                        <div class="trust-signal">
                            <span class="trust-icon">↩️</span>
                            <span class="trust-text"><?php _e('Easy returns', 'saadibazaar-theme'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>

<style>
.checkout-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
}

.checkout-header {
    text-align: center;
    margin-bottom: 40px;
    padding-bottom: 20px;
    border-bottom: 2px solid #eee;
}

.checkout-title {
    font-size: 32px;
    margin-bottom: 10px;
    color: #333;
}

.checkout-description {
    color: #666;
    font-size: 16px;
}

.checkout-form-wrapper {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 60px;
    margin-top: 40px;
}

.customer-details {
    display: grid;
    gap: 40px;
}

.billing-fields h3,
.shipping-fields h3 {
    font-size: 24px;
    margin-bottom: 20px;
    color: #333;
    padding-bottom: 10px;
    border-bottom: 2px solid #2c5aa0;
}

.order-review-wrapper {
    background: #f8f9fa;
    padding: 30px;
    border-radius: 8px;
    border: 1px solid #eee;
    position: sticky;
    top: 20px;
}

#order_review_heading {
    font-size: 24px;
    margin-bottom: 20px;
    color: #333;
    text-align: center;
}

.checkout-trust-signals {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #ddd;
}

.trust-signal {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    color: #666;
    font-size: 14px;
}

.trust-icon {
    margin-right: 10px;
    font-size: 16px;
}

@media (max-width: 768px) {
    .checkout-form-wrapper {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .order-review-wrapper {
        position: relative;
        top: auto;
    }
}
</style>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>