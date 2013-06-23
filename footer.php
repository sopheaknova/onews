<?php 

	global $smof_data; 

	$title = $smof_data['footer_social_title'];
	$footer_logo = $smof_data['footer_logo'];
?>
    
    <footer id="footer">
        <div class="container clearfix">
        <?php echo sp_footer_navigation(); ?>
        
        <div class="social-footer">
        <span><?php if( $title ) echo $title; else _e("Join with us on: " , 'sptheme') ; ?></span>
        <?php sp_get_social('yes', '16'); ?>
        </div>
        
        <div class="copyright">
        <a  href="<?php echo home_url() ?>/"  title="<?php echo esc_attr( get_bloginfo('name', 'display') ); ?>">
        <img src="<?php echo $footer_logo; ?>" alt="<?php echo esc_attr( get_bloginfo('name', 'display') ); ?>" />
        </a>
        <p><?php echo ($smof_data['footer_text'] !== '') ? $smof_data['footer_text'] : '&copy; ' . date('Y') . ' COMPANY NAME'; ?></p>
        </div>
                
        </div><!--end .container -->
    </footer><!--end #footer-cols -->
 
</div>     
<!-- end .wrapper -->  

<?php wp_footer(); ?>

</body>
</html>