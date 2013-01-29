<?php
$is_active_page = function ( $jpost ) {
  global $active_page_id;
  return ( $jpost->ID == $active_page_id ) ? true : false;
};

J_Post::register_test( 'is_active_page', $is_active_page );
