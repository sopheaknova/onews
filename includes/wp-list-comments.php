<?php

/*-----------------------------------------------------------------------------------*/
# Queue Comments reply js
/*-----------------------------------------------------------------------------------*/
function comments_queue_js(){
if ( (!is_admin()) && is_singular() && comments_open() && get_option('thread_comments') )
  wp_enqueue_script( 'comment-reply' );
}
add_action('wp_print_scripts', 'comments_queue_js');


/*-----------------------------------------------------------------------------------*/
# Remove recent comments style
/*-----------------------------------------------------------------------------------*/
function sp_remove_recent_comments_style() {
	add_filter( 'show_recent_comments_widget_style', '__return_false' );
}
add_action( 'widgets_init', 'sp_remove_recent_comments_style' );

/*-----------------------------------------------------------------------------------*/
# Custom comments style
/*-----------------------------------------------------------------------------------*/
function custom_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment ;
	?>
	<li id="comment-<?php comment_ID(); ?>">
		<div  <?php comment_class('comment-wrap'); ?> >
			<div class="comment-avatar"><?php echo get_avatar( $comment, 45 ); ?></div>
			<div class="author-comment">
				<?php printf( __( '%s ', 'sptheme' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">	<?php printf( __( '%1$s at %2$s', 'sptheme' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'sptheme' ), ' ' ); ?></div><!-- .comment-meta .commentmetadata -->
			</div>
			<div class="clear"></div>
			<div class="comment-content">
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'sptheme' ); ?></em>
					<br />
				<?php endif; ?>
					
				<?php comment_text(); ?>
			</div>
			<div class="reply"><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></div><!-- .reply -->
		</div><!-- #comment-##  -->

	<?php
}

function custom_pings($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?>
	<li class="comment pingback">
		<p><?php _e( 'Pingback:', 'sptheme' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'sptheme' ), ' ' ); ?></p>
<?php	
}
?>