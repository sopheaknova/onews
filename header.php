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
    
    <script type="text/javascript">
	jQuery(document).ready(function($) {
		
		//mushead roat ads
		$('.mushead-roate-ads').cycle({
			fx:       'fade',
			slideExpr: 'img',
			next:   '.next-ads', 
    		prev:   '.prev-ads',
			timeout:   7000,
			speed: 500,
			pause: true
		});
		
		//featured news slideshow
		$('#featured-slideshow').cycle({
			fx:       '<?php echo $smof_data['cycle_effect']; ?>',
			slideExpr: '.cat-slide-items',
			timeout:   <?php echo $smof_data['cycle_timeout']; ?>,
			speed: <?php echo $smof_data['cycle_speed']; ?>,
			slideResize: 0,
			after: feature_slide_after,
			before: feature_slide_before,
			pager: 'ul.slider-nav',
			pause: true,
			pagerAnchorBuilder: function(idx, slide) { 
				// return selector string for existing anchor 
				return 'ul.slider-nav li:eq(' + idx + ') a'; 
			} 
		});
		
		function feature_slide_after() {
			$('#featured-slideshow .caption').stop().animate({opacity:1, bottom:0},{queue:false,duration:300 });
		}
		   
		function feature_slide_before() {
			$('#featured-slideshow .caption').stop().animate({opacity:1, bottom:'-120px'},{queue:false,duration:300});
		}
		
		//slider nav
		$('.slider-nav li:not(.activeSlide) a').click( 
				function () {
					$('.slider-nav li a').css('opacity', 0.7);
					$(this).css('opacity', 1);
				}
			);
			
		
		$('.slider-nav li:not(.slider-nav) a').hover( 
				function () {
					$(this).stop(true, true).animate({opacity: 1}, 300);
				}, function () {
					$(this).stop(true, true).animate({opacity: 0.7}, 300);
				}
			);
		
	});
	</script>
    
</head>

<body <?php body_class(); ?>>

<div class="bg-cover"></div>

<div class="wrapper layout-2c">
	
    <?php if($smof_data['show_topbar']): ?>
    <section class="top-nav head_menu">
        <div class="container clearfix">
            <div class="search-block">
                <?php get_search_form(); ?>
            </div><!-- .search-block /-->
            
            <?php 
			if ($smof_data['topbar_social']) 
				sp_get_social( 'yes' , 'flat' , 'tooldown' , true ); 
			?>
            
            <?php echo sp_top_navigation(); ?>
        </div><!-- end .container -->
    </section><!-- end .top-menu -->
    <?php endif; ?>
    
	<header id="header">
    	<div class="container clearfix">
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
        
        <?php if ( $smof_data['ads_top'] ) : ?>
        <div class="widget ads-widget ads-top">
        	<a href="#"><img src="<?php echo SP_BASE_URL; ?>images/ads/ads-top-728x90.gif" width="728" height="90" /></a>
        </div><!-- end .widget .ads-widget .top-ads -->
        <?php endif; ?>
        
        </div><!-- end .container -->
    </header>
    
    <?php $stick = ''; ?>
	<?php if( $smof_data['stick_nav'] ) $stick = 'fixed-enabled' ?>
    <nav id="main-nav" class="clearfix <?php echo $stick; ?> ">
        <?php echo sp_main_navigation(); ?>
    </nav><!-- end #main-nav .container .clearfix -->
    
    <?php if ( $smof_data[ 'breaking_news' ] ) : ?>
    <section id="ticker-news" class="clearfix">
    <?php require_once( SP_BASE_DIR . 'includes/news-ticker-scroll.php' ); ?>
    </section>
    <?php endif; ?>
    
    <?php if ( $smof_data['ads_mushead'] ) : ?>
    <section id="mushead">
    	<div class="widget ads-widget mushead-roate-ads">
        	<a href="#"><img src="<?php echo SP_BASE_URL; ?>images/ads/mushead-ads-sample-01.jpg" width="728" height="90" /></a>
            <a href="#"><img src="<?php echo SP_BASE_URL; ?>images/ads/mushead-ads-sample-02.jpg" width="728" height="90" /></a>
            <a href="#"><img src="<?php echo SP_BASE_URL; ?>images/ads/mushead-ads-sample-03.jpg" width="728" height="90" /></a>
        </div><!-- end .widget .ads-widget .mushead-roate-ads-->
        <a class="prev-ads" href="#"><?php _e( 'Previous', 'sptheme' ); ?></a>
        <a class="next-ads" href="#"><?php _e( 'Next', 'sptheme' ); ?></a>
    </section>
    <?php endif; ?>




