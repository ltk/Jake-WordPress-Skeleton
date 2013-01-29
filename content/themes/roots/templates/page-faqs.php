<?php
$paged = get_query_var('paged');

$post_list_parameters = array(
  'post_type' => 'faq',
  'posts_per_page' => -1,
  'connected_type' => 'faq_to_page',
  'connected_to' => get_queried_object_id(),
  'connected_direction' => 'to'
  
);

$faqs = new J_PostList( $post_list_parameters, array('post_format' => 'faq', 'list_class' => 'faq-list') );
echo $faqs->pagination_to_html( $paged );
echo $faqs->to_html();
