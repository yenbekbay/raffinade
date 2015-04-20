<?php get_header(); ?>

<section id="content">

 <section id="entries">
 <?php if (have_posts()) { ?>

 <div class="page-header">
  <h1 class="page-title"><?php printf(__( 'Search Results for: %s', 'exultic' ), '<span>' . get_search_query() . '</span>'); ?></h1>
 </div>
 
 <?php while (have_posts()) { the_post(); ?>
 
 <?php get_template_part('content', get_post_format()); ?>

 <?php } ?>
 
 <?php if ($wp_query->max_num_pages > 1) { ?>
 
 <nav id="nav-below">
  <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else { ?>
  <div class="nav-previous"><?php next_posts_link(__( '&larr; Older posts', 'exultic')); ?></div>
  <div class="nav-next"><?php previous_posts_link(__( 'Newer posts &rarr;', 'exultic')); ?></div>
  <?php } ?>
 </nav>
 
 <?php } } else { ?>

 <article id="post-0" class="post no-results not-found">
 <div class="page-header">
  <h1 class="page-title"><?php _e('Nothing Found', 'exultic'); ?></h1>
 </div>

 <div class="single-entry-content">
 <p><?php _e('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'exultic'); ?></p>
 <?php get_search_form(); ?>
 </div>
 </article>

 <?php } ?>

 </section>
 
<?php get_template_part('sidebar', 'page'); ?>
<?php get_footer(); ?>