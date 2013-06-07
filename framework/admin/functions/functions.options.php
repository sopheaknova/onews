<?php

add_action('init','of_options');

if (!function_exists('of_options'))
{
	function of_options()
	{
		//Access the WordPress Categories via an Array
		$of_categories 		= array();  
		$of_categories_obj 	= get_categories('hide_empty=0');
		foreach ($of_categories_obj as $of_cat) {
		    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
		$categories_tmp 	= array_unshift($of_categories, "Select a category:");    
	       
		//Access the WordPress Pages via an Array
		$of_pages 			= array();
		$of_pages_obj 		= get_pages('sort_column=post_parent,menu_order');    
		foreach ($of_pages_obj as $of_page) {
		    $of_pages[$of_page->ID] = $of_page->post_name; }
		$of_pages_tmp 		= array_unshift($of_pages, "Select a page:");       
	
		//Testing 
		$of_options_select 	= array("one","two","three","four","five"); 
		$of_options_radio 	= array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
		
		//Sample Homepage blocks for the layout manager (sorter)
		$of_options_homepage_blocks = array
		( 
			"disabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
				"block_one"		=> "Block One",
				"block_two"		=> "Block Two",
				"block_three"	=> "Block Three",
			), 
			"enabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
				"block_four"	=> "Block Four",
			),
		);


		//Stylesheets Reader
		$alt_stylesheet_path = LAYOUT_PATH;
		$alt_stylesheets = array();
		
		if ( is_dir($alt_stylesheet_path) ) 
		{
		    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) 
		    { 
		        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) 
		        {
		            if(stristr($alt_stylesheet_file, ".css") !== false)
		            {
		                $alt_stylesheets[] = $alt_stylesheet_file;
		            }
		        }    
		    }
		}


		//Background Images Reader
		$bg_images_path = SP_BASE_DIR. 'framework/assets/img/bg/'; // change this to where you store your bg images
		$bg_images_url = SP_BASE_URL.'framework/assets/img/bg/'; // change this to where you store your bg images
		$bg_images = array();
		
		if ( is_dir($bg_images_path) ) {
		    if ($bg_images_dir = opendir($bg_images_path) ) { 
		        while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
		            if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false || stristr($bg_images_file, ".gif") !== false) {
		                $bg_images[] = $bg_images_url . $bg_images_file;
		            }
		        }    
		    }
		}
		

		/*-----------------------------------------------------------------------------------*/
		/* TO DO: Add options/functions that use these */
		/*-----------------------------------------------------------------------------------*/
		
		//More Options
		$uploads_arr 		= wp_upload_dir();
		$all_uploads_path 	= $uploads_arr['path'];
		$all_uploads 		= get_option('of_uploads');
		$other_entries 		= array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
		$body_repeat 		= array("no-repeat","repeat-x","repeat-y","repeat");
		$body_pos 			= array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");
		
		// Image Alignment radio box
		$of_options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 
		
		// Image Links to Options
		$of_options_image_link_to = array("image" => "The Image","post" => "The Post"); 
		
		//cycle Slider
		$cycle_effects = array('fade' => 'fade', 'blindX' => 'blindX', 'blindY' => 'blindY', 'blindZ' => 'blindZ', 'cover' => 'cover', 'curtainX' => 'curtainX','curtainY' => 'curtainY', 'fadeZoom' => 'fadeZoom', 'growX' => 'growX', 'growY' => 'growY', 
	 'none' => 'none', 'scrollUp' => 'scrollUp', 'scrollDown' => 'scrollDown', 'scrollLeft' => 'scrollLeft', 
	 'scrollRight' => 'scrollRight', 'scrollHorz' => 'scrollHorz', 'scrollVert' => 'scrollVert',
	'shuffle' => 'shuffle', 'slideX' => 'slideX', 'slideY' => 'slideY', 'toss' => 'toss', 
	 'turnUp' => 'turnUp', 'turnDown' => 'turnDown', 'turnLeft' => 'turnLeft', 'turnRight' => 'turnRight', 'uncover' => 'uncover', 'wipe' => 'wipe', 'zoom' => 	'zoom');


/*-----------------------------------------------------------------------------------*/
/* The Options Array */
/*-----------------------------------------------------------------------------------*/

// Set the Options Array
global $of_options;
$of_options = array();

//General
$of_options[] = array( 	"name" 		=> "General Settings",
						"type" 		=> "heading"
				);
					
/*$url =  ADMIN_DIR . 'assets/images/';
$of_options[] = array( 	"name" 		=> "Main Layout",
						"desc" 		=> "Select main content and sidebar alignment. Choose between 1 or 2 column layout.",
						"id" 		=> "layout",
						"std" 		=> "2c-l-fixed.css",
						"type" 		=> "images",
						"options" 	=> array(
							'1col-fixed.css' 	=> $url . '1col.png',
							'2c-r-fixed.css' 	=> $url . '2cr.png',
							'2c-l-fixed.css' 	=> $url . '2cl.png',
							'3c-fixed.css' 		=> $url . '3cm.png',
							'3c-r-fixed.css' 	=> $url . '3cr.png'
						)
				);*/

