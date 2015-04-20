<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

 <section class="entry-header"><?php exultic_page_title($post->ID); ?></section>
 
 <section class="entry-content">
  <?php exultic_page_hr($post->ID); ?>
  <?php the_content(); ?>
 </section>
 
 <section class="entry-footer">
  <?php edit_post_link(__('[edit]', 'exultic')); ?>
  
  <?php exultic_page_share($post->ID); ?>
 </section > 
 
 </article>
