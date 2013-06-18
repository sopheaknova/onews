<?php get_header(); ?>

<div class="container clearfix"><?php sp_breadcrumbs() ?></div>

<section id="content" class="clearfix sidebar-right">

	<div class="container">

		<section id="main">
        
        <div class="page-header">

			<?php if ( have_posts() ): ?>
				
				<h2 class="title">
					<?php
						if ( is_day() ) :
							printf( __( 'Daily Archives: %s', 'sptheme' ), '<span>' . get_the_date() . '</span>' );
						elseif ( is_month() ) :
							printf( __( 'Monthly Archives: %s', 'sptheme' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );
						elseif ( is_year() ) :
							printf( __( 'Yearly Archives: %s', 'sptheme' ), '<span>' . get_the_date( 'Y' ) . '</span>' );
						else :
							_e( 'Archives', 'sptheme' );
						endif;
					?>
				</h2>

				<?php rewind_posts(); ?>
				
			<?php else: ?>
			
					<h1 class="page-title"><?php _e( 'Nothing Found', 'sptheme' ); ?></h1>

			<?php endif; ?>

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
