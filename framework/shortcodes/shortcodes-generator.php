<?php
/*
*****************************************************
*      1) ACTIONS AND FILTERS
*****************************************************
*/
	//ACTIONS
		$wmGeneratorIncludes = array( 'post.php', 'post-new.php' );
		if ( in_array( $pagenow, $wmGeneratorIncludes ) ) {
			add_action( 'admin_enqueue_scripts', 'sp_mce_assets', 1000 );
			add_action( 'init', 'sp_shortcode_generator_button' );
			add_action( 'admin_footer', 'sp_add_generator_popup', 1000 );
		}





/*
*****************************************************
*      2) ASSETS NEEDED
*****************************************************
*/
	/*
	* Assets files
	*/
	if ( ! function_exists( 'sp_mce_assets' ) ) {
		function sp_mce_assets() {
			global $pagenow;

			$wmGeneratorIncludes = array( 'post.php', 'post-new.php' );

			if ( in_array( $pagenow, $wmGeneratorIncludes ) ) {
				//styles
				wp_register_style( 'sp-buttons', SP_BASE_URL . 'framework/assets/css/shortcodes.css', false, SP_SCRIPTS_VERSION, 'screen' );
				wp_enqueue_style( 'sp-buttons' );

				//scripts
				wp_register_script( 'sp-shortcodes', SP_BASE_URL . 'framework/assets/js/shortcodes/sp-shortcodes.js', array( 'jquery' ), SP_SCRIPTS_VERSION, true );
				wp_enqueue_script( 'sp-shortcodes' );
			}
		}
	} // /sp_mce_assets





/*
*****************************************************
*      3) TINYMCE BUTTON REGISTRATION
*****************************************************
*/
	/*
	* Register visual editor custom button position
	*/
	if ( ! function_exists( 'sp_register_tinymce_buttons' ) ) {
		function sp_register_tinymce_buttons( $buttons ) {
			$wmButtons = array( '|', 'sp_mce_button_line_above', 'sp_mce_button_line_below', '|', 'sp_mce_button_shortcodes' );

			array_push( $buttons, implode( ',', $wmButtons ) );

			return $buttons;
		}
	} // /sp_register_tinymce_buttons



	/*
	* Register the button functionality script
	*/
	if ( ! function_exists( 'sp_add_tinymce_plugin' ) ) {
		function sp_add_tinymce_plugin( $plugin_array ) {
			$plugin_array['sp_mce_button'] = SP_BASE_URL . 'framework/assets/js/shortcodes/sp-mce-button.js?ver=' . SP_SCRIPTS_VERSION;

			return $plugin_array;
		}
	} // /sp_add_tinymce_plugin



	/*
	* Adding the button to visual editor
	*/
	if ( ! function_exists( 'sp_shortcode_generator_button' ) ) {
		function sp_shortcode_generator_button() {
			if ( ! ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) )
				return;

			if ( 'true' == get_user_option( 'rich_editing' ) ) {
				//filter the tinymce buttons and add custom ones
				add_filter( 'mce_external_plugins', 'sp_add_tinymce_plugin' );
				add_filter( 'mce_buttons_2', 'sp_register_tinymce_buttons' );
			}
		}
	} // /sp_shortcode_generator_button
	

