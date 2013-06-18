<?php
	global $smof_data;
	$news_mod = $smof_data['breaking_mode'];
	$title = $smof_data['breaking_title'];
	$number = $smof_data['breaking_number'];
	
	if( !$number || $number == ' ' || !is_numeric($number) )	$number = 5;
?>

	<div class="breaking-news">
		<span><?php if( $title ) echo $title; else _e("Breaking news: " , 'sptheme') ; ?></span>
		<?php
			global $post;
			$orig_post = $post;
		?>
		
		<?php
		$category_id = get_cat_ID($cat);
		
		//$args=array('post_type' => 'breaking_news','posts_per_page'=> $number);
		$args=array('posts_per_page'=> $number);
		
		$breaking_query = new wp_query( $args  );
		
		if( $breaking_query->have_posts() ) : $count=0; ?>
		<ul>
		<?php while( $breaking_query->have_posts() ) : $breaking_query->the_post();	$count++;?>
			<li><a href="<?php the_permalink()?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
		<?php endwhile; ?>
		</ul>
		<?php endif; ?>
		<div class="bg-ticker"></div>
		
		<?php $post = $orig_post; ?>
		<script type="text/javascript">
		
			jQuery(document).ready(function($){
				createTicker(); 
			});
		
		</script>
	</div> <!-- .breaking-news -->
    
    