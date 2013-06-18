<?php

/* ---------------------------------------------------------------------- */
/*	Show main and footer navigation
/* ---------------------------------------------------------------------- */

if( !function_exists('sp_top_navigation')) {

	function sp_top_navigation() {
		
		if ( function_exists ( 'wp_nav_menu' ) )
			wp_nav_menu( array(
				'container_class'	 => 'top-menu',
				'theme_location' => 'top_nav',
				'fallback_cb' => 'sp_top_nav_fallback'
				) );
		else
			sp_top_nav_fallback();	
	}
}

if (!function_exists('sp_top_nav_fallback')) {
	
	function sp_top_nav_fallback() {
    	
		$menu_html .= '<ul class="top-menu">';
		$menu_html .= '<li><a href="'.admin_url('nav-menus.php').'">'.esc_html__('Add Main menu', 'sptheme').'</a></li>';
		$menu_html .= '</ul>';
		echo $menu_html;
		
	}
	
}

if( !function_exists('sp_main_navigation')) {

	function sp_main_navigation() {
		
		// set default main menu if wp_nav_menu not active
		if ( function_exists ( 'wp_nav_menu' ) )
			wp_nav_menu( array(
				'container'      => false,
				'menu_class'	 => 'main-menu',
				'theme_location' => 'primary_nav',
				'fallback_cb' => 'sp_main_nav_fallback'
				) );
		else
			sp_main_nav_fallback();	
	}
}

if (!function_exists('sp_main_nav_fallback')) {
	
	function sp_main_nav_fallback() {
    	
		$menu_html .= '<ul class="main-menu">';
		$menu_html .= '<li><a href="'.admin_url('nav-menus.php').'">'.esc_html__('Add Main menu', 'sptheme').'</a></li>';
		$menu_html .= '</ul>';
		echo $menu_html;
		
	}
	
}

if (!function_exists('sp_footer_navigation')){
	
	function sp_footer_navigation() {
		
		// set default main menu if wp_nav_menu not active
		if ( function_exists ( 'wp_nav_menu' ) )
			wp_nav_menu( array(
				'container'      => false,
				'menu_class'	 => 'footer-nav',
				'after'		 	 => ' &nbsp;',
				'theme_location' => 'footer_nav',
				'fallback_cb'	 => 'sp_footer_nav_fallback'
				));	
		else
			sp_footer_nav_fallback();	
	}
}

if (!function_exists('sp_footer_nav_fallback')) {
	
	function sp_footer_nav_fallback() {
    	
		$menu_html .= '<ul class="footer-nav">';
		$menu_html .= '<li><a href="'.admin_url('nav-menus.php').'">'.esc_html__('Add Footer menu', 'sptheme').'</a></li>';
		$menu_html .= '</ul>';
		echo $menu_html;
		
	}
	
}

/* ---------------------------------------------------------------------- */
/*	Get Custom Field
/* ---------------------------------------------------------------------- */

if ( !function_exists('sp_get_custom_field') ) {
	
	function sp_get_custom_field( $key, $post_id = null) {
		
		global $wp_query;
		
		$post_id = $post_id ? $post_id : $wp_query->get_queried_object()->ID;
		
		return get_post_meta( $post_id, $key, true );
	}
}

/* ---------------------------------------------------------------------- */
/*	Check page layout
/* ---------------------------------------------------------------------- */

if ( !function_exists('sp_check_page_layout') ) {

	function sp_check_page_layout( $single_project = null, $portfolio_category = null ) {

		$page_layout = sp_get_custom_field('sp_page_layout');

		/*if( $single_project )
			$page_layout = sp_get_custom_field('sp_project_page_layout');

		if( $portfolio_category )
			$page_layout = sp_get_custom_field( 'sp_page_layout', of_get_option('sp_portfolio_parent') );

		$site_structure = of_get_option('sp_site_structure');*/

		//if( ( $page_layout == '2cl' || $page_layout == '2cr' ) || ( $page_layout != '1col' && ( $site_structure == '2cl' || $site_structure == '2cr' ) ) )
		if( ( $page_layout == '2cl' || $page_layout == '2cr' || $page_layout == '3col' ) )
			return true;
			
		//if( ( $page_layout == '3col' ) )
			//return $page_layout;	

		return false;

	}
	
}

/* ---------------------------------------------------------------------- */
/*	Check sidebar position
/* ---------------------------------------------------------------------- */

if ( !function_exists('sp_check_sidebar_position') ) {

	function sp_check_sidebar_position( $single_project = null, $portfolio_category = null ) {

		$page_layout = sp_get_custom_field('sp_page_layout');

		/*if( $single_project )
			$page_layout = sp_get_custom_field('sp_project_page_layout');

		if( $portfolio_category )
			$page_layout = sp_get_custom_field( 'sp_page_layout', of_get_option('sp_portfolio_parent') );

		$site_structure = of_get_option('sp_site_structure'); */

		if( $page_layout == '2cl' )
			return 'sidebar-left';
		if( $page_layout == '2cr' )
			return 'sidebar-right';	
		if( $page_layout == '1col' )
			return 'sidebar-no';	

		return null;

	}
	
}

