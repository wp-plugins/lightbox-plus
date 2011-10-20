<?php
    /**
    * @package Lightbox Plus
    * @subpackage filters.class.php
    * @internal 2011.10.03
    * @author Dan Zappone / 23Systems
    * @version 2.4
    */
    if (!class_exists('lbp_filters')) {
        class lbp_filters extends lbp_shortcode {

            /**
            * Filter to call page parsing
            *
            * @param mixed $content
            * @return simple_html_dom
            */
            function filterLightboxPlusReplace( $content ) {
                $lightboxPlusOptions = get_option('lightboxplus_options');
                return $this->lightboxPlusReplace( $content, '' );
            }

            /**
            * New method to parse page content navigating the dom and replacing found elements with modified HTML to acomodate LBP appropriate HTML
            *
            * @param mixed $content
            * @return mixed
            */
            function lightboxPlusReplace( $html_content, $unq_id ) {
                global $post;

                if (!empty($this->lightboxOptions)) {$lightboxPlusOptions   = $this->getAdminOptions($this->lightboxOptionsName);}
                $postGroupID = $post->ID;
                $postGroupTitle = $post->post_title;

                $html = new simple_html_dom();
                $html->load($html_content,false,false);

                /**
                * Find all image links (text and images)
                *
                * If (autolightbox text links) then
                */
                switch ( $lightboxPlusOptions['text_links'] ) {
                    case 1:
                        foreach($html->find('a[href*=jpg$], a[href*=gif$], a[href*=png$], a[href*=jpeg$], a[href*=bmp$]') as $e) {
                            /**
                            * Use Class Method is selected - yes/no
                            */
                            switch ($lightboxPlusOptions['use_class_method']) {
                                case 1:
                                    if ($e->class && $e->class != $lightboxPlusOptions['class_name']) {
                                        $e->class .= ' '.$lightboxPlusOptions['class_name'];
                                        if (!$e->rel) { $e->rel = 'lightbox['.$postGroupID.$unq_id.']'; }
                                    }
                                    else {
                                        $e->class = $lightboxPlusOptions['class_name'];
                                        if (!$e->rel) { $e->rel = 'lightbox['.$postGroupID.$unq_id.']'; }
                                    }
                                    break;
                                default:
                                    if (!$e->rel) { $e->rel = 'lightbox['.$postGroupID.$unq_id.']'; }
                                    break;
                            }

                            /**
                            * Do Not Display Title is select - yes/no
                            */
                            switch ($lightboxPlusOptions['no_display_title']) {
                                case 1:
                                    $e->title = null;
                                    break;
                                default:
                                    /**
                                    * If title doesn't exist then get a title
                                    * Set to caption title->image->post title by default then set to image title is exists
                                    */
                                    if (!$e->title) {
                                        if ($e->first_child()->title) {
                                            $e->title = $e->first_child()->title;
                                        } else {
                                            $e->title = $postGroupTitle;
                                        }
                                    }
                                    /**
                                    * If use caption for title try to get the text from the caption - this could be wrong
                                    */
                                    if ($lightboxPlusOptions['use_caption_title']) {
                                        if ($e->next_sibling()->innertext) { $e->title = $e->next_sibling()->innertext; }
                                    }
                                    break;
                            }
                        }
                        break;
                    default:
                        /**
                        *  find all links with image only else if (do not autolightbox textlinks) then
                        */
                        foreach($html->find('a[href*=jpg$] img, a[href*=gif$] img, a[href*=png$] img, a[href*=jpeg$] img, a[href*=bmp$] img') as $e) {
                            /**
                            * Use Class Method is selected - yes/no
                            */
                            switch ($lightboxPlusOptions['use_class_method']) {
                                case 1:
                                    if ($e->parent()->class && $e->parent()->class != $lightboxPlusOptions['class_name']) {
                                        $e->parent()->class .= ' '.$lightboxPlusOptions['class_name'];
                                        if (!$e->parent()->rel) { $e->parent()->rel = 'lightbox['.$postGroupID.$unq_id.']'; }
                                    }
                                    else {
                                        $e->parent()->class = $lightboxPlusOptions['class_name'];
                                        if (!$e->parent()->rel) { $e->parent()->rel = 'lightbox['.$postGroupID.$unq_id.']'; }
                                    }
                                    break;
                                default:
                                    if (!$e->parent()->rel) { $e->parent()->rel = 'lightbox['.$postGroupID.$unq_id.']'; }
                                    break;
                            }
                            /**
                            * Do Not Display Title is select - yes/no
                            */
                            switch ($lightboxPlusOptions['no_display_title']) {
                                case 1:
                                    $e->parent()->title = null;
                                    break;
                                default:
                                    if (!$e->parent()->title) {
                                        if ($e->title) {
                                            $e->parent()->title = $e->title;
                                        }
                                        else {
                                            $e->parent()->title = $postGroupTitle;
                                        }
                                    }
                                    if ($lightboxPlusOptions['use_caption_title']) {
                                        if ($e->parent()->next_sibling()->innertext) { $e->parent()->title = $e->parent()->next_sibling()->innertext; }
                                    }
                                    break;
                            }
                        }
                        break;
                }

                $content = $html->save();
                $html->clear();
                unset($html);
                return $content;
            }
        }
    }

?>
