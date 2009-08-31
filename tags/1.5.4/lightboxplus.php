<?php
/*
Plugin Name: Lightbox Plus
Plugin URI: http://www.23systems.net/plugins/lightbox-plus/
Description: Lightbox Plus implements ColorBox as a lightbox image overlay tool for WordPress.  <a href="http://colorpowered.com/colorbox/">ColorBox</a> was created by Jack Moore of Color Powered and is licensed under the <a href="http://www.opensource.org/licenses/mit-license.php">MIT License</a>.
Author: Dan Zappone
Author URI: http://www.danzappone.com/
Version: 1.5.4
*/
/*---- 3/27/2009 12:48:47 PM ----*/
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
    var $lightboxOptionsName = 'lightboxplus_options';
    var $lightboxInitName = 'lightboxplus_init';
    var $lightboxStylePathName = 'lightboxplus_style_path';

    /*---- PHP 4 Compatible Constructor ----*/
    function wp_lightboxplus() {
      $this->__construct();
    }

    /*---- PHP 5 Constructor ----*/
    function __construct() {
      $this->lightboxOptions = $this->getAdminOptions($this->lightboxOptionsName);
      $this->lightboxInit = get_option($this->lightboxInitName);
			if (!$this->lightboxInit) { $this->lightboxPlusInit(); }

      add_action("admin_menu", array(&$this, "lightboxPlusAddPages"));
      add_action('wp_head', array(&$this, 'lightboxPlusAddHeader'));
    	if (!empty($this->lightboxOptions)) {
				$lightboxPlusOptions   = $this->getAdminOptions($this->lightboxOptionsName);
	      $autoLightbox          = $lightboxPlusOptions['auto_lightbox'];
	    }
	    if ($autoLightbox != 1) {
        add_filter('the_content', array(&$this, 'lightboxPlusReplace'));
      }
      add_action("init", array(&$this, "addScripts"));

    }

    /*---- Retrieves the options from the database.  @return array ----*/
    function getAdminOptions($optionsName) {
      $savedOptions = get_option($optionsName);
      if (!empty($savedOptions)) {
        foreach ($savedOptions as $key => $option) {
          $theOptions[$key] = $option;
        }
      }
      update_option($optionsName, $theOptions);
      return $theOptions;
    }

    /*---- Saves the admin options to the database. ----*/
    function saveAdminOptions($optionsName, $options) {
      update_option($optionsName, $options);
    }

    /*---- Tells WordPress to load the scripts ----*/
    function addScripts() {
    	global $g_lightbox_plus_url;
      wp_enqueue_script('lightbox', $g_lightbox_plus_url.'/js/jquery.colorbox-min.js', array('jquery'));
    }

    function lightboxPlusReplace($content) {
      global $post;
    	if (!empty($this->lightboxOptions)) {
				$lightboxPlusOptions   = $this->getAdminOptions($this->lightboxOptionsName);
	    }
      $postGroupID = $post->ID;
			$pattern[0]     = "/<a(.*?)href=('|\")([A-Za-z0-9\/_\.\~\:-]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")([^\>]*?)><img(.*?)title=('|\")(.*?)('|\")([^\>]*?)\/>/i";
			$pattern[1]     = "/<a(.*?)href=('|\")([A-Za-z0-9\/_\.\~\:-]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")(.*?)(rel=('|\")lightbox(.*?)('|\"))([ \t\r\n\v\f]*?)((rel=('|\")lightbox(.*?)('|\"))?)([ \t\r\n\v\f]?)([^\>]*?)>/i";
			if ($lightboxPlusOptions['display_title'] != 1) {
			  if ($lightboxPlusOptions['class_method'] == 1) {
			    $replacement[0] = '<a$1href=$2$3$4$5$6 title="$9" class="cboxModal" rel="lightbox['.$postGroupID.']"><img$7title=$8$9$10$11/>';
			  } else {
          $replacement[0] = '<a$1href=$2$3$4$5$6 title="$9" rel="lightbox['.$postGroupID.']"><img$7title=$8$9$10$11/>';
        }
			}	else {
				if ($lightboxPlusOptions['class_method'] == 1) {
			    $replacement[0] = '<a$1href=$2$3$4$5$6 class="cboxModal" rel="lightbox['.$postGroupID.']"><img$7$11/>';
			  } else {
          $replacement[0] = '<a$1href=$2$3$4$5$6 rel="lightbox['.$postGroupID.']"><img$7$11/>';
        }
			}
			$replacement[1] = '<a$1href=$2$3$4$5$6$7>';

      $content        = preg_replace($pattern, $replacement, $content);
      return $content;
    }

    function lightboxPlusAddHeader() {
      global $g_lightbox_plus_url;
    	if (!empty($this->lightboxOptions)) {
				$lightboxPlusOptions   = $this->getAdminOptions($this->lightboxOptionsName);
        $lightboxPlusJavaScript = "";

        $lightboxPlusJavaScript .= '<script type="text/javascript">'.$this->EOL();
        $lightboxPlusJavaScript .= 'jQuery(function($){'.$this->EOL();
        $lightboxPlusJavaScript .= '  $(document).ready(function(){'.$this->EOL();
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.transition = "'.$lightboxPlusOptions['transition'].'";'.$this->EOL();
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.speed = '.$lightboxPlusOptions['speed'].';'.$this->EOL();
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.maxWidth = "'.$lightboxPlusOptions['max_width'].'";'.$this->EOL();
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.maxHeight = "'.$lightboxPlusOptions['max_height'].'";'.$this->EOL();
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.resize = '.$this->setBoolean($lightboxPlusOptions['resize']).';'.$this->EOL();
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.opacity = '.$lightboxPlusOptions['opacity'].';'.$this->EOL();
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.preloading = '.$this->setBoolean($lightboxPlusOptions['preloading']).';'.$this->EOL();
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.current = "'.$lightboxPlusOptions['label_image'].' {current} '.$lightboxPlusOptions['label_of'].' {total}";'.$this->EOL();
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.previous = "'.$lightboxPlusOptions['previous'].'";'.$this->EOL();
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.next = "'.$lightboxPlusOptions['next'].'";'.$this->EOL();
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.close = "'.$lightboxPlusOptions['close'].'";'.$this->EOL();
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.overlayClose = '.$this->setBoolean($lightboxPlusOptions['overlay_close']).';'.$this->EOL();
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.slideshow = '.$this->setBoolean($lightboxPlusOptions['slideshow']).';'.$this->EOL();
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.slideshowAuto = '.$this->setBoolean($lightboxPlusOptions['slideshow_auto']).';'.$this->EOL();
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.slideshowSpeed = '.$lightboxPlusOptions['slideshow_speed'].';'.$this->EOL();
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.slideshowStart =  "'.$lightboxPlusOptions['slideshow_start'].'";'.$this->EOL();
        $lightboxPlusJavaScript .= '  $.fn.colorbox.settings.slideshowStop = "'.$lightboxPlusOptions['slideshow_stop'].'";'.$this->EOL();
  	    switch ($lightboxPlusOptions['class_method']) {
          case 1:
            $lightboxPlusJavaScript .= '  $(".cboxModal").colorbox();'.$this->EOL();
            break;
          default:
            $lightboxPlusJavaScript .= '  $("a[rel*=lightbox]").colorbox();'.$this->EOL();
            break;
        }
        $lightboxPlusJavaScript .= '  });'.$this->EOL();
        $lightboxPlusJavaScript .= '});'.$this->EOL();
        $lightboxPlusJavaScript .= '</script>'.$this->EOL();

        echo $lightboxPlusJavaScript;

        $lightboxPlusStyleSheet = '<link rel="stylesheet" type="text/css" href="'.$g_lightbox_plus_url.'/css/'.$lightboxPlusOptions['lightboxplus_style'].'/colorbox.css" media="screen" />'.$this->EOL();
        $currentStylePath = get_option('lightboxplus_style_path');
        $filename = $currentStylePath.'/'.$lightboxPlusOptions['lightboxplus_style'].'/colorbox-ie.css';
        if (file_exists($filename)) {
            $lightboxPlusStyleSheet .= '<!--[if IE]>'.$this->EOL();
            $lightboxPlusStyleSheet .= '     <link type="text/css" media="screen" rel="stylesheet" href="'.$g_lightbox_plus_url.'/css/'.$lightboxPlusOptions['lightboxplus_style'].'/colorbox-ie.css" title="IE fixes" />'.$this->EOL();
            $lightboxPlusStyleSheet .= '<![endif]-->'.$this->EOL();
        }

        echo $lightboxPlusStyleSheet;
			}
    }

    function lightboxPlusAddPages() {
      add_submenu_page('themes.php', "Lightbox Plus", "Lightbox Plus", 10, "lightboxplus", array(&$this, "lightboxPlusAdminPanel"));
    }

		/*---- Add some default options if they don't exist ----*/
		function lightboxPlusInit() {
			global $g_lightbox_plus_url;
      delete_option($this->lightboxOptionsName);
      delete_option($this->lightboxInitName);
      delete_option($this->lightboxStylePathName);

  		$this->saveAdminOptions($this->lightboxInitName, true);

			$lightboxPlusOptions = array(
					"lightboxplus_style"       => 'shadowed',
          "transition"               => 'elastic',
          "speed"                    => '350',
          "max_width"                => 'false',
          "max_height"               => 'false',
          "resize"                   => '1',
          "opacity"                  => '0.8',
          "preloading"               => '1',
    			"label_image"              => 'Image',
    			"label_of"                 => 'of',
          "previous"                 => 'previous',
          "next"                     => 'next',
          "close"                    => 'close',
          "overlay_close"            => '1',
          "slideshow"                => '0',
          "slideshow_auto"           => '1',
          "slideshow_speed"          => '2500',
          "slideshow_start"          => 'start',
          "slideshow_stop"           => 'stop',
	        "display_title"            => '0',
	        "auto_lightbox"            => '0',
	        "class_method"             => '0',
			);

			$this->saveAdminOptions($this->lightboxOptionsName, $lightboxPlusOptions);

      /*---- Where the styles reside ----*/
      $stylePath = (dirname(__FILE__)."/css");
      $this->saveAdminOptions($this->lightboxStylePathName, $stylePath);
		}

    function lightboxPlusAdminPanel() {
      global $g_lightbox_plus_url;
      load_plugin_textdomain('lightboxplus', $path = $g_lightbox_plus_url);
      $location = get_option('siteurl').'/wp-admin/admin.php?page=lightboxplus';

      /*---- check form submission and update setting ----*/
      if ($_POST['action']) {
        switch ($_POST['sub']) {
          case 'settings':
            $lightboxPlusOptions = array(
              "lightboxplus_style"       => $_POST[lightboxplus_style],
              "transition"               => $_POST[transition],
              "speed"                    => $_POST[speed],
              "max_width"                => $_POST[max_width],
              "max_height"               => $_POST[max_height],
              "resize"                   => $_POST[resize],
              "opacity"                  => $_POST[opacity],
              "preloading"               => $_POST[preloading],
              "label_image"              => $_POST[label_image],
              "label_of"                 => $_POST[label_of],
              "previous"                 => $_POST[previous],
              "next"                     => $_POST[next],
              "close"                    => $_POST[close],
              "overlay_close"            => $_POST[overlay_close],
              "slideshow"                => $_POST[slideshow],
              "slideshow_auto"           => $_POST[slideshow_auto],
              "slideshow_speed"          => $_POST[slideshow_speed],
              "slideshow_start"          => $_POST[slideshow_start],
              "slideshow_stop"           => $_POST[slideshow_stop],
              "display_title"            => $_POST[display_title],
              "auto_lightbox"            => $_POST[auto_lightbox],
              "class_method"             => $_POST[class_method],
              );

              $this->saveAdminOptions($this->lightboxOptionsName, $lightboxPlusOptions);
              lightboxPlusReload('settings');
              break;
          case 'reset':
            if (!empty($_POST[reinit_lightboxplus])) {
              delete_option($this->lightboxOptionsName);
              delete_option($this->lightboxInitName);
              delete_option($this->lightboxStylePathName);

              /*---- Used to remove old setting from previous versions of LBP ----*/
              $pluginPath = (dirname(__FILE__));
              if (file_exists($pluginPath."/images")) {
                echo "Deleting: ".$pluginPath."/images"."<br />";
                $this->delete_directory($pluginPath."/images/");
              }
              else {
                echo $pluginPath."/images"." already removed<br />";
              }
              if (file_exists($pluginPath."/js/"."lightbox.js")) {
                echo "Deleting: ".$pluginPath."/js/"."lightbox.js"."<br />";
                $this->delete_file($pluginPath."/js", "lightbox.js");
              }
              else {
                echo $pluginPath."/js/"."lightbox.js"." already removed<br />";
              }
              $oldStyles = $this->dirList($pluginPath."/css/");
              if (!empty($oldStyles)) {
                foreach ($oldStyles as $value) {
                  if (file_exists($pluginPath."/css/".$value)) {
                    echo "Deleting: ".$pluginPath."/css/".$value."<br />";
                    $this->delete_file($pluginPath."/css", $value);
                  }
                }
              }
              else {
                echo "Old styles already removed";
              }
            }
            /*---- Will reinitilize on reload where option lightboxplus_init is null ----*/
            lightboxPlusReload('reset');
            break;
          default:
            break;
				} //keep end switch
      }

      /*---- Get options to load in form ----*/
			if (!empty($this->lightboxOptions)) {	$lightboxPlusOptions   = $this->getAdminOptions($this->lightboxOptionsName); }

      /*---- Check if there are styles ----*/
      $stylePath = get_option('lightboxplus_style_path');
      if ($handle = opendir($stylePath)) {
        while (false !== ($file = readdir($handle))) {
          if ($file != "." && $file != ".." && $file != ".DS_Store") {
            $styles[$file] = $stylePath."/".$file."/";
          }
        }
        closedir($handle);
      }

      $lightboxPlusStatus     = $_GET[updated];
      if ($lightboxPlusStatus) {
      switch ($lightboxPlusStatus)
				{
				case 'settings':
				  echo '<div id="message" class="updated fade">';
		    	_e('<p><strong>Lightbox Plus settings have been saved</strong></p></div>',"lightboxplus");
				  break;
				case 'reset':
				  echo '<div id="message" class="updated fade">';
		    	_e('<p><strong>Lightbox Plus has been reset to default settings.</strong></p></div>',"lightboxplus");
				  break;
				default:
				  break;
				}
      }
?>
			<div class="wrap">
				  <h2><?php _e('Lightbox Plus Options', 'lightboxplus')?></h2>
				  <?php _e('Lightbox Plus implements ColorBox as a lightbox image overlay tool for WordPress.  ColorBox was created by Jack Moore of <a href="http://colorpowered.com/colorbox/">Color Powered</a> and is licensed under the MIT License. Lightbox Plus allows you to easily integrate and customize a powerful and light-weight lightbox plugin for jQuery into your WordPress site.  You can easily create additional styles by adding a new folder to the css directory under <code>wp-content/plugins/lighbox-plus/css/</code> by duplicating and modifying any of the existing themes or using them as examples to create your own.  See the <a href="http://www.23systems.net/plugins/lightbox-plus/">changelog</a> for important details on this upgrade.',"lightboxplus"); ?>

      	<h3><?php _e('Reset/Re-initialize Lightbox Plus',"lightboxplus"); ?>: </h3>
					<form action="<?php echo $location?>&amp;updated=true" method="post" id="lightboxplus_reset" name="lightboxplus_reset">
					<table>
					<tr>
            <td valign="top"><?php _e('This will immediately remove all existing settings and any files for versions of Lightbox Plus prior to version 1.5 and will also re-initialize the plugin with the new default options. Be absolutely certain you want to do this. <br /><strong><em>If you are upgrading from a version prior to 1.4 it is <strong><em>highly</em></strong> recommended that you reinitialize Lightbox Plus</em></strong>',"lightboxplus"); ?></td>
					</tr>
					<tr>
            <td valign="top"><p class="submit"><input type="hidden" name="reinit_lightboxplus" value="1" /><input type="submit" class="btn" name="save" style="padding:5px 30px 5px 30px;" value="<?php _e('Reset/Re-initialize Lightbox Plus',"lightboxplus"); ?>" /></p>
					<input type="hidden" name="action" value="action" /><input type="hidden" name="sub" value="reset" /></td>
					</tr>
					</table>
         </form>

				  <h3><?php _e('Lightbox Plus Settings',"lightboxplus"); ?>: </h3>

				  <form name="lightboxplus_settings" method="post" action="<?php echo $location?>&amp;updated=true">
					<input type="hidden" name="action" value="action" /><input type="hidden" name="sub" value="settings" />
					<table class="form-table">
					  <tr valign="top">
						<th scope="row"><?php _e('Lightbox Plus Style', 'lightboxplus')?>: </th>
						<td>
      			<select name="lightboxplus_style">
            <?php
                  foreach ($styles as $key => $value) {
                    if ($lightboxPlusOptions['lightboxplus_style'] == urlencode($key)) {
                      echo("<option value=\"".urlencode($key)."\" selected=\"selected\">".$this->setProperName($key)."</option>\n");
                    } else {
                      echo("<option value=\"".urlencode($key)."\">".$this->setProperName($key)."</option>\n");
                    }
                  }
            ?>
      			</select>
			         </td>
					  </tr>
					  <tr>
              <th scope="row"><?php _e('Transition Type', 'lightboxplus')?>: </th>
              <td>
      					<select name="transition" id="transition">
      					  <option value="elastic"<?php if ($lightboxPlusOptions['transition']=='elastic') echo ' selected="selected"'?>>Elastic</option>
      					  <option value="fade"<?php if ($lightboxPlusOptions['transition']=='fade') echo ' selected="selected"'?>>Fade</option>
      					  <option value="none"<?php if ($lightboxPlusOptions['transition']=='none') echo ' selected="selected"'?>>None</option>
      					</select><br /><?php _e('Specifies the transition type. Can be set to "elastic", "fade", or "none".<br /><strong><em>Default: Elastic</em></strong>', 'lightboxplus')?>
              </td>
            </tr>
					  <tr>
              <th scope="row"><?php _e('Resize Speed', 'lightboxplus')?>: </th>
              <td>
      					<select name="speed" id="speed">
      					  <option value="0"<?php if ($lightboxPlusOptions['speed']=='0') echo ' selected="selected"'?>>0</option>
      					  <option value="50"<?php if ($lightboxPlusOptions['speed']=='50') echo ' selected="selected"'?>>50</option>
      					  <option value="100"<?php if ($lightboxPlusOptions['speed']=='100') echo ' selected="selected"'?>>100</option>
      					  <option value="150"<?php if ($lightboxPlusOptions['speed']=='150') echo ' selected="selected"'?>>150</option>
      					  <option value="200"<?php if ($lightboxPlusOptions['speed']=='200') echo ' selected="selected"'?>>200</option>
      					  <option value="250"<?php if ($lightboxPlusOptions['speed']=='250') echo ' selected="selected"'?>>250</option>
      					  <option value="300"<?php if ($lightboxPlusOptions['speed']=='300') echo ' selected="selected"'?>>300</option>
      					  <option value="350"<?php if ($lightboxPlusOptions['speed']=='350') echo ' selected="selected"'?>>350</option>
      					  <option value="400"<?php if ($lightboxPlusOptions['speed']=='400') echo ' selected="selected"'?>>400</option>
      					  <option value="450"<?php if ($lightboxPlusOptions['speed']=='450') echo ' selected="selected"'?>>450</option>
      					  <option value="500"<?php if ($lightboxPlusOptions['speed']=='500') echo ' selected="selected"'?>>500</option>
      					  <option value="550"<?php if ($lightboxPlusOptions['speed']=='550') echo ' selected="selected"'?>>550</option>
      					  <option value="600"<?php if ($lightboxPlusOptions['speed']=='600') echo ' selected="selected"'?>>600</option>
      					  <option value="650"<?php if ($lightboxPlusOptions['speed']=='650') echo ' selected="selected"'?>>650</option>
      					  <option value="700"<?php if ($lightboxPlusOptions['speed']=='700') echo ' selected="selected"'?>>700</option>
      					  <option value="750"<?php if ($lightboxPlusOptions['speed']=='750') echo ' selected="selected"'?>>750</option>
      					  <option value="800"<?php if ($lightboxPlusOptions['speed']=='800') echo ' selected="selected"'?>>800</option>
      					  <option value="850"<?php if ($lightboxPlusOptions['speed']=='850') echo ' selected="selected"'?>>850</option>
      					  <option value="900"<?php if ($lightboxPlusOptions['speed']=='900') echo ' selected="selected"'?>>900</option>
      					  <option value="950"<?php if ($lightboxPlusOptions['speed']=='950') echo ' selected="selected"'?>>950</option>
      					  <option value="1000"<?php if ($lightboxPlusOptions['speed']=='1000') echo ' selected="selected"'?>>1000</option>
      					  <option value="1050"<?php if ($lightboxPlusOptions['speed']=='1050') echo ' selected="selected"'?>>1050</option>
      					  <option value="1250"<?php if ($lightboxPlusOptions['speed']=='1250') echo ' selected="selected"'?>>1250</option>
      					  <option value="1500"<?php if ($lightboxPlusOptions['speed']=='1500') echo ' selected="selected"'?>>1500</option>
      					  <option value="1750"<?php if ($lightboxPlusOptions['speed']=='1750') echo ' selected="selected"'?>>1750</option>
      					  <option value="2000"<?php if ($lightboxPlusOptions['speed']=='2000') echo ' selected="selected"'?>>2000</option>
      					  <option value="2500"<?php if ($lightboxPlusOptions['speed']=='2500') echo ' selected="selected"'?>>2500</option>
      					  <option value="3000"<?php if ($lightboxPlusOptions['speed']=='3000') echo ' selected="selected"'?>>3000</option>
      					  <option value="3500"<?php if ($lightboxPlusOptions['speed']=='3500') echo ' selected="selected"'?>>3500</option>
      					  <option value="4000"<?php if ($lightboxPlusOptions['speed']=='4000') echo ' selected="selected"'?>>4000</option>
      					  <option value="5000"<?php if ($lightboxPlusOptions['speed']=='5000') echo ' selected="selected"'?>>5000</option>
      					</select><br /><?php _e('Controls the speed of the fade and elastic transitions, in milliseconds.<br /><strong><em>Default: 350</em></strong>', 'lightboxplus')?>
              </td>
            </tr>

					  <tr>
              <th scope="row"><?php _e('Maximum Width', 'lightboxplus')?>: </th>
              <td><input type="text" size="15" name="max_width" id="max_width" value="<?php if (!empty($lightboxPlusOptions['max_width'])) { echo $lightboxPlusOptions['max_width'];} else { echo ''; } ?>" /><br /><?php _e('Set a maximum width for loaded content.  Example: "75%", "500px", 500, or false for no maximum width.  <strong><em>Default: false</em></strong>', 'lightboxplus')?></td>
            </tr>

					  <tr>
              <th scope="row"><?php _e('Maximum Height', 'lightboxplus')?>: </th>
              <td><input type="text" size="15" name="max_height" id="max_height" value="<?php if (!empty($lightboxPlusOptions['max_height'])) { echo $lightboxPlusOptions['max_height'];} else { echo ''; } ?>" /><br /><?php _e('Set a maximum height for loaded content.  Example: "75%", "500px",, 500, or false for no maximum height. <strong><em>Default: false</em></strong>', 'lightboxplus')?></td>
            </tr>

					  <tr>
              <th scope="row"><?php _e('Resize', 'lightboxplus')?>: </th>
              <td><input type="checkbox" name="resize"id="resize" value="1"<?php if ($lightboxPlusOptions['resize']) echo ' checked="checked"';?> /><br /><?php _e('If checked and if Maximum Width or Maximum Height have been defined, Lightbx Plus will resize photos to fit within the those values.<br /><strong><em>Default: Checked</em></strong>', 'lightboxplus')?></td>
            </tr>

					  <tr>
              <th scope="row"><?php _e('Overlay Opacity', 'lightboxplus')?>: </th>
              <td>
      					<select name="opacity">
      					  <option value="0"<?php if ($lightboxPlusOptions['opacity']=='0') echo ' selected="selected"'?>>0%</option>
      					  <option value="0.05"<?php if ($lightboxPlusOptions['opacity']=='0.05') echo ' selected="selected"'?>>5%</option>
      					  <option value="0.1"<?php if ($lightboxPlusOptions['opacity']=='0.1') echo ' selected="selected"'?>>10%</option>
      					  <option value="0.15"<?php if ($lightboxPlusOptions['opacity']=='0.15') echo ' selected="selected"'?>>15%</option>
      					  <option value="0.2"<?php if ($lightboxPlusOptions['opacity']=='0.2') echo ' selected="selected"'?>>20%</option>
      					  <option value="0.25"<?php if ($lightboxPlusOptions['opacity']=='0.25') echo ' selected="selected"'?>>25%</option>
      					  <option value="0.3"<?php if ($lightboxPlusOptions['opacity']=='0.3') echo ' selected="selected"'?>>30%</option>
      					  <option value="0.35"<?php if ($lightboxPlusOptions['opacity']=='0.35') echo ' selected="selected"'?>>35%</option>
      					  <option value="0.4"<?php if ($lightboxPlusOptions['opacity']=='0.4') echo ' selected="selected"'?>>40%</option>
      					  <option value="0.45"<?php if ($lightboxPlusOptions['opacity']=='0.45') echo ' selected="selected"'?>>45%</option>
      					  <option value="0.5"<?php if ($lightboxPlusOptions['opacity']=='0.5') echo ' selected="selected"'?>>50%</option>
      					  <option value="0.55"<?php if ($lightboxPlusOptions['opacity']=='0.55') echo ' selected="selected"'?>>55%</option>
      					  <option value="0.6"<?php if ($lightboxPlusOptions['opacity']=='0.6') echo ' selected="selected"'?>>60%</option>
      					  <option value="0.65"<?php if ($lightboxPlusOptions['opacity']=='0.65') echo ' selected="selected"'?>>65%</option>
      					  <option value="0.7"<?php if ($lightboxPlusOptions['opacity']=='0.7') echo ' selected="selected"'?>>70%</option>
      					  <option value="0.75"<?php if ($lightboxPlusOptions['opacity']=='0.75') echo ' selected="selected"'?>>75%</option>
      					  <option value="0.8"<?php if ($lightboxPlusOptions['opacity']=='0.8') echo ' selected="selected"'?>>80%</option>
      					  <option value="0.85"<?php if ($lightboxPlusOptions['opacity']=='0.85') echo ' selected="selected"'?>>85%</option>
      					  <option value="0.9"<?php if ($lightboxPlusOptions['opacity']=='0.9') echo ' selected="selected"'?>>90%</option>
      					  <option value="0.95"<?php if ($lightboxPlusOptions['opacity']=='0.95') echo ' selected="selected"'?>>95%</option>
      					  <option value="1.0"<?php if ($lightboxPlusOptions['opacity']=='1.0') echo ' selected="selected"'?>>100%</option>
      					</select><br /><?php _e('Controls transparency of shadow overlay. Lower numbers are more transparent.<br /><strong><em>Default: 80%</em></strong>', 'lightboxplus')?>
              </td>
            </tr>

					  <tr>
              <th scope="row"><?php _e('Pre-load images', 'lightboxplus')?>: </th>
              <td><input type="checkbox" name="preloading" value="1"<?php if ($lightboxPlusOptions['preloading']) echo ' checked="checked"';?> /><br /><?php _e('Allows for preloading of "Next" and "Previous" content in a shared relation group (same values for the "rel" attribute), after the current content has finished loading. Uncheck to disable.<br /><strong><em>Default: Checked</em></strong>', 'lightboxplus')?></td>
            </tr>

					  <tr>
              <th scope="row"><?php _e('Grouping Labels', 'lightboxplus')?>: </th>
              <td><input type="text" size="15" name="label_image" id="label_image" value="<?php if (empty($lightboxPlusOptions['label_image'])) { echo 'Image'; } else {echo $lightboxPlusOptions['label_image'];}?>" /> # <input type="text" size="15" name="label_of" id="label_of" value="<?php if (empty($lightboxPlusOptions['label_of'])) { echo 'of'; } else {echo $lightboxPlusOptions['label_of'];}?>" /> #<br /><?php _e('Text format for the content group / gallery count. {current} and {total} are detected and replaced with actual numbers while ColorBox runs.<strong><em>Default: Image {current} of {total}</em></strong>', 'lightboxplus')?></td>
            </tr>

					  <tr>
              <th scope="row"><?php _e('Previous image text', 'lightboxplus')?>: </th>
              <td><input type="text" size="15" name="previous" id="previous" value="<?php if (!empty($lightboxPlusOptions['previous'])) { echo $lightboxPlusOptions['previous'];} else { echo 'previous'; } ?>" /><br /><?php _e('Text for the previous button in a shared relation group (same values for "rel" attribute). <strong><em>Default: previous</em></strong>', 'lightboxplus')?></td>
            </tr>

					  <tr>
              <th scope="row"><?php _e('Next image text', 'lightboxplus')?>: </th>
              <td><input type="text" size="15" name="next" id="next" value="<?php if (!empty($lightboxPlusOptions['next'])) { echo $lightboxPlusOptions['next'];} else { echo 'next'; } ?>" /><br /><?php _e('Text for the next button in a shared relation group (same values for "rel" attribute).  <strong><em>Default: next</em></strong>', 'lightboxplus')?></td>
            </tr>

					  <tr>
              <th scope="row"><?php _e('Close image text', 'lightboxplus')?>: </th>
              <td><input type="text" size="15" name="close" id="close" value="<?php if (!empty($lightboxPlusOptions['close'])) { echo $lightboxPlusOptions['close'];} else { echo 'close'; } ?>" /><br /><?php _e('Text for the close button. The "Esc" key will also close Lightbox Plus. <strong><em>Default: close</em></strong>', 'lightboxplus')?></td>
            </tr>

					  <tr>
              <th scope="row"><?php _e('Overlay Close', 'lightboxplus')?>: </th>
              <td><input type="checkbox" name="overlay_close" id="overlay_close" value="1"<?php if ($lightboxPlusOptions['overlay_close']) echo ' checked="checked"';?> /><br /><?php _e('If checked, enables closing Lightbox Plus by clicking on the background overlay.<br /><strong><em>Default: Checked</em></strong>', 'lightboxplus')?></td>
            </tr>

					  <tr>
              <th scope="row" colspan="2"><h3><?php _e('Slideshow Settings', 'lightboxplus')?></h3></th>
            </tr>

					  <tr>
              <th scope="row"><?php _e('Slideshow', 'lightboxplus')?>: </th>
              <td><input type="checkbox" name="slideshow" id="slideshow" value="1"<?php if ($lightboxPlusOptions['slideshow']) echo ' checked="checked"';?> /><br /><?php _e('If checked, adds slideshow capablity to a content group / gallery. <br /><strong><em>Default: Unchecked</em></strong>', 'lightboxplus')?></td>
            </tr>

					  <tr>
              <th scope="row"><?php _e('Auto-Start Slideshow', 'lightboxplus')?>: </th>
              <td><input type="checkbox" name="slideshow_auto" id="slideshow_auto" value="1"<?php if ($lightboxPlusOptions['slideshow_auto']) echo ' checked="checked"';?> /><br /><?php _e('If checked, the slideshows will automatically start to play when content grou opened. <br /><strong><em>Default: Checked</em></strong>', 'lightboxplus')?></td>
            </tr>

					  <tr>
              <th scope="row"><?php _e('Slideshow Speed', 'lightboxplus')?>: </th>
              <td>
      					<select name="slideshow_speed" id="slideshow_speed">
      					  <option value="500"<?php if ($lightboxPlusOptions['slideshow_speed']=='500') echo ' selected="selected"'?>>500</option>
      					  <option value="1000"<?php if ($lightboxPlusOptions['slideshow_speed']=='1000') echo ' selected="selected"'?>>1000</option>
      					  <option value="1500"<?php if ($lightboxPlusOptions['slideshow_speed']=='1500') echo ' selected="selected"'?>>1500</option>
      					  <option value="2000"<?php if ($lightboxPlusOptions['slideshow_speed']=='2000') echo ' selected="selected"'?>>2000</option>
      					  <option value="2500"<?php if ($lightboxPlusOptions['slideshow_speed']=='2500') echo ' selected="selected"'?>>2500</option>
      					  <option value="3000"<?php if ($lightboxPlusOptions['slideshow_speed']=='3000') echo ' selected="selected"'?>>3000</option>
      					  <option value="3500"<?php if ($lightboxPlusOptions['slideshow_speed']=='3500') echo ' selected="selected"'?>>3500</option>
      					  <option value="4000"<?php if ($lightboxPlusOptions['slideshow_speed']=='4000') echo ' selected="selected"'?>>4000</option>
      					  <option value="4500"<?php if ($lightboxPlusOptions['slideshow_speed']=='4500') echo ' selected="selected"'?>>4500</option>
      					  <option value="5000"<?php if ($lightboxPlusOptions['slideshow_speed']=='5000') echo ' selected="selected"'?>>5000</option>
      					  <option value="5500"<?php if ($lightboxPlusOptions['slideshow_speed']=='5500') echo ' selected="selected"'?>>5500</option>
      					  <option value="6000"<?php if ($lightboxPlusOptions['slideshow_speed']=='6000') echo ' selected="selected"'?>>6000</option>
      					  <option value="6500"<?php if ($lightboxPlusOptions['slideshow_speed']=='6500') echo ' selected="selected"'?>>6500</option>
      					  <option value="7000"<?php if ($lightboxPlusOptions['slideshow_speed']=='7000') echo ' selected="selected"'?>>7000</option>
      					  <option value="7500"<?php if ($lightboxPlusOptions['slideshow_speed']=='7500') echo ' selected="selected"'?>>7500</option>
      					  <option value="8000"<?php if ($lightboxPlusOptions['slideshow_speed']=='8000') echo ' selected="selected"'?>>8000</option>
      					  <option value="8500"<?php if ($lightboxPlusOptions['slideshow_speed']=='8500') echo ' selected="selected"'?>>8500</option>
      					  <option value="9000"<?php if ($lightboxPlusOptions['slideshow_speed']=='9000') echo ' selected="selected"'?>>9000</option>
                  <option value="9500"<?php if ($lightboxPlusOptions['slideshow_speed']=='9500') echo ' selected="selected"'?>>9500</option>
                  <option value="10000"<?php if ($lightboxPlusOptions['slideshow_speed']=='10000') echo ' selected="selected"'?>>10000</option>
                  <option value="11000"<?php if ($lightboxPlusOptions['slideshow_speed']=='11000') echo ' selected="selected"'?>>11000</option>
                  <option value="12000"<?php if ($lightboxPlusOptions['slideshow_speed']=='12000') echo ' selected="selected"'?>>12000</option>
                  <option value="13000"<?php if ($lightboxPlusOptions['slideshow_speed']=='13000') echo ' selected="selected"'?>>13000</option>
                  <option value="14000"<?php if ($lightboxPlusOptions['slideshow_speed']=='14000') echo ' selected="selected"'?>>14000</option>
                  <option value="15000"<?php if ($lightboxPlusOptions['slideshow_speed']=='15000') echo ' selected="selected"'?>>15000</option>
                  <option value="20000"<?php if ($lightboxPlusOptions['slideshow_speed']=='20000') echo ' selected="selected"'?>>20000</option>
      					</select><br /><?php _e('Controls the speed of the slideshow, in milliseconds.<br /><strong><em>Default: 2500</em></strong>', 'lightboxplus')?>
              </td>
            </tr>

					  <tr>
              <th scope="row"><?php _e('Slideshow start text', 'lightboxplus')?>: </th>
              <td><input type="text" size="15" name="slideshow_start" id="slideshow_start" value="<?php if (!empty($lightboxPlusOptions['slideshow_start'])) { echo $lightboxPlusOptions['slideshow_start'];} else { echo 'start'; } ?>" /><br /><?php _e('Text for the slideshow start button. <strong><em>Default: start</em></strong>', 'lightboxplus')?></td>
            </tr>

					  <tr>
              <th scope="row"><?php _e('Slideshow stop text', 'lightboxplus')?>: </th>
              <td><input type="text" size="15" name="slideshow_stop" id="slideshow_stop" value="<?php if (!empty($lightboxPlusOptions['slideshow_stop'])) { echo $lightboxPlusOptions['slideshow_stop'];} else { echo 'stop'; } ?>" /><br /><?php _e('Text for the slideshow stop button.  <strong><em>Default: stop</em></strong>', 'lightboxplus')?></td>
            </tr>

					  <tr>
              <th scope="row" colspan="2"><h3><?php _e('Other Settings', 'lightboxplus')?></h3></th>
            </tr>

					  <tr>
              <th scope="row"><?php _e('Use Class Method', 'lightboxplus')?>: </th>
              <td><input type="checkbox" name="class_method" id="class_method" value="1"<?php if ($lightboxPlusOptions['class_method']) echo ' checked="checked"';?> /><br /><?php _e('If checked, Lightbox Plus will only lightbox images via <code>class: cboxModal</code> attribute.  Using this method you can manually control which images are affected by Lightbox Plus by adding the cboxModal class to the Advanced Link Settings in the WordPress Edit Image tool or by adding it to the image link URL and checking the <strong>Do Not Auto-Lightbox Images</strong> option.<br /><strong><em>Default: Unchecked</em></strong>', 'lightboxplus')?></td>
            </tr>

					  <tr>
              <th scope="row"><?php _e('<strong>Do Not</strong> Auto-Lightbox Images', 'lightboxplus')?>: </th>
              <td><input type="checkbox" name="auto_lightbox" id="auto_lightbox" value="1"<?php if ($lightboxPlusOptions['auto_lightbox']) echo ' checked="checked"';?> /><br /><?php _e('If checked, Lightbox Plus <em>will not</em> automatically add appropriate attibutes (either <code>rel="lightbox[postID]"</code> or <code>class: cpModal</code>) to Image URL.  You will need to manually add the appropriate attribute for Lightbox Plus to work.<br /><strong><em>Default: Unchecked</em></strong>', 'lightboxplus')?></td>
            </tr>

					  <tr>
              <th scope="row"><?php _e('<strong>Do Not</strong> Display Image Title', 'lightboxplus')?>: </th>
              <td><input type="checkbox" name="display_title" id="display_title" value="1"<?php if ($lightboxPlusOptions['display_title']) echo ' checked="checked"';?> /><br /><?php _e('If checked, Lightbox Plus <em>will not</em> display image titles automatically.  This has no effect if the <strong>Do Not Auto-Lightbox Images</strong> option is checked.<br /><strong><em>Default: Unchecked</em></strong>', 'lightboxplus')?></td>
            </tr>


					 </table>
			    <p class="submit">
			      <input type="submit" style="padding:5px 30px 5px 30px;" name="Submit" value="<?php _e('Save settings', 'lightboxplus')?> &raquo;" />
			    </p>
			  </form>

      	<h3><?php _e('About Lightbox Plus for WordPress',"lightboxplus"); ?>: </h3>
      	<div class="inside">
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="float:right;"> <input name="cmd" type="hidden" value="_donations" /> <input name="business" type="hidden" value="dzappone@gmail.com" /> <input name="item_name" type="hidden" value="Dan Zappone" /> <input name="item_number" type="hidden" value="23SDONWP" /> <input name="no_shipping" type="hidden" value="0" /> <input name="no_note" type="hidden" value="1" /> <input name="currency_code" type="hidden" value="EUR" /> <input name="tax" type="hidden" value="0" /> <input name="lc" type="hidden" value="US" /> <input name="bn" type="hidden" value="PP-DonationsBF" /> <input alt="PayPal - The safer, easier way to pay online!" name="submit" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" type="image" /> <img src="https://www.paypal.com/en_US/i/scr/pixel.gif" border="0" alt="" width="1" height="1" />
</form>
					<h4><?php _e('Thank you for downloading and installing Lightbox Plus for WordPress',"lightboxplus"); ?></h4>
					<?php _e('Like many developers I spend a lot of my spare time working on WordPress plugins and themes and any donation to the cause is appreciated.  I know a lot of other developers do the same and I try to donate to them whenever I can.  As a developer I greatly appreciate any donation you can make to help support further development of quality plugins and themes for WordPress.  In keeping with the name of my site <a href="http://www.23systems.net">23Systems</a> a minimum donation of &euro;2.30 to &euro;23.00 is encouraged but I\'ll gladly accept whatever you feel comfortable with. <em>You have my sincere thanks and appreciation</em>.',"lightboxplus"); ?>
						</div>
			</div>
			<?php
    }

    /*---- UTILITY FUNCTIONS ----*/
    /*---- Create clean eols for source ----*/
    function EOL() {
      switch (strtoupper(substr(PHP_OS, 0, 3))) {
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
    function setProperName($styleName) {
      $proper = str_replace('.css', '', $styleName);
      $proper = ucfirst($proper);
      return $proper;
    }

    /*---- Create dropdown name from stylesheet ----*/
    function setBoolean($nValue) {
      switch ($nValue) {
      case 1:
        return 'true';
        break;
      default:
        return 'false';
        break;
      }
    }

    function delete_directory($dirname) {
      if (is_dir($dirname))
        $dir_handle = opendir($dirname);
      if (!$dir_handle)
        return false;
      while($file = readdir($dir_handle)) {
        if ($file != '.' && $file != '..') {
          if (!is_dir($dirname.'/'.$file)) {
            unlink($dirname.'/'.$file);
          } else {
            delete_directory($dirname.'/'.$file);
          }
        }
      }
      closedir($dir_handle);
      rmdir($dirname);
      return true;
    }

    function delete_file($dirname,$file) {
      if ($file != '.' && $file != '..') {
        if (!is_dir($dirname.'/'.$file)) { unlink($dirname.'/'.$file); }
        return true;
      }
    }

    function dirList ($dirname) {
  		$types = array ('css');
  		$results = array ();
  		$dir_handle = opendir($dirname);
  		while ($file = readdir($dir_handle)) {
    		$type = strtolower(substr(strrchr($file, '.'), 1));
    		if (in_array($type, $types)) { array_push($results, $file);	}
      }
  		closedir($dir_handle);
  		sort($results);
      return $results;
    }

  } /*---- END CLASS ----*/
}

/*---- instantiate the class  ----*/
if (class_exists('wp_lightboxplus')) { $wp_lightboxplus = new wp_lightboxplus(); }