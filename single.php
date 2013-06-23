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
                
                <?php if( $smof_data[ 'post_tags' ] ) the_tags( '<p class="post-tag">'.__( 'Tagged with: ', 'sptheme' )  ,' ', '</p>'); ?>
				<?php require_once( SP_BASE_DIR . 'includes/single-post-share.php' ); // Get Share Button template ?>
				<?php require_once( SP_BASE_DIR . 'includes/custom/home-ads-1.php' ); ?>
			</article><!-- end .hentry -->
            
            <?php the_tags( '<span style="display:none">',' ', '</span>'); ?>
            <span style="display:none" class="updated"><?php the_time( 'Y-m-d' ); ?></span>
            <div style="display:none" class="vcard author" itemprop="author" itemscope itemtype="http://schema.org/Person"><strong class="fn" itemprop="name"><?php the_author_posts_link(); ?></strong></div>
		
        <?php if( $smof_data[ 'post_nav' ] ): ?>				
		<div class="post-navigation">
			<div class="post-previous"><?php previous_post_link( '%link', '<span>'. __( 'Previous:', 'sptheme' ).'</span> %title' ); ?></div>
			<div class="post-next"><?php next_post_link( '%link', '<span>'. __( 'Next:', 'sptheme' ).'</span> %title' ); ?></div>
		</div><!-- .post-navigation -->
		<?php endif; ?>
        
        <?php if( $smof_data[ 'post_authorbio' ] ): ?>		
		<section id="author-box">
			<div class="block-head">
				<h3><?php _e( 'About', 'sptheme' ) ?> <?php the_author() ?> </h3>
			</div>
			<div class="post-listing">
				<?php sp_author_box() ?>
			</div>
		</section><!-- #author-box -->
		<?php endif; ?>
        
        <?php require_once( SP_BASE_DIR . 'includes/post-related.php' ); ?>
        
		<?php endwhile; ?>
        
       <?php // if ( comments_open() || '0' != get_comments_number() ) comments_template( '', true ); ?>
        
		<?php if( $has_sidebar ): ?>

			</section><!-- end #main -->

			<?php get_sidebar(); ?>

		<?php endif; ?>
        
    </div><!-- end .container.clearfix -->    

</section><!-- end #content -->

<?php get_footer(); ?>
