<?php
    /*
    Plugin Name: Lightbox Plus
    Plugin URI: http://www.23systems.net/plugins/lightbox-plus/
    Description: Lightbox Plus implements ColorBox as a lightbox image overlay tool for WordPress.  <a href="http://colorpowered.com/colorbox/">ColorBox</a> was created by Jack Moore of Color Powered and is licensed under the <a href="http://www.opensource.org/licenses/mit-license.php">MIT License</a>.
    Author: Dan Zappone
    Author URI: http://www.23systems.net/
    Version: 1.7
    */
    /*---- 6/23/2010 ----*/
    global $post, $content;  // WordPress Globals
    global $g_lightbox_plus_url;
    global $g_lbp_messages;
    $g_lbp_messages = '';
    $g_lightbox_plus_url = WP_PLUGIN_URL.'/lightbox-plus';
    load_plugin_textdomain('lightboxplus', $path = $g_lightbox_plus_url);

    /**
    * Require extented classes
    */
    require_once('utility.class.php');
    require_once('shortcode.class.php');
    require_once('filters.class.php');
    require_once('actions.class.php');
    require_once('init.class.php');

    /**
    * Ensure class doesn't already exist        
    */
    if (!class_exists('wp_lightboxplus')) {

        class wp_lightboxplus extends lbp_init {

            /**
            * The name the options are saved under in the database
            * 
            * @var mixed
            */
            var $lightboxOptionsName   = 'lightboxplus_options';
            var $lightboxInitName      = 'lightboxplus_init';
            var $lightboxStylePathName = 'lightboxplus_style_path';

            /**
            * The PHP 4 Compatible Constructor
            * 
            */
            function wp_lightboxplus( ) {
                $this->__construct( );
            }

            /**
            * The PHP 5 Constructor
            * 
            */
            function __construct( ) {
                $this->lightboxOptions = $this->getAdminOptions( $this->lightboxOptionsName );
                if ( !get_option( $this->lightboxInitName ) ) {
                    $this->lightboxPlusInit( );
                }
                add_filter( 'plugin_row_meta',array( &$this, 'RegisterLBPLinks'),10,2);
                add_action( 'admin_menu', array( &$this, 'lightboxPlusAddPages' ) );
                add_action( 'admin_head', array( &$this, 'lightboxPlusAdminHead' ) );
                add_action( 'admin_footer-'. $plugin_page, array( &$this, 'addscripts' ) );
                add_action( 'admin_footer', array( &$this, 'lightboxPlusAddFooter' ) );
                add_action( 'wp_head', array( &$this, 'lightboxPlusAddHeader' ) );
                add_action( 'wp_footer', array( &$this, 'lightboxPlusAddFooter' ) );
                if ( !empty( $this->lightboxOptions ) ) {
                    $lightboxPlusOptions = $this->getAdminOptions( $this->lightboxOptionsName );
                    $autoLightbox = $lightboxPlusOptions['auto_lightbox'];
                    $lightboxGallery = $lightboxPlusOptions['gallery_lightboxplus'];
                }
                if ( $autoLightbox != 1 ) {
                    if ($lightboxGallery != 1) {
                        add_filter( 'the_content', array( &$this, 'lightboxPlusReplace' ) );
                    }
                    else {
                        remove_shortcode( 'gallery' );
                        add_shortcode( 'gallery', array( &$this, 'lightboxPlusGallery' ), 10);
                        add_filter( 'the_content', array( &$this, 'lightboxPlusReplace' ), 12 );
                    }
                }
                add_action( "init", array( &$this, "addScripts" ) );
            }

            /**
            * Retrieves the options from the database.
            * 
            * @param mixed $optionsName
            */
            function getAdminOptions( $optionsName ) {
                $savedOptions = get_option( $optionsName );
                if ( !empty( $savedOptions ) ) {
                    foreach ( $savedOptions as $key => $option ) {
                        $theOptions[$key] = $option;
                    }
                }
                update_option( $optionsName, $theOptions );
                return $theOptions;
            }

            /**
            * Saves the admin options to the database.
            * 
            * @param mixed $optionsName
            * @param mixed $options
            */
            function saveAdminOptions( $optionsName, $options ) {
                update_option( $optionsName, $options );
            }

            /**
            * Tells WordPress to load the plugin JavaScript files and what library to use
            * 
            */
            function addScripts( ) {
                global $g_lightbox_plus_url;
                wp_enqueue_script('jquery','','','1.4.2',true);
                wp_enqueue_script('jquery-ui-core','','','1.7.1',true);
                wp_enqueue_script('jquery-ui-dialog','','','1.7.1',true);

                wp_enqueue_script( 'lightbox', $g_lightbox_plus_url.'/js/jquery.colorbox-min.js', array( 'jquery' ), '1.3.8', true);
            }

            /**
            * The admin panel funtion
            * handles creating admin panel and processing of form submission
            */
            function lightboxPlusAdminPanel( ) {
                global $g_lightbox_plus_url, $g_lbp_messages;
                load_plugin_textdomain( 'lightboxplus', $path = $g_lightbox_plus_url );
                $location = admin_url('/admin.php?page=lightboxplus');
                // TODO -c Unknown -o Dan Zappone: Not sure what needs done.  Old comment?
                /**
                * Check form submission and update setting
                */
                if ( $_POST['action'] ) {
                    switch ( $_POST['sub'] ) {
                        case 'settings':
                            $detail_code = 0;
                            $lightboxPlusOptions = array(
                            "lightboxplus_style"    => $_POST['lightboxplus_style'],
                            "disable_css"           => $_POST['disable_css'],
                            "lightboxplus_multi"    => $_POST['lightboxplus_multi'],
                            "use_inline"            => $_POST['use_inline'],
                            "inline_num"            => $_POST['inline_num'],

                            "transition"            => $_POST['transition'],
                            "speed"                 => $_POST['speed'],
                            "width"                 => $_POST['width'],
                            "height"                => $_POST['height'],
                            "inner_width"           => $_POST['inner_width'],
                            "inner_height"          => $_POST['inner_height'],
                            "initial_width"         => $_POST['initial_width'],
                            "initial_height"        => $_POST['initial_height'],
                            "max_width"             => $_POST['max_width'],
                            "max_height"            => $_POST['max_height'],
                            "resize"                => $_POST['resize'],
                            "opacity"               => $_POST['opacity'],
                            "preloading"            => $_POST['preloading'],
                            "label_image"           => $_POST['label_image'],
                            "label_of"              => $_POST['label_of'],
                            "previous"              => $_POST['previous'],
                            "next"                  => $_POST['next'],
                            "close"                 => $_POST['close'],
                            "overlay_close"         => $_POST['overlay_close'],
                            "slideshow"             => $_POST['slideshow'],
                            "slideshow_auto"        => $_POST['slideshow_auto'],
                            "slideshow_speed"       => $_POST['slideshow_speed'],
                            "slideshow_start"       => $_POST['slideshow_start'],
                            "slideshow_stop"        => $_POST['slideshow_stop'],
                            "gallery_lightboxplus"  => $_POST['gallery_lightboxplus'],
                            "class_method"          => $_POST['class_method'],
                            "class_name"            => $_POST['class_name'],
                            "auto_lightbox"         => $_POST['auto_lightbox'],
                            "text_links"            => $_POST['text_links'],
                            "display_title"         => $_POST['display_title']
                            );

                            $g_lbp_messages .= __('Primary lightbox settings updated.','lightboxplus').'<br /><br />';

                            if ( $_POST['lightboxplus_multi'] ) {
                                $lightboxPlusSecondaryOptions = array(
                                "transition_sec"        => $_POST['transition_sec'],
                                "speed_sec"             => $_POST['speed_sec'],
                                "width_sec"             => $_POST['width_sec'],
                                "height_sec"            => $_POST['height_sec'],
                                "inner_width_sec"       => $_POST['inner_width_sec'],
                                "inner_height_sec"      => $_POST['inner_height_sec'],
                                "initial_width_sec"     => $_POST['initial_width_sec'],
                                "initial_height_sec"    => $_POST['initial_height_sec'],
                                "max_width_sec"         => $_POST['max_width_sec'],
                                "max_height_sec"        => $_POST['max_height_sec'],
                                "resize_sec"            => $_POST['resize_sec'],
                                "opacity_sec"           => $_POST['opacity_sec'],
                                "preloading_sec"        => $_POST['preloading_sec'],
                                "label_image_sec"       => $_POST['label_image_sec'],
                                "label_of_sec"          => $_POST['label_of_sec'],
                                "previous_sec"          => $_POST['previous_sec'],
                                "next_sec"              => $_POST['next_sec'],
                                "close_sec"             => $_POST['close_sec'],
                                "overlay_close_sec"     => $_POST['overlay_close_sec'],
                                "slideshow_sec"         => $_POST['slideshow_sec'],
                                "slideshow_auto_sec"    => $_POST['slideshow_auto_sec'],
                                "slideshow_speed_sec"   => $_POST['slideshow_speed_sec'],
                                "slideshow_start_sec"   => $_POST['slideshow_start_sec'],
                                "slideshow_stop_sec"    => $_POST['slideshow_stop_sec'],
                                "iframe_sec"            => $_POST['iframe_sec'],
                                "class_method_sec"      => $_POST['class_method_sec'],
                                "class_name_sec"        => $_POST['class_name_sec'],
                                "display_title_sec"     => $_POST['display_title_sec'],
                                );
                                $lightboxPlusOptions = array_merge($lightboxPlusOptions, $lightboxPlusSecondaryOptions);
                                unset($lightboxPlusSecondaryOptions);
                                $g_lbp_messages .= __('Secondary lightbox settings updated.','lightboxplus').'<br /><br />';
                            }

                            if ( $_POST['use_inline'] ) {
                                if (!empty($this->lightboxOptions)) {
                                    $lightboxPlusInlineOptions   = $this->getAdminOptions($this->lightboxOptionsName);
                                }

                                if ($lightboxPlusInlineOptions['use_inline'] && $lightboxPlusInlineOptions['inline_num'] != '') {
                                    $inline_links = array();
                                    $inline_hrefs = array();
                                    $inline_widths = array();
                                    $inline_heights = array();
                                    for ($i = 1; $i <= $lightboxPlusInlineOptions['inline_num']; $i++) {
                                        $inline_links[] = $_POST["inline_link_$i"];
                                        $inline_hrefs[] = $_POST["inline_href_$i"];
                                        $inline_widths[] = $_POST["inline_width_$i"];
                                        $inline_heights[] = $_POST["inline_height_$i"];
                                    }
                                }

                                $lightboxPlusInlineOptions = array(
                                "inline_links"          => $inline_links,
                                "inline_hrefs"          => $inline_hrefs,
                                "inline_widths"         => $inline_widths,
                                "inline_heights"        => $inline_heights
                                );

                                $lightboxPlusOptions = array_merge($lightboxPlusOptions, $lightboxPlusInlineOptions);
                                unset($lightboxPlusInlineOptions);
                                $g_lbp_messages .= __('Inline lightbox settings updated.','lightboxplus').'<br /><br />';
                            }

                            $this->saveAdminOptions($this->lightboxOptionsName, $lightboxPlusOptions);

                            /**
                            * Initialize Secondary Lightbox if enabled
                            */
                            if ( $_POST['lightboxplus_multi'] && !$_POST['class_name_sec'] ) {
                                $this->lightboxPlusSecondaryInit();
                                $g_lbp_messages .= __('Secondary lightbox settings initialized.','lightboxplus').'<br /><br />';
                            }  
                            /**
                            *  Initialize Inline Lightboxes if enabled
                            */
                            if ( $_POST['use_inline'] && !$_POST['inline_link_1'] ) {
                                $this->lightboxPlusInlineInit($_POST['inline_num']);
                                $g_lbp_messages .= __('Inline lightbox settings initialized.','lightboxplus').'<br /><br />';
                            }

                            unset($lightboxPlusOptions);

                            break;
                        case 'reset':
                            if ( !empty( $_POST[reinit_lightboxplus] )) {
                                delete_option( $this->lightboxOptionsName );
                                delete_option( $this->lightboxInitName );
                                delete_option( $this->lightboxStylePathName );
                                $g_lbp_messages .= '<strong>'.__('Lightbox Plus has been reset to default settings.','lightboxplus').'</strong><br /><br />';

                                /**
                                * Used to remove old setting from previous versions of LBP
                                * 
                                * @var string
                                */
                                $pluginPath = ( dirname( __FILE__ ));
                                if ( file_exists( $pluginPath."/images" )) {
                                    $g_lbp_messages .= __('Deleting: ').$pluginPath.'/images . . . '.__('Removed old Lightbox Plus style images.','lightboxplus').'<br /><br />';
                                    $this->delete_directory( $pluginPath."/images/" );
                                } else {
                                    $g_lbp_messages .= __('No images deleted . . . ','lightboxplus').$pluginPath.'/images '.__('already removed','lightboxplus').'<br /><br />';
                                }
                                if ( file_exists( $pluginPath."/js/"."lightbox.js" )) {
                                    $g_lbp_messages .= __('Deleting: ','lightboxplus').$pluginPath.'/js/lightbox.js . . . '.__('Removed old Lightbox Plus JavaScript.','lightboxplus').'<br /><br />';
                                    $this->delete_file( $pluginPath."/js", "lightbox.js" );
                                } else {
                                    $g_lbp_messages .= __('No JavaScript deleted . . . ','lightboxplus').$pluginPath.'/js/lightbox.js '.__('already removed','lightboxplus').'<br /><br />';
                                }
                                $oldStyles = $this->dirList( $pluginPath."/css/" );
                                if ( !empty( $oldStyles )) {
                                    foreach ( $oldStyles as $value ) {
                                        if ( file_exists( $pluginPath."/css/".$value )) {
                                            $g_lbp_messages .= __('Deleting: '.$pluginPath.'/css/'.$value).' . . . <br /><br />';
                                            $this->delete_file( $pluginPath."/css", $value );
                                        }
                                    }
                                    $g_lbp_messages .= __('Removed old Lightbox Plus styles.','lightboxplus').'<br /><br />';
                                }
                                else {
                                    $g_lbp_messages .= __('No styles deleted . . . Old styles already removed','lightboxplus').'<br /><br />';
                                }
                            }

                            /**
                            * Will reinitilize on reload where option lightboxplus_init is null
                            * 
                            * @var wp_lightboxplus
                            */
                            $this->lightboxPlusInit();
                            $g_lbp_messages .= '<strong>'.__('Please check and update your settings before continuing!','lightboxplus').'</strong>';
                            break;
                        default:
                            break;
                    }
                }

                /**
                * Get options to load in form
                */
                if ( !empty( $this->lightboxOptions )) { $lightboxPlusOptions = $this->getAdminOptions( $this->lightboxOptionsName ); }

                /**
                * Check if there are styles
                * 
                * @var mixed
                */
                $stylePath = get_option( 'lightboxplus_style_path' );
                if ( $handle = opendir( $stylePath )) {
                    while ( false !== ( $file = readdir( $handle ))) {
                        if ( $file != "." && $file != ".." && $file != ".DS_Store" ) {
                            $styles[$file] = $stylePath."/".$file."/";
                        }
                    }
                    closedir( $handle );
                }
            ?>
            <div class="wrap" id="lightbox">
                <h2><?php _e( 'Lightbox Plus Options v1.7 (ColorBox v1.3.8)', 'lightboxplus' )?></h2>
                <br style="clear:both;" />
                <?php
                    if ($g_lbp_messages) {
                        echo '<div id="lbp_message" title="'.__('Settings Saved', 'lightboxplus').'" style="display:none">'.$g_lbp_messages.'</div>';
                        echo '<script type="text/javascript">';
                        echo 'jQuery(function() {';
                        echo '  jQuery("#lbp_message").dialog({ buttons: { "Ok": function() { jQuery(this).dialog("close"); } },open: function() { jQuery(".ui-dialog").fadeOut(9000); },resizable:false,width: 480 });';
                        echo '});';
                        echo '</script>';
                    }
                    require('admin/admin-lightbox.php');
                ?>
            </div>
            <script type="text/javascript">
                <!--
                /*          jQuery('.postbox h3').click( function() {
                jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); }
                ); */

                jQuery('.postbox .close-me').each(function() {
                    jQuery(this).addClass("closed");
                });

                jQuery('#lbp_message').each(function() {
                    jQuery(this).fadeOut(5000);
                });

                jQuery('.postbox h3').click( function() {
                    jQuery(this).next('.toggle').slideToggle('fast');
                });

                function toggleVisibility(id) {
                    var elmt = document.getElementById(id);
                    if(elmt.style.display == 'block')
                        elmt.style.display = 'none';
                    else
                        elmt.style.display = 'block';
                }
                //-->
            </script>
            <?php
        }


    } /*---- END CLASS ----*/
} /*---- END CLASS CHECK ----*/


/**
* Instantiate the class
*/
if (class_exists('wp_lightboxplus')) { $wp_lightboxplus = new wp_lightboxplus(); }