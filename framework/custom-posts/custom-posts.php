<?php

//All custom posts
require_once( SP_BASE_DIR . 'framework/custom-posts/cp-ticker-news.php' );

//Taxonomies
//require_once( SP_BASE_DIR . 'framework/custom-posts/ct-taxonomies.php' );
	
/*==========================================================================*/

//Change title text when creating new post
if ( is_admin() )
	add_filter( 'enter_title_here', 'sp_change_new_post_title' );	
	
/*
* Changes "Enter title here" text when creating new post
*/
if ( ! function_exists( 'sp_change_new_post_title' ) ) {
	function sp_change_new_post_title( $title ){
		$screen = get_current_screen();

		if ( 'sp_slideshow' == $screen->post_type )
			$title = __( "Slide title", 'sptheme_admin' );

		/*if ( 'sp_faq' == $screen->post_type )
			$title = __( "Enter question here", 'sptheme_admin' );*/

		return $title;
	}
} // /sp_change_new_post_title	