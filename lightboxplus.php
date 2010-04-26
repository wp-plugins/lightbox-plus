<?php
/*
Plugin Name: Lightbox Plus
Plugin URI: http://www.23systems.net/plugins/lightbox-plus/
Description: Lightbox Plus implements ColorBox as a lightbox image overlay tool for WordPress.  <a href="http://colorpowered.com/colorbox/">ColorBox</a> was created by Jack Moore of Color Powered and is licensed under the <a href="http://www.opensource.org/licenses/mit-license.php">MIT License</a>.
Author: Dan Zappone
Author URI: http://www.23systems.net/
Version: 1.6.9.7
*/
/*---- 8/30/2009 9:30:03 AM ----*/
global $post, $content;  // WordPress Globals
global $g_lightbox_plus_url;
global $g_lbp_messages;
$g_lbp_messages = '';
$g_lightbox_plus_url = WP_PLUGIN_URL.'/lightbox-plus';
load_plugin_textdomain('lightboxplus', $path = $g_lightbox_plus_url);

if (!function_exists("lightboxPlusReload")) {
	function lightboxPlusReload($update,$detail) {
/*		$location = admin_url('/themes.php?page=lightboxplus');
		echo '<script type="text/javascript">'."\r\n";
		echo '<!--'."\r\n";
  	echo 'window.location="'.$location.'&updated='.$update.'&detail='.$detail.'"'."\r\n";
  	echo '//-->'."\r\n";
   	echo '</script>'."\r\n"; */
  }
}

