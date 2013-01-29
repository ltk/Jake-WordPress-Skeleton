<?php
/**
Custom Thumbnail Sizes
*/
$custom_thumbnail_sizes = array(
  // array(
  //   'name' => 'big-thumbnail',
  //   'width' => 226,
  //   'height' => 181,
  //   'crop' => true
  // ),
  // array(
  //   'name' => 'small-thumbnail',
  //   'width' => 159,
  //   'height' => 97,
  //   'crop' => true
  // ),
  // array(
  //   'name' => 'tiny-thumbnail',
  //   'width' => 83,
  //   'height' => 83,
  //   'crop' => true
  // ),
  // array(
  //   'name' => 'large-panel',
  //   'width' => 560,
  //   'height' => 225,
  //   'crop' => true
  // ),
  // array(
  //   'name' => 'small-panel',
  //   'width' => 200,
  //   'height' => 225,
  //   'crop' => true
  // )
);

if( ! empty( $custom_thumbnail_sizes ) ) {
  foreach( $custom_thumbnail_sizes as $custom_size ) {
    add_image_size( $custom_size['name'], $custom_size['width'], $custom_size['height'], $custom_size['crop'] );  
  }
}

/**
Registering Custom Widgets
*/
function jake_widgets_init() {
  register_widget('Jake_Social_Widget');
}

add_action('widgets_init', 'jake_widgets_init');

/**
Registering Widget Areas
*/
function register_custom_widget_areas() {
  // register_sidebar(array(
  //   'name' => __('Footer Social Nav', 'roots'),
  //   'id' => 'footer-social-nav'
  // ));
}
add_action('widgets_init', 'register_custom_widget_areas');


/**
Social Widget
*/
class Jake_Social_Widget extends WP_Widget {
  function flush_widget_cache() {
    wp_cache_delete('Jake_Social_Widget', 'widget');
  }
  
  function Jake_Social_Widget() {
    $widget_ops = array('classname' => 'Jake_Social_Widget', 'description' => __('This widget displays links to Facebook, Twitter, Linkedin and a mailing list sign up form.', 'roots'));
    $this->WP_Widget('Jake_Social_Widget', __('Social Media Widget', 'roots'), $widget_ops);
    $this->alt_option_name = 'Jake_Social_Widget';

    add_action('save_post', array(&$this, 'flush_widget_cache'));
    add_action('deleted_post', array(&$this, 'flush_widget_cache'));
    add_action('switch_theme', array(&$this, 'flush_widget_cache'));
  }

  function widget($args, $instance) {
    $this->facebook = isset( $instance[ 'facebook' ] )  ? esc_attr( $instance[ 'facebook' ] )   : false;
    $this->twitter  = isset( $instance[ 'twitter' ] )   ? esc_attr( $instance[ 'twitter' ] )  : false;
    $this->linkedin = isset( $instance[ 'linkedin' ] )  ? esc_attr( $instance[ 'linkedin' ] ) : false;

?>
      <ul class="social-media-links horizontal-list">
        <?php if ( $this->facebook ) { ?>
        <li>
          <a href="<?php echo $this->facebook; ?>" target="_blank" title="Visit Us on Facebook">
            <img src="/assets/img/icon-facebook.png" alt="Facebook" />
          </a>
        </li>
        <?php } 
          if ( $this->twitter ) { ?>
        <li>
          <a href="<?php echo $this->twitter; ?>" target="_blank" title="Visit Us on Twitter">
            <img src="/assets/img/icon-twitter.png" alt="Twitter" />
          </a>
        </li>
        <?php } 
          if ( $this->linkedin ) { ?>
        <li>
          <a href="<?php echo $this->linkedin; ?>" target="_blank" title="Visit Us on LinkedIn">
            <img src="/assets/img/icon-linkedin.png" alt="LinkedIn" />
          </a>
        </li>
        <?php } ?>
      </ul> 
<?php
  }

