<section id="featured-slideshow">
	<?php
	$category_slide_name = $smof_data['featured_slide'];
    $category_id = get_cat_ID($category_slide_name);
    $category_link = get_category_link( $category_id ); 
    ?>
    
	<h3 class="featured-title"><a href="<?php echo esc_url( $category_link ); ?>"><?php echo $category_slide_name; ?></a></h3>
    
	<?php
	$args = array ( 'cat' => $category_id, 'posts_per_page' => 5 );
		
    $media_query = new WP_Query($args);
    if ($media_query->have_posts()) :
    while ( $media_query->have_posts() ) : $media_query->the_post();
    $post_thumb = get_post_thumbnail_id( $post->ID );
    $image_src = wp_get_attachment_image_src($post_thumb, 'slider');
    ?>
        <div class="cat-slide-items">
        <?php if ($post_thumb) : ?>
            <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'sptheme'), the_title_attribute('echo=0') ); ?>" rel="bookmark">
            <img src="<?php echo $image_src[0];?>" alt="<?php the_title(); ?>" />
            </a>
        <?php else:	?>
            <img src="<?php echo SP_BASE_URL; ?>images/placeholder/image-news-slider-620x330.gif" alt="Photo media slide" />
        <?php endif; ?>
        <div class="caption">
            <h4><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'sptheme'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h4>
            <p>
            <?php echo sp_posted_on(); ?>
            </p>
        </div>
        </div><!-- end .cat-slide-items -->
      <?php
      endwhile;
      
      endif;
      ?>   
        <ul class="slider-nav">
        <?php
        if ($media_query->have_posts()) :
        while ( $media_query->have_posts() ) : $media_query->the_post();
        $post_thumb = get_post_thumbnail_id( $post->ID );
        $image_src = wp_get_attachment_image_src($post_thumb, 'full');
        $image = aq_resize( $image_src[0], 115, 78, true ); //resize & crop the image	
        ?>
            <?php if ($image) : ?>
                <li><a href="#"><img src="<?php echo $image;?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" /></a></li>
            <?php else:	?>
                <li><a href="#"><img src="<?php echo SP_BASE_URL; ?>images/media-landing-image-115x78.gif" alt="Photo media slide thumb" /></a></li>
            <?php endif; ?>
        <?php
          endwhile;
          endif;
        ?>      
        </ul>
</section><!-- end #featured-news -->