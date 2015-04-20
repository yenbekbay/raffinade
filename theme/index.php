<?php get_header(); ?>

<section id="content">

 <section id="entries">
 <?php while ( have_posts() ) : the_post(); ?>
 <?php get_template_part( 'content', get_post_format() ); ?>

 
 <?php endwhile; ?>
 
 <?php ?>
 <?php if ( $wp_query->max_num_pages > 1 ) : ?>
 <nav id="pagination">
  <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else { ?>
  <div class="nav-previous"><?php next_posts_link( __( '&larr; Older posts', 'exultic' ) ); ?></div>
  <div class="nav-next"><?php previous_posts_link( __( 'Newer posts &rarr;', 'exultic' ) ); ?></div>
  <?php } ?>
 </nav>
 <?php endif; ?> 
 </section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>