if (!class_exists('wp_lightboxplus')) {

  class wp_lightboxplus {

    /*---- The name the options are saved under in the database ----*/
    var $lightboxOptionsName   = 'lightboxplus_options';
    var $lightboxInitName      = 'lightboxplus_init';
    var $lightboxStylePathName = 'lightboxplus_style_path';

    /*---- The PHP 4 Compatible Constructor ----*/
    function wp_lightboxplus( ) {
      $this->__construct( );
    }

    /*---- The PHP 5 Constructor ----*/
    function __construct( ) {
      $this->lightboxOptions = $this->getAdminOptions( $this->lightboxOptionsName );
      $this->lightboxInit = get_option( $this->lightboxInitName );
      if ( !$this->lightboxInit ) {
        $this->lightboxPlusInit( );
      }
		  add_filter( 'plugin_row_meta',array( &$this, 'RegisterLBPLinks'),10,2);
      add_action( 'admin_menu', array( &$this, 'lightboxPlusAddPages' ) );
      add_action( 'admin_head', array( &$this, 'lightboxPlusAdminHead' ) );
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

    /*---- Retrieves the options from the database.  @return array ----*/
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

    /*---- Saves the admin options to the database. ----*/
    function saveAdminOptions( $optionsName, $options ) {
      update_option( $optionsName, $options );
    }

    /*---- Tells WordPress to load the plugin JavaScript files and what library to use ----*/
    function addScripts( ) {
      global $g_lightbox_plus_url;
      wp_enqueue_script('jquery','','','1.3.6',true);
	    wp_enqueue_script('jquery-ui-core','','','1.7.1',true);
	    wp_enqueue_script('jquery-ui-dialog','','','1.7.1',true);

      wp_enqueue_script( 'lightbox', $g_lightbox_plus_url.'/js/jquery.colorbox-min.js', array( 'jquery' ), '1.3.6', true);
    }

    function getBaseName() {
		  return plugin_basename(__FILE__);
	  }

    function RegisterLBPLinks($links, $file) {
    	$base = wp_lightboxplus::getBaseName();
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

    /*---- Parse page content looking for RegEx matches and add modify HTML to acomodate LBP display ----*/
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
      /*---- Replacement Patterns ---*/
      /*---- In case Do Not Display Title is selected ----*/
      /*---- Contrary to what the option is called it now does the opposite ----*/
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
        /*---- Display title ----*/
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
      /*---- Correct extra title and standardize quotes to double for links ---*/
      $pattern_b[0] = "/title='(.*?)'/i";
      $pattern_b[1] = "/href='([A-Za-z0-9\/_\.\~\:-]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)'/i";
      $pattern_b[2] = "/rel=('|\")lightbox(.*?)('|\") rel=('|\")lightbox(.*?)('|\")/i";
      $replacement_b[0] = '';
      $replacement_b[1] = 'href="$1$2"';
      $replacement_b[2] = 'rel=$1lightbox$2$3';
      $content = preg_replace( $pattern_b, $replacement_b, $content );
      return $content;
    }

    /*---- Add CSS styles to page header to activate LBP ----*/
    function lightboxPlusAddHeader( ) {
      global $g_lightbox_plus_url;
      if ( !empty( $this->lightboxOptions ) ) {

        $lightboxPlusOptions     = $this->getAdminOptions( $this->lightboxOptionsName );
        if ( $lightboxPlusOptions['disable_css'] ) {
          echo "<!-- User set lightbox styles -->".$this->EOL( );
        } else {
          $lightboxPlusStyleSheet = '<link rel="stylesheet" type="text/css" href="'.$g_lightbox_plus_url.'/css/'.$lightboxPlusOptions['lightboxplus_style'].'/colorbox.css" media="screen" />'.$this->EOL( );

          /*---- Check for and add conditional IE specific CSS fixes ----*/
          $currentStylePath       = get_option( 'lightboxplus_style_path' );
          $filename               = $currentStylePath.'/'.$lightboxPlusOptions['lightboxplus_style'].'/colorbox-ie.php';
          if ( file_exists( $filename ) ) {
            $lightboxPlusStyleSheet .= '<!--[if IE]>'.$this->EOL( );
            $lightboxPlusStyleSheet .= '     <link type="text/css" media="screen" rel="stylesheet" href="'.$g_lightbox_plus_url.'/css/'.$lightboxPlusOptions['lightboxplus_style'].'/colorbox-ie.php" title="IE fixes" />'.$this->EOL( );
            $lightboxPlusStyleSheet .= '<![endif]-->'.$this->EOL( );
          }
          echo $lightboxPlusStyleSheet;
        }
      }
    }

    /*---- Add JavaScript (jQuery) to page footer to activate LBP ----*/
    function lightboxPlusAddFooter( ) {
      global $g_lightbox_plus_url;
      if ( !empty( $this->lightboxOptions ) ) {
        $lightboxPlusOptions     = $this->getAdminOptions( $this->lightboxOptionsName );
        $lightboxPlusJavaScript  = "";
        $lightboxPlusJavaScript .= '<!-- Lightbox Plus v1.6.9.7 - 3/24/2010 AM - Message: '.$lightboxPlusOptions['lightboxplus_multi'].'-->'.$this->EOL( );
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

    /*---- Replacement shortcode gallery function adds rel="lightbox" or class="cboxModal" ----*/
    function lightboxPlusGallery($attr) {
    	global $post;

    	static $instance = 0;
    	$instance++;

    	// Allow plugins/themes to override the default gallery template.
    	$output = apply_filters('post_gallery', '', $attr);
    	if ( $output != '' )
    		return $output;

    	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    	if ( isset( $attr['orderby'] ) ) {
    		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
    		if ( !$attr['orderby'] )
    			unset( $attr['orderby'] );
    	}

    	extract(shortcode_atts(array(
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
    	), $attr));

    	$id = intval($id);

      if ( 'RAND' == $order )
		  $orderby = 'none';

      if ( !empty($include) ) {
      	$include = preg_replace( '/[^0-9,]+/', '', $include );
      	$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

      	$attachments = array();
      	foreach ( $_attachments as $key => $val ) {
      		$attachments[$val->ID] = $_attachments[$key];
      	}
      }
      elseif ( !empty($exclude) ) {
        $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
      }
      else
      {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
      }

    	if ( empty($attachments) )
    		return '';

    	if ( is_feed() ) {
    		$output = "\n";
    		foreach ( $attachments as $att_id => $attachment )
    			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
    		return $output;
    	}

    	$itemtag = tag_escape($itemtag);
    	$captiontag = tag_escape($captiontag);
    	$columns = intval($columns);
    	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;

    	$selector = "gallery-{$instance}";

    	$output = apply_filters('gallery_style', "
    		<style type='text/css'>
    			#{$selector} {
    				margin: auto;
    			}
    			#{$selector} .gallery-item {
    				float: left;
    				margin-top: 10px;
    				text-align: center;
    				width: {$itemwidth}%;			}
    			#{$selector} img {
    				border: 2px solid #cfcfcf;
    			}
    			#{$selector} .gallery-caption {
    				margin-left: 0;
    			}
    		</style>
    		<!-- see gallery_shortcode() in wp-includes/media.php -->
    		<div id='$selector' class='gallery galleryid-{$id}'>");

    	$i = 0;
    	foreach ( $attachments as $id => $attachment ) {
    		$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);

        $link = $this->lightboxPlusReplace($link);

    		$output .= "<{$itemtag} class='gallery-item'>";
    		$output .= "
    			<{$icontag} class='gallery-icon'>
    				$link
    			</{$icontag}>";
    		if ( $captiontag && trim($attachment->post_excerpt) ) {
    			$output .= "
    				<{$captiontag} class='gallery-caption'>
    				" . wptexturize($attachment->post_excerpt) . "
    				</{$captiontag}>";
    		}
    		$output .= "</{$itemtag}>";
    		if ( $columns > 0 && ++$i % $columns == 0 )
    			$output .= '<br style="clear: both" />';
    	}

    	$output .= "
    			<br style='clear: both;' />
    		</div>\n";

    	return $output;
    }

    /*---- Add some default options if they don't exist or if reinitialized ----*/
    function lightboxPlusInit( ) {
      global $g_lightbox_plus_url;
      delete_option( $this->lightboxOptionsName );
      delete_option( $this->lightboxInitName );
      delete_option( $this->lightboxStylePathName );

      /*-- If Lightbox Plus has been initialized - set to true --*/
      $this->saveAdminOptions( $this->lightboxInitName, true );

//      $this->saveAdminOptions( $this->lightboxOptionsName, $lightboxPlusOptions );

      /*---- Where the default styles aew located ----*/
      $stylePath = ( dirname( __FILE__ )."/css" );
      $this->saveAdminOptions( $this->lightboxStylePathName, $stylePath );

      $this->lightboxPlusPrimaryInit(); /*--- Initialize Primary Lightbox ---*/

      $this->lightboxPlusSecondaryInit(); /*--- Initialize Secondary Lightbox if activated ---*/
      $this->lightboxPlusInlineInit(1);  /*--- Initialize Inline Lightboxes if activated ---*/

//      $lightboxPlusOptions = array_merge($lbpPrimary, $lbpSecondary);
//      $lightboxPlusOptions = array_merge($lightboxPlusOptions, $lbpInline);

      return $lightboxPlusOptions;
    }

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
        "class_method"          => '0',
        "class_name"            => 'cboxModal',
        "auto_lightbox"         => '0',
        "text_links"            => '0',
        "display_title"         => '0'
      );

      $this->saveAdminOptions( $this->lightboxOptionsName, $lightboxPlusPrimaryOptions );
