<?php
/**
 * @package    Lightbox Plus Colorbox
 * @subpackage admin-lightbox.php
 * @internal   2013.01.16
 * @author     Dan Zappone / 23Systems
 * @version    2.7
 * @$Id: admin-lightbox.php 937943 2014-06-24 17:06:54Z dzappone $
 * @$URL: http://plugins.svn.wordpress.org/lightbox-plus/trunk/admin/admin-lightbox.php $
 */

global $g_lbp_base_options;
global $g_lbp_primary_options;
global $g_lbp_secondary_options;
global $g_lbp_inline_options;
global $wp_version;

/**
 * Check if there are styles
 *
 * @var mixed
 */
if ( $g_lbp_base_options['use_custom_style'] == 1 ) {
	$st_style_path = LBP_CUSTOM_STYLE_PATH;
} else {
	$st_style_path = LBP_STYLE_PATH;
}

if ( $handle = opendir( $st_style_path ) ) {
	while ( false !== ( $file = readdir( $handle ) ) ) {
		if ( $file != "." && $file != ".." && $file != ".DS_Store" && $file != ".svn" && $file != "index.html" ) {
			$styles[ $file ] = $st_style_path . "/" . $file . "/";
		}
	}
	closedir( $handle );
}

/**
 * Remove following line after a few versions or 2.6 is the prevelent version
 */
if ( isset( $g_lbp_base_options ) ) {
	$g_lbp_base_options = $this->set_missing_options( $g_lbp_base_options );
}
?>
<!-- About Lightbox Plus Colorbox for WordPress -->
<div id="poststuff-about" class="lbp poststuff">
	<div class="postbox<?php if ( $g_lbp_base_options['hide_about'] ) {
		echo ' close-me';
	} ?>">
		<h3 class="handle"><?php _e( 'About Lightbox Plus Colorbox for WordPress', 'lightboxplus' ); ?></h3>

		<div class="inside toggle">
			<div class="donate">
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="hosted_button_id" value="BKVLWU2KWRNAG">
					<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" name="submit" alt="PayPal - The safer, easier way to pay online!">
					<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
				</form>
				<hr class="lbp_hr" />
				<h3>
					<a href="http://premium.wpmudev.org/blog/donate-1-to-every-free-wordpress-plugin-you-use/" title="Why Donate?">Why Should I Donate?</a>
				</h3>
			</div>
			<h4><?php _e( 'Thank you for downloading and installing Lightbox Plus Colorbox for WordPress', 'lightboxplus' ); ?></h4>

			<p style="text-align: justify;">
				<?php _e( 'Lightbox Plus Colorbox implements Colorbox as a lightbox image overlay tool for WordPress.  Colorbox was created by <a href="http://www.jacklmoore.com/colorbox">Jack Moore</a> and is licensed under the MIT License. Lightbox Plus Colorbox allows you to easily integrate and customize a powerful and light-weight lightbox plugin for jQuery into your WordPress site.  You can easily create additional styles by adding a new folder to the css directory under <code>wp-content/plugins/lightbox-plus/asset/lbp-css/</code> by duplicating and modifying any of the existing themes or using them as examples to create your own.  Lightbox Plus Colorbox uses the built in WordPress jQuery library. Lightbox Plus Colorbox also uses the <a href="http://simplehtmldom.sourceforge.net/" title="PHP Simple HTML DOM Parser">PHP Simple HTML DOM Parser</a> helper class to navigate page content for inserting the Lightbox attributes into elements. See the <a href="http://www.23systems.net/plugins/lightbox-plus/">changelog</a> for important details on this upgrade.', 'lightboxplus' ); ?>
			</p>

			<p style="text-align: justify;">
				<?php _e( 'I spend as much of my spare time as possible working on <strong>Lightbox Plus Colorbox</strong> and any donation is appreciated. Donations play a crucial role in supporting Free and Open Source Software projects. So why are donations important? As a developer the more donations I receive the more time I can invest in working on <strong>Lightbox Plus Colorbox</strong>. Donations help cover the cost of hardware for development and to pay hosting bills. This is critical to the development of free software. I know a lot of other developers do the same and I try to donate to them whenever I can. As a developer I greatly appreciate any donation you can make to help support further development of quality plugins and themes for WordPress.', 'lightboxplus' ); ?>
			</p>
			<h4><?php _e( 'You have my sincere thanks and appreciation for using <em>Lightbox Plus Colorbox</em>.', 'lightboxplus' ); ?></h4>

			<div class="clear"></div>
		</div>
	</div>
</div>
<?php flush(); ?>
<!-- Settings/Options -->
<form name="lightboxplus-settings" id="lightboxplus-settings" method="post" action="<?php echo LBP_ADMIN_PAGE; ?>">
<input type="hidden" name="action" value="basic" />
<input type="hidden" name="sub" id="basic-sub" value="settings" />

<div id="poststuff-settings" class="lbp poststuff">
<div class="postbox">
<h3 class="handle"><?php _e( 'Lightbox Plus Colorbox - Basic Settings', 'lightboxplus' ); ?></h3>

<div class="inside toggle">
<div id="blbp-tabs">
<ul>
	<li><a href="#blbp-tabs-1"><?php _e( 'General', 'lightboxplus' ); ?></a></li>
	<li><a href="#blbp-tabs-2"><?php _e( 'Styles', 'lightboxplus' ); ?></a></li>
	<li><a href="#blbp-tabs-3"><?php _e( 'Advanced', 'lightboxplus' ); ?></a></li>
	<li><a href="#blbp-tabs-4"><?php _e( 'Support', 'lightboxplus' ); ?></a></li>

