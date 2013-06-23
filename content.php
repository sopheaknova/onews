<?php global $smof_data; ?>
<div class="entry-body">
	<?php if(is_single()) { ?>
		<h1 class="title"><?php the_title(); ?></h1>
    <?php } else {?>
    	<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'sptheme'), the_title_attribute('echo=0') ); ?>" rel="bookmark">
		<h1 class="title"><?php the_title(); ?></h1>
	</a>
    <?php } ?>
    
    <div class="entry-meta">

		<?php echo sp_post_meta(); ?>
        
    
    </div><!-- end .entry-meta -->

	<div class="entry-content<?php echo ($smof_data[ 'blog_display' ] == 'thumbnail') ? ' cat-thumb' : '' ;?>">
	<?php echo sp_post_content(); ?>
    </div><!-- end .entry-content -->

</div><!-- end .entry-body -->