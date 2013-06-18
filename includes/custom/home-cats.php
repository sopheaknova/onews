
<?php
	$category_name = $smof_data['cat_box_1'];
	$category_id = get_cat_ID($category_name);
	$category_link = get_category_link( $category_id );
	$num_posts = $smof_data['num_cat_box_1'];
?>

    
<section id="sp-cat-<?php echo $category_id; ?>" class="cat-box list-box">
		<h2 class="cat-box-title"><a href="<?php echo esc_url( $category_link ); ?>"> <?php echo $category_name; ?></a></h2>
        <?php
        $count = 0;
        $args = array (
                    'cat' 				=> $category_id,
                    'posts_per_page'	=> $num_posts
                );
        $media_query = new WP_Query($args);
        if ($media_query->have_posts()) : ?>
        <ul>
        <?php while ( $media_query->have_posts() ) : $media_query->the_post(); $count ++; ?>
        <?php if($count == 1) : ?>
            <li class="first-news">
            <?php if ( sp_post_image('sp-large') ) : ?>			
            <div class="post-thumbnail">
                <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'sptheme' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
                    <img src="<?php echo sp_post_image('sp-large') ?>" width="298" height="145" />
                    <?php //sp_get_score( true ); ?>
                </a>
            </div><!-- post-thumbnail /-->
            <?php else: ?>
            <div class="empty-space"></div>
            <?php endif; ?>
            <div class="entry-meta">
                <span><?php _e( 'Posted on: &mdash; ', 'sptheme' ); ?><?php echo sp_posted_on(); ?></span>
            </div><!-- end .entry-meta -->
            <h2 class="post-box-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'sptheme'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            <p>
            <?php echo sp_excerpt_length(52); ?>
            <a class="learn-more" href="<?php the_permalink(); ?>"><?php _e( 'Learn more »', 'sptheme' ); ?></a>
            </p>
            </li><!-- end .first-news -->
        <?php else: ?>
            <li class="other-news">
                <h3 class="post-box-title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
                <?php //sp_get_score(); ?> <div class="entry-meta"><?php echo sp_posted_on(); ?></div>
            </li>
        
        <?php endif; ?>    
        <?php
        endwhile;
        ?>
            <li><a href="<?php echo esc_url( $category_link ); ?>" class="learn-more"><?php _e('See more ', 'sptheme')?> <?php echo $category_name; ?> »</a></li>
            </ul>
        <?php
        endif;
        ?>
   
</section> <!-- end .sp-cat-<?php echo $category_id; ?>-->

<?php
	$category_name = $smof_data['cat_box_2'];
	$category_id = get_cat_ID($category_name);
	$category_link = get_category_link( $category_id );
	$num_posts = $smof_data['num_cat_box_2'];
?>

    
<section id="sp-cat-<?php echo $category_id; ?>" class="cat-box list-box last">
		<h2 class="cat-box-title"><a href="<?php echo esc_url( $category_link ); ?>"> <?php echo $category_name; ?></a></h2>
        <?php
        $count = 0;
        $args = array (
                    'cat' 				=> $category_id,
                    'posts_per_page'	=> $num_posts
                );
        $media_query = new WP_Query($args);
        if ($media_query->have_posts()) : ?>
        <ul>
        <?php while ( $media_query->have_posts() ) : $media_query->the_post(); $count ++; ?>
        <?php if($count == 1) : ?>
            <li class="first-news">
            <?php if ( sp_post_image('sp-large') ) : ?>			
            <div class="post-thumbnail">
                <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'sptheme' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
                    <img src="<?php echo sp_post_image('sp-large') ?>" width="298" height="145" />
                    <?php //sp_get_score( true ); ?>
                </a>
            </div><!-- post-thumbnail /-->
            <?php else: ?>
            <div class="empty-space"></div>
            <?php endif; ?>
            <div class="entry-meta">
                <span><?php _e( 'Posted on: &mdash; ', 'sptheme' ); ?><?php echo sp_posted_on(); ?></span>
            </div><!-- end .entry-meta -->
            <h2 class="post-box-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'sptheme'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            <p>
            <?php echo sp_excerpt_length(52); ?>
            <a class="learn-more" href="<?php the_permalink(); ?>"><?php _e( 'Learn more »', 'sptheme' ); ?></a>
            </p>
            </li><!-- end .first-news -->
        <?php else: ?>
            <li class="other-news">
                <h3 class="post-box-title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
                <?php //sp_get_score(); ?> <div class="entry-meta"><?php echo sp_posted_on(); ?></div>
            </li>
        
        <?php endif; ?>    
        <?php
        endwhile;
        ?>
            <li><a href="<?php echo esc_url( $category_link ); ?>" class="learn-more"><?php _e('See more ', 'sptheme')?> <?php echo $category_name; ?> »</a></li>
            </ul>
        <?php
        endif;
        ?>
   
</section> <!-- end .sp-cat-<?php echo $category_id; ?>-->