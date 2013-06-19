<?php 

/* ---------------------------------------------------------------------- */
/*	Basic Theme Settings
/* ---------------------------------------------------------------------- */
$shortname = get_template();

//WP 3.4+ only
$themeData     = wp_get_theme( $shortname );
$themeName     = $themeData->Name;
$themeVersion  = $themeData->Version;
	
define( 'SP_BASE_DIR', TEMPLATEPATH . '/' );
define( 'SP_BASE_URL', get_template_directory_uri() . '/' );
define( 'THEME_VERSION', $themeData->Version);
define( 'THEME_NAME', 'KPT'); // should be $themeName but it's too long
define( 'SP_SCRIPTS_VERSION', 20130605 );
define( 'SP_ADMIN_LIST_THUMB', '64x64' ); //thumbnail size (width x height) on post/page/custom post listings


//Custom post WordPress admin menu position - 30, 33, 39, 42, 45, 48
	if ( ! isset( $cpMenuPosition ) )
		$cpMenuPosition = array(
				'slideshow'		=> 30,
			);

/* ---------------------------------------------------------------------- */
/*	Setup and Load Parts
/* ---------------------------------------------------------------------- */

// Add setup functions
require_once( SP_BASE_DIR . 'framework/functions/setup-theme.php' );
require_once( SP_BASE_DIR . 'framework/functions/theme-functions.php' );
require_once( SP_BASE_DIR . 'framework/functions/aq_resizer.php');

// Add shortcodes
require_once( SP_BASE_DIR . 'framework/shortcode/shortcodes.php');

// Add CPT
require_once( SP_BASE_DIR . 'framework/custom-posts/custom-posts.php');

// Add widgets
require_once( SP_BASE_DIR . 'framework/widgets/widgets.php' );

// Add Admin Option
require_once( SP_BASE_DIR . 'framework/admin/index.php' );

// Add metaboxes
require_once( SP_BASE_DIR . 'framework/meta-box/class.php' );
require_once( SP_BASE_DIR . 'framework/meta-box/meta-boxes.php' );

// Addon custom functions
require_once( SP_BASE_DIR . 'includes/breadcrumbs.php' );
require_once( SP_BASE_DIR . 'includes/wp-list-comments.php' );
