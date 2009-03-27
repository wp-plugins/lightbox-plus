<?php
/*
Plugin Name: Lightbox Plus
Plugin URI: http://www.23systems.net/plugins/lightbox-plus/
Description: Lightbox permits users to view larger versions of images without having to leave the current page, and is also able to display simple slideshows. The use of the dark or light background, which dims the page over which the image has been overlaid, also serves to highlight the image being viewed. Lightbox JS by <a href="http://www.huddletogether.com/projects/lightbox/">Lokesh Dhakar</a>.
Author: Dan Zappone 
Author URI: http://www.danzappone.com/
Version: 1.3.2
*/
/*---- 3/27/2009 12:48:47 PM ----*/
global $post, $content;  // WordPress Globals
global $g_lightbox_plus_url;
$g_lightbox_plus_url = WP_PLUGIN_URL.'/lightbox-plus';
load_plugin_textdomain('lightboxplus', $path = $g_lightbox_plus_url);
if (!class_exists('wp_lightboxplus')) {

  class wp_lightboxplus {

    /*---- The name the options are saved under in the database ----*/
    var $lightboxOptionsName = "lightboxplus_options";
    var $lightboxInitName = "lightboxplus_init";

    /*---- PHP 4 Compatible Constructor ----*/
    function wp_lightboxplus() {
      $this->__construct();
    }

    /*---- PHP 5 Constructor ----*/
    function __construct() {
      add_action("admin_menu", array(&$this, "lightboxPlusAddPages"));
      add_action('wp_head', array(&$this, 'lightboxPlusAddHeader'));
      add_filter('the_content', array(&$this, 'lightboxPlusReplace'));
      add_action("init", array(&$this, "addScripts"));
      $this->lightboxOptions = $this->getAdminOptions($this->lightboxOptionsName);
      $this->lightboxInit = get_option($this->lightboxInitName);
			if (!$this->lightboxInit) {
		  	$this->lightboxPlusInit();
			}
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
      wp_enqueue_script('lightbox', $g_lightbox_plus_url.'/js/lightbox.js', array('scriptaculous-builder', 'scriptaculous-effects', 'prototype'));
    }

    function lightboxPlusReplace($content) {
      global $post;
			$pattern[0]     = "/<a(.*?)href=('|\")([A-Za-z0-9\/_\.\~\:-]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")([^\>]*?)><img(.*?)title=('|\")([a-zA-Z0-9\s-_!&?^$.;:|*+\[\]{}()#%]*)('|\")([^\>]*?)\/>/i";
			$pattern[1]     = "/<a(.*?)href=('|\")([A-Za-z0-9\/_\.\~\:-]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")(.*?)(rel=('|\")lightbox(.*?)('|\"))([ \t\r\n\v\f]*?)((rel=('|\")lightbox(.*?)('|\"))?)([ \t\r\n\v\f]?)([^\>]*?)>/i";
			$replacement[0] = '<a$1href=$2$3$4$5$6 title="$9" rel="lightbox['.$post->ID.']"><img$7title=$8$9$10$11/>';
			$replacement[1] = '<a$1href=$2$3$4$5$6$7>';
      $content        = preg_replace($pattern, $replacement, $content);
      return $content;
    }

    function lightboxPlusAddHeader() {
      global $g_lightbox_plus_url;
    	if (!empty($this->lightboxOptions)) {
				$lightboxPlusOptions   = $this->getAdminOptions($this->lightboxOptionsName);
	      $themeStyle            = $lightboxPlusOptions['lightboxplus_style'];
	      $loadingImage          = $lightboxPlusOptions['loading_image'];
	      $closeImage            = $lightboxPlusOptions['close_image'];
	      $overlayOpacity        = $lightboxPlusOptions['overlay_opacity'];
	      $resizeSpeed           = $lightboxPlusOptions['resize_speed'];
	      $resizeAnimate         = $lightboxPlusOptions['animate'];
	      $borderSize            = $lightboxPlusOptions['border_size'];
	      $labelImage            = $lightboxPlusOptions['label_image'];
	      $labelOf               = $lightboxPlusOptions['label_of'];
			}
    
    
      $lightboxPlusJavaScript = "";
      $lightboxPlusJavaScript .= '<script type="text/javascript">'.$this->endLine();
      $lightboxPlusJavaScript .= "LightboxOptions = Object.extend({".$this->endLine();
      $lightboxPlusJavaScript .= "fileLoadingImage:        '".$loadingImage."',".$this->endLine();
      $lightboxPlusJavaScript .= "fileBottomNavCloseImage: '".$closeImage."',".$this->endLine();

      $lightboxPlusJavaScript .= "overlayOpacity: ".$overlayOpacity.",".$this->endLine();

      $lightboxPlusJavaScript .= "animate: ".$resizeAnimate.",".$this->endLine();
      $lightboxPlusJavaScript .= "resizeSpeed: ".$resizeSpeed.",".$this->endLine();

      $lightboxPlusJavaScript .= "borderSize: ".$borderSize.",".$this->endLine();

      $lightboxPlusJavaScript .= 'labelImage: "'.$labelImage.'",'.$this->endLine();
      $lightboxPlusJavaScript .= 'labelOf: "'.$labelOf.'",'.$this->endLine();
      $lightboxPlusJavaScript .= "}, window.LightboxOptions || {});".$this->endLine();
      $lightboxPlusJavaScript .= "</script>".$this->endLine();

      echo $lightboxPlusJavaScript;

//      $lightboxPlusPath = get_option('siteurl')."/wp-content/plugins/lightbox-plus";
      $lightboxPlusStyleSheet = '<link rel="stylesheet" type="text/css" href="'.$g_lightbox_plus_url.'/css/'.$themeStyle.'" media="screen" />'.$this->endLine();
      echo $lightboxPlusStyleSheet;
    }

    function lightboxPlusAddPages() {
      add_submenu_page('themes.php', "Lightbox Plus", "Lightbox Plus", 10, "lightboxplus", array(&$this, "lightboxPlusAdminPanel"));
    }

		/*---- Add some default options if they don't exist ----*/
		function lightboxPlusInit() {
			global $g_lightbox_plus_url;
			$oldOptions = get_option('lightboxplus_style');
			if (!empty($oldOptions)) {
				delete_option('lightboxplus_style');
			}
			add_option('lightboxplus_init', true);
			
			$themeStyle         = $_POST[lightboxplus_style];
			$loadingImage       = $_POST[loading_image];
			$closeImage         = $_POST[close_image];
			$overlayOpacity			= $_POST[overlay_opacity];
			$resizeSpeed        = $_POST[resize_speed];
			$resizeAnimate      = $_POST[animate];
			$borderSize		      = $_POST[border_size];
			$labelImage         = $_POST[label_image];
			$labelOf            = $_POST[label_of];
			$lightboxPlusOptions = array(
					"lightboxplus_style"       => 'white.css',
					"loading_image"            => $g_lightbox_plus_url.'/images/loading.gif',
					"close_image"              => $g_lightbox_plus_url.'/images/close.png',
					"overlay_opacity"					 => '0.8',
					"resize_speed"						 => '7',
					"animate"							     => true,
					"border_size"              => '10',
					"label_image"              => 'Image',
					"label_of"                 => 'of',
			);
			
			$this->saveAdminOptions($this->lightboxOptionsName, $lightboxPlusOptions);
		}

    function lightboxPlusAdminPanel() {
      global $g_lightbox_plus_url;
      load_plugin_textdomain('lightboxplus', $path = $g_lightbox_plus_url);
      $location = get_option('siteurl').'/wp-admin/admin.php?page=lightboxplus';

      /*---- Where the styles reside ----*/
      $stylePath = (dirname(__FILE__)."/css");
      update_option('lightboxplus_style_path', $stylePath);

      /*check form submission and update options*/
      if ('process' == $_POST['stage']) {
				$themeStyle        = $_POST[lightboxplus_style];
        $loadingImage      = $_POST[loading_image];
        $closeImage        = $_POST[close_image];
        $overlayOpacity		 = $_POST[overlay_opacity];
        $resizeSpeed       = $_POST[resize_speed];
        $resizeAnimate     = $_POST[animate];
        $borderSize		     = $_POST[border_size];
        $labelImage        = $_POST[label_image];
        $labelOf           = $_POST[label_of];
        $lightboxPlusOptions = array(
            "lightboxplus_style"       => $themeStyle,
            "loading_image"            => $loadingImage,
            "close_image"              => $closeImage,
            "overlay_opacity"					 => $overlayOpacity,
            "resize_speed"						 => $resizeSpeed,
            "animate"							     => $resizeAnimate,
            "border_size"              => $borderSize,
            "label_image"              => $labelImage,
            "label_of"                 => $labelOf,
          );

			  $this->saveAdminOptions($this->lightboxOptionsName, $lightboxPlusOptions);
      }
      
      /*---- Get options to load in form ----*/
			if (!empty($this->lightboxOptions)) {
				$lightboxPlusOptions    = $this->getAdminOptions($this->lightboxOptionsName);
	      $themeStyle             = $lightboxPlusOptions['lightboxplus_style'];
	      $loadingImage           = $lightboxPlusOptions['loading_image'];
	      $closeImage             = $lightboxPlusOptions['close_image'];
	      $overlayOpacity         = $lightboxPlusOptions['overlay_opacity'];
	      $resizeSpeed            = $lightboxPlusOptions['resize_speed'];
	      $resizeAnimate          = $lightboxPlusOptions['animate'];
	      $borderSize             = $lightboxPlusOptions['border_size'];
	      $labelImage             = $lightboxPlusOptions['label_image'];
	      $labelOf                = $lightboxPlusOptions['label_of'];
			}
					
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
?>
			<div class="wrap">
				  <h2><?php _e('Lightbox Plus Options', 'lightboxplus')?></h2>
				  <form name="form1" method="post" action="<?php echo $location?>&amp;updated=true">
					<input type="hidden" name="stage" value="process" />
					<table class="form-table">
					  <tr valign="top">
						<th scope="row"><?php _e('Lightbox Plus Style', 'lightboxplus')?>: </th>
						<td>
      			<select name="lightboxplus_style">
<?php
      foreach ($styles as $key => $value) {
        if ($themeStyle == urlencode($key)) {
          echo("<option value=\"".urlencode($key)."\" selected=\"selected\">".$this->setProperName($key)."</option>\n");
        }
        else {
          echo("<option value=\"".urlencode($key)."\">".$this->setProperName($key)."</option>\n");
        }
      }
?>
      			</select>         
			         </td>
					  </tr>
					  <tr>
              <th scope="row"><?php _e('Loading Image', 'lightboxplus')?>: </th>
              <td><input type="text" size="80" name="loading_image" id="loading_image" value="<?php if (!empty($loadingImage)) { echo $loadingImage;} else { echo $g_lightbox_plus_url.'/images/loading.gif'; } ?>" /><br /><?php _e('Full path location of the image to use while loading.  Verify this is correct. Adjust as needed or change to your preference.', 'lightboxplus')?></td>
            </tr>
					  <tr>
              <th scope="row"><?php _e('Close Image', 'lightboxplus')?>: </th>
              <td><input type="text" size="80" name="close_image" id="close_image" value="<?php if (!empty($closeImage)) { echo $closeImage;} else { echo $g_lightbox_plus_url.'/images/closelabel.gif'; } ?>" /><br /><?php _e('Full path location of the image to use as a close button. Verify this is correct. Adjust as needed or change to your preference.', 'lightboxplus')?></td>
            </tr>
					  <tr>
              <th scope="row"><?php _e('Overlay Opacity', 'lightboxplus')?>: </th>
              <td>
      					<select name="overlay_opacity">
      					  <option value="0.1"<?php if ($overlayOpacity=='0.1') echo ' selected="selected"'?>>10%</option>
      					  <option value="0.2"<?php if ($overlayOpacity=='0.2') echo ' selected="selected"'?>>20%</option>
      					  <option value="0.3"<?php if ($overlayOpacity=='0.3') echo ' selected="selected"'?>>30%</option>
      					  <option value="0.4"<?php if ($overlayOpacity=='0.4') echo ' selected="selected"'?>>40%</option>
      					  <option value="0.5"<?php if ($overlayOpacity=='0.5') echo ' selected="selected"'?>>50%</option>
      					  <option value="0.6"<?php if ($overlayOpacity=='0.6') echo ' selected="selected"'?>>60%</option>
      					  <option value="0.7"<?php if ($overlayOpacity=='0.7') echo ' selected="selected"'?>>70%</option>
      					  <option value="0.8"<?php if ($overlayOpacity=='0.8') echo ' selected="selected"'?>>80%</option>
      					  <option value="0.9"<?php if ($overlayOpacity=='0.9') echo ' selected="selected"'?>>90%</option>
      					  <option value="1.0"<?php if ($overlayOpacity=='1.0') echo ' selected="selected"'?>>100%</option>
      					</select><br /><?php _e('Controls transparency of shadow overlay<br /><strong><em>Default: 80%</em></strong>', 'lightboxplus')?>
              </td>
            </tr>
					  <tr>
              <th scope="row"><?php _e('Animate', 'lightboxplus')?>: </th>
              <td><input type="checkbox" name="animate" value="1"<?php if ($resizeAnimate) echo ' checked="checked"';?> /><br /><?php _e('Toggles resizing animations<br /><strong><em>Default: Checked</em></strong>', 'lightboxplus')?></td>
            </tr>
					  <tr>
              <th scope="row"><?php _e('Resize Speed', 'lightboxplus')?>: </th>
              <td>
      					<select name="resize_speed" id="resize_speed">
      					  <option value="1"<?php if ($resizeSpeed=='1') echo ' selected="selected"'?>>1</option>
      					  <option value="2"<?php if ($resizeSpeed=='2') echo ' selected="selected"'?>>2</option>
      					  <option value="3"<?php if ($resizeSpeed=='3') echo ' selected="selected"'?>>3</option>
      					  <option value="4"<?php if ($resizeSpeed=='4') echo ' selected="selected"'?>>4</option>
      					  <option value="5"<?php if ($resizeSpeed=='5') echo ' selected="selected"'?>>5</option>
      					  <option value="6"<?php if ($resizeSpeed=='6') echo ' selected="selected"'?>>6</option>
      					  <option value="7"<?php if ($resizeSpeed=='7') echo ' selected="selected"'?>>7</option>
      					  <option value="8"<?php if ($resizeSpeed=='8') echo ' selected="selected"'?>>8</option>
      					  <option value="9"<?php if ($resizeSpeed=='9') echo ' selected="selected"'?>>9</option>
      					  <option value="10"<?php if ($resizeSpeed=='10') echo ' selected="selected"'?>>10</option>
      					</select><br /><?php _e('Controls the speed of the image resizing animations (1=slowest and 10=fastest)<br /><strong><em>Default: 7</em></strong>', 'lightboxplus')?>
              </td>
            </tr>
					  <tr>
              <th scope="row"><?php _e('Border Size', 'lightboxplus')?>: </th>
              <td><input type="text" size="15" name="border_size" id="border_size" value="<?php if (!empty($borderSize)) { echo $borderSize;} else { echo '10'; } ?>" /><br /><?php _e('if you adjust the padding in the CSS, you will need to update this variable.<strong><em>Default: 10</em></strong>', 'lightboxplus')?></td>
            </tr>
					  <tr>
              <th scope="row"><?php _e('Labels for "Image # of #"', 'lightboxplus')?>: </th>
              <td><input type="text" size="15" name="label_image" id="label_image" value="<?php if (empty($labelImage)) { echo 'Image'; } else {echo $labelImage;}?>" /> # <input type="text" size="15" name="label_of" id="label_of" value="<?php if (empty($labelOf)) { echo 'of'; } else {echo $labelOf;}?>" /> #<br /><?php _e('When grouping images this is used to write: Image # of #. Change it for non-english localization.<strong><em>Default: Image # of #</em></strong>', 'lightboxplus')?></td>
            </tr>
					 </table>
			    <p class="submit">
			      <input type="submit" name="Submit" value="<?php _e('Save options', 'lightboxplus')?> &raquo;" />
			    </p>
			  </form>

      	<h3><?php _e('About Lightbox Plus for WordPress',"lightboxplus"); ?>: </h3>
      	<div class="inside">
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="float:right;"> <input name="cmd" type="hidden" value="_donations" /> <input name="business" type="hidden" value="dzappone@gmail.com" /> <input name="item_name" type="hidden" value="Dan Zappone" /> <input name="item_number" type="hidden" value="23SDONWP" /> <input name="no_shipping" type="hidden" value="0" /> <input name="no_note" type="hidden" value="1" /> <input name="currency_code" type="hidden" value="EUR" /> <input name="tax" type="hidden" value="0" /> <input name="lc" type="hidden" value="US" /> <input name="bn" type="hidden" value="PP-DonationsBF" /> <input alt="PayPal - The safer, easier way to pay online!" name="submit" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" type="image" /> <img src="https://www.paypal.com/en_US/i/scr/pixel.gif" border="0" alt="" width="1" height="1" />
</form>
					<h4><?php _e('Thank you for downloading and installing Lightbox Plus for WordPress',"lightboxplus"); ?></h4>
					<?php _e('Like many developers I spend a lot of my spare time working on WordPress plugins and themes and any donation to the cause is appreciated.  I know a lot of other developers do the same and I try to donate to them whenever I can.  As a developer I greatly appreciate any donation you can make to help support further development of quality plugins and themes for WordPress.  In keeping with the name of my site <a href="http://www.23systems.net">23Systems</a> a minimum donation of &euro;2.30 is encouraged but I\'ll gladly accept whatever you feel comfortable with. <em>You have my sincere thanks and appreciation</em>.',"lightboxplus"); ?>
						</div>
			</div>
			<?php
    }

    /*---- UTILITY FUNCTIONS ----*/
    /*---- Create clean eols for source ----*/
    function endLine() {
      if (strtoupper(substr(PHP_OS, 0, 3) == 'WIN')) {
        $eol = "\r\n";
      }
      elseif (strtoupper(substr(PHP_OS, 0, 3) == 'MAC')) {
        $eol = "\r";
      }
      else {
        $eol = "\n";
      }
      return $eol;
    }

		/*---- Create dropdown name from stylesheet ----*/
    function setProperName($styleName) {
      $proper = str_replace('.css', '', $styleName);
      $proper = ucfirst($proper);
      return $proper;
    }
  }
}

/*---- instantiate the class  ----*/
if (class_exists('wp_lightboxplus')) {
  $wp_lightboxplus = new wp_lightboxplus();
}