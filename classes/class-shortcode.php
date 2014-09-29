<?php
/**
 * @package    Lightbox Plus Colorbox
 * @subpackage class-shortcode.php
 * @internal   2013.01.16
 * @author     Dan Zappone / 23Systems
 * @version    2.7
 * @$Id: class-shortcode.php 983793 2014-09-07 19:22:57Z dzappone $
 * @$URL: http://plugins.svn.wordpress.org/lightbox-plus/trunk/classes/class-shortcode.php $
 */

if ( ! interface_exists( 'LBP_Shortcode_Interface' ) ) {
	interface LBP_Shortcode_Interface {
		/**
		 * @param $attr
		 *
		 * @return mixed
		 */
		function lbp_gallery( $attr );
	}
}

if ( ! class_exists( 'LBP_Shortcode' ) ) {
	class LBP_Shortcode extends LBP_Utilities implements LBP_Shortcode_Interface {
		/**
		 * Replacement shortcode gallery function adds rel="lightbox" or class="cboxModal"
		 * Overrides the default gallery template
		 *
		 * @param $attr
		 *
		 * @return mixed|string|void
		 */
		function lbp_gallery( $attr ) {
			global $post;
			global $g_lbp_base_options;
			global $g_lbp_primary_options;

			$post = get_post();

			static $instance = 0;
			$instance ++;

			if ( ! empty( $attr['ids'] ) ) {
				// 'ids' is explicitly ordered, unless you specify otherwise.
				if ( empty( $attr['orderby'] ) ) {
					$attr['orderby'] = 'post__in';
				}
				$attr['include'] = $attr['ids'];
			}

			// Allow plugins/themes to override the default gallery template.
			$output = apply_filters( 'post_gallery', '', $attr );
			if ( $output != '' ) {
				return $output;
			}

			// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
			if ( isset( $attr['orderby'] ) ) {
				$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
				if ( ! $attr['orderby'] ) {
					unset( $attr['orderby'] );
				}
			}

			extract( shortcode_atts( array(
				'order'      => 'ASC',
				'orderby'    => 'menu_order ID',
				'id'         => $post->ID,
				'itemtag'    => 'dl',
				'icontag'    => 'dt',
				'captiontag' => 'dd',
				'columns'    => 3,
				'size'       => 'thumbnail',
				'include'    => '',
				'exclude'    => ''
			), $attr ) );

			$id = intval( $id );
			if ( 'RAND' == $order ) {
				$orderby = 'none';
			}

			if ( ! empty( $include ) ) {
				$_attachments = get_posts( array( 'include'        => $include,
				                                  'post_status'    => 'inherit',
				                                  'post_type'      => 'attachment',
				                                  'post_mime_type' => 'image',
				                                  'order'          => $order,
				                                  'orderby'        => $orderby
					) );

				$attachments = array();
				foreach ( $_attachments as $key => $val ) {
					$attachments[ $val->ID ] = $_attachments[ $key ];
				}
			} elseif ( ! empty( $exclude ) ) {
				$attachments = get_children( array( 'post_parent'    => $id,
				                                    'exclude'        => $exclude,
				                                    'post_status'    => 'inherit',
				                                    'post_type'      => 'attachment',
				                                    'post_mime_type' => 'image',
				                                    'order'          => $order,
				                                    'orderby'        => $orderby
					) );
			} else {
				$attachments = get_children( array( 'post_parent'    => $id,
				                                    'post_status'    => 'inherit',
				                                    'post_type'      => 'attachment',
				                                    'post_mime_type' => 'image',
				                                    'order'          => $order,
				                                    'orderby'        => $orderby
					) );
			}

			if ( empty( $attachments ) ) {
				return '';
			}

			if ( is_feed() ) {
				$output = "\n";
				foreach ( $attachments as $att_id => $attachment ) {
					$output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
				}

				return $output;
			}

			$itemtag    = tag_escape( $itemtag );
			$captiontag = tag_escape( $captiontag );
			$columns    = intval( $columns );
			$itemwidth  = $columns > 0 ? floor( 100 / $columns ) : 100;
			$float      = is_rtl() ? 'right' : 'left';

			$selector = "gallery-{$instance}";

			$gallery_style = $gallery_div = '';
			if ( apply_filters( 'use_default_gallery_style', true ) ) {
				$gallery_style = "
                    <style type='text/css'>
                    #{$selector} {
                    margin: auto;
                    }
                    #{$selector} .gallery-item {
                    float: {$float};
                    margin-top: 10px;
                    text-align: center;
                    width: {$itemwidth}%;
                    }
                    #{$selector} img {
                    border: 2px solid #cfcfcf;
                    }
                    #{$selector} .gallery-caption {
                    margin-left: 0;
                    }
                    </style>
                    <!-- see gallery_shortcode() in wp-includes/media.php -->";
			}
			$size_class  = sanitize_html_class( $size );
			$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
			$output      = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

			$i = 0;

			/**
			 * TODO: remove next line if not needed
			 */
			$g_lbp_base_options = get_option( 'lightboxplus_base_settings' );
			$g_lbp_primary_options = get_option( 'lightboxplus_primary_settings' );

			foreach ( $attachments as $id => $attachment ) {
				$link = isset( $attr['link'] ) && 'file' == $attr['link'] ? wp_get_attachment_link( $id, $size, false, false ) : wp_get_attachment_link( $id, $size, true, false );

				/**
				 * Rewrite links for wp-gallery to add lightbox plus properties (class or rel=[])
				 *
				 * @var mixed
				 */
				if ( $g_lbp_primary_options['multiple_galleries'] ) {
				} else {
					$link = $this->lbp_replace( $link, '' );
				}
				$output .= "<{$itemtag} class='gallery-item'>";
				$output .= "
                    <{$icontag} class='gallery-icon'>
                    $link
                    </{$icontag}>";
				if ( $captiontag && trim( $attachment->post_excerpt ) ) {
					$output .= "
                        <{$captiontag} class='wp-caption-text gallery-caption'>
                        " . wptexturize( $attachment->post_excerpt ) . "
                        </{$captiontag}>";
				}
				$output .= "</{$itemtag}>";
				if ( $columns > 0 && ++ $i % $columns == 0 ) {
					$output .= '<br style="clear: both" />';
				}
			}

			$output .= "
                <br style='clear: both;' />
                </div>\n";

			return $output;
		}
	}
}