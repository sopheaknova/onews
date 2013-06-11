<?php get_header(); ?>

<div class="container clearfix"><?php sp_breadcrumbs() ?></div>

<section id="content" class="clearfix sidebar-right">

	<div class="container">

		<section id="main">
		
        <div class="page-header">

			<?php if ( have_posts() ): ?>
			
					<h2 class="title"><?php printf( __( 'Author Archives: %s', 'sptheme' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?></h2>

			<?php else: ?>
			
					<h2 class="title"><?php _e( 'Nothing Found', 'sptheme' ); ?></h2>

			<?php endif; ?>
            
            <?php if( $smof_data[ 'author_rss' ] ): ?>
        	<a class="rss-cat-icon ttip" title="<?php _e( 'Feed Subscription', 'sptheme' ); ?>"  href="<?php echo get_author_feed_link( get_the_author_meta('ID') ); ?>"><?php _e( 'Feed Subscription', 'sptheme' ); ?></a>
        	<?php endif; ?>
            <div class="clear"></div>

		</div><!-- end .page-header -->	

		<?php if ( have_posts() ) : the_post(); ?>
			
            <?php if( $smof_data[ 'author_bio' ] ): ?>
            <div class="author-bio">
                <div id="author-avatar">
                    <?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'sp_author_bio_avatar_size', 70 ) ); ?>
                </div><!-- #author-avatar -->
                
                <div id="author-description">
                    <?php the_author_meta( 'description' ); ?>
                </div><!-- #author-description -->
                <div class="author-social">
                    <?php if ( get_the_author_meta( 'url' ) ) : ?>
                    <a class="ttip" href="<?php the_author_meta( 'url' ); ?>" title="<?php the_author_meta( 'display_name' ); ?><?php _e( " 's site", 'sptheme' ); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/socialicons/site.png" alt="" /></a>
                    <?php endif ?>	
                    <?php if ( get_the_author_meta( 'twitter' ) ) : ?>
                    <a class="ttip" href="http://twitter.com/<?php the_author_meta( 'twitter' ); ?>" title="<?php the_author_meta( 'display_name' ); ?><?php _e( '  on Twitter', 'sptheme' ); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/socialicons/twitter.png" alt="" /></a>
                    <?php endif ?>	
                    <?php if ( get_the_author_meta( 'facebook' ) ) : ?>
                    <a class="ttip" href="<?php the_author_meta( 'facebook' ); ?>" title="<?php the_author_meta( 'display_name' ); ?> <?php _e( '  on Facebook', 'sptheme' ); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/socialicons/facebook.png" alt="" /></a>
                    <?php endif ?>
                    <?php if ( get_the_author_meta( 'google' ) ) : ?>
                    <a class="ttip" href="<?php the_author_meta( 'google' ); ?>" title="<?php the_author_meta( 'display_name' ); ?> <?php _e( '  on Google+', 'sptheme' ); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/socialicons/google_plus.png" alt="" /></a>
                    <?php endif ?>	
                    <?php if ( get_the_author_meta( 'linkedin' ) ) : ?>
                    <a class="ttip" href="<?php the_author_meta( 'linkedin' ); ?>" title="<?php the_author_meta( 'display_name' ); ?> <?php _e( '  on Linkedin', 'sptheme' ); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/socialicons/linkedin.png" alt="" /></a>
                    <?php endif ?>				
                    <?php if ( get_the_author_meta( 'flickr' ) ) : ?>
                    <a class="ttip" href="<?php the_author_meta( 'flickr' ); ?>" title="<?php the_author_meta( 'display_name' ); ?><?php _e( '  on Flickr', 'sptheme' ); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/socialicons/flickr.png" alt="" /></a>
                    <?php endif ?>	
                    <?php if ( get_the_author_meta( 'youtube' ) ) : ?>
                    <a class="ttip" href="<?php the_author_meta( 'youtube' ); ?>" title="<?php the_author_meta( 'display_name' ); ?><?php _e( '  on YouTube', 'sptheme' ); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/socialicons/youtube.png" alt="" /></a>
                    <?php endif ?>
                    <?php if ( get_the_author_meta( 'pinterest' ) ) : ?>
                    <a class="ttip" href="<?php the_author_meta( 'pinterest' ); ?>" title="<?php the_author_meta( 'display_name' ); ?><?php _e( '  on Pinterest', 'sptheme' ); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/socialicons/pinterest.png" alt="" /></a>
                    <?php endif ?>	
                </div>
            </div>
            <?php endif; ?>
            
            <?php rewind_posts(); ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix item-list'); ?>>

					<?php get_template_part( 'content', get_post_format() ); ?>

				</article><!-- end .hentry -->

			<?php endwhile; ?>

			<?php // Pagination
				if(function_exists('wp_pagenavi'))
					wp_pagenavi();
				else 
					echo sp_pagination(); 
			?>
			
		<?php else: ?>
		
			<article id="post-0" class="post no-results not-found">
		
				<h3><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for...', 'sptheme' ); ?></h3>

			</article><!-- end .hentry -->

		<?php endif; ?>
		

			</section><!-- end #main -->

			<?php get_sidebar(); ?>
        
    </div><!-- end .container.clearfix -->    

</section><!-- end #content -->

<?php get_footer(); ?>
