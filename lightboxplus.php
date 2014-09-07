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

global $g_lbp_options;
global $g_lbp_primary_options;
global $g_lbp_secondary_options;
global $g_lbp_inline_options;

/**
 * Instantiate Lightbox Plus Colorbox Global Variables
 *
 * @var mixed
 */
$g_lbp_plugin_page   = '';
$g_lbp_messages      = '';
$g_lbp_message_title = '';

DEFINE( 'LBP_ADMIN_PAGE', 'themes.php?page=lightboxplus' );
//define( 'HDM_DOCUMENT_PAGE', 'admin.php?page=hdm_document' );
//define( 'HDM_TAXONOMY_PAGE', 'admin.php?page=hdm_taxonomy' );
//define( 'HDM_SETTINGS_PAGE', 'admin.php?page=hdm_settings' );

DEFINE( 'LBP_VERSION', '2.7' );
DEFINE( 'LBP_SHD_VERSION', '1.5 rev 202' );
DEFINE( 'LBP_COLORBOX_VERSION', '1.5.13' );
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
require_once( LBP_CLASS_PATH . '/utility.class.php' );
require_once( LBP_CLASS_PATH . '/shortcode.class.php' );
require_once( LBP_CLASS_PATH . '/filters.class.php' );
require_once( LBP_CLASS_PATH . '/actions.class.php' );
require_once( LBP_CLASS_PATH . '/init.class.php' );
/**
 * Require PHP HTML Parser - This thing is slow should be replaced
 */
require_once( LBP_CLASS_PATH . '/shd.class.new.php' );


/**
 * Register activation/deactivation hooks and text domain
 */
register_activation_hook( __FILE__, 'ActivateLBP' );
register_deactivation_hook( __FILE__, 'DeactivateLBP' );
register_uninstall_hook( __FILE__, 'UninstallLBP' );

/**
 * On Plugin Activation initialize settings
 */
if ( ! function_exists( 'ActivateLBP' ) ) {
	function ActivateLBP() {
		$lbp_activate = new lbp_init();
		$lbp_activate->lbp_install();
		unset( $lbp_activate );
	}
}

/**
 * On plugin deactivation don't do anything - keep settings
 */
if ( ! function_exists( 'DeactivateLBP' ) ) {
	function DeactivateLBP() {
		$lbp_deactivate = new lbp_init();
		$lbp_deactivate->lbp_deactivate();
		unset( $lbp_deactivate );
	}
}

/**
 * On plugin deactivation remove settings from database
 */
if ( ! function_exists( 'UninstallLBP' ) ) {
	function UninstallLBP() {
		$lbp_uninstall = new lbp_init();
		$lbp_uninstall->lbp_uninstall();
		unset( $lbp_uninstall );
	}
}

load_plugin_textdomain( 'lightboxplus', false, $path = LBP_URL . 'languages' );

/**
 * Ensure class doesn't already exist
 */
