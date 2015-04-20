<?php
/**
 * Template Name: Sitemap
 */
	
get_header(); ?>

<section id="content">

 <section id="entries" class="full-width">
 <?php the_post(); ?>
 <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

 <section class="entry-header"><?php exultic_page_title($post->ID); ?></section>
			 
 <section class="entry-content"> 
  <?php exultic_page_hr($post->ID); ?>
  <div class="one-half">
  <h3><?php _e('Archives', 'exultic') ?></h3>
   <ul>
    <?php wp_get_archives('type=monthly&show_post_count=true'); ?>
   </ul>
  </div>
  <div class="one-half last">
  <h3><?php _e('Categories', 'exultic') ?></h3>
   <ul>
    <?php wp_list_categories('sort_column=name&optioncount=1&hierarchical=0&title_li='); ?>
   </ul>
  <h3><?php _e('Formats', 'exultic') ?></h3>
   <ul>
    <li><a href="<?php echo home_url( '/' ); ?>type/aside/"><?php _e('Aside', 'exultic') ?></a></li>
    <li><a href="<?php echo home_url( '/' ); ?>type/audio/"><?php _e('Audio', 'exultic') ?></a></li>
	<li><a href="<?php echo home_url( '/' ); ?>type/chat/"><?php _e('Chats', 'exultic') ?></a></li>
	<li><a href="<?php echo home_url( '/' ); ?>type/gallery/"><?php _e('Galleries', 'exultic') ?></a></li>
	<li><a href="<?php echo home_url( '/' ); ?>type/image/"><?php _e('Images', 'exultic') ?></a></li>
	<li><a href="<?php echo home_url( '/' ); ?>type/link/"><?php _e('Links', 'exultic') ?></a></li>
	<li><a href="<?php echo home_url( '/' ); ?>type/quote/"><?php _e('Quotes', 'exultic') ?></a></li>
	<li><a href="<?php echo home_url( '/' ); ?>type/video/"><?php _e('Video', 'exultic') ?></a></li>
   </ul>
  </div> 
 </section>
 
 <section class="entry-footer">
  <?php edit_post_link(__('[edit]', 'exultic')); ?>
 </section>
 
 </article>
 
 </section>
 
</section>

<?php get_footer(); ?>