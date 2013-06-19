<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'RWMB_Slider_Slides_Field' ) ) 
{
	class RWMB_Slider_Slides_Field
	{
		/**
		 * Enqueue scripts and styles
		 *
		 * @return void
		 */
		static function admin_enqueue_scripts()
		{
			wp_enqueue_style( 'thickbox' );
			wp_enqueue_style( 'rwmb-slider-slide', RWMB_CSS_URL . 'slider-slides.css', array(), RWMB_VER );

			wp_enqueue_script( 'media-upload' );
			wp_enqueue_script( 'thickbox' );
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-tabs' );
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'rwmb-slider-slide', RWMB_JS_URL . 'slider-slides.js', array( 'jquery' ), RWMB_VER, true );
		}

		/**
		 * Show begin HTML markup for fields
		 *
		 * @param string $html
		 * @param mixed  $meta
		 * @param array  $field
		 *
		 * @return string
		 */
		static function begin_html( $html, $meta, $field )
		{
			$html = '';

			return $html;
		}

		/**
		 * Show end HTML markup for fields
		 *
		 * @param string $html
		 * @param mixed $meta
		 * @param array $field
		 *
		 * @return string
		 */
		static function end_html( $html, $meta, $field )
		{
			$html = '';

			return $html;
		}

		/**
		* Get field HTML
		*
		* @param $html
		* @param $field
		* @param $meta
		*
		* @return string
		*/
		static function html( $html, $meta, $field ) 
		{

			global $post;

			$id = $field['id'];

			$slider_slides = get_post_meta( $post->ID, $id, true ) ? get_post_meta( $post->ID, $id, true ) : false;

			$html = '<ul id="slider-slides">';

				if( $slider_slides ) {

					foreach ( $slider_slides as $i => $slide ) {

						$slide_img_src            = isset( $slide['slide-img-src'] )            ? $slide['slide-img-src']            : null;
						$slide_button_title       = isset( $slide['slide-button-title'] )       ? $slide['slide-button-title']       : null;
						$slide_title_story		  = isset( $slide['slide-title-story'] )		? $slide['slide-title-story']		 : null;
						$slide_content            = isset( $slide['slide-content'] )            ? $slide['slide-content']            : null;
						$slide_link_url           = isset( $slide['slide-link-url'] )           ? $slide['slide-link-url']           : null;

						$html .= '<li class="slide postbox">

									<div class="handlediv" title="' . __('Click to toggle', 'sptheme_admin') . '">&nbsp;</div>

									<h3 class="hndle"><span>' . __('Slide', 'sptheme_admin') . '</span></h3>

									<div class="inside">

										<div class="slider-slide-tabs">

											<ul>
												<li><a href="#slide-image">' . __('Image', 'sptheme_admin') . '</a></li>
												<li><a href="#slide-content">' . __('Content', 'sptheme_admin') . '</a></li>
												<li><a href="#slide-link">' . __('Link', 'sptheme_admin') . '</a></li>
											</ul>

											<div id="slide-image" class="tabs-content">

												<div class="rwmb-field">

													<div class="rwmb-label">
														<label>' . __('Image URL', 'sptheme_admin') . '</label>
													</div><!-- end .rwmb-label -->

													<div class="rwmb-input">
														<input type="text" name="slide-img-src[]" class="rwmb-text" size="30" value="' . $slide_img_src . '">
														<input type="button" name="upload-image" class="upload-image button" value="' . __('Upload Image', 'sptheme_admin') . '">
														<img src="' . $slide_img_src . '" class="thumb-view" width="200" height="150" />
													</div><!-- end .rwmb-input -->

												</div><!-- end .rwmb-field -->											

											</div><!-- end #slide-image -->
											
											<div id="slide-link" class="tabs-content">
													
												<div class="rwmb-field">

													<div class="rwmb-label">
														<label>' . __('URL', 'sptheme_admin') . '</label>
													</div><!-- end .rwmb-label -->

													<div class="rwmb-input">
														<input type="text" name="slide-link-url[]" class="rwmb-text" size="30" value="' . $slide_link_url . '">
														<p class="description">' . __('(optional) Any valid URL is allowed (e.g: http//www.google.com), doesn\'t have to be an image', 'sptheme_admin') . '.</p>
													</div><!-- end .rwmb-input -->

												</div><!-- end .rwmb-field -->

											</div><!-- end #slide-link -->
											
											<div id="slide-content" class="tabs-content">
												
												<div class="rwmb-field">

													<div class="rwmb-label">
														<label>' . __('Title', 'sptheme_admin') . '</label>
													</div><!-- end .rwmb-label -->

													<div class="rwmb-input">
														<input type="text" name="slide-title-story[]" class="rwmb-text" size="70" value="' . $slide_title_story . '">
														<p class="description">e.g: Title of this slide item</p>
													</div><!-- end .rwmb-input -->

												</div><!-- end .rwmb-field -->
												
												<div class="rwmb-field">

													<div class="rwmb-label">
														<label>' . __('Slide Content', 'sptheme_admin') . '</label>
													</div><!-- end .rwmb-label -->

													<div class="rwmb-input">
														<textarea name="slide-content[]" class="rwmb-textarea large-text" cols="60" rows="2">' . $slide_content . '</textarea>
														<p class="description">' . __('(optional) Max 255 characters are allowed.', 'sptheme_admin') . '</p>
													</div><!-- end .rwmb-input -->

												</div><!-- end .rwmb-field -->

											</div><!-- end #slide-content -->

										</div><!-- end .slider-slide-tabs -->

										<button class="remove-slide button-secondary">' . __('Remove Slide', 'sptheme_admin') . '</button>
										
										<input type="hidden" name="' . $id . '[]" class="rwmb-text" size="30" value="">
								
									</div><!-- end .inside -->
									
								</li>';

					}

				} else {


						$html .= '<li class="slide postbox">

									<div class="handlediv" title="' . __('Click to toggle', 'sptheme_admin') . '">&nbsp;</div>

									<h3 class="hndle"><span>' . __('Slide', 'sptheme_admin') . '</span></h3>

									<div class="inside">

										<div class="slider-slide-tabs">

											<ul>
												<li><a href="#slide-image">' . __('Image', 'sptheme_admin') . '</a></li>
												<li><a href="#slide-content">' . __('Content', 'sptheme_admin') . '</a></li>
												<li><a href="#slide-link">' . __('Link', 'sptheme_admin') . '</a></li>
											</ul>

											<div id="slide-image" class="tabs-content">

												<div class="rwmb-field">

													<div class="rwmb-label">
														<label>' . __('Image URL', 'sptheme_admin') . '</label>
													</div><!-- end .rwmb-label -->

													<div class="rwmb-input">
														<input type="text" name="slide-img-src[]" class="rwmb-text" size="30" value="">
														<input type="button" name="upload-image" class="upload-image button" value="' . __('Upload Image', 'sptheme_admin') . '">
														<img src="" class="thumb-view" width="200" height="150" />
													</div><!-- end .rwmb-input -->

												</div><!-- end .rwmb-field -->											

											</div><!-- end #slide-image -->

											<div id="slide-link" class="tabs-content">
											
												<div class="rwmb-field">

													<div class="rwmb-label">
														<label>' . __('URL', 'sptheme_admin') . '</label>
													</div><!-- end .rwmb-label -->

													<div class="rwmb-input">
														<input type="text" name="slide-link-url[]" class="rwmb-text" size="30" value="">
														<p class="description">' . __('(optional) Any valid URL is allowed (e.g: http//www.google.com), doesn\'t have to be an image', 'sptheme_admin') . '.</p>
													</div><!-- end .rwmb-input -->

												</div><!-- end .rwmb-field -->
													
											</div><!-- end #slide-link -->

											<div id="slide-content" class="tabs-content">
												
												<div class="rwmb-field">

													<div class="rwmb-label">
														<label>' . __('Title', 'sptheme_admin') . '</label>
													</div><!-- end .rwmb-label -->

													<div class="rwmb-input">
														<input type="text" name="slide-title-story[]" class="rwmb-text" size="70" value="">
														<p class="description">e.g: Title of this slide item</p>
													</div><!-- end .rwmb-input -->

												</div><!-- end .rwmb-field -->
												
												<div class="rwmb-field">

													<div class="rwmb-label">
														<label>' . __('Slide Content', 'sptheme_admin') . '</label>
													</div><!-- end .rwmb-label -->

													<div class="rwmb-input">
														<textarea name="slide-content[]" class="rwmb-textarea large-text" cols="60" rows="2"></textarea>
														<p class="description">' . __('(optional) Max 255 characters are allowed.', 'sptheme_admin') . '</p>
													</div><!-- end .rwmb-input -->

												</div><!-- end .rwmb-field -->

											</div><!-- end #slide-content -->

										</div><!-- end .slider-slide-tabs -->

										<button class="remove-slide button-secondary">' . __('Remove Slide', 'sptheme_admin') . '</button>
										
										<input type="hidden" name="' . $id . '[]" class="rwmb-text" size="30" value="">
								
									</div><!-- end .inside -->
									
								</li>';

				}

				$html .= '</ul><!-- end #slider-slides -->

						  <p> <button id="add-slider-slide" class="button-primary">' . __('Add New Slide', 'sptheme_admin') . '</button> </p>

						  <input type="hidden" name="slider-meta-info" value="' . $post->ID . '|' . $id . '">';

			return $html;
		}

		/**
		 * Save slides
		 *
		 * @param mixed $new
		 * @param mixed $old
		 * @param int $post_id
		 * @param array $field
		 *
		 * @return void
		 */
		static function save( $new, $old, $post_id, $field )
		{
				
			$name = $field['id'];

			$slider_slides = array();
			
			foreach( $_POST[$name] as $k => $v ) {

				$slider_slides[] = array(
					'slide-img-src'            => $_POST['slide-img-src'][$k],
					'slide-button-title'       => $_POST['slide-button-title'][$k],
					'slide-title-story'		   => $_POST['slide-title-story'][$k],
					'slide-content'            => $_POST['slide-content'][$k],
					'slide-link-url'           => $_POST['slide-link-url'][$k]
				);

			}

			$new = $slider_slides;

			update_post_meta( $post_id, $name, $new );

		}
	}
}