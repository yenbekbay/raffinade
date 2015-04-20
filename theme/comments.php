<div id="comments"  class="clearfix">
<?php if (post_password_required()) { ?>
 <div class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'exultic' ); ?></div>
 </div>
<?php
 return;
 }
?>

<?php if (have_comments()) { ?>
 <h3 id="comments-title"><?php _e('Comments', 'exultic'); ?><span><?php comments_number('0', '1', '%'); ?></span></h3>
 
 <a class="comment-jump" href="#respond"><?php _e( 'Leave a reply &rarr;', 'exultic' ); ?></a>
 <div class="clear"></div>
 <ol class="commentlist">
 <?php wp_list_comments(array('callback' => 'exultic_comment')); ?>
 </ol>
 <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) { ?>
 <nav id="comment-nav-below">
  <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'exultic' ) ); ?></div>
  <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'exultic' ) ); ?></div>
 </nav>
 <?php } 
 } else {
 if (comments_open()) { } else {
 if (!comments_open() && ! is_page()) { ?>
 <p class="nocomments"><?php _e( 'Comments are closed.', 'exultic' ); ?></p>
 <?php }
 }
 
 }
comment_form(
array(
	'comment_notes_before' => '<p class="comment-notes">'.__('Required fields are marked', 'exultic').' <span class="required">*</span>.</p>',
	'comment_notes_after' => '',
	'comment_field'  => '<p class="comment-form-comment"><label for="comment">'._x('Message', 'noun', 'exultic').'<span class="required">*</span></label><textarea id="comment" name="comment" rows="8"></textarea></p>',
)
); ?>
</div>