//      return $lightboxPlusPrimaryOptions;
      unset($lightboxPlusPrimaryOptions);
    }

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
        "class_method_sec"      => '0',
        "class_name_sec"        => 'lbpModal',
        "display_title_sec"     => '0'
      );

      $lightboxPlusOptions = array_merge($lightboxPlusOptions, $lightboxPlusSecondaryOptions);
      $this->saveAdminOptions( $this->lightboxOptionsName, $lightboxPlusOptions );
//      return $lightboxPlusSecondaryOptions;
      unset($lightboxPlusSecondaryOptions);
      unset($lightboxPlusOptions);
    }

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
//      return $lightboxPlusInlineOptions;
      unset($lightboxPlusInlineOptions);
      unset($lightboxPlusOptions);
    }

    /*---- Add styles to Admin Panel ----*/
    function lightboxPlusAdminHead( ) {
      global $g_lightbox_plus_url;
      echo '<link rel="stylesheet" type="text/css" href="'.$g_lightbox_plus_url.'/admin/admin.css" media="screen" />'.$this->EOL( );
      if ( !empty( $this->lightboxOptions ) ) {

        $lightboxPlusOptions     = $this->getAdminOptions( $this->lightboxOptionsName );
        if ( $lightboxPlusOptions['disable_css'] ) {
          echo "<!-- User set lightbox styles -->".$this->EOL( );
        } else {
          $lightboxPlusStyleSheet = '<link rel="stylesheet" type="text/css" href="'.$g_lightbox_plus_url.'/css/'.$lightboxPlusOptions['lightboxplus_style'].'/colorbox.css" media="screen" />'.$this->EOL( );

          /*---- Check for and add conditional IE specific CSS fixes ----*/
          $currentStylePath       = get_option( 'lightboxplus_style_path' );
          $filename               = $currentStylePath.'/'.$lightboxPlusOptions['lightboxplus_style'].'/colorbox-ie.php';
          if ( file_exists( $filename ) ) {
            $lightboxPlusStyleSheet .= '<!--[if IE]>'.$this->EOL( );
            $lightboxPlusStyleSheet .= '     <link type="text/css" media="screen" rel="stylesheet" href="'.$g_lightbox_plus_url.'/css/'.$lightboxPlusOptions['lightboxplus_style'].'/colorbox-ie.php" title="IE fixes" />'.$this->EOL( );
            $lightboxPlusStyleSheet .= '<![endif]-->'.$this->EOL( );
          }
          echo $lightboxPlusStyleSheet;
        }
      }
    }
