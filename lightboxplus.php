<?php
/*
Plugin Name: Lightbox Plus
Plugin URI: http://www.23systems.net/plugins/lightbox-plus/
Description: Used to overlay images on the webpage and to automatically add links to images. Lightbox JS by <a href="http://www.huddletogether.com/projects/lightbox/">Lokesh Dhakar</a>.
Author: Dan Zappone 
Author URI: http://www.danzappone.com/
Version: 1.0.1
Put in /wp-content/plugins/ of your Wordpress installation

Copyright 2008  Dan Zappone  (email : dzapppone@23systems.net)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/
global $lightbox_plus_path;
$lightbox_plus_path = 'wp-content/plugins/lightbox-plus';
load_plugin_textdomain('lightboxplus',$path = $lightbox_plus_path);

wp_enqueue_script('lightbox', '/wp-content/plugins/lightbox-plus/js/lightbox.js', array('scriptaculous-builder','scriptaculous-effects','prototype') );

function lightbox_plus_replace ($content)
{   
	global $post;

	$pattern[0] = "/<a(.*?)href=('|\")([A-Za-z0-9\/_\.\~\:-]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")([^\>]*?)><img(.*?)title=('|\")([a-zA-Z0-9\s-_!&?^$.;:|*+\[\]{}()#%]*)('|\")([^\>]*?)\/>/i";
	$pattern[1] = "/<a(.*?)href=('|\")([A-Za-z0-9\/_\.\~\:-]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")(.*?)(rel=('|\")lightbox(.*?)('|\"))([ \t\r\n\v\f]*?)((rel=('|\")lightbox(.*?)('|\"))?)([ \t\r\n\v\f]?)([^\>]*?)>/i";
	$replacement[0] = '<a$1href=$2$3$4$5$6 title="$9" rel="lightbox['.$post->ID.']"><img$7title=$8$9$10$11/>';
	$replacement[1] = '<a$1href=$2$3$4$5$6$7>';
	$content = preg_replace($pattern, $replacement, $content);
	return $content;

	return $content;
}

function lightboxplus_styles() {
	$lightbox_path = get_option('siteurl')."/wp-content/plugins/lightbox-plus";
	$lightboxstyle  = '<link rel="stylesheet" type="text/css" href="'.$lightbox_path.'/css/'.get_option('lightboxplus_style').'" media="screen" />';

	echo $lightboxstyle;
}

function lightbox_plus_add_pages() {
    add_options_page('Lightbox Plus', 'Lightbox Plus', 8, 'lightboxplus.php', 'lightbox_plus_admin_panel');
}

function lightbox_plus_admin_panel() {
   load_plugin_textdomain('lightboxplus',$path = $lightbox_plus_path);
	$location = get_option('siteurl') . '/wp-admin/admin.php?page=lightboxplus.php'; // Form Action URI
	/*Lets add some default options if they don't exist*/
   add_option('lightboxplus_style', 'white.css');
	
   /* Where our theme reside: */
   $lightboxplus_style_path = (dirname(__FILE__)."/css");
   update_option('lightboxplus_style_path', $lightboxplus_style_path);
	
	/*check form submission and update options*/
	if ('process' == $_POST['stage'])
	{
   	update_option('lightboxplus_style', $_POST['lightboxplus_style']);
	}
?>
<div class="wrap">
	  <h2><?php _e('Lightbox Plus Options', 'lightboxplus') ?></h2>
	  <form name="form1" method="post" action="<?php echo $location ?>&amp;updated=true">
		<input type="hidden" name="stage" value="process" />
		<table width="100%" cellspacing="2" cellpadding="5" class="editform">
		  <tr valign="top">
			<th scope="row"><?php _e('Lightbox Plus Style') ?></th>
			<td>
<?php
/* Check if there are themes: */
$lightboxplus_style_path =  get_option('lightboxplus_style_path');

if ($handle = opendir($lightboxplus_style_path)) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && $file != ".DS_Store") {
            $styles[$file] = $lightbox_plus_theme_path."/".$file."/";
        }   
    }
    closedir($handle);
}

/* Create a drop-down menu of the valid themes: */
echo("\n<select name=\"lightboxplus_style\">\n");
$current_theme = get_option('lightboxplus_style');
foreach($styles as $shortname => $fullpath) {
   if($current_theme == urlencode($shortname)) {
      echo("<option value=\"".urlencode($shortname)."\" selected=\"selected\">".setname($shortname)."</option>\n");
   } else {
      echo("<option value=\"".urlencode($shortname)."\">".setname($shortname)."</option>\n");
   }
}
echo("\n</select>");
?>         
         </td>
		  </tr>
		 </table>
    <p class="submit">
      <input type="submit" name="Submit" value="<?php _e('Select Style', 'lightboxplus') ?> &raquo;" />
    </p>
  </form>
</div>
<?php
}

function setname($stylename) {
   $proper = str_replace('.css','',$stylename);
   $proper = ucfirst($proper);
   return $proper;
}

add_action('admin_menu', 'lightbox_plus_add_pages');
add_filter('wp_head', 'lightboxplus_styles');
add_filter('the_content', 'lightbox_plus_replace');

?>