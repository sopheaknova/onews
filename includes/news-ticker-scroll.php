<?php
	global $smof_data;
	$news_mod = $smof_data['breaking_mode'];
	$title = $smof_data['breaking_title'];
	$number = $smof_data['breaking_number'];
	
	if( !$number || $number == ' ' || !is_numeric($number) )	$number = 5;
?>

	<div class="news-ticker">
		<span class="ticker-title"><?php if( $title ) echo $title; else _e("Breaking news: " , 'sptheme') ; ?></span>
		<?php
			global $post;
			$orig_post = $post;
		?>
		
		<?php
		$args=array('post_type' => 'sp_tickernews', 'posts_per_page'=> $number);
		
		$breaking_query = new wp_query( $args  );
		
		if( $breaking_query->have_posts() ) : ?>
		<marquee truespeed>
		<?php while( $breaking_query->have_posts() ) : $breaking_query->the_post();?>
        
			<span class="tick"><?php echo get_post_meta( $post->ID, 'sp_ticker_news_text', true ); ?></span>
		<?php endwhile; ?>
		</marquee>
		<?php endif; ?>
		<div class="bg-ticker"></div>
		
		<?php $post = $orig_post; ?>
	</div> <!-- .breaking-news -->
    
    