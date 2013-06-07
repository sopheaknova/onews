<?php

/*
*****************************************************
*      ACTIONS AND FILTERS
*****************************************************
*/

	//ACTION
		add_action('after_setup_theme', 'sp_theme_setup');//Theme support after activate
		add_action('init', 'sp_register_assets');//Register and print CSS and JS
		add_action('wp_print_styles', 'sp_enqueue_styles'); //print CSS
		add_action('wp_print_scripts', 'sp_enqueue_scripts'); //print JS
		add_action( 'wp_head', 'sp_print_css_js' );//Custom scripts
		
	//FILTER
		add_filter('wp_title', 'sp_filter_wp_title', 10, 2);	
		//TinyMCE customization
		if ( is_admin() ) {
			add_filter( 'mce_buttons', 'sp_add_buttons_row1' );
			add_filter( 'mce_buttons_2', 'sp_add_buttons_row2' );
		}
		
		add_filter( 'the_excerpt_rss', 'sp_rss_post_thumbnail' );//Display thumbnails in RSS
		add_filter( 'the_content_feed', 'sp_rss_post_thumbnail' );//Display thumbnails in RSS
		
		add_filter('excerpt_length', 'sp_excerpt_length');
		add_filter('excerpt_more', 'sp_auto_excerpt_more');
		
		add_action('admin_menu', 'sp_disable_default_dashboard_widgets'); //diable unsued dashboard
		add_action('widgets_init', 'sp_unregister_default_wp_widgets', 1); // unregister unused widget
		
	
	//SECURITY
		//Remove error message login
		add_filter('login_errors', create_function('$a', "return null;"));
		//Remove wordpress version generation
		remove_action( 'wp_head', 'wp_generator' );
		//Rremove Windows Live Writer support
		remove_action( 'wp_head', 'wlwmanifest_link' );	
		
	//BRANDING
		add_action( 'admin_head', 'sp_adminfavicon' );//Set favicons for backend code
		add_action('login_head', 'sp_custom_login_logo');// Custom logo login
		add_action( 'wp_before_admin_bar_render', 'sp_remove_admin_bar_links' );//	Remove logo and other items in Admin menu bar
		add_filter('login_headerurl', 'sp_remove_link_on_admin_login_info');//  Remove wordpress link on admin login logo
		add_filter('login_headertitle', 'sp_change_loging_logo_title');// Change login logo title
		add_filter('admin_footer_text', 'sp_modify_footer_admin'); // Customising footer text	

/*-----------------------------------------------------------------------------------*/
/*	theme set up
/*-----------------------------------------------------------------------------------*/
function sp_theme_setup() {
	
	if ( ! isset( $content_width ) ) $content_width = 620; 	// Set the $content_width for things such as video embeds.
	
	// Make theme available for translation
	load_theme_textdomain( strtolower(THEME_NAME), SP_BASE_DIR . 'languages' );
	
	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );
	
	// Editor style
	add_editor_style('css/editor-style.css');
	
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'top_nav' => __( 'Top Navigation', 'sptheme_admin' ),
		'primary_nav' => __( 'Primary Navigation', 'sptheme_admin' ),
		'footer_nav'  => __( 'Footer Navigation', 'sptheme_admin' )
	) );

	if ( function_exists( 'add_image_size' ) ){
		add_image_size( 'sp-small', 70, 70, true );
		add_image_size( 'sp-large', 300, 160, true );
		add_image_size( 'slider', 620, 330, true );
	}

	if ( function_exists( 'add_theme_support' ) ){
		add_theme_support( 'post-thumbnails' ); // Add theme support for post thumbnails (featured images).
		add_theme_support( 'post-formats', array( 'audio', 'video', 'link' ) ); // aside, gallery, image, link, quote, video, audio
		add_theme_support( 'automatic-feed-links' ); // Add theme support for automatic feed links.
	}
	
}

