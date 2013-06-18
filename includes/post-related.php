<?php
global $smof_data, $get_meta , $post;

if( $smof_data[ 'related_post' ] ):
	$related_no = $smof_data['related_number'] ? $smof_data['related_number'] : 3;
	
	global $post;
	$orig_post = $post;
	
	$query_type = $smof_data['related_query'] ;
	if( $query_type == 'author' ){
		$args=array('post__not_in' => array($post->ID),'posts_per_page'=> $related_no , 'author'=> get_the_author_meta( 'ID' ));
	}elseif( $query_type == 'tag' ){
		$tags = wp_get_post_tags($post->ID);
		$tags_ids = array();
		foreach($tags as $individual_tag) $tags_ids[] = $individual_tag->term_id;
		$args=array('post__not_in' => array($post->ID),'posts_per_page'=> $related_no , 'tag__in'=> $tags_ids );
	}
	else{
		$categories = get_the_category($post->ID);
		$category_ids = array();
		foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
		$args=array('post__not_in' => array($post->ID),'posts_per_page'=> $related_no , 'category__in'=> $category_ids );
	}		
	$related_query = new wp_query( $args );
	if( $related_query->have_posts() ) : $count=0;?>
	<section id="related_posts">
		<div class="block-head">
			<h3><?php _e( 'Related Articles' , 'sptheme' ); ?></h3><div class="stripe-line"></div>
		</div>
		<div class="post-listing">
			<?php while ( $related_query->have_posts() ) : $related_query->the_post()?>
			<div class="related-item">
			<?php if ( sp_post_image('sp-medium') ) : ?>		
				<div class="post-thumbnail">
					<a href="<?php the_permalink(); ?>" title="<?php printf( __( 'Permalink to %s', 'sptheme' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
						<img src="<?php echo sp_post_image('sp-medium') ?>" width="200" height="150" />
						<?php //sp_get_score(  ); ?>
					</a>
				</div><!-- post-thumbnail /-->
            <?php endif; ?>    
                
				<h3><a href="<?php the_permalink(); ?>" title="<?php printf( __( 'Permalink to %s', 'sptheme' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
				<p class="entry-meta"><?php echo sp_posted_on() ?></p>
			</div>
			<?php endwhile;?>
			<div class="clear"></div>
		</div>
	</section>
	<?php	endif;
	$post = $orig_post;
	wp_reset_query();
endif; ?>