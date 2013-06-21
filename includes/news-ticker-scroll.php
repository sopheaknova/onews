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
		$args=array('post_type' => 'sp_newsticker', 'posts_per_page'=> $number);
		
		$breaking_query = new wp_query( $args  );
		
		if( $breaking_query->have_posts() ) : ?>
		<marquee  onmouseout="this.setAttribute('scrollamount',3, 0);" onmouseover="this.setAttribute('scrollamount', 0, 0);" scrollamount="3">
		<?php while( $breaking_query->have_posts() ) : $breaking_query->the_post();?>
        
			<span class="tick"><?php echo strip_tags(get_post_meta( $post->ID, 'sp_news_ticker_text', true ), '<span><a>'); ?></span>
		<?php endwhile; ?>
		</marquee>
		<?php endif; ?>
		<div class="bg-ticker"></div>
	</div> <!-- .breaking-news -->
    
    