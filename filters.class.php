<?php
    if (!class_exists('lbp_filters')) {
        class lbp_filters extends lbp_shortcode {
            /**
            * put your comment there...
            * 
            */
            function getBaseName() {
                return plugin_basename(__FILE__);
            }

            /**
            * put your comment there...
            * 
            * @param mixed $links
            * @param mixed $file
            */

            function RegisterLBPLinks($links, $file) {
                $base = $this->getBaseName();
                if ($file == $base) {
                    $links[] = '<a href="themes.php?page=lightboxplus">' . __('Settings') . '</a>';
                    $links[] = '<a href="http://www.23systems.net/plugins/lightbox-plus/frequently-asked-questions/">' . __('FAQ') . '</a>';
                    $links[] = '<a href="http://www.23systems.net/bbpress/forum/lightbox-plus">' . __('Support') . '</a>';
                    $links[] = '<a href="http://www.23systems.net/donate/">' . __('Donate') . '</a>';
                    $links[] = '<a href="http://twitter.com/23systems">' . __('Follow on Twitter') . '</a>';
                    $links[] = '<a href="http://www.facebook.com/pages/Austin-TX/23Systems-Web-Devsign/94195762502">' . __('Facebook Page') . '</a>';
                }
                return $links;
            }

            /**
            * Parse page content looking for RegEx matches and add modify HTML to acomodate LBP display
            * 
            * @param mixed $content
            * @return mixed
            */
            function lightboxPlusReplace( $content ) {
                global $post;
                if (!empty($this->lightboxOptions)) {
                    $lightboxPlusOptions   = $this->getAdminOptions($this->lightboxOptionsName);
                }
                $postGroupID = $post->ID;
                /*---- Auto-Lightbox Match Patterns ----*/
                $pattern_a[0] = "/<a(.*?)href=('|\")([A-Za-z0-9\/_\.\~\:-]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")([^\>]*?)><img(.*?)title=('|\")(.*?)('|\")([^\>]*?)\/>/i";

                if ( $lightboxPlusOptions['text_links'] ) {
                    $pattern_a[1] = "/<a(.*?)href=('|\")([A-Za-z0-9\/_\.\~\:-]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")([^\>]*?)>/i";
                }
                $pattern_a[2] = "/<a(.*?)href=('|\")([A-Za-z0-9\/_\.\~\:-]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")(.*?)(rel=('|\")lightbox(.*?)('|\"))([ \t\r\n\v\f]*?)((rel=('|\")lightbox(.*?)('|\"))?)([ \t\r\n\v\f]?)([^\>]*?)>/i";
                $pattern_a[3] = "/<a(.*?)href=('|\")([A-Za-z0-9\/_\.\~\:-]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")([^\>]*?)><img(.*?)/i";
                /**
                * Replacement Patterns
                * In case Do Not Display Title is selected
                * Contrary to what the option is called it now does the opposite
                */
                switch ( $lightboxPlusOptions['display_title'] ) {
                    case 1:
                    switch ( $lightboxPlusOptions['class_method'] ) {
                        case 1:
                            $replacement_a[0] = '<a$1href=$2$3$4$5$6 class="'.$lightboxPlusOptions['class_name'].'" rel="lightbox['.$postGroupID.']"><img$7$11/>';
                            break;
                        default:
                            $replacement_a[0] = '<a$1href=$2$3$4$5$6 rel="lightbox['.$postGroupID.']"><img$7$11/>';
                            break;
                    }
                    break;
                    /**
                    * Display title
                    */
                    default:
                    switch ( $lightboxPlusOptions['class_method'] ) {
                        case 1:
                            $replacement_a[0] = '<a$1href=$2$3$4$5$6 title="$9" class="'.$lightboxPlusOptions['class_name'].'" rel="lightbox['.$postGroupID.']"><img$7title=$8$9$10$11/>';
                            break;
                        default:
                            $replacement_a[0] = '<a$1href=$2$3$4$5$6 title="$9" rel="lightbox['.$postGroupID.']"><img$7title=$8$9$10$11/>';
                            break;
                    }
                    break;
                }

                switch ( $lightboxPlusOptions['text_links'] ) {
                    case 1:
                    switch ( $lightboxPlusOptions['class_method'] ) {
                        case 1:
                            $replacement_a[1] = '<a$1href=$2$3$4$5$6 class="'.$lightboxPlusOptions['class_name'].'" rel="lightbox['.$postGroupID.']">';
                            break;
                        default:
                            $replacement_a[1] = '<a$1href=$2$3$4$5$6 rel="lightbox['.$postGroupID.']">';
                            break;
                        default:
                            $replacement_a[1] = '<a$1href=$2$3$4$5$6 rel="lightbox['.$postGroupID.']">';
                            break;
                    }
                }

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
