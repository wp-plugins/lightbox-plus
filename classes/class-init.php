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

		function lbp_base_init();

		function lbp_primary_init();

		function lbp_secondary_init();

		function lbp_inline_init( $inline_number = 5 );

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
			global $g_lbp_base_options;
			global $g_lbp_primary_options;
			global $g_lbp_secondary_options;
			global $g_lbp_inline_options;


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

				update_option( 'lightboxplus_init', false );
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
				"top_sec"              => '0',
				"right_sec"            => '0',
				"bottom_sec"           => '0',
				"left_sec"             => '0',
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
			$inline_opacitys         = '';

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
	}
}