if ( ! class_exists( 'wp_lightboxplus' ) ) {
	class wp_lightboxplus extends lbp_init {
		/**
		 * The name the options are saved under in the database
		 *
		 * @var mixed
		 */
		var $lightboxOptionsName = 'lightboxplus_options';
		var $lightboxOptionsPrimaryName = 'lightboxplus_options_primary';
		var $lightboxOptionsSecondaryName = 'lightboxplus_options_secondary';
		var $lightboxOptionsInlineName = 'lightboxplus_options_inline';
		var $lightboxInitName = 'lightboxplus_init';
		var $lightboxVersionName = 'lightboxplus_version';
		var $lightboxStylePathName = 'lightboxplus_style_path';
		var $lightboxPlusOptions = '';

		/**
		 * The PHP 5 Constructor - initializes the plugin and sets up panels
		 */
		function __construct() {
			//register an activation hook for the plugin
			add_action( 'init', array( $this, 'init' ) );
		}

		function init() {
			$this->lightboxOptions          = $this->getAdminOptions( $this->lightboxOptionsName );
			$this->lightboxPrimaryOptions   = $this->getAdminOptions( $this->lightboxOptionsPrimaryName );
			$this->lightboxSecondaryOptions = $this->getAdminOptions( $this->lightboxOptionsSecondaryName );
			$this->lightboxInlineOptions    = $this->getAdminOptions( $this->lightboxOptionsInlineName );
			/**
			 * TODO: WHy is this here - do we need it - options updated above
			 */
			if ( ! empty( $this->lightboxOptions ) ) {
				$lightboxPlusOptions = $this->getAdminOptions( $this->lightboxOptionsName );
			}

			if ( ! empty( $this->lightboxPrimaryOptions ) ) {
				$lightboxPrimaryOptions = $this->getAdminOptions( $this->lightboxOptionsPrimaryName );
			}

			if ( ! empty( $this->lightboxSecondaryOptions ) ) {
				$lightboxSecondaryOptions = $this->getAdminOptions( $this->lightboxOptionsSecondaryName );
			}

			if ( ! empty( $this->lightboxInlineOptions ) ) {
				$lightboxInlineOptions = $this->getAdminOptions( $this->lightboxOptionsInlineName );
			}

			/**
			 * If user is in the admin panel
			 */
			if ( is_admin() && current_user_can( 'administrator' ) ) {
				add_action( 'admin_menu', array( &$this, 'lightboxPlusAddPanel' ) );
				/**
				 * Check to see if the user wants to use per page/post options
				 */
				if ( ( isset( $lightboxPlusOptions['use_forpage'] ) && $lightboxPlusOptions['use_forpage'] == '1' ) || ( isset( $lightboxPlusOptions['use_forpost'] ) && $lightboxPlusOptions['use_forpost'] == '1' ) ) {
					add_action( 'save_post', array( &$this, 'lightboxPlusSaveMeta' ), 10, 2 );
					add_action( 'add_meta_boxes', array( &$this, "lightboxPlusMetaBox" ), 10, 2 );
				}
				$this->lbpFinal();
			}
			add_action( 'template_redirect', array( &$this, 'lbpInitial' ) );
			add_filter( 'plugin_row_meta', array( &$this, 'RegisterLBPLinks' ), 10, 2 );
		}

		function lbpInitial() {
			global $the_post_id;
			global $wp_query;

			$the_post_id = $wp_query->post->ID;

			if ( ! empty( $this->lightboxOptions ) ) {
				$lightboxPlusOptions = $this->getAdminOptions( $this->lightboxOptionsName );
			}

			/**
			 * Remove following line after a few versions or 2.6 is the prevelent version
			 */
			if ( isset( $lightboxPlusOptions ) ) {
				$lightboxPlusOptions = $this->setMissingOptions( $lightboxPlusOptions );
			}

			if ( isset( $lightboxPlusOptions['use_perpage'] ) && $lightboxPlusOptions['use_perpage'] != '0' ) {
				add_action( 'wp_print_styles', array(
					&$this,
					'lightboxPlusAddHeader'
				), intval( $lightboxPlusOptions['load_priority'] ) );
				if ( $lightboxPlusOptions['use_forpage'] && get_post_meta( $the_post_id, '_lbp_use', true ) ) {
					$this->lbpFinal();
				}
				if ( $lightboxPlusOptions['use_forpost'] && ( ( $wp_query->is_posts_page ) || is_single() ) ) {
					$this->lbpFinal();
				}
			} else {
				$this->lbpFinal();
			}
		}

		function lbpFinal() {
			/**
			 * Get lightbox options to check for auto-lightbox and gallery
			 */
			if ( ! empty( $this->lightboxOptions ) ) {
				$lightboxPlusOptions        = $this->getAdminOptions( $this->lightboxOptionsName );
				$lightboxPlusPrimaryOptions = $this->getAdminOptions( $this->lightboxOptionsPrimaryName );
				/**
				 * Remove following line after a few versions or 2.6 is the prevelent version
				 */
				if ( isset( $lightboxPlusOptions ) ) {
					$lightboxPlusOptions = $this->setMissingOptions( $lightboxPlusOptions );
				}

				add_action( 'wp_print_styles', array(
					&$this,
					'lightboxPlusAddHeader'
				), intval( $lightboxPlusOptions['load_priority'] ) );

				/**
				 * Check to see if users wants images auto-lightboxed
				 */
				if ( $lightboxPlusPrimaryOptions['no_auto_lightbox'] != 1 ) {
					/**
					 * Check to see if user wants to have gallery images lightboxed
					 */
					if ( $lightboxPlusPrimaryOptions['gallery_lightboxplus'] != 1 ) {
						add_filter( 'the_content', array( &$this, 'filterLightboxPlusReplace' ), 11 );
					} else {
						remove_shortcode( 'gallery' );
						add_shortcode( 'gallery', array( &$this, 'lightboxPlusGallery' ), 6 );
						add_filter( 'the_content', array( &$this, 'filterLightboxPlusReplace' ), 11 );
					}
				}
				//add_action( 'wp_footer', array( &$this, 'lightboxPlusColorbox' ) );
				add_action( $lightboxPlusOptions['load_location'], array(
					&$this,
					'lightboxPlusColorbox'
				), ( intval( $lightboxPlusOptions['load_priority'] ) + 4 ) );
			}
		}

		/**
		 * Retrieves the options from the database.
		 *
		 * @param mixed $optionsName
		 *
		 * @return array
		 */
		function getAdminOptions( $optionsName ) {
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
		function saveAdminOptions( $optionsName, $options ) {
			update_option( $optionsName, $options );
		}

		/**
		 * Adds links to the plugin row on the plugins page.
		 * This add_filter function must be in this file or it does not work correctly, requires plugin_basename and file match
		 *
		 * @param mixed $links
		 * @param mixed $file
		 *
		 */
		function RegisterLBPLinks( $links, $file ) {
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
		function lightboxPlusAdminPanel() {
			global $g_lbp_messages;
			global $g_lbp_message_title;

			/**
			 * Check form submission and update setting
			 */
			if ( isset( $_REQUEST['action'] ) ) {
				if ( $_REQUEST['action'] == 'basic' ) {
					$lightboxPlusOptions = array(
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

					if ( isset( $_POST['use_inline'] ) && isset( $_POST['inline_num'] ) ) {
						$lightboxCurrentOptions = $this->getAdminOptions( $this->lightboxOptionsName );
						if ( $_POST['inline_num'] > $lightboxCurrentOptions['inline_num'] ) {
							$lightboxPlusCurrentInlineOptions = $this->getAdminOptions( $this->lightboxOptionsInlineName );
							$lightboxPlusNewInlineOptions     = $this->lightboxPlusInlineInit( $_POST['inline_num'] );
							$lightboxPlusInlineOptions        = array_replace_recursive( $lightboxPlusNewInlineOptions, $lightboxPlusCurrentInlineOptions );
							update_option( 'lightboxplus_options_inline', $lightboxPlusInlineOptions );
						} elseif ( $_POST['inline_num'] < $lightboxCurrentOptions['inline_num'] ) {
							$lightboxPlusCurrentInlineOptions = $this->getAdminOptions( $this->lightboxOptionsInlineName );
							$lightboxPlusInlineOptions        = array_splice( $lightboxPlusCurrentInlineOptions, $_POST['inline_num'], ( count( $lightboxPlusCurrentInlineOptions ) - $_POST['inline_num'] ) );
							update_option( 'lightboxplus_options_inline', $lightboxPlusInlineOptions );
						}
					}
					update_option( 'lightboxplus_options', $lightboxPlusOptions );


				} elseif ( $_REQUEST['action'] == 'primary' ) {
					$lightboxPlusPrimaryOptions = array(
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
					update_option( 'lightboxplus_options_primary', $lightboxPlusPrimaryOptions );

				} elseif ( $_REQUEST['action'] == 'secondary' ) {
					if ( $_POST['lightboxplus_multi'] && isset( $_POST['ready_sec'] ) ) {
						$lightboxPlusSecondaryOptions = array(
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
						if ( isset( $lightboxPlusSecondaryOptions ) ) {
							update_option( 'lightboxplus_options_secondary', $lightboxPlusSecondaryOptions );
						}

					}
				} elseif ( $_REQUEST['action'] == 'inline' ) {
					$lightboxPlusOptions = $this->getAdminOptions( $this->lightboxOptionsName );
					if ( $lightboxPlusOptions['use_inline'] && isset( $_POST['ready_inline'] ) ) {
						if ( $lightboxPlusOptions['use_inline'] && isset( $lightboxPlusOptions['inline_num'] ) ) {
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
							for ( $i = 1; $i <= $lightboxPlusOptions['inline_num']; $i ++ ) {
								$inline_links[]            = $_POST["inline_link_$i"];
								$inline_hrefs[]            = $_POST["inline_href_$i"];
								$inline_transitions[]      = $_POST["inline_transition_$i"];
								$inline_speeds[]           = $_POST["inline_speed_$i"];
								$inline_widths[]           = $_POST["inline_width_$i"];
								$inline_heights[]          = $_POST["inline_height_$i"];
								$inline_inner_widths[]     = $_POST["inline_inner_width_$i"];
								$inline_inner_heights[]    = $_POST["inline_inner_height_$i"];
								$inline_max_widths[]       = $_POST["inline_max_width_$i"];
								$inline_max_heights[]      = $_POST["inline_max_height_$i"];
								$inline_position_tops[]    = $_POST["inline_position_top_$i"];
								$inline_position_rights[]  = $_POST["inline_position_right_$i"];
								$inline_position_bottoms[] = $_POST["inline_position_bottom_$i"];
								$inline_position_lefts[]   = $_POST["inline_position_left_$i"];
								$inline_fixeds[]           = $_POST["inline_fixed_$i"];
								$inline_opens[]            = $_POST["inline_open_$i"];
								$inline_opacitys[]         = $_POST["inline_opacity_$i"];
							}
						}

						$lightboxPlusInlineOptions = array(
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

						if ( isset( $lightboxPlusInlineOptions ) ) {
							update_option( 'lightboxplus_options_inline', $lightboxPlusInlineOptions );
						}

					}
				} elseif ( $_REQUEST['action'] == 'reset' ) {
					if ( isset( $_REQUEST['reinit_lightboxplus'] ) ) {
						delete_option( $this->lightboxOptionsName );
						delete_option( $this->lightboxOptionsPrimaryName );
						delete_option( $this->lightboxOptionsSecondaryName );
						delete_option( $this->lightboxOptionsInlineName );
						delete_option( $this->lightboxInitName );
						delete_option( $this->lightboxVersionName );
						delete_option( $this->lightboxStylePathName );
						/**
						 * Used to remove old setting from previous versions of LBP
						 *
						 * @var string
						 */
						$pluginPath = ( dirname( __FILE__ ) );
						if ( file_exists( $pluginPath . "/images" ) ) {
							$g_lbp_messages .= __( 'Deleting: ' ) . $pluginPath . '/images . . . ' . __( 'Removed old Lightbox Plus Colorbox style images.', 'lightboxplus' ) . '<br /><br />';
							$this->delete_directory( $pluginPath . "/images/" );
						} else {
							$g_lbp_messages .= '';
						}
						if ( file_exists( $pluginPath . "/js/" . "lightbox.js" ) ) {
							$g_lbp_messages .= __( 'Deleting: ', 'lightboxplus' ) . $pluginPath . '/js/lightbox.js . . . ' . __( 'Removed old Lightbox Plus Colorbox JavaScript.', 'lightboxplus' ) . '<br /><br />';
							$this->delete_file( $pluginPath . "/js", "lightbox.js" );
						} else {
							$g_lbp_messages .= '';
						}
						if ( is_dir( $pluginPath . "/css/" ) ) {
							$oldStyles = $this->dirList( $pluginPath . "/css/" );
						}
						if ( isset( $oldStyles ) ) {
							foreach ( $oldStyles as $value ) {
								if ( file_exists( $pluginPath . "/css/" . $value ) ) {
									$g_lbp_messages .= __( 'Deleting: ' . $pluginPath . '/css/' . $value ) . ' . . . <br /><br />';
									$this->delete_file( $pluginPath . "/css", $value );
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
					 * @var wp_lightboxplus
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
								$g_lbp_messages .= __( 'Lightbox Plus Colorbox basic settings saved.', 'lightboxplus' ) . '<br /><br />';

								/**
								 * Load options info array if not yet loaded
								 */
								if ( ! empty( $this->lightboxOptions ) ) {
									$lightboxPlusOptions = $this->getAdminOptions( $this->lightboxOptionsName );
								}

								/**
								 * Initialize Custom lightbox Plus Path
								 */
								if ( isset( $lightboxPlusOptions['use_custom_styles'] ) ) {
									if ( ! is_dir( LBP_CUSTOM_STYLE_PATH ) ) {
										$dir_create_result = $this->lightboxPlusGlobalStylesinit();
										if ( $dir_create_result ) {
											$g_lbp_messages .= __( 'Lightbox custom styles initialized.', 'lightboxplus' ) . '<br /><br />';
										} else {
											$g_lbp_messages .= __( '<strong style="color:#900;">Lightbox custom styles initialization failed.</strong><br />Please create a directory called <code>lbp-css</code> in your <code>wp-content</code> directory and copy the styles located in <code>wp-content/plugins/lightbox-plus/assets/lbp-css/</code> to <code>wp-content/lbp-css</code>', 'lightboxplus' ) . '<br /><br />';
										}
									}
								}

								/**
								 * Initialize Secondary Lightbox if enabled
								 */
								if ( isset( $lightboxPlusOptions['lightboxplus_multi'] ) ) {
									$this->lightboxPlusSecondaryInit();
									$g_lbp_messages .= __( 'Secondary lightbox settings initialized.', 'lightboxplus' ) . '<br /><br />';
								}

								/**
								 *  Initialize Inline Lightboxes if enabled
								 */
								if ( isset( $lightboxPlusOptions['use_inline'] ) ) {
									$this->lightboxPlusInlineInit( $lightboxPlusOptions['inline_num'] );
									$g_lbp_messages .= __( 'Inline lightbox settings initialized.', 'lightboxplus' ) . '<br /><br />';
								}
								unset( $lightboxPlusOptions );
								break;
							case 'primary':
								$g_lbp_messages .= __( 'Primary lightbox settings saved.', 'lightboxplus' ) . '<br /><br />';
								break;
							case 'secondary':
								$g_lbp_messages .= __( 'Secondary lightbox settings saved.', 'lightboxplus' ) . '<br /><br />';
								break;
							case 'inline':
								$g_lbp_messages .= __( 'Inline lightbox settings saved.', 'lightboxplus' ) . '<br /><br />';
								break;
							case 'reset':
								$g_lbp_messages .= '<h3>' . __( 'Lightbox Plus Colorbox Reset', 'lightboxplus' ) . '</h3>';
								$g_lbp_messages .= '<strong>' . __( 'Lightbox Plus Colorbox has been completely reset to default settings.', 'lightboxplus' ) . '</strong><br /><br />';
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
                    <a href="https://plus.google.com/111641141856782935011/posts" title="23System on Google+">Google+</a>' ); ?></h4>
				</div>
				<?php
				require( LBP_CLASS_PATH . '/lightbox.admin.php' );
			}
//				$location = admin_url( '/admin.php?page=lightboxplus' );
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
if ( class_exists( 'wp_lightboxplus' ) ) {
	$wp_lightboxplus = new wp_lightboxplus();
}