  function update( $new_instance, $old_instance ) {
    $instance             = $old_instance;
    $instance[ 'facebook' ] = strip_tags( $new_instance[ 'facebook' ] );
    $instance[ 'twitter' ]  = strip_tags( $new_instance[ 'twitter' ] );
    $instance[ 'linkedin' ] = strip_tags( $new_instance[ 'linkedin' ] );

    $this->flush_widget_cache();

    $alloptions = wp_cache_get( 'alloptions', 'options' );
    if ( isset( $alloptions[ 'Jake_Social_Widget' ] ) ) {
      delete_option( 'Jake_Social_Widget' );
    }

    return $instance;
  }

  function form($instance) {
    $facebook = isset( $instance[ 'facebook'  ]) ? esc_attr( $instance[ 'facebook' ] ) : '';
    $twitter  = isset( $instance[ 'twitter' ] )  ? esc_attr( $instance[ 'twitter' ] )  : '';
    $linkedin = isset( $instance[ 'linkedin' ] ) ? esc_attr( $instance[ 'linkedin' ] ) : '';

  ?>
    <p>
      <label for="<?php echo esc_attr($this->get_field_id('facebook')); ?>"><?php _e('Facebook:', 'roots'); ?></label>
      <input class="widefat" id="<?php echo esc_attr($this->get_field_id('facebook')); ?>" name="<?php echo esc_attr($this->get_field_name('facebook')); ?>" type="text" value="<?php echo esc_attr($facebook); ?>" />
    </p>

    <p>
      <label for="<?php echo esc_attr($this->get_field_id('twitter')); ?>"><?php _e('Twitter:', 'roots'); ?></label>
      <input class="widefat" id="<?php echo esc_attr($this->get_field_id('twitter')); ?>" name="<?php echo esc_attr($this->get_field_name('twitter')); ?>" type="text" value="<?php echo esc_attr($twitter); ?>" />
    </p>

    <p>
      <label for="<?php echo esc_attr($this->get_field_id('linkedin')); ?>"><?php _e('LinkedIn:', 'roots'); ?></label>
      <input class="widefat" id="<?php echo esc_attr($this->get_field_id('linkedin')); ?>" name="<?php echo esc_attr($this->get_field_name('linkedin')); ?>" type="text" value="<?php echo esc_attr($linkedin); ?>" />
    </p>
  <?php
  }
}

/**
Post 2 Post Relationship Registration
*/

function register_p2p_custom_connection_types() {
  // p2p_register_connection_type( array(
  //     'name' => 'homepage_boxes_to_page',
  //     'from' => 'homepage-boxes',
  //     'to' => 'page',
  //     'sortable' => 'any'
  //   )
  // );

  // p2p_register_connection_type( array(
  //     'name' => 'homepage_banners_to_page',
  //     'from' => 'homepage-banners',
  //     'to' => 'page',
  //     'sortable' => 'any'
  //   )
  // );

  // p2p_register_connection_type( array(
  //     'name' => 'faq_to_page',
  //     'from' => 'faq',
  //     'to' => 'page',
  //     'sortable' => 'any'
  //   )
  // );
}

add_action('init', 'register_p2p_custom_connection_types');

/**
Post 2 Post Only Show Homepage Boxes Connection Box on Homepage
*/
function restrict_p2p_box_display( $show, $ctype, $post ) {
  // if ( 'homepage_boxes_to_page' == $ctype->name ) {
  //   return ( 'frontpage.php' == $post->page_template );
  // }

  // if ( 'homepage_banners_to_page' == $ctype->name ) {
  //   return ( 'frontpage.php' == $post->page_template );
  // }

  // if ( 'faq_to_page' == $ctype->name ) {
  //   return ( 'page-faqs.php' == $post->page_template );
  // }

  return $show;
}

add_filter( 'p2p_admin_box_show', 'restrict_p2p_box_display', 10, 3 );

/**
BugHerd Toolbar
 */
function bugherd_toolbar() {
  if( $_ENV["WP_DEBUG"] ) {
      echo "<script type='text/javascript'>//Bugherd script goes here.</script>";
  }
}

add_action('wp_head', 'bugherd_toolbar');