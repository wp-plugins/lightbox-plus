<?php
/**
 * @package    Lightbox Plus Colorbox
 * @subpackage actions.class.php
 * @internal   2013.01.16
 * @author     Dan Zappone / 23Systems
 * @version    2.7
 * @$Id$
 * @$URL$
 */
if ( ! class_exists( 'lbp_actions' ) ) {
	class lbp_actions extends lbp_filters {
		/**
		 * Tell WordPress to load jquery and jquery-colorbox-min.js in the front end and the admin panel
		 */
		//            function lightboxPlusInitScripts() {
		//                global LBP_URL;
		//
		//            }
		function getPostID() {
			global $the_post_id;
			global $wp_query;
			$the_post_id = $wp_query->post->ID;
			echo $the_post_id;
		}

		/**
		 * Add CSS styles to site page headers to display lightboxed images
		 */
		function lightboxPlusAddHeader() {
			global $post;
			global $wp_version;

			if ( ! empty( $this->lightboxOptions ) ) {
				$lightboxPlusOptions = $this->getAdminOptions( $this->lightboxOptionsName );
			}

			/**
			 * Remove following line after a few versions or 2.6 is the prevelent version
			 */
			if (isset($lightboxPlusOptions)) { $lightboxPlusOptions = $this->setMissingOptions( $lightboxPlusOptions ); }

			if ( ! is_admin() ) {
				if ( floatval( $wp_version ) < 3.1 ) {
					wp_deregister_script( 'jquery' );
					wp_register_script( 'jquery', "http" . ( $_SERVER['SERVER_PORT'] == 443 ? "s" : "" ) . "://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js", false, null );
					wp_enqueue_script( 'jquery' );
				} else {
					wp_enqueue_script( 'jquery', '', '', '', true );
				}
				//wp_enqueue_script('jquery-colorbox', LBP_URL.'asset/js/jquery.colorbox.'.LBP_COLORBOX_VERSION.'-min.js', array( 'jquery' ), LBP_COLORBOX_VERSION, $this->setLoadLocation($lightboxPlusOptions['load_location']));
				wp_enqueue_script( 'jquery-colorbox', LBP_URL . 'asset/js/jquery.colorbox.' . LBP_COLORBOX_VERSION . '.js', array( 'jquery' ), LBP_COLORBOX_VERSION, $this->setLoadLocation( $lightboxPlusOptions['load_location'] ) );
			}

			if ( $lightboxPlusOptions['use_custom_style'] ) {
				$style_path_url = LBP_CUSTOM_STYLE_URL;
				$style_path_dir = LBP_CUSTOM_STYLE_PATH;
			} else {
				$style_path_url = LBP_STYLE_URL;
				$style_path_dir = LBP_STYLE_PATH;
			}

			if ( $lightboxPlusOptions['disable_css'] ) {
				echo "<!-- User set lightbox styles -->" . PHP_EOL;
			} else {
				wp_register_style( 'lightboxStyle', $style_path_url . '/' . $lightboxPlusOptions['lightboxplus_style'] . '/colorbox.css', '', LBP_VERSION, 'screen' );
				wp_enqueue_style( 'lightboxStyle' );
				if ( file_exists( $style_path_dir . '/' . $lightboxPlusOptions['lightboxplus_style'] . '/helper.js' ) ) {
					wp_enqueue_script( 'lbp-helper', $style_path_url . '/' . $lightboxPlusOptions['lightboxplus_style'] . '/helper.js', '', LBP_VERSION, $this->setLoadLocation( $lightboxPlusOptions['load_location'] ) );
				}
			}

			return $post->ID;
		}

		/**
		 * Add JavaScript (jQuery based) to page footer to activate LBP
		 *
		 * @echo string
		 */
		function lightboxPlusColorbox() {
			global $post;
			if ( ! empty( $this->lightboxOptions ) ) {
				$lightboxPlusOptions = $this->getAdminOptions( $this->lightboxOptionsName );
				$lightboxPlusPrimaryOptions = $this->getAdminOptions( $this->lightboxOptionsPrimaryName );
				$lightboxPlusSecondaryOptions = $this->getAdminOptions( $this->lightboxOptionsSecondaryName );
				$lightboxPlusInlineOptions = $this->getAdminOptions( $this->lightboxOptionsInlineName );
				/**
				 * Remove following line after a few versions or 2.6 is the prevelent version
				 */
				if (isset($lightboxPlusOptions)) { $lightboxPlusOptions = $this->setMissingOptions( $lightboxPlusOptions ); }

				$lightboxPlusJavaScript = "";
				$lightboxPlusJavaScript .= '<!-- Lightbox Plus Colorbox v' . LBP_VERSION . '/' . LBP_COLORBOX_VERSION . ' - 2013.01.24 - Message: ' . $lightboxPlusOptions['lightboxplus_multi'] . '-->' . PHP_EOL;
				$lightboxPlusJavaScript .= '<script type="text/javascript">' . PHP_EOL;
				$lightboxPlusJavaScript .= 'jQuery(document).ready(function($){' . PHP_EOL;
				$lbpArrayPrimary = array();
				if ( $lightboxPlusPrimaryOptions['transition'] != 'elastic' ) {
					$lbpArrayPrimary[] = 'transition:"' . $lightboxPlusPrimaryOptions['transition'] . '"';
				}
				if ( $lightboxPlusPrimaryOptions['speed'] != '300' ) {
					$lbpArrayPrimary[] = 'speed:' . $lightboxPlusPrimaryOptions['speed'];
				}
				if ( $lightboxPlusPrimaryOptions['width'] != 'false' ) {
					$lbpArrayPrimary[] = 'width:' . $this->setValue( $lightboxPlusPrimaryOptions['width'] );
				}
				if ( $lightboxPlusPrimaryOptions['height'] != 'false' ) {
					$lbpArrayPrimary[] = 'height:' . $this->setValue( $lightboxPlusPrimaryOptions['height'] );
				}
				if ( $lightboxPlusPrimaryOptions['inner_width'] != 'false' ) {
					$lbpArrayPrimary[] = 'innerWidth:' . $this->setValue( $lightboxPlusPrimaryOptions['inner_width'] );
				}
				if ( $lightboxPlusPrimaryOptions['inner_height'] != 'false' ) {
					$lbpArrayPrimary[] = 'innerHeight:' . $this->setValue( $lightboxPlusPrimaryOptions['inner_height'] );
				}
				if ( $lightboxPlusPrimaryOptions['initial_width'] != '600' ) {
					$lbpArrayPrimary[] = 'initialWidth:' . $this->setValue( $lightboxPlusPrimaryOptions['initial_width'] );
				}
				if ( $lightboxPlusPrimaryOptions['initial_height'] != '450' ) {
					$lbpArrayPrimary[] = 'initialHeight:' . $this->setValue( $lightboxPlusPrimaryOptions['initial_height'] );
				}
				if ( $lightboxPlusPrimaryOptions['max_width'] != 'false' ) {
					$lbpArrayPrimary[] = 'maxWidth:' . $this->setValue( $lightboxPlusPrimaryOptions['max_width'] );
				}
				if ( $lightboxPlusPrimaryOptions['max_height'] != 'false' ) {
					$lbpArrayPrimary[] = 'maxHeight:' . $this->setValue( $lightboxPlusPrimaryOptions['max_height'] );
				}
				if ( $lightboxPlusPrimaryOptions['resize'] != '1' ) {
					$lbpArrayPrimary[] = 'scalePhotos:' . $this->setBoolean( $lightboxPlusPrimaryOptions['resize'] );
				}
				if ( $lightboxPlusPrimaryOptions['rel'] == 'nofollow' ) {
					$lbpArrayPrimary[] = 'rel:' . $this->setValue( $lightboxPlusPrimaryOptions['rel'] );
				}
				if ( $lightboxPlusPrimaryOptions['opacity'] != '0.9' ) {
					$lbpArrayPrimary[] = 'opacity:' . $lightboxPlusPrimaryOptions['opacity'];
				}
				if ( $lightboxPlusPrimaryOptions['preloading'] != '1' ) {
					$lbpArrayPrimary[] = 'preloading:' . $this->setBoolean( $lightboxPlusPrimaryOptions['preloading'] );
				}
				if ( $lightboxPlusPrimaryOptions['label_image'] != 'Image' && $lightboxPlusPrimaryOptions['label_of'] != 'of' ) {
					$lbpArrayPrimary[] = 'current:"' . $lightboxPlusPrimaryOptions['label_image'] . ' {current} ' . $lightboxPlusPrimaryOptions['label_of'] . ' {total}"';
				}
				if ( $lightboxPlusPrimaryOptions['previous'] != 'previous' ) {
					$lbpArrayPrimary[] = 'previous:"' . $lightboxPlusPrimaryOptions['previous'] . '"';
				}
				if ( $lightboxPlusPrimaryOptions['next'] != 'next' ) {
					$lbpArrayPrimary[] = 'next:"' . $lightboxPlusPrimaryOptions['next'] . '"';
				}
				if ( $lightboxPlusPrimaryOptions['close'] != 'close' ) {
					$lbpArrayPrimary[] = 'close:"' . $lightboxPlusPrimaryOptions['close'] . '"';
				}
				if ( $lightboxPlusPrimaryOptions['overlay_close'] != '1' ) {
					$lbpArrayPrimary[] = 'overlayClose:' . $this->setBoolean( $lightboxPlusPrimaryOptions['overlay_close'] );
				}
				if ( $lightboxPlusPrimaryOptions['loop'] != '1' ) {
					$lbpArrayPrimary[] = 'loop:' . $this->setBoolean( $lightboxPlusPrimaryOptions['loop'] );
				}
				if ( $lightboxPlusPrimaryOptions['slideshow'] == '1' ) {
					$lbpArrayPrimary[] = 'slideshow:' . $this->setBoolean( $lightboxPlusPrimaryOptions['slideshow'] );
				}
				if ( $lightboxPlusPrimaryOptions['slideshow'] == '1' ) {
					if ( $lightboxPlusPrimaryOptions['slideshow_auto'] != '1' ) {
						$lbpArrayPrimary[] = 'slideshowAuto:' . $this->setBoolean( $lightboxPlusPrimaryOptions['slideshow_auto'] );
					}
					if ( $lightboxPlusPrimaryOptions['slideshow_speed'] ) {
						$lbpArrayPrimary[] = 'slideshowSpeed:' . $lightboxPlusPrimaryOptions['slideshow_speed'];
					}
					if ( $lightboxPlusPrimaryOptions['slideshow_start'] ) {
						$lbpArrayPrimary[] = 'slideshowStart:"' . $lightboxPlusPrimaryOptions['slideshow_start'] . '"';
					}
					if ( $lightboxPlusPrimaryOptions['slideshow_stop'] ) {
						$lbpArrayPrimary[] = 'slideshowStop:"' . $lightboxPlusPrimaryOptions['slideshow_stop'] . '"';
					}
				}
				if ( $lightboxPlusPrimaryOptions['scrolling'] != '1' ) {
					$lbpArrayPrimary[] = 'scrolling:' . $this->setBoolean( $lightboxPlusPrimaryOptions['scrolling'] );
				}
				if ( $lightboxPlusPrimaryOptions['esc_key'] != '1' ) {
					$lbpArrayPrimary[] = 'escKey:' . $this->setBoolean( $lightboxPlusPrimaryOptions['esc_key'] );
				}
				if ( $lightboxPlusPrimaryOptions['arrow_key'] != '1' ) {
					$lbpArrayPrimary[] = 'arrowKey:' . $this->setBoolean( $lightboxPlusPrimaryOptions['arrow_key'] );
				}
				if ( $lightboxPlusPrimaryOptions['top'] != 'false' ) {
					$lbpArrayPrimary[] = 'top:' . $this->setValue( $lightboxPlusPrimaryOptions['top'] );
				}
				if ( $lightboxPlusPrimaryOptions['right'] != 'false' ) {
					$lbpArrayPrimary[] = 'right:' . $this->setValue( $lightboxPlusPrimaryOptions['right'] );
				}
				if ( $lightboxPlusPrimaryOptions['bottom'] != 'false' ) {
					$lbpArrayPrimary[] = 'bottom:' . $this->setValue( $lightboxPlusPrimaryOptions['bottom'] );
				}
				if ( $lightboxPlusPrimaryOptions['left'] != 'false' ) {
					$lbpArrayPrimary[] = 'left:' . $this->setValue( $lightboxPlusPrimaryOptions['left'] );
				}
				if ( $lightboxPlusPrimaryOptions['fixed'] == '1' ) {
					$lbpArrayPrimary[] = 'fixed:' . $this->setBoolean( $lightboxPlusPrimaryOptions['fixed'] );
				}
				if ( ! is_admin() ) {
					$lbp_autoload = get_post_meta( $post->ID, '_lbp_autoload', true );
					if ( $lbp_autoload == '1' ) {
						$lbpArrayPrimary[] = 'open:true';
					}
				}
				switch ( $lightboxPlusOptions['output_htmlv'] ) {
					case 1:
						$htmlv_prop            = 'data-' . $lightboxPlusOptions['data_name'];
						$lightboxPlusFnPrimary = '{rel:$(this).attr("' . $htmlv_prop . '"),' . implode( ",", $lbpArrayPrimary ) . '}';
						switch ( $lightboxPlusOptions['use_class_method'] ) {
							case 1:
								$lightboxPlusJavaScript .= '  $(".' . $lightboxPlusPrimaryOptions['class_name'] . '").each(function(){' . PHP_EOL;
								$lightboxPlusJavaScript .= '    $(this).colorbox(' . $lightboxPlusFnPrimary . ');' . PHP_EOL;
								$lightboxPlusJavaScript .= '  });' . PHP_EOL;
								break;
							default:
								$lightboxPlusJavaScript .= '  $("a[' . $htmlv_prop . '*=lightbox]").each(function(){' . PHP_EOL;
								$lightboxPlusJavaScript .= '    $(this).colorbox(' . $lightboxPlusFnPrimary . ');' . PHP_EOL;
								$lightboxPlusJavaScript .= '  });' . PHP_EOL;
								break;
						}
						break;
					default:
						$lightboxPlusFnPrimary = '{' . implode( ",", $lbpArrayPrimary ) . '}';
						switch ( $lightboxPlusPrimaryOptions['use_class_method'] ) {
							case 1:
								$lightboxPlusJavaScript .= '  $(".' . $lightboxPlusPrimaryOptions['class_name'] . '").colorbox(' . $lightboxPlusFnPrimary . ');' . PHP_EOL;
								break;
							default:
								$lightboxPlusJavaScript .= '  $("a[rel*=lightbox]").colorbox(' . $lightboxPlusFnPrimary . ');' . PHP_EOL;
								break;
						}
						break;
				}
				switch ( $lightboxPlusOptions['lightboxplus_multi'] ) {
					case 1:
						$lbpArraySecondary = array();
						if ( $lightboxPlusSecondaryOptions['transition_sec'] != 'elastic' ) {
							$lbpArraySecondary[] = 'transition:"' . $lightboxPlusSecondaryOptions['transition_sec'] . '"';
						}
						if ( $lightboxPlusSecondaryOptions['speed_sec'] != '350' ) {
							$lbpArraySecondary[] = 'speed:' . $lightboxPlusSecondaryOptions['speed_sec'];
						}
						if ( $lightboxPlusSecondaryOptions['width_sec'] && $lightboxPlusSecondaryOptions['width_sec'] != 'false' ) {
							$lbpArraySecondary[] = 'width:' . $this->setValue( $lightboxPlusSecondaryOptions['width_sec'] );
						}
						if ( $lightboxPlusSecondaryOptions['height_sec'] && $lightboxPlusSecondaryOptions['height_sec'] != 'false' ) {
							$lbpArraySecondary[] = 'height:' . $this->setValue( $lightboxPlusSecondaryOptions['height_sec'] );
						}
						if ( $lightboxPlusSecondaryOptions['inner_width_sec'] && $lightboxPlusSecondaryOptions['inner_width_sec'] != 'false' ) {
							$lbpArraySecondary[] = 'innerWidth:' . $this->setValue( $lightboxPlusSecondaryOptions['inner_width_sec'] );
						}
						if ( $lightboxPlusSecondaryOptions['inner_height_sec'] && $lightboxPlusSecondaryOptions['inner_height_sec'] != 'false' ) {
							$lbpArraySecondary[] = 'innerHeight:' . $this->setValue( $lightboxPlusSecondaryOptions['inner_height_sec'] );
						}
						if ( $lightboxPlusSecondaryOptions['initial_width_sec'] && $lightboxPlusSecondaryOptions['initial_width_sec'] != '600' ) {
							$lbpArraySecondary[] = 'initialWidth:' . $this->setValue( $lightboxPlusSecondaryOptions['initial_width_sec'] );
						}
						if ( $lightboxPlusSecondaryOptions['initial_height_sec'] && $lightboxPlusSecondaryOptions['initial_height_sec'] != '450' ) {
							$lbpArraySecondary[] = 'initialHeight:' . $this->setValue( $lightboxPlusSecondaryOptions['initial_height_sec'] );
						}
						if ( $lightboxPlusSecondaryOptions['max_width_sec'] && $lightboxPlusSecondaryOptions['max_width_sec'] != 'false' ) {
							$lbpArraySecondary[] = 'maxWidth:' . $this->setValue( $lightboxPlusSecondaryOptions['max_width_sec'] );
						}
						if ( $lightboxPlusSecondaryOptions['max_height_sec'] && $lightboxPlusSecondaryOptions['max_height_sec'] != 'false' ) {
							$lbpArraySecondary[] = 'maxHeight:' . $this->setValue( $lightboxPlusSecondaryOptions['max_height_sec'] );
						}
						if ( $lightboxPlusSecondaryOptions['resize_sec'] != '1' ) {
							$lbpArraySecondary[] = 'scalePhotos:' . $this->setBoolean( $lightboxPlusSecondaryOptions['resize_sec'] );
						}
						if ( $lightboxPlusSecondaryOptions['rel_sec'] == 'nofollow' ) {
							$lbpArrayPrimary[] = 'rel:' . $this->setValue( $lightboxPlusSecondaryOptions['rel'] );
						}
						if ( $lightboxPlusSecondaryOptions['opacity_sec'] != '0.9' ) {
							$lbpArraySecondary[] = 'opacity:' . $lightboxPlusSecondaryOptions['opacity_sec'];
						}
						if ( $lightboxPlusSecondaryOptions['preloading_sec'] != '1' ) {
							$lbpArraySecondary[] = 'preloading:' . $this->setBoolean( $lightboxPlusSecondaryOptions['preloading_sec'] );
						}
						if ( $lightboxPlusSecondaryOptions['label_image_sec'] != 'Image' && $lightboxPlusSecondaryOptions['label_of_sec'] != 'of' ) {
							$lbpArraySecondary[] = 'current:"' . $lightboxPlusSecondaryOptions['label_image_sec'] . ' {current} ' . $lightboxPlusSecondaryOptions['label_of_sec'] . ' {total}"';
						}
						if ( $lightboxPlusSecondaryOptions['previous_sec'] != 'previous' ) {
							$lbpArraySecondary[] = 'previous:"' . $lightboxPlusSecondaryOptions['previous_sec'] . '"';
						}
						if ( $lightboxPlusSecondaryOptions['next_sec'] != 'next' ) {
							$lbpArraySecondary[] = 'next:"' . $lightboxPlusSecondaryOptions['next_sec'] . '"';
						}
						if ( $lightboxPlusSecondaryOptions['close_sec'] != 'close' ) {
							$lbpArraySecondary[] = 'close:"' . $lightboxPlusSecondaryOptions['close_sec'] . '"';
						}
						if ( $lightboxPlusSecondaryOptions['overlay_close_sec'] != '1' ) {
							$lbpArraySecondary[] = 'overlayClose:' . $this->setBoolean( $lightboxPlusSecondaryOptions['overlay_close_sec'] );
						}
						if ( $lightboxPlusSecondaryOptions['loop_sec'] != '1' ) {
							$lbpArrayPrimary[] = 'loop:' . $this->setBoolean( $lightboxPlusSecondaryOptions['loop_sec'] );
						}
						if ( $lightboxPlusSecondaryOptions['slideshow_sec'] == '1' ) {
							$lbpArraySecondary[] = 'slideshow:' . $this->setBoolean( $lightboxPlusSecondaryOptions['slideshow_sec'] );
						}
						if ( $lightboxPlusSecondaryOptions['slideshow_sec'] == '1' ) {
							if ( $lightboxPlusSecondaryOptions['slideshow_auto_sec'] != '1' ) {
								$lbpArraySecondary[] = 'slideshowAuto:' . $this->setBoolean( $lightboxPlusSecondaryOptions['slideshow_auto_sec'] );
							}
							if ( $lightboxPlusSecondaryOptions['slideshow_speed_sec'] ) {
								$lbpArraySecondary[] = 'slideshowSpeed:' . $lightboxPlusSecondaryOptions['slideshow_speed_sec'];
							}
							if ( $lightboxPlusSecondaryOptions['slideshow_start_sec'] ) {
								$lbpArraySecondary[] = 'slideshowStart:"' . $lightboxPlusSecondaryOptions['slideshow_start_sec'] . '"';
							}
							if ( $lightboxPlusSecondaryOptions['slideshow_stop_sec'] ) {
								$lbpArraySecondary[] = 'slideshowStop:"' . $lightboxPlusSecondaryOptions['slideshow_stop_sec'] . '"';
							}
						}
						if ( $lightboxPlusSecondaryOptions['iframe_sec'] != '0' ) {
							$lbpArraySecondary[] = 'iframe:' . $this->setBoolean( $lightboxPlusSecondaryOptions['iframe_sec'] );
						}
						if ( $lightboxPlusSecondaryOptions['scrolling_sec'] != '1' ) {
							$lbpArrayPrimary[] = 'scrolling:' . $this->setBoolean( $lightboxPlusSecondaryOptions['scrolling_sec'] );
						}
						if ( $lightboxPlusSecondaryOptions['esc_key_sec'] != '1' ) {
							$lbpArrayPrimary[] = 'escKey:' . $this->setBoolean( $lightboxPlusSecondaryOptions['esc_key_sec'] );
						}
						if ( $lightboxPlusSecondaryOptions['arrow_key_sec'] != '1' ) {
							$lbpArrayPrimary[] = 'arrowKey:' . $this->setBoolean( $lightboxPlusSecondaryOptions['arrow_key_sec'] );
						}
						if ( $lightboxPlusSecondaryOptions['top_sec'] != 'false' ) {
							$lbpArrayPrimary[] = 'top:' . $this->setValue( $lightboxPlusSecondaryOptions['top_sec'] );
						}
						if ( $lightboxPlusSecondaryOptions['right_sec'] != 'false' ) {
							$lbpArrayPrimary[] = 'right:' . $this->setValue( $lightboxPlusSecondaryOptions['right_sec'] );
						}
						if ( $lightboxPlusSecondaryOptions['bottom_sec'] != 'false' ) {
							$lbpArrayPrimary[] = 'bottom:' . $this->setValue( $lightboxPlusSecondaryOptions['bottom_sec'] );
						}
						if ( $lightboxPlusSecondaryOptions['left_sec'] != 'false' ) {
							$lbpArrayPrimary[] = 'left:' . $this->setValue( $lightboxPlusSecondaryOptions['left_sec'] );
						}
						if ( $lightboxPlusSecondaryOptions['fixed_sec'] == '1' ) {
							$lbpArrayPrimary[] = 'fixed:' . $this->setBoolean( $lightboxPlusSecondaryOptions['fixed_sec'] );
						}
						//$lightboxPlusFnSecondary = '{'.implode(",", $lbpArraySecondary).'}';
						switch ( $lightboxPlusOptions['output_htmlv'] ) {
							case 1:
								$htmlv_prop = 'data-' . $lightboxPlusOptions['data_name'];
								//$lightboxPlusFnSecondary = '{'.implode(",", $lbpArraySecondary).'}';
								$lightboxPlusFnSecondary = '{rel:$(this).attr("' . $htmlv_prop . '"),' . implode( ",", $lbpArraySecondary ) . '}';
								$lightboxPlusJavaScript .= '  $(".' . $lightboxPlusSecondaryOptions['class_name_sec'] . '").each(function(){' . PHP_EOL;
								$lightboxPlusJavaScript .= '    $(this).colorbox(' . $lightboxPlusFnSecondary . ');' . PHP_EOL;
								$lightboxPlusJavaScript .= '  });' . PHP_EOL;
								break;
							default:
								$lightboxPlusFnSecondary = '{' . implode( ",", $lbpArraySecondary ) . '}';
								$lightboxPlusJavaScript .= '  $(".' . $lightboxPlusSecondaryOptions['class_name_sec'] . '").colorbox(' . $lightboxPlusFnSecondary . ');' . PHP_EOL;
								break;
						}
						break;
					default:
						break;
				}

				if ( isset($lightboxPlusOptions['use_inline']) && $lightboxPlusOptions['inline_num'] != '' ) {
					$inline_links            = $lightboxPlusInlineOptions['inline_links'];
					$inline_hrefs            = $lightboxPlusInlineOptions['inline_hrefs'];
					$inline_transitions      = $lightboxPlusInlineOptions['inline_transitions'];
					$inline_speeds           = $lightboxPlusInlineOptions['inline_speeds'];
					$inline_widths           = $lightboxPlusInlineOptions['inline_widths'];
					$inline_heights          = $lightboxPlusInlineOptions['inline_heights'];
					$inline_inner_widths     = $lightboxPlusInlineOptions['inline_inner_widths'];
					$inline_inner_heights    = $lightboxPlusInlineOptions['inline_inner_heights'];
					$inline_max_widths       = $lightboxPlusInlineOptions['inline_max_widths'];
					$inline_max_heights      = $lightboxPlusInlineOptions['inline_max_heights'];
					$inline_position_tops    = $lightboxPlusInlineOptions['inline_position_tops'];
					$inline_position_rights  = $lightboxPlusInlineOptions['inline_position_rights'];
					$inline_position_bottoms = $lightboxPlusInlineOptions['inline_position_bottoms'];
					$inline_position_lefts   = $lightboxPlusInlineOptions['inline_position_lefts'];
					$inline_fixeds           = $lightboxPlusInlineOptions['inline_fixeds'];
					$inline_opens            = $lightboxPlusInlineOptions['inline_opens'];
					$inline_opacitys         = $lightboxPlusInlineOptions['inline_opacitys'];

					for ( $i = 1; $i <= $lightboxPlusOptions['inline_num']; $i ++ ) {
						//echo "Opacity: ".$inline_opacitys[$i - 1];
						$lightboxPlusJavaScript .= '  $(".' . $inline_links[ $i ] . '").colorbox({transition:' . $this->setValue( $inline_transitions[ $i ] ) . ', speed:' . $this->setValue( $inline_speeds[ $i ] ) . ', width:' . $this->setValue( $inline_widths[ $i ] ) . ', height:' . $this->setValue( $inline_heights[ $i ] ) . ', innerWidth:' . $this->setValue( $inline_inner_widths[ $i ] ) . ', innerHeight:' . $this->setValue( $inline_inner_heights[ $i ] ) . ', maxWidth:' . $this->setValue( $inline_max_widths[ $i ] ) . ', maxHeight:' . $this->setValue( $inline_max_heights[ $i ] ) . ', top:' . $this->setValue( $inline_position_tops[ $i ] ) . ', right:' . $this->setValue( $inline_position_rights[ $i ] ) . ', bottom:' . $this->setValue( $inline_position_bottoms[ $i ] ) . ', left:' . $this->setValue( $inline_position_lefts[ $i ] ) . ', fixed:' . $this->setBoolean( $inline_fixeds[ $i ] ) . ', open:' . $this->setBoolean( $inline_opens[ $i ] ) . ', opacity:' . $this->setValue( $inline_opacitys[ $i ] ) . ', inline:true, href:"#' . $inline_hrefs[ $i ] . '"});' . PHP_EOL;
					}
				}

				$lightboxPlusJavaScript .= '});' . PHP_EOL;
				$lightboxPlusJavaScript .= '</script>' . PHP_EOL;
				echo $lightboxPlusJavaScript;
			}
		}

		/**
		 * Add new admin panel to WordPress under the Appearance category
		 */
		function lightboxPlusAddPanel() {
			$plugin_page = add_theme_page( 'Lightbox Plus Colorbox', __( 'Lightbox Plus Colorbox', 'lightboxplus' ), 'manage_options', 'lightboxplus', array(
					&$this,
					'lightboxPlusAdminPanel'
				) );
			add_action( 'admin_print_scripts-' . $plugin_page, array( &$this, 'lightboxPlusAdminScripts' ) );
			add_action( 'admin_head-' . $plugin_page, array( &$this, 'lightboxPlusColorbox' ) );
			add_action( 'admin_print_styles-' . $plugin_page, array( &$this, 'lightboxPlusAdminStyles' ) );
		}

		/**
		 * Tells WordPress to load the jquery, jquery-ui-core and jquery-ui-dialog in the lightbox plus admin panel
		 */
		function lightboxPlusAdminScripts() {
			wp_enqueue_script( 'jquery', '', '', '', true );
			wp_enqueue_script( 'jquery-ui-core', '', '', '', true );
			wp_enqueue_script( 'jquery-ui-dialog', '', '', '', true );
			wp_enqueue_script( 'jquery-ui-tabs', '', '', '', true );
			wp_enqueue_script( 'jquery-colorbox', LBP_ASSETS_URL . '/js/jquery.colorbox.' . LBP_COLORBOX_VERSION . '-min.js', array( 'jquery' ), LBP_COLORBOX_VERSION, true );
			wp_enqueue_script( 'lightboxplus-admin', LBP_ASSETS_URL . '/js/lightbox.admin.js', array( 'jquery' ), LBP_VERSION, true );
		}

		/**
		 * Add CSS styles to lightbox plus admin panel page headers to display lightboxed images
		 */
		function lightboxPlusAdminStyles() {
			wp_register_style( 'lightboxplusStyles', LBP_ASSETS_URL . '/css/lightbox.admin.css', '', LBP_VERSION, 'screen' );
			wp_enqueue_style( 'lightboxplusStyles' );

			if ( ! empty( $this->lightboxOptions ) ) {
				$lightboxPlusOptions = $this->getAdminOptions( $this->lightboxOptionsName );

				if ( $lightboxPlusOptions['use_custom_style'] == 1 ) {
					$style_path_url = LBP_CUSTOM_STYLE_URL;
					$style_path_dir = LBP_CUSTOM_STYLE_PATH;
				} else {
					$style_path_url = LBP_STYLE_URL;
					$style_path_dir = LBP_STYLE_PATH;
				}

				if ( $lightboxPlusOptions['disable_css'] ) {
					echo "<!-- User set lightbox styles -->" . PHP_EOL;
				} else {
					wp_register_style( 'lightboxStyle', $style_path_url . '/' . $lightboxPlusOptions['lightboxplus_style'] . '/colorbox.css', '', LBP_VERSION, 'screen' );
					wp_register_style( 'lightboxStylebase', $style_path_url . '/colorbox-base.css', '', LBP_VERSION, 'screen' );
					wp_enqueue_style( 'lightboxStyle','lightboxStylebase' );
					if ( file_exists( $style_path_dir . '/' . $lightboxPlusOptions['lightboxplus_style'] . '/helper.js' ) ) {
						wp_enqueue_script( 'lbp-helper', $style_path_url . '/' . $lightboxPlusOptions['lightboxplus_style'] . '/helper.js', '', LBP_VERSION, true );
					}
				}
			}
		}

		/**
		 * Add metabox to edit post/page for per page application of lightbox plus
		 */
		function saveLightboxPlusMeta() {
			add_action( 'save_post', array( $this, 'lightboxPlusSaveMeta' ), 10, 1 );
		}

		function lightboxPlusMetaBox() {
			add_meta_box( 'lbp-meta-box', __( 'Lightbox Plus Colorbox Per Page', 'lightboxplus' ), array(
					&$this,
					'drawLightboxPlusMeta'
				), 'page', 'side', 'high' );
		}

		function drawLightboxPlusMeta( $post ) {
			wp_nonce_field( 'lbp_meta_nonce', 'nonce_lbp' );
			$lbp_use      = get_post_meta( $post->ID, '_lbp_use', true );
			$lbp_uid      = get_post_meta( $post->ID, '_lbp_uid', true );
			$lbp_autoload = get_post_meta( $post->ID, '_lbp_autoload', true );
			?>
			<table class="form-table">
				<tr>
					<th scope="row"><?php _e( 'Use with this page/post:', 'lightboxplus' ); ?>:</th>
					<td>
						<input type="hidden" name="lbp_use" value="0">
						<input type="checkbox" name="lbp_use" id="lbp_use" value="1" <?php if ( isset( $lbp_use ) ) {
							checked( '1', $lbp_use );
						} ?> />
					</td>
				</tr>
				<tr>
					<th scope="row"><?php _e( 'Auto launch on this page/post:', 'lightboxplus' ); ?>:</th>
					<td>
						<input type="hidden" name="lbp_autoload" value="0">
						<input type="checkbox" name="lbp_autoload" id="lbp_autoload" value="1"<?php if ( isset( $lbp_autoload ) ) {
							checked( '1', $lbp_autoload );
						} ?> />
					</td>
				</tr>
				<tr>
					<th scope="row" colspan="2"><?php _e( 'Lightbox Plus Colorbox unique ID for this page:', 'lightboxplus' ); ?>:</th>
				</tr>
				<tr>
					<td colspan="2">
						<input type="text" id="lbp_uid" name="lbp_uid" size="40" value="<?php if ( ! empty( $lbp_uid ) ) {
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

		function lightboxPlusSaveMeta( $post_id ) {
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
?>