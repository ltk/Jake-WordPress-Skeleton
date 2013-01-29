<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class() ?> id="post-<?php the_ID(); ?>">
    <header>
      <h2 class="entry-title"><?php the_title(); ?></h3>
    </header>
    <div class="entry-content media">
      <?php
        // Disabling auto thumbnail for now
        // if ( has_post_thumbnail() ) {
        //   the_post_thumbnail( 'full', array( 'class' => 'bordered-thumbnail pull-left img' ) );
        // } 
      ?>
      <?php the_content(); ?>
    </div>
    <footer>
      <?php wp_link_pages(array('before' => '<nav id="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>')); ?>
      <?php the_tags('<ul class="entry-tags"><li>','</li><li>','</li></ul>'); ?>
    </footer>
    <?php comments_template('/templates/comments.php'); ?>
  </article>
<?php endwhile; ?>