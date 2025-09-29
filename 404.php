<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Saadibazaar_Theme
 * @since 1.0.0
 */

get_header(); ?>

<div class="site-content">
    <div class="container clearfix">
        <main class="content-area">
            <section class="error-404 not-found">
                <header class="page-header">
                    <h1 class="page-title"><?php _e('Oops! That page can&rsquo;t be found.', 'saadibazaar-theme'); ?></h1>
                </header>

                <div class="page-content">
                    <p><?php _e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'saadibazaar-theme'); ?></p>

                    <?php get_search_form(); ?>

                    <?php if (is_active_sidebar('sidebar-1')) : ?>
                        <div class="widget-area">
                            <h2><?php _e('Most Used Categories', 'saadibazaar-theme'); ?></h2>
                            <ul>
                                <?php
                                wp_list_categories(array(
                                    'orderby'    => 'count',
                                    'order'      => 'DESC',
                                    'show_count' => 1,
                                    'title_li'   => '',
                                    'number'     => 10,
                                ));
                                ?>
                            </ul>
                        </div>

                        <?php
                        $archive_content = '<p>' . sprintf(__('Try looking in the monthly archives. %1$s', 'saadibazaar-theme'), convert_smilies(':)')) . '</p>';
                        the_widget('WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content");
                        ?>

                        <?php the_widget('WP_Widget_Tag_Cloud'); ?>
                    <?php endif; ?>
                </div>
            </section>
        </main>

        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>