<?php
    if (!class_exists('lbp_init')) {
        class lbp_init extends lbp_actions {
            /**
            * Add some default options if they don't exist or if reinitialized
            * 
            */
            function lightboxPlusInit( ) {
                global $g_lightbox_plus_url;
                delete_option( $this->lightboxOptionsName );
                delete_option( $this->lightboxInitName );
                delete_option( $this->lightboxStylePathName );

                /**
                * If Lightbox Plus has been initialized - set to true
                * 
                * @var wp_lightboxplus
                */
                $this->saveAdminOptions( $this->lightboxInitName, true );

                /**
                * Where the default styles aew located
                * 
                * @var mixed
                *
                * TODO 4 -c filesystem -o Dan Zappone: Add path outside for user generatoed styles ~version 2.1
                */
                $stylePath = ( dirname( __FILE__ )."/css" );
                $this->saveAdminOptions( $this->lightboxStylePathName, $stylePath );

                /**
                * Call Initialize Primary Lightbox
                * 
                * @var wp_lightboxplus
                */
                $this->lightboxPlusPrimaryInit();
                /**
                * Call Initialize Secondary Lightbox if enabled
                * 
                * @var wp_lightboxplus
                */
                $this->lightboxPlusSecondaryInit();
                /**
                * Call Initialize Inline Lightboxes if enabled
                * 
                * @var wp_lightboxplus
                */
                $this->lightboxPlusInlineInit(1);

                return $lightboxPlusOptions;
            }

            /**
            * Initialize Primary Lightbox by buiding array of options and committing to database
            */
            function lightboxPlusPrimaryInit() {
                $lightboxPlusPrimaryOptions = array(
                "lightboxplus_style"    => 'shadowed',
                "lightboxplus_multi"    => '0',
                "disable_css"           => '0',
                "use_inline"            => '0',
                "inline_num"            => '1',

                "transition"            => 'elastic',
                "speed"                 => '350',
                "width"                 => 'false',
                "height"                => 'false',
                "inner_width"           => 'false',
                "inner_height"          => 'false',
                "initial_width"         => '300',
                "initial_height"        => '100',
                "max_width"             => 'false',
                "max_height"            => 'false',
                "resize"                => '1',
                "opacity"               => '0.8',
                "preloading"            => '1',
                "label_image"           => 'Image',
                "label_of"              => 'of',
                "previous"              => 'previous',
                "next"                  => 'next',
                "close"                 => 'close',
                "overlay_close"         => '1',
                "slideshow"             => '0',
                "slideshow_auto"        => '1',
                "slideshow_speed"       => '2500',
                "slideshow_start"       => 'start',
                "slideshow_stop"        => 'stop',
                "gallery_lightboxplus"  => '0',
                "use_class_method"          => '0',
                "class_name"            => 'cboxModal',
                "no_auto_lightbox"      => '0',
                "text_links"            => '0',
                "no_display_title"         => '0'
                );

                $this->saveAdminOptions( $this->lightboxOptionsName, $lightboxPlusPrimaryOptions );
                unset($lightboxPlusPrimaryOptions);
            }

            /**
            * Initialize Secondary Lightbox by buiding array of options and committing to database
            */
            function lightboxPlusSecondaryInit() {
                if ( !empty( $this->lightboxOptions )) { $lightboxPlusOptions = $this->getAdminOptions( $this->lightboxOptionsName ); }

                $lightboxPlusSecondaryOptions = array(
                "transition_sec"        => 'elastic',
                "speed_sec"             => '350',
                "width_sec"             => 'false',
                "height_sec"            => 'false',
                "inner_width_sec"       => '50%',
                "inner_height_sec"      => '50%',
                "initial_width_sec"     => '300',
                "initial_height_sec"    => '100',
                "max_width_sec"         => 'false',
                "max_height_sec"        => 'false',
                "resize_sec"            => '1',
                "opacity_sec"           => '0.8',
                "preloading_sec"        => '1',
                "label_image_sec"       => 'Image',
                "label_of_sec"          => 'of',
                "previous_sec"          => 'previous',
                "next_sec"              => 'next',
                "close_sec"             => 'close',
                "overlay_close_sec"     => '1',
                "slideshow_sec"         => '0',
                "slideshow_auto_sec"    => '1',
                "slideshow_speed_sec"   => '2500',
                "slideshow_start_sec"   => 'start',
                "slideshow_stop_sec"    => 'stop',
                "iframe_sec"            => '1',
                "use_class_method_sec"      => '0',
                "class_name_sec"        => 'lbpModal',
                "no_display_title_sec"     => '0'
                );

                $lightboxPlusOptions = array_merge($lightboxPlusOptions, $lightboxPlusSecondaryOptions);
                $this->saveAdminOptions( $this->lightboxOptionsName, $lightboxPlusOptions );

                unset($lightboxPlusSecondaryOptions);
                unset($lightboxPlusOptions);
            }

            /**
            * Initialize Inline Lightbox by buiding array of options and committing to database
            * 
            * @param mixed $inline_number
            */
            function lightboxPlusInlineInit( $inline_number ) {
                if ( !empty( $this->lightboxOptions )) { $lightboxPlusOptions = $this->getAdminOptions( $this->lightboxOptionsName ); }

                if ($lightboxPlusOptions['use_inline'] && $inline_number != '') {
                    $inline_links = array();
                    $inline_hrefs = array();
                    $inline_widths = array();
                    $inline_heights = array();
                    for ($i = 1; $i <= $inline_number; $i++) {
                        $inline_links[] = 'lbp-inline-link-'.$i;
                        $inline_hrefs[] = 'lbp-inline-href-'.$i;
                        $inline_widths[] = '50%';
                        $inline_heights[] = '50%';
                    }
                }

                $lightboxPlusInlineOptions = array(
                "inline_links"          => $inline_links,
                "inline_hrefs"          => $inline_hrefs,
                "inline_widths"         => $inline_widths,
                "inline_heights"        => $inline_heights
                );

                $lightboxPlusOptions = array_merge($lightboxPlusOptions, $lightboxPlusInlineOptions);
                $this->saveAdminOptions( $this->lightboxOptionsName, $lightboxPlusOptions );
                unset($lightboxPlusInlineOptions);
                unset($lightboxPlusOptions);
            }


        }
    }
?>
