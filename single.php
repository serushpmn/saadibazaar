<?php
/**
 * The template for displaying all single posts
 *
 * @package Saadibazaar_Theme
 * @since 1.0.0
 */

get_header(); ?>

<div class="site-content">
    <div class="container clearfix">
        <main class="content-area">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                        <div class="entry-meta">
                            <span class="posted-on">
                                <?php echo get_the_date(); ?>
                            </span>
                            <span class="byline">
                                <?php _e('by', 'saadibazaar-theme'); ?> 
                                <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                    <?php the_author(); ?>
                                </a>
                            </span>
                            <?php if (has_category()) : ?>
                                <span class="cat-links">
                                    <?php _e('in', 'saadibazaar-theme'); ?> 
                                    <?php the_category(', '); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </header>

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="entry-content">
                        <?php
                        the_content();
                        
                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . __('Pages:', 'saadibazaar-theme'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>

                    <footer class="entry-footer">
                        <?php if (has_tag()) : ?>
                            <div class="tag-links">
                                <strong><?php _e('Tags:', 'saadibazaar-theme'); ?></strong>
                                <?php the_tags('', ', ', ''); ?>
                            </div>
                        <?php endif; ?>
                    </footer>
                </article>

                <?php
                // Navigation between posts
                the_post_navigation(array(
                    'prev_text' => __('Previous Post', 'saadibazaar-theme'),
                    'next_text' => __('Next Post', 'saadibazaar-theme'),
                ));
                ?>

                <?php if (comments_open() || get_comments_number()) : ?>
                    <div class="comments-section">
                        <?php comments_template(); ?>
                    </div>
                <?php endif; ?>

            <?php endwhile; ?>
        </main>

        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>