</ul>
<!-- General -->
<div id="blbp-tabs-1">
	<table class="form-table">
		<tr>
			<th scope="row">
				<label for="lightboxplus_multi"><?php _e( 'Use Secondary Lightbox', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="lightboxplus_multi" value="0">
				<input type="checkbox" name="lightboxplus_multi" id="lightboxplus_multi" class="tooltip" value="1"<?php checked( '1', $g_lbp_base_options['lightboxplus_multi'] ); ?> title="<?php _e( 'If checked, Lightbox Plus Colorbox will create a secondary lightbox with an additional set of controls.  This secondary lightbox can be used to create inline or iFramed content using a class to specify the content. DEFAULT: Unchecked', 'lightboxplus' ) ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="use_inline"><?php _e( 'Add Inline Lightboxes', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="use_inline" value="0">
				<input type="checkbox" name="use_inline" id="use_inline" value="1"<?php checked( '1', $g_lbp_base_options['use_inline'] ); ?> title="<?php _e( 'If checked, Lightbox Plus Colorbox will add the selected number of additional lightboxes that you can use to manual add inline lightboxed content to.  Additional controls will be available at the bottom of the Lightbox Plus Colorbox admin page. DEFAULT: Unchecked', 'lightboxplus' ) ?>" />
			</td>
		</tr>
		<tr class="base_gen">
			<th scope="row">
				<label for="inline_num"><?php _e( 'Number of Inline Lightboxes:', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<select name="inline_num" id="inline_num" title="<?php _e( 'Select the number of inline lightboxes (up to 1000). There is a performance hit after about 100. DEFAULT: 5', 'lightboxplus' ) ?>">
					<?php
					for ( $i = 1; $i <= 51; ) {
						?>
						<option value="<?php echo $i; ?>"<?php selected( $i, $g_lbp_base_options['inline_num'] ); ?>><?php echo $i; ?></option>
						<?php
						if ( 10 <= $i ) {
							$i += 5;
						} else {
							$i += 1;
						}
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="output_htmlv"><?php _e( 'Output Valid HTML5', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="output_htmlv" value="0">
				<input type="checkbox" name="output_htmlv" id="output_htmlv" value="1"<?php checked( '1', $g_lbp_base_options['output_htmlv'] ); ?> title="<?php _e( 'If checked Lightbox Plus Colorbox will create valid HTML5 lightbox links. DEFAULT: Unchecked', "lightboxplus" ); ?>" />
			</td>
		</tr>
		<tr class="htmlv_settings lbp-closed">
			<th scope="row">
				<label for="data_name"><?php _e( 'HTML Data attribute', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				data-<input type="text" size="15" title="<?php _e( 'Specify HTML5 data attribute to use or leave as default. DEFAULT: lightboxplus', "lightboxplus" ); ?>" name="data_name" id="data_name" value="<?php if ( empty( $g_lbp_base_options['data_name'] ) ) {
					echo 'lightboxplus';
				} else {
					echo $g_lbp_base_options['data_name'];
				} ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="disable_mobile"><?php _e( 'Disable for mobile devices', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="disable_mobile" value="0">
				<input type="checkbox" name="disable_mobile" id="disable_mobile" value="1"<?php checked( '1', $g_lbp_base_options['disable_mobile'] ); ?> title="<?php _e( 'If checked disable lightbox effect on mobile devices. This will disable Lightbox Plus Colorbox for all phones and tablets. Uses wp_is_mobile() for detection. DEFAULT: Unchecked', "lightboxplus" ); ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="hide_about"><?php _e( 'Hide "About Lightbox Plus Colorbox"', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="hide_about" value="0">
				<input type="checkbox" name="hide_about" id="hide_about" value="1"<?php checked( '1', $g_lbp_base_options['hide_about'] ); ?> title="<?php _e( "If checked will keep 'About Lightbox Plus Colorbox for WordPress' closed. DEFAULT: Unchecked", 'lightboxplus' ) ?>" />
			</td>
		</tr>
	</table>
</div>
<!-- Styles -->
<div id="blbp-tabs-2">
	<table class="form-table">
		<tr valign="top">
			<th scope="row">
				<label for="lightboxplus_style"><?php _e( 'Lightbox Plus Colorbox Style', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<select name="lightboxplus_style" id="lightboxplus_style" title="<?php _e( 'Select Lightbox Plus Colorbox theme/style here. DEFAULT: Shadowed', "lightboxplus" ); ?>">
					<?php
					foreach ( $styles as $key => $value ) {
						if ( $g_lbp_base_options['lightboxplus_style'] == urlencode( $key ) ) {
							echo '<option value="' . urlencode( $key ) . '" selected="selected">' . $this->set_proper_name( $key ) . '</option>' . PHP_EOL;
						} else {
							echo '<option value="' . urlencode( $key ) . '">' . $this->set_proper_name( $key ) . '</option>' . PHP_EOL;
						}
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<?php _e( 'Example Style', 'lightboxplus' ) ?>:
			</th>
			<td>
				<div id="lbp-style-screenshot" class="lbp-help" title="<?php _e( 'Example showing the look and feel of the selected style', 'lightboxplus' ) ?>">
					<?php
					if ( $g_lbp_base_options['use_custom_style'] == 1 ) {
						$style_path_url = LBP_CUSTOM_STYLE_URL;
					} else {
						$style_path_url = LBP_STYLE_URL;
					}
					foreach ( $styles as $key => $value ) {
						if ( $g_lbp_base_options['lightboxplus_style'] == urlencode( $key ) ) {
							echo( '<img src="' . $style_path_url . '/' . urlencode( $key ) . '/sample.jpg" class="lbp-sample-current" id="lbp-sample-' . urlencode( $key ) . '" />' . PHP_EOL );
						} else {
							echo( '<img src="' . $style_path_url . '/' . urlencode( $key ) . '/sample.jpg" class="lbp-sample" id="lbp-sample-' . urlencode( $key ) . '" />' . PHP_EOL );
						}
					}
					?>
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="use_custom_style"><?php _e( 'Use Custom Styles', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="use_custom_style" value="0" />
				<input type="checkbox" name="use_custom_style" id="use_custom_style" value="1"<?php checked( '1', $g_lbp_base_options['use_custom_style'] ); ?> title="<?php _e( 'If checked, the built in stylsheets for Lightbox Plus Colorbox will be located at wp-content/lbp-css.  Lightbox Plus Colorbox will attempt to create this directory and copy default styles to it.  This will allow you to create custom styles in that directory with fear of the styles being deleted when you upgrade he plugin. DEFAULT: Unchecked', 'lightboxplus' ) ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="disable_css"><?php _e( 'Disable Lightbox CSS', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="disable_css" value="0" />
				<input type="checkbox" name="disable_css" id="disable_css" value="1"<?php checked( '1', $g_lbp_base_options['disable_css'] ); ?> title="<?php _e( 'If checked, the built in stylsheets for Lightbox Plus Colorbox will be disabled.  This will allow you to include customized Lightbox Plus Colorbox styles in your theme stylesheets which can reduce files loaded, and making editing easier. Note, that if you do not have the Lightbox styles set in your stylesheet your Lightboxed images will appear at the top of your page. DEFAULT: Unchecked', 'lightboxplus' ) ?>" />
			</td>
		</tr>
	</table>
</div>
<!-- Advanced -->
<div id="blbp-tabs-3">
	<table class="form-table">
		<tr>
			<th scope="row">
				<label for="use_perpage"><?php _e( 'Use page/post options', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="use_perpage" value="0">
				<input type="checkbox" name="use_perpage" id="use_perpage" value="1"<?php checked( '1', $g_lbp_base_options['use_perpage'] ); ?> title="<?php _e( 'If checked allows you specify which posts or pages to load Lightbox Plus Colorbox on while writing the page or set for blog/single posts. DEFAULT: Unchecked', "lightboxplus" ); ?>" />
			</td>
		</tr>
		<tr class="base_blog">
			<th scope="row">
				<label for="use_forpage"><?php _e( 'Use for page', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="use_forpage" value="0">
				<input type="checkbox" name="use_forpage" id="use_forpage" value="1"<?php checked( '1', $g_lbp_base_options['use_forpage'] ); ?> title="<?php _e( 'If checked allows you specify which pages to load Lightbox Plus Colorbox on while writing the page. DEFAULT: Unchecked', "lightboxplus" ); ?>" />
			</td>
		</tr>
		<tr class="base_blog">
			<th scope="row">
				<label for="use_forpost"><?php _e( 'Use for posts/blog', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="use_forpost" value="0">
				<input type="checkbox" name="use_forpost" id="use_forpost" value="1"<?php checked( '1', $g_lbp_base_options['use_forpost'] ); ?> title="<?php _e( 'If checked will use for blog/posts page and all single posts but not for pages unless the above is checked. DEFAULT: Unchecked', "lightboxplus" ); ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="load_location"><?php _e( 'Load in Header/Footer', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<select name="load_location" id="load_location" title="<?php _e( 'You can set whether you want to inline scripts to load in the header or footer. Footer loads at the end of page and is highly recommended. DEFAULT: Footer', "lightboxplus" ); ?>">
					<option value="wp_footer"<?php selected( 'wp_footer', $g_lbp_base_options['load_location'] ); ?>>Footer</option>
					<option value="wp_head"<?php selected( 'wp_head', $g_lbp_base_options['load_location'] ); ?>>Header</option>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="load_priority"><?php _e( 'Load Priority', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<select name="load_priority" id="load_priority" title="<?php _e( 'Allows you to set the priority for the load action for the inline scripts, higher will load sooner. DEFAULT: Normal', "lightboxplus" ); ?>">
					<option value="15"<?php selected( '15', $g_lbp_base_options['load_priority'] ); ?>>Low</option>
					<option value="10"<?php selected( '10', $g_lbp_base_options['load_priority'] ); ?>>Normal</option>
					<option value="5"<?php selected( '5', $g_lbp_base_options['load_priority'] ); ?>>High</option>
				</select>
			</td>
		</tr>
	</table>
</div>
<?php flush(); ?>
<!-- Support -->
<div id="blbp-tabs-4">

	<h4><?php _e( 'Support for 23Systems Free WordPress Plugins', 'lightboxplus' ); ?></h4>

	<p><?php _e( '23Systems has created a number of free WordPress plugins and we offer limited support for Lightbox Plus Colorbox via the <a href="http://wordpress.org/support/plugin/lightbox-plus" title="Lightbox Plus Colorbox Direct Support">support forums</a>.  Check the following box to display information about your WordPress installation and enable support and debug options.  Please include the following information when requesting support:', 'lightboxplus' ); ?></p>
	<table class="form-table">
		<tr>
			<th scope="row">
				<label for="enable_dev"><?php _e( 'Enable Support and Development Options', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="enable_dev" value="0">
				<input type="checkbox" name="enable_dev" id="enable_dev" value="1"<?php checked( '1', $g_lbp_base_options['enable_dev'] ); ?> title="<?php _e( 'If checked enables development and debug options for plugin including loading non-minified javascript and css. DEFAULT: Unchecked', "lightboxplus" ); ?>" />
			</td>
		</tr>
	</table>
	<?php
	if ( isset( $g_lbp_base_options['enable_dev'] ) && 1 == $g_lbp_base_options['enable_dev'] ) {
		?>
		<table width="100%" border="0" class="lbp-support-info">
			<tbody>
			<tr>
				<td width="50%" valign="top">
					<h4>WordPress Information</h4>
					<strong>WordPress Version:</strong> <?php echo $wp_version; ?><br />
					<strong>jQuery Version:</strong>
					<script type="text/javascript">document.write(jQuery.fn.jquery);</script>
					<br />
				</td>
				<td width="50%" valign="top">
					<h4>Server Information</h4>
					<strong>Site URL:</strong> <?php echo get_site_url(); ?><br />
					<strong>PHP Version:</strong> <?php echo phpversion(); ?><br />
					<strong>Server Software:</strong> <?php echo $_SERVER['SERVER_SOFTWARE']; ?>
				</td>
			</tr>
			<tr>
				<td width="50%" valign="top">
					<h4>Plugin Information</h4>
					<strong>Lightbox Plus Colorbox Version:</strong> <?php echo LBP_VERSION; ?><br />
					<strong>LBP Shortcode Version:</strong> <?php echo LBP_SHORTCODE_VERSION; ?><br />
					<strong>Colorbox Version:</strong> <?php echo LBP_COLORBOX_VERSION; ?><br />
					<strong>Simple PHP HTML DOM Parser Version:</strong> <?php echo LBP_SHD_VERSION; ?>
				</td>
				<td width="50%" valign="top">
					<h4>Client Information</h4>
					<strong>Browser:</strong> <?php echo $_SERVER['HTTP_USER_AGENT']; ?><br />
					<strong>Viewport:</strong>
					<script type="text/javascript">document.write(jQuery(window).width() + 'x' + jQuery(window).height());</script>
					<br />
					<strong>Platform:</strong>
					<script type="text/javascript">document.write(navigator.platform);</script>
					<br />
					<strong>Javascript:</strong>
					<noscript>No</noscript>
					<script type="text/javascript">document.write('Yes');</script>
				</td>
			</tr>
			</tbody>
		</table>
		<h3>
			<a class="button" id="lbp_setting_detail">Display Raw Settings</a></h3>
		<table width="100%" border="0" class="lbp-support-info" id="lbp_detail">
			<tbody>
			<tr>
				<td>Lightbox Plus Colorbox Basic Settings - Raw</td>
				<td>Lightbox Plus Colorbox Primary Settings - Raw</td>
				<?php
				$secondary_init = get_option( 'lightboxplus_init_secondary' );
				if ( isset( $secondary_init ) && 1 == $secondary_init ) {
					?>
					<td>Lightbox Plus Colorbox Secondary Settings - Raw</td>
				<?php
				}
				$inline_init = get_option( 'lightboxplus_init_inline' );
				if ( isset( $inline_init ) && 1 == $inline_init ) {
					?>
					<td>Lightbox Plus Colorbox Primary Settings - Raw</td>
				<?php
				}
				?>
			</tr>
			<tr>
				<td valign="top">
					<pre><?php echo $this->json_pretty( json_encode( $g_lbp_base_options ) ); ?></pre>
				</td>
				<td valign="top">
					<pre><?php echo $this->json_pretty( json_encode( $g_lbp_primary_options ) ); ?></pre>
				</td>
				<?php
				if ( isset( $secondary_init ) && $secondary_init == 1 ) {
					?>
					<td valign="top">
						<pre><?php echo $this->json_pretty( json_encode( $g_lbp_secondary_options ) ); ?></pre>
					</td>
				<?php
				}
				if ( isset( $inline_init ) && $inline_init == 1 ) {
					?>
					<td valign="top">
						<pre><?php echo $this->json_pretty( json_encode( $g_lbp_inline_options ) ); ?></pre>
					</td>
				<?php
				}
				?>
			</tr>
			</tbody>
		</table>
	<?php
	}
	?>
	<p><?php _e( 'It would also be a good idea to read the <a title="Lightbox Plus Colorbox Frequently Asked Questions" href="http://www.23systems.net/wordpress-plugins/lightbox-plus-for-wordpress/frequently-asked-questions/">Lightbox Plus Colorbox FAQ</a> to see if you question is answered there. For more in-depth support or if you need extra help with one of our plugins you may place a service request using the form on the <a title="Get technical support for 23Systems free WordPress plugins" href="http://www.23systems.net/services/support/plugin-support/">Plugin Support Request</a> page.', 'lightboxplus' ); ?></p>

	<p><?php _e( '23Systems does not offer phone support for any of our plugs unless you are an existing client.  If you are an <b>existing client</b> and would like phone support please fill out the form on the <a title="Get technical support for 23Systems free WordPress plugins" href="http://www.23systems.net/services/support/plugin-support/">Plugin Support</a> page and request phone support.  Once we receive the support request we can contact you with rates and information.', 'lightboxplus' ); ?></p>

	<p><?php _e( 'If you would like to show your support for our free WordPress plugins please consider a <a title="Help support Free and Open Source software by donating to our free plugin development" href="http://www.23systems.net/wordpress-plugins/donate/">donation</a>.', 'lightboxplus' ); ?></p>
</div>
</div>
<p class="submit">
	<input type="submit" name="Submit" class="button-primary save-all-settings" id="save-settings" title="<?php _e( 'Save Basic Lightbox Plus Colorbox settings', 'lightboxplus' ) ?>" value="<?php _e( 'Save Basic settings', 'lightboxplus' ) ?> &raquo;" />
</p>
</div>

</div>
</div>
</form>
<?php flush(); ?>
<form name="lightboxplus-settings-primary" id="lightboxplus-settings-primary" method="post" action="<?php echo LBP_ADMIN_PAGE; ?>">
<input type="hidden" name="action" value="primary" />
<input type="hidden" name="sub" id="primary-sub" value="primary" />

<!-- Primary Lightbox Settings -->
<div id="poststuff-primary" class="lbp poststuff">
<div class="postbox">
<h3 class="handle"><?php _e( 'Lightbox Plus Colorbox - Primary Lightbox Settings', 'lightboxplus' ); ?></h3>

<div class="inside toggle">
<div id="plbp-tabs">
<ul>
	<li><a href="#plbp-tabs-1"><?php _e( 'General', 'lightboxplus' ); ?></a></li>
	<li><a href="#plbp-tabs-2"><?php _e( 'Size', 'lightboxplus' ); ?></a></li>
	<li><a href="#plbp-tabs-3"><?php _e( 'Postition', 'lightboxplus' ); ?></a></li>
	<li><a href="#plbp-tabs-4"><?php _e( 'Interface', 'lightboxplus' ); ?></a></li>
	<li><a href="#plbp-tabs-5"><?php _e( 'Slideshow', 'lightboxplus' ); ?></a></li>
	<li><a href="#plbp-tabs-6"><?php _e( 'Advanced', 'lightboxplus' ); ?></a></li>
	<li><a href="#plbp-tabs-7"><?php _e( 'Usage', 'lightboxplus' ); ?></a></li>
	<li><a href="#plbp-tabs-8"><?php _e( 'Demo/Test', 'lightboxplus' ); ?></a></li>
</ul>
<!-- General -->
<div id="plbp-tabs-1">
	<table class="form-table">
		<tr>
			<th scope="row">
				<label for="transition"><?php _e( 'Transition Type', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<select name="transition" id="transition" title="<?php _e( 'Specifies the transition type. Can be set to "elastic", "fade", or "none". DEFAULT: Elastic', "lightboxplus" ) ?>">
					<option value="elastic"<?php selected( 'elastic', $g_lbp_primary_options['transition'] ); ?>>Elastic</option>
					<option value="fade"<?php selected( 'fade', $g_lbp_primary_options['transition'] ); ?>>Fade</option>
					<option value="none"<?php selected( 'none', $g_lbp_primary_options['transition'] ); ?>>None</option>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="speed"><?php _e( 'Resize Speed', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<select name="speed" id="speed" title="<?php _e( 'Controls the speed of the fade and elastic transitions, in milliseconds. DEFAULT: 300', "lightboxplus" ) ?>">
					<?php
					for ( $i = 0; $i <= 5001; ) {
						?>
						<option value="<?php echo $i; ?>"<?php selected( $i, $g_lbp_primary_options['speed'] ); ?>><?php echo $i; ?></option>
						<?php
						if ( 2000 <= $i ) {
							$i += 500;
						} elseif ( 1250 <= $i ) {
							$i += 250;
						} else {
							$i += 50;
						}
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="opacity"><?php _e( 'Overlay Opacity', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<select name="opacity" id="opacity" title="<?php _e( 'Controls transparency of shadow overlay. Lower numbers are more transparent. DEFAULT: 80%', "lightboxplus" ) ?>">
					<?php
					for ( $i = 0; $i <= 1.01; $i = $i + .05 ) {
						?>
						<option value="<?php echo $i; ?>"<?php selected( $i, $g_lbp_primary_options['opacity'] ); ?>><?php echo( $i * 100 ); ?>%</option>
					<?php
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="preloading"><?php _e( 'Pre-load images', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="preloading" value="0">
				<input type="checkbox" name="preloading" id="preloading" value="1"<?php checked( '1', $g_lbp_primary_options['preloading'] ); ?> title="<?php _e( 'Allows for preloading of "Next" and "Previous" content in a shared relation group (same values for the "rel" attribute), after the current content has finished loading. Uncheck to disable. DEFAULT: Checked', "lightboxplus" ) ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="gallery_lightboxplus"><?php _e( 'Use For WordPress Galleries', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="gallery_lightboxplus" value="0">
				<input type="checkbox" name="gallery_lightboxplus" id="gallery_lightboxplus" value="1"<?php checked( '1', $g_lbp_primary_options['gallery_lightboxplus'] ); ?> title="<?php _e( "If checked, Lightbox Plus Colorbox will add the Lightboxing feature to the WordPress built in gallery feature.  In order for this to work correctly you must set Link thumbnails to: Image File or use [gallery link='file'... for the gallery options. DEFAULT: Unchecked", "lightboxplus" ) ?>" />
			</td>
		</tr>
		<tr>
		<tr>
			<th scope="row">
				<label for="multiple_galleries"><?php _e( 'Separate Galleries in Post?', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="multiple_galleries" value="0">
				<input type="checkbox" name="multiple_galleries" id="multiple_galleries" value="1"<?php checked( '1', $g_lbp_primary_options['multiple_galleries'] ); ?> title="<?php _e( 'If the option to separate multiple galleries in a single post is check Lightbox Plus Colorbox will create separate sets of lightbox display for each gallery in the post. DEFAULT: Unchecked', "lightboxplus" ) ?>" />
			</td>
		</tr>
	</table>
</div>
<!-- Size -->
<div id="plbp-tabs-2">
	<table class="form-table">
		<tr>
			<th scope="row">
				<label for="width"><?php _e( 'Width', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" title="<?php _e( "Set a fixed total width. This includes borders and buttons. Example: '100%', '500px', or 500, or false for no defined width.  DEFAULT: false", "lightboxplus" ) ?>" size="15" name="width" id="width" value="<?php if ( ! empty( $g_lbp_primary_options['width'] ) ) {
					echo $g_lbp_primary_options['width'];
				} else {
					echo '';
				} ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="height"><?php _e( 'Height', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" title="<?php _e( "Set a fixed total height. This includes borders and buttons. Example: '100%', '500px', or 500, or false for no defined height. DEFAULT: false", "lightboxplus" ) ?>" size="15" name="height" id="height" value="<?php if ( ! empty( $g_lbp_primary_options['height'] ) ) {
					echo $g_lbp_primary_options['height'];
				} else {
					echo '';
				} ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="inner_width"><?php _e( 'Inner Width', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" title="<?php _e( "This is an alternative to 'width' used to set a fixed inner width. This excludes borders and buttons. Example: 50%, 500px, or 500, or false for no inner width.  DEFAULT: false", "lightboxplus" ) ?>" size="15" name="inner_width" id="inner_width" value="<?php if ( ! empty( $g_lbp_primary_options['inner_width'] ) ) {
					echo $g_lbp_primary_options['inner_width'];
				} else {
					echo '';
				} ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="inner_height"><?php _e( 'Inner Height', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" title="<?php _e( "This is an alternative to 'height' used to set a fixed inner height. This excludes borders and buttons. Example: 50%, 500px, or 500 or false for no inner height. DEFAULT: false", "lightboxplus" ) ?>" size="15" name="inner_height" id="inner_height" value="<?php if ( ! empty( $g_lbp_primary_options['inner_height'] ) ) {
					echo $g_lbp_primary_options['inner_height'];
				} else {
					echo '';
				} ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="initial_width"><?php _e( 'Initial Width', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" title="<?php _e( 'Set the initial width, prior to any content being loaded.  DEFAULT: 300', "lightboxplus" ) ?>" size="15" name="initial_width" id="initial_width" value="<?php if ( ! empty( $g_lbp_primary_options['initial_width'] ) ) {
					echo $g_lbp_primary_options['initial_width'];
				} else {
					echo '';
				} ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="initial_height"><?php _e( 'Initial Height', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" title="<?php _e( 'Set the initial height, prior to any content being loaded. DEFAULT: 100', "lightboxplus" ) ?>" size="15" name="initial_height" id="initial_height" value="<?php if ( ! empty( $g_lbp_primary_options['initial_height'] ) ) {
					echo $g_lbp_primary_options['initial_height'];
				} else {
					echo '';
				} ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="max_width"><?php _e( 'Maximum Width', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" title="<?php _e( 'Set a maximum width for loaded content.  Example: "75%", "500px", 500, or false for no maximum width.  DEFAULT: false', "lightboxplus" ) ?>" size="15" name="max_width" id="max_width" value="<?php if ( ! empty( $g_lbp_primary_options['max_width'] ) ) {
					echo $g_lbp_primary_options['max_width'];
				} else {
					echo '';
				} ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="max_height"><?php _e( 'Maximum Height', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" title="<?php _e( 'Set a maximum height for loaded content.  Example: 75%, 500px, 500, or false for no maximum height. DEFAULT: false', "lightboxplus" ) ?>" size="15" name="max_height" id="max_height" value="<?php if ( ! empty( $g_lbp_primary_options['max_height'] ) ) {
					echo $g_lbp_primary_options['max_height'];
				} else {
					echo '';
				} ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="resize"><?php _e( 'Resize', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="resize" value="0">
				<input type="checkbox" name="resize" id="resize" value="1"<?php checked( '1', $g_lbp_primary_options['resize'] ); ?> title="<?php _e( 'If checked and if Maximum Width or Maximum Height have been defined, Lightbox Plus will resize photos to fit within the those values. DEFAULT: Checked', "lightboxplus" ) ?>" />
			</td>
		</tr>
	</table>
</div>
<!-- Position -->
<div id="plbp-tabs-3">
	<table class="form-table">
		<tr>
			<th scope="row"><?php _e( 'Top', 'lightboxplus' ) ?>:</th>
			<td>
				<input name="top" title="<?php _e( 'Accepts a pixel or percent value (50, 50px, 10%). Controls vertical positioning instead of using the default position of being centered in the viewport. DEFAULT: null', "lightboxplus" ) ?>" type="text" id="top" size="8" maxlength="8" value="<?php if ( ! empty( $g_lbp_primary_options['top'] ) ) {
					echo $g_lbp_primary_options['top'];
				} else {
					echo '';
				} ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e( 'Right', 'lightboxplus' ) ?>:</th>
			<td>
				<input name="right" title="<?php _e( 'Accepts a pixel or percent value (50, 50px, 10%). Controls horizontal positioning instead of using the default position of being centered in the viewport. DEFAULT: null', "lightboxplus" ) ?>" type="text" id="right" size="8" maxlength="8" value="<?php if ( ! empty( $g_lbp_primary_options['right'] ) ) {
					echo $g_lbp_primary_options['right'];
				} else {
					echo '';
				} ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e( 'Bottom', 'lightboxplus' ) ?>:</th>
			<td>
				<input name="bottom" title="<?php _e( 'SetAccepts a pixel or percent value (50, 50px, 10%). Controls vertical positioning instead of using the default position of being centered in the viewport. DEFAULT: false', "lightboxplus" ) ?>" type="text" id="bottom" size="8" maxlength="8" value="<?php if ( ! empty( $g_lbp_primary_options['bottom'] ) ) {
					echo $g_lbp_primary_options['bottom'];
				} else {
					echo '';
				} ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e( 'Left', 'lightboxplus' ) ?>:</th>
			<td>
				<input name="left" title="<?php _e( 'SetAccepts a pixel or percent value (50, 50px, 10%). Controls horizontal positioning instead of using the default position of being centered in the viewport. DEFAULT: false', "lightboxplus" ) ?>" type="text" id="left" size="8" maxlength="8" value="<?php if ( ! empty( $g_lbp_primary_options['left'] ) ) {
					echo $g_lbp_primary_options['left'];
				} else {
					echo '';
				} ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="fixed"><?php _e( 'Fixed', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="fixed" value="0">
				<input type="checkbox" name="fixed" id="fixed" value="1"<?php checked( '1', $g_lbp_primary_options['fixed'] ); ?> title="<?php _e( 'If checked, the lightbox will always be displayed in a fixed position within the viewport. In other words it will stay within the viewport while scrolling on the page.  This is unlike the default absolute positioning relative to the document. DEFAULT: Unchecked', "lightboxplus" ) ?>" />
			</td>
		</tr>
	</table>
</div>
<!-- Interface -->
<div id="plbp-tabs-4">
	<table class="form-table">
		<tr>
			<th scope="row"></th>
			<td><strong><?php _e( 'General Interface Options', 'lightboxplus' ) ?></strong></td>
		</tr>
		<tr>
			<th scope="row">
				<label for="close"><?php _e( 'Close image text', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" title="<?php _e( 'Text for the close button.  If Overlay Close or ESC Key Close are check those options will also close the lightbox. DEFAULT: close', "lightboxplus" ) ?>" size="15" name="close" id="close" value="<?php if ( empty( $g_lbp_primary_options['close'] ) ) {
					echo '';
				} else {
					echo $g_lbp_primary_options['close'];
				} ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="overlay_close"><?php _e( 'Overlay Close', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="overlay_close" value="0">
				<input type="checkbox" name="overlay_close" id="overlay_close" value="1"<?php checked( '1', $g_lbp_primary_options['overlay_close'] ); ?> title="<?php _e( 'If checked, enables closing Lightbox Plus Colorbox by clicking on the background overlay. DEFAULT: Checked', "lightboxplus" ) ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="esc_key"><?php _e( 'ESC Key Close', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="esc_key" value="0">
				<input type="checkbox" name="esc_key" id="esc_key" value="1"<?php checked( '1', $g_lbp_primary_options['esc_key'] ); ?> title="<?php _e( 'If checked, enables closing Lightbox Plus Colorbox using the ESC key. DEFAULT: Checked', "lightboxplus" ) ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="scrolling"><?php _e( 'Scroll Bars', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="scrolling" value="0">
				<input type="checkbox" name="scrolling" id="scrolling" value="1"<?php checked( '1', $g_lbp_primary_options['scrolling'] ); ?> title="<?php _e( 'If unchecked, Lightbox Plus Colorbox will hide scrollbars for overflowing content. DEFAULT: Checked', "lightboxplus" ) ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row"></th>
			<td><strong><?php _e( 'Image Grouping', 'lightboxplus' ) ?></strong></td>
		</tr>
		<tr>
			<th scope="row">
				<label for="rel"><?php _e( 'Disable grouping', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="rel" value="0">
				<input type="checkbox" name="rel" id="rel" value="nofollow"<?php if ( $g_lbp_primary_options['rel'] == 'nofollow' ) {
					echo ' checked="checked"';
				} ?> title="<?php _e( 'If checked will disable grouping of images and previous/next label. DEFAULT: Unchecked', "lightboxplus" ) ?>" />
			</td>
		</tr>
		<tr class="grouping_prim">
			<th scope="row">
				<label for="label_image"><?php _e( 'Grouping Labels', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" size="15" name="label_image" id="label_image" value="<?php if ( empty( $g_lbp_primary_options['label_image'] ) ) {
					echo '';
				} else {
					echo $g_lbp_primary_options['label_image'];
				} ?>" title="<?php _e( 'Text format for the content group / gallery count. {current} and {total} are detected and replaced with actual numbers while Colorbox runs. DEFAULT: Image {current} of {total}', "lightboxplus" ) ?>" />
				#
				<input type="text" size="15" name="label_of" id="label_of" value="<?php if ( empty( $g_lbp_primary_options['label_of'] ) ) {
					echo '';
				} else {
					echo $g_lbp_primary_options['label_of'];
				} ?>" title="<?php _e( 'Text format for the content group / gallery count. {current} and {total} are detected and replaced with actual numbers while Colorbox runs. DEFAULT: Image {current} of {total}', "lightboxplus" ) ?>" />
				#
			</td>
		</tr>
		<tr class="grouping_prim">
			<th scope="row">
				<label for="previous"><?php _e( 'Previous image text', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" size="15" name="previous" id="previous" value="<?php if ( empty( $g_lbp_primary_options['previous'] ) ) {
					echo '';
				} else {
					echo $g_lbp_primary_options['previous'];
				} ?>" title="<?php _e( 'Text for the previous button in a shared relation group (same values for "rel" attribute). DEFAULT: previous', "lightboxplus" ) ?>" />
			</td>
		</tr>
		<tr class="grouping_prim">
			<th scope="row">
				<label for="next"><?php _e( 'Next image text', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" size="15" name="next" id="next" value="<?php if ( empty( $g_lbp_primary_options['next'] ) ) {
					echo '';
				} else {
					echo $g_lbp_primary_options['next'];
				} ?>" title="<?php _e( 'Text for the next button in a shared relation group (same values for "rel" attribute).  DEFAULT: next', "lightboxplus" ) ?>" />
			</td>
		</tr>
		<tr class="grouping_prim">
			<th scope="row">
				<label for="arrow_key"><?php _e( 'Arrow key navigation', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="arrow_key" value="0">
				<input type="checkbox" name="arrow_key" id="arrow_key" value="1"<?php checked( '1', $g_lbp_primary_options['arrow_key'] ); ?> title="<?php _e( 'If checked, enables the left and right arrow keys for navigating between the items in a group. DEFAULT: Checked', "lightboxplus" ) ?>" />
			</td>
		</tr>
		<tr class="grouping_prim">
			<th scope="row">
				<label for="loop"><?php _e( 'Loop image group', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="loop" value="0">
				<input type="checkbox" name="loop" id="loop" value="1"<?php checked( '1', $g_lbp_primary_options['loop'] ); ?> title="<?php _e( 'If checked, enables the ability to loop back to the beginning of the group when on the last element. DEFAULT: Checked', "lightboxplus" ) ?>" />
			</td>
		</tr>
	</table>
</div>
<!-- Slideshow -->
<div id="plbp-tabs-5">
	<table class="form-table">
		<tr>
			<th scope="row">
				<label for="slideshow"><?php _e( 'Slideshow', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="slideshow" value="0">
				<input type="checkbox" name="slideshow" id="slideshow" value="1"<?php checked( '1', $g_lbp_primary_options['slideshow'] ); ?> title="<?php _e( 'If checked, adds slideshow capability to a content group / gallery. DEFAULT: Unchecked', "lightboxplus" ) ?>" />
			</td>
		</tr>
		<tr class="slideshow_prim">
			<th scope="row">
				<label for="slideshow_auto"><?php _e( 'Auto-Start Slideshow', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="slideshow_auto" value="0">
				<input type="checkbox" name="slideshow_auto" id="slideshow_auto" value="1"<?php checked( '1', $g_lbp_primary_options['slideshow_auto'] ); ?> title="<?php _e( 'If checked, the slideshows will automatically start to play when content group opened. DEFAULT: Checked', "lightboxplus" ) ?>" />
			</td>
		</tr>
		<tr class="slideshow_prim">
			<th scope="row">
				<label for="slideshow_speed"><?php _e( 'Slideshow Speed', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<select name="slideshow_speed" id="slideshow_speed" title="<?php _e( 'Controls the speed of the slideshow, in milliseconds. DEFAULT: 2500', "lightboxplus" ) ?>">
					<?php
					for ( $i = 500; $i <= 20001; ) {
						?>
						<option value="<?php echo $i; ?>"<?php selected( $i, $g_lbp_primary_options['slideshow_speed'] ); ?>><?php echo $i; ?></option>
						<?php
						if ( 15000 <= $i ) {
							$i += 5000;
						} elseif ( 10000 >= $i ) {
							$i += 1000;
						} else {
							$i += 500;
						}
					}
					?>
				</select>
			</td>
		</tr>
		<tr class="slideshow_prim">
			<th scope="row">
				<label for="slideshow_start"><?php _e( 'Slideshow start text', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" size="15" name="slideshow_start" id="slideshow_start" value="<?php if ( ! empty( $g_lbp_primary_options['slideshow_start'] ) ) {
					echo $g_lbp_primary_options['slideshow_start'];
				} else {
					echo 'start';
				} ?>" title="<?php _e( 'Text for the slideshow start button. DEFAULT: start', "lightboxplus" ) ?>" />
			</td>
		</tr>
		<tr class="slideshow_prim">
			<th scope="row">
				<label for="slideshow_stop"><?php _e( 'Slideshow stop text', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" size="15" name="slideshow_stop" id="slideshow_stop" value="<?php if ( ! empty( $g_lbp_primary_options['slideshow_stop'] ) ) {
					echo $g_lbp_primary_options['slideshow_stop'];
				} else {
					echo 'stop';
				} ?>" title="<?php _e( 'Text for the slideshow stop button.  DEFAULT: stop', "lightboxplus" ) ?>" />
			</td>
		</tr>
	</table>
</div>
<!-- Advanced -->
<div id="plbp-tabs-6">
	<table class="form-table">
		<tr>
			<th scope="row">
				<label for="photo"><?php _e( 'File as photo', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="photo" value="0">
				<input type="checkbox" name="photo" id="photo" value="1"<?php checked( '1', $g_lbp_primary_options['photo'] ); ?> title="<?php _e( "If checked, this setting forces Lightbox Plus Colorbox to display a link as a photo. Use this when automatic photo detection fails (such as using a url like 'photo.php' instead of 'photo.jpg'). DEFAULT: Unchecked", "lightboxplus" ) ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="use_caption_title"><?php _e( 'Use WP Caption for LBP Caption', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="use_caption_title" value="0">
				<input type="checkbox" name="use_caption_title" id="use_caption_title" value="1"<?php checked( '1', $g_lbp_primary_options['use_caption_title'] ); ?> title="<?php _e( 'If checked, Lightbox Plus Colorbox will attempt to use the displayed caption for the image on the page as the caption for the image in the Lightbox Plus Colorbox overlay. DEFAULT: Unchecked', "lightboxplus" ) ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="use_class_method"><?php _e( 'Use Class Method', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="use_class_method" value="0">
				<input type="checkbox" name="use_class_method" id="use_class_method" value="1"<?php checked( '1', $g_lbp_primary_options['use_class_method'] ); ?> title="<?php _e( "If checked, Lightbox Plus Colorbox will only lightbox images using a class instead of the 'rel=lightbox[]' or 'data-attr' attributes.  Using this method you can manually control which images are affected by Lightbox Plus Colorbox by adding the class to the Advanced Link Settings in the WordPress Edit Image tool or by adding it to the image link URL and checking the Do Not Auto-Lightbox Images option. You can also specify the name of the class instead of using the default. DEFAULT: Unchecked / Default cboxModal", "lightboxplus" ) ?>" />
			</td>
		</tr>
		<tr class="primary_class_name lbp-closed">
			<th scope="row">
				<label for="class_name"><?php _e( 'Class name', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" size="15" name="class_name" id="class_name" value="<?php if ( empty( $g_lbp_primary_options['class_name'] ) ) {
					echo 'lbp_primary';
				} else {
					echo $g_lbp_primary_options['class_name'];
				} ?>" title="<?php _e( "You can also specify the name of the class instead of using the default. DEFAULT: lbp_primary", "lightboxplus" ) ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="text_links"><?php _e( 'Auto-Lightbox Text Links', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="text_links" value="0">
				<input type="checkbox" name="text_links" id="text_links" value="1"<?php checked( '1', $g_lbp_primary_options['text_links'] ); ?> title="<?php _e( 'If checked, Lightbox Plus Colorbox will lightbox images that are linked to images via text as well as those link by images.  Use with care as there is a small possibility that you will get double or triple images in the lightbox display if you have invalidly nested html. DEFAULT: Unchecked', "lightboxplus" ) ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="no_auto_lightbox"><?php _e( '<strong>Do Not</strong> Auto-Lightbox Images', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="no_auto_lightbox" value="0">
				<input type="checkbox" name="no_auto_lightbox" id="no_auto_lightbox" value="1"<?php checked( '1', $g_lbp_primary_options['no_auto_lightbox'] ); ?> title="<?php _e( "If checked, Lightbox Plus Colorbox will not automatically add appropriate attributes (either rel='lightbox[postID]' or 'class: cboxModal') to Image URL.  You will need to manually add the appropriate attribute for Lightbox Plus Colorbox to work. DEFAULT: Unchecked", "lightboxplus" ) ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="no_display_title"><?php _e( '<strong>Do Not</strong> Display Image Title', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="no_display_title" value="0">
				<input type="checkbox" name="no_display_title" id="no_display_title" value="1"<?php checked( '1', $g_lbp_primary_options['no_display_title'] ); ?> title="<?php _e( 'If checked, Lightbox Plus Colorbox will not display image titles automatically.  This has no effect if the Do Not Auto-Lightbox Images option is checked. DEFAULT: Unchecked', "lightboxplus" ) ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="retina_image"><?php _e( 'Retina Image', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="retina_image" value="0">
				<input type="checkbox" name="retina_image" id="retina_image" value="1"<?php checked( '1', $g_lbp_primary_options['retina_image'] ); ?> title="<?php _e( "If checked Lightbox Plus Colorbox will scale down the current photo to match the screen's pixel ratio. DEFAULT: Unchecked", "lightboxplus" ); ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="retina_url"><?php _e( 'Retina URL', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="retina_url" value="0">
				<input type="checkbox" name="retina_url" id="retina_url" value="1"<?php checked( '1', $g_lbp_primary_options['retina_url'] ); ?> title="<?php _e( "If checked and the device has a high resolution display, Colorbox will replace the current photo's file extension with the retinaSuffix+extension. DEFAULT: Unchecked", "lightboxplus" ); ?>" />
			</td>
		</tr>
		<tr class="retina_suffix lbp-closed">
			<th scope="row">
				<label for="retina_suffix"><?php _e( 'Retina Suffix', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" size="15" name="retina_suffix" id="retina_suffix" value="<?php if ( empty( $g_lbp_primary_options['retina_suffix'] ) ) {
					echo '$1';
				} else {
					echo $g_lbp_primary_options['retina_suffix'];
				} ?>" title="<?php _e( "If Retina URL is checked and the device has a high resolution display, the href value will have it's extension extended with this suffix. For example, if you had an image named 'my-photo.jpg' and another retina image called 'my-photo@2x.jpg' you would put @2x.$1 (the $1 represents the file extension, in this case jpg) and the name would changed from 'my-photo.jpg' to 'my-photo@2x.jpg'. DEFAULT: .$1", "lightboxplus" ) ?>" />
			</td>
		</tr>
	</table>
</div>
<!-- Usage -->
<div id="plbp-tabs-7">
	<table class="form-table">
		<tr>
			<td>
				<h4><?php _e( 'Basic Usage of Lightbox Plus Colorbox' ); ?></h4>

				<p><?php _e( 'All of the settings described here also apply to the secondary lightbox.  <span class="lbp-help" title="Hover over each settings item on the form for more information.">Hover</span> over each settings item on the form for more information.', 'lightboxplus' ) ?></p>
				<h5 class="subhelp"><?php _e( 'General Tab', 'lightboxplus' ) ?></h5>

				<p><?php _e( 'Lets you specify basic functions of how Lightbox Plus Colorbox works.', 'lightboxplus' ) ?></p>
				<h5 class="subhelp"><?php _e( 'Size Tab', 'lightboxplus' ) ?></h5>

				<p><?php _e( 'Allows you to set all the different size options and whether to automatically resize images.', 'lightboxplus' ) ?></p>
				<h5 class="subhelp"><?php _e( 'Position Tab', 'lightboxplus' ) ?></h5>

				<p><?php _e( 'Lets you set the specific position of where the lightbox appears in the browser viewport and whether to keep it in the viewport while scrolling', 'lightboxplus' ) ?></p>
				<h5 class="subhelp"><?php _e( 'Interface Tab', 'lightboxplus' ) ?></h5>

				<p><?php _e( 'Set the options for how the user interacts with the lightbox and whether to group images or not.', 'lightboxplus' ) ?></p>
				<h5 class="subhelp"><?php _e( 'Slideshow Tab', 'lightboxplus' ) ?></h5>

				<p><?php _e( 'Lightbox Plus Colorbox supports simple slideshows, here you can the the timings and if it should started automatically.', 'lightboxplus' ) ?></p>
				<h5 class="subhelp"><?php _e( 'Other Tab', 'lightboxplus' ) ?></h5>

				<p><?php _e( 'All additional options for lightboxes such as using for galleries, alternate methods for triggering, etc.', 'lightboxplus' ) ?></p>
				<h5 class="subhelp"><?php _e( 'Usage Tab', 'lightboxplus' ) ?></h5>

				<p><?php _e( 'This tab, general help.', 'lightboxplus' ) ?></p>
				<h5 class="subhelp"><?php _e( 'Demo/Test Tab', 'lightboxplus' ) ?></h5>

				<p><?php _e( 'Tests of your current settings for Lightbox Plus Colorbox.', 'lightboxplus' ) ?></p>
		</tr>
	</table>
</div>
<!-- Demo/Test -->
<div id="plbp-tabs-8">
	<table class="form-table">
		<tr valign="top">
			<td>
				<?php _e( 'Here you can test your settings for Lightbox Plus Colorbox using image and text links.  If they do not work please check your settings and ensure that you have transition type and resize speed set ', "lightboxplus" ); ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php if ( isset( $g_lbp_primary_options['output_htmlv'] ) ) { ?>
					<p class="primary_test_item">
						<a href="<?php echo LBP_URL ?>screenshot-1.jpg" <?php if ( $g_lbp_primary_options['use_class_method'] ) {
							echo 'class="' . $g_lbp_primary_options['class_name'] . '"';
						} else {
							echo 'data-' . $g_lbp_primary_options['data_name'] . '="lightbox[test demo]"';
						} ?> title="Screenshot 1"><img title="Screenshot 1" src="<?php echo LBP_URL ?>screenshot-1.jpg" alt="Screenshot 1" width="120" height="90" /></a><br />
						<a href="<?php echo LBP_URL ?>screenshot-2.jpg" <?php if ( $g_lbp_primary_options['use_class_method'] ) {
							echo 'class="' . $g_lbp_primary_options['class_name'] . '"';
						} else {
							echo 'data-' . $g_lbp_primary_options['data_name'] . '="lightbox[test demo]"';
						} ?> title="Screenshot 2">Screenshot 2 Text Link</a></p>
				<?php } else { ?>
					<p class="primary_test_item">
						<a href="<?php echo LBP_URL ?>screenshot-1.jpg" <?php if ( $g_lbp_primary_options['use_class_method'] ) {
							echo 'class="' . $g_lbp_primary_options['class_name'] . '"';
						} else {
							echo 'rel="lightbox[test demo]"';
						} ?> title="Screenshot 1"><img title="Screenshot 1" src="<?php echo LBP_URL ?>screenshot-1.jpg" alt="Screenshot 1" width="120" height="90" /></a><br />
						<a href="<?php echo LBP_URL ?>screenshot-2.jpg" <?php if ( $g_lbp_primary_options['use_class_method'] ) {
							echo 'class="' . $g_lbp_primary_options['class_name'] . '"';
						} else {
							echo 'rel="lightbox[test demo]"';
						} ?> title="Screenshot 2">Screenshot 2 Text Link</a></p>
				<?php } ?>
			</td>
		</tr>
	</table>
</div>
</div>
<script type="text/javascript">
	<!--
	jQuery("textarea.primary_test").change(function () {
		var test_str = jQuery("textarea.primary_test").val();
		jQuery("p.primary_test_item").html(test_str);
	});
	//-->
</script>
<p class="submit">
	<input type="submit" name="Submit" class="button-primary save-all-settings" id="save-primary" title="<?php _e( 'Save Primary Lightbox Plus Colorbox Settings', 'lightboxplus' ) ?>" value="<?php _e( 'Save Primary Lightbox Settings', 'lightboxplus' ) ?> &raquo;" />
</p>
</div>
</div>
</form>

<?php
if ( $g_lbp_base_options['lightboxplus_multi'] ) {
	require( LBP_CLASS_PATH . '/admin-lightbox-secondary.php' );
	flush();
}
if ( $g_lbp_base_options['use_inline'] ) {
	require( LBP_CLASS_PATH . '/admin-lightbox-inline.php' );
	flush();
}
?>

<!-- Reset/Re-initialize -->
<div id="poststuff-reset" class="lbp poststuff">
	<div class="postbox close-me">
		<h3 class="handle"><?php _e( 'Lightbox Plus Colorbox - Reset/Re-initialize', 'lightboxplus' ); ?></h3>

		<div class="inside toggle">
			<!-- Secondary Settings -->
			<div class="ui-widget">
				<div class="ui-state-error ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
					<p>
						<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
						<?php _e( 'This will immediately remove all existing settings and any files for versions of Lightbox Plus Colorbox prior to version 1.5 (if needed) and will also re-initialize the plugin with the new default options. Be absolutely certain you want to do this. <br /><br /><strong><em>If you are upgrading from a version prior to 2.0 it is <strong><em>highly</em></strong> recommended that you reinitialize Lightbox Plus Colorbox', "lightboxplus" ); ?>
					</p>

					<form name="lightboxplus-settings-reset" id="lightboxplus-settings-reset" method="post" action="<?php echo LBP_ADMIN_PAGE; ?>">
						<input type="hidden" name="action" value="reset" />
						<input type="hidden" name="sub" value="reset" />

						<p class="submit">
							<input type="hidden" name="reinit_lightboxplus" value="1" />
							<input type="submit" class="button-primary" name="save" title="<?php _e( 'Resets and re-initializes all Lightbox Plus Colorbox settings', 'lightboxplus' ) ?>" value="<?php _e( 'Reset/Re-initialize Lightbox Plus Colorbox', 'lightboxplus' ); ?>" />
						</p>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Inline Demo Form -->
<div style="display:none;">
	<div class="<?php if ( isset( $inline_hrefs[1] ) ) {
		echo $inline_hrefs[1];
	} ?>" id="<?php if ( isset( $inline_hrefs[1] ) ) {
		echo $inline_hrefs[1];
	} ?>" style="padding: 10px;background: #fff;">
		<h3><?php _e( 'About Lightbox Plus Colorbox for WordPress', 'lightboxplus' ); ?>: </h3>

		<div class="donate">
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="BKVLWU2KWRNAG">
				<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" name="submit" alt="PayPal - The safer, easier way to pay online!">
				<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>

			<hr class="lbp_hr" />
			<h3>
				<a href="http://premium.wpmudev.org/blog/donate-1-to-every-free-wordpress-plugin-you-use/" title="Why Donate?">Why Should I Donate?</a>
			</h3>
		</div>
		<h4><?php _e( 'Thank you for downloading and installing Lightbox Plus Colorbox for WordPress', 'lightboxplus' ); ?></h4>

		<p style="text-align: justify;">
			<?php _e( 'Lightbox Plus Colorbox implements Colorbox as a lightbox image overlay tool for WordPress.  Colorbox was created by Jack Moore of <a href="http://www.jacklmoore.com/colorbox">Color Powered</a> and is licensed under the MIT License. Lightbox Plus Colorbox allows you to easily integrate and customize a powerful and light-weight lightbox plugin for jQuery into your WordPress site.  You can easily create additional styles by adding a new folder to the css directory under <code>wp-content/plugins/lightbox-plus/assets/lbp-css/</code> by duplicating and modifying any of the existing themes or using them as examples to create your own.  See the <a href="http://www.23systems.net/plugins/lightbox-plus/">changelog</a> for important details on this upgrade.', 'lightboxplus' ); ?>
		</p>

		<p style="text-align: justify;">
			<?php _e( 'I spend as much of my spare time as possible working on <strong>Lightbox Plus Colorbox</strong> and any donation is appreciated. Donations play a crucial role in supporting Free and Open Source Software projects. So why are donations important? As a developer the more donations I receive the more time I can invest in working on <strong>Lightbox Plus Colorbox</strong>. Donations help cover the cost of hardware for development and to pay hosting bills. This is critical to the development of free software. I know a lot of other developers do the same and I try to donate to them whenever I can. As a developer I greatly appreciate any donation you can make to help support further development of quality plugins and themes for WordPress.', 'lightboxplus' ); ?>
		</p>
		<h4><?php _e( 'Once again, you have my sincere thanks and appreciation for using <em>Lightbox Plus Colorbox</em>.', 'lightboxplus' ); ?></h4>

		<div class="clear"></div>
	</div>
</div>

<!-- Fix for end of page content -->
<div class="clear">&nbsp;</div>