/*-----------------------------------------------------------------------------------*/
/*	Add Pretty Photo to default link of post image attache
/*-----------------------------------------------------------------------------------*/
defined('WP_PRETTY_PHOTO_PLUGIN_ACTIVE')
        || define('WP_PRETTY_PHOTO_PLUGIN_ACTIVE', class_exists( 'WP_prettyPhoto' ) );


// if the WP-prettyPhoto plugin is not active handle rel="wp-prettyPhoto" in links for the prettyPhoto integrated script (if enabled)
if ( !WP_PRETTY_PHOTO_PLUGIN_ACTIVE ) {
    /**
     * Insert rel="wp-prettyPhoto" to all links for images, movie, YouTube and iFrame. 
     * This function will ignore links where you have manually entered your own rel reference.
     * @param string $content Post/page contents
     * @return string Prettified post/page contents
     * @link http://0xtc.com/2008/05/27/auto-lightbox-function.xhtml
     * @access public
      */
    function autoinsert_rel_prettyPhoto ($content) {
        global $post;
        $rel = 'wp-prettyPhoto';
        $image_match = '\.bmp|\.gif|\.jpg|\.jpeg|\.png';
        $movie_match = '\.mov.*?';
        $swf_match = '\.swf.*?';
        $youtube_match = 'http:\/\/www\.youtube\.com\/watch\?v=[A-Za-z0-9]*';
        $iframe_match = '.*iframe=true.*';
        $pattern[0] = "/<a(.*?)href=('|\")([A-Za-z0-9\/_\.\~\:-]*?)(".$image_match."|".$movie_match."|".$swf_match."|".$youtube_match."|".$iframe_match.")('|\")([^\>]*?)>/i";
        $pattern[1] = "/<a(.*?)href=('|\")([A-Za-z0-9\/_\.\~\:-]*?)(".$image_match."|".$movie_match."|".$swf_match."|".$youtube_match."|".$iframe_match.")('|\")(.*?)(rel=('|\")".$rel."(.*?)('|\"))([ \t\r\n\v\f]*?)((rel=('|\")".$rel."(.*?)('|\"))?)([ \t\r\n\v\f]?)([^\>]*?)>/i";
        $replacement[0] = '<a$1href=$2$3$4$5$6 rel="'.$rel.'['.$post->ID.']">';
        $replacement[1] = '<a$1href=$2$3$4$5$6$7>';
        $content = preg_replace($pattern, $replacement, $content);
        return $content;
    }
    add_filter('the_content', 'autoinsert_rel_prettyPhoto');
    add_filter('the_excerpt', 'autoinsert_rel_prettyPhoto');


    // Add the 'wp-prettyPhoto' rel attribute to the default WP gallery links
    function gallery_prettyPhoto ($content) {
            // add checks if you want to add prettyPhoto on certain places (archives etc).
            return str_replace("<a", "<a rel='wp-prettyPhoto[gallery]'", $content);
    }
    add_filter( 'wp_get_attachment_link', 'gallery_prettyPhoto');
}

/* ---------------------------------------------------------------------- */
/*	Register CSS and JS
/* ---------------------------------------------------------------------- */

