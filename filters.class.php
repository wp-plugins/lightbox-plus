<?php
    if (!class_exists('lbp_filters')) {
        class lbp_filters extends lbp_shortcode {
            /**
            * Parse page content looking for RegEx matches and replace matched with modified HTML to acomodate LBP appropriate HTML
            * 
            * @param mixed $content
            * @return mixed
            */
            function lightboxPlusReplace( $content ) {
                global $post;
                if (!empty($this->lightboxOptions)) {$lightboxPlusOptions   = $this->getAdminOptions($this->lightboxOptionsName);}
                $postGroupID = $post->ID;
                /**
                * Auto-Lightbox Match Patterns
                * 
                * @var mixed
                */
                $pattern_a[0] = "/<a(.*?)href=('|\")([A-Za-z0-9\/_\.\~\:-]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")([^\>]*?)><img(.*?)title=('|\")(.*?)('|\")([^\>]*?)\/>/i";
                /**
                * Auto-Lightbox Text Links match patterns
                */
                if ( $lightboxPlusOptions['text_links'] ) {
                    $pattern_a[1] = "/<a(.*?)href=('|\")([A-Za-z0-9\/_\.\~\:-]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")([^\>]*?)>/i";
                }
                /**
                * General match patterns
                * 
                * @var mixed
                */
                $pattern_a[2] = "/<a(.*?)href=('|\")([A-Za-z0-9\/_\.\~\:-]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")(.*?)(rel=('|\")lightbox(.*?)('|\"))([ \t\r\n\v\f]*?)((rel=('|\")lightbox(.*?)('|\"))?)([ \t\r\n\v\f]?)([^\>]*?)>/i";
                $pattern_a[3] = "/<a(.*?)href=('|\")([A-Za-z0-9\/_\.\~\:-]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")([^\>]*?)><img(.*?)/i";
                /**
                * Replacement Patterns
                * In case Do Not Display Title is selected
                * Contrary to what the option is called it now does the opposite i.e. switch ( $lightboxPlusOptions['dont_no_display_title'] ) 
                * Option name was not changed to prevent conflicts
                */
                switch ( $lightboxPlusOptions['no_display_title'] ) {
                    case 1:
                    /**
                    * Using class method - yes/no
                    */
                    switch ( $lightboxPlusOptions['use_class_method'] ) {
                        case 1:
                            $replacement_a[0] = '<a$1href=$2$3$4$5$6 class="'.$lightboxPlusOptions['class_name'].'" rel="lightbox['.$postGroupID.']"><img$7$11/>';
                            break;
                        default:
                            $replacement_a[0] = '<a$1href=$2$3$4$5$6 rel="lightbox['.$postGroupID.']"><img$7$11/>';
                            break;
                    }
                    break;
                    /**
                    * Display title replacment patterns
                    * 
                    * Using class method - yes/no
                    */
                    default:
                    switch ( $lightboxPlusOptions['use_class_method'] ) {
                        case 1:
                            $replacement_a[0] = '<a$1href=$2$3$4$5$6 title="$9" class="'.$lightboxPlusOptions['class_name'].'" rel="lightbox['.$postGroupID.']"><img$7title=$8$9$10$11/>';
                            break;
                        default:
                            $replacement_a[0] = '<a$1href=$2$3$4$5$6 title="$9" rel="lightbox['.$postGroupID.']"><img$7title=$8$9$10$11/>';
                            break;
                    }
                    break;
                }

                /**
                * Set replacemnt pattern for auto-lightbox text links
                * 
                * Using class method - yes/no
                */
                switch ( $lightboxPlusOptions['text_links'] ) {
                    case 1:
                    switch ( $lightboxPlusOptions['use_class_method'] ) {
                        case 1:
                            $replacement_a[1] = '<a$1href=$2$3$4$5$6 class="'.$lightboxPlusOptions['class_name'].'" rel="lightbox['.$postGroupID.']">';
                            break;
                        default:
                            $replacement_a[1] = '<a$1href=$2$3$4$5$6 rel="lightbox['.$postGroupID.']">';
                            break;
                    }
                }
                /**
                * Additional replacement patterns
                * 
                * @var mixed
                */
                $replacement_a[2] = '<a$1href=$2$3$4$5$6$7>';
                $replacement_a[3] = '<a$1href=$2$3$4$5$6 rel="lightbox['.$postGroupID.']"><img$7';

                $content = preg_replace( $pattern_a, $replacement_a, $content );

                /**
                * Correct extra title and standardize quotes to double for links
                * 
                * @var mixed
                */
                $pattern_b[0] = "/title='(.*?)'/i";
                $pattern_b[1] = "/href='([A-Za-z0-9\/_\.\~\:-]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)'/i";
                $pattern_b[2] = "/rel=('|\")lightbox(.*?)('|\") rel=('|\")lightbox(.*?)('|\")/i";
                $replacement_b[0] = '';
                $replacement_b[1] = 'href="$1$2"';
                $replacement_b[2] = 'rel=$1lightbox$2$3';
                $content = preg_replace( $pattern_b, $replacement_b, $content );
                return $content;
            }
        }
    }

?>