$of_options[] = array( 	"name" 		=> "Custom Logo",
						"desc" 		=> "Upload a Png/Gif image that will represent your website's logo.",
						"id" 		=> "theme_logo",
						"std" 		=> SP_BASE_URL . "images/logo.png",
						"type" 		=> "upload"
				);
				
$of_options[] = array( 	"name" 		=> "Custom Favicon",
						"desc" 		=> "Upload a 16px x 16px Png/Gif image that will represent your website's favicon.",
						"id" 		=> "theme_favico",
						"std" 		=> SP_BASE_URL . "favicon.ico",
						"type" 		=> "upload"
				); 

$of_options[] = array( 	"name" 		=> "Show Topbar",
						"desc" 		=> "Choose if you want to show the topbar or not.",
						"id" 		=> "show_topbar",
						"std" 		=> 1,
						"type" 		=> "switch"
				);
								
$of_options[] = array( 	"name" 		=> "Tracking Code",
						"desc" 		=> "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.",
						"id" 		=> "google_analytics",
						"std" 		=> "",
						"type" 		=> "textarea"
				);
				
$of_options[] = array( 	"name" 		=> "Footer Text",
						"desc" 		=> "Enter your footer text",
						"id" 		=> "footer_text",
						"std" 		=> "© 2013 NOVA CAMBODIA",
						"type" 		=> "textarea"
				);
				
//Header
$of_options[] = array( 	"name" 		=> "Header Settings",
						"type" 		=> "heading"
				);	
				
$of_options[] = array( 	"name" 		=> "Breaking News",
						"desc" 		=> "Show/Hide breaking news",
						"id" 		=> "breaking_news",
						"std" 		=> 1,
						"type" 		=> "switch"
				);	

$of_options[] = array( "name" => 'Breaking News Setting',
					"desc" => "",
					"id" => "introduction",
					"std" => "<h3 style=\"margin: 0 0 10px;\">Breaking News Setting</h3>",
					"icon" => true,
					"type" => "info",
					);			
					
$of_options[] = array( "name" => 'Breaking News Title',
					"id" => "breaking_title",
					"std" => "",
					"type" => "text",
					);
					
$of_options[] = array( "name" => 'Animation Effect',
					"desc" => 'name of transition effect',
					"id" => "breaking_effect",
					"std" => "fade",
					"type" => "select",
					"options" => array(
									'fade' 	=>	'Fade',
									'slide'	=>	'Slide',
									'ticker'=>	'Ticker'
								)
					);
					
$of_options[] = array( "name" => 'Animation Speed',
					"id" => "breaking_speed",
					"std" => "750",
					"min" => "0",
					"step"	=> "50",
					"max" => "10000",
					"type" => "sliderui"
					);		
					
$of_options[] = array( "name" => 'Time between the fades',
					"id" => "breaking_time",
					"std" => "3500",
					"min" => "0",
					"step"	=> "50",
					"max" => "10000",
					"type" => "sliderui" 
					);
					
$of_options[] = array( "name" => 'Number Of Posts To Show',
					"id" => "breaking_number",
					"std" => "",
					"type" => "text",
					);		

$of_options[] = array( "name" => 'Breaking News Categories',
					"id" => "breaking_cat",
					"std" => "",
					"type" => "select",
					"options" => $of_categories,
					);																																	
				
				
//Feature Slide
$of_options[] = array( "name" => 'Featured Slideshow',
						"type" => "heading",
						"slug" => "feature"
						);

$of_options[] = array( "name" => 'Animation & Effects',
					"desc" => "",
					"id" => "introduction",
					"std" => "<h3 style=\"margin: 0 0 10px;\">Animation & Effects</h3>",
					"icon" => true,
					"type" => "info",
					);

$of_options[] = array( "name" => 'Effect',
					"desc" => 'name of transition effect',
					"id" => "cycle_effect",
					"std" => "fade",
					"type" => "select",
					"options" => $cycle_effects
					);

$of_options[] = array( "name" => 'Speed',
					"desc" => 'speed of the transition',
					"id" => "cycle_speed",
					"std" => "5000",
					"type" => "text",
					);

$of_options[] = array( "name" => 'timeout',
					"desc" => 'milliseconds between slide transitions',
					"id" => "cycle_timeout",
					"std" => "5000",
					"type" => "text",
					);				


//Post Setting	
			
$of_options[] = array( 	"name" 		=> "Article Settings",
						"type" 		=> "heading"
				);

$of_options[] = array( 	"name" 		=> "Time format",
						"desc" 		=> "Time format for blog posts",
						"id" 		=> "time_format",
						"std" 		=> "traditional",
						"type" 		=> "radio",
						"options" 	=> array(
										"traditional"	=>	"Traditinal",
										"modern"		=>	"Time Ago Format"
									)
				);