// FIXME
    /*---- Add new panel to WordPress under the Appearance category ----*/
    function lightboxPlusAddPages( ) {
      add_submenu_page( 'themes.php', "Lightbox Plus", "Lightbox Plus", 10, "lightboxplus", array( &$this, "lightboxPlusAdminPanel" ) );
    }

    /*---- The admin panel funtion - handles creating admin panel and processing of form submission ----*/
    function lightboxPlusAdminPanel( ) {
      global $g_lightbox_plus_url, $g_lbp_messages;
      load_plugin_textdomain( 'lightboxplus', $path = $g_lightbox_plus_url );
      $location = admin_url('/admin.php?page=lightboxplus');
// TODO
      /*---- check form submission and update setting ----*/
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

            if ( $_POST['lightboxplus_multi'] && !$_POST['class_name_sec'] ) {
              $this->lightboxPlusSecondaryInit();
              $g_lbp_messages .= __('Secondary lightbox settings initialized.','lightboxplus').'<br /><br />';
            }  /*--- Initialize Secondary Lightbox if activated ---*/
            if ( $_POST['use_inline'] && !$_POST['inline_link_1'] ) {
              $this->lightboxPlusInlineInit($_POST['inline_num']);
              $g_lbp_messages .= __('Inline lightbox settings initialized.','lightboxplus').'<br /><br />';
            }   /*--- Initialize Inline Lightboxes if activated ---*/

            unset($lightboxPlusOptions);

//            lightboxPlusReload( 'settings', $detail_code );
            break;
          case 'reset':
            if ( !empty( $_POST[reinit_lightboxplus] )) {
              delete_option( $this->lightboxOptionsName );
              delete_option( $this->lightboxInitName );
              delete_option( $this->lightboxStylePathName );
              $g_lbp_messages .= '<strong>'.__('Lightbox Plus has been reset to default settings.','lightboxplus').'</strong><br /><br />';

              /*---- Used to remove old setting from previous versions of LBP ----*/
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
            /*---- Will reinitilize on reload where option lightboxplus_init is null ----*/
            $this->lightboxPlusInit();
//            lightboxPlusReload( 'reset', 23 );
            $g_lbp_messages .= '<strong>'.__('Please check and update your settings before continuing!','lightboxplus').'</strong>';
            break;
          default:
            break;
				}
      }

      /*---- Get options to load in form ----*/
			if ( !empty( $this->lightboxOptions )) { $lightboxPlusOptions = $this->getAdminOptions( $this->lightboxOptionsName ); }

      /*---- Check if there are styles ----*/
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
				  <h2><?php _e( 'Lightbox Plus Options v1.6.9.7 (ColorBox v1.3.6)', 'lightboxplus' )?></h2>
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
			require('admin/admin-html.php');
