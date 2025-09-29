<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * @package Saadibazaar_Theme
 * @since 1.0.0
 */

defined('ABSPATH') || exit;
?>

<div class="woocommerce-order">

    <?php
    if ($order) :

        do_action('woocommerce_before_thankyou', $order->get_id());
        ?>

        <div class="thankyou-header">
            <?php if ($order->has_status('failed')) : ?>
                <div class="order-failed">
                    <h1 class="thankyou-title failed"><?php _e('Order Failed', 'saadibazaar-theme'); ?></h1>
                    <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed">
                        <?php _e('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'saadibazaar-theme'); ?>
                    </p>
                    <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
                        <a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>" class="button pay"><?php _e('Pay', 'saadibazaar-theme'); ?></a>
                        <?php if (is_user_logged_in()) : ?>
                            <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="button pay"><?php _e('My account', 'saadibazaar-theme'); ?></a>
                        <?php endif; ?>
                    </p>
                </div>

            <?php else : ?>
                <div class="order-success">
                    <div class="success-icon">✅</div>
                    <h1 class="thankyou-title success"><?php _e('Thank you for your order!', 'saadibazaar-theme'); ?></h1>
                    <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">
                        <?php echo apply_filters('woocommerce_thankyou_order_received_text', __('Thank you. Your order has been received.', 'saadibazaar-theme'), $order); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </p>
                </div>

                <div class="order-summary-card">
                    <h2><?php _e('Order Summary', 'saadibazaar-theme'); ?></h2>
                    
                    <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">
                        <li class="woocommerce-order-overview__order order">
                            <strong><?php _e('Order number:', 'saadibazaar-theme'); ?></strong>
                            <span><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                        </li>

                        <li class="woocommerce-order-overview__date date">
                            <strong><?php _e('Date:', 'saadibazaar-theme'); ?></strong>
                            <span><?php echo wc_format_datetime($order->get_date_created()); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                        </li>

                        <?php if (is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email()) : ?>
                            <li class="woocommerce-order-overview__email email">
                                <strong><?php _e('Email:', 'saadibazaar-theme'); ?></strong>
                                <span><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                            </li>
                        <?php endif; ?>

                        <li class="woocommerce-order-overview__total total">
                            <strong><?php _e('Total:', 'saadibazaar-theme'); ?></strong>
                            <span><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                        </li>

                        <?php if ($order->get_payment_method_title()) : ?>
                            <li class="woocommerce-order-overview__payment-method method">
                                <strong><?php _e('Payment method:', 'saadibazaar-theme'); ?></strong>
                                <span><?php echo wp_kses_post($order->get_payment_method_title()); ?></span>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>

                <?php if ($order->has_status('processing')) : ?>
                    <div class="processing-notice">
                        <h3><?php _e('What happens next?', 'saadibazaar-theme'); ?></h3>
                        <ul>
                            <li><?php _e('We will process your order within 1-2 business days', 'saadibazaar-theme'); ?></li>
                            <li><?php _e('You will receive a shipping confirmation email with tracking information', 'saadibazaar-theme'); ?></li>
                            <li><?php _e('Your order will be delivered to the address provided', 'saadibazaar-theme'); ?></li>
                        </ul>
                    </div>
                <?php endif; ?>

            <?php endif; ?>

            <div class="thankyou-actions">
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="button continue-shopping">
                    <?php _e('Continue Shopping', 'saadibazaar-theme'); ?>
                </a>
                
                <?php if (is_user_logged_in()) : ?>
                    <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="button view-account">
                        <?php _e('View Account', 'saadibazaar-theme'); ?>
                    </a>
                <?php endif; ?>
                
                <?php if ($order->has_status(array('processing', 'completed'))) : ?>
                    <a href="<?php echo esc_url($order->get_view_order_url()); ?>" class="button view-order">
                        <?php _e('View Order Details', 'saadibazaar-theme'); ?>
                    </a>
                <?php endif; ?>
            </div>

        </div>

        <?php do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id()); ?>
        <?php do_action('woocommerce_thankyou', $order->get_id()); ?>

    <?php else : ?>
        <div class="order-not-found">
            <h1><?php _e('Order not found', 'saadibazaar-theme'); ?></h1>
            <p class="woocommerce-notice woocommerce-notice--error">
                <?php _e('Sorry, this order is invalid and cannot be displayed.', 'saadibazaar-theme'); ?>
            </p>
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="button">
                <?php _e('Return to Shop', 'saadibazaar-theme'); ?>
            </a>
        </div>
    <?php endif; ?>

