<?php
/*
Plugin Name: Lightbox Plus Colorbox
Plugin URI: http://www.23systems.net/plugins/lightbox-plus/
Description: Lightbox Plus Colorbox implements Colorbox as a lightbox image overlay tool for WordPress.  <a href="http://www.jacklmoore.com/colorbox">Colorbox</a> was created by Jack Moore of Color Powered and is licensed under the <a href="http://www.opensource.org/licenses/mit-license.php">MIT License</a>.
Author: Dan Zappone
Author URI: http://www.23systems.net/
Version: 2.7
*/

/**
 * @package    Lightbox Plus Colorbox
 * @subpackage lightboxplus.php DEV VERSION
 * @internal   2013.01.16
 * @author     Dan Zappone / 23Systems
 * @version    2.7
 * @$Id$
 * @$URL$
 */
/**
 * WordPress Globals
 *
 * @var mixed
 */
global $post;
global $content;
global $page;
global $wp_query;
global $wp_version;
global $the_post_id;
/**
 * Lightbox Plus Colorbox Globals
 *
 * @var mixed
 */
global $g_lbp_messages;
global $g_lbp_message_title;
global $g_lbp_plugin_page;

global $g_lbp_old_options;
global $g_lbp_base_options;
global $g_lbp_primary_options;
global $g_lbp_secondary_options;
global $g_lbp_inline_options;

/**
 * Instantiate Lightbox Plus Colorbox Global Variables
 * Hungarian Notation Where possible
 *
 * @var mixed
 */
$g_lbp_plugin_page   = '';
$g_lbp_messages      = '';
$g_lbp_message_title = '';

DEFINE( 'LBP_ADMIN_PAGE', 'themes.php?page=lightboxplus' );

DEFINE( 'LBP_VERSION', '2.8' );
DEFINE( 'LBP_PREV_VERSION', '2.7' );
DEFINE( 'LBP_SHD_VERSION', '1.5 rev 202' );
DEFINE( 'LBP_COLORBOX_VERSION', '1.5.14' );
DEFINE( 'LBP_SHORTCODE_VERSION', '3.9+' );

DEFINE( 'LBP_PATH', plugin_dir_path( __FILE__ ) );
DEFINE( 'LBP_URL', plugin_dir_url( __FILE__ ) );
DEFINE( 'LBP_ASSETS_PATH', LBP_PATH . 'assets' );
DEFINE( 'LBP_ASSETS_URL', LBP_URL . 'assets' );
DEFINE( 'LBP_CLASS_PATH', LBP_PATH . 'classes' );
DEFINE( 'LBP_CLASS_URL', LBP_URL . 'classes' );
DEFINE( 'LBP_STYLE_PATH', LBP_ASSETS_PATH . '/lbp-css' );
DEFINE( 'LBP_STYLE_URL', LBP_ASSETS_URL . '/lbp-css' );
DEFINE( 'LBP_CUSTOM_STYLE_URL', content_url() . '/lbp-css' );
DEFINE( 'LBP_CUSTOM_STYLE_PATH', ABSPATH . 'wp-content' . '/lbp-css' );

/**
 * Require extended Lightbox Plus Colorbox classes
 */
require_once( LBP_CLASS_PATH . '/class-utility.php' );
require_once( LBP_CLASS_PATH . '/class-shortcode.php' );
require_once( LBP_CLASS_PATH . '/class-filters.php' );
require_once( LBP_CLASS_PATH . '/class-actions.php' );
require_once( LBP_CLASS_PATH . '/class-init.php' );
/**
 * Require PHP HTML Parser - This thing is slow should be replaced
 */
require_once( LBP_CLASS_PATH . '/class-shd.php' );


/**
 * Register activation/deactivation hooks and text domain
 */
register_activation_hook( __FILE__, 'activate_lbp' );
register_deactivation_hook( __FILE__, 'deactivate_lbp' );
register_uninstall_hook( __FILE__, 'uninstall_lbp' );

/**
 * On Plugin Activation initialize settings
 */
