<?php get_header(); ?>

<div class="container clearfix"><?php sp_breadcrumbs() ?></div>

<section id="content" class="clearfix  sidebar-right">

	<div class="container">

		<section id="main">
        
        <div class="page-header">

			<?php if ( have_posts() ): ?>
				
				<h2 class="title">
					<?php
						printf( __( 'Tag', 'sptheme' ), '<span>' . single_tag_title( '', false ) . '</span>' );
					?>
				</h2>

				<?php rewind_posts(); ?>
				
			<?php else: ?>
			
					<h1 class="page-title"><?php _e( 'Nothing Found', 'sptheme' ); ?></h1>

			<?php endif; ?>
            
            <?php if( $smof_data[ 'tag_rss' ] ): ?>
			<a class="rss-cat-icon tooltip" title="<?php _e( 'Feed Subscription', 'sptheme' ); ?>"  href="<?php echo  get_term_feed_link($tag_id , 'post_tag', "rss2") ?>"><?php _e( 'Feed Subscription', 'sptheme' ); ?></a>
			<?php endif; ?>
            <div class="clear"></div>

		</div><!-- end .page-header -->


		<?php if ( have_posts() ) : ?>

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