function sp_register_assets() {	
	
	if( !is_admin() ) {
		
		//CSS
		//wp_register_style( 'g_droidsans', 'http://fonts.googleapis.com/css?family=Droid+Sans', false, SP_SCRIPTS_VERSION );
		wp_register_style( 'sp-theme-styles', SP_BASE_URL . 'style.css', false, THEME_VERSION );
		wp_register_style( 'video',         SP_BASE_URL . 'css/video-js.min.css', false, SP_SCRIPTS_VERSION );
		wp_register_style( 'audioplayerv1',    SP_BASE_URL . 'css/audioplayerv1.min.css', false, SP_SCRIPTS_VERSION );
		//wp_register_style( 'shortcodes',    SP_BASE_URL . 'css/shortcodes.css', false, SP_SCRIPTS_VERSION );
		//addon style 'PrettyPhoto'
		if ( !WP_PRETTY_PHOTO_PLUGIN_ACTIVE )
			wp_register_style('pretty_photo', SP_BASE_URL . 'js/prettyPhoto/css/prettyPhoto.css', false, SP_SCRIPTS_VERSION, 'screen');
			
		//JS
		/* Register our scripts -----------------------------------------------------*/
		/*wp_deregister_script('jquery');
		wp_register_script( 'jquery',   'http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js', array(), '1.8.2', false ); //use for online */
		wp_register_script( 'modernizr_custom',  SP_BASE_URL . 'js/modernizr.custom.js', array('jquery'), SP_SCRIPTS_VERSION, false );
		wp_register_script( 'video-js',          SP_BASE_URL . 'js/video-js.min.js', array('jquery'), SP_SCRIPTS_VERSION, false );
		wp_register_script( 'selectivizr',       SP_BASE_URL . 'js/selectivizr-min.js', array('jquery'), SP_SCRIPTS_VERSION, true );
		wp_register_script( 'audioplayerv1',     SP_BASE_URL . 'js/audioplayerv1.min.js', array('jquery'), SP_SCRIPTS_VERSION, true );

		wp_register_script( 'cycle',     SP_BASE_URL . 'js/jquery.cycle.all.min.js', array('jquery'), SP_SCRIPTS_VERSION, true );
		wp_register_script( 'easing',     SP_BASE_URL . 'js/jquery.easing-1.3.pack.js', array('jquery'), SP_SCRIPTS_VERSION, true );
		wp_register_script( 'validation',     SP_BASE_URL . 'js/validation.js', array('jquery'), SP_SCRIPTS_VERSION, true );//scrollable plugin script 
	
		// PrettyPhoto script
		if( !WP_PRETTY_PHOTO_PLUGIN_ACTIVE ) {
			wp_register_script('pretty_photo_lib', SP_BASE_URL . "js/prettyPhoto/js/jquery.prettyPhoto.js", array('jquery'), SP_SCRIPTS_VERSION, false);
			wp_register_script('custom_pretty_photo', SP_BASE_URL . "js/prettyPhoto/custom_params.js", array('pretty_photo_lib'), SP_SCRIPTS_VERSION, false);
		}
		wp_register_script( 'custom_scripts',    SP_BASE_URL . 'js/custom.js', array('jquery'), THEME_VERSION, true );	
	} 

}

/* ---------------------------------------------------------------------- */
/*	Enqueue/print CSS
/* ---------------------------------------------------------------------- */
function sp_enqueue_styles() {

	if( !is_admin() ) {
		//wp_enqueue_style('g_droidsans');
		wp_enqueue_style('sp-theme-styles');
		wp_enqueue_style('video');
		wp_enqueue_style('audioplayerv1');
		//wp_enqueue_style('shortcodes');
		
		if ( !WP_PRETTY_PHOTO_PLUGIN_ACTIVE )
			wp_enqueue_style('pretty_photo');
	} 

}

