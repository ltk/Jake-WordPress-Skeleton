<div id="carousel" class="carousel slide relative">
<?php
  $post_list_parameters = array(
    'post_type' => 'homepage-banners',
    'posts_per_page' => -1,
    'connected_type' => 'homepage_banners_to_page',
    'connected_to' => get_queried_object_id(),
    'connected_direction' => 'to'
  );
  $post_list = new J_PostList( $post_list_parameters, array( 'post_format' => 'homepage-banner', 'list_tag' => 'div', 'list_class' => 'carousel-inner homepage-banner-list' ) );
  
  $class_array = array('post0' => 'active');
  $post_list->set_post_classes( $class_array );

  if( $post_list->have_posts() ) {
    echo $post_list->to_html();
  }

  unset($post_list);
?>
  
  <div class="container relative carousel-indicators-container">
    <ul class="carousel-indicators"></ul>
  </div>
</div>
