<?php get_header(); ?>

<div id="content" class="clearfix">
	<div class="container">
    
    <div id="main">
    <?php 
	$home_cat_1 = $smof_data[ 'cat_box_style' ];
	if ( $home_cat_1 )
		sp_get_home_cats(); 
	?>
    </div><!-- end #main -->
    
	<?php get_sidebar(); ?>
	
    </div><!-- end .container -->
</div><!-- end #content -->

<?php get_footer(); ?>