/* ---------------------------------------------------------------------- */
/*	Enqueue/print JS
/* ---------------------------------------------------------------------- */
function sp_enqueue_scripts() {
	if( !is_admin() ) {
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-widget');
		wp_enqueue_script('modernizr_custom');
		wp_enqueue_script('video-js');
		wp_enqueue_script('audioplayerv1');	
		wp_enqueue_script('cycle');
		wp_enqueue_script('easing');	
		wp_enqueue_script('validation');
		
		// For Internet Explorer
		global $is_IE;

		if( $is_IE )
			wp_enqueue_script('selectivizr');
			
		// PrettyPhoto script
		if( !WP_PRETTY_PHOTO_PLUGIN_ACTIVE ) {
			wp_enqueue_script('pretty_photo_lib');
			wp_enqueue_script('custom_pretty_photo');	
		}	
		wp_enqueue_script('custom_scripts');
	}
}
//custom scripts
function sp_print_css_js() {
	
	global $smof_data;
	
	if (!is_admin()) {
		wp_register_script( 'scroll_to_top',    SP_BASE_URL . 'js/scroll.to.top.js', array(), THEME_VERSION, false, false );
		wp_enqueue_script('scroll_to_top');
		//VideoJS Flash fallback url
		?>

		<script type='text/javascript'>
        _V_.options.flash.swf = '<?php echo SP_BASE_URL; ?>js/video-js.swf';
        </script>
        
        <style type="text/css">
        /*.bg-cover{
				background-image : url('http://themes.tielabs.com/jarida/wp-content/uploads/2013/03/DSC09005cc.jpg') ;
			filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='http://themes.tielabs.com/jarida/wp-content/uploads/2013/03/DSC09005cc.jpg',sizingMethod='scale');
			-ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='http://themes.tielabs.com/jarida/wp-content/uploads/2013/03/DSC09005cc.jpg',sizingMethod='scale')";
		}*/
		</style>
		<?php
	}
}


/* ---------------------------------------------------------------------- */
/*	Visual editor improvment
/* ---------------------------------------------------------------------- */
	
/*
* Add buttons to visual editor first row
*
* $buttons = ARRAY [default WordPress visual editor buttons array]
*/
if ( ! function_exists( 'sp_add_buttons_row1' ) ) {
	function sp_add_buttons_row1( $buttons ) {
		//inserting buttons after "italic" button
		$pos = array_search( 'italic', $buttons, true );
		if ( $pos != false ) {
			$add = array_slice( $buttons, 0, $pos + 1 );
			$add[] = 'underline';
			$buttons = array_merge( $add, array_slice( $buttons, $pos + 1 ) );
		}

		//inserting buttons after "justifyright" button
		$pos = array_search( 'justifyright', $buttons, true );
		if ( $pos != false ) {
			$add = array_slice( $buttons, 0, $pos + 1 );
			$add[] = 'justifyfull';
			$buttons = array_merge( $add, array_slice( $buttons, $pos + 1 ) );
		}
		
		return $buttons;
	}
} // /sp_add_buttons_row1

/*
* Add buttons to visual editor second row
*
* $buttons = ARRAY [default WordPress visual editor buttons array]
*/
if ( ! function_exists( 'sp_add_buttons_row2' ) ) {
	function sp_add_buttons_row2( $buttons ) {
		//inserting buttons before "underline" button
		$pos = array_search( 'underline', $buttons, true );
		if ( $pos != false ) {
			$add = array_slice( $buttons, 0, $pos );
			$add[] = 'removeformat';
			$add[] = '|';
			$buttons = array_merge( $add, array_slice( $buttons, $pos + 1 ) );
		}

		//remove "justify full" button from second row
		$pos = array_search( 'justifyfull', $buttons, true );
		if ( $pos != false ) {
			unset( $buttons[$pos] );
			$add = array_slice( $buttons, 0, $pos + 1 );
			$add[] = '|';
			$add[] = 'sub';
			$add[] = 'sup';
			$add[] = '|';
			$buttons = array_merge( $add, array_slice( $buttons, $pos + 1 ) );
		}

		return $buttons;
	}
} // sp_add_buttons_row2

//Display thumbnails in RSS
if ( ! function_exists( 'sp_rss_post_thumbnail' ) ) {
	function sp_rss_post_thumbnail( $content ) {
		global $post;

		if ( has_post_thumbnail( $post->ID ) )
			$content = '<p>' . get_the_post_thumbnail( $post->ID ) . '</p>' . get_the_content();

		return $content;
	}
} // /sp_rss_post_thumbnail


