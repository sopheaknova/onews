<?php get_header(); ?>

<section id="content" class="clearfix">

	<div class="container clearfix">
		
        <center>
		<header class="page-header">
		
			<h1 class="title"><?php _e( 'Apologies, but the page you requested could not be found.', 'sptheme' ); ?></h1>

		<article id="post-0" class="post error404 not-found">
		
        	<h4><?php printf( __('<strong>Start over again</strong> with the %1$sHomepage%2$s.', 'sptheme'), '<a href="'.get_bloginfo('url').'">', '</a>' ); ?></h4>
		
		</article><!-- end .hentry -->
        
        </header><!-- end .page-header -->
        
        
        </center>
        
    </div><!-- end .container.clearfix -->    

</section><!-- end #content -->

<?php get_footer(); ?>
