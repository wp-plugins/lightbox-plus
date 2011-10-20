<?php
	/**
	* Lightbox Plus 2.4 - 2011.10.03 
	*/
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
				* Call Initialize Primary Lightbox
				* Call Initialize Secondary Lightbox if enabled
				* Call Initialize Inline Lightboxes if enabled
				*
				* @var wp_lightboxplus
				*/
				$lightboxPlusPrimaryOptions = $this->lightboxPlusPrimaryInit();
				$lightboxPlusSecondaryOptions = $this->lightboxPlusSecondaryInit();
				$lightboxPlusInlineOptions = $this->lightboxPlusInlineInit();

				$lightboxPlusOptions = array_merge($lightboxPlusPrimaryOptions, $lightboxPlusSecondaryOptions, $lightboxPlusInlineOptions);

				/**
				* Saved options and then get them out of the db to see if they are actually there
				*/
				update_option('lightboxplus_options', $lightboxPlusOptions);
				$savedOptions = get_option('lightboxplus_options');

				/**
				* If Lightbox Plus has been initialized - set to true
				*/
				if ($savedOptions) { update_option('lightboxplus_init', true); }

				return $savedOptions;
			}

			/**
			* Initialize Primary Lightbox by buiding array of options and committing to database
			*/
			function lightboxPlusPrimaryInit() {

				$lightboxPlusPrimaryOptions = array(
				"use_perpage"           => '0',
				"lightboxplus_style"    => 'shadowed',
				"use_custom_style"      => '0',
				"lightboxplus_multi"    => '0',
				"disable_css"           => '0',
				"use_inline"            => '0',
				"inline_num"            => '1',
				"transition"            => 'elastic',
				"speed"                 => '300',
				"width"                 => '90%',
				"height"                => '90%',
				"inner_width"           => 'false',
				"inner_height"          => 'false',
				"initial_width"         => '600',
				"initial_height"        => '450',
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
				"slideshow_auto"        => '0',
				"slideshow_speed"       => '2500',
				"slideshow_start"       => 'start',
				"slideshow_stop"        => 'stop',
				"use_caption_title"     => '0',
				"gallery_lightboxplus"  => '0',
				"multiple_galleries"    => '0',
				"use_class_method"      => '0',
				"class_name"            => 'cboxModal',
				"no_auto_lightbox"      => '0',
				"text_links"            => '0',
				"no_display_title"      => '0',
				"scalePhotos"           => '1',
				"scrolling"             => '0',
				"photo"                 => '0',
				"title"                 => '0',
				"rel"                   => '0',
				"open"                  => '0',
				"returnFocus"           => '1',
				"loop"                  => '1',
				"overlayClose"          => '1',        
				"escKey"                => '1',
				"arrowKey"              => '1',
				"top"                   => '0',
				"bottom"                => '0',
				"left"                  => '0',
				"right"                 => '0',
				"fixed"                 => '0'
				);



				return $lightboxPlusPrimaryOptions;
				unset($lightboxPlusPrimaryOptions);
			}

			/**
			* Initialize Secondary Lightbox by buiding array of options and returning
			*
			* @return array $lightboxPlusSecondaryOptions
			*/
			function lightboxPlusSecondaryInit() {
				$lightboxPlusOptions = get_option('lightboxplus_options');

				$lightboxPlusSecondaryOptions = array(
				"transition_sec"        => 'elastic',
				"speed_sec"             => '300',
				"width_sec"             => 'false',
				"height_sec"            => 'false',
				"inner_width_sec"       => '50%',
				"inner_height_sec"      => '50%',
				"initial_width_sec"     => '600',
				"initial_height_sec"    => '450',
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
				"use_class_method_sec"  => '0',
				"class_name_sec"        => 'lbpModal',
				"no_display_title_sec"  => '0',
				"scale_photos_sec"      => '1',
				"scrolling_sec"         => '0',
				"photo_sec"             => '0',
				"title_sec"             => '0',
				"rel_sec"               => '0',
				"open_sec"              => '0',
				"returnFocus_sec"       => '1',
				"loop_sec"              => '1',
				"overlayClose_sec"      => '1',        
				"escKey_sec"            => '1',
				"arrowKey_sec"          => '1',
				"top_sec"               => '0',
				"bottom_sec"            => '0',
				"left_sec"              => '0',
				"right_sec"             => '0',
				"fixed_sec"             => '0',
				"fastIframe_sec"        => '1'
				);

				if ( !empty($lightboxPlusOptions) ) {
					$lightboxPlusOptions = array_merge($lightboxPlusOptions, $lightboxPlusSecondaryOptions);
					update_option('lightboxplus_options', $lightboxPlusOptions );
					unset($lightboxPlusOptions);
				}
				
				return $lightboxPlusSecondaryOptions;
				unset($lightboxPlusSecondaryOptions);
			}

			/**
			* Initialize Inline Lightbox by buiding array of options and committing to database
			*
			* @param mixed $inline_number
			*
			* @return array $lightboxPlusInlineOptions
			*/
			function lightboxPlusInlineInit( $inline_number = 2 ) {
				$lightboxPlusOptions = get_option('lightboxplus_options');

				if ($lightboxPlusOptions['use_inline'] && $inline_number != '') {
					$inline_links            = array();
					$inline_hrefs            = array();
					$inline_widths           = array();
					$inline_heights          = array();
					$inline_inner_widths     = array();
					$inline_inner_heights    = array();
					$inline_max_widths       = array();
					$inline_max_heights      = array();
					$inline_position_tops    = array();
					$inline_position_rights  = array();
					$inline_position_bottoms = array();
					$inline_position_lefts   = array();
					$inline_position_fixeds  = array();
					$inline_opacitys         = array();
					for ($i = 1; $i <= $inline_number; $i++) {
						$inline_links[]            = 'lbp-inline-link-'.$i;
						$inline_hrefs[]            = 'lbp-inline-href-'.$i;
						$inline_widths[]           = '80%';
						$inline_heights[]          = '80%';
						$inline_inner_widths[]     = 'false';
						$inline_inner_heights[]    = 'false';
						$inline_max_widths[]       = '80%';
						$inline_max_heights[]      = '80%';
						$inline_position_tops[]    = '';
						$inline_position_rights[]  = '';
						$inline_position_bottoms[] = '';
						$inline_position_lefts[]   = '';
						$inline_position_fixeds[]  = '0';
						$inline_opacitys[]         = '80%';
					}
				}

				$lightboxPlusInlineOptions = array(
				"inline_links"     => $inline_links,
				"inline_hrefs"     => $inline_hrefs,
				"inline_widths"    => $inline_widths,
				"inline_heights"   => $inline_heights
				/**
				* TODO: Add inititialization for inline lightbox base on array above
				*/
				);


				if ( !empty($lightboxPlusOptions)) {
					$lightboxPlusOptions = array_merge($lightboxPlusOptions, $lightboxPlusInlineOptions);
					update_option('lightboxplus_options', $lightboxPlusOptions );
					unset($lightboxPlusOptions);
				}

				return $lightboxPlusInlineOptions;
				unset($lightboxPlusInlineOptions);

			}

			/**
			* Initialize the external style directory
			*
			* @return boolean
			*/
			function lightboxPlusGlobalStylesinit() {
				global $g_lbp_local_style_path, $g_lbp_global_style_path;
				$dir_create = mkdir($g_lbp_global_style_path, 0755);
				if ($dir_create) {
					$this->copy_directory($g_lbp_local_style_path,$g_lbp_global_style_path.'/');
					return true;
				}
				else {
					return false;
				}

			}


		}
	}
?>
