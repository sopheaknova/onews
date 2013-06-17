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
		
			case 'home_cat_scroll':
			require_once( SP_BASE_DIR . 'includes/custom/home-cat-scroll.php');
			
			}
		}
	endif;	
	?>
    
    </div><!-- end #main -->
    
	<?php get_sidebar(); ?>
	
    </div><!-- end .container -->
</div><!-- end #content -->

<?php get_footer(); ?>