/* ---------------------------------------------------------------------- */
/*	Show the post content
/* ---------------------------------------------------------------------- */

if( !function_exists('sp_post_content')) {

	function sp_post_content() {

		global $smof_data, $post, $user_ID;

		get_currentuserinfo();

		$output = '';
		
		if ( is_singular() ) {

			$content = get_the_content();
			$content = apply_filters( 'the_content', $content );
			$content = str_replace( ']]>', ']]&gt;', $content );

			$output .= $content;

			$output .= wp_link_pages( array( 'echo' => false ) );

		} else {
			
			if ( $smof_data[ 'blog_display' ] !== 'none' ) {
				//$output .= '<article class="item-list">';
				if ( $smof_data[ 'blog_display' ] == 'thumbnail' ) {
						if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) :	
						$output .= '<div class="post-thumbnail">';
						$output .= '<a href="'.get_permalink().'" title="' . __( 'Permalink to ', 'sptheme' ) . get_the_title() . '" rel="bookmark">';
						$output .= '<img src="' . sp_post_image('sp-medium') . '" width="200" height="150" /></a>';
						//$output .= sp_get_score( true ); // show rate ui
						$output .= '</div>';
					endif;
				}
				$output .= '<p>' . sp_excerpt_string_length($smof_data[ 'archive_char_length' ]) . '</p>';
				$output .= '<a href="'.get_permalink().'" class="learn-more button">' . __( 'Read more »', 'sptheme' ) . '</a>';
				//$output .= '</article>';
			}
		}
		
		return $output;

	}

}

/* ---------------------------------------------------------------------- */
/*	Show the post meta (permalink, date, tags, categories & comments)
/* ---------------------------------------------------------------------- */

if( !function_exists('sp_post_meta')) {

	function sp_post_meta() {

		global $smof_data, $post, $user_ID;;
		
		if ($smof_data[ 'post_meta' ]) :
		if( $smof_data[ 'posted_by' ] )
			$output = '<span>' . __('Posted by:', 'sptheme_admin') . '</span><span class="title"><a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" title="' . sprintf( esc_attr__( 'View all posts by %s', 'sptheme' ), get_the_author() . '">' . get_the_author()) . '</a></span><span>&mdash;</span>';
			
		if( $smof_data[ 'post_date' ] )
			$output .=  sp_posted_on() . '<span>&mdash;</span>';
		
		if( $smof_data[ 'post_categories' ] )	
			$output .= '<span class="post-categories">' . __(' in: ', 'sptheme') . ' ' . get_the_category_list(', ') . '</span><span>&mdash;</span>';
		
		if ( comments_open() || ( '0' != get_comments_number() && !comments_open() ) ) :
		if( $smof_data[ 'post_comments' ] )	
			$output .= '<span class="post-comments">' . get_comments_popup_link( __( 'Leave a comment', 'sptheme' ), __( '1 Comment', 'sptheme' ), __( '% Comments', 'sptheme' ) ) . '</span><span>&mdash;</span>';
		endif; // end show/hide comments	
			
			
		if( $smof_data[ 'post_views' ] )	
			$output .= sp_post_views();
			
		if( user_can( $user_ID, 'edit_posts' ) )
			$output .= '<span>&mdash;</span><span class="edit-link"><a title="' . __('Edit Post', 'sptheme') . '" href="' . get_edit_post_link( $post->ID ) . '">' . __('Edit', 'sptheme') . '</a></span>';	
		
		return $output;
		
		else: 
		
		return false;
		
		endif;
	}

}

/*-----------------------------------------------------------------------------------*/
# Buffer the output from comments_popup_link
/*-----------------------------------------------------------------------------------*/
function get_comments_popup_link( $zero = false, $one = false, $more = false, $css_class = '', $none = false ) {
    ob_start();
    comments_popup_link( $zero, $one, $more, $css_class, $none );
    return ob_get_clean();
}

/* ---------------------------------------------------------------------- */
/*	The current post—date/time
/* ---------------------------------------------------------------------- */

if( !function_exists('sp_posted_on')) {

	function sp_posted_on() {

	global $smof_data, $post ;
	
	if( $smof_data[ 'time_format' ] == 'none' ){
		return false;
	}elseif( $smof_data[ 'time_format' ] == 'modern' ){	
		$to = time();
		$from = get_the_time('U') ;
		
		$diff = (int) abs($to - $from);
		if ($diff <= 3600) {
			$mins = round($diff / 60);
			if ($mins <= 1) {
				$mins = 1;
			}
			$since = sprintf(_n('%s min', '%s mins', $mins), $mins) .' '. __( 'ago' , 'sptheme' );
		}
		else if (($diff <= 86400) && ($diff > 3600)) {
			$hours = round($diff / 3600);
			if ($hours <= 1) {
				$hours = 1;
			}
			$since = sprintf(_n('%s hour', '%s hours', $hours), $hours) .' '. __( 'ago' , 'sptheme' );
		}
		elseif ($diff >= 86400) {
			$days = round($diff / 86400);
			if ($days <= 1) {
				$days = 1;
				$since = sprintf(_n('%s day', '%s days', $days), $days) .' '. __( 'ago' , 'sptheme' );
			}
			elseif( $days > 29){
				$since = get_the_time(get_option('date_format'));
			}
			else{
				$since = sprintf(_n('%s day', '%s days', $days), $days) .' '. __( 'ago' , 'sptheme' );
			}
		}
	}else{
		$since = get_the_time(get_option('date_format'));
	}
	//echo '<span class="post-date">'.$since.'</span>';
	
	return sprintf( __( '<time datetime="%1$s" pubdate>%2$s - %3$s</time>', 'sptheme' ),
			esc_attr( get_the_date('c') ),
			esc_html( $since ),
			esc_attr( get_the_time('g:i a') )
		);
	
	}

}

