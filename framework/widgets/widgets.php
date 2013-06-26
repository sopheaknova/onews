<?php

/* ---------------------------------------------------------------------- */
/*	Add custom color of widget header
/* ---------------------------------------------------------------------- */
function load_custom_wp_admin_style() {
		wp_register_style( 'admin_addons', SP_BASE_URL . 'framework/assets/css/admin-addon.css', false, SP_SCRIPTS_VERSION );
		wp_enqueue_style( 'admin_addons' );
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );

/* ---------------------------------------------------------------------- */
/*	Register sidebars
/* ---------------------------------------------------------------------- */
function sp_widgets_init() {
	
	global $smof_data;
	
	// Main Widget Area
	register_sidebar(array(
		'name'          => __('Main Sidebar', 'sptheme_admin'),
		'id' => 'main-sidebar',
		'before_widget' => '<div class="widget %2$s"><div class="widget-container">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	));
	
	// Home Widget Area
	register_sidebar(array(
		'name'          => __('Home Sidebar', 'sptheme_admin'),
		'id' => 'home-sidebar',
		'before_widget' => '<div class="widget %2$s"><div class="widget-container">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	));
	
	// Dynamic sidebar generate
	$generate_sidebars = $smof_data['sidebar_options']; 
	if($generate_sidebars){
		foreach ($generate_sidebars as $sidebar) { 
			if ( function_exists('register_sidebar') )
			register_sidebar(array(
			'name' 			=> $sidebar['title'],
			'id'			=> str_replace(' ', '-', strtolower($sidebar['title'])),
			'description' 	=> 'Widgets in this area will be shown in the sidebar.',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-container">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h4 class="label-mod">',
			'after_title'   => '</h4>',
			));
		}
	}
	
	// Addon widgets		
	require_once ( SP_BASE_DIR . 'framework/widgets/widget-text-image.php' );
	require_once ( SP_BASE_DIR . 'framework/widgets/widget-video.php' );
	require_once ( SP_BASE_DIR . 'framework/widgets/widget-fb-likebox.php' );
	require_once ( SP_BASE_DIR . 'framework/widgets/widget-subnav.php' );
	require_once ( SP_BASE_DIR . 'framework/widgets/widget-tabbed.php' );
	require_once ( SP_BASE_DIR . 'framework/widgets/widget-category.php' );
	require_once ( SP_BASE_DIR . 'framework/widgets/widget-feedburner.php' );
	require_once ( SP_BASE_DIR . 'framework/widgets/widget-posts-list.php' );
	require_once ( SP_BASE_DIR . 'framework/widgets/widget-google-plus.php' );
	require_once ( SP_BASE_DIR . 'framework/widgets/widget-soundcloud.php' );
	require_once ( SP_BASE_DIR . 'framework/widgets/widget-social.php' );
	
	// Register widgets
	register_widget( 'sp_widget_text_image' );
	register_widget( 'sp_widget_video' );
	register_widget( 'sp_widget_fb_likebox' );
	register_widget( 'sp_widget_subnav' );
	register_widget( 'sp_widget_tabs' );
	register_widget( 'sp_widget_categort' );
	register_widget( 'sp_widget_feedburner' );
	register_widget( 'sp_widget_posts_list' );
	register_widget( 'sp_widget_google_plus' );
	register_widget( 'sp_widget_soundcloud' );
	register_widget( 'sp_widget_social' );

}
add_action('widgets_init', 'sp_widgets_init');

