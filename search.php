<?php get_header(); ?>

<div class="container clearfix"><?php sp_breadcrumbs() ?></div>

<section id="content" class="clearfix sidebar-right">

	<div class="container">

		<section id="main">
		<div class="page-header">
        <h2 class="title-mod"><?php printf( __( 'Search result for: %s', 'sptheme' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
        </div>

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
        
    </div><!-- end .container -->    

</section><!-- end #content .clearfix -->

<?php get_footer(); ?>





