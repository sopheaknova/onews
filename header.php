<?php
	/* get theme options for further processing */
	global $smof_data, $is_IE; 
?>
<!DOCTYPE html>
<!--[if IE 7]>                  <html class="ie7 no-js"  <?php language_attributes(); ?> prefix="og: http://ogp.me/ns#">     <![endif]-->
<!--[if lte IE 8]>              <html class="ie8 no-js"  <?php language_attributes(); ?> prefix="og: http://ogp.me/ns#">     <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="not-ie no-js" <?php language_attributes(); ?> prefix="og: http://ogp.me/ns#">  <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	
    <title>
	<?php wp_title( '|', true, 'right' ); ?>
    </title>
   	
    <link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <link rel="shortcut icon" href="<?php echo ($smof_data['theme_favico'] == '') ? SP_BASE_URL.'favicon.ico' : $smof_data['theme_favico']; ?>" type="image/x-icon" /> 
    
	<?php wp_head(); ?>
    
</head>

<body <?php body_class(); ?>>

<div class="bg-cover"></div>

<div class="wrapper layout-2c">
	
    <?php if($smof_data['show_topbar']): ?>
    <div class="top-nav head_menu">
        <div class="container">
            <div class="search-block">
                <?php get_search_form(); ?>
            </div><!-- .search-block /-->
            
            <?php 
			if ($smof_data['topbar_social']) 
				sp_get_social( 'yes' , 'flat' , 'tooldown' , true ); 
			?>
            
            <?php echo sp_top_navigation(); ?>
            
        </div><!-- end .container -->
    </div><!-- end .top-menu -->
    <?php endif; ?>
    
	<header id="header" class="clearfix">
    	<div class="logo">
        	<?php if( !is_singular() ) echo '<h1>'; else echo '<h2>'; ?>
            
            <a  href="<?php echo home_url() ?>/"  title="<?php echo esc_attr( get_bloginfo('name', 'display') ); ?>">
            	<?php if($smof_data['theme_logo'] !== '') : ?>
                <img src="<?php echo $smof_data['theme_logo']; ?>" alt="<?php echo esc_attr( get_bloginfo('name', 'display') ); ?>">
                <?php else: ?>
                <span><?php bloginfo( 'description' ); ?></span>
                <?php endif; ?>
			</a>
            
            <?php if( !is_singular() ) echo '</h1>'; else echo '</h2>'; ?>
        </div><!-- end .logo -->
    </header>
    
    <?php $stick = ''; ?>
	<?php if( $smof_data['stick_nav'] ) $stick = 'fixed-enabled' ?>
    <nav id="main-nav" class="container clearfix <?php echo $stick; ?> ">
        <?php echo sp_main_navigation(); ?>
    </nav><!-- end #main-nav .container .clearfix -->
    
    <?php if ( $smof_data[ 'breaking_news' ] ) : ?>
    <section id="ticker-news" class="container clearfix">
    <?php require_once( SP_BASE_DIR . 'includes/breaking-news.php' ); ?>
    </section>
    <?php endif; ?>