</div>

<style>
.thankyou-header {
    text-align: center;
    max-width: 800px;
    margin: 0 auto;
    padding: 40px 20px;
}

.order-success {
    background: #f0f8f0;
    padding: 40px;
    border-radius: 12px;
    border: 2px solid #28a745;
    margin-bottom: 40px;
}

.success-icon {
    font-size: 48px;
    margin-bottom: 20px;
}

.thankyou-title.success {
    font-size: 36px;
    color: #28a745;
    margin-bottom: 20px;
}

.thankyou-title.failed {
    font-size: 36px;
    color: #dc3545;
    margin-bottom: 20px;
}

.order-failed {
    background: #fff5f5;
    padding: 40px;
    border-radius: 12px;
    border: 2px solid #dc3545;
    margin-bottom: 40px;
}

.order-summary-card {
    background: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    margin-bottom: 40px;
}

.order-summary-card h2 {
    font-size: 24px;
    margin-bottom: 20px;
    color: #333;
    text-align: center;
    padding-bottom: 15px;
    border-bottom: 2px solid #eee;
}

.woocommerce-order-overview {
    list-style: none;
    margin: 0;
    padding: 0;
}

.woocommerce-order-overview li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid #eee;
}

.woocommerce-order-overview li:last-child {
    border-bottom: none;
}

.woocommerce-order-overview li.total {
    background: #f8f9fa;
    margin: 15px -30px 0;
    padding: 20px 30px;
    border-radius: 8px;
    font-size: 18px;
    font-weight: bold;
    color: #2c5aa0;
}

.processing-notice {
    background: #fff8e1;
    padding: 30px;
    border-radius: 8px;
    border-left: 4px solid #ff9800;
    margin-bottom: 30px;
}

.processing-notice h3 {
    color: #e65100;
    margin-bottom: 15px;
}

.processing-notice ul {
    list-style: none;
    padding: 0;
}

.processing-notice li {
    padding: 8px 0;
    position: relative;
    padding-left: 25px;
}

.processing-notice li:before {
    content: "✓";
    position: absolute;
    left: 0;
    color: #ff9800;
    font-weight: bold;
}

.thankyou-actions {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 40px;
}

.thankyou-actions .button {
    background: #2c5aa0;
    color: white;
    padding: 15px 30px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: bold;
    font-size: 16px;
    transition: all 0.3s;
    border: none;
    cursor: pointer;
}

.thankyou-actions .button:hover {
    background: #1a3b6b;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(44, 90, 160, 0.3);
}

.continue-shopping {
    background: #28a745 !important;
}

.continue-shopping:hover {
    background: #1e7e34 !important;
}

.view-account {
    background: #666 !important;
}

.view-account:hover {
    background: #333 !important;
}

.order-not-found {
    text-align: center;
    padding: 60px 20px;
}

.order-not-found h1 {
    color: #dc3545;
    margin-bottom: 20px;
}

@media (max-width: 768px) {
    .thankyou-header {
        padding: 20px;
    }
    
    .thankyou-title.success,
    .thankyou-title.failed {
        font-size: 28px;
    }
    
    .success-icon {
        font-size: 36px;
    }
    
    .order-summary-card,
    .order-success,
    .order-failed {
        padding: 20px;
    }
    
    .woocommerce-order-overview li {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
    
    .thankyou-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .thankyou-actions .button {
        width: 100%;
        max-width: 300px;
    }
}
</style>