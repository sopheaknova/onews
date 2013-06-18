<?php get_header(); ?>

<?php $has_sidebar = sp_check_page_layout(); ?>

<section id="content" class="clearfix sidebar-right">

	<div class="container">

		<section id="main">
		
        <div class="page-header">

			<?php if ( have_posts() ): ?>
			
					<h2 class="title"><?php printf( __( 'Category Archives: %s', 'sptheme' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?></h2>

			<?php else: ?>
			
					<h2 class="title"><?php _e( 'Nothing Found', 'sptheme' ); ?></h2>

			<?php endif; ?>
					
			<?php if( $smof_data[ 'category_rss' ] ): ?>
			<a class="rss-cat-icon ttip" title="<?php _e( 'Feed Subscription', 'tie' ); ?>" href="<?php echo get_category_feed_link($category_id) ?>"><?php _e( 'Feed Subscription', 'sptheme' ); ?></a>
			<?php endif; ?>
            <div class="clear"></div>
            
            <?php
			if( $smof_data[ 'category_desc' ] ):	
				$category_description = category_description();
				if ( ! empty( $category_description ) )
				echo '<div class="clear"></div><div class="archive-meta">' . $category_description . '</div>';
			endif;
			?>

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
