<?php
	$category_name_tab1 = $smof_data['cat_box_tab_1'];
	$category_name_tab2 = $smof_data['cat_box_tab_2'];
	$category_id_tab1 = get_cat_ID($category_name_tab1);
	$category_id_tab2 = get_cat_ID($category_name_tab2);
	$category_link_tab1 = get_category_link( $category_id_tab1 );
	$category_link_tab2 = get_category_link( $category_id_tab2 ); 
	$num_posts_tab1 = $smof_data['num_cat_box_tab_1'];
	$num_posts_tab2 = $smof_data['num_cat_box_tab_2'];
	
?>

<section class="cat-box">
    <ul class="cats-tabs-nav">
        <li><a href="#sp-cat-<?php echo $category_id_tab1; ?>"><?php echo $category_name_tab1; ?></a></li>
        <li><a href="#sp-cat-<?php echo $category_id_tab2; ?>"><?php echo $category_name_tab2; ?></a></li>
    </ul><!-- end .cats-tabs-nav -->
    <div class="cats-tab-container">
        <div id="sp-cat-<?php echo $category_id_tab1; ?>" class="cat-tab-content cat-box-tab clearfix">
        
                <?php
				$count = 0;
				$args = array (
                            'cat' 				=> $category_id_tab1,
                            'posts_per_page'	=> $num_posts_tab1
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
                    <h2 class="post-box-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'sptheme'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                    <div class="entry-meta">
                        <span><?php echo sp_posted_on(); ?></span>
                    </div><!-- end .entry-meta -->
                    
                    <?php echo sp_excerpt_string_length(920); ?>
                    <a class="learn-more" href="<?php the_permalink(); ?>"><?php _e( 'Learn more', 'sptheme' ); ?></a>
                    
                    </li><!-- end .first-news -->
                <?php else: ?>
                    <li class="other-news">
                    	<?php if ( sp_post_image('sp-small') ) : ?>			
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'sptheme' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
                                    <img src="<?php echo sp_post_image('sp-small') ?>" width="110" height="83" />
                                    <?php //sp_get_score( true ); ?>
                                </a>
                            </div><!-- post-thumbnail /-->
                        <?php endif; ?>    
                        <h3 class="post-box-title">
                        <?php $title_kh = get_the_title(); ?>
                        <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'sptheme' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
                        <?php the_title(); ?>
                        </a>
                        </h3>
                        <?php //sp_get_score(); ?> <div class="entry-meta"><?php echo sp_posted_on(); ?></div>
                    </li>
                
				<?php endif; ?>    
                <?php
                endwhile;
				?>
                	<li><a href="<?php echo esc_url( $category_link_tab1 ); ?>" class="learn-more"><?php _e('Show more ', 'sptheme')?> <?php echo $category_name_tab1; ?></a></li>
                	</ul>
				<?php
                endif;
                ?>
            
        </div><!-- end .sp-cat-<?php echo $category_id_tab1; ?>-->
            
        <div id="sp-cat-<?php echo $category_id_tab2; ?>" class="cat-tab-content cat-box-tab clearfix">
        
                <?php
				$count = 0;
				$args = array (
                            'cat' 				=> $category_id_tab2,
                            'posts_per_page'	=> $num_posts_tab2
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
                    <h2 class="post-box-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'sptheme'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                     <div class="entry-meta">
                        <span><?php echo sp_posted_on(); ?></span>
                    </div><!-- end .entry-meta -->
                    
                    <?php echo sp_excerpt_string_length(860); ?>
                    <a class="learn-more" href="<?php the_permalink(); ?>"><?php _e( 'Learn more', 'sptheme' ); ?></a>
                    
                    </li><!-- end .first-news -->
                <?php else: ?>
                    <li class="other-news">
                    	<?php if ( sp_post_image('sp-small') ) : ?>			
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'sptheme' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
                                    <img src="<?php echo sp_post_image('sp-small') ?>" width="110" height="83" />
                                    <?php //sp_get_score( true ); ?>
                                </a>
                            </div><!-- post-thumbnail /-->
                        <?php endif; ?>    
                        <h3 class="post-box-title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
                        <?php //sp_get_score(); ?> <div class="entry-meta"><?php echo sp_posted_on(); ?></div>
                    </li>
                
				<?php endif; ?>    
                <?php
                endwhile;
				?>
                	<li><a href="<?php echo esc_url( $category_link_tab2 ); ?>" class="learn-more"><?php _e('Show more ', 'sptheme')?> <?php echo $category_name_tab2; ?></a></li>
                	</ul>
				<?php
                endif;
                ?>
            
        </div><!-- end .sp-cat-<?php echo $category_id_tab2; ?>-->
    </div><!-- end .cats-tab-container -->
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        var $tabsNavCat    = $('.cats-tabs-nav'),
        $tabsNavCatLis = $tabsNavCat.children('li');
        
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