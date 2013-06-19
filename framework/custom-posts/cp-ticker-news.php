<?php
/*
*****************************************************
* Tikcer News custom post
*
* CONTENT:
* - 1) Actions and filters
* - 2) Creating a custom post
* - 3) Custom post list in admin
*****************************************************
*/





/*
*****************************************************
*      1) ACTIONS AND FILTERS
*****************************************************
*/
	//ACTIONS
		//Registering CP
		add_action( 'init', 'sp_tickernews_cp_init' );
		//CP list table columns
		add_action( 'manage_sp_tickernews_posts_custom_column', 'sp_tickernews_cp_custom_column' );

	//FILTERS
		//CP list table columns
		add_filter( 'manage_edit-sp_tickernews_columns', 'sp_tickernews_cp_columns' );




/*
*****************************************************
*      2) CREATING A CUSTOM POST
*****************************************************
*/
	/*
	* Custom post registration
	*/
	if ( ! function_exists( 'sp_tickernews_cp_init' ) ) {
		function sp_tickernews_cp_init() {
			global $cpMenuPosition;

			$role     = 'post'; // page
			$slug     = 'tickernews';
			$supports = array('title'); // 'title', 'editor', 'thumbnail'

			/*if ( $smof_data['sp_tickernews_revisions'] )
				$supports[] = 'revisions';*/

			$args = array(
				'query_var'           => 'tickernews',
				'capability_type'     => $role,
				'public'              => true,
				'show_ui'             => true,
				'show_in_nav_menus'	  => false,
				'exclude_from_search' => false,
				'hierarchical'        => false,
				'rewrite'             => array( 'slug' => $slug ),
				'menu_position'       => $cpMenuPosition['tickernews'],
				'menu_icon'           => SP_BASE_URL . 'framework/assets/img/icon-news.png',
				'supports'            => $supports,
				'labels'              => array(
					'name'               => __( 'Tikcer News', 'sptheme_admin' ),
					'singular_name'      => __( 'Tikcer News', 'sptheme_admin' ),
					'add_new'            => __( 'Add new ticker news', 'sptheme_admin' ),
					'add_new_item'       => __( 'Add new ticker news', 'sptheme_admin' ),
					'new_item'           => __( 'Add new ticker news', 'sptheme_admin' ),
					'edit_item'          => __( 'Edit ticker news', 'sptheme_admin' ),
					'view_item'          => __( 'View ticker news', 'sptheme_admin' ),
					'search_items'       => __( 'Search ticker news', 'sptheme_admin' ),
					'not_found'          => __( 'No ticker news found', 'sptheme_admin' ),
					'not_found_in_trash' => __( 'No ticker news found in trash', 'sptheme_admin' ),
					'parent_item_colon'  => ''
				)
			);
			register_post_type( 'sp_tickernews' , $args );
		}
	} // /sp_tickernews_cp_init





/*
*****************************************************
*      3) CUSTOM POST LIST IN ADMIN
*****************************************************
*/
	/*
	* Registration of the table columns
	*
	* $Cols = ARRAY [array of columns]
	*/
	if ( ! function_exists( 'sp_tickernews_cp_columns' ) ) {
		function sp_tickernews_cp_columns( $sp_tickernewsCols ) {
			
			$sp_tickernewsCols = array(
				//standard columns
				"cb"				=> '<input type="checkbox" />',
				//'title'				=> __( 'Title', 'sptheme_admin' ),
				'ticker_news_title'	=> __( 'Text', 'sptheme_admin' ),
				"date"				=> __( 'Date', 'sptheme_admin' ),
				"author"			=> __( 'Created by', 'sptheme_admin' )
			);

			return $sp_tickernewsCols;
		}
	} // /sp_tickernews_cp_columns

	/*
	* Outputting values for the custom columns in the table
	*
	* $Col = TEXT [column id for switch]
	*/
	if ( ! function_exists( 'sp_tickernews_cp_custom_column' ) ) {
		function sp_tickernews_cp_custom_column( $sp_tickernewsCol ) {
			global $post;
			
			$wpg_row_actions  = wpg_row_actions();
			$news_title = get_post_meta( $post->ID, 'sp_ticker_news_text', true ) ? get_post_meta( $post->ID, 'sp_ticker_news_text', true ) : ' '; 
			
			switch ( $sp_tickernewsCol ) {
				
				case "ticker_news_title":

					echo $news_title.$wpg_row_actions;

					break;
				
				default:
					break;
			}
		}
	} // /sp_tickernews_cp_custom_column
	
	//Add edit action link on each post
	function wpg_row_actions() {
	  global $post;
	  if($post->post_type == 'page') {
		if(!current_user_can('edit_page')) {
		  return;
		}
	  }
	  else {
		if(!current_user_can('edit_post')) {
		  return;
		}
	  }
	  if($post->post_status == 'trash') {
		$actionLinks  = '<div class="row-actions"><span class="untrash"><a title="'.__('Restore this item', 'quotable').'" href="'.wp_nonce_url(get_admin_url().'post.php?post='.$post->ID.'&amp;action=untrash', 'untrash-'.$post->post_type.'_'.$post->ID).'">'.__('Restore', 'quotable').'</a> | </span>';
		$actionLinks .= '<span class="trash"><a href="'.wp_nonce_url(get_admin_url().'post.php?post='.$post->ID.'&amp;action=delete', 'delete-'.$post->post_type.'_'.$post->ID).'" title="'.__('Delete this item permanently', 'quotable').'" class="submitdelete">'.__('Delete Permanently', 'quotable').'</a></span>';
	  }
	  else {
		$actionLinks  = '<div class="row-actions"><span class="edit"><a title="'.__('Edit this item', 'quotable').'" href="'.get_admin_url().'post.php?post='.$post->ID.'&amp;action=edit">'.__('Edit', 'quotable').'</a> | </span>';
		$actionLinks .= '<span class="inline hide-if-no-js"><a title="'.__('Edit this item inline', 'quotable').'" class="editinline" href="#">'.__('Quick Edit', 'quotable').'</a> | </span>';
		$actionLinks .= '<span class="trash"><a href="'.wp_nonce_url(get_admin_url().'post.php?post='.$post->ID.'&amp;action=trash', 'trash-'.$post->post_type.'_'.$post->ID).'" title="'.__('Move this item to the Trash', 'quotable').'" class="submitdelete">'._x('Trash', 'verb (ie. trash this post)', 'quotable').'</a></span>';
	  }
	  return $actionLinks;
	}