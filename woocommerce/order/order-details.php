<?php
/**
 * Order details table shown in emails and account pages.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * @package Saadibazaar_Theme
 * @since 1.0.0
 */

defined('ABSPATH') || exit;

$order = wc_get_order($order_id);

if (!$order) {
    return;
}

$order_items           = $order->get_items(apply_filters('woocommerce_purchase_order_item_types', 'line_item'));
$show_purchase_note    = $order->has_status(apply_filters('woocommerce_purchase_note_order_statuses', array('completed', 'processing')));
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
$downloads             = $order->get_downloadable_items();
$show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();

if ($show_downloads) {
    wc_get_template(
        'order/order-downloads.php',
        array(
            'downloads'  => $downloads,
            'show_title' => true,
        )
    );
}
?>

<section class="woocommerce-order-details">
    <div class="order-details-header">
        <h2 class="woocommerce-order-details__title"><?php esc_html_e('Order details', 'saadibazaar-theme'); ?></h2>
        <div class="order-meta">
            <span class="order-number">
                <?php printf(__('Order #%s', 'saadibazaar-theme'), $order->get_order_number()); ?>
            </span>
            <span class="order-date">
                <?php printf(__('placed on %s', 'saadibazaar-theme'), wc_format_datetime($order->get_date_created())); ?>
            </span>
            <span class="order-status">
                <?php printf(__('Status: %s', 'saadibazaar-theme'), wc_get_order_status_name($order->get_status())); ?>
            </span>
        </div>
    </div>

    <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
        <thead>
            <tr>
                <th class="woocommerce-table__product-name product-name"><?php esc_html_e('Product', 'saadibazaar-theme'); ?></th>
                <th class="woocommerce-table__product-table product-total"><?php esc_html_e('Total', 'saadibazaar-theme'); ?></th>
            </tr>
        </thead>

        <tbody>
            <?php
            do_action('woocommerce_order_details_before_order_table_items', $order);

            foreach ($order_items as $item_id => $item) {
                $product = $item->get_product();

                wc_get_template(
                    'order/order-details-item.php',
                    array(
                        'order'              => $order,
                        'item_id'            => $item_id,
                        'item'               => $item,
                        'show_purchase_note' => $show_purchase_note,
                        'purchase_note'      => $product ? $product->get_purchase_note() : '',
                        'product'            => $product,
                    )
                );
            }

            do_action('woocommerce_order_details_after_order_table_items', $order);
            ?>
        </tbody>

        <tfoot>
            <?php
            foreach ($order->get_order_item_totals() as $key => $total) {
                ?>
                <tr>
                    <th scope="row"><?php echo esc_html($total['label']); ?></th>
                    <td><?php echo ('payment_method' === $key) ? esc_html($total['value']) : wp_kses_post($total['value']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
                </tr>
                <?php
            }
            ?>
            <?php if ($order->get_customer_note()) : ?>
                <tr>
                    <th><?php esc_html_e('Note:', 'saadibazaar-theme'); ?></th>
                    <td><?php echo wp_kses_post(nl2br(wptexturize($order->get_customer_note()))); ?></td>
                </tr>
            <?php endif; ?>
        </tfoot>
    </table>

    <?php do_action('woocommerce_order_details_after_order_table', $order); ?>

    <div class="order-actions">
        <?php if ($order->has_status('completed') && $order->get_billing_email()) : ?>
            <a href="<?php echo esc_url(wp_nonce_url(add_query_arg('print_order', $order->get_id()), 'print_order')); ?>" 
               class="button print-order" target="_blank">
                <?php _e('Print Order', 'saadibazaar-theme'); ?>
            </a>
        <?php endif; ?>
        
        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="button continue-shopping">
            <?php _e('Continue Shopping', 'saadibazaar-theme'); ?>
        </a>
    </div>
</section>

<style>
.order-details-header {
    background: #f8f9fa;
    padding: 30px;
    border-radius: 8px;
    margin-bottom: 30px;
    text-align: center;
}

.woocommerce-order-details__title {
    font-size: 28px;
    margin-bottom: 20px;
    color: #333;
}

.order-meta {
    display: flex;
    justify-content: center;
    gap: 30px;
    flex-wrap: wrap;
    color: #666;
}

.order-meta span {
    font-size: 14px;
    padding: 8px 16px;
    background: white;
    border-radius: 4px;
    border: 1px solid #ddd;
}

.order-status {
    background: #2c5aa0 !important;
    color: white !important;
    border-color: #2c5aa0 !important;
}

.woocommerce-table--order-details {
    background: white;
    border: 1px solid #eee;
    border-radius: 8px;
    overflow: hidden;
}

.woocommerce-table--order-details th {
    background: #f8f9fa;
    padding: 20px;
    font-weight: bold;
    color: #333;
}

.woocommerce-table--order-details td {
    padding: 20px;
    border-bottom: 1px solid #eee;
}

.woocommerce-table--order-details tfoot th {
    background: white;
    font-weight: bold;
}

.woocommerce-table--order-details tfoot .order-total th,
.woocommerce-table--order-details tfoot .order-total td {
    background: #2c5aa0;
    color: white;
    font-size: 18px;
    font-weight: bold;
}

.order-actions {
    display: flex;
    gap: 15px;
    justify-content: center;
    margin-top: 30px;
}

.order-actions .button {
    background: #2c5aa0;
    color: white;
    padding: 12px 24px;
    border-radius: 4px;
    text-decoration: none;
    font-weight: bold;
    transition: background-color 0.3s;
}

.order-actions .button:hover {
    background: #1a3b6b;
}

.continue-shopping {
    background: #666 !important;
}

.continue-shopping:hover {
    background: #333 !important;
}

@media (max-width: 768px) {
    .order-meta {
        flex-direction: column;
        gap: 10px;
    }
    
    .order-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .order-actions .button {
        width: 100%;
        max-width: 300px;
        text-align: center;
    }
}
</style>

<?php
/**
 * Action hook fired after the order details.
 *
 * @param WC_Order $order Order data.
 */
do_action('woocommerce_order_details_after_order_table', $order);