/*-----------------------------------------------------------------------------------*/
/* Amount of Post viewed 
/*-----------------------------------------------------------------------------------*/
// function to display number of posts.
function sp_post_views( $postID = '' ){
	global $smof_data, $post;
	
	if( !$smof_data[ 'post_views' ] ) return false;

	if( empty($postID) ) $postID = $post->ID ;
	
    $count_key = 'sp_post_views';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        $count = "0";
    }
    return '<span class="post-views">'.$count.' '.__( 'Views' , 'sptheme' ).'</span> ';
}

// function to count views.
function sp_set_post_views() {
	global $smof_data, $post;
	
	if( !$smof_data[ 'post_views' ] ) return false;

	$postID = $post->ID ;
    $count_key = 'sp_post_views';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}


// Add it to a column in WP-Admin 
add_filter('manage_posts_columns', 'sp_posts_column_views');
add_action('manage_posts_custom_column', 'sp_posts_custom_column_views',5,2);
function sp_posts_column_views($defaults){
    $defaults['sp_post_views'] = __('Views');
    return $defaults;
}
function sp_posts_custom_column_views($column_name, $id){
	if($column_name === 'sp_post_views'){
        echo sp_post_views(get_the_ID());
    }
}

/* ---------------------------------------------------------------------- */
/*	Get Post image
/* ---------------------------------------------------------------------- */

if( !function_exists('sp_post_image')) {

	function sp_post_image($size = 'thumbnail'){
		global $post;
		$image = '';
		
		//get the post thumbnail;
		$image_id = get_post_thumbnail_id($post->ID);
		$image = wp_get_attachment_image_src($image_id, $size);
		$image = $image[0];
		if ($image) return $image;
		
		//if the post is video post and haven't a feutre image
		$post_type = get_post_format($post->ID);
		$vtype = sp_get_custom_field( 'sp_video_type', $post->ID );
		$vId = get_post_meta($post->ID, 'sp_video_id', true);

		if($post_type == 'video') {
						if($vtype == 'youtube') {
						  $image = 'http://img.youtube.com/vi/'.$vId.'/0.jpg';
						} elseif ($vtype == 'vimeo') {
						$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$vId.php"));
						  $image = $hash[0]['thumbnail_large'];
						} elseif ($vtype == 'daily') {
						  $image = 'http://www.dailymotion.com/thumbnail/video/'.$vId;
						}
				}
		if($post_type == 'audio') {
			$image = SP_BASE_URL . 'images/placeholder/sound-post-thumb.gif'; // use placeholder image or sound icon
		}		
						
		if ($image) return $image;
		//If there is still no image, get the first image from the post
		return sp_get_first_image();
	}
		

}

/* ---------------------------------------------------------------------- */
/*	Get first image in post
/* ---------------------------------------------------------------------- */
if( !function_exists('sp_get_first_image')) {
	
	function sp_get_first_image() {
		global $post, $posts;
		$first_img = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		$first_img = $matches[1][0];
		
		return $first_img;
	}
}

/* ---------------------------------------------------------------------- */
/*	Blog navigation
/* ---------------------------------------------------------------------- */

