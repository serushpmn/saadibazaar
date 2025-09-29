<?php
/**
 * The main template file
 *
 * This is the most generic template file and is used as a fallback
 * when a more specific template is not found.
 *
 * @package Saadibazaar_Theme
 * @since 1.0.0
 */

get_header(); ?>

<div class="site-content">
    <div class="container clearfix">
        <main class="content-area">
            <?php if (have_posts()) : ?>
                <header class="page-header">
                    <?php if (is_home() && !is_front_page()) : ?>
                        <h1 class="page-title"><?php single_post_title(); ?></h1>
                    <?php elseif (is_archive()) : ?>
                        <h1 class="page-title"><?php the_archive_title(); ?></h1>
                        <?php the_archive_description('<div class="archive-description">', '</div>'); ?>
                    <?php elseif (is_search()) : ?>
                        <h1 class="page-title">
                            <?php printf(__('Search Results for: %s', 'saadibazaar-theme'), '<span>' . get_search_query() . '</span>'); ?>
                        </h1>
                    <?php else : ?>
                        <h1 class="page-title"><?php _e('Latest Posts', 'saadibazaar-theme'); ?></h1>
                    <?php endif; ?>
                </header>

                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-entry'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('large'); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <header class="entry-header">
                            <h2 class="entry-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
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
                            </div>
                        </header>

                        <div class="entry-content">
                            <?php the_excerpt(); ?>
                        </div>
                    </article>
                <?php endwhile; ?>

                <?php
                the_posts_pagination(array(
                    'prev_text' => __('Previous', 'saadibazaar-theme'),
                    'next_text' => __('Next', 'saadibazaar-theme'),
                ));
                ?>

            <?php else : ?>
                <div class="no-posts-found">
                    <h2><?php _e('Nothing Found', 'saadibazaar-theme'); ?></h2>
                    <p><?php _e('It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'saadibazaar-theme'); ?></p>
                    <?php get_search_form(); ?>
                </div>
            <?php endif; ?>
        </main>

        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>