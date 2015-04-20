<?php get_header(); ?>

<section id="content">

 <section id="entries">
 <?php if (have_posts()) while (have_posts()) : the_post(); ?>

 <?php get_template_part('content', get_post_format()); ?>
 
 <?php comments_template('', true); ?>

 <?php endwhile; ?>
 
 <nav id="nav-below">
   <div class="nav-previous"><?php previous_post_link( '%link', '' . _x( 'Previous Post', 'Previous post link', 'exultic' ) . '' ); ?></div>
   <div class="nav-next"><?php next_post_link( '%link', '' . _x( 'Next Post', 'Next post link', 'exultic' ) . '' ); ?></div>
 </nav> 
 </section>
 
<?php get_template_part('sidebar', 'single'); ?>
<?php get_footer(); ?>