if ( ! function_exists( 'activate_lbp' ) ) {
	function activate_lbp() {
		$g_lbp_old_version = get_option( 'lightboxplus_version' );
		if ( ! isset( $g_lbp_old_version ) || false == $g_lbp_old_version) {
			/**
			 * To update versions greater than 1.4 up to 2.7 to new database schema
			 */
			$g_lbp_old_options = get_option( 'lightboxplus_options' );
			if ( isset( $g_lbp_old_options ) ) {
				require_once( LBP_CLASS_PATH . '/class-update.php' );
				$lbp_update = new LBP_Update();
				$lbp_update->lbp_convert( $g_lbp_old_options );
				update_option( 'lightboxplus_options_old', $g_lbp_old_options );
				unset( $lbp_update );

				return true;
			} else {
				return false;
			}
		} elseif ( isset( $g_lbp_old_version ) && $g_lbp_old_version >= LBP_VERSION ) {
			/**
			 * For future updates
			 */
			return true;
		} else {
			/**
			 * If none of the above - initilize settings.
			 */
			$lbp_activate = new LBP_Init();
			$lbp_activate->lbp_install();
			unset( $lbp_activate );

			return true;
		}
	}
}

/**
 * On plugin deactivation don't do anything - keep settings
 */
if ( ! function_exists( 'deactivate_lbp' ) ) {
	function deactivate_lbp() {
		$lbp_deactivate = new LBP_Init();
		$lbp_deactivate->lbp_deactivate();
		unset( $lbp_deactivate );
	}
}

/**
 * On plugin deactivation remove settings from database
 */
if ( ! function_exists( 'uninstall_lbp' ) ) {
	function uninstall_lbp() {
		$lbp_uninstall = new LBP_Init();
		$lbp_uninstall->lbp_uninstall();
		unset( $lbp_uninstall );
	}
}

load_plugin_textdomain( 'lightboxplus', false, $path = LBP_URL . 'languages' );


if ( ! interface_exists( 'LBP_Lightboxplus_Interface' ) ) {
	interface LBP_Lightboxplus_Interface {
		function __construct();

		function init();

		function lbp_initial();

		function lbp_final();

		function get_admin_options( $optionsName );

		function save_admin_options( $optionsName, $options );

		function register_lbp_links( $links, $file );

		function lbp_admin_panel();
	}
}

/**
 * Ensure class doesn't already exist
 */
