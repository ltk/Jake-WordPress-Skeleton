<?php
$button_text = get_post_meta($post->ID, 'wpcf-button-text', true);
$button_link = get_post_meta($post->ID, 'wpcf-button-link', true);

if( ! empty( $button_text ) && ! empty( $button_link ) ){
  $button_text = esc_attr($button_text);
  $button_link = esc_url($button_link );
  echo sprintf('<p class="center"><a class="btn btn-call-to-action" title="%s" href="%s">%s</a></p>',
               $button_text,
               $button_link,
               $button_text
               );
}

