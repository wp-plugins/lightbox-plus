<?php
/**
 * @package    Lightbox Plus Colorbox
 * @subpackage class-filters.php
 * @internal   2013.01.16
 * @author     Dan Zappone / 23Systems
 * @version    2.7
 * @$Id: class-filters.php 983793 2014-09-07 19:22:57Z dzappone $
 * @$URL: http://plugins.svn.wordpress.org/lightbox-plus/trunk/classes/class-filters.php $
 */

if ( ! interface_exists( 'LBP_Filters_Interface' ) ) {
	/**
	 * Interface LBP_Filters_SHD_Interface
	 *
	 */
	interface LBP_Filters_Interface {
		/**
		 * @param $content
		 *
		 * @return mixed
		 */
		function lbp_replace_content( $content );

		/**
		 * @param $html_content
		 * @param $unq_id
		 *
		 * @return mixed
		 */
		function lbp_replace( $html_content, $unq_id );
	}
}

if ( ! class_exists( 'LBP_Filters' ) ) {
	/**
	 * Class LBP_Filters_SHD
	 *
	 * @method removeAttr
	 */
	class LBP_Filters extends LBP_Shortcode implements LBP_Filters_Interface {

		/**
		 * Filter to call page parsing
		 *
		 * @param $content
		 *
		 * @return mixed
		 */
		function lbp_replace_content( $content ) {
			return $this->lbp_replace( $content, '' );
		}

		/**
		 * New method to parse page content navigating the dom and replacing found elements with modified HTML to accommodate LBP appropriate HTML
		 *
		 * @param $html_content
		 * @param $unq_id
		 *
		 * @return mixed
		 */
		function lbp_replace( $html_content, $unq_id ) {
			global $post;
			global $g_lbp_base_options;
			global $g_lbp_primary_options;

			$postGroupID    = $post->ID;
			$postGroupTitle = $post->post_title;

			$html = new simple_html_dom();
			$html->load( $html_content, false, false );

			/**
			 * AUTO LIGHTBOX ALL IMAGE LINKS
			 * Find all a elements that have images as their links whether the inner is plain text or an img elemen if *do auto-lightbox text links* is checked
			 */
			switch ( $g_lbp_primary_options['text_links'] ) {
				case 1:
					foreach ( $html->find( 'a[href*=jpg$],a[href*=gif$],a[href*=png$], a[href*=jpeg$], a[href*=bmp$], a[href*=svg$], a[href*=webp$]' ) as $element ) {
						/**
						 * Use Class Method is selected - yes/no
						 */
						switch ( $g_lbp_base_options['output_htmlv'] ) {
							case 1:
								$htmlv_prop = 'data-' . $g_lbp_base_options['data_name'];
								switch ( $g_lbp_primary_options['use_class_method'] ) {
									case 1:
										if ( ! strpos( $element->class, $g_lbp_primary_options['class_name'] ) ) {
											$element->class .= ' ' . $g_lbp_primary_options['class_name'];
											if ( ! $element->$htmlv_prop ) {
												$element->$htmlv_prop = 'lightbox[' . $postGroupID . $unq_id . ']';
											}
										}
										break;
									default:
										if ( ! $element->$htmlv_prop ) {
											$element->$htmlv_prop = 'lightbox[' . $postGroupID . $unq_id . ']';
										}
										break;
								}
								break;
							default:
								switch ( $g_lbp_primary_options['use_class_method'] ) {
									case 1:
										if ( ! strpos( $element->class, $g_lbp_primary_options['class_name'] ) ) {
											$element->class .= ' ' . $g_lbp_primary_options['class_name'];
											if ( ! $element->rel ) {
												$element->rel = 'lightbox[' . $postGroupID . $unq_id . ']';
											}
										}
										break;
									default:
										if ( ! $element->rel ) {
											$element->rel = 'lightbox[' . $postGroupID . $unq_id . ']';
										}
										break;
								}
								break;
						}
						/**
						 * Do Not Display Title is select - yes/no
						 */
						switch ( $g_lbp_primary_options['no_display_title'] ) {
							case 1:
								$element->removeAttr( 'title' );
								break;
							default:
								/**
								 * If title doesn't exist then get a title
								 *
								 * Set to caption title->image->post title by default then set to image title if exists
								 *
								 * If use caption for title try to get the text from the caption - this could be wrong
								 */
								if ( $g_lbp_primary_options['use_caption_title'] ) {
									if ( 'wp-caption-text' == $element->next_sibling()->class ) {
										$element->title = $element->next_sibling()->innertext;
									} elseif ( 'gallery-caption' == $element->parent()->next_sibling()->class ) {
										$element->title = $element->parent()->next_sibling()->innertext;
									}
								} else {
								if ( ! $element->title && $element->first_child() ) {
									if ( $element->first_child()->alt ) {
										$element->title = $element->first_child()->alt;
									} else {
										$element->title = $postGroupTitle;
									}
								}
								}



								break;
						}
					}
					break;
				default:
					/**
					 * DO NOT AUTO LIGHTBOX TEXT LINKS
					 *
					 * Find all a elements that contain img elements if *do not auto lightbox textlinks* is checked
					 */
					foreach ( $html->find( 'a[href*=jpg$],a[href*=gif$],a[href*=png$], a[href*=jpeg$], a[href*=bmp$], a[href*=svg$], a[href*=webp$]' ) as $element ) {
						/**
						 * Generate HTML5 yes/no
						 */
						switch ( $g_lbp_base_options['output_htmlv'] ) {
							case 1:
								$htmlv_prop = 'data-' . $g_lbp_base_options['data_name'];
								switch ( $g_lbp_primary_options['use_class_method'] ) {
									/**
									 * Use Class Method is selected - yes/no
									 */
									case 1:
										if ( ! strpos( $element->parent()->class, $g_lbp_primary_options['class_name'] ) ) {
											$element->parent()->class .= ' ' . $g_lbp_primary_options['class_name'];
											if ( ! $element->parent()->$htmlv_prop ) {
												$element->parent()->$htmlv_prop = 'lightbox[' . $postGroupID . $unq_id . ']';
											}
										}
										break;
									default:
										if ( ! $element->parent()->$htmlv_prop ) {
											$element->parent()->$htmlv_prop = 'lightbox[' . $postGroupID . $unq_id . ']';
										}
										break;
								}
								break;
							default:
								switch ( $g_lbp_primary_options['use_class_method'] ) {
									/**
									 * Use Class Method is selected - yes/no
									 */
									case 1:
										if ( ! strpos( $element->parent()->class, $g_lbp_primary_options['class_name'] ) ) {
											$element->parent()->class .= ' ' . $g_lbp_primary_options['class_name'];
											if ( ! $element->parent()->rel ) {
												$element->parent()->rel = 'lightbox[' . $postGroupID . $unq_id . ']';
											}
										} else {
											$element->parent()->class = $g_lbp_primary_options['class_name'];
											if ( ! $element->parent()->rel ) {
												$element->parent()->rel = 'lightbox[' . $postGroupID . $unq_id . ']';
											}
										}
										break;
									default:
										if ( ! $element->parent()->rel ) {
											$element->parent()->rel = 'lightbox[' . $postGroupID . $unq_id . ']';
										}
										break;
								}
								break;
						}

						/**
						 * Do Not Display Title is selected - yes/no
						 */
						switch ( $g_lbp_primary_options['no_display_title'] ) {
							case 1:
								$element->parent()->removeAttr( 'title' );
								break;
							default:
								/**
								 * If title doesn't exist then get a title
								 *
								 * Set to caption title->image->post title by default then set to image title if exists
								 *
								 * If use caption for title try to get the text from the caption - this could be wrong
								 */
								if ( $g_lbp_primary_options['use_caption_title'] ) {
									if ( $element->find( 'a[href*=jpg$],a[href*=gif$],a[href*=png$], a[href*=jpeg$], a[href*=bmp$], a[href*=svg$], a[href*=webp$]' ) && 'wp-caption-text' == $element->next_sibling()->class ) {
										$element->title = $element->next_sibling()->innertext;
									} elseif ( $element->find( 'a[href*=jpg$],a[href*=gif$],a[href*=png$], a[href*=jpeg$], a[href*=bmp$], a[href*=svg$], a[href*=webp$]' ) && 'gallery-caption' == $element->parent()->next_sibling()->class ) {
										$element->title = $element->parent()->next_sibling()->innertext;
									}
								} else {
									if ( ! $element->parent()->title ) {
										if ( $element->title ) {
											$element->parent()->title = $element->title;
										} else {
											$element->parent()->title = $postGroupTitle;
										}
									}
								}
								break;
						}
					}
					break;
			}

			$content = $html->save();
			$html->clear();
			unset( $html );

			return $content;
		}
	}
}