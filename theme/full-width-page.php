<?php
/**
 * Template Name: Full-Width
 */

get_header(); ?>

<section id="content">

 <section id="entries" class="full-width">

 <?php the_post(); ?>

 <?php get_template_part('content', 'page'); ?>

 <?php comments_template('', true); ?>

 </section>

<?php get_footer(); ?>