/*
*****************************************************
*      4) SHORTCODES ARRAY
*****************************************************
*/
	/*
	* Shortcodes settings for Shortcode Generator
	*/
	if ( ! function_exists( 'sp_shortcode_generator_tabs' ) ) {
		function sp_shortcode_generator_tabs() {
			
			$wmShortcodeGeneratorTabs = array(
			
			//Columns
			array(
				'id' => 'columns',
				'name' => __( 'Columns', 'lespaul_domain_adm' ),
				'settings' => array(
					'size' => array(
						'label' => __( 'Column size', 'lespaul_domain_adm' ),
						'desc'  => __( 'Select column size', 'lespaul_domain_adm' ),
						'value' => array(
							'1OPTGROUP'   =>  __( 'Halfs', 'lespaul_domain_adm' ),
								'one_half'      => '1/2',
								'one_half last' => '1/2' . __( ' last in row', 'lespaul_domain_adm' ),
							'1/OPTGROUP'  => '',
							'2OPTGROUP'   =>  __( 'Thirds', 'lespaul_domain_adm' ),
								'one_third'      => '1/3',
								'one_third last' => '1/3' . __( ' last in row', 'lespaul_domain_adm' ),
								'two_third'      => '2/3',
								'two_third last' => '2/3' . __( ' last in row', 'lespaul_domain_adm' ),
							'2/OPTGROUP'  => '',
							'3OPTGROUP'   =>  __( 'Quarters', 'lespaul_domain_adm' ),
								'one_fourth'      => '1/4',
								'one_fourth last' => '1/4' . __( ' last in row', 'lespaul_domain_adm' ),
								'two_fourth'      => '2/4',
								'two_fourth last' => '2/4' . __( ' last in row', 'lespaul_domain_adm' ),
								'three_fourth'      => '3/4',
								'three_fourth last' => '3/4' . __( ' last in row', 'lespaul_domain_adm' ),
							'3/OPTGROUP'  => '',
							'4OPTGROUP'   =>  __( 'Fifths', 'lespaul_domain_adm' ),
								'one_fifth'      => '1/5',
								'one_fifth last' => '1/5' . __( ' last in row', 'lespaul_domain_adm' ),
								'two_fifth'      => '2/5',
								'two_fifth last' => '2/5' . __( ' last in row', 'lespaul_domain_adm' ),
								'three_fifth'      => '3/5',
								'three_fifth last' => '3/5' . __( ' last in row', 'lespaul_domain_adm' ),
								'four_fifth'      => '4/5',
								'four_fifth last' => '4/5' . __( ' last in row', 'lespaul_domain_adm' ),
							'4/OPTGROUP'  => '',
							)
						),
					),
				'output-shortcode' => '[column{{size}}]TEXT[/column]'
			),
			
			//Tabs
					array(
						'id' => 'tabs',
						'name' => __( 'Tabs', 'lespaul_domain_adm' ),
						'desc' => __( 'Please, copy the <code>[tab title=""][/tab]</code> sub-shortcode as many times as you need. But keep them wrapped in <code>[tabs][/tabs]</code> parent shortcode.', 'lespaul_domain_adm' ),
						'settings' => array(
							'type' => array(
								'label' => __( 'Tabs type', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select tabs styling', 'lespaul_domain_adm' ),
								'value' => array(
									'normal-tabs'              => __( 'Normal tabs', 'lespaul_domain_adm' ),
									'modern-tabs'     => __( 'Modern tabs', 'lespaul_domain_adm' ),
									'classic-tabs'      => __( 'Classic tabs', 'lespaul_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[tabs{{type}}] [tab title="TEXT"]TEXT[/tab] [/tabs]'
					),
			
			//Table
			array(
				'id' => 'table',
				'name' => __( 'Table', 'lespaul_domain_adm' ),
				'desc' => __( 'For simple data tables use the shortcode below.', 'lespaul_domain_adm' ) . '<br />' . __( 'However, if you require more control over your table you can use sub-shortcodes for table row (<code>[trow][/trow]</code> or <code>[trow_alt][/trow_alt]</code> for alternatively styled table row), table cell (<code>[tcell][/tcell]</code>) and table heading cell (<code>[tcell_heading][/tcell_heading]</code>). All wrapped in <code>[table][/table]</code> parent shortcode.', 'lespaul_domain_adm' ),
				'settings' => array(
					'cols' => array(
						'label' => __( 'Heading row', 'lespaul_domain_adm' ),
						'desc'  => __( 'Titles of columns, separated with separator character. This is required to determine the number of columns for the table.', 'lespaul_domain_adm' ),
						'value' => ''
						),
					'data' => array(
						'label' => __( 'Table data', 'lespaul_domain_adm' ),
						'desc'  => __( 'Table cells data separated with separator character. Will be automatically aligned into columns (depending on "Heading row" setting).', 'lespaul_domain_adm' ),
						'value' => ''
						),
					'separator' => array(
						'label' => __( 'Separator character', 'lespaul_domain_adm' ),
						'desc'  => __( 'Individual table cell data separator used in previous input fields', 'lespaul_domain_adm' ),
						'value' => ';'
						),
					'heading_col' => array(
						'label' => __( 'Heading column', 'lespaul_domain_adm' ),
						'desc'  => __( 'If you wish to display a whole column of the table as a heading, set its order number here', 'lespaul_domain_adm' ),
						'value' => array(
							''  => '',
							'1' => 1,
							'2' => 2,
							'3' => 3,
							'4' => 4,
							'5' => 5,
							'6' => 6,
							'7' => 7,
							'8' => 8,
							'9' => 9,
							'10' => 10
							)
						),
					'class' => array(
						'label' => __( 'CSS class', 'lespaul_domain_adm' ),
						'desc'  => __( 'Optional custom css class applied on the table HTML tag', 'lespaul_domain_adm' ),
						'value' => ''
						),
					),
				'output-shortcode' => '[table{{class}}{{cols}}{{data}}{{separator}}{{heading_col}} /]'
			),
			
			//Logos
			'logos' => array(
				'id' => 'logos',
				'name' => __( 'Logos', 'lespaul_domain_adm' ),
				'desc' => __( 'You can include a description of the list created with the shortcode. Just place the text between opening and closing shortcode tag.', 'lespaul_domain_adm' ),
				'settings' => array(
					'category' => array(
						'label' => __( 'Logos category', 'lespaul_domain_adm' ),
						'desc'  => __( 'Select a category from where the list will be populated', 'lespaul_domain_adm' ),
						'value' => sp_tax_array( array(
								'allCountPost' => 'wm_logos',
								'allText'      => __( 'All logos', 'lespaul_domain_adm' ),
								'tax'          => 'logos-category',
							) )
						),
					'columns' => array(
						'label' => __( 'Layout', 'lespaul_domain_adm' ),
						'desc'  => __( 'Select number of columns to lay out the list', 'lespaul_domain_adm' ),
						'value' => array(
							'2' => __( '2 columns', 'lespaul_domain_adm' ),
							'3' => __( '3 columns', 'lespaul_domain_adm' ),
							'4' => __( '4 columns', 'lespaul_domain_adm' ),
							'5' => __( '5 columns', 'lespaul_domain_adm' ),
							'6' => __( '6 columns', 'lespaul_domain_adm' ),
							'7' => __( '7 columns', 'lespaul_domain_adm' ),
							'8' => __( '8 columns', 'lespaul_domain_adm' ),
							'9' => __( '9 columns', 'lespaul_domain_adm' ),
							)
						),
					'count' => array(
						'label' => __( 'Logo count', 'lespaul_domain_adm' ),
						'desc'  => __( 'Number of items to display', 'lespaul_domain_adm' ),
						'value' => array(
							'1' => 1,
							'2' => 2,
							'3' => 3,
							'4' => 4,
							'5' => 5,
							'6' => 6,
							'7' => 7,
							'8' => 8,
							'9' => 9,
							'10' => 10,
							'11' => 11,
							'12' => 12,
							'13' => 13,
							'14' => 14,
							'15' => 15,
							)
						),
					'order' => array(
						'label' => __( 'Order', 'lespaul_domain_adm' ),
						'desc'  => __( 'Select order in which items will be displayed', 'lespaul_domain_adm' ),
						'value' => array(
							''       => __( 'Default', 'lespaul_domain_adm' ),
							'name'   => __( 'By name', 'lespaul_domain_adm' ),
							'new'    => __( 'Newest first', 'lespaul_domain_adm' ),
							'old'    => __( 'Oldest first', 'lespaul_domain_adm' ),
							'random' => __( 'Randomly', 'lespaul_domain_adm' ),
							)
						),
					'align' => array(
						'label' => __( 'Description align', 'lespaul_domain_adm' ),
						'desc'  => __( 'Optional list description alignement', 'lespaul_domain_adm' ),
						'value' => array(
							''      => '',
							'left'  => __( 'Description text on the left', 'lespaul_domain_adm' ),
							'right' => __( 'Description text on the right', 'lespaul_domain_adm' ),
							)
						),
					'scroll' => array(
						'label' => __( 'Horizontal scroll', 'lespaul_domain_adm' ),
						'desc'  => __( 'To enable automatic scroll insert a pause time in miliseconds (minimal value is 1000). To enable manual scroll just insert any text or a number from 1 to 999. Please note that "count" parameter should be greater than "columns" parameter for scroll to work.', 'lespaul_domain_adm' ),
						'value' => ''
						),
					'scroll_stack' => array(
						'label' => __( 'Scroll method', 'lespaul_domain_adm' ),
						'desc'  => __( 'Whether to scroll items one by one or the whole stack', 'lespaul_domain_adm' ),
						'value' => array(
							''  => __( 'One by one', 'lespaul_domain_adm' ),
							'1' => __( 'Stack', 'lespaul_domain_adm' ),
							)
						),
					'grayscale' => array(
						'label' => __( 'Grayscale', 'lespaul_domain_adm' ),
						'desc'  => __( 'By default logo images are grayscale, turn to color when mouse hovers', 'lespaul_domain_adm' ),
						'value' => array(
							''  => __( 'Keep grayscale', 'lespaul_domain_adm' ),
							'0' => __( 'Turn off', 'lespaul_domain_adm' ),
							)
						),
					),
				'output-shortcode' => '[logos{{category}}{{columns}}{{count}}{{order}}{{align}}{{grayscale}}{{scroll}}{{scroll_stack}}][/logos]'
			),
					
			//FAQ
			'faq' => array(
				'id' => 'faq',
				'name' => __( 'FAQ', 'lespaul_domain_adm' ),
				'desc' => __( 'You can include a description of the list created with the shortcode. Just place the text between opening and closing shortcode tag.', 'lespaul_domain_adm' ),
				'settings' => array(
					'category' => array(
						'label' => __( 'FAQ category', 'lespaul_domain_adm' ),
						'desc'  => __( 'Select a category from where the list will be populated', 'lespaul_domain_adm' ),
						'value' => sp_tax_array( array(
								'allCountPost' => 'wm_faq',
								'allText'      => __( 'All FAQs', 'lespaul_domain_adm' ),
								'tax'          => 'faq-category',
							) )
						),
					'order' => array(
						'label' => __( 'Order', 'lespaul_domain_adm' ),
						'desc'  => __( 'Select order in which items will be displayed', 'lespaul_domain_adm' ),
						'value' => array(
							''       => __( 'Default', 'lespaul_domain_adm' ),
							'name'   => __( 'By name', 'lespaul_domain_adm' ),
							'new'    => __( 'Newest first', 'lespaul_domain_adm' ),
							'old'    => __( 'Oldest first', 'lespaul_domain_adm' ),
							'random' => __( 'Randomly', 'lespaul_domain_adm' ),
							)
						),
					'align' => array(
						'label' => __( 'Description align', 'lespaul_domain_adm' ),
						'desc'  => __( 'Description text alignement (when used - it will disable the filter)', 'lespaul_domain_adm' ),
						'value' => array(
							''      => '',
							'left'  => __( 'Description text on the left', 'lespaul_domain_adm' ),
							'right' => __( 'Description text on the right', 'lespaul_domain_adm' ),
							)
						),
					),
				'output-shortcode' => '[faq{{category}}{{order}}{{align}}][/faq]'
			),
			
			//Videos
			array(
				'id' => 'video',
				'name' => __( 'Video', 'lespaul_domain_adm' ),
				'desc' => sprintf( __( '<a%s>Supported video portals</a> and Screenr videos.', 'lespaul_domain_adm' ), ' href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank"' ),
				'settings' => array(
					'url' => array(
						'label' => __( 'Video URL', 'lespaul_domain_adm' ),
						'desc'  => __( 'Insert video URL address here', 'lespaul_domain_adm' ),
						'value' => ''
						),
					),
				'output-shortcode' => '[video{{url}} /]'
			),
			
			);
			
		return $wmShortcodeGeneratorTabs;
		}
	} // /sp_shortcode_generator_tabs



/*
*****************************************************
*      5) SHORTCODE GENERATOR HTML
*****************************************************
*/
	/*
	* Shortcode generator popup form
	*/
	if ( ! function_exists( 'sp_add_generator_popup' ) ) {
		function sp_add_generator_popup() {
			$shortcodes = sp_shortcode_generator_tabs();

			$out = '
				<div id="wm-shortcode-generator" class="selectable">
				<div id="wm-shortcode-form">
				';

			if ( ! empty( $shortcodes ) ) {

				//tabs
				/*
				$out .= '<ul class="wm-tabs">';
				foreach ( $shortcodes as $shortcode ) {
					$shortcodeId = 'wm-generate-' . $shortcode['id'];
					$out .= '<li><a href="#' . $shortcodeId . '">' . $shortcode['name'] . '</a></li>';
				}
				$out .= '</ul>';
				*/

				//select
				$out .= '<div class="wm-select-wrap"><label for="select-shortcode">' . __( 'Select a shortcode:', 'sptheme_admin' ) . '</label><select id="select-shortcode" class="wm-select">';
				foreach ( $shortcodes as $shortcode ) {
					$shortcodeId = 'wm-generate-' . $shortcode['id'];
					$out .= '<option value="#' . $shortcodeId . '">' . $shortcode['name'] . '</option>';
				}
				$out .= '</select></div>';

				//content
				$out .= '<div class="wm-tabs-content">';
				foreach ( $shortcodes as $shortcode ) {

					$shortcodeId     = 'wm-generate-' . $shortcode['id'];
					$settings        = ( isset( $shortcode['settings'] ) ) ? ( $shortcode['settings'] ) : ( null );
					$shortcodeOutput = ( isset( $shortcode['output-shortcode'] ) ) ? ( $shortcode['output-shortcode'] ) : ( null );
					$close           = ( isset( $shortcode['close'] ) ) ? ( ' ' . $shortcode['close'] ) : ( null );
					$settingsCount   = count( $settings );

					$out .= '
						<div id="' . $shortcodeId . '" class="tab-content">
						<p class="shortcode-title"><strong>' . $shortcode['name'] . '</strong> ' . __( 'shortcode', 'sptheme_admin' ) . '</p>
						';

					if ( isset( $shortcode['desc'] ) && $shortcode['desc'] )
						$out .= '<p class="shortcode-desc">' . $shortcode['desc'] . '</p>';

					$out .= '
						<div class="form-wrap">
						<form method="get" action="">
						<table class="items-' . $settingsCount . '">
						';

					if ( $settings ) {
						$i = 0;
						foreach ( $settings as $id => $labelValue ) {
							$i++;
							$desc      = ( isset( $labelValue['desc'] ) ) ? ( esc_attr( $labelValue['desc'] ) ) : ( '' );
							$maxlength = ( isset( $labelValue['maxlength'] ) ) ? ( ' maxlength="' . absint( $labelValue['maxlength'] ) . '"' ) : ( '' );

							$out .= '<tr class="item-' . $i . '"><td>';
							$out .= '<label for="' . $shortcodeId . '-' . $id . '" title="' . $desc . '">' . $labelValue['label'] . '</label></td><td>';
							if ( is_array( $labelValue['value'] ) ) {
								$imageBefore  = ( isset( $labelValue['image-before'] ) && $labelValue['image-before'] ) ? ( '<div class="image-before"></div>' ) : ( '' );
								$shorterClass = ( $imageBefore ) ? ( ' class="shorter set-image"' ) : ( '' );

								$out .= $imageBefore . '<select name="' . $shortcodeId . '-' . $id . '" id="' . $shortcodeId . '-' . $id . '" title="' . $desc . '" data-attribute="' . $id . '"' . $shorterClass . '>';
								foreach ( $labelValue['value'] as $value => $valueName ) {
									if ( 'OPTGROUP' === substr( $value, 1 ) )
										$out .= '<optgroup label="' . $valueName . '">';
									elseif ( '/OPTGROUP' === substr( $value, 1 ) )
										$out .= '</optgroup>';
									else
										$out .= '<option value="' . $value . '">' . $valueName . '</option>';
								}
								$out .= '</select>';

							} else {

								$out .= '<input type="text" name="' . $shortcodeId . '-' . $id . '" value="' . $labelValue['value'] . '" id="' . $shortcodeId . '-' . $id . '" class="widefat" title="' . $desc . '"' . $maxlength . ' data-attribute="' . $id . '" /><img src="' . SP_BASE_URL . 'framework/assets/img/shortcodes/add16.png" alt="' . __( 'Apply changes', 'sptheme_admin' ) . '" title="' . __( 'Apply changes', 'sptheme_admin' ) . '" class="ico-apply" />';

							}
							$out .= '</td></tr>';
						}
					}

					$out .= '<tr><td>&nbsp;</td><td><p><a data-parent="' . $shortcodeId . '" class="send-to-generator button-primary">' . __( 'Insert into editor', 'sptheme_admin' ) . '</a></p></td></tr>';
					$out .= '
						</table>
						</form>
						';
					$out .= '<p><strong>' . __( 'Or copy and paste in this shortcode:', 'sptheme_admin' ) . '</strong></p>';
					$out .= '<form><textarea class="wm-shortcode-output' . $close . '" cols="30" rows="2" readonly="readonly" onfocus="this.select();" data-reference="' . esc_attr( $shortcodeOutput ) . '">' . esc_attr( $shortcodeOutput ) . '</textarea></form>';
					$out .= '<!-- /form-wrap --></div>';
					$out .= '<!-- /tab-content --></div>';

				}
				$out .= '<!-- /wm-tabs-content --></div>';

			}

			$out .= '
				<!-- /wm-shortcode-form --></div>
				<p class="credits"><small>&copy; <a href="http://www.webmandesign.eu" target="_blank">WebMan</a></small></p>
				<!-- /wm-shortcode-generator --></div>
				';

			echo $out;
		}
	} // /sp_add_generator_popup