$of_options[] = array( 	"name" 		=> "Breadcrumbs Settings",
						"desc" 		=> "Show/Hide breadcrumb menu",
						"id" 		=> "breadcrumbs",
						"std" 		=> 1,
						"type" 		=> "switch"
				);

$of_options[] = array( "name" => 'Post Meta Settings',
					"desc" => "",
					"id" => "introduction",
					"std" => "<h3>Post Meta Settings</h3>",
					"icon" => true,
					"type" => "info",
					);
				
$of_options[] = array( 	"name" 		=> "Post Meta",
						"desc" 		=> "Show/Hide post meta",
						"id" 		=> "post_meta",
						"std" 		=> 1,
						"folds"		=> 1,
						"type" 		=> "switch"
				);
				
	$of_options[] = array( 	"name" 		=> "Posted by",
							"desc" 		=> "Show/Hide posted by",
							"id" 		=> "posted_by",
							"std" 		=> 1,
							"fold"		=> "post_meta",
							"type" 		=> "switch"
					);
				
	$of_options[] = array( 	"name" 		=> "Date Meta",
						"desc" 		=> "Show/Hide post date",
						"id" 		=> "post_date",
						"std" 		=> 1,
						"fold"		=> "post_meta",
						"type" 		=> "switch"
				);
				
	$of_options[] = array( 	"name" 		=> "Categories Meta",
						"desc" 		=> "Show/Hide categories",
						"id" 		=> "post_categories",
						"std" 		=> 1,
						"fold"		=> "post_meta",
						"type" 		=> "switch"
				);
				
	$of_options[] = array( 	"name" 		=> "Comments Meta",
						"desc" 		=> "Show/Hide comments",
						"id" 		=> "post_comments",
						"std" 		=> 1,
						"fold"		=> "post_meta",
						"type" 		=> "switch"
				);		
	
	$of_options[] = array( 	"name" 		=> "Views Meta",
						"desc" 		=> "Show/Hide views",
						"id" 		=> "post_views",
						"std" 		=> 1,
						"fold"		=> "post_meta",
						"type" 		=> "switch"
				);
				
	$of_options[] = array( 	"name" 		=> "Tags Meta",
						"desc" 		=> "Show/Hide tags",
						"id" 		=> "post_tags",
						"std" 		=> 1,
						"fold"		=> "post_meta",
						"type" 		=> "switch"
				);																		


//Style				
$of_options[] = array( 	"name" 		=> "Styling Options",
						"type" 		=> "heading"
				);

$of_options[] = array( 	"name" 		=> "Top Bar Background Color",
						"desc" 		=> "Pick a background color for the header (default: #fff).",
						"id" 		=> "top_bar_bg",
						"std" 		=> "#4B641B",
						"type" 		=> "color"
				);
								
$of_options[] = array( 	"name" 		=> "Body Background Color",
						"desc" 		=> "Pick a background color for the theme (default: #fff).",
						"id" 		=> "body_bg_color",
						"std" 		=> "#ffffff",
						"type" 		=> "color"
				);

$of_options[] = array( 	"name" 		=> "Background Images",
						"desc" 		=> "Select a background pattern.",
						"id" 		=> "body_bg_image",
						"std" 		=> $bg_images_url."bg0.png",
						"type" 		=> "tiles",
						"options" 	=> $bg_images,
				);				
				

				
//Sidebar Settings

$of_options[] = array( "name" => "Sidebar Settings",
					"type" => "heading");

$of_options[] = array( "name" => "Sidebar Options",
					"desc" => "",
					"id" => "sidebar_options",
					"std" => "",
					"type" => "sidebar");
																	
// Contact
$of_options[] = array( "name" => "Contact",
					"type" => "heading");					
					
$of_options[] = array( "name" => "Latitude",
					"desc" => "Latitude of google map see <a href='http://itouchmap.com'>itouchmap.com</a>",
					"id" => "map_lat",
					"std" => "11.558384",
					"type" => "text"
					);

$of_options[] = array( "name" => "Longitude",
					"desc" => "Longitude of google map see <a href='http://itouchmap.com'>itouchmap.com</a>",
					"id" => "map_long",
					"std" => "104.919965",
					"type" => "text"
					);											
					
$of_options[] = array( "name" => "Email",
					"desc" => "",
					"id" => "email",
					"std" => "info@irisfleurs69.com",
					"type" => "text"
					);
									
// Backup Options
$of_options[] = array( 	"name" 		=> "Backup Options",
						"type" 		=> "heading"
				);
				
$of_options[] = array( 	"name" 		=> "Backup and Restore Options",
						"id" 		=> "of_backup",
						"std" 		=> "",
						"type" 		=> "backup",
						"desc" 		=> 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.',
				);
				
$of_options[] = array( 	"name" 		=> "Transfer Theme Options Data",
						"id" 		=> "of_transfer",
						"std" 		=> "",
						"type" 		=> "transfer",
						"desc" 		=> 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".',
				);
				
	}//End function: of_options()
}//End chack if function exists: of_options()
?>
