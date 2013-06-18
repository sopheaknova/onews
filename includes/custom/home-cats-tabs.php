<?php
	$category_name_tab1 = $smof_data['cat_box_tab_1'];
	$category_name_tab2 = $smof_data['cat_box_tab_2'];
	$category_id_tab1 = get_cat_ID($category_name_tab1);
	$category_id_tab2 = get_cat_ID($category_name_tab2);
	$category_link_tab1 = get_category_link( $category_id_tab1 );
	$category_link_tab2 = get_category_link( $category_id_tab2 ); 
	$num_posts_tab1 = $smof_data['num_cat_box_tab_1'];
	$num_posts_tab2 = $smof_data['num_cat_box_tab_2'];
	$layout_tab1 = $smof_data['style_cat_box_tab_1'];
	$layout_tab2 = $smof_data['style_cat_box_tab_2'];
	
	$cat_query = new WP_Query('cat='.$category_id.'&posts_per_page='.$num_posts); 
?>

<section class="cat-box">
    <ul class="cats-tabs-nav">
        <li><h3><a href="#<?php echo $category_id_tab1; ?>"><?php echo $category_name_tab1; ?></a></h3></li>
        <li><h3><a href="#<?php echo $category_id_tab2; ?>"><?php echo $category_name_tab2; ?></a></h3></li>
    </ul><!-- end .cats-tabs-nav -->
    <div class="cats-tab-container">
        <div id="sp-cat-<?php echo $category_id_tab1; ?>" class="cat-tab-content cat-box-tab sp-cat-<?php echo $category_id_tab1; ?> clearfix">
            <?php if( $layout_tab1 == '2c'):  //************** 2C ****************************************************** ?>
                <?php
                $args = array (
                            'cat' 				=> $category_id_tab1,
                            'posts_per_page'	=> 1
                        );
                $media_query = new WP_Query($args);
                if ($media_query->have_posts()) : ?>
                <ul>
                <?php while ( $media_query->have_posts() ) : $media_query->the_post();?>
                <?php if($count == 1) : ?>
					<li class="first-news">
                	<?php if ( sp_post_image('sp-large') ) : ?>			
                    <div class="post-thumbnail">
                        <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
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
                    <h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'sptheme'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                    <p>
                    <?php echo sp_excerpt_length(52); ?>
                    <a class="learn-more" href="<?php the_permalink(); ?>"><?php _e( 'Learn more »', 'sptheme' ); ?></a>
                    </p>
                    </li><!-- end .first-news -->
                <?php else : ?>
                 
				<?php sp_last_posts_cat($num_posts_tab1 , true , $category_id_tab1, 0); ?>
                
				<?php endif; ?>    
                <?php
                endwhile;
				?>
                	</ul>
				<?php
                endif;
                ?>
            <?php endif; //end layout_tab1 ?>  
            
        </div><!-- end .sp-cat-<?php echo $category_id_tab1; ?>-->
            
        <div id="sp-cat-<?php echo $category_id_tab2; ?>" class="cat-tab-content cat-box-tab sp-cat-<?php echo $category_id_tab2; ?> clearfix">
            <?php if( $layout_tab2 == '2c'):  //************** 2C ****************************************************** ?>
                <?php
                $args = array (
                            'cat' 				=> $category_id_tab2,
                            'posts_per_page'	=> 1
                        );
                $media_query = new WP_Query($args);
                if ($media_query->have_posts()) : ?>
                <ul>
                <?php while ( $media_query->have_posts() ) : $media_query->the_post(); ?>
                <?php if($count == 1) : ?>
					<li class="first-news">
                	<?php if ( sp_post_image('sp-large') ) : ?>			
                    <div class="post-thumbnail">
                        <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
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
                    <h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'sptheme'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                    <p>
                    <?php echo sp_excerpt_length(52); ?>
                    <a class="learn-more" href="<?php the_permalink(); ?>"><?php _e( 'Learn more »', 'sptheme' ); ?></a>
                    </p>
                    </li><!-- end .first-news -->
                <?php else : ?>
                 
				<?php sp_last_posts_cat($num_posts_tab2 , true , $category_id_tab2, 0); ?>
                
				<?php endif; ?>    
                <?php
                endwhile;
				?>
                	</ul>
				<?php
                endif;
                ?>
            <?php endif; //end layout_tab1 ?>  
            
        </div><!-- end .sp-cat-<?php echo $category_id_tab2; ?>-->
    </div><!-- end .cats-tab-container -->
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        var $tabsNavCat    = $('.cats-tabs-nav'),
        $tabsNavCatLis = $tabsNavCat.children('li'),
        $tabContent = $('.cat-tab-content');
    
        $tabsNavCat.each(function() {
            var $this = $(this);
        
            $this.next().children('.cat-tab-content').hide()
                                                 .first().show()
                                                 .css('background-color','#ffffff');
        
            $this.children('li').first().addClass('active').show();
        });
        
        $tabsNavCatLis.on('click', function(e) {
            var $this = $(this);
        
            $this.siblings().removeClass('active').end()
                 .addClass('active');
            
            $this.parent().next().children('.cat-tab-content').hide()
                                                          .siblings( $this.find('a').attr('href') ).fadeIn()
                                                          .css('background-color','#ffffff');
        
            e.preventDefault();
        });
    });	
    </script>
</section> <!-- end .cat-box-tab -->