/* ---------------------------------------------------------------------- */
/*	Customizable login screen and WordPress admin area
/* ---------------------------------------------------------------------- */
// Custom logo login
function sp_custom_login_logo() {
    echo '<style type="text/css">
		body.login{ background-color:#ffffff; }
        .login h1 a { background-image:url('.SP_BASE_URL.'images/logo.png) !important; height:140px !important; background-size: auto auto !important;}
    </style>';
}

//  Remove wordpress link on admin login logo
function sp_remove_link_on_admin_login_info() {
     return  get_bloginfo('url');
}

// Change login logo title
function sp_change_loging_logo_title(){
	return 'Go to '.get_bloginfo('name').' Homepage';
}

//	Remove logo and other items in Admin menu bar
function sp_remove_admin_bar_links() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
	$wp_admin_bar->remove_menu('wp-logo');
}


// Customising footer text
function sp_modify_footer_admin () {  
  echo 'Created by <a href="http://www.novacambodia.com" target="_blank">novadesign</a>. Powered by <a href="http://www.wordpress.org" target="_blank">WordPress</a>';  
}  

/* ---------------------------------------------------------------------- */
/*	Other hook
/* ---------------------------------------------------------------------- */

// Sets the post excerpt length by word
function sp_excerpt_length( $length ) {
	global $post;
	
	$content = $post->post_content;
	$words = explode(' ', $content, $length + 1);
	if(count($words) > $length) :
		array_pop($words);
		array_push($words, '...');
		$content = implode(' ', $words);
	endif;
  
	$content = strip_tags(strip_shortcodes($content));
  
	return $content;

}

if ( ! function_exists( 'sp_auto_excerpt_more' ) ) {
	function sp_auto_excerpt_more( $more ) {
		return '&hellip;';
	}
} 

// Makes some changes to the <title> tag, by filtering the output of wp_title()
function sp_filter_wp_title( $title, $separator ) {

	if ( is_feed() ) return $title;

	global $paged, $page;

	if ( is_search() ) {
		$title = sprintf(__('Search results for %s', 'sptheme_admin'), '"' . get_search_query() . '"');

		if ( $paged >= 2 )
			$title .= " $separator " . sprintf(__('Page %s', 'sptheme_admin'), $paged);

		$title .= " $separator " . get_bloginfo('name', 'display');

		return $title;
	}

	$title .= get_bloginfo('name', 'display');
	$site_description = get_bloginfo('description', 'display');

	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $separator " . $site_description;

	if ( $paged >= 2 || $page >= 2)
		$title .= " $separator " . sprintf(__('Page %s', 'sptheme_admin'), max($paged, $page) );

	return $title;

}

// Remove dashboard widget
function sp_disable_default_dashboard_widgets() {  
    //remove_meta_box('dashboard_right_now', 'dashboard', 'core');  
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');  
    //remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');  
    remove_meta_box('dashboard_plugins', 'dashboard', 'core');  
    //remove_meta_box('dashboard_quick_press', 'dashboard', 'core');  
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');  
    remove_meta_box('dashboard_primary', 'dashboard', 'core');  
    remove_meta_box('dashboard_secondary', 'dashboard', 'core');  
}  


//  Set favicons for backend code
function sp_adminfavicon() {
echo '<link rel="icon" type="image/x-icon" href="'.SP_BASE_URL.'favicon.ico" />';
}


// unregister all default WP Widgets
function sp_unregister_default_wp_widgets() {
    /*unregister_widget('WP_Widget_Pages');
    unregister_widget('WP_Widget_Calendar');
    unregister_widget('WP_Widget_Archives');
	unregister_widget('WP_Widget_Text');
	unregister_widget('WP_Widget_Categories');
    unregister_widget('WP_Widget_Recent_Posts');
    unregister_widget('WP_Nav_Menu_Widget');
	unregister_widget('WP_Widget_Search');
	*/
    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_Tag_Cloud');
	unregister_widget('WP_Widget_RSS');
	unregister_widget('WP_Widget_Meta');
}