if ( ! class_exists( 'LBP_Lightboxplus' ) ) {
	class LBP_Lightboxplus extends LBP_Init implements LBP_Lightboxplus_Interface {
		/**
		 * The name the options are saved under in the database
		 *
		 * @var mixed
		 */
		var $lbp_options_base_name = 'lightboxplus_options_base';
		var $lbp_options_primary_name = 'lightboxplus_options_primary';
		var $lbp_options_secondary_name = 'lightboxplus_options_secondary';
		var $lbp_options_inline_name = 'lightboxplus_options_inline';
		var $lbp_init_name = 'lightboxplus_init';
		var $lbp_verison_name = 'lightboxplus_version';
		var $lbp_style_pathname = 'lightboxplus_style_path';
		var $lbp_options = '';


		/**
		 * The PHP 5 Constructor - initializes the plugin and sets up panels
		 */
		function __construct() {
			//register an activation hook for the plugin
			add_action( 'init', array( $this, 'init' ) );
		}

		function init() {
			global $g_lbp_base_options;
			global $g_lbp_primary_options;
			global $g_lbp_secondary_options;
			global $g_lbp_inline_options;
			global $g_lbp_old_options;


			$g_lbp_base_options      = get_option( $this->lbp_options_base_name );
			$g_lbp_primary_options   = get_option( $this->lbp_options_primary_name );
			$g_lbp_secondary_options = get_option( $this->lbp_options_secondary_name );
			$g_lbp_inline_options    = get_option( $this->lbp_options_inline_name );

			/**
			 * If user is in the admin panel
			 */
			if ( is_admin() && current_user_can( 'administrator' ) ) {
				add_action( 'admin_menu', array( &$this, 'lbp_add_panel' ) );
				/**
				 * Check to see if the user wants to use per page/post options
				 */
				if ( ( isset( $g_lbp_base_options['use_forpage'] ) && $g_lbp_base_options['use_forpage'] == '1' ) || ( isset( $g_lbp_base_options['use_forpost'] ) && $g_lbp_base_options['use_forpost'] == '1' ) ) {
					add_action( 'save_post', array( &$this, 'lbp_save_meta' ), 10, 2 );
					add_action( 'add_meta_boxes', array( &$this, "lbp_meta_box" ), 10, 2 );
				}
				$this->lbp_final();
			}
			add_action( 'template_redirect', array( &$this, 'lbp_initial' ) );
			add_filter( 'plugin_row_meta', array( &$this, 'register_lbp_links' ), 10, 2 );
		}

		function lbp_initial() {
			global $the_post_id;
			global $wp_query;
			global $g_lbp_base_options;

			$the_post_id = $wp_query->post->ID;

			/**
			 * Remove following line after a few versions or 2.6 is the prevelent version
			 */
			if ( isset( $g_lbp_base_options ) ) {
				$g_lbp_base_options = $this->set_missing_options( $g_lbp_base_options );
			}

			if ( isset( $g_lbp_base_options['use_perpage'] ) && '0' != $g_lbp_base_options['use_perpage'] ) {
				add_action( 'wp_print_styles', array(
					&$this,
					'lbp_add_header'
				), intval( $g_lbp_base_options['load_priority'] ) );
				if ( $g_lbp_base_options['use_forpage'] && get_post_meta( $the_post_id, '_lbp_use', true ) ) {
					$this->lbp_final();
				}
				if ( $g_lbp_base_options['use_forpost'] && ( ( $wp_query->is_posts_page ) || is_single() ) ) {
					$this->lbp_final();
				}
			} else {
				$this->lbp_final();
			}
		}

		function lbp_final() {
			global $g_lbp_base_options;
			global $g_lbp_primary_options;

			/**
			 * Get lightbox options to check for auto-lightbox and gallery
			 */

			/**
			 * Remove following line after a few versions or 2.6 is the prevelent version
			 */
			if ( isset( $g_lbp_base_options ) ) {
				$g_lbp_base_options = $this->set_missing_options( $g_lbp_base_options );
			}

			add_action( 'wp_print_styles', array(
				&$this,
				'lbp_add_header'
			), intval( $g_lbp_base_options['load_priority'] ) );

			/**
			 * Check to see if users wants images auto-lightboxed
			 */
			if ( $g_lbp_primary_options['no_auto_lightbox'] != 1 ) {
				/**
				 * Check to see if user wants to have gallery images lightboxed
				 */
				if ( 1 != $g_lbp_primary_options['gallery_lightboxplus'] ) {
					add_filter( 'the_content', array( &$this, 'lbp_replace_content' ), 11 );
				} else {
					remove_shortcode( 'gallery' );
					add_shortcode( 'gallery', array( &$this, 'lbp_gallery' ), 6 );
					add_filter( 'the_content', array( &$this, 'lbp_replace_content' ), 11 );
				}
			}
			//add_action( 'wp_footer', array( &$this, 'lbp_colorbox' ) );
			add_action( $g_lbp_base_options['load_location'], array(
				&$this,
				'lbp_colorbox'
			), ( intval( $g_lbp_base_options['load_priority'] ) + 4 ) );
//			}
		}

		/**
		 * Retrieves the options from the database.
		 *
		 * @param mixed $optionsName
		 *
		 * @return array
		 */
		function get_admin_options( $optionsName ) {
			$theOptions   = '';
			$savedOptions = get_option( $optionsName );
			if ( ! empty( $savedOptions ) ) {
				foreach ( $savedOptions as $key => $option ) {
					$theOptions[ $key ] = $option;
				}
			}
			update_option( $optionsName, $theOptions );

			return $theOptions;
		}

		/**
		 * Saves the admin options to the database.
		 * TODO: Check to see if used remove if not
		 *
		 * @param mixed $optionsName
		 * @param mixed $options
		 */
		function save_admin_options( $optionsName, $options ) {
			update_option( $optionsName, $options );
		}

		/**
		 * Adds links to the plugin row on the plugins page.
		 * This add_filter function must be in this file or it does not work correctly, requires plugin_basename and file match
		 *
		 * @param mixed $links
		 * @param mixed $file
		 *
		 * @return string
		 *
		 */
		function register_lbp_links( $links, $file ) {
			$base = plugin_basename( __FILE__ );
			if ( $file == $base ) {
				$links[] = '<a href="themes.php?page=lightboxplus" title="Lightbox Plus Colorbox Settings">' . __( 'Settings', 'lightboxplus' ) . '</a>';
				$links[] = '<a href="http://www.23systems.net/wordpress-plugins/lightbox-plus-for-wordpress/frequently-asked-questions/" title="Lightbox Plus Colorbox FAQ">' . __( 'FAQ', 'lightboxplus' ) . '</a>';
				$links[] = '<a href="http://www.23systems.net/wordpress-php-development-services/wordpress-plugin-client-support/wordpress-plugin-support/" title="Lightbox Plus Colorbox Direct Support">' . __( 'Request Support', 'lightboxplus' ) . '</a>';
				$links[] = '<a href="http://wordpress.org/support/plugin/lightbox-plus" title="Lightbox Plus Colorbox Support Forum">' . __( 'Support Forum', 'lightboxplus' ) . '</a>';
				$links[] = '<a href="http://www.23systems.net/donate/" title="Donate to Lightbox Plus Colorbox">' . __( 'Donate', 'lightboxplus' ) . '</a>';
				$links[] = '<a href="http://twitter.com/23systems" title="@23System on Twitter">' . __( 'Twitter', 'lightboxplus' ) . '</a>';
				$links[] = '<a href="http://www.facebook.com/23Systems" title="23Systems on Facebook">' . __( 'Facebook', 'lightboxplus' ) . '</a>';
				$links[] = '<a href="http://www.linkedin.com/company/23systems" title="23Systems on LinkedIn">' . __( 'LinkedIn', 'lightboxplus' ) . '</a>';
				$links[] = '<a href="https://plus.google.com/111641141856782935011/posts" title="23System on Google+">' . __( 'Google+', 'lightboxplus' ) . '</a>';
			}

			return $links;
		}

		/**
		 * The admin panel funtion
		 * handles creating admin panel and processing of form submission
		 */
		function lbp_admin_panel() {
			global $g_lbp_messages;
			global $g_lbp_base_options;
			global $g_lbp_primary_options;
			global $g_lbp_secondary_options;
			global $g_lbp_inline_options;


			/**
			 * Check form submission and update setting
			 */
			if ( isset( $_REQUEST['action'] ) ) {
				if ( $_REQUEST['action'] == 'basic' ) {
					$g_lbp_base_options = array(
						"lightboxplus_multi" => $_POST['lightboxplus_multi'],
						"use_inline"         => $_POST['use_inline'],
						"inline_num"         => $_POST['inline_num'],
						"lightboxplus_style" => $_POST['lightboxplus_style'],
						"use_custom_style"   => $_POST['use_custom_style'],
						"disable_css"        => $_POST['disable_css'],
						"hide_about"         => $_POST['hide_about'],
						"output_htmlv"       => $_POST['output_htmlv'],
						"data_name"          => $_POST['data_name'],
						"load_location"      => $_POST['load_location'],
						"load_priority"      => $_POST['load_priority'],
						"use_perpage"        => $_POST['use_perpage'],
						"use_forpage"        => $_POST['use_forpage'],
						"use_forpost"        => $_POST['use_forpost']
					);

					if ( isset( $_POST['lightboxplus_multi'] ) ) {
						update_option( 'lightboxplus_init_secondary', true );
					} else {
						update_option( 'lightboxplus_init_secondary', 0 );
					}

					if ( isset( $_POST['use_inline'] ) && isset( $_POST['inline_num'] ) ) {
						$lbp_base_options_current   = get_option( 'lightboxplus_options_base' );
						$lbp_inline_options_current = get_option( 'lightboxplus_options_inline' );

						if ( $_POST['inline_num'] > $lbp_base_options_current['inline_num'] ) {
							$lbp_inline_options_new = $this->lbp_inline_init( $_POST['inline_num'] );
							$g_lbp_inline_options   = array_replace_recursive( $lbp_inline_options_new, $lbp_inline_options_current );
							update_option( 'lightboxplus_options_inline', $g_lbp_inline_options );
						} elseif ( $lbp_base_options_current['inline_num'] > $_POST['inline_num'] ) {
							foreach ( $lbp_inline_options_current as $key => $value ) {
//								for ( $i = 1; $i <= ( $lbp_base_options_current['inline_num'] - $_POST['inline_num'] ); $i ++ ) {
//									array_pop( $value );
//								}

								$g_lbp_inline_options[ $key ] = $this->lbp_array_trim( $value, ( $lbp_base_options_current['inline_num'] - $_POST['inline_num'] ) );
//								$g_lbp_inline_options[ $key ] = $value;
							}

							update_option( 'lightboxplus_options_inline', $g_lbp_inline_options );
						}
						update_option( 'lightboxplus_init_inline', true );
					} else {
						update_option( 'lightboxplus_init_inline', 0 );
					}

					update_option( 'lightboxplus_options_base', $g_lbp_base_options );

				} elseif ( $_REQUEST['action'] == 'primary' ) {
					$g_lbp_primary_options = array(
						"transition"           => $_POST['transition'],
						"speed"                => $_POST['speed'],
						"width"                => $_POST['width'],
						"height"               => $_POST['height'],
						"inner_width"          => $_POST['inner_width'],
						"inner_height"         => $_POST['inner_height'],
						"initial_width"        => $_POST['initial_width'],
						"initial_height"       => $_POST['initial_height'],
						"max_width"            => $_POST['max_width'],
						"max_height"           => $_POST['max_height'],
						"resize"               => $_POST['resize'],
						"opacity"              => $_POST['opacity'],
						"preloading"           => $_POST['preloading'],
						"label_image"          => $_POST['label_image'],
						"label_of"             => $_POST['label_of'],
						"previous"             => $_POST['previous'],
						"next"                 => $_POST['next'],
						"close"                => $_POST['close'],
						"overlay_close"        => $_POST['overlay_close'],
						"slideshow"            => $_POST['slideshow'],
						"slideshow_auto"       => $_POST['slideshow_auto'],
						"slideshow_speed"      => $_POST['slideshow_speed'],
						"slideshow_start"      => $_POST['slideshow_start'],
						"slideshow_stop"       => $_POST['slideshow_stop'],
						"use_caption_title"    => $_POST['use_caption_title'],
						"gallery_lightboxplus" => $_POST['gallery_lightboxplus'],
						"multiple_galleries"   => $_POST['multiple_galleries'],
						"use_class_method"     => $_POST['use_class_method'],
						"class_name"           => $_POST['class_name'],
						"no_auto_lightbox"     => $_POST['no_auto_lightbox'],
						"text_links"           => $_POST['text_links'],
						"no_display_title"     => $_POST['no_display_title'],
						"scrolling"            => $_POST['scrolling'],
						"photo"                => $_POST['photo'],
						"rel"                  => $_POST['rel'], //Disable grouping
						"loop"                 => $_POST['loop'],
						"esc_key"              => $_POST['esc_key'],
						"arrow_key"            => $_POST['arrow_key'],
						"top"                  => $_POST['top'],
						"bottom"               => $_POST['bottom'],
						"left"                 => $_POST['left'],
						"right"                => $_POST['right'],
						"fixed"                => $_POST['fixed']
					);
					update_option( 'lightboxplus_options_primary', $g_lbp_primary_options );

				} elseif ( $_REQUEST['action'] == 'secondary' ) {
					if ( $_POST['lightboxplus_multi'] && isset( $_POST['ready_sec'] ) ) {
						$g_lbp_secondary_options = array(
							"transition_sec"       => $_POST['transition_sec'],
							"speed_sec"            => $_POST['speed_sec'],
							"width_sec"            => $_POST['width_sec'],
							"height_sec"           => $_POST['height_sec'],
							"inner_width_sec"      => $_POST['inner_width_sec'],
							"inner_height_sec"     => $_POST['inner_height_sec'],
							"initial_width_sec"    => $_POST['initial_width_sec'],
							"initial_height_sec"   => $_POST['initial_height_sec'],
							"max_width_sec"        => $_POST['max_width_sec'],
							"max_height_sec"       => $_POST['max_height_sec'],
							"resize_sec"           => $_POST['resize_sec'],
							"opacity_sec"          => $_POST['opacity_sec'],
							"preloading_sec"       => $_POST['preloading_sec'],
							"label_image_sec"      => $_POST['label_image_sec'],
							"label_of_sec"         => $_POST['label_of_sec'],
							"previous_sec"         => $_POST['previous_sec'],
							"next_sec"             => $_POST['next_sec'],
							"close_sec"            => $_POST['close_sec'],
							"overlay_close_sec"    => $_POST['overlay_close_sec'],
							"slideshow_sec"        => $_POST['slideshow_sec'],
							"slideshow_auto_sec"   => $_POST['slideshow_auto_sec'],
							"slideshow_speed_sec"  => $_POST['slideshow_speed_sec'],
							"slideshow_start_sec"  => $_POST['slideshow_start_sec'],
							"slideshow_stop_sec"   => $_POST['slideshow_stop_sec'],
							"iframe_sec"           => $_POST['iframe_sec'],
							"class_name_sec"       => $_POST['class_name_sec'],
							"no_display_title_sec" => $_POST['no_display_title_sec'],
							"scrolling_sec"        => $_POST['scrolling_sec'],
							"photo_sec"            => $_POST['photo_sec'],
							"rel_sec"              => $_POST['rel_sec'], //Disable grouping
							"loop_sec"             => $_POST['loop_sec'],
							"esc_key_sec"          => $_POST['esc_key_sec'],
							"arrow_key_sec"        => $_POST['arrow_key_sec'],
							"top_sec"              => $_POST['top_sec'],
							"bottom_sec"           => $_POST['bottom_sec'],
							"left_sec"             => $_POST['left_sec'],
							"right_sec"            => $_POST['right_sec'],
							"fixed_sec"            => $_POST['fixed_sec']
						);
						if ( isset( $g_lbp_secondary_options ) ) {
							update_option( 'lightboxplus_options_secondary', $g_lbp_secondary_options );
						}

					}
				} elseif ( $_REQUEST['action'] == 'inline' ) {
					$g_lbp_base_options = get_option( $this->lbp_options_base_name );
					if ( $g_lbp_base_options['use_inline'] && isset( $_POST['ready_inline'] ) ) {
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

						if ( $g_lbp_base_options['use_inline'] && isset( $g_lbp_base_options['inline_num'] ) ) {
							for ( $i = 1; $i <= $g_lbp_base_options['inline_num']; $i ++ ) {
								$inline_links[ $i ]            = $_POST["inline_link"][ $i ];
								$inline_hrefs[ $i ]            = $_POST["inline_href"][ $i ];
								$inline_transitions[ $i ]      = $_POST["inline_transition"][ $i ];
								$inline_speeds[ $i ]           = $_POST["inline_speed"][ $i ];
								$inline_widths[ $i ]           = $_POST["inline_width"][ $i ];
								$inline_heights[ $i ]          = $_POST["inline_height"][ $i ];
								$inline_inner_widths[ $i ]     = $_POST["inline_inner_width"][ $i ];
								$inline_inner_heights[ $i ]    = $_POST["inline_inner_height"][ $i ];
								$inline_max_widths[ $i ]       = $_POST["inline_max_width"][ $i ];
								$inline_max_heights[ $i ]      = $_POST["inline_max_height"][ $i ];
								$inline_position_tops[ $i ]    = $_POST["inline_position_top"][ $i ];
								$inline_position_rights[ $i ]  = $_POST["inline_position_right"][ $i ];
								$inline_position_bottoms[ $i ] = $_POST["inline_position_bottom"][ $i ];
								$inline_position_lefts[ $i ]   = $_POST["inline_position_left"][ $i ];
								$inline_fixeds[ $i ]           = $_POST["inline_fixed"][ $i ];
								$inline_opens[ $i ]            = $_POST["inline_open"][ $i ];
								$inline_opacitys[ $i ]         = $_POST["inline_opacity"][ $i ];
							}
						}

						$g_lbp_inline_options = array(
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

						if ( isset( $g_lbp_inline_options ) ) {
							update_option( 'lightboxplus_options_inline', $g_lbp_inline_options );
						}

					}
				} elseif ( $_REQUEST['action'] == 'reset' ) {
					if ( isset( $_REQUEST['reinit_lightboxplus'] ) ) {
						delete_option( $this->lbp_options_base_name );
						delete_option( $this->lbp_options_primary_name );
						delete_option( $this->lbp_options_secondary_name );
						delete_option( $this->lbp_options_inline_name );
						delete_option( $this->lbp_init_name );
						delete_option( $this->lbp_verison_name );
						delete_option( $this->lbp_style_pathname );
						/**
						 * Used to remove old setting from previous versions of LBP
						 *
						 * @var string
						 */
						$plugin_path = ( dirname( __FILE__ ) );
						if ( file_exists( $plugin_path . "/images" ) ) {
							$g_lbp_messages .= __( 'Deleting: ' ) . $plugin_path . '/images . . . ' . __( 'Removed old Lightbox Plus Colorbox style images.', 'lightboxplus' ) . '<br /><br />';
							$this->delete_directory( $plugin_path . "/images/" );
						} else {
							$g_lbp_messages .= '';
						}
						if ( file_exists( $plugin_path . "/js/" . "lightbox.js" ) ) {
							$g_lbp_messages .= __( 'Deleting: ', 'lightboxplus' ) . $plugin_path . '/js/lightbox.js . . . ' . __( 'Removed old Lightbox Plus Colorbox JavaScript.', 'lightboxplus' ) . '<br /><br />';
							$this->delete_file( $plugin_path . "/js", "lightbox.js" );
						} else {
							$g_lbp_messages .= '';
						}
						if ( is_dir( $plugin_path . "/css/" ) ) {
							$st_old_styles = $this->directory_list( $plugin_path . "/css/" );
						}
						if ( isset( $st_old_styles ) ) {
							foreach ( $st_old_styles as $value ) {
								if ( file_exists( $plugin_path . "/css/" . $value ) ) {
									$g_lbp_messages .= __( 'Deleting: ' . $plugin_path . '/css/' . $value ) . ' . . . <br /><br />';
									$this->delete_file( $plugin_path . "/css", $value );
								}
							}
							$g_lbp_messages .= __( 'Removed old Lightbox Plus Colorbox styles.', 'lightboxplus' ) . '<br /><br />';
						} else {
							$g_lbp_messages .= '';
						}
					}

					/**
					 * Will reinitilize on reload where option lightboxplus_init is null
					 *
					 * @var LBP_Lightboxplus
					 */
					$this->lbp_install();

					return 'success';
				}
			} else {
				?>
				<div class="wrap" id="lightbox">
					<?php
					if ( isset( $_GET['message'] ) ) {
						$g_lbp_messages = '';
						switch ( $_GET['message'] ) {
							case 'basic':
								$g_lbp_messages .= __( 'Lightbox Plus Colorbox basic settings saved.', 'lightboxplus' );

								/**
								 * Load options info array if not yet loaded
								 */
								if ( ! empty( $this->lbp_options_base_name ) ) {
									$g_lbp_base_options = get_option( $this->lbp_options_base_name );
								}

								/**
								 * Initialize Custom lightbox Plus Path
								 */
								if ( isset( $g_lbp_base_options['use_custom_styles'] ) ) {
									if ( ! is_dir( LBP_CUSTOM_STYLE_PATH ) ) {
										$dir_create_result = $this->lbp_global_styles_init();
										if ( $dir_create_result ) {
											$g_lbp_messages .= '<br /><br />' . __( 'Lightbox custom styles initialized.', 'lightboxplus' );
										} else {
											$g_lbp_messages .= '<br /><br />' . __( '<strong style="color:#900;">Lightbox custom styles initialization failed.</strong><br />Please create a directory called <code>lbp-css</code> in your <code>wp-content</code> directory and copy the styles located in <code>wp-content/plugins/lightbox-plus/assets/lbp-css/</code> to <code>wp-content/lbp-css</code>', 'lightboxplus' );
										}
									}
								}

								/**
								 * Initialize Secondary Lightbox if enabled
								 */
								if ( isset( $g_lbp_base_options['lightboxplus_multi'] ) && $g_lbp_base_options['lightboxplus_multi'] == 1 ) {
									$this->lbp_secondary_init();
									$g_lbp_messages .= '<br /><br />' . __( 'Secondary lightbox settings initialized.', 'lightboxplus' );
								}

								/**
								 *  Initialize Inline Lightboxes if enabled
								 */
								if ( isset( $g_lbp_base_options['use_inline'] ) && $g_lbp_base_options['use_inline'] == 1 ) {
									$this->lbp_inline_init( $g_lbp_base_options['inline_num'] );
									$g_lbp_messages .= '<br /><br />' . __( 'Inline lightbox settings initialized.', 'lightboxplus' );
								}
								unset( $g_lbp_base_options );
								break;
							case 'primary':
								$g_lbp_messages .= __( 'Primary lightbox settings saved.', 'lightboxplus' );
								break;
							case 'secondary':
								$g_lbp_messages .= __( 'Secondary lightbox settings saved.', 'lightboxplus' );
								break;
							case 'inline':
								$g_lbp_messages .= __( 'Inline lightbox settings saved.', 'lightboxplus' );
								break;
							case 'reset':
								$g_lbp_messages .= '<h3>' . __( 'Lightbox Plus Colorbox Reset', 'lightboxplus' ) . '</h3>';
								$g_lbp_messages .= '<strong>' . __( 'Lightbox Plus Colorbox has been completely reset to default settings.', 'lightboxplus' ) . '</strong><br />';
								$g_lbp_messages .= '<strong>' . __( 'Please check and update your Lightbox Plus Colorbox settings before continuing!', 'lightboxplus' ) . '</strong>';

						}
					}
					if ( $g_lbp_messages ) {
						echo '<div class="updated fade-notice"><p>' . $g_lbp_messages . '</p></div>';
					}
					?>
					<h2><?php _e( 'Lightbox Plus Colorbox (v' . LBP_VERSION . ') Options', 'lightboxplus' ) ?></h2>

					<h3><?php _e( 'With Colorbox (v' . LBP_COLORBOX_VERSION . ') and PHP Simple HTML DOM Parser (v' . LBP_SHD_VERSION . ')', 'lightboxplus' ) ?></h3>
					<h4><?php _e( '<a href="http://www.23systems.net/plugins/lightbox-plus/">Visit plugin site</a> |
                        <a href="http://www.23systems.net/wordpress-plugins/lightbox-plus-for-wordpress/frequently-asked-questions/" title="Lightbox Plus Colorbox FAQ">FAQ</a> |
                        <a href="http://www.23systems.net/wordpress-php-development-services/wordpress-plugin-client-support/wordpress-plugin-support/" title="Lightbox Plus Colorbox Direct Support">Request Support</a> |
                        <a href="http://wordpress.org/support/plugin/lightbox-plus" title="Lightbox Plus Colorbox Support Forum">Support Forum</a> |
                        <a href="http://twitter.com/23systems" title="@23Systems on Twitter">Twitter</a> |
                        <a href="http://www.facebook.com/23Systems" title="23Systems on Facebook">Facebook</a> |
                        <a href="http://www.linkedin.com/company/23systems" title="23Systems of LinkedIn">LinkedIn</a> |
                    <a href="https://plus.google.com/111641141856782935011/posts" title="23System on Google+">Google+</a>' ); ?> |
					</h4>
				</div>
				<?php
				require( LBP_CLASS_PATH . '/admin-lightbox.php' );
			}
			?>
		<?php
		}
	}

	/**
	 * END CLASS
	 */
	/**
	 * END CLASS CHECK
	 */
}
/**
 * Instantiate the class
 */
if ( class_exists( 'LBP_Lightboxplus' ) ) {
	$wp_lightboxplus = new LBP_Lightboxplus();
}