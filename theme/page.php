<?php get_header(); ?>

<section id="content">

 <section id="entries">

 <?php the_post(); ?>

 <?php get_template_part('content', 'page'); ?>

 <?php comments_template('', true); ?>

 </section>

<?php get_template_part('sidebar', 'page'); ?>
<?php get_footer(); ?>