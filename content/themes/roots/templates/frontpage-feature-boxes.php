<?php
$args_array = array(
    'posts_per_page' => 3,
    'post_type' => 'homepage-boxes',
    'connected_type' => 'homepage_boxes_to_page',
    'connected_to' => get_queried_object_id(),
    'connected_direction' => 'to'
    );

$feature_boxes = new J_PostList( $args_array, array('post_format' => 'feature-box', 'list_tag' => 'div', 'list_class' => 'horizontal-list feature-box-list' ) );
echo $feature_boxes;
unset( $feature_boxes );
?>