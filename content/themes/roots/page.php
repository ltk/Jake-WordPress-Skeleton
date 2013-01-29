<?php
global $show_call_to_action;
global $show_news_items;
global $show_faqs;
?>
<div id="main" class="container relative <?php echo has_post_thumbnail( $post->ID ) ? '' : 'fallback-image'; ?>">
    <aside id="sidebar" class="secondary-column" role="complementary">
        <?php get_template_part('templates/sidebar'); ?>
    </aside>
    <div class="primary-column">
        <?php get_template_part('templates/content', 'page'); ?>
        <?php if( $show_call_to_action ) get_template_part('templates/page', 'call-to-action'); ?>
        <?php if( $show_news_items ) get_template_part('templates/page', 'news-items'); ?>
        <?php if( $show_faqs ) get_template_part('templates/page', 'faqs'); ?>
    </div>
</div>