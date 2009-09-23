<?php
/*
Plugin Name: Lightbox Plus
Plugin URI: http://www.23systems.net/plugins/lightbox-plus/
Description: Lightbox Plus implements ColorBox as a lightbox image overlay tool for WordPress.  <a href="http://colorpowered.com/colorbox/">ColorBox</a> was created by Jack Moore of Color Powered and is licensed under the <a href="http://www.opensource.org/licenses/mit-license.php">MIT License</a>.
Author: Dan Zappone
Author URI: http://www.danzappone.com/
Version: 1.6
*/
/*---- 8/30/2009 9:30:03 AM ----*/
global $post, $content;  // WordPress Globals
global $g_lightbox_plus_url;
$g_lightbox_plus_url = WP_PLUGIN_URL.'/lightbox-plus';
load_plugin_textdomain('lightboxplus', $path = $g_lightbox_plus_url);

if (!function_exists("lightboxPlusReload")) {
	function lightboxPlusReload($update) {
		$location = get_option('siteurl').'/wp-admin/themes.php?page=lightboxplus';
		echo '<script type="text/javascript">'."\r\n";
		echo '<!--'."\r\n";
  	echo 'window.location="'.$location.'&updated='.$update.'"'."\r\n";
  	echo '//-->'."\r\n";
  	echo '</script>'."\r\n";
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
      add_action( 'admin_menu', array( &$this, 'lightboxPlusAddPages' ) );
      add_action( 'admin_head', array( &$this, 'lightboxPlusAdminHead' ) );
      add_action( 'wp_head', array( &$this, 'lightboxPlusAddHeader' ) );
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
          add_filter( 'the_content', array( &$this, 'lightboxPlusReplace' ), 12  );
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
      wp_enqueue_script( 'lightbox', $g_lightbox_plus_url.'/js/jquery.colorbox-min.js', array( 'jquery' ) );
    }

    /*---- Parse page content looking for RegEx matches and add modify HTML to acomodate LBP display ----*/
    function lightboxPlusReplace( $content ) {
      global $post;
    	if (!empty($this->lightboxOptions)) {
				$lightboxPlusOptions   = $this->getAdminOptions($this->lightboxOptionsName);
	    }
      $postGroupID = $post->ID;
			$pattern[0] = "/<a(.*?)href=('|\")([A-Za-z0-9\/_\.\~\:-]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")([^\>]*?)><img(.*?)title=('|\")(.*?)('|\")([^\>]*?)\/>/i";
			$pattern[1] = "/<a(.*?)href=('|\")([A-Za-z0-9\/_\.\~\:-]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")(.*?)(rel=('|\")lightbox(.*?)('|\"))([ \t\r\n\v\f]*?)((rel=('|\")lightbox(.*?)('|\"))?)([ \t\r\n\v\f]?)([^\>]*?)>/i";
			switch ( $lightboxPlusOptions['display_title'] ) {
        case 1:
          switch ( $lightboxPlusOptions['class_method'] ) {
            case 1:
              $replacement[0] = '<a$1href=$2$3$4$5$6 class="cboxModal" rel="lightbox['.$postGroupID.']"><img$7$11/>';
              break;
            default:
              $replacement[0] = '<a$1href=$2$3$4$5$6 rel="lightbox['.$postGroupID.']"><img$7$11/>';
              break;
          }
          break;
        default:
			    switch ( $lightboxPlusOptions['class_method'] ) {
  			    case 1:
  			      $replacement[0] = '<a$1href=$2$3$4$5$6 title="$9" class="cboxModal" rel="lightbox['.$postGroupID.']"><img$7title=$8$9$10$11/>';
  			      break;
            default:
              $replacement[0] = '<a$1href=$2$3$4$5$6 title="$9" rel="lightbox['.$postGroupID.']"><img$7title=$8$9$10$11/>';
              break;
          }
        break;
			}
			$replacement[1] = '<a$1href=$2$3$4$5$6$7>';
      $content = preg_replace( $pattern, $replacement, $content );
      return $content;
    }

    /*---- Add JavaScript (jQuery) to page header to activate LBP ----*/
    function lightboxPlusAddHeader( ) {
      global $g_lightbox_plus_url;
      if ( !empty( $this->lightboxOptions ) ) {
        $lightboxPlusOptions     = $this->getAdminOptions( $this->lightboxOptionsName );
        $lightboxPlusJavaScript  = "";
        $lightboxPlusJavaScript .= '<script type="text/javascript">'.$this->EOL( );
        $lightboxPlusJavaScript .= 'jQuery(function($){'.$this->EOL( );
        $lightboxPlusJavaScript .= '  $(document).ready(function(){'.$this->EOL( );
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.transition = "'.$lightboxPlusOptions['transition'].'";'.$this->EOL( );
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.speed = '.$lightboxPlusOptions['speed'].';'.$this->EOL( );
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.maxWidth = "'.$lightboxPlusOptions['max_width'].'";'.$this->EOL( );
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.maxHeight = "'.$lightboxPlusOptions['max_height'].'";'.$this->EOL( );
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.scalePhotos = '.$this->setBoolean( $lightboxPlusOptions['resize'] ).';'.$this->EOL( );
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.opacity = '.$lightboxPlusOptions['opacity'].';'.$this->EOL( );
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.preloading = '.$this->setBoolean( $lightboxPlusOptions['preloading'] ).';'.$this->EOL( );
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.current = "'.$lightboxPlusOptions['label_image'].' {current} '.$lightboxPlusOptions['label_of'].' {total}";'.$this->EOL( );
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.previous = "'.$lightboxPlusOptions['previous'].'";'.$this->EOL( );
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.next = "'.$lightboxPlusOptions['next'].'";'.$this->EOL( );
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.close = "'.$lightboxPlusOptions['close'].'";'.$this->EOL( );
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.overlayClose = '.$this->setBoolean( $lightboxPlusOptions['overlay_close'] ).';'.$this->EOL( );
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.slideshow = '.$this->setBoolean( $lightboxPlusOptions['slideshow'] ).';'.$this->EOL( );
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.slideshowAuto = '.$this->setBoolean( $lightboxPlusOptions['slideshow_auto'] ).';'.$this->EOL( );
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.slideshowSpeed = '.$lightboxPlusOptions['slideshow_speed'].';'.$this->EOL( );
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.slideshowStart =  "'.$lightboxPlusOptions['slideshow_start'].'";'.$this->EOL( );
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.slideshowStop = "'.$lightboxPlusOptions['slideshow_stop'].'";'.$this->EOL( );
        switch ( $lightboxPlusOptions['class_method'] ) {
          case 1:
            $lightboxPlusJavaScript .= '  $(".cboxModal").colorbox();'.$this->EOL( );
            break;
          default:
            $lightboxPlusJavaScript .= '  $("a[rel*=lightbox]").colorbox();'.$this->EOL( );
            break;
        }
        $lightboxPlusJavaScript .= '  });'.$this->EOL( );
        $lightboxPlusJavaScript .= '});'.$this->EOL( );
        $lightboxPlusJavaScript .= '</script>'.$this->EOL( );
        echo $lightboxPlusJavaScript;
        $lightboxPlusStyleSheet = '<link rel="stylesheet" type="text/css" href="'.$g_lightbox_plus_url.'/css/'.$lightboxPlusOptions['lightboxplus_style'].'/colorbox.css" media="screen" />'.$this->EOL( );
        
        /*---- Check for and add conditional IE specific CSS fixes ----*/
        $currentStylePath       = get_option( 'lightboxplus_style_path' );
        $filename               = $currentStylePath.'/'.$lightboxPlusOptions['lightboxplus_style'].'/colorbox-ie.css';
        if ( file_exists( $filename ) ) {
          $lightboxPlusStyleSheet .= '<!--[if IE]>'.$this->EOL( );
          $lightboxPlusStyleSheet .= '     <link type="text/css" media="screen" rel="stylesheet" href="'.$g_lightbox_plus_url.'/css/'.$lightboxPlusOptions['lightboxplus_style'].'/colorbox-ie.css" title="IE fixes" />'.$this->EOL( );
          $lightboxPlusStyleSheet .= '<![endif]-->'.$this->EOL( );
        }
        echo $lightboxPlusStyleSheet;
      }
    }

    /*---- Add some default options if they don't exist or if reinitialized ----*/
    function lightboxPlusInit( ) {
      global $g_lightbox_plus_url;
      delete_option( $this->lightboxOptionsName );
      delete_option( $this->lightboxInitName );
      delete_option( $this->lightboxStylePathName );
      $this->saveAdminOptions( $this->lightboxInitName, true );
      $lightboxPlusOptions = array(
        "lightboxplus_style"    => 'shadowed',
        "transition"            => 'elastic',
        "speed"                 => '350',
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
        "display_title"         => '0',
        "auto_lightbox"         => '0',
        "class_method"          => '0',
        "gallery_lightboxplus"  => '0'
      );
      $this->saveAdminOptions( $this->lightboxOptionsName, $lightboxPlusOptions );

      /*---- Where the styles reside ----*/
      $stylePath = ( dirname( __FILE__ )."/css" );
      $this->saveAdminOptions( $this->lightboxStylePathName, $stylePath );
    }

    /*---- Add styles to Admin Panel ----*/
    function lightboxPlusAdminHead( ) {
      global $g_lightbox_plus_url;
      echo '<link rel="stylesheet" type="text/css" href="'.$g_lightbox_plus_url.'/admin/admin.css" media="screen" />'.$this->EOL( );
    }

    /*---- Add new panel to WordPress under the Appearance category ----*/
    function lightboxPlusAddPages( ) {
      add_submenu_page( 'themes.php', "Lightbox Plus", "Lightbox Plus", 10, "lightboxplus", array( &$this, "lightboxPlusAdminPanel" ) );
    }

    /*---- The admin panel funtion - handles creating admin panel and processing of form submission ----*/
    function lightboxPlusAdminPanel( ) {
      global $g_lightbox_plus_url;
      load_plugin_textdomain( 'lightboxplus', $path = $g_lightbox_plus_url );
      $location = get_option( 'siteurl' ).'/wp-admin/admin.php?page=lightboxplus';

      /*---- check form submission and update setting ----*/
      if ( $_POST['action'] ) {
        switch ( $_POST['sub'] ) {
          case 'settings':
            $lightboxPlusOptions = array(
              "lightboxplus_style"    => $_POST[lightboxplus_style],
              "transition"            => $_POST[transition],
              "speed"                 => $_POST[speed],
              "max_width"             => $_POST[max_width],
              "max_height"            => $_POST[max_height],
              "resize"                => $_POST[resize],
              "opacity"               => $_POST[opacity],
              "preloading"            => $_POST[preloading],
              "label_image"           => $_POST[label_image],
              "label_of"              => $_POST[label_of],
              "previous"              => $_POST[previous],
              "next"                  => $_POST[next],
              "close"                 => $_POST[close],
              "overlay_close"         => $_POST[overlay_close],
              "slideshow"             => $_POST[slideshow],
              "slideshow_auto"        => $_POST[slideshow_auto],
              "slideshow_speed"       => $_POST[slideshow_speed],
              "slideshow_start"       => $_POST[slideshow_start],
              "slideshow_stop"        => $_POST[slideshow_stop],
              "display_title"         => $_POST[display_title],
              "auto_lightbox"         => $_POST[auto_lightbox],
              "class_method"          => $_POST[class_method],
              "gallery_lightboxplus"  => $_POST[gallery_lightboxplus],
            );

            $this->saveAdminOptions($this->lightboxOptionsName, $lightboxPlusOptions);
            lightboxPlusReload('settings');
            break;
          case 'reset':
            if ( !empty( $_POST[reinit_lightboxplus] )) {
              delete_option( $this->lightboxOptionsName );
              delete_option( $this->lightboxInitName );
              delete_option( $this->lightboxStylePathName );

              /*---- Used to remove old setting from previous versions of LBP ----*/
              $pluginPath = ( dirname( __FILE__ ));
              if ( file_exists( $pluginPath."/images" )) {
                echo "Deleting: ".$pluginPath."/images"."<br />";
                $this->delete_directory( $pluginPath."/images/" );
              } else {
                echo $pluginPath."/images"." already removed<br />";
              }
              if ( file_exists( $pluginPath."/js/"."lightbox.js" )) {
                echo "Deleting: ".$pluginPath."/js/"."lightbox.js"."<br />";
                $this->delete_file( $pluginPath."/js", "lightbox.js" );
              } else {
                echo $pluginPath."/js/"."lightbox.js"." already removed<br />";
              }
              $oldStyles = $this->dirList( $pluginPath."/css/" );
              if ( !empty( $oldStyles )) {
                foreach ( $oldStyles as $value ) {
                  if ( file_exists( $pluginPath."/css/".$value )) {
                    echo "Deleting: ".$pluginPath."/css/".$value."<br />";
                    $this->delete_file( $pluginPath."/css", $value );
                  }
                }
              }
              else {
                echo "Old styles already removed";
              }
            }
            /*---- Will reinitilize on reload where option lightboxplus_init is null ----*/
            lightboxPlusReload( 'reset' );
            break;
          default:
            break;
				} 
      }

      /*---- Get options to load in form ----*/
			if ( !empty( $this->lightboxOptions )) {	$lightboxPlusOptions   = $this->getAdminOptions( $this->lightboxOptionsName ); }

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

      $lightboxPlusStatus     = $_GET[updated];
      if ($lightboxPlusStatus) {
        switch ($lightboxPlusStatus) {
  				case 'settings':
  				  echo '<div id="message" class="updated fade">';
  		    	_e( '<p><strong>Lightbox Plus settings have been saved</strong></p></div>','lightboxplus' );
  				  break;
  				case 'reset':
  				  echo '<div id="message" class="updated fade">';
  		    	_e(' <p><strong>Lightbox Plus has been reset to default settings.</strong></p></div>','lightboxplus' );
  				  break;
  				default:
  				  break;
				}
      }
?>
			<div class="wrap">
				  <h2><?php _e( 'Lightbox Plus Options', 'lightboxplus' )?></h2>
				  <?php _e( 'Lightbox Plus implements ColorBox as a lightbox image overlay tool for WordPress.  ColorBox was created by Jack Moore of <a href="http://colorpowered.com/colorbox/">Color Powered</a> and is licensed under the MIT License. Lightbox Plus allows you to easily integrate and customize a powerful and light-weight lightbox plugin for jQuery into your WordPress site.  You can easily create additional styles by adding a new folder to the css directory under <code>wp-content/plugins/lighbox-plus/css/</code> by duplicating and modifying any of the existing themes or using them as examples to create your own.  See the <a href="http://www.23systems.net/plugins/lightbox-plus/">changelog</a> for important details on this upgrade.','lightboxplus' ); ?>
<?php
			require('admin/admin-html.php');
?>
			</div>
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