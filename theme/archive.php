<?php get_header(); 
 if(get_query_var('author_name')) {
  $curauth = get_userdatabylogin(get_query_var('author_name'));
 } else {
  $curauth = get_userdata(get_query_var('author'));
 }
?>

<section id="content">

 <section id="entries">
 <?php if (have_posts()) {
  $post = $posts[0]; 
 ?>

 <div class="page-header">
  <h1 class="page-title">
  <?php if(is_category()) {
   printf(__('Category: %s', 'exultic'), single_cat_title('',false));
  } elseif(is_tag()) {
   printf(__('Tag: %s', 'exultic'), single_tag_title('',false));
  } elseif(is_tax('post_format')) {
   _e(get_post_format(), 'exultic');
  } elseif(is_day()) {
   printf(__('Archive for %s', 'exultic'), get_the_date('F j, Y'));
  } elseif(is_month()) {
   printf(__('Archive for %s', 'exultic'), get_the_date('F, Y'));
  } elseif(is_year()) {
   printf(__('Archive for %s year', 'exultic'), get_the_date('Y'));
  } elseif(is_author()) {
   _e('Author: ', 'exultic');
   echo $curauth->display_name;
  } else { 
   _e('Blog Archives', 'exultic'); } ?>
  </h1>
 </div>

 <?php while (have_posts()) : the_post(); ?> 
 
 <?php get_template_part('content', get_post_format()); ?>

 <?php endwhile; ?>
 
 <?php?>
 <?php if ( $wp_query->max_num_pages > 1 ) { ?>
 <nav id="nav-below">
  <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else { ?>
  <div class="nav-previous"><?php next_posts_link(__('&larr; Older posts', 'exultic')); ?></div>
  <div class="nav-next"><?php previous_posts_link(__('Newer posts &rarr;', 'exultic')); ?></div>
  <?php } ?>
 </nav>
 <?php } } ?>
 </section>

<?php get_template_part('sidebar', 'page'); ?>
<?php get_footer(); ?>