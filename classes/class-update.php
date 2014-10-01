<?php
/**
 * @package    Lightbox Plus Colorbox
 * @subpackage class-update.php
 * @internal   2013.01.16
 * @author     Dan Zappone / 23Systems
 * @version    2.7
 * @$Id: class-update.php 983793 2014-09-07 19:22:57Z dzappone $
 * @$URL: http://plugins.svn.wordpress.org/lightbox-plus/trunk/classes/class-update.php $
 */

if ( ! interface_exists( 'LBP_Update_Interface' ) ) {
	/**
	 * Interface LBP_Update_Interface
	 */
	interface LBP_Update_Interface {
		/**
		 * @param $old_array
		 *
		 * @return mixed
		 */
		function lbp_convert( $old_array );

		/**
		 * @param $array
		 *
		 * @return mixed
		 */
		function lbp_base_convert( $array );

		/**
		 * @param $array
		 *
		 * @return mixed
		 */
		function lbp_secondary_convert( $array );

		/**
		 * @param $array
		 *
		 * @return mixed
		 */
		function lbp_inline_convert( $array );

		/**
		 * @param $value
		 * @param $num
		 *
		 * @return mixed
		 */
		function fix_array_links_values( $value, $num );

		/**
		 * @param $value
		 * @param $num
		 *
		 * @return mixed
		 */
		function fix_array_href_values( $value, $num );

		/**
		 * @param $value
		 *
		 * @return mixed
		 */
		function fix_array_transition_values( $value );

		/**
		 * @param $value
		 *
		 * @return mixed
		 */
		function fix_array_speed_values( $value );

		/**
		 * @param $value
		 *
		 * @return mixed
		 */
		function fix_array_text_values( $value );

		/**
		 * @param $value
		 *
		 * @return mixed
		 */
		function fix_array_checkbox_values( $value );

		/**
		 * @param $value
		 *
		 * @return mixed
		 */
		function fix_array_opacity_values( $value );

	}
}

