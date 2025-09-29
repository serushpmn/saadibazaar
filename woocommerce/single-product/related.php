<?php
/**
 * Single Product Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * @package Saadibazaar_Theme
 * @since 1.0.0
 */

defined('ABSPATH') || exit;

if ($related_products) : ?>

    <section class="related products">
        <div class="related-products-header">
            <?php
            $heading = apply_filters('woocommerce_product_related_products_heading', __('Related products', 'saadibazaar-theme'));

            if ($heading) :
                ?>
                <h2><?php echo esc_html($heading); ?></h2>
                <p class="related-description"><?php _e('You might also like these products', 'saadibazaar-theme'); ?></p>
            <?php endif; ?>
        </div>

        <?php woocommerce_product_loop_start(); ?>

        <?php foreach ($related_products as $related_product) : ?>

            <?php
            $post_object = get_post($related_product->get_id());

            setup_postdata($GLOBALS['post'] =& $post_object); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found
            ?>

            <li class="related-product-item">
                <div class="product-inner">
                    <a href="<?php echo esc_url($related_product->get_permalink()); ?>" class="product-link">
                        <?php echo $related_product->get_image('medium'); ?>
                        
                        <div class="product-info">
                            <h3 class="product-title"><?php echo esc_html($related_product->get_name()); ?></h3>
                            
                            <div class="product-price">
                                <?php echo $related_product->get_price_html(); ?>
                            </div>
                            
                            <?php if ($related_product->get_rating_count() > 0) : ?>
                                <div class="product-rating">
                                    <?php echo wc_get_rating_html($related_product->get_average_rating()); ?>
                                    <span class="rating-count">(<?php echo $related_product->get_rating_count(); ?>)</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </a>
                    
                    <div class="product-actions">
                        <?php
                        woocommerce_template_loop_add_to_cart();
                        ?>
                    </div>
                </div>
            </li>

        <?php endforeach; ?>

        <?php woocommerce_product_loop_end(); ?>

    </section>

    <style>
    .related.products {
        margin-top: 60px;
        padding-top: 40px;
        border-top: 2px solid #eee;
    }
    
    .related-products-header {
        text-align: center;
        margin-bottom: 40px;
    }
    
    .related-products-header h2 {
        font-size: 28px;
        margin-bottom: 10px;
        color: #333;
    }
    
    .related-description {
        color: #666;
        font-size: 16px;
    }
    
    .related-product-item {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .related-product-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .related-product-item .product-link {
        display: block;
        text-decoration: none;
        color: inherit;
    }
    
    .related-product-item .product-info {
        padding: 20px;
    }
    
    .related-product-item .product-title {
        font-size: 18px;
        margin-bottom: 10px;
        color: #333;
    }
    
    .related-product-item .product-price {
        font-weight: bold;
        color: #2c5aa0;
        margin-bottom: 10px;
    }
    
    .related-product-item .product-actions {
        padding: 0 20px 20px;
    }
    
    .related-product-item .button {
        width: 100%;
        text-align: center;
        background-color: #2c5aa0;
        color: #fff;
        border: none;
        padding: 12px;
        border-radius: 4px;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }
    
    .related-product-item .button:hover {
        background-color: #1a3b6b;
    }
    </style>

    <?php
endif;

wp_reset_postdata();