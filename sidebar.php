<?php
/**
 * The sidebar template
 *
 * Contains the primary widget area.
 *
 * @package Saadibazaar_Theme
 * @since 1.0.0
 */

if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>

<aside id="secondary" class="sidebar-area widget-area">
    <?php dynamic_sidebar('sidebar-1'); ?>
</aside>