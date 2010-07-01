<?php
    if (!class_exists('lbp_actions')) {
        class lbp_actions extends lbp_filters {
            /**
            * Add new panel to WordPress under the Appearance category
            */
            function lightboxPlusAddPages( ) {
                add_theme_page( "Lightbox Plus", "Lightbox Plus", "manage_options", "lightboxplus", array( &$this, "lightboxPlusAdminPanel" ) );
            }

            /**
            * Add CSS styles to Admin Panel page headers to display lightboxed images
            */
            function lightboxPlusAdminHead( ) {
                global $g_lightbox_plus_url;
                echo '<link rel="stylesheet" type="text/css" href="'.$g_lightbox_plus_url.'/admin/lightbox.admin.css" media="screen" />'.$this->EOL( );
                if ( !empty( $this->lightboxOptions ) ) {

                    $lightboxPlusOptions     = $this->getAdminOptions( $this->lightboxOptionsName );
                    if ( $lightboxPlusOptions['disable_css'] ) {
                        echo "<!-- User set lightbox styles -->".$this->EOL( );
                    } else {
                        $lightboxPlusStyleSheet = '<link rel="stylesheet" type="text/css" href="'.$g_lightbox_plus_url.'/css/'.$lightboxPlusOptions['lightboxplus_style'].'/colorbox.css" media="screen" />'.$this->EOL( );

                        /**
                        * TODO 4 -o Dan Zappone -c filesystem, IE: IE Styles
                        *
                        * Experimental should not be used currently Check for and add conditional IE specific CSS fixes
                        *
                        * @var mixed
                        */
                        /**
                        * $currentStylePath       = get_option( 'lightboxplus_style_path' );
                        * $filename               = $currentStylePath.'/'.$lightboxPlusOptions['lightboxplus_style'].'/colorbox-ie.php';
                        * if ( file_exists( $filename ) ) {
                        *     $lightboxPlusStyleSheet .= '<!--[if IE]>'.$this->EOL( );
                        *     $lightboxPlusStyleSheet .= '     <link type="text/css" media="screen" rel="stylesheet" href="'.$g_lightbox_plus_url.'/css/'.$lightboxPlusOptions['lightboxplus_style'].'/colorbox-ie.php" title="IE fixes" />'.$this->EOL( );
                        *     $lightboxPlusStyleSheet .= '<![endif]-->'.$this->EOL( );
                        * }
                        */
                        echo $lightboxPlusStyleSheet;
                    }
                }
            }

            /**
            * Add JavaScript (jQuery) to page footer to activate LBP
            */
            function lightboxPlusAddFooter( ) {
                global $g_lightbox_plus_url;
                if ( !empty( $this->lightboxOptions ) ) {
                    $lightboxPlusOptions     = $this->getAdminOptions( $this->lightboxOptionsName );
                    $lightboxPlusJavaScript  = "";
                    $lightboxPlusJavaScript .= '<!-- Lightbox Plus v1.7 - 3/24/2010 AM - Message: '.$lightboxPlusOptions['lightboxplus_multi'].'-->'.$this->EOL( );
                    $lightboxPlusJavaScript .= '<script type="text/javascript">'.$this->EOL( );
                    $lightboxPlusJavaScript .= 'jQuery(document).ready(function($){'.$this->EOL( );
                    $lbpArrayPrimary = array();
                    if ( $lightboxPlusOptions['transition'] != 'elastic' ) { $lbpArrayPrimary[] = 'transition:"'.$lightboxPlusOptions['transition'].'"'; }
                    if ( $lightboxPlusOptions['speed'] != '350' ) { $lbpArrayPrimary[] = 'speed:'.$lightboxPlusOptions['speed']; }
                    if ( $lightboxPlusOptions['width'] != 'false' ) { $lbpArrayPrimary[] = 'width:'.$this->setValue( $lightboxPlusOptions['width'] ); }
                    if ( $lightboxPlusOptions['height'] != 'false'  ) { $lbpArrayPrimary[] = 'height:'.$this->setValue( $lightboxPlusOptions['height'] ); }
                    if ( $lightboxPlusOptions['inner_width'] != 'false'  ) { $lbpArrayPrimary[] = 'innerWidth:'.$this->setValue( $lightboxPlusOptions['inner_width'] ); }
                    if ( $lightboxPlusOptions['inner_height'] != 'false'  ) { $lbpArrayPrimary[] = 'innerHeight:'.$this->setValue( $lightboxPlusOptions['inner_height'] ); }
                    if ( $lightboxPlusOptions['initial_width'] != '300'  ) { $lbpArrayPrimary[] =  'initialWidth:'.$this->setValue( $lightboxPlusOptions['initial_width'] ); }
                    if ( $lightboxPlusOptions['initial_height'] != '100'  ) { $lbpArrayPrimary[] = 'initialHeight:'.$this->setValue( $lightboxPlusOptions['initial_height'] ); }
                    if ( $lightboxPlusOptions['max_width'] != 'false'  ) { $lbpArrayPrimary[] = 'maxWidth:'.$this->setValue( $lightboxPlusOptions['max_width'] ); }
                    if ( $lightboxPlusOptions['max_height'] != 'false'  ) { $lbpArrayPrimary[] = 'maxHeight:'.$this->setValue( $lightboxPlusOptions['max_height'] ); }
                    if ( $lightboxPlusOptions['resize'] != '1'  ) { $lbpArrayPrimary[] = 'scalePhotos:'.$this->setBoolean( $lightboxPlusOptions['resize'] ); }
                    if ( $lightboxPlusOptions['opacity'] != '0.85' ) { $lbpArrayPrimary[] = 'opacity:'.$lightboxPlusOptions['opacity']; }
                    if ( $lightboxPlusOptions['preloading'] != '1' ) { $lbpArrayPrimary[] = 'preloading:'.$this->setBoolean( $lightboxPlusOptions['preloading'] ); }
                    if ( $lightboxPlusOptions['label_image'] != 'Image' && $lightboxPlusOptions['label_of'] != 'of' ) { $lbpArrayPrimary[] = 'current:"'.$lightboxPlusOptions['label_image'].' {current} '.$lightboxPlusOptions['label_of'].' {total}"'; }
                    if ( $lightboxPlusOptions['previous'] != 'previous' ) { $lbpArrayPrimary[] = 'previous:"'.$lightboxPlusOptions['previous'].'"'; }
                    if ( $lightboxPlusOptions['next'] != 'next' ) { $lbpArrayPrimary[] = 'next:"'.$lightboxPlusOptions['next'].'"'; }
                    if ( $lightboxPlusOptions['close'] != 'close' ) { $lbpArrayPrimary[] = 'close:"'.$lightboxPlusOptions['close'].'"'; }
                    if ( $lightboxPlusOptions['overlay_close'] != '1' ) { $lbpArrayPrimary[] = 'overlayClose:'.$this->setBoolean( $lightboxPlusOptions['overlay_close'] ); }
                    if ( $lightboxPlusOptions['slideshow'] == '1' ) { $lbpArrayPrimary[] = 'slideshow:'.$this->setBoolean( $lightboxPlusOptions['slideshow'] ); }
                    if ( $lightboxPlusOptions['slideshow'] == '1' ) {
                        if ( $lightboxPlusOptions['slideshow_auto'] ) { $lbpArrayPrimary[] = 'slideshowAuto:'.$this->setBoolean( $lightboxPlusOptions['slideshow_auto'] ); }
                        if ( $lightboxPlusOptions['slideshow_speed'] ) { $lbpArrayPrimary[] = 'slideshowSpeed:'.$lightboxPlusOptions['slideshow_speed']; }
                        if ( $lightboxPlusOptions['slideshow_start' ]) { $lbpArrayPrimary[] = 'slideshowStart:"'.$lightboxPlusOptions['slideshow_start'].'"'; }
                        if ( $lightboxPlusOptions['slideshow_stop'] ) { $lbpArrayPrimary[] =  'slideshowStop:"'.$lightboxPlusOptions['slideshow_stop'].'"'; }
                    }
                    $lightboxPlusFnPrimary = '{'.implode(",", $lbpArrayPrimary).'}';
                    switch ( $lightboxPlusOptions['class_method'] ) {
                        case 1:
                            $lightboxPlusJavaScript .= '  $(".'.$lightboxPlusOptions['class_name'].'").colorbox('.$lightboxPlusFnPrimary.');'.$this->EOL( );
                            break;
                        default:
                            $lightboxPlusJavaScript .= '  $("a[rel*=lightbox]").colorbox('.$lightboxPlusFnPrimary.');'.$this->EOL( );
                            break;
                    }

                    switch ( $lightboxPlusOptions['lightboxplus_multi'] ) {
                        case 1:
                        $lbpArraySecondary = array();
                        if ( $lightboxPlusOptions['transition_sec'] != 'elastic' ) { $lbpArraySecondary[] = 'transition:"'.$lightboxPlusOptions['transition_sec'].'"'; }
                        if ( $lightboxPlusOptions['speed_sec'] != '350' ) { $lbpArraySecondary[] = 'speed:'.$lightboxPlusOptions['speed_sec']; }
                        if ( $lightboxPlusOptions['width_sec'] && $lightboxPlusOptions['width_sec'] != 'false' ) { $lbpArraySecondary[] = 'width:'.$this->setValue( $lightboxPlusOptions['width_sec'] ); }
                        if ( $lightboxPlusOptions['height_sec'] && $lightboxPlusOptions['height_sec'] != 'false' ) { $lbpArraySecondary[] = 'height:'.$this->setValue( $lightboxPlusOptions['height_sec'] ); }
                        if ( $lightboxPlusOptions['inner_width_sec'] && $lightboxPlusOptions['inner_width_sec'] != 'false' ) { $lbpArraySecondary[] = 'innerWidth:'.$this->setValue( $lightboxPlusOptions['inner_width_sec'] ); }
                        if ( $lightboxPlusOptions['inner_height_sec'] && $lightboxPlusOptions['inner_height_sec'] != 'false' ) { $lbpArraySecondary[] = 'innerHeight:'.$this->setValue( $lightboxPlusOptions['inner_height_sec'] ); }
                        if ( $lightboxPlusOptions['initial_width_sec'] && $lightboxPlusOptions['initial_width_sec'] != '300' ) { $lbpArraySecondary[] =  'initialWidth:'.$this->setValue( $lightboxPlusOptions['initial_width_sec'] ); }
                        if ( $lightboxPlusOptions['initial_height_sec'] && $lightboxPlusOptions['initial_height_sec'] != '100' ) { $lbpArraySecondary[] = 'initialHeight:'.$this->setValue( $lightboxPlusOptions['initial_height_sec'] ); }
                        if ( $lightboxPlusOptions['max_width_sec'] && $lightboxPlusOptions['max_width_sec'] != 'false' ) { $lbpArraySecondary[] = 'maxWidth:'.$this->setValue( $lightboxPlusOptions['max_width_sec'] ); }
                        if ( $lightboxPlusOptions['max_height_sec'] && $lightboxPlusOptions['max_height_sec'] != 'false' ) { $lbpArraySecondary[] = 'maxHeight:'.$this->setValue( $lightboxPlusOptions['max_height_sec'] ); }
                        if ( $lightboxPlusOptions['resize_sec'] != '1' ) { $lbpArraySecondary[] = 'scalePhotos:'.$this->setBoolean( $lightboxPlusOptions['resize_sec'] ); }
                        if ( $lightboxPlusOptions['opacity_sec'] != '0.85' ) { $lbpArraySecondary[] = 'opacity:'.$lightboxPlusOptions['opacity_sec']; }
                        if ( $lightboxPlusOptions['preloading_sec'] != '1' ) { $lbpArraySecondary[] = 'preloading:'.$this->setBoolean( $lightboxPlusOptions['preloading_sec'] ); }
                        if ( $lightboxPlusOptions['label_image_sec'] != 'Image' && $lightboxPlusOptions['label_of_sec'] != 'of' ) { $lbpArraySecondary[] = 'current:"'.$lightboxPlusOptions['label_image_sec'].' {current} '.$lightboxPlusOptions['label_of_sec'].' {total}"'; }
                        if ( $lightboxPlusOptions['previous_sec'] != 'previous' ) { $lbpArraySecondary[] = 'previous:"'.$lightboxPlusOptions['previous_sec'].'"'; }
                        if ( $lightboxPlusOptions['next_sec'] != 'next' ) { $lbpArraySecondary[] = 'next:"'.$lightboxPlusOptions['next_sec'].'"'; }
                        if ( $lightboxPlusOptions['close_sec'] != 'close' ) { $lbpArraySecondary[] = 'close:"'.$lightboxPlusOptions['close_sec'].'"'; }
                        if ( $lightboxPlusOptions['overlay_close_sec'] != '1' ) { $lbpArraySecondary[] = 'overlayClose:'.$this->setBoolean( $lightboxPlusOptions['overlay_close_sec'] ); }
                        if ( $lightboxPlusOptions['slideshow_sec'] == '1' ) { $lbpArraySecondary[] = 'slideshow:'.$this->setBoolean( $lightboxPlusOptions['slideshow_sec'] ); }
                        if ( $lightboxPlusOptions['slideshow_sec']== '1' ) {
                            if ( $lightboxPlusOptions['slideshow_auto_sec'] ) { $lbpArraySecondary[] = 'slideshowAuto:'.$this->setBoolean( $lightboxPlusOptions['slideshow_auto_sec'] ); }
                            if ( $lightboxPlusOptions['slideshow_speed_sec'] ) { $lbpArraySecondary[] = 'slideshowSpeed:'.$lightboxPlusOptions['slideshow_speed_sec']; }
                            if ( $lightboxPlusOptions['slideshow_start_sec'] ) { $lbpArraySecondary[] = 'slideshowStart:"'.$lightboxPlusOptions['slideshow_start_sec'].'"'; }
                            if ( $lightboxPlusOptions['slideshow_stop_sec'] ) { $lbpArraySecondary[] =  'slideshowStop:"'.$lightboxPlusOptions['slideshow_stop_sec'].'"'; }
                        }
                        if ( $lightboxPlusOptions['iframe_sec'] != '0' ) { $lbpArraySecondary[] = 'iframe:'.$this->setBoolean( $lightboxPlusOptions['iframe_sec'] ); }
                        $lightboxPlusFnSecondary = '{'.implode(",", $lbpArraySecondary).'}';
                        switch ( $lightboxPlusOptions['class_method_sec'] ) {
                            case 1:
                                $lightboxPlusJavaScript .= '  $(".'.$lightboxPlusOptions['class_name_sec'].'").colorbox('.$lightboxPlusFnSecondary.');'.$this->EOL( );
                                break;
                            default:
                                $lightboxPlusJavaScript .= '  $(".'.$lightboxPlusOptions['class_name_sec'].'").colorbox('.$lightboxPlusFnSecondary.');'.$this->EOL( );
                                break;
                        }
                        break;
                        default:
                            break;
                    }

                    if ($lightboxPlusOptions['use_inline'] && $lightboxPlusOptions['inline_num'] != '') {
                        $inline_links = array();
                        $inline_hrefs = array();
                        $inline_widths = array();
                        $inline_heights = array();
                        for ($i = 1; $i <= $lightboxPlusOptions['inline_num']; $i++) {
                            $inline_links = $lightboxPlusOptions['inline_links'];
                            $inline_hrefs = $lightboxPlusOptions['inline_hrefs'];
                            $inline_widths = $lightboxPlusOptions['inline_widths'];
                            $inline_heights = $lightboxPlusOptions['inline_heights'];
                            $lightboxPlusJavaScript .= '  $(".'.$inline_links[$i - 1].'").colorbox({width:"'.$inline_widths[$i - 1].'", height:'.$this->setValue( $inline_heights[$i - 1] ).', inline:true, href:"#'.$inline_hrefs[$i - 1].'"});'.$this->EOL( );
                        }
                    }

                    $lightboxPlusJavaScript .= '});'.$this->EOL( );
                    $lightboxPlusJavaScript .= '</script>'.$this->EOL( );
                    echo $lightboxPlusJavaScript;
                }
            }

            /**
            * Add CSS styles to site page headers to display lightboxed images
            */
            function lightboxPlusAddHeader( ) {
                global $g_lightbox_plus_url;
                if ( !empty( $this->lightboxOptions ) ) {

                    $lightboxPlusOptions     = $this->getAdminOptions( $this->lightboxOptionsName );
                    if ( $lightboxPlusOptions['disable_css'] ) {
                        echo "<!-- User set lightbox styles -->".$this->EOL( );
                    } else {
                        $lightboxPlusStyleSheet = '<link rel="stylesheet" type="text/css" href="'.$g_lightbox_plus_url.'/css/'.$lightboxPlusOptions['lightboxplus_style'].'/colorbox.css" media="screen" />'.$this->EOL( );
                        /**
                        * TODO 4 -o Dan Zappone -c filesystem, IE: IE Styles
                        *
                        * Experimental should not be used currently Check for and add conditional IE specific CSS fixes
                        *
                        * @var mixed
                        */
                        /* $currentStylePath       = get_option( 'lightboxplus_style_path' );
                        * $filename               = $currentStylePath.'/'.$lightboxPlusOptions['lightboxplus_style'].'/colorbox-ie.php';
                        * if ( file_exists( $filename ) ) {
                        *     $lightboxPlusStyleSheet .= '<!--[if IE]>'.$this->EOL( );
                        *     $lightboxPlusStyleSheet .= '     <link type="text/css" media="screen" rel="stylesheet" href="'.$g_lightbox_plus_url.'/css/'.$lightboxPlusOptions['lightboxplus_style'].'/colorbox-ie.php" title="IE fixes" />'.$this->EOL( );
                        *     $lightboxPlusStyleSheet .= '<![endif]-->'.$this->EOL( );
                        * }
                        */
                        echo $lightboxPlusStyleSheet;
                    }
                }
            }

            /**
            * Tell WordPress to load jquery and jquery-colorbox-min.js in the front end and the admin panel
            */
            function lightboxPlusAddScripts( ) {
                global $g_lightbox_plus_url;
                wp_enqueue_script('jquery','','','1.4.2',true);
                /**
                * Tells WordPress to load the jquery, jquery-ui-core and jquery-ui-dialog in the admin panel
                */
                if (is_admin()) {
                    wp_enqueue_script('jquery-ui-core','','','1.8',true);
                    wp_enqueue_script('jquery-ui-dialog','','','1.8',true);
                }
                wp_enqueue_script( 'lightbox', $g_lightbox_plus_url.'/js/jquery.colorbox-min.js', array( 'jquery' ), '1.3.8', true);
            }

        }
    }
?>
