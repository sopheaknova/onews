<div class="one_half">
    <div id="economics" class="posts-cat-1">
        <?php 
        //$category_name = $smof_data['eco_cat'];
        //$category_id = get_cat_ID($category_name);
        $category_id = 3;
        $category_link = get_category_link( $category_id ); 
        ?>
         <h3 class="widget-title"><a href="<?php echo esc_url( $category_link ); ?>"><?php echo $category_name; ?></a></h3>
        <?php
        $args = array (
                    'cat' 	=> $category_id,
                    'posts_per_page'	=> 1
                );
        $media_query = new WP_Query($args);
        if ($media_query->have_posts()) :
        while ( $media_query->have_posts() ) : $media_query->the_post();
        $post_thumb = get_post_thumbnail_id( $post->ID );
        $image_src = wp_get_attachment_image_src($post_thumb, 'medium');
        $image = aq_resize( $image_src[0], 298, 145, true ); //resize & crop the image	
        ?>
        <?php if ($image) : ?>
            <img src="<?php echo $image;?>" alt="<?php the_title(); ?>" />
        <?php else:	?>
            <img src="<?php echo SP_BASE_URL; ?>images/blank-photo-300.gif" alt="Blank photo" />
        <?php endif; ?>
            <div class="entry-meta">
                <span><?php _e( 'Posted on: &mdash; ', 'sptheme' ); ?><?php echo sp_posted_on(); ?></span>
            </div><!-- end .entry-meta -->
            <h4><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'sptheme'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h4>
            <p>
            <?php echo sp_excerpt_length(16); ?>
            <a class="learn-more" href="<?php the_permalink(); ?>"><?php _e( 'Learn more »', 'sptheme' ); ?></a>
            </p>
        <?php
        endwhile;
        endif;
        ?>
        <div class="more-posts">
        <ul class="arrow-dot">
        <?php sp_last_posts_cat(3 , false , $category_id, 1); ?>
        </ul>
        <a href="<?php echo esc_url( $category_link ); ?>" class="learn-more"><?php _e('See more ', 'sptheme')?> <?php echo $category_name; ?> »</a>   
        </div><!-- end .more-posts-->
    </div><!-- end #economics-->
</div><!-- end .one_half-->
    
<div class="one_half last">
	<div id="technology" class="posts-cat-1">
        <?php 
        //$category_name = $smof_data['eco_cat'];
        //$category_id = get_cat_ID($category_name);
        $category_id = 4;
        $category_link = get_category_link( $category_id ); 
        ?>
         <h3 class="widget-title"><a href="<?php echo esc_url( $category_link ); ?>"><?php echo $category_name; ?></a></h3>
        <?php
        $args = array (
                    'cat' 	=> $category_id,
                    'posts_per_page'	=> 1
                );
        $media_query = new WP_Query($args);
        if ($media_query->have_posts()) :
        while ( $media_query->have_posts() ) : $media_query->the_post();
        $post_thumb = get_post_thumbnail_id( $post->ID );
        $image_src = wp_get_attachment_image_src($post_thumb, 'medium');
        $image = aq_resize( $image_src[0], 298, 145, true ); //resize & crop the image	
        ?>
        <?php if ($image) : ?>
            <img src="<?php echo $image;?>" alt="<?php the_title(); ?>" />
        <?php else:	?>
            <img src="<?php echo SP_BASE_URL; ?>images/blank-photo-300.gif" alt="Blank photo" />
        <?php endif; ?>
            <div class="entry-meta">
                <span><?php _e( 'Posted on: &mdash; ', 'sptheme' ); ?><?php echo sp_posted_on(); ?></span>
            </div><!-- end .entry-meta -->
            <h4><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'sptheme'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h4>
            <p>
            <?php echo sp_excerpt_length(16); ?>
            <a class="learn-more" href="<?php the_permalink(); ?>"><?php _e( 'Learn more »', 'sptheme' ); ?></a>
            </p>
        <?php
        endwhile;
        endif;
        ?>
        <div class="more-posts">
        <ul class="arrow-dot">
        <?php sp_last_posts_cat(3 , false , $category_id, 1); ?>
        </ul>
        <a href="<?php echo esc_url( $category_link ); ?>" class="learn-more"><?php _e('See more ', 'sptheme')?> <?php echo $category_name; ?> »</a>   
        </div><!-- end .more-posts-->
    </div><!-- end #economics-->
</div><!-- end .one_half .last-->
<div class="clear"></div>