if ( !function_exists('sp_pagination') ) {

	function sp_pagination( $pages = '', $range = 2 ) {

		$showitems = ( $range * 2 ) + 1;

		global $paged, $wp_query;

		if( empty( $paged ) )
			$paged = 1;

		if( $pages == '' ) {

			$pages = $wp_query->max_num_pages;

			if( !$pages )
				$pages = 1;

		}

		if( 1 != $pages ) {

			$output = '<nav class="pagination">';

			// if( $paged > 2 && $paged >= $range + 1 /*&& $showitems < $pages*/ )
				// $output .= '<a href="' . get_pagenum_link( 1 ) . '" class="next">&laquo; ' . __('First', 'sptheme_admin') . '</a>';

			if( $paged > 1 /*&& $showitems < $pages*/ )
				$output .= '<a href="' . get_pagenum_link( $paged - 1 ) . '" class="next">&larr; ' . __('Previous', 'sptheme') . '</a>';

			for ( $i = 1; $i <= $pages; $i++ )  {

				if ( 1 != $pages && ( !( $i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems ) )
					$output .= ( $paged == $i ) ? '<span class="current">' . $i . '</span>' : '<a href="' . get_pagenum_link( $i ) . '">' . $i . '</a>';

			}

			if ( $paged < $pages /*&& $showitems < $pages*/ )
				$output .= '<a href="' . get_pagenum_link( $paged + 1 ) . '" class="prev">' . __('Next', 'sptheme') . ' &rarr;</a>';

			// if ( $paged < $pages - 1 && $paged + $range - 1 <= $pages /*&& $showitems < $pages*/ )
				// $output .= '<a href="' . get_pagenum_link( $pages ) . '" class="prev">' . __('Last', 'sptheme_admin') . ' &raquo;</a>';

			$output .= '</nav>';

			return $output;

		}

	}

}

// Strip string by words count
if ( ! function_exists( 'sp_string_length' ) ) {
	function sp_string_length( $str, $words = 20, $more = '' ) {
		if ( ! $str )
			return;

		$str = preg_replace( '/\s\s+/', ' ', $str );
		$str = explode( ' ', $str, ( $words + 1 ) );

		if ( count( $str ) > $words ) {
			array_pop( $str );
			$out = implode( ' ', $str ) . $more;
		} else {
			$out = implode( ' ', $str );
		}

		return $out;
	}
} // sp_string_length

/* ---------------------------------------------------------------------- */
/*	Taxonomy list
/* ---------------------------------------------------------------------- */
/*
	* Taxonomy list - returns array [slug => name]
	*
	* $args = ARRAY [see below for options]
	*/
	if ( ! function_exists( 'sp_tax_array' ) ) {
		function sp_tax_array( $args = array() ) {
			$args = wp_parse_args( $args, array(
					'all'          => true, //whether to display "all" option
					'allCountPost' => 'post', //post type to count posts for "all" option, if left empty, the posts count will not be displayed
					'allText'      => __( 'All posts', 'sptheme_admin' ), //"all" option text
					'hierarchical' => '1', //whether taxonomy is hierarchical
					'orderBy'      => 'name', //in which order the taxonomy titles should appear
					'parentsOnly'  => false, //will return only parent (highest level) categories
					'return'       => 'slug', //what to return as a value (slug, or term_id?)
					'tax'          => 'category', //taxonomy name
				) );

			$outArray = array();
			$terms    = get_terms( $args['tax'], 'orderby=' . $args['orderBy'] . '&hide_empty=0&hierarchical=' . $args['hierarchical'] );

			if ( $args['all'] ) {
				if ( ! $args['allCountPost'] ) {
					$allCount = '';
				} else {
					$allCount = wp_count_posts( $args['allCountPost'], 'readable' );
					$allCount = ' (' . absint( $allCount->publish ) . ')';
				}
				$outArray[''] = '- ' . $args['allText'] . $allCount . ' -';
			}

			if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					if ( ! $args['parentsOnly'] ) {
						$outArray[$term->$args['return']] = $term->name;
						$outArray[$term->$args['return']] .= ( ! $args['allCountPost'] ) ? ( '' ) : ( ' (' . $term->count . ')' );
					} elseif ( $args['parentsOnly'] && ! $term->parent ) { //get only parent categories, no children
						$outArray[$term->$args['return']] = $term->name;
						$outArray[$term->$args['return']] .= ( ! $args['allCountPost'] ) ? ( '' ) : ( ' (' . $term->count . ')' );
					}
				}
			}

			return $outArray;
		}
	} // /sp_tax_array
	
/* ---------------------------------------------------------------------- */
/*	Pages list
/* ---------------------------------------------------------------------- */	
	/*
	* Pages list - returns array [post_name (slug) => name]
	*
	* $return  = 'post_name' OR 'ID'
	*/
	if ( ! function_exists( 'sp_pages' ) ) {
		function sp_pages( $return = 'post_name' ) {
			$pages       = get_pages();
			$outArray    = array();
			$outArray[0] = __( '- Select page -', 'sptheme_admin' );

			foreach ( $pages as $page ) {
				$indents = $pagePath = '';
				$ancestors = get_post_ancestors( $page->ID );

				if ( ! empty( $ancestors ) ) {
					$indent = ( $page->post_parent ) ? ( '&ndash; ' ) : ( '' );
					foreach ( $ancestors as $ancestor ) {
						if ( 'post_name' == $return ) {
							$parent = get_page( $ancestor );
							$pagePath .= $parent->post_name . '/';
						}
						$indents .= $indent;
					}
				}

				$pagePath .= $page->post_name;
				$returnParam = ( 'post_name' == $return ) ? ( $pagePath ) : ( $page->ID );

				$outArray[$returnParam] = $indents . strip_tags( $page->post_title );
			}

			return $outArray;
		}
	} // /sp_pages


/*-----------------------------------------------------------------------------------*/
/* Embeded add video from youtube, vimeo and dailymotion
/*-----------------------------------------------------------------------------------*/
function sp_add_video ($url, $width = 620, $height = 349) {
	
	$video_url = @parse_url($url);

	if ( $video_url['host'] == 'www.youtube.com' || $video_url['host']  == 'youtube.com' ) {
		parse_str( @parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
		$video =  $my_array_of_vars['v'] ;
		$output .='<iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$video.'?rel=0" frameborder="0" allowfullscreen></iframe>';
	}
	elseif( $video_url['host'] == 'www.youtu.be' || $video_url['host']  == 'youtu.be' ){
		$video = substr(@parse_url($url, PHP_URL_PATH), 1);
		$output .='<iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$video.'?rel=0" frameborder="0" allowfullscreen></iframe>';
	}
	elseif( $video_url['host'] == 'www.vimeo.com' || $video_url['host']  == 'vimeo.com' ){
		$video = (int) substr(@parse_url($url, PHP_URL_PATH), 1);
		$output .='<iframe src="http://player.vimeo.com/video/'.$video.'" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
	}
	elseif( $video_url['host'] == 'www.dailymotion.com' || $video_url['host']  == 'dailymotion.com' ){
		$video = substr(@parse_url($url, PHP_URL_PATH), 7);
		$video_id = strtok($video, '_');
		$output .='<iframe frameborder="0" width="'.$width.'" height="'.$height.'" src="http://www.dailymotion.com/embed/video/'.$video_id.'"></iframe>';
	}
	
	return $output;
}

/*-----------------------------------------------------------------------------------*/
/* Embeded Audio/Sound from Soundcloud.com
/*-----------------------------------------------------------------------------------*/
function sp_soundcloud($url , $autoplay = 'false' ) {
	return '<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url='.$url.'&amp;auto_play='.$autoplay.'&amp;show_artwork=true"></iframe>';
}

/*-----------------------------------------------------------------------------------*/
/* Get Most Recent posts
/*-----------------------------------------------------------------------------------*/
function sp_last_posts($numberOfPosts = 5 , $thumb = true){
	global $post;
	$orig_post = $post;
	
	$lastPosts = get_posts('numberposts='.$numberOfPosts);
	foreach($lastPosts as $post): setup_postdata($post);
?>
<li>
	<?php if ( $thumb && sp_post_image('sp-small') ) : ?>
	<div class="post-thumbnail">
        <a href="<?php the_permalink(); ?>" title="<?php printf( __( 'Permalink to %s', 'sptheme' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
        <img src="<?php echo sp_post_image('sp-small') ?>" width="110" height="83" />
        </a>
    </div><!-- post-thumbnail /-->
    <?php endif; ?>
    
	<h3><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
	<?php //sp_get_score(); ?> <div class="entry-meta"><?php echo sp_posted_on(); ?></div>
</li>
<?php endforeach; 
	$post = $orig_post;
}

/*-----------------------------------------------------------------------------------*/
/* Get Random posts 
/*-----------------------------------------------------------------------------------*/
function sp_random_posts($numberOfPosts = 5 , $thumb = true){
	global $post;
	$orig_post = $post;

	$lastPosts = get_posts('orderby=rand&numberposts='.$numberOfPosts);
	foreach($lastPosts as $post): setup_postdata($post);
?>
<li>
	<?php if ( $thumb && sp_post_image('sp-small') ) : ?>			
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>" title="<?php printf( __( 'Permalink to %s', 'sptheme' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
			<img src="<?php echo sp_post_image('sp-small') ?>" width="110" height="83" />
            </a>
		</div><!-- post-thumbnail /-->
	<?php endif; ?>
	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<?php //sp_get_score(); ?> <div class="entry-meta"><?php echo sp_posted_on(); ?></div>
</li>
<?php endforeach;
	$post = $orig_post;
}


/*-----------------------------------------------------------------------------------*/
/* Get Popular posts 
/*-----------------------------------------------------------------------------------*/
function sp_popular_posts($pop_posts = 5 , $thumb = true){
	global $wpdb , $post;
	$orig_post = $post;
	
	$popularposts = "SELECT ID,post_title,post_date,post_author,post_content,post_type FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY comment_count DESC LIMIT 0,".$pop_posts;
	$posts = $wpdb->get_results($popularposts);
	if($posts){
		global $post;
		foreach($posts as $post){
		setup_postdata($post);?>
			<li>
            <?php if ( $thumb && sp_post_image('sp-small') ) : ?>	
	            <div class="post-thumbnail">
					<a href="<?php echo get_permalink( $post->ID ) ?>" title="<?php printf( __( 'Permalink to %s', 'sptheme' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
					<img src="<?php echo sp_post_image('sp-small') ?>" width="110" height="83" />
                    </a>
				</div><!-- post-thumbnail /-->
            <?php endif; ?>    
                
				<h3><a href="<?php echo get_permalink( $post->ID ) ?>" title="<?php echo the_title(); ?>"><?php echo the_title(); ?></a></h3>
				<?php //sp_get_score(); ?> <div class="entry-meta"><?php echo sp_posted_on(); ?></div>
               
			</li>
	<?php 
		}
	}
	$post = $orig_post;
}


/*-----------------------------------------------------------------------------------*/
/* Get Most commented posts 
/*-----------------------------------------------------------------------------------*/
function sp_most_commented($comment_posts = 5 , $avatar_size = 60){
$comments = get_comments('status=approve&number='.$comment_posts);
foreach ($comments as $comment) { ?>
	<li>
		<div class="post-thumbnail">
			<?php echo get_avatar( $comment, $avatar_size ); ?>
		</div>
		<a href="<?php echo get_permalink($comment->comment_post_ID ); ?>#comment-<?php echo $comment->comment_ID; ?>">
		<?php echo strip_tags($comment->comment_author); ?>: <?php echo wp_html_excerpt( $comment->comment_content, 60 ); ?>... </a>
	</li>
<?php } 
}

/*-----------------------------------------------------------------------------------*/
/* Get Most Racent posts from Category
/*-----------------------------------------------------------------------------------*/
function sp_last_posts_cat($numberOfPosts = 5 , $thumb = true , $cats = 1){
	global $post;
	$orig_post = $post;
	
	if ($offset)
		$lastPosts = get_posts('category='.$cats.'&numberposts='.$numberOfPosts.'&offset='.$offset);
	else
		$lastPosts = get_posts('category='.$cats.'&numberposts='.$numberOfPosts);	
	foreach($lastPosts as $post): setup_postdata($post);
?>
<li>
	<?php if ( $thumb && sp_post_image('sp-small') ) : ?>			
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>" title="<?php printf( __( 'Permalink to %s', 'sptheme' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
			<img src="<?php echo sp_post_image('sp-small') ?>" width="110" height="83" />
            </a>
		</div><!-- post-thumbnail /-->
	<?php endif; ?>
	<h3><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
	<?php //sp_get_score(); ?> <div class="entry-meta"><?php echo sp_posted_on(); ?></div>
</li>
<?php endforeach;
	$post = $orig_post;
	wp_reset_postdata();
}

/*-----------------------------------------------------------------------------------*/
# Add user's social accounts
/*-----------------------------------------------------------------------------------*/
add_action( 'show_user_profile', 'sp_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'sp_show_extra_profile_fields' );
function sp_show_extra_profile_fields( $user ) { ?>
	<h3>Custom Author widget</h3>
	<table class="form-table">
		<tr>
			<th><label for="author_widget_content">Custom Author widget content</label></th>
			<td>
				<textarea name="author_widget_content" id="author_widget_content" rows="5" cols="30"><?php echo esc_attr( get_the_author_meta( 'author_widget_content', $user->ID ) ); ?></textarea>
				<br /><span class="description">Supports HTML and Shortcodes .</span>
			</td>
		</tr>
	</table>
	<h3><?php _e( 'Social Networking', 'sptheme' ) ?></h3>
	<table class="form-table">
		<tr>
			<th><label for="google">Google + URL</label></th>
			<td>
				<input type="text" name="google" id="google" value="<?php echo esc_attr( get_the_author_meta( 'google', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="twitter">Twitter Username</label></th>
			<td>
				<input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="facebook">FaceBook URL</label></th>
			<td>
				<input type="text" name="facebook" id="facebook" value="<?php echo esc_attr( get_the_author_meta( 'facebook', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="linkedin">linkedIn URL</label></th>
			<td>
				<input type="text" name="linkedin" id="linkedin" value="<?php echo esc_attr( get_the_author_meta( 'linkedin', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="flickr">Flickr URL</label></th>
			<td>
				<input type="text" name="flickr" id="flickr" value="<?php echo esc_attr( get_the_author_meta( 'flickr', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="youtube">YouTube URL</label></th>
			<td>
				<input type="text" name="youtube" id="youtube" value="<?php echo esc_attr( get_the_author_meta( 'youtube', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="pinterest">Pinterest URL</label></th>
			<td>
				<input type="text" name="pinterest" id="pinterest" value="<?php echo esc_attr( get_the_author_meta( 'pinterest', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>

	</table>
<?php }

## Save user's social accounts
add_action( 'personal_options_update', 'sp_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'sp_save_extra_profile_fields' );
function sp_save_extra_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) ) return false;
	update_user_meta( $user_id, 'author_widget_content', $_POST['author_widget_content'] );
	update_user_meta( $user_id, 'google', $_POST['google'] );
	update_user_meta( $user_id, 'pinterest', $_POST['pinterest'] );
	update_user_meta( $user_id, 'twitter', $_POST['twitter'] );
	update_user_meta( $user_id, 'facebook', $_POST['facebook'] );
	update_user_meta( $user_id, 'linkedin', $_POST['linkedin'] );
	update_user_meta( $user_id, 'flickr', $_POST['flickr'] );
	update_user_meta( $user_id, 'youtube', $_POST['youtube'] );
}

/*-----------------------------------------------------------------------------------*/
/*Author Box
/*-----------------------------------------------------------------------------------*/
function sp_author_box($avatar = true , $social = true ){
	if( $avatar ) : ?>
	<div class="author-avatar">
		<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'MFW_author_bio_avatar_size', 75 ) ); ?>
	</div><!-- #author-avatar -->
	<?php endif; ?>
		<div class="author-description">
			<?php the_author_meta( 'description' ); ?>
		</div><!-- #author-description -->
	<?php  if( $social ) :	?>	
		<div class="author-social">
			<?php if ( get_the_author_meta( 'url' ) ) : ?>
			<a class="ttip" href="<?php the_author_meta( 'url' ); ?>" title="<?php the_author_meta( 'display_name' ); ?><?php _e( " 's site", 'sptheme' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/socialicons/site.png" alt="" /></a>
			<?php endif ?>	
			<?php if ( get_the_author_meta( 'twitter' ) ) : ?>
			<a class="ttip" href="http://twitter.com/<?php the_author_meta( 'twitter' ); ?>" title="<?php the_author_meta( 'display_name' ); ?><?php _e( '  on Twitter', 'sptheme' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/socialicons/twitter.png" alt="" /></a>
			<?php endif ?>	
			<?php if ( get_the_author_meta( 'facebook' ) ) : ?>
			<a class="ttip" href="<?php the_author_meta( 'facebook' ); ?>" title="<?php the_author_meta( 'display_name' ); ?> <?php _e( '  on Facebook', 'sptheme' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/socialicons/facebook.png" alt="" /></a>
			<?php endif ?>
			<?php if ( get_the_author_meta( 'google' ) ) : ?>
			<a class="ttip" href="<?php the_author_meta( 'google' ); ?>" title="<?php the_author_meta( 'display_name' ); ?> <?php _e( '  on Google+', 'sptheme' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/socialicons/google_plus.png" alt="" /></a>
			<?php endif ?>	
			<?php if ( get_the_author_meta( 'linkedin' ) ) : ?>
			<a class="ttip" href="<?php the_author_meta( 'linkedin' ); ?>" title="<?php the_author_meta( 'display_name' ); ?> <?php _e( '  on Linkedin', 'sptheme' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/socialicons/linkedin.png" alt="" /></a>
			<?php endif ?>				
			<?php if ( get_the_author_meta( 'flickr' ) ) : ?>
			<a class="ttip" href="<?php the_author_meta( 'flickr' ); ?>" title="<?php the_author_meta( 'display_name' ); ?><?php _e( '  on Flickr', 'sptheme' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/socialicons/flickr.png" alt="" /></a>
			<?php endif ?>	
			<?php if ( get_the_author_meta( 'youtube' ) ) : ?>
			<a class="ttip" href="<?php the_author_meta( 'youtube' ); ?>" title="<?php the_author_meta( 'display_name' ); ?><?php _e( '  on YouTube', 'sptheme' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/socialicons/youtube.png" alt="" /></a>
			<?php endif ?>
			<?php if ( get_the_author_meta( 'pinterest' ) ) : ?>
			<a class="ttip" href="<?php the_author_meta( 'pinterest' ); ?>" title="<?php the_author_meta( 'display_name' ); ?><?php _e( '  on Pinterest', 'sptheme' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/socialicons/pinterest.png" alt="" /></a>
			<?php endif ?>

		</div>
	<?php endif; ?>
	<div class="clear"></div>
	<?php
}

/*-----------------------------------------------------------------------------------*/
/* Get Og Image of post
/*-----------------------------------------------------------------------------------*/
function sp_og_image() {
	global $post ;
	
	if ( function_exists("has_post_thumbnail") && has_post_thumbnail() )
		$post_thumb = sp_post_image('slider') ;
	else{
		$get_meta = get_post_custom($post->ID);
		if( !empty( $get_meta["sp_video_url"][0] ) ){
			$video_url = $get_meta["sp_video_url"][0];
			$video_link = @parse_url($video_url);
			if ( $video_link['host'] == 'www.youtube.com' || $video_link['host']  == 'youtube.com' ) {
				parse_str( @parse_url( $video_url, PHP_URL_QUERY ), $my_array_of_vars );
				$video =  $my_array_of_vars['v'] ;
				$post_thumb ='http://img.youtube.com/vi/'.$video.'/0.jpg';
			}
			elseif( $video_link['host'] == 'www.vimeo.com' || $video_link['host']  == 'vimeo.com' ){
				$video = (int) substr(@parse_url($video_url, PHP_URL_PATH), 1);
				$url = 'http://vimeo.com/api/v2/video/'.$video.'.php';;
				$contents = @file_get_contents($url);
				$thumb = @unserialize(trim($contents));
				$post_thumb = $thumb[0][thumbnail_large];
			}
		}
	}
	
	if( isset($post_thumb) )
		echo '<meta property="og:image" content="'. $post_thumb .'" />';
}

/*-----------------------------------------------------------------------------------*/
/* Social 
/*-----------------------------------------------------------------------------------*/
function sp_get_social($newtab='yes', $icon_size='32', $tooltip='ttip' , $flat = false){
	
	global $smof_data;
		
	if ($newtab == 'yes') $newtab = "target=\"_blank\"";
	else $newtab = '';
		
	$icons_path =  SP_BASE_URL . 'images/socialicons';
		
		?>
		<div class="social-icons icon_<?php echo $icon_size; ?>">
		<?php
		// RSS
		if ( !$smof_data['rss_icon'] ){
		if ( $smof_data['rss_url'] != '' && $smof_data['rss_url'] != ' ' ) $rss = $smof_data['rss_url'] ;
		else $rss = get_bloginfo('rss2_url'); 
			?><a class="<?php echo $tooltip; ?> rss-tieicon" title="Rss" href="<?php echo $rss ; ?>" <?php echo $newtab; ?>><?php if( !$flat) : ?><img src="<?php echo $icons_path; ?>/rss.png" alt="RSS"  /><?php endif; ?></a><?php 
		}
		// Google+
		if ( !empty($smof_data['social_google_plus']) && $smof_data['social_google_plus'] != ' ' ) {
			?><a class="<?php echo $tooltip; ?> google-tieicon" title="Google+" href="<?php echo $smof_data['social_google_plus']; ?>" <?php echo $newtab; ?>><?php if( !$flat) : ?><img src="<?php echo $icons_path; ?>/google_plus.png" alt="Google+"  /><?php endif; ?></a><?php 
		}
		// Facebook
		if ( !empty($smof_data['social_facebook']) && $smof_data['social_facebook'] != ' ' ) {
			?><a class="<?php echo $tooltip; ?> facebook-tieicon" title="Facebook" href="<?php echo $smof_data['social_facebook']; ?>" <?php echo $newtab; ?>><?php if( !$flat) : ?><img src="<?php echo $icons_path; ?>/facebook.png" alt="Facebook"  /><?php endif; ?></a><?php 
		}
		// Twitter
		if ( !empty($smof_data['social_twitter']) && $smof_data['social_twitter'] != ' ') {
			?><a class="<?php echo $tooltip; ?> twitter-tieicon" title="Twitter" href="<?php echo $smof_data['social_twitter']; ?>" <?php echo $newtab; ?>><?php if( !$flat) : ?><img src="<?php echo $icons_path; ?>/twitter.png" alt="Twitter"  /><?php endif; ?></a><?php
		}		
		// Pinterest
		if ( !empty($smof_data['social_pinterest']) && $smof_data['social_pinterest'] != ' ') {
			?><a class="<?php echo $tooltip; ?> pinterest-tieicon" title="Pinterest" href="<?php echo $smof_data['social_pinterest']; ?>" <?php echo $newtab; ?>><?php if( !$flat) : ?><img src="<?php echo $icons_path; ?>/pinterest.png" alt="MySpace"  /><?php endif; ?></a><?php
		}
		// LinkedIN
		if ( !empty($smof_data['social_linkedin']) && $smof_data['social_linkedin'] != ' ' ) {
			?><a class="<?php echo $tooltip; ?> linkedin-tieicon" title="LinkedIn" href="<?php echo $smof_data['social_linkedin']; ?>" <?php echo $newtab; ?>><?php if( !$flat) : ?><img  src="<?php echo $icons_path; ?>/linkedin.png" alt="LinkedIn"  /><?php endif; ?></a><?php
		}
		// YouTube
		if ( !empty($smof_data['social_youtube']) && $smof_data['social_youtube'] != ' ' ) {
			?><a class="<?php echo $tooltip; ?> youtube-tieicon" title="Youtube" href="<?php echo $smof_data['social_youtube']; ?>" <?php echo $newtab; ?>><?php if( !$flat) : ?><img  src="<?php echo $icons_path; ?>/youtube.png" alt="YouTube"  /><?php endif; ?></a><?php
		}
		// Skype
		if ( !empty($smof_data['social_skype']) && $smof_data['social_skype'] != ' ' ) {
			?><a class="<?php echo $tooltip; ?> skype-tieicon" title="Skype" href="<?php echo $smof_data['social_skype']; ?>" <?php echo $newtab; ?>><?php if( !$flat) : ?><img  src="<?php echo $icons_path; ?>/skype.png" alt="Skype"  /><?php endif; ?></a><?php
		}
		// Delicious 
		if ( !empty($smof_data['social_delicious']) && $smof_data['social_delicious'] != ' ' ) {
			?><a class="<?php echo $tooltip; ?> delicious-tieicon" title="Delicious" href="<?php echo $smof_data['social_delicious']; ?>" <?php echo $newtab; ?>><?php if( !$flat) : ?><img  src="<?php echo $icons_path; ?>/delicious.png" alt="Delicious"  /><?php endif; ?></a><?php
		}
		// Vimeo
		if ( !empty($smof_data['social_vimeo']) && $smof_data['social_vimeo'] != ' ' ) {
			?><a class="<?php echo $tooltip; ?> vimeo-tieicon" title="Vimeo" href="<?php echo $smof_data['social_vimeo']; ?>" <?php echo $newtab; ?>><?php if( !$flat) : ?><img  src="<?php echo $icons_path; ?>/vimeo.png" alt="Vimeo"  /><?php endif; ?></a><?php
		}
		// instagram
		if ( !empty( $smof_data['social_instagram'] ) && $smof_data['social_instagram'] != ' ' ) {
			?><a class="<?php echo $tooltip; ?> instagram-tieicon" title="instagram" href="<?php echo $smof_data['social_instagram']; ?>" <?php echo $newtab; ?>><?php if( !$flat) : ?><img  src="<?php echo $icons_path; ?>/instagram.png" alt="instagram"  /><?php endif; ?></a><?php
		}
?>
	</div>

<?php
}