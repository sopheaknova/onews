<?php get_header(); ?>

<?php sp_set_post_views() ?>
<?php $has_sidebar = sp_check_page_layout(); ?>

<div class="container clearfix"><?php sp_breadcrumbs() ?></div>

<section id="content" class="clearfix <?php echo sp_check_sidebar_position(); ?>">

	<div class="container clearfix">
        
		<?php if( $has_sidebar ): ?>

			<section id="main">

		<?php endif; ?>
		

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

				<?php get_template_part( 'content', get_post_format() ); ?>

			</article><!-- end .hentry -->
            
            <?php if( $smof_data[ 'post_tags' ] ) the_tags( '<p class="post-tag">'.__( 'Tagged with: ', 'sptheme' )  ,' ', '</p>'); ?>
            
		<?php endwhile; ?>
        
        <?php edit_post_link( __( 'Edit', 'tie' ), '<span class="edit-link">', '</span>' ); ?>
		
		<?php comments_template( '', true ); ?>
        
		<?php if( $has_sidebar ): ?>

			</section><!-- end #main -->

			<?php get_sidebar(); ?>

		<?php endif; ?>
        
    </div><!-- end .container.clearfix -->    

</section><!-- end #content -->

<?php get_footer(); ?>
