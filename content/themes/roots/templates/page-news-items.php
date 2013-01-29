<?php
$paged = get_query_var('paged');

$post_list_parameters = array(
  'post_type' => 'news-items',
  'posts_per_page' => 6,
  'paged' => $paged,
);

$news_items = new J_PostList( $post_list_parameters, array('post_format' => 'news-item', 'list_class' => 'news-item-list horizontal-list') );
echo $news_items->pagination_to_html( $paged );
echo $news_items->to_html();