?>
			</div>
      <script type="text/javascript">
  		<!--
/*  		jQuery('.postbox h3').click( function() {
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

		  //-->
    	</script>
<?php
    }

    /*---- CLASS UTILITY FUNCTIONS ----*/
    /*---- Not sure if WordPress has equivelents but cannot locate in API docs if so ----*/

    /*---- Create clean eols for source ----*/
    function EOL( ) {
      switch ( strtoupper( substr( PHP_OS, 0, 3 ) ) ) {
        case 'WIN':
          return "\r\n";
          break;
        case 'MAC':
          return "\r";
          break;
        default:
          return "\n";
          break;
      }
    }

    /*---- Create dropdown name from stylesheet ----*/
    function setProperName( $styleName ) {
      $proper = str_replace( '.css', '', $styleName );
      $proper = ucfirst( $proper );
      return $proper;
    }

    /*---- Convert DB booleans to text for use with JavaScript (jQuery) parameters ----*/
    function setBoolean( $nValue ) {
      switch ( $nValue ) {
        case 1:
          return 'true';
          break;
        default:
          return 'false';
          break;
      }
    }

    /*---- Convert DB booleans to text for use with JavaScript (jQuery) parameters ----*/
    function setValue( $rValue ) {
      if ($rValue == '' || $rValue == 'false') {
        $tmpValue = 'false';
      } else {
        $tmpValue = '"'.$rValue.'"';
      }
      return $tmpValue;
    }

    /*---- Delete directory function used to remove old directories during upgrade from versions prior to 1.4 ----*/
    function delete_directory( $dirname ) {
      if ( is_dir( $dirname ) ) {
        $dir_handle = opendir( $dirname );
      }
      if ( !$dir_handle ) {
        return false;
      }
      while ( $file = readdir( $dir_handle ) ) {
        if ( $file != '.' && $file != '..' ) {
          if ( !is_dir( $dirname.'/'.$file ) ) {
            unlink( $dirname.'/'.$file );
          } else {
            delete_directory( $dirname.'/'.$file );
          }
        }
      }
      closedir( $dir_handle );
      rmdir( $dirname );
      return true;
    }

    /*---- Delete directory function used to remove old directories during upgrade from versions prior to 1.4 ----*/
    function delete_file( $dirname, $file ) {
      if ( $file != '.' && $file != '..' ) {
        if ( !is_dir( $dirname.'/'.$file ) ) {
          unlink( $dirname.'/'.$file );
        }
        return true;
      }
    }

    /*---- List directory function used to iterate theme directories ----*/
    function dirList( $dirname ) {
      $types = array(
        'css',
      );
      $results = array( );
      $dir_handle = opendir( $dirname );
      while ( $file = readdir( $dir_handle ) ) {
        $type = strtolower( substr( strrchr( $file, '.' ), 1 ) );
        if ( in_array( $type, $types ) ) {
          array_push( $results, $file );
        }
      }
      closedir( $dir_handle );
      sort( $results );
      return $results;
    }

  } /*---- END CLASS ----*/
} /*---- END CLASS CHECK ----*/

/*---- instantiate the class  ----*/
if (class_exists('wp_lightboxplus')) { $wp_lightboxplus = new wp_lightboxplus(); }