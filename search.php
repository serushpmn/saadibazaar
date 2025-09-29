<?php
/**
 * The template for displaying search results pages
 *
 * @package Saadibazaar_Theme
 * @since 1.0.0
 */

get_header(); ?>

<div class="site-content">
    <div class="container clearfix">
        <main class="content-area">
            <header class="page-header">
                <h1 class="page-title">
                    <?php
                    printf(
                        __('Search Results for: %s', 'saadibazaar-theme'),
                        '<span>' . get_search_query() . '</span>'
                    );
                    ?>
                </h1>
            </header>

            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-entry'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium'); ?>
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
                                <span class="post-type">
                                    <?php echo ucfirst(get_post_type()); ?>
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
                    <h2><?php _e('Nothing found', 'saadibazaar-theme'); ?></h2>
                    <p><?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'saadibazaar-theme'); ?></p>
                    <?php get_search_form(); ?>
                </div>
            <?php endif; ?>
        </main>

        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>