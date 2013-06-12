<?php

add_action( 'init', 'add_shortcodes_button' );
/* ---------------------------------------------------------------------- */
/*	TinyMCE Buttons or Add Editor Buttons
/* ---------------------------------------------------------------------- */
function add_shortcodes_button() {
	
	if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') )
		return;
		
	if ( get_user_option('rich_editing') == 'true' ) {
		add_filter('mce_external_plugins', 'add_shortcodes_tinymce_plugin');
		add_filter('mce_buttons_3', 'register_shortcodes_button');
	}
	
}

function add_shortcodes_tinymce_plugin( $plugin_array ) {
    $plugin_array['sp_buttons'] = SP_BASE_URL.'framework/shortcode/js/shortcodes.js';
    return $plugin_array;
}

function register_shortcodes_button( $buttons ) {
	
	//array_push($buttons, "highlight", "notifications", "buttons", "divider", "toggle", "tabs", "contactForm", "price_table_group", 'social_link', 'social_button', 'teaser', 'testimonials','dropcaps','totop','toc');
    array_push( $buttons, "highlight", "notifications", "buttons", "divider", "toggle", "dropcaps" );
    return $buttons;
}


//raw

function sp_sc_formatter($content)
{
	$new_content = '';
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

	foreach ($pieces as $piece)
	{
		if (preg_match($pattern_contents, $piece, $matches))
		{
			$new_content .= $matches[1];
		}
		else
		{
			$new_content .= wptexturize(wpautop($piece));
		}
	}

	return $new_content;
}

remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');

add_filter('the_content', 'sp_sc_formatter', 99);

/* ---------------------------------------------------------------------- */
/*	Make shortcode buttons work with wpml
/* ---------------------------------------------------------------------- */
add_action('admin_head', 'wpml_lang_init');

function wpml_lang_init()
{
	if(defined('ICL_LANGUAGE_CODE'))
	{?>
		<script>
			var sp_wpml_lang = '?lang=<?php echo ICL_LANGUAGE_CODE?>';
		</script>
	<?php
	}
	else
	{?>
		<script>
			var sp_wpml_lang = '';
		</script>
	<?php
	}
}

///Highlight
function highlight($atts, $content = null)
{
	extract(shortcode_atts(array(
					), $atts));

	$out = "<span class='hdark' >" . do_shortcode($content) . "</span>";

	return $out;
}

///Notifications
function notification($atts, $content = null)
{
	extract(shortcode_atts(array(
				'type' => '',
					), $atts));

	$out = "<div class='sp_notification " . $type . "' >" . do_shortcode($content) . "</div>";

	return $out;
}

add_shortcode('notification', 'notification');

add_shortcode('highlight', 'highlight');

//Buttons
function button($atts, $content = null)
{
	extract(shortcode_atts(array(
				'type' => '',
				'url' => '',
				'target' => ''
					), $atts));
	if ($target != '') : $target = "target='_blank'";
	endif;
	$out = "<a class='sp_button " . $type . "' href='" . $url . "' " . $target . "  >" . do_shortcode($content) . "</a>";

	return $out;
}

add_shortcode('button', 'button');

//Toggles
function toggle_shortcode($atts, $content = null)
{
	extract(shortcode_atts(
					array(
				'title' => '',
				'type' => '',
				'active' =>''
					), $atts));
	return '<div class="toggle toggle-' . $type . '"><h4 class="trigger '.$active.'"><span class="t_ico"></span><a href="#">' . $title . '</a></h4><div class="toggle_container '.$active.'">' . do_shortcode($content) . '</div></div>';
	
}

add_shortcode('toggle', 'toggle_shortcode');

///Dropcaps
function dropcaps($atts, $content = null)
{
	extract(shortcode_atts(array(
					), $atts));

	$out = "<span class='dropcaps' >" . do_shortcode($content) . "</span>";

	return $out;
}

add_shortcode('dropcaps', 'dropcaps');

?>