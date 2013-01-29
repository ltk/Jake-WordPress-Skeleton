<?php while (have_posts()) : the_post(); ?>
  <?php
    if ( has_post_thumbnail() ) {
        the_post_thumbnail( 'full', 'banner' );
    } else {
        // Fallback to the thumbnail on the homepage
        echo "<img class='banner' src='" . get_bloginfo('template_url') . "/assets/img/page-header.jpg' alt='Yoga del Sol' title='Yoga del Sol' />";
    }
  ?>
  <h1><?php the_title(); ?></h1>
  <?php the_content(); ?>
  <?php wp_link_pages(array('before' => '<nav class="pagination">', 'after' => '</nav>')); ?>
<?php endwhile; ?>