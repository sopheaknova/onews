<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input class="search-button" type="submit" value="<?php _e( 'Search term', 'sptheme' ); ?> &#8230;" />	
    <input type="text" id="s" name="s" class="searchtxt" value="<?php _e( 'Search...' , 'sptheme' ) ?>" onfocus="if (this.value == '<?php _e( 'Search...' , 'sptheme' ) ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e( 'Search...' , 'sptheme' ) ?>';}"  />
</form>