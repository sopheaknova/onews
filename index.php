<?php get_header(); ?>
<div id="content" class="clearfix">
	<div class="container">
    
    <div id="main">
    
    <?php
	//get homepage module blocks
	$layout = $smof_data['homepage_blocks']['enabled'];
	if ($layout):
		foreach ($layout as $key=>$value) {
		
			switch($key) {
		
			case 'home_slider':
			require_once( SP_BASE_DIR . 'includes/custom/slider.php');
			
			case 'home_ads_1':
			require_once( SP_BASE_DIR . 'includes/custom/home-ads-1.php' );
			
			case 'home_cat_tabs':
			require_once( SP_BASE_DIR . 'includes/custom/home-cats-tabs.php');
			
			case 'home_cat_box_1':
			require_once( SP_BASE_DIR . 'includes/custom/home-cats.php');
			
			case 'home_ads_2':
			require_once( SP_BASE_DIR . 'includes/custom/home-ads-2.php' );

			case 'home_cat_scroll':
			require_once( SP_BASE_DIR . 'includes/custom/home-cat-scroll.php');
			
			}
		}
	endif;	
	?>
    
    <!--START CONTENTS SECTION BLOCK-->
    
    
    <!--END CONTENTS SECTION BLOCK-->
    </div><!-- end #main -->
    
	<?php get_sidebar(); ?>
	
    </div><!-- end .container -->
</div><!-- end #content -->

<?php get_footer(); ?>