if ( ! interface_exists( 'LBP_Update' ) ) {
	/**
	 * Class LBP_Update
	 */
	class LBP_Update implements LBP_Update_Interface {

		/**
		 * @param $old_array
		 *
		 * @return bool
		 */
		function lbp_convert( $old_array ) {
			delete_option( 'lightboxplus_init' );
			/**
			 * Call Convert Primary Lightbox
			 * Call Convert Secondary Lightbox if enabled
			 * Call Convert Inline Lightboxes if enabled
			 */
			update_option( 'lightboxplus_options_base', $this->lbp_base_convert( $old_array ) );
			update_option( 'lightboxplus_options_primary', $this->lbp_primary_convert( $old_array ) );
			update_option( 'lightboxplus_options_secondary', $this->lbp_secondary_convert( $old_array ) );
			update_option( 'lightboxplus_options_inline', $this->lbp_inline_convert( $old_array ) );

			delete_option( 'lightboxplus_options' );

			/**
			 * Saved options and then get them out of the db to see if they are actually there
			 */
			$ar_saved_options = get_option( 'lightboxplus_options_base' );

			/**
			 * If Lightbox Plus Colorbox has been initialized - set to true anbd set version
			 */
			if ( isset( $ar_saved_options ) ) {
				update_option( 'lightboxplus_init', 1 );
				if ( 1 == $ar_saved_options['lightboxplus_multi'] ) {
					update_option( 'lightboxplus_init_secondary', 1 );
				} else {
					update_option( 'lightboxplus_init_secondary', 0 );
				}
				if ( 1 == $ar_saved_options['use_inline'] ) {
					update_option( 'lightboxplus_init_inline', 1 );
				} else {
					update_option( 'lightboxplus_init_inline', 0 );
				}
				update_option( 'lightboxplus_version', LBP_VERSION );
			}

			$b_init = get_option( ' lightboxplus_init' );

			if ( isset( $b_init ) && true == $b_init ) {
				return true;
			} else {
				return false;
			}
		}

		/**
		 * @param $array
		 *
		 * @return array
		 */
		function lbp_base_convert( $array ) {
			return array(
				"lightboxplus_multi" => $array['lightboxplus_multi'],
				"use_inline"         => $array['use_inline'],
				"inline_num"         => $array['inline_num'],
				"lightboxplus_style" => $array['lightboxplus_style'],
				"use_custom_style"   => $array['use_custom_style'],
				"disable_css"        => $array['disable_css'],
				"hide_about"         => $array['hide_about'],
				"output_htmlv"       => $array['output_htmlv'],
				"data_name"          => $array['data_name'],
				"disable_mobile"     => '0',
				"use_perpage"        => $array['use_perpage'],
				"use_forpage"        => $array['use_forpage'],
				"use_forpost"        => $array['use_forpost'],
				"load_location"      => $array['load_location'],
				"load_priority"      => $array['load_priority']
			);
		}

		/**
		 * @param $array
		 *
		 * @return array
		 */
		function lbp_primary_convert( $array ) {
			return array(
				"transition"           => $array['transition'],
				"speed"                => $array['speed'],
				"width"                => $array['width'],
				"height"               => $array['height'],
				"inner_width"          => $array['inner_width'],
				"inner_height"         => $array['inner_height'],
				"initial_width"        => $array['initial_width'],
				"initial_height"       => $array['initial_height'],
				"max_width"            => $array['max_width'],
				"max_height"           => $array['max_height'],
				"resize"               => $array['resize'],
				"opacity"              => $array['opacity'],
				"preloading"           => $array['preloading'],
				"label_image"          => $array['label_image'],
				"label_of"             => $array['label_of'],
				"previous"             => $array['previous'],
				"next"                 => $array['next'],
				"close"                => $array['close'],
				"overlay_close"        => $array['overlay_close'],
				"slideshow"            => $array['slideshow'],
				"slideshow_auto"       => $array['slideshow_auto'],
				"slideshow_speed"      => $array['slideshow_speed'],
				"slideshow_start"      => $array['slideshow_start'],
				"slideshow_stop"       => $array['slideshow_stop'],
				"use_caption_title"    => $array['use_caption_title'],
				"gallery_lightboxplus" => $array['gallery_lightboxplus'],
				"multiple_galleries"   => $array['multiple_galleries'],
				"use_class_method"     => $array['use_class_method'],
				"class_name"           => $array['class_name'],
				"no_auto_lightbox"     => $array['no_auto_lightbox'],
				"text_links"           => $array['text_links'],
				"no_display_title"     => $array['no_display_title'],
				"retina_image"         => '0',
				"retina_url"           => '0',
				"retina_suffix"        => '.$1',
				"scrolling"            => $array['scrolling'],
				"photo"                => $array['photo'],
				"rel"                  => $array['rel'],
				"loop"                 => $array['loop'],
				"esc_key"              => $array['esc_key'],
				"arrow_key"            => $array['arrow_key'],
				"top"                  => $array['top'],
				"right"                => $array['right'],
				"bottom"               => $array['bottom'],
				"left"                 => $array['left'],
				"fixed"                => $array['fixed']
			);
		}

		/**
		 * @param $array
		 *
		 * @return array
		 */
		function lbp_secondary_convert( $array ) {
			return array(
				"transition_sec"       => $array['transition_sec'],
				"speed_sec"            => $array['speed_sec'],
				"width_sec"            => $array['width_sec'],
				"height_sec"           => $array['height_sec'],
				"inner_width_sec"      => $array['inner_width_sec'],
				"inner_height_sec"     => $array['inner_height_sec'],
				"initial_width_sec"    => $array['initial_width_sec'],
				"initial_height_sec"   => $array['initial_height_sec'],
				"max_width_sec"        => $array['max_width_sec'],
				"max_height_sec"       => $array['max_height_sec'],
				"resize_sec"           => $array['resize_sec'],
				"opacity_sec"          => $array['opacity_sec'],
				"preloading_sec"       => $array['preloading_sec'],
				"label_image_sec"      => $array['label_image_sec'],
				"label_of_sec"         => $array['label_of_sec'],
				"previous_sec"         => $array['previous_sec'],
				"next_sec"             => $array['next_sec'],
				"close_sec"            => $array['close_sec'],
				"overlay_close_sec"    => $array['overlay_close_sec'],
				"slideshow_sec"        => $array['slideshow_sec'],
				"slideshow_auto_sec"   => $array['slideshow_auto_sec'],
				"slideshow_speed_sec"  => $array['slideshow_speed_sec'],
				"slideshow_start_sec"  => $array['slideshow_start_sec'],
				"slideshow_stop_sec"   => $array['slideshow_stop_sec'],
				"iframe_sec"           => $array['iframe_sec'],
				"class_name_sec"       => $array['class_name_sec'],
				"no_display_title_sec" => $array['no_display_title_sec'],
				"retina_image_sec"     => '0',
				"retina_url_sec"       => '0',
				"retina_suffix_sec"    => '.$1',
				"scrolling_sec"        => $array['scrolling_sec'],
				"photo_sec"            => $array['photo_sec'],
				"rel_sec"              => $array['rel_sec'], //Disable grouping
				"loop_sec"             => $array['loop_sec'],
				"esc_key_sec"          => $array['esc_key_sec'],
				"arrow_key_sec"        => $array['arrow_key_sec'],
				"top_sec"              => $array['top_sec'],
				"right_sec"            => $array['right_sec'],
				"bottom_sec"           => $array['bottom_sec'],
				"left_sec"             => $array['left_sec'],
				"fixed_sec"            => $array['fixed_sec']
			);
		}

		/**
		 * @param $array
		 *
		 * @return array|mixed
		 */
		function lbp_inline_convert( $array ) {
			$inline_links            = '';
			$inline_hrefs            = '';
			$inline_transitions      = '';
			$inline_speeds           = '';
			$inline_widths           = '';
			$inline_heights          = '';
			$inline_inner_widths     = '';
			$inline_inner_heights    = '';
			$inline_max_widths       = '';
			$inline_max_heights      = '';
			$inline_position_tops    = '';
			$inline_position_rights  = '';
			$inline_position_bottoms = '';
			$inline_position_lefts   = '';
			$inline_fixeds           = '';
			$inline_opens            = '';
			$inline_reuses           = '';
			$inline_opacitys         = '';

			if ( isset( $array['inline_num'] ) ) {
				for ( $i = 1; $i <= $array['inline_num']; $i ++ ) {
					$inline_links[ $i ]            = $this->fix_array_links_values( $array['inline_links'][ $i - 1 ], $i );
					$inline_hrefs[ $i ]            = $this->fix_array_href_values( $array['inline_hrefs'][ $i - 1 ], $i );
					$inline_transitions[ $i ]      = $this->fix_array_transition_values( $array['inline_transitions'][ $i - 1 ] );
					$inline_speeds[ $i ]           = $this->fix_array_speed_values( $array['inline_speeds'][ $i - 1 ] );
					$inline_widths[ $i ]           = $this->fix_array_text_values( $array['inline_widths'][ $i - 1 ] );
					$inline_heights[ $i ]          = $this->fix_array_text_values( $array['inline_heights'][ $i - 1 ] );
					$inline_inner_widths[ $i ]     = $this->fix_array_text_values( $array['inline_inner_widths'][ $i - 1 ] );
					$inline_inner_heights[ $i ]    = $this->fix_array_text_values( $array['inline_inner_heights'][ $i - 1 ] );
					$inline_max_widths[ $i ]       = $this->fix_array_text_values( $array['inline_max_widths'][ $i - 1 ] );
					$inline_max_heights[ $i ]      = $this->fix_array_text_values( $array['inline_max_heights'][ $i - 1 ] );
					$inline_position_tops[ $i ]    = $this->fix_array_text_values( $array['inline_position_tops'][ $i - 1 ] );
					$inline_position_rights[ $i ]  = $this->fix_array_text_values( $array['inline_position_rights'][ $i - 1 ] );
					$inline_position_bottoms[ $i ] = $this->fix_array_text_values( $array['inline_position_bottoms'][ $i - 1 ] );
					$inline_position_lefts[ $i ]   = $this->fix_array_text_values( $array['inline_position_lefts'][ $i - 1 ] );
					$inline_fixeds[ $i ]           = $this->fix_array_checkbox_values( $array['inline_fixeds'][ $i - 1 ] );
					$inline_opens[ $i ]            = $this->fix_array_checkbox_values( $array['inline_opens'][ $i - 1 ] );
					$inline_reuses[ $i ]           = "0";
					$inline_opacitys[ $i ]         = $this->fix_array_opacity_values( $array['inline_opacitys'][ $i - 1 ] );
					if ( 50 == $i ) {
						break;
					}
				}
			}

			/**
			 *
			 */
			return array(
				"inline_links"            => $inline_links,
				"inline_hrefs"            => $inline_hrefs,
				"inline_transitions"      => $inline_transitions,
				"inline_speeds"           => $inline_speeds,
				"inline_widths"           => $inline_widths,
				"inline_heights"          => $inline_heights,
				"inline_inner_widths"     => $inline_inner_widths,
				"inline_inner_heights"    => $inline_inner_heights,
				"inline_max_widths"       => $inline_max_widths,
				"inline_max_heights"      => $inline_max_heights,
				"inline_position_tops"    => $inline_position_tops,
				"inline_position_rights"  => $inline_position_rights,
				"inline_position_bottoms" => $inline_position_bottoms,
				"inline_position_lefts"   => $inline_position_lefts,
				"inline_fixeds"           => $inline_fixeds,
				"inline_opens"            => $inline_opens,
				"inline_reuses"           => $inline_reuses,
				"inline_opacitys"         => $inline_opacitys
			);
		}

		/**
		 * @param $value
		 * @param $num
		 *
		 * @return string
		 */
		function fix_array_links_values( $value, $num ) {
			if ( empty( $value ) || null == $value ) {
				return 'false';
			} else {
				return $value;
			}
		}

		/**
		 * @param $value
		 * @param $num
		 *
		 * @return string
		 */
		function fix_array_href_values( $value, $num ) {
			if ( empty( $value ) || null == $value ) {
				return 'false';
			} else {
				return $value;
			}
		}

		/**
		 * @param $value
		 *
		 * @return string
		 */
		function fix_array_transition_values( $value ) {
			if ( empty( $value ) || null == $value ) {
				return 'elastic';
			} else {
				return $value;
			}
		}

		/**
		 * @param $value
		 *
		 * @return string
		 */
		function fix_array_speed_values( $value ) {
			if ( empty( $value ) || null == $value ) {
				return '300';
			} else {
				return $value;
			}
		}

		/**
		 * @param $value
		 *
		 * @return string
		 */
		function fix_array_text_values( $value ) {
			if ( empty( $value ) || null == $value ) {
				return 'false';
			} else {
				return $value;
			}
		}

		/**
		 * @param $value
		 *
		 * @return string
		 */
		function fix_array_checkbox_values( $value ) {
			if ( empty( $value ) || null == $value ) {
				return '0';
			} else {
				return $value;
			}
		}

		/**
		 * @param $value
		 *
		 * @return string
		 */
		function fix_array_opacity_values( $value ) {
			if ( empty( $value ) || null == $value ) {
				return '0.8';
			} else {
				return $value;
			}
		}

	}
}
