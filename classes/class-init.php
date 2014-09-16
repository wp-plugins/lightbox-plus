<?php
/**
 * @package    Lightbox Plus Colorbox
 * @subpackage class-init.php
 * @internal   2013.01.16
 * @author     Dan Zappone / 23Systems
 * @version    2.7
 * @$Id: class-init.php 983793 2014-09-07 19:22:57Z dzappone $
 * @$URL: http://plugins.svn.wordpress.org/lightbox-plus/trunk/classes/class-init.php $
 */

if ( ! interface_exists( 'LBP_Init_Interface' ) ) {
	interface LBP_Init_Interface {
		function lbp_install();

		function lbp_reinstall();

		function lbp_convert( $old_array );

		function lbp_base_init();

		function lbp_primary_init();

		function lbp_secondary_init();

		function lbp_inline_init( $inline_number );

		function lbp_deactivate();

		function lbp_uninstall();

		function lbp_global_styles_init();


	}
}

if ( ! class_exists( 'LBP_Init' ) ) {
	class LBP_Init extends LBP_Actions implements LBP_Init_Interface {
		/**
		 * Add some default options if they don't exist or if reinitialized
		 *
		 * @return bool
		 */
		function lbp_install() {
			/**
			 * Call Initialize Primary Lightbox
			 * Call Initialize Secondary Lightbox if enabled
			 * Call Initialize Inline Lightboxes if enabled
			 *
			 */
			update_option( 'lightboxplus_options_base', $this->lbp_base_init() );
			update_option( 'lightboxplus_options_primary', $this->lbp_primary_init() );
			update_option( 'lightboxplus_options_secondary', $this->lbp_secondary_init() );
			update_option( 'lightboxplus_options_inline', $this->lbp_inline_init() );

			/**
			 * Saved options and then get them out of the db to see if they are actually there
			 */
			$ar_saved_options = get_option( 'lightboxplus_options_base' );

			/**
			 * If Lightbox Plus Colorbox has been initialized - set to true anbd set version
			 */
			if ( isset( $ar_saved_options ) ) {
				update_option( 'lightboxplus_init', 1 );
				update_option( 'lightboxplus_init_secondary', 0 );
				update_option( 'lightboxplus_init_inline', 0 );
				update_option( 'lightboxplus_version', LBP_VERSION );
			}

			$b_init = get_option( ' lightboxplus_init' );

			if ( isset( $b_init ) && true == $b_init ) {
				return true;
			} else {
				return false;
			}
		}

		/*
		 * @return bool
		 */
		function lbp_reinstall() {
			global $g_lbp_base_options;
			global $g_lbp_primary_options;
			global $g_lbp_secondary_options;
			global $g_lbp_inline_options;

			delete_option( 'lightboxplus_options' );
			delete_option( 'lightboxplus_options_base' );
			delete_option( 'lightboxplus_options_primary' );
			delete_option( 'lightboxplus_options_secondary' );
			delete_option( 'lightboxplus_options_inline' );
			delete_option( 'lightboxplus_init' );
			delete_option( 'lightboxplus_init_secondary' );
			delete_option( 'lightboxplus_init_inline' );
			delete_option( 'lightboxplus_version' );
			/**
			 * Call Initialize Primary Lightbox
			 * Call Initialize Secondary Lightbox if enabled
			 * Call Initialize Inline Lightboxes if enabled
			 *
			 * @var LBP_Lightboxplus
			 */
			if ( isset( $_POST['reinit_lightboxplus'] ) ) {
				$g_lbp_base_options      = $this->lbp_base_init();
				$g_lbp_primary_options   = $this->lbp_primary_init();
				$g_lbp_secondary_options = $this->lbp_secondary_init();
				$g_lbp_inline_options    = $this->lbp_inline_init();

				update_option( 'lightboxplus_init', 0 );
				/**
				 * Saved options and then get them out of the db to see if they are actually there
				 */
				update_option( 'lightboxplus_options_base', $this->lbp_base_init() );
				update_option( 'lightboxplus_options_primary', $this->lbp_primary_init() );
				update_option( 'lightboxplus_options_secondary', $this->lbp_secondary_init() );
				update_option( 'lightboxplus_options_inline', $this->lbp_inline_init() );

				$ar_saved_options = get_option( 'lightboxplus_options_base' );

				/**
				 * If Lightbox Plus Colorbox has been re-initialized - set to true and set version
				 */
				if ( isset( $ar_saved_options ) ) {
					update_option( 'lightboxplus_init', true );
					update_option( 'lightboxplus_init_secondary', false );
					update_option( 'lightboxplus_init_inline', false );
					update_option( 'lightboxplus_version', LBP_VERSION );
				} else {
					$ar_saved_options = $g_lbp_base_options;
				}

				/**
				 * If Lightbox Plus Colorbox has been re-initialized - set to true
				 */
				if ( isset( $ar_saved_options ) ) {
					update_option( 'lightboxplus_init', 1 );
					update_option( 'lightboxplus_init_secondary', 0 );
					update_option( 'lightboxplus_init_inline', 0 );
					update_option( 'lightboxplus_version', LBP_VERSION );
				}

				$b_init = get_option( ' lightboxplus_init' );

				if ( isset( $b_init ) && true == $b_init ) {
					return true;
				} else {
					return false;
				}
			}
		}

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
				if ( 1 == $ar_saved_options['lightbox_multi'] ) {
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
		 * Initiailize Lightbox Plus base settings
		 *
		 * @return array
		 */
		function lbp_base_init() {
			return array(
				"lightboxplus_multi" => '0',
				"use_inline"         => '0',
				"inline_num"         => '1',
				"lightboxplus_style" => 'fancypants',
				"use_custom_style"   => '0',
				"disable_css"        => '0',
				"hide_about"         => '0',
				"output_htmlv"       => '0',
				"data_name"          => 'lightboxplus',
				"use_perpage"        => '0',
				"use_forpage"        => '0',
				"use_forpost"        => '0',
				"load_location"      => 'wp_footer',
				"load_priority"      => '10'
			);
		}

		/**
		 * Initialize Primary Lightbox by buiding array of options and committing to database
		 *
		 * @return array
		 */
		function lbp_primary_init() {
			return array(
				"transition"           => 'elastic',
				"speed"                => '300',
				"width"                => 'false',
				"height"               => 'false',
				"inner_width"          => 'false',
				"inner_height"         => 'false',
				"initial_width"        => '30%',
				"initial_height"       => '30%',
				"max_width"            => '90%',
				"max_height"           => '90%',
				"resize"               => '1',
				"opacity"              => '0.8',
				"preloading"           => '1',
				"label_image"          => 'Image',
				"label_of"             => 'of',
				"previous"             => 'previous',
				"next"                 => 'next',
				"close"                => 'close',
				"overlay_close"        => '1',
				"slideshow"            => '0',
				"slideshow_auto"       => '0',
				"slideshow_speed"      => '2500',
				"slideshow_start"      => 'start',
				"slideshow_stop"       => 'stop',
				"use_caption_title"    => '0',
				"gallery_lightboxplus" => '0',
				"multiple_galleries"   => '0',
				"use_class_method"     => '0',
				"class_name"           => 'lbp_primary',
				"no_auto_lightbox"     => '0',
				"text_links"           => '1',
				"no_display_title"     => '0',
				"scrolling"            => '1',
				"photo"                => '0',
				"rel"                  => 'false', //Disable grouping
				"loop"                 => '1',
				"esc_key"              => '1',
				"arrow_key"            => '1',
				"top"                  => 'false',
				"right"                => 'false',
				"bottom"               => 'false',
				"left"                 => 'false',
				"fixed"                => '0'
			);
		}

		/**
		 * Initialize Secondary Lightbox by buiding array of options and returning
		 *
		 * @return array
		 */
		function lbp_secondary_init() {
			return array(
				"transition_sec"       => 'elastic',
				"speed_sec"            => '300',
				"width_sec"            => 'false',
				"height_sec"           => 'false',
				"inner_width_sec"      => '50%',
				"inner_height_sec"     => '50%',
				"initial_width_sec"    => '30%',
				"initial_height_sec"   => '40%',
				"max_width_sec"        => '90%',
				"max_height_sec"       => '90%',
				"resize_sec"           => '1',
				"opacity_sec"          => '0.8',
				"preloading_sec"       => '1',
				"label_image_sec"      => 'Image',
				"label_of_sec"         => 'of',
				"previous_sec"         => 'previous',
				"next_sec"             => 'next',
				"close_sec"            => 'close',
				"overlay_close_sec"    => '1',
				"slideshow_sec"        => '0',
				"slideshow_auto_sec"   => '1',
				"slideshow_speed_sec"  => '2500',
				"slideshow_start_sec"  => 'start',
				"slideshow_stop_sec"   => 'stop',
				"iframe_sec"           => '1',
				//"use_class_method_sec" => '0',
				"class_name_sec"       => 'lbp_secondary',
				"no_display_title_sec" => '0',
				"scrolling_sec"        => '1',
				"photo_sec"            => '0',
				"rel_sec"              => '0', //Disable grouping
				"loop_sec"             => '1',
				"esc_key_sec"          => '1',
				"arrow_key_sec"        => '1',
				"top_sec"              => 'false',
				"right_sec"            => 'false',
				"bottom_sec"           => 'false',
				"left_sec"             => 'false',
				"fixed_sec"            => '0'
			);
		}

		/**
		 * Initialize Inline Lightbox by buiding array of options and committing to database
		 *
		 * @param int $inline_number
		 *
		 * @return array
		 */
		function lbp_inline_init( $inline_number = 5 ) {
//			$inline_links            = '';
//			$inline_hrefs            = '';
//			$inline_transitions      = '';
//			$inline_speeds           = '';
//			$inline_widths           = '';
//			$inline_heights          = '';
//			$inline_inner_widths     = '';
//			$inline_inner_heights    = '';
//			$inline_max_widths       = '';
//			$inline_max_heights      = '';
//			$inline_position_tops    = '';
//			$inline_position_rights  = '';
//			$inline_position_bottoms = '';
//			$inline_position_lefts   = '';
//			$inline_fixeds           = '';
//			$inline_opens            = '';
//			$inline_opacitys         = '';

			if ( ! empty( $inline_number ) ) {
				for ( $i = 1; $i <= $inline_number; $i ++ ) {
					$inline_links[ $i ]            = 'lbp-inline-link-' . $i;
					$inline_hrefs[ $i ]            = 'lbp-inline-href-' . $i;
					$inline_transitions[ $i ]      = 'elastic';
					$inline_speeds[ $i ]           = '300';
					$inline_widths[ $i ]           = '80%';
					$inline_heights[ $i ]          = '80%';
					$inline_inner_widths[ $i ]     = 'false';
					$inline_inner_heights[ $i ]    = 'false';
					$inline_max_widths[ $i ]       = '80%';
					$inline_max_heights[ $i ]      = '80%';
					$inline_position_tops[ $i ]    = 'false';
					$inline_position_rights[ $i ]  = 'false';
					$inline_position_bottoms[ $i ] = 'false';
					$inline_position_lefts[ $i ]   = 'false';
					$inline_fixeds[ $i ]           = '0';
					$inline_opens[ $i ]            = '0';
					$inline_opacitys[ $i ]         = '0.8';
				}
			}

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
				"inline_opacitys"         => $inline_opacitys
			);
		}

		function lbp_deactivate() {
			/**
			 * TODO: Change/remove before release
			 */
			delete_option( 'lightboxplus_options_base' );
			delete_option( 'lightboxplus_options_primary' );
			delete_option( 'lightboxplus_options_secondary' );
			delete_option( 'lightboxplus_options_inline' );
			delete_option( 'lightboxplus_init' );
			delete_option( 'lightboxplus_init_secondary' );
			delete_option( 'lightboxplus_init_inline' );
			delete_option( 'lightboxplus_version' );

			return false;
		}


		function lbp_uninstall() {
			delete_option( 'lightboxplus_options_base' );
			delete_option( 'lightboxplus_options_primary' );
			delete_option( 'lightboxplus_options_secondary' );
			delete_option( 'lightboxplus_options_inline' );
			delete_option( 'lightboxplus_init' );
			delete_option( 'lightboxplus_init_secondary' );
			delete_option( 'lightboxplus_init_inline' );
			delete_option( 'lightboxplus_version' );

			return false;
		}

		/**
		 * Initialize the external style directory
		 *
		 * @return boolean
		 */
		function lbp_global_styles_init() {
			$directory_create = mkdir( LBP_CUSTOM_STYLE_PATH, 0755 );
			if ( $directory_create ) {
				$this->copy_directory( LBP_STYLE_PATH, LBP_CUSTOM_STYLE_PATH . '/' );

				return true;
			} else {
				return false;
			}
		}

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
				"use_perpage"        => $array['use_perpage'],
				"use_forpage"        => $array['use_forpage'],
				"use_forpost"        => $array['use_forpost'],
				"load_location"      => $array['load_location'],
				"load_priority"      => $array['load_priority']
			);
		}

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
				//"use_class_method_sec" => $array['use_class_method_sec'],
				"class_name_sec"       => $array['class_name_sec'],
				"no_display_title_sec" => $array['no_display_title_sec'],
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

		function lbp_inline_convert( $array ) {
			if ( ! empty( $array['inline_number'] ) ) {
				for ( $i = 1; $i <= $array['inline_number']; $i ++ ) {
					$inline_links[ $i ]            = $array['inline_links'][ $i - 1 ];
					$inline_hrefs[ $i ]            = $array['inline_hrefs'][ $i - 1 ];
					$inline_transitions[ $i ]      = $array['inline_transitions'][ $i - 1 ];
					$inline_speeds[ $i ]           = $array['inline_speeds'][ $i - 1 ];
					$inline_widths[ $i ]           = $array['inline_widths'][ $i - 1 ];
					$inline_heights[ $i ]          = $array['inline_heights'][ $i - 1 ];
					$inline_inner_widths[ $i ]     = $array['inline_inner_widths'][ $i - 1 ];
					$inline_inner_heights[ $i ]    = $array['inline_inner_heights'][ $i - 1 ];
					$inline_max_widths[ $i ]       = $array['inline_max_widths'][ $i - 1 ];
					$inline_max_heights[ $i ]      = $array['inline_max_heights'][ $i - 1 ];
					$inline_position_tops[ $i ]    = $array['inline_position_tops'][ $i - 1 ];
					$inline_position_rights[ $i ]  = $array['inline_position_rights'][ $i - 1 ];
					$inline_position_bottoms[ $i ] = $array['inline_position_bottoms'][ $i - 1 ];
					$inline_position_lefts[ $i ]   = $array['inline_position_lefts'][ $i - 1 ];
					$inline_fixeds[ $i ]           = $array['inline_fixeds'][ $i - 1 ];
					$inline_opens[ $i ]            = $array['inline_opens'][ $i - 1 ];
					$inline_opacitys[ $i ]         = $array['inline_opacitys'][ $i - 1 ];
				}
			}

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
				"inline_opacitys"         => $inline_opacitys
			);
		}

		/**
		 * End Class
		 */
	}
	/**
	 * End Class Exists Check
	 */
}