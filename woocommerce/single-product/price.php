<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * @package Saadibazaar_Theme
 * @since 1.0.0
 */

defined('ABSPATH') || exit;

global $product;

?>
<div class="price-wrapper">
    <?php echo $product->get_price_html(); ?>
    
    <?php if ($product->is_on_sale() && $product->get_type() !== 'variable') : ?>
        <?php
        $regular_price = $product->get_regular_price();
        $sale_price = $product->get_sale_price();
        
        if ($regular_price && $sale_price) {
            $discount_percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
            echo '<span class="discount-percentage">' . sprintf(__('Save %s%%', 'saadibazaar-theme'), $discount_percentage) . '</span>';
        }
        ?>
    <?php endif; ?>
</div>