<?php
/**
 * The template for displaying WooCommerce pages
 *
 * This template is used as a wrapper for all WooCommerce templates.
 *
 * @package Saadibazaar_Theme
 * @since 1.0.0
 */

get_header(); ?>

<div class="site-content">
    <div class="container clearfix">
        <main class="content-area woocommerce-content">
            <?php woocommerce_content(); ?>
        </main>

        <?php
        // Only show sidebar on shop pages, not on single product or cart/checkout
        if (is_shop() || is_product_category() || is_product_tag()) {
            get_sidebar();
        }
        ?>
    </div>
</div>

<?php get_footer(); ?>