<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the main content area and all content after.
 *
 * @package Saadibazaar_Theme
 * @since 1.0.0
 */
?>

    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="container">
            <?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3')) : ?>
                <div class="footer-widgets">
                    <?php if (is_active_sidebar('footer-1')) : ?>
                        <div class="footer-widget-area">
                            <?php dynamic_sidebar('footer-1'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (is_active_sidebar('footer-2')) : ?>
                        <div class="footer-widget-area">
                            <?php dynamic_sidebar('footer-2'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (is_active_sidebar('footer-3')) : ?>
                        <div class="footer-widget-area">
                            <?php dynamic_sidebar('footer-3'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="site-info">
                <p>
                    <?php
                    printf(
                        /* translators: 1: Theme name, 2: Theme author. */
                        __('&copy; %1$s %2$s. Powered by %3$s', 'saadibazaar-theme'),
                        date('Y'),
                        get_bloginfo('name'),
                        '<a href="https://wordpress.org/" rel="nofollow">WordPress</a>'
                    );
                    ?>
                </p>
                <p>
                    <?php
                    printf(
                        /* translators: 1: Theme name, 2: Theme author. */
                        __('Theme: %1$s by %2$s', 'saadibazaar-theme'),
                        'Saadibazaar Theme',
                        '<a href="https://saadibazaar.ir/" rel="nofollow">Saadibazaar Team</a>'
                    );
                    ?>
                </p>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>