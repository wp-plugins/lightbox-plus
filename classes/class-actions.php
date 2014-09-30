<?php
/**
 * @package    Lightbox Plus Colorbox
 * @subpackage class-actions.php
 * @internal   2013.01.16
 * @author     Dan Zappone / 23Systems
 * @version    2.7
 * @$Id: class-actions.php 983793 2014-09-07 19:22:57Z dzappone $
 * @$URL: http://plugins.svn.wordpress.org/lightbox-plus/trunk/classes/class-actions.php $
 */

if ( ! interface_exists( 'LBP_Actions_Interface' ) ) {
	interface LBP_Actions_Interface {
//		function getPostID();
		function lbp_add_header();

		function lbp_colorbox();

		function lbp_add_panel();

		function lbp_admin_scripts();

		function lbp_admin_styles();

		function lbp_save_post_meta();

		function lbp_meta_box();

		function lbp_show_meta( $post );

		function lbp_save_meta( $post_id );
	}
}

if ( ! class_exists( 'LBP_Actions' ) ) {
	class LBP_Actions extends LBP_Filters implements LBP_Actions_Interface {
//		function getPostID() {
//			global $the_post_id;
//			global $wp_query;
//			$the_post_id = $wp_query->post->ID;
//			echo $the_post_id;
//		}

		/**
		 * Add CSS styles to site page headers to display lightboxed image
		 *
		 * @return int
		 */
		function lbp_add_header() {
			global $post;
			global $wp_version;
			global $g_lbp_base_options;

			if ( ! empty( $this->lbp_options_base_name ) ) {
				$g_lbp_base_options = get_option( $this->lbp_options_base_name );
			}

			/**
			 * Remove following line after a few versions or 2.6 is the prevelent version
			 */
			if ( isset( $g_lbp_base_options ) ) {
				$g_lbp_base_options = $this->set_missing_options( $g_lbp_base_options );
			}

			if ( ! is_admin() ) {
				if ( floatval( $wp_version ) < 3.1 ) {
					wp_deregister_script( 'jquery' );
					wp_register_script( 'jquery', "http" . ( $_SERVER['SERVER_PORT'] == 443 ? "s" : "" ) . "://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js", false, null );
					wp_enqueue_script( 'jquery' );
				} else {
					wp_enqueue_script( 'jquery', '', '', '', true );
				}
				// Production
				//wp_enqueue_script('jquery-colorbox', LBP_ASSETS_URL .'/js/jquery.colorbox.'.LBP_COLORBOX_VERSION.'-min.js', array( 'jquery' ), LBP_COLORBOX_VERSION, $this->set_load_location($lbp_options['load_location']));
				// Development
				wp_enqueue_script( 'jquery-colorbox', LBP_ASSETS_URL . '/js/jquery.colorbox.' . LBP_COLORBOX_VERSION . '.js', array( 'jquery' ), LBP_COLORBOX_VERSION, $this->set_load_location( $g_lbp_base_options['load_location'] ) );
			}

			if ( $g_lbp_base_options['use_custom_style'] ) {
				$style_path_url = LBP_CUSTOM_STYLE_URL;
				$style_path_dir = LBP_CUSTOM_STYLE_PATH;
			} else {
				$style_path_url = LBP_STYLE_URL;
				$style_path_dir = LBP_STYLE_PATH;
			}

			if ( $g_lbp_base_options['disable_css'] ) {
				echo "<!-- User set lightbox styles -->" . PHP_EOL;
			} else {
				wp_register_style( 'lightboxStyle', $style_path_url . '/' . $g_lbp_base_options['lightboxplus_style'] . '/colorbox.css', '', LBP_VERSION, 'screen' );
				wp_enqueue_style( 'lightboxStyle' );
				if ( file_exists( $style_path_dir . '/' . $g_lbp_base_options['lightboxplus_style'] . '/helper.js' ) ) {
					wp_enqueue_script( 'lbp-helper', $style_path_url . '/' . $g_lbp_base_options['lightboxplus_style'] . '/helper.js', '', LBP_VERSION, $this->set_load_location( $g_lbp_base_options['load_location'] ) );
				}
			}

			return $post->ID;
		}

		/**
		 * Add JavaScript (jQuery based) to page footer to activate LBP
		 *
		 * @echo string
		 */
		function lbp_colorbox() {
			global $post;
			global $g_lbp_base_options;
			global $g_lbp_primary_options;
			global $g_lbp_secondary_options;
			global $g_lbp_inline_options;

			if ( isset( $g_lbp_base_options ) ) {

				/**
				 * Remove following line after a few versions or 2.6 is the prevelent version
				 */
				if ( isset( $g_lbp_base_options ) ) {
					$g_lbp_base_options = $this->set_missing_options( $g_lbp_base_options );
				}

				$st_lbp_javascript = "";
				$st_lbp_javascript .= '<!-- Lightbox Plus Colorbox v' . LBP_VERSION . '/' . LBP_COLORBOX_VERSION . ' - 2013.01.24 - Message: ' . $g_lbp_base_options['lightboxplus_multi'] . '-->' . PHP_EOL;
				$st_lbp_javascript .= '<script type="text/javascript">' . PHP_EOL;
				$st_lbp_javascript .= 'jQuery(document).ready(function($){' . PHP_EOL;
				$ar_lbp_primary = array();
				if ( $g_lbp_primary_options['transition'] != 'elastic' ) {
					$ar_lbp_primary[] = 'transition:"' . $g_lbp_primary_options['transition'] . '"';
				}
				if ( $g_lbp_primary_options['speed'] != '300' ) {
					$ar_lbp_primary[] = 'speed:' . $g_lbp_primary_options['speed'];
				}
				if ( $g_lbp_primary_options['width'] != 'false' ) {
					$ar_lbp_primary[] = 'width:' . $this->set_value( $g_lbp_primary_options['width'] );
				}
				if ( $g_lbp_primary_options['height'] != 'false' ) {
					$ar_lbp_primary[] = 'height:' . $this->set_value( $g_lbp_primary_options['height'] );
				}
				if ( $g_lbp_primary_options['inner_width'] != 'false' ) {
					$ar_lbp_primary[] = 'innerWidth:' . $this->set_value( $g_lbp_primary_options['inner_width'] );
				}
				if ( $g_lbp_primary_options['inner_height'] != 'false' ) {
					$ar_lbp_primary[] = 'innerHeight:' . $this->set_value( $g_lbp_primary_options['inner_height'] );
				}
				if ( $g_lbp_primary_options['initial_width'] != '600' ) {
					$ar_lbp_primary[] = 'initialWidth:' . $this->set_value( $g_lbp_primary_options['initial_width'] );
				}
				if ( $g_lbp_primary_options['initial_height'] != '450' ) {
					$ar_lbp_primary[] = 'initialHeight:' . $this->set_value( $g_lbp_primary_options['initial_height'] );
				}
				if ( $g_lbp_primary_options['max_width'] != 'false' ) {
					$ar_lbp_primary[] = 'maxWidth:' . $this->set_value( $g_lbp_primary_options['max_width'] );
				}
				if ( $g_lbp_primary_options['max_height'] != 'false' ) {
					$ar_lbp_primary[] = 'maxHeight:' . $this->set_value( $g_lbp_primary_options['max_height'] );
				}
				if ( $g_lbp_primary_options['resize'] != '1' ) {
					$ar_lbp_primary[] = 'scalePhotos:' . $this->set_boolean( $g_lbp_primary_options['resize'] );
				}
				if ( $g_lbp_primary_options['rel'] == 'nofollow' ) {
					$ar_lbp_primary[] = 'rel:' . $this->set_value( $g_lbp_primary_options['rel'] );
				}
				if ( $g_lbp_primary_options['opacity'] != '0.9' ) {
					$ar_lbp_primary[] = 'opacity:' . $g_lbp_primary_options['opacity'];
				}
				if ( $g_lbp_primary_options['preloading'] != '1' ) {
					$ar_lbp_primary[] = 'preloading:' . $this->set_boolean( $g_lbp_primary_options['preloading'] );
				}
				if ( $g_lbp_primary_options['label_image'] != 'Image' && $g_lbp_primary_options['label_of'] != 'of' ) {
					$ar_lbp_primary[] = 'current:"' . $g_lbp_primary_options['label_image'] . ' {current} ' . $g_lbp_primary_options['label_of'] . ' {total}"';
				}
				if ( $g_lbp_primary_options['previous'] != 'previous' ) {
					$ar_lbp_primary[] = 'previous:"' . $g_lbp_primary_options['previous'] . '"';
				}
				if ( $g_lbp_primary_options['next'] != 'next' ) {
					$ar_lbp_primary[] = 'next:"' . $g_lbp_primary_options['next'] . '"';
				}
				if ( $g_lbp_primary_options['close'] != 'close' ) {
					$ar_lbp_primary[] = 'close:"' . $g_lbp_primary_options['close'] . '"';
				}
				if ( $g_lbp_primary_options['overlay_close'] != '1' ) {
					$ar_lbp_primary[] = 'overlayClose:' . $this->set_boolean( $g_lbp_primary_options['overlay_close'] );
				}
				if ( $g_lbp_primary_options['loop'] != '1' ) {
					$ar_lbp_primary[] = 'loop:' . $this->set_boolean( $g_lbp_primary_options['loop'] );
				}
				if ( $g_lbp_primary_options['slideshow'] == '1' ) {
					$ar_lbp_primary[] = 'slideshow:' . $this->set_boolean( $g_lbp_primary_options['slideshow'] );
				}
				if ( $g_lbp_primary_options['slideshow'] == '1' ) {
					if ( $g_lbp_primary_options['slideshow_auto'] != '1' ) {
						$ar_lbp_primary[] = 'slideshowAuto:' . $this->set_boolean( $g_lbp_primary_options['slideshow_auto'] );
					}
					if ( $g_lbp_primary_options['slideshow_speed'] ) {
						$ar_lbp_primary[] = 'slideshowSpeed:' . $g_lbp_primary_options['slideshow_speed'];
					}
					if ( $g_lbp_primary_options['slideshow_start'] ) {
						$ar_lbp_primary[] = 'slideshowStart:"' . $g_lbp_primary_options['slideshow_start'] . '"';
					}
					if ( $g_lbp_primary_options['slideshow_stop'] ) {
						$ar_lbp_primary[] = 'slideshowStop:"' . $g_lbp_primary_options['slideshow_stop'] . '"';
					}
				}
				if ( $g_lbp_primary_options['scrolling'] != '1' ) {
					$ar_lbp_primary[] = 'scrolling:' . $this->set_boolean( $g_lbp_primary_options['scrolling'] );
				}
				if ( $g_lbp_primary_options['esc_key'] != '1' ) {
					$ar_lbp_primary[] = 'escKey:' . $this->set_boolean( $g_lbp_primary_options['esc_key'] );
				}
				if ( $g_lbp_primary_options['arrow_key'] != '1' ) {
					$ar_lbp_primary[] = 'arrowKey:' . $this->set_boolean( $g_lbp_primary_options['arrow_key'] );
				}
				if ( $g_lbp_primary_options['top'] != 'false' ) {
					$ar_lbp_primary[] = 'top:' . $this->set_value( $g_lbp_primary_options['top'] );
				}
				if ( $g_lbp_primary_options['right'] != 'false' ) {
					$ar_lbp_primary[] = 'right:' . $this->set_value( $g_lbp_primary_options['right'] );
				}
				if ( $g_lbp_primary_options['bottom'] != 'false' ) {
					$ar_lbp_primary[] = 'bottom:' . $this->set_value( $g_lbp_primary_options['bottom'] );
				}
				if ( $g_lbp_primary_options['left'] != 'false' ) {
					$ar_lbp_primary[] = 'left:' . $this->set_value( $g_lbp_primary_options['left'] );
				}
				if ( $g_lbp_primary_options['fixed'] == '1' ) {
					$ar_lbp_primary[] = 'fixed:' . $this->set_boolean( $g_lbp_primary_options['fixed'] );
				}
				if ( $g_lbp_primary_options['retina_image'] == '1' ) {
					$ar_lbp_primary[] = 'retinaImage:' . $this->set_boolean( $g_lbp_primary_options['retina_image'] );
				}
				if ( $g_lbp_primary_options['retina_url'] == '1' ) {
					$ar_lbp_primary[] = 'retinaUrl:' . $this->set_boolean( $g_lbp_primary_options['retina_url'] );
				}
				if ( $g_lbp_primary_options['retina_url'] == '1' ) {
					if ( isset( $g_lbp_primary_options['retina_suffix'] )) {
						$ar_lbp_primary[] = "retinaSuffix:'".$g_lbp_primary_options['retina_suffix']."'";
					}
				}
				if ( ! is_admin() ) {
					$lbp_autoload = get_post_meta( $post->ID, '_lbp_autoload', true );
					if ( $lbp_autoload == '1' ) {
						$ar_lbp_primary[] = 'open:true';
					}
				}
				switch ( $g_lbp_base_options['output_htmlv'] ) {
					case 1:
						$htmlv_prop             = 'data-' . $g_lbp_base_options['data_name'];
						$lbp_primary_javascript = '{rel:$(this).attr("' . $htmlv_prop . '"),' . implode( ",", $ar_lbp_primary ) . '}';
						switch ( $g_lbp_base_options['use_class_method'] ) {
							case 1:
								$st_lbp_javascript .= '  $(".' . $g_lbp_primary_options['class_name'] . '").each(function(){' . PHP_EOL;
								$st_lbp_javascript .= '    $(this).colorbox(' . $lbp_primary_javascript . ');' . PHP_EOL;
								$st_lbp_javascript .= '  });' . PHP_EOL;
								break;
							default:
								$st_lbp_javascript .= '  $("a[' . $htmlv_prop . '*=lightbox]").each(function(){' . PHP_EOL;
								$st_lbp_javascript .= '    $(this).colorbox(' . $lbp_primary_javascript . ');' . PHP_EOL;
								$st_lbp_javascript .= '  });' . PHP_EOL;
								break;
						}
						break;
					default:
						$lbp_primary_javascript = '{' . implode( ",", $ar_lbp_primary ) . '}';
						switch ( $g_lbp_primary_options['use_class_method'] ) {
							case 1:
								$st_lbp_javascript .= '  $(".' . $g_lbp_primary_options['class_name'] . '").colorbox(' . $lbp_primary_javascript . ');' . PHP_EOL;
								break;
							default:
								$st_lbp_javascript .= '  $("a[rel*=lightbox]").colorbox(' . $lbp_primary_javascript . ');' . PHP_EOL;
								break;
						}
						break;
				}
				switch ( $g_lbp_base_options['lightboxplus_multi'] ) {
					case 1:
						$ar_lbp_secondary = array();
						if ( $g_lbp_secondary_options['transition_sec'] != 'elastic' ) {
							$ar_lbp_secondary[] = 'transition:"' . $g_lbp_secondary_options['transition_sec'] . '"';
						}
						if ( $g_lbp_secondary_options['speed_sec'] != '350' ) {
							$ar_lbp_secondary[] = 'speed:' . $g_lbp_secondary_options['speed_sec'];
						}
						if ( $g_lbp_secondary_options['width_sec'] && $g_lbp_secondary_options['width_sec'] != 'false' ) {
							$ar_lbp_secondary[] = 'width:' . $this->set_value( $g_lbp_secondary_options['width_sec'] );
						}
						if ( $g_lbp_secondary_options['height_sec'] && $g_lbp_secondary_options['height_sec'] != 'false' ) {
							$ar_lbp_secondary[] = 'height:' . $this->set_value( $g_lbp_secondary_options['height_sec'] );
						}
						if ( $g_lbp_secondary_options['inner_width_sec'] && $g_lbp_secondary_options['inner_width_sec'] != 'false' ) {
							$ar_lbp_secondary[] = 'innerWidth:' . $this->set_value( $g_lbp_secondary_options['inner_width_sec'] );
						}
						if ( $g_lbp_secondary_options['inner_height_sec'] && $g_lbp_secondary_options['inner_height_sec'] != 'false' ) {
							$ar_lbp_secondary[] = 'innerHeight:' . $this->set_value( $g_lbp_secondary_options['inner_height_sec'] );
						}
						if ( $g_lbp_secondary_options['initial_width_sec'] && $g_lbp_secondary_options['initial_width_sec'] != '600' ) {
							$ar_lbp_secondary[] = 'initialWidth:' . $this->set_value( $g_lbp_secondary_options['initial_width_sec'] );
						}
						if ( $g_lbp_secondary_options['initial_height_sec'] && $g_lbp_secondary_options['initial_height_sec'] != '450' ) {
							$ar_lbp_secondary[] = 'initialHeight:' . $this->set_value( $g_lbp_secondary_options['initial_height_sec'] );
						}
						if ( $g_lbp_secondary_options['max_width_sec'] && $g_lbp_secondary_options['max_width_sec'] != 'false' ) {
							$ar_lbp_secondary[] = 'maxWidth:' . $this->set_value( $g_lbp_secondary_options['max_width_sec'] );
						}
						if ( $g_lbp_secondary_options['max_height_sec'] && $g_lbp_secondary_options['max_height_sec'] != 'false' ) {
							$ar_lbp_secondary[] = 'maxHeight:' . $this->set_value( $g_lbp_secondary_options['max_height_sec'] );
						}
						if ( $g_lbp_secondary_options['resize_sec'] != '1' ) {
							$ar_lbp_secondary[] = 'scalePhotos:' . $this->set_boolean( $g_lbp_secondary_options['resize_sec'] );
						}
						if ( $g_lbp_secondary_options['rel_sec'] == 'nofollow' ) {
							$ar_lbp_primary[] = 'rel:' . $this->set_value( $g_lbp_secondary_options['rel'] );
						}
						if ( $g_lbp_secondary_options['opacity_sec'] != '0.9' ) {
							$ar_lbp_secondary[] = 'opacity:' . $g_lbp_secondary_options['opacity_sec'];
						}
						if ( $g_lbp_secondary_options['preloading_sec'] != '1' ) {
							$ar_lbp_secondary[] = 'preloading:' . $this->set_boolean( $g_lbp_secondary_options['preloading_sec'] );
						}
						if ( $g_lbp_secondary_options['label_image_sec'] != 'Image' && $g_lbp_secondary_options['label_of_sec'] != 'of' ) {
							$ar_lbp_secondary[] = 'current:"' . $g_lbp_secondary_options['label_image_sec'] . ' {current} ' . $g_lbp_secondary_options['label_of_sec'] . ' {total}"';
						}
						if ( $g_lbp_secondary_options['previous_sec'] != 'previous' ) {
							$ar_lbp_secondary[] = 'previous:"' . $g_lbp_secondary_options['previous_sec'] . '"';
						}
						if ( $g_lbp_secondary_options['next_sec'] != 'next' ) {
							$ar_lbp_secondary[] = 'next:"' . $g_lbp_secondary_options['next_sec'] . '"';
						}
						if ( $g_lbp_secondary_options['close_sec'] != 'close' ) {
							$ar_lbp_secondary[] = 'close:"' . $g_lbp_secondary_options['close_sec'] . '"';
						}
						if ( $g_lbp_secondary_options['overlay_close_sec'] != '1' ) {
							$ar_lbp_secondary[] = 'overlayClose:' . $this->set_boolean( $g_lbp_secondary_options['overlay_close_sec'] );
						}
						if ( $g_lbp_secondary_options['loop_sec'] != '1' ) {
							$ar_lbp_primary[] = 'loop:' . $this->set_boolean( $g_lbp_secondary_options['loop_sec'] );
						}
						if ( $g_lbp_secondary_options['slideshow_sec'] == '1' ) {
							$ar_lbp_secondary[] = 'slideshow:' . $this->set_boolean( $g_lbp_secondary_options['slideshow_sec'] );
						}
						if ( $g_lbp_secondary_options['slideshow_sec'] == '1' ) {
							if ( $g_lbp_secondary_options['slideshow_auto_sec'] != '1' ) {
								$ar_lbp_secondary[] = 'slideshowAuto:' . $this->set_boolean( $g_lbp_secondary_options['slideshow_auto_sec'] );
							}
							if ( $g_lbp_secondary_options['slideshow_speed_sec'] ) {
								$ar_lbp_secondary[] = 'slideshowSpeed:' . $g_lbp_secondary_options['slideshow_speed_sec'];
							}
							if ( $g_lbp_secondary_options['slideshow_start_sec'] ) {
								$ar_lbp_secondary[] = 'slideshowStart:"' . $g_lbp_secondary_options['slideshow_start_sec'] . '"';
							}
							if ( $g_lbp_secondary_options['slideshow_stop_sec'] ) {
								$ar_lbp_secondary[] = 'slideshowStop:"' . $g_lbp_secondary_options['slideshow_stop_sec'] . '"';
							}
						}
						if ( $g_lbp_secondary_options['iframe_sec'] != '0' ) {
							$ar_lbp_secondary[] = 'iframe:' . $this->set_boolean( $g_lbp_secondary_options['iframe_sec'] );
						}
						if ( $g_lbp_secondary_options['scrolling_sec'] != '1' ) {
							$ar_lbp_secondary[] = 'scrolling:' . $this->set_boolean( $g_lbp_secondary_options['scrolling_sec'] );
						}
						if ( $g_lbp_secondary_options['esc_key_sec'] != '1' ) {
							$ar_lbp_secondary[] = 'escKey:' . $this->set_boolean( $g_lbp_secondary_options['esc_key_sec'] );
						}
						if ( $g_lbp_secondary_options['arrow_key_sec'] != '1' ) {
							$ar_lbp_secondary[] = 'arrowKey:' . $this->set_boolean( $g_lbp_secondary_options['arrow_key_sec'] );
						}
						if ( $g_lbp_secondary_options['top_sec'] != 'false' ) {
							$ar_lbp_secondary[] = 'top:' . $this->set_value( $g_lbp_secondary_options['top_sec'] );
						}
						if ( $g_lbp_secondary_options['right_sec'] != 'false' ) {
							$ar_lbp_secondary[] = 'right:' . $this->set_value( $g_lbp_secondary_options['right_sec'] );
						}
						if ( $g_lbp_secondary_options['bottom_sec'] != 'false' ) {
							$ar_lbp_secondary[] = 'bottom:' . $this->set_value( $g_lbp_secondary_options['bottom_sec'] );
						}
						if ( $g_lbp_secondary_options['left_sec'] != 'false' ) {
							$ar_lbp_secondary[] = 'left:' . $this->set_value( $g_lbp_secondary_options['left_sec'] );
						}
						if ( $g_lbp_secondary_options['fixed_sec'] == '1' ) {
							$ar_lbp_secondary[] = 'fixed:' . $this->set_boolean( $g_lbp_secondary_options['fixed_sec'] );
						}
						if ( $g_lbp_primary_options['retina_image_sec'] == '1' ) {
							$ar_lbp_primary[] = 'retinaImage:' . $this->set_boolean( $g_lbp_primary_options['retina_image_sec'] );
						}
						if ( $g_lbp_primary_options['retina_url_sec'] == '1' ) {
							$ar_lbp_primary[] = 'retinaUrl:' . $this->set_boolean( $g_lbp_primary_options['retina_url_sec'] );
						}
						if ( $g_lbp_primary_options['retina_url_sec'] == '1' ) {
							if ( isset( $g_lbp_primary_options['retina_suffix_sec'] ) ) {
								$ar_lbp_primary[] = "retinaSuffix:'".$g_lbp_primary_options['retina_suffix_sec']."'";
							}
						}
						$st_lbp_secondary_javascript = '{'.implode(",", $ar_lbp_secondary).'}';
						switch ( $g_lbp_base_options['output_htmlv'] ) {
							case 1:
								$htmlv_prop = 'data-' . $g_lbp_base_options['data_name'];
								//$st_lbp_secondary_javascript = '{'.implode(",", $ar_lbp_secondary).'}';
								$st_lbp_secondary_javascript = '{rel:$(this).attr("' . $htmlv_prop . '"),' . implode( ",", $ar_lbp_secondary ) . '}';
								$st_lbp_javascript .= '  $(".' . $g_lbp_secondary_options['class_name_sec'] . '").each(function(){' . PHP_EOL;
								$st_lbp_javascript .= '    $(this).colorbox(' . $st_lbp_secondary_javascript . ');' . PHP_EOL;
								$st_lbp_javascript .= '  });' . PHP_EOL;
								break;
							default:
								$st_lbp_secondary_javascript = '{' . implode( ",", $ar_lbp_secondary ) . '}';
								$st_lbp_javascript .= '  $(".' . $g_lbp_secondary_options['class_name_sec'] . '").colorbox(' . $st_lbp_secondary_javascript . ');' . PHP_EOL;
								break;
						}
						break;
					default:
						break;
				}

				if ( isset( $g_lbp_base_options['use_inline'] ) && '' != $g_lbp_base_options['inline_num'] ) {
					$ar_inline_links            = $g_lbp_inline_options['inline_links'];
					$ar_inline_hrefs            = $g_lbp_inline_options['inline_hrefs'];
					$ar_inline_transitions      = $g_lbp_inline_options['inline_transitions'];
					$ar_inline_speeds           = $g_lbp_inline_options['inline_speeds'];
					$ar_inline_widths           = $g_lbp_inline_options['inline_widths'];
					$ar_inline_heights          = $g_lbp_inline_options['inline_heights'];
					$ar_inline_inner_widths     = $g_lbp_inline_options['inline_inner_widths'];
					$ar_inline_inner_heights    = $g_lbp_inline_options['inline_inner_heights'];
					$ar_inline_max_widths       = $g_lbp_inline_options['inline_max_widths'];
					$ar_inline_max_heights      = $g_lbp_inline_options['inline_max_heights'];
					$ar_inline_position_tops    = $g_lbp_inline_options['inline_position_tops'];
					$ar_inline_position_rights  = $g_lbp_inline_options['inline_position_rights'];
					$ar_inline_position_bottoms = $g_lbp_inline_options['inline_position_bottoms'];
					$ar_inline_position_lefts   = $g_lbp_inline_options['inline_position_lefts'];
					$ar_inline_fixeds           = $g_lbp_inline_options['inline_fixeds'];
					$ar_inline_opens            = $g_lbp_inline_options['inline_opens'];
					$ar_inline_reuses           = $g_lbp_inline_options['inline_reuses'];
					$ar_inline_opacitys         = $g_lbp_inline_options['inline_opacitys'];

					for ( $i = 1; $i <= $g_lbp_base_options['inline_num']; $i ++ ) {
						if ( isset( $ar_inline_reuses[ $i ] ) && 1 == $ar_inline_reuses[ $i ] ) {
							$st_lbp_javascript .= '  $(".' . $ar_inline_links[ $i ] . '").click(function() { $(this).colorbox({transition:' . $this->set_value( $ar_inline_transitions[ $i ] ) . ', speed:' . $this->set_value( $ar_inline_speeds[ $i ] ) . ', width:' . $this->set_value( $ar_inline_widths[ $i ] ) . ', height:' . $this->set_value( $ar_inline_heights[ $i ] ) . ', innerWidth:' . $this->set_value( $ar_inline_inner_widths[ $i ] ) . ', innerHeight:' . $this->set_value( $ar_inline_inner_heights[ $i ] ) . ', maxWidth:' . $this->set_value( $ar_inline_max_widths[ $i ] ) . ', maxHeight:' . $this->set_value( $ar_inline_max_heights[ $i ] ) . ', top:' . $this->set_value( $ar_inline_position_tops[ $i ] ) . ', right:' . $this->set_value( $ar_inline_position_rights[ $i ] ) . ', bottom:' . $this->set_value( $ar_inline_position_bottoms[ $i ] ) . ', left:' . $this->set_value( $ar_inline_position_lefts[ $i ] ) . ', fixed:' . $this->set_boolean( $ar_inline_fixeds[ $i ] ) . ', open:' . $this->set_boolean( $ar_inline_opens[ $i ] ) . ', opacity:' . $this->set_value( $ar_inline_opacitys[ $i ] ) . ', inline:true, href: "." + $(this).attr("data-link")}); });' . PHP_EOL;
						} elseif ( isset( $ar_inline_links[ $i ] ) ) {
							$st_lbp_javascript .= '  $(".' . $ar_inline_links[ $i ] . '").colorbox({transition:' . $this->set_value( $ar_inline_transitions[ $i ] ) . ', speed:' . $this->set_value( $ar_inline_speeds[ $i ] ) . ', width:' . $this->set_value( $ar_inline_widths[ $i ] ) . ', height:' . $this->set_value( $ar_inline_heights[ $i ] ) . ', innerWidth:' . $this->set_value( $ar_inline_inner_widths[ $i ] ) . ', innerHeight:' . $this->set_value( $ar_inline_inner_heights[ $i ] ) . ', maxWidth:' . $this->set_value( $ar_inline_max_widths[ $i ] ) . ', maxHeight:' . $this->set_value( $ar_inline_max_heights[ $i ] ) . ', top:' . $this->set_value( $ar_inline_position_tops[ $i ] ) . ', right:' . $this->set_value( $ar_inline_position_rights[ $i ] ) . ', bottom:' . $this->set_value( $ar_inline_position_bottoms[ $i ] ) . ', left:' . $this->set_value( $ar_inline_position_lefts[ $i ] ) . ', fixed:' . $this->set_boolean( $ar_inline_fixeds[ $i ] ) . ', open:' . $this->set_boolean( $ar_inline_opens[ $i ] ) . ', opacity:' . $this->set_value( $ar_inline_opacitys[ $i ] ) . ', inline:true, href:"#' . $ar_inline_hrefs[ $i ] . '"});' . PHP_EOL;
						} else {
							$st_lbp_javascript .= '';
						}
					}

				}

				$st_lbp_javascript .= '});' . PHP_EOL;
				$st_lbp_javascript .= '</script>' . PHP_EOL;
				echo $st_lbp_javascript;
			}
		}

		/**
		 * Add new admin panel to WordPress under the Appearance category
		 */
		function lbp_add_panel() {
			$plugin_page = add_theme_page( 'Lightbox Plus Colorbox', __( 'Lightbox Plus Colorbox', 'lightboxplus' ), 'manage_options', 'lightboxplus', array(
				&$this,
				'lbp_admin_panel'
			) );
			add_action( 'admin_print_scripts-' . $plugin_page, array( &$this, 'lbp_admin_scripts' ) );
			add_action( 'admin_head-' . $plugin_page, array( &$this, 'lbp_colorbox' ) );
			add_action( 'admin_print_styles-' . $plugin_page, array( &$this, 'lbp_admin_styles' ) );
		}

		/**
		 * Tells WordPress to load the jquery, jquery-ui-core and jquery-ui-dialog in the lightbox plus admin panel
		 */
		function lbp_admin_scripts() {
			wp_enqueue_script( 'jquery', '', '', '', true );
			wp_enqueue_script( 'jquery-ui-core', '', '', '', true );
			wp_enqueue_script( 'jquery-ui-dialog', '', '', '', true );
			wp_enqueue_script( 'jquery-ui-tabs', '', '', '', true );
			wp_enqueue_script( 'jquery-ui-tooltip', '', '', '', true );
			wp_enqueue_script( 'jquery-colorbox', LBP_ASSETS_URL . '/js/jquery.colorbox.' . LBP_COLORBOX_VERSION . '-min.js', array( 'jquery' ), LBP_COLORBOX_VERSION, true );
			wp_enqueue_script( 'lightboxplus-admin', LBP_ASSETS_URL . '/js/lightbox.admin.js', array( 'jquery' ), LBP_VERSION, true );
		}

		/**
		 * Add CSS styles to lightbox plus admin panel page headers to display lightboxed images
		 */
		function lbp_admin_styles() {
			global $g_lbp_base_options;
			if ( ! isset( $g_lbp_base_options ) ) {
				$g_lbp_base_options = get_option( 'lightboxplus_options_base' );
			}
			wp_register_style( 'lbp_styles', LBP_ASSETS_URL . '/css/lightbox-admin.css', '', LBP_VERSION, 'screen' );
			wp_enqueue_style( 'lbp_styles' );

			if ( isset( $g_lbp_base_options ) ) {
				//$g_lbp_base_options = get_option( $this->lbp_options_base_name );

				if ( $g_lbp_base_options['use_custom_style'] == 1 ) {
					$style_path_url = LBP_CUSTOM_STYLE_URL;
					$style_path_dir = LBP_CUSTOM_STYLE_PATH;
				} else {
					$style_path_url = LBP_STYLE_URL;
					$style_path_dir = LBP_STYLE_PATH;
				}

				if ( $g_lbp_base_options['disable_css'] ) {
					echo "<!-- User set lightbox styles -->" . PHP_EOL;
				} else {
					wp_register_style( 'lightboxStyle', $style_path_url . '/' . $g_lbp_base_options['lightboxplus_style'] . '/colorbox.css', '', LBP_VERSION, 'screen' );
					wp_register_style( 'lightboxStylebase', $style_path_url . '/colorbox-base.css', '', LBP_VERSION, 'screen' );
					wp_enqueue_style( 'lightboxStyle', 'lightboxStylebase' );
					if ( file_exists( $style_path_dir . '/' . $g_lbp_base_options['lightboxplus_style'] . '/helper.js' ) ) {
						wp_enqueue_script( 'lbp-helper', $style_path_url . '/' . $g_lbp_base_options['lightboxplus_style'] . '/helper.js', '', LBP_VERSION, true );
					}
				}
			}
		}

		/**
		 * Add metabox to edit post/page for per page application of lightbox plus
		 */
		function lbp_save_post_meta() {
			add_action( 'save_post', array( $this, 'lbp_save_meta' ), 10, 1 );
		}

		function lbp_meta_box() {
			add_meta_box( 'lbp-meta-box', __( 'Lightbox Plus Colorbox Per Page', 'lightboxplus' ), array(
				&$this,
				'lbp_show_meta'
			), 'page', 'side', 'high' );
		}

		function lbp_show_meta( $post ) {
			wp_nonce_field( 'lbp_meta_nonce', 'nonce_lbp' );
			$lbp_use      = get_post_meta( $post->ID, '_lbp_use', true );
			$lbp_uid      = get_post_meta( $post->ID, '_lbp_uid', true );
			$lbp_autoload = get_post_meta( $post->ID, '_lbp_autoload', true );
			?>
			<table class="form-table">
				<tr>
					<th scope="row">
						<label for="lbp_use"><?php _e( 'Use with this page/post:', 'lightboxplus' ); ?></label>:
					</th>
					<td>
						<input type="hidden" name="lbp_use" value="0">
						<input type="checkbox" name="lbp_use" id="lbp_use" value="1" <?php if ( isset( $lbp_use ) ) {
							checked( '1', $lbp_use );
						} ?> />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="lbp_autoload"><?php _e( 'Auto launch on this page/post:', 'lightboxplus' ); ?></label>:
					</th>
					<td>
						<input type="hidden" name="lbp_autoload" value="0">
						<input type="checkbox" name="lbp_autoload" id="lbp_autoload" value="1"<?php if ( isset( $lbp_autoload ) ) {
							checked( '1', $lbp_autoload );
						} ?> />
					</td>
				</tr>
				<tr>
					<th scope="row" colspan="2">
						<label for="lbp_uid"><?php _e( 'Lightbox Plus Colorbox unique ID for this page:', 'lightboxplus' ); ?></label>:
					</th>
				</tr>
				<tr>
					<td colspan="2">
						<input type="text" id="lbp_uid" name="lbp_uid" size="20" value="<?php if ( ! empty( $lbp_uid ) ) {
							echo $lbp_uid;
						} else {
							echo $post->post_name;
						} ?>" />
						<br />
						<small><?php _e( '(defaults to page/post name/slug)', 'lightboxplus' ); ?></small>
					</td>
				</tr>
			</table>

		<?php
		}

		function lbp_save_meta( $post_id ) {
			global $postid;
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return false;
			}

			if ( isset( $_POST['nonce_lbp'] ) && ! wp_verify_nonce( $_POST['nonce_lbp'], 'lbp_meta_nonce' ) ) {
				return false;
			}

			if ( isset( $_POST['post_type'] ) && $_POST['post_type'] == 'page' ) {
				if ( ! current_user_can( 'edit_page', $postid ) ) {
					return false;
				}
			} else {
				if ( isset( $postid ) && ! current_user_can( 'edit_post', $postid ) ) {
					return false;
				}
			}

			if ( isset( $post_id ) ) {
				if ( isset( $_POST['lbp_use'] ) ) {
					$lbp_use = $_POST['lbp_use'];
					update_post_meta( $post_id, '_lbp_use', $lbp_use );
				}
				if ( isset( $_POST['lbp_autoload'] ) ) {
					$lbp_autoload = $_POST['lbp_autoload'];
					update_post_meta( $post_id, '_lbp_autoload', $lbp_autoload );
				}
				if ( isset( $_POST['lbp_uid'] ) ) {
					$lbp_uid = $_POST['lbp_uid'];
					update_post_meta( $post_id, '_lbp_uid', $lbp_uid );
				}
			}

			return $post_id;
		}
	}
}