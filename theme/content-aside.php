<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

  <div class="ribbon"><a href="<?php echo home_url( '/' ); ?>type/aside/"><div class="shadow"></div></a></div>
  
 <section class="entry-header">
  <?php exultic_post_title($post->ID); ?>
 
 </section>
 
 <section class="entry-content">
  <div class="entry-inner clearfix" <?php exultic_entry_style($post->ID); ?>>
  <?php exultic_entry_content($post->ID); ?>  </div>
 </section>
 
 <section class="entry-footer">
  <?php edit_post_link(__('[edit]', 'exultic'));
  exultic_tags($post->ID);
  exultic_share($post->ID);
  exultic_comments_count($post->ID);
  exultic_likes($post->ID);
  if(!is_single()) { ?><a class="date-stickie" href="<?php the_permalink(); ?>"><?php } else { ?><div class="date-stickie"><?php } ?>
  
   <span class="day"><?php the_time('j') ?></span>
   <span class="month"><?php the_time('M') ?></span>
  <?php if(!is_single()) { ?></a><?php } else { ?></div><?php } ?>
  
 </section > 
 
 </article>