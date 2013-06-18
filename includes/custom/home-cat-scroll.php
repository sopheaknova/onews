
<?php
	$category_name = $smof_data['cat_scroll'];
	$category_id = get_cat_ID($category_name);
	$category_link = get_category_link( $category_id ); 
	$num_posts = $smof_data['num_cat_scroll'];
	
	$cat_query = new WP_Query('cat='.$category_id.'&posts_per_page='.$num_posts); 
?>
    <section class="cat-box scroll-box sp-cat-<?php echo $category_id ?>">
        <h2 class="cat-box-title"><a href="<?php echo esc_url( $category_link ); ?>"><?php echo $category_name ; ?></a></h2>
        <div class="cat-box-content">
        
            <?php if($cat_query->have_posts()): ?>
            <div  id="slideshow<?php echo $category_id ?>">
            <?php while ( $cat_query->have_posts() ) : $cat_query->the_post()?>
                <div class="scroll-item">
                    <?php if ( sp_post_image('sp-large') ) : ?>			
                        <div class="post-thumbnail">
                            <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'sptheme' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
                                <img src="<?php echo sp_post_image('sp-large') ?>" width="200" height="107" />
                                <?php //sp_get_score( ); ?>
                            </a>
                        </div><!-- post-thumbnail /-->
                    <?php else: ?>
                    <div class="empty-space"></div>
                    <?php endif; ?>

                    <h3 class="post-box-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'sptheme' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                    <div class="entry-meta"><?php echo sp_posted_on(); ?></div>
                </div>
            <?php endwhile;?>
            <div class="clear"></div>
            </div>
                <?php endif; ?>
        </div><!-- .cat-box-content /-->
        <div class="scroll-nav"><a id="next<?php echo $category_id ?>" href="#">Next</a><a class="prev-scroll" id="prev<?php echo $category_id ?>" href="#">Prev</a></div>
    </section>
    <div class="clear"></div>


<script type="text/javascript">
	jQuery(document).ready(function($) {
		var vids = $("#slideshow<?php echo $category_id ?> .scroll-item");
		for(var i = 0; i < vids.length; i+=3) {
		  vids.slice(i, i+3).wrapAll('<div class="group_items"></div>');
		}
		$(function() {
			$('#slideshow<?php echo $category_id ?>').cycle({
				fx:     'scrollHorz',
				timeout: 3000,
				//pager:  '#nav<?php echo $category_id ?>',
				slideExpr: '.group_items',
				prev:   '#prev<?php echo $category_id ?>', 
				next:   '#next<?php echo $category_id ?>',
				speed: 300,
				pause: true
			});
		});
  });
</script>