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

		global $post, $user_ID;

		get_currentuserinfo();

		if ( is_singular() ) {

			$content = get_the_content();
			$content = apply_filters( 'the_content', $content );
			$content = str_replace( ']]>', ']]&gt;', $content );

			$output = $content;

			$output .= wp_link_pages( array( 'echo' => false ) );

		} else {
			$output = '<p>' . sp_excerpt_length(20) . '</p>';	
			//$output = '<p>' . sp_excerpt_string_length(350) . '</p>';
			$output .= '<a href="'.get_permalink().'" class="learn-more button">' . __( 'Read more »', 'sptheme' ) . '</a>';
		}
		
		return $output;

	}

}

/* ---------------------------------------------------------------------- */
/*	Show the post meta (permalink, date, tags, categories & comments)
/* ---------------------------------------------------------------------- */

if( !function_exists('sp_post_meta')) {

	function sp_post_meta() {

		global $smof_data, $post;
		
		if ($smof_data[ 'post_meta' ]) :
		if( $smof_data[ 'posted_by' ] )
			$output = '<span>' . __('Posted by:', 'sptheme_admin') . '</span><span class="title">' . get_the_author() . '</span><span>&mdash;</span>';
			
		if( $smof_data[ 'post_date' ] )
			$output .=  sp_posted_on() . '<span>&mdash;</span>';
		
		if( $smof_data[ 'post_categories' ] )	
			$output .= '<span class="post-categories">' . __(' in: ', 'sptheme') . ' ' . get_the_category_list(', ') . '</span><span>&mdash;</span>';
		
		if( $smof_data[ 'post_comments' ] )	
			$output .= '<span class="post-comments">' . get_comments_popup_link( __( 'Leave a comment', 'sptheme' ), __( '1 Comment', 'sptheme' ), __( '% Comments', 'sptheme' ) ) . '</span><span>&mdash;</span>';
			
		if( $smof_data[ 'post_views' ] )	
			$output .= sp_post_views();
		
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
	
	return sprintf( __( '<time datetime="%1$s" pubdate>%2$s</time>', 'sptheme' ),
			esc_attr( get_the_date('c') ),
			esc_html( $since )
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
/* Get Most Recent posts
/*-----------------------------------------------------------------------------------*/
function wp_last_posts($numberOfPosts = 5 , $thumb = true){
	global $post;
	$orig_post = $post;
	
	$lastPosts = get_posts('numberposts='.$numberOfPosts);
	foreach($lastPosts as $post): setup_postdata($post);
?>
<li>
    <div class="post-thumbnail">
        <a href="<?php the_permalink(); ?>" title="<?php printf( __( 'Permalink to %s', 'sptheme' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
        <img src="<?php echo sp_post_image('sp-small') ?>" width="60" height="60" />
        </a>
    </div><!-- post-thumbnail /-->
	<h3><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
	<?php //tie_get_score(); ?> <div class="entry-meta"><?php echo sp_posted_on(); ?></div>
</li>
<?php endforeach; 
	$post = $orig_post;
}

/*-----------------------------------------------------------------------------------*/
/* Get Popular posts 
/*-----------------------------------------------------------------------------------*/
function wp_popular_posts($pop_posts = 5 , $thumb = true){
	global $wpdb , $post;
	$orig_post = $post;
	
	$popularposts = "SELECT ID,post_title,post_date,post_author,post_content,post_type FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY comment_count DESC LIMIT 0,".$pop_posts;
	$posts = $wpdb->get_results($popularposts);
	if($posts){
		global $post;
		foreach($posts as $post){
		setup_postdata($post);?>
			<li>
				<div class="post-thumbnail">
					<a href="<?php echo get_permalink( $post->ID ) ?>" title="<?php printf( __( 'Permalink to %s', 'sptheme' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
					<img src="<?php echo sp_post_image('sp-small') ?>" width="60" height="60" />
                    </a>
				</div><!-- post-thumbnail /-->
				<h3><a href="<?php echo get_permalink( $post->ID ) ?>" title="<?php echo the_title(); ?>"><?php echo the_title(); ?></a></h3>
				<?php //tie_get_score(); ?> <div class="entry-meta"><?php echo sp_posted_on(); ?></div>
			</li>
	<?php 
		}
	}
	$post = $orig_post;
}


/*-----------------------------------------------------------------------------------*/
/* Get Most commented posts 
/*-----------------------------------------------------------------------------------*/
function most_commented($comment_posts = 5 , $avatar_size = 60){
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
	
	$lastPosts = get_posts('category='.$cats.'&numberposts='.$numberOfPosts);
	foreach($lastPosts as $post): setup_postdata($post);
?>
<li>
	<?php if ( $thumb ) : ?>			
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>" title="<?php printf( __( 'Permalink to %s', 'sptheme' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
			<img src="<?php echo sp_post_image('sp-small') ?>" width="60" height="60" />
            </a>
		</div><!-- post-thumbnail /-->
	<?php endif; ?>
	<h3><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
	<?php //tie_get_score(); ?> <div class="entry-meta"><?php echo sp_posted_on(); ?></div>
</li>
<?php endforeach;
	$post = $orig_post;
	wp_reset_postdata();
}