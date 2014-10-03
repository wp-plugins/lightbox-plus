<?php
/**
 * @package    Lightbox Plus Colorbox
 * @subpackage admin-lightbox-inline.php
 * @internal   2013.01.16
 * @author     Dan Zappone / 23Systems
 * @version    2.7
 * @$Id: admin-lightbox-inline.php 937943 2014-06-24 17:06:54Z dzappone $
 * @$URL: http://plugins.svn.wordpress.org/lightbox-plus/trunk/admin/admin-lightbox-inline.php $
 */

global $g_lbp_base_options;
global $g_lbp_inline_options;

?>
<!-- Inline Lightbox Settings -->
<form name="lightboxplus-settings-inline" id="lightboxplus-settings-inline" method="post" action="<?php echo LBP_ADMIN_PAGE; ?>">
<input type="hidden" name="action" value="inline" />
<input type="hidden" name="sub" id="sub" value="inline" />

<div id="poststuff-inline" class="lbp poststuff">
<div class="postbox">
<h3 class="handle"><?php _e( 'Lightbox Plus Colorbox - Inline Lightbox Settings', 'lightboxplus' ); ?></h3>

<div class="inside toggle">
<div id="ilbp-tabs">
<ul>
	<li><a href="#ilbp-tabs-1"><?php _e( 'General', 'lightboxplus' ); ?></a></li>
	<li><a href="#ilbp-tabs-2"><?php _e( 'Usage', 'lightboxplus' ); ?></a></li>
	<li><a href="#ilbp-tabs-3"><?php _e( 'Demo/Test', 'lightboxplus' ); ?></a></li>
</ul>
<!-- General -->
<div id="ilbp-tabs-1">
	<input type="hidden" name="ready_inline" value="1" />
	<table class="wp-list-table widefat">
		<thead>
		<tr>
			<th>&nbsp;</th>
			<th style="text-align:center;">
				<b><label for="inline_link_"><?php _e( 'Link Class', 'lightboxplus' ); ?></label></b><br /><b><label for="inline_href_"><?php _e( 'Content ID', 'lightboxplus' ); ?></label></b>
			</th>
			<th style="text-align:center;">
				<b><?php _e( 'Transition', 'lightboxplus' ); ?></b><br /><b><?php _e( 'Speed', 'lightboxplus' ); ?></b>
			</th>
			<th style="text-align:center;"><b><?php _e( 'Width', 'lightboxplus' ); ?>
					<br /><?php _e( 'Height', 'lightboxplus' ); ?></b></th>
			<th style="text-align:center;"><b><?php _e( 'Inner Width', 'lightboxplus' ); ?>
					<br /><?php _e( 'Inner Height', 'lightboxplus' ); ?></b></th>
			<th style="text-align:center;"><b><?php _e( 'Max Width', 'lightboxplus' ); ?>
					<br /><?php _e( 'Max Height', 'lightboxplus' ); ?></b></th>
			<th style="text-align:center;"><b><?php _e( 'Position', 'lightboxplus' ); ?></b><br />

				<div style="font-size:8px;line-height:9px;"><?php _e( 'Top', 'lightboxplus' ); ?>
					<br /><?php _e( 'Right, Left', 'lightboxplus' ); ?>
					<br /><?php _e( 'Bottom', 'lightboxplus' ); ?></div>
			</th>
			<th style="text-align:center;"><b><?php _e( 'Fixed', 'lightboxplus' ); ?></b></th>
			<th style="text-align:center;"><b><?php _e( 'Auto Open', 'lightboxplus' ); ?></b></th>
			<th style="text-align:center;"><b><?php _e( 'Reuse', 'lightboxplus' ); ?></b></th>
			<th style="text-align:center;"><b><?php _e( 'Overlay Opacity', 'lightboxplus' ); ?></b></th>
		</tr>
		</thead>
		<tbody>
		<?php
		$inline_links            = array();
		$inline_hrefs            = array();
		$inline_transitions      = array();
		$inline_speeds           = array();
		$inline_widths           = array();
		$inline_heights          = array();
		$inline_inner_widths     = array();
		$inline_inner_heights    = array();
		$inline_max_widths       = array();
		$inline_max_heights      = array();
		$inline_position_tops    = array();
		$inline_position_rights  = array();
		$inline_position_bottoms = array();
		$inline_position_lefts   = array();
		$inline_fixeds           = array();
		$inline_opens            = array();
		$inline_reuses           = array();
		$inline_opacitys         = array();
		for ( $i = 1; $i <= $g_lbp_base_options['inline_num']; $i ++ ) {
			$inline_links            = $g_lbp_inline_options['inline_links'];
			$inline_hrefs            = $g_lbp_inline_options['inline_hrefs'];
			$inline_transitions      = $g_lbp_inline_options['inline_transitions'];
			$inline_speeds           = $g_lbp_inline_options['inline_speeds'];
			$inline_widths           = $g_lbp_inline_options['inline_widths'];
			$inline_heights          = $g_lbp_inline_options['inline_heights'];
			$inline_inner_widths     = $g_lbp_inline_options['inline_inner_widths'];
			$inline_inner_heights    = $g_lbp_inline_options['inline_inner_heights'];
			$inline_max_widths       = $g_lbp_inline_options['inline_max_widths'];
			$inline_max_heights      = $g_lbp_inline_options['inline_max_heights'];
			$inline_position_tops    = $g_lbp_inline_options['inline_position_tops'];
			$inline_position_rights  = $g_lbp_inline_options['inline_position_rights'];
			$inline_position_bottoms = $g_lbp_inline_options['inline_position_bottoms'];
			$inline_position_lefts   = $g_lbp_inline_options['inline_position_lefts'];
			$inline_fixeds           = $g_lbp_inline_options['inline_fixeds'];
			$inline_opens            = $g_lbp_inline_options['inline_opens'];
			$inline_reuses           = $g_lbp_inline_options['inline_reuses'];
			$inline_opacitys         = $g_lbp_inline_options['inline_opacitys'];
			?>
			<tr<?php if ( $i % 2 == 0 ) {
				echo ' class="lbp_alt"';
			} ?>>
				<td><?php _e( 'Inline Lightbox #' . $i, 'lightboxplus' ) ?>:</td>
				<td align="center">
					<input type="text" size="15" name="inline_link[<?php echo $i; ?>]" id="inline_link_<?php echo $i; ?>" value="<?php if ( empty( $inline_links[ $i ] ) ) {
						echo 'lbp-inline-link-' . $i;
					} else {
						echo $inline_links[ $i ];
					} ?>" title="<?php _e( "Class name for inline link number $i to click on. DEFAULT: lbp-inline-link-$i", "lightboxplus" ) ?>" /><br />
					<input type="text" size="15" name="inline_href[<?php echo $i; ?>]" id="inline_href_<?php echo $i; ?>" value="<?php if ( empty( $inline_hrefs[ $i ] ) ) {
						echo 'lbp-inline-href-' . $i;
					} else {
						echo $inline_hrefs[ $i ];
					} ?>" title="<?php _e( "Name for the <div id='' which the inline content number $i. is contained in. DEFAULT: lbp-inline-href-$i", "lightboxplus" ) ?>" />
				</td>
				<td align="center">
					<select name="inline_transition[<?php echo $i; ?>]" id="inline_transition_<?php echo $i; ?>" title="<?php _e( "Specifies the transition type for inline lightbox number $i. Can be set to 'elastic', 'fade', or 'none'. DEFAULT: Elastic", "lightboxplus" ) ?>">
						<option value="elastic"<?php selected( 'elastic', $inline_transitions[ $i ] ); ?>>Elastic</option>
						<option value="fade"<?php selected( 'fade', $inline_transitions[ $i ] ); ?>>Fade</option>
						<option value="none"<?php selected( 'none', $inline_transitions[ $i ] ); ?>>None</option>
					</select><br />
					<select name="inline_speed[<?php echo $i; ?>]" id="inline_speed_<?php echo $i; ?>" title="<?php _e( "Controls the speed of the fade and elastic transitions for inline lightbox number $i, in milliseconds. DEFAULT: 300", "lightboxplus" ) ?>">
						<?php
						for ( $j = 0; $j <= 5001; ) {
							?>
							<option value="<?php echo $j; ?>"<?php selected( $j, $inline_speeds[ $i ] ); ?>><?php echo $j; ?></option>
							<?php
							if ( $j >= 2000 ) {
								$j = $j + 500;
							} elseif ( $j >= 1250 ) {
								$j = $j + 250;
							} else {
								$j = $j + 50;
							}
						}
						?>
					</select>
				</td>
				<td align="center">
					<input type="text" size="5" name="inline_width[<?php echo $i; ?>]" id="inline_width_<?php echo $i; ?>" value="<?php if ( empty( $inline_widths[ $i ] ) ) {
						echo '80%';
					} else {
						echo $inline_widths[ $i ];
					} ?>" title="<?php _e( "Set a fixed total width for inline lightbox $i. This includes borders and buttons. Example: '100%', '500px', or 500, or false for no defined width.  DEFAULT: false", "lightboxplus" ) ?>" /><br />
					<input type="text" size="5" name="inline_height[<?php echo $i; ?>]" id="inline_height_<?php echo $i; ?>" value="<?php if ( empty( $inline_heights[ $i ] ) ) {
						echo '80%';
					} else {
						echo $inline_heights[ $i ];
					} ?>" title="<?php _e( "Set a fixed total height for inline lightbox $i. This includes borders and buttons. Example: '100%', '500px', or 500, or false for no defined height. DEFAULT: false", "lightboxplus" ) ?>" />
				</td>
				<td align="center">
					<input type="text" size="5" name="inline_inner_width[<?php echo $i; ?>]" id="inline_inner_width_<?php echo $i; ?>" value="<?php if ( empty( $inline_inner_widths[ $i ] ) ) {
						echo 'false';
					} else {
						echo $inline_inner_widths[ $i ];
					} ?>" title="<?php _e( "This is an alternative to 'width' used to set a fixed inner width for inline lightbox $i. This excludes borders and buttons. Example: '50%', '500px', or 500, or false for no inner width.  DEFAULT: false", "lightboxplus" ) ?>" /><br />
					<input type="text" size="5" name="inline_inner_height[<?php echo $i; ?>]" id="inline_inner_height_<?php echo $i; ?>" value="<?php if ( empty( $inline_inner_heights[ $i ] ) ) {
						echo 'false';
					} else {
						echo $inline_inner_heights[ $i ];
					} ?>" title="<?php _e( "This is an alternative to 'height' used to set a fixed inner height for inline lightbox $i. This excludes borders and buttons. Example: '50%', '500px', or 500 or false for no inner height. DEFAULT: false", "lightboxplus" ) ?>" />
				</td>
				<td align="center">
					<input type="text" size="5" name="inline_max_width[<?php echo $i; ?>]" id="inline_max_width_<?php echo $i; ?>" value="<?php if ( empty( $inline_max_widths[ $i ] ) ) {
						echo '80%';
					} else {
						echo $inline_max_widths[ $i ];
					} ?>" title="<?php _e( "Set a maximum width for loaded content of inline lightbox $i.  Example: '75%', '500px', 500, or false for no maximum width.  DEFAULT: false", "lightboxplus" ) ?>" /><br />
					<input type="text" size="5" name="inline_max_height[<?php echo $i; ?>]" id="inline_max_height_<?php echo $i; ?>" value="<?php if ( empty( $inline_max_heights[ $i ] ) ) {
						echo '80%';
					} else {
						echo $inline_max_heights[ $i ];
					} ?>" title="<?php _e( "Set a maximum height for loaded content inline lightbox $i.  Example: '75%', '500px', 500, or false for no maximum height. DEFAULT: false", "lightboxplus" ) ?>" />
				</td>
				<td align="center">
					<input type="text" size="5" name="inline_position_top[<?php echo $i; ?>]" id="inline_position_top_<?php echo $i; ?>" value="<?php if ( empty( $inline_position_tops[ $i ] ) ) {
						echo '';
					} else {
						echo $inline_position_tops[ $i ];
					} ?>" title="<?php _e( "Accepts a pixel or percent value (50, 50px, 10%). Controls vertical positioning for inline lightbox $i instead of using the default position of being centered in the viewport. DEFAULT: null", "lightboxplus" ) ?>" />

					<br />
					<input type="text" size="5" name="inline_position_right[<?php echo $i; ?>]" id="inline_position_right_<?php echo $i; ?>" value="<?php if ( empty( $inline_position_rights[ $i ] ) ) {
						echo '';
					} else {
						echo $inline_position_rights[ $i ];
					} ?>" title="<?php _e( "Accepts a pixel or percent value (50, 50px, 10%). Controls horizontal positioning for inline lightbox $i instead of using the default position of being centered in the viewport. DEFAULT: null", "lightboxplus" ) ?>" /><input type="text" size="5" name="inline_position_left[<?php echo $i; ?>]" id="inline_position_left_<?php echo $i; ?>" value="<?php if ( empty( $inline_position_lefts[ $i ] ) ) {
						echo '';
					} else {
						echo $inline_position_lefts[ $i ];
					} ?>" title="<?php _e( "Accepts a pixel or percent value (50, 50px, 10%). Controls horizontal positioning for inline lightbox $i instead of using the default position of being centered in the viewport. DEFAULT: null", "lightboxplus" ) ?>" /><br />
					<input type="text" size="5" name="inline_position_bottom[<?php echo $i; ?>]" id="inline_position_bottom_<?php echo $i; ?>" value="<?php if ( empty( $inline_position_bottoms[ $i ] ) ) {
						echo '';
					} else {
						echo $inline_position_bottoms[ $i ];
					} ?>" title="<?php _e( "Accepts a pixel or percent value (50, 50px, 10%). Controls vertical positioning for inline lightbox $i instead of using the default position of being centered in the viewport. DEFAULT: null", "lightboxplus" ) ?>" />
				</td>
				<td align="center">
					<input type="hidden" name="inline_fixed[<?php echo $i; ?>]" value="0" />
					<input type="checkbox" name="inline_fixed[<?php echo $i; ?>]" id="inline_fixed_<?php echo $i; ?>" value="1"<?php checked(1, $inline_fixeds[ $i ] ); ?> title="<?php _e( "If checked, inline lightbox $i will always be displayed in a fixed position within the viewport. In other words it will stay within the viewport while scrolling on the page. This is unlike the default absolute positioning relative to the document. DEFAULT: Unchecked", "lightboxplus" ) ?>" />
				</td>
				<td align="center">
					<input type="hidden" name="inline_open[<?php echo $i; ?>]" value="0" />
					<input type="checkbox" name="inline_open[<?php echo $i; ?>]" id="inline_open_<?php echo $i; ?>" value="1"<?php checked(1, $inline_opens[ $i ] ); ?> title="<?php _e( "If checked, inline lightbox $i will automatically open when the page is loaded. DEFAULT: Unchecked", "lightboxplus" ) ?>" />
				</td>
				<td align="center">
					<input type="hidden" name="inline_reuse[<?php echo $i; ?>]" value="0" />
					<input type="checkbox" name="inline_reuse[<?php echo $i; ?>]" id="inline_reuse_<?php echo $i; ?>" value="1"<?php checked( 1, $inline_reuses[ $i ] ); ?> title="<?php _e( "If checked, inline lightbox $i will automatically will be reused for multiple lightboxes  Good for a lot of inline content with the same sized lightbox. DEFAULT: Unchecked", "lightboxplus" ) ?>" />
				</td>
				<td align="center">

					<select name="inline_opacity[<?php echo $i; ?>]" id="inline_opacity_<?php echo $i; ?>" title="<?php _e( "Controls transparency of shadow overlay for inline lightbox $i. Lower numbers are more transparent. DEFAULT: 80%", "lightboxplus" ) ?>">
						<?php
						for ( $j = 0; $j <= 1.01; $j = $j + .05 ) {
							?>
							<option value="<?php echo $j; ?>"<?php selected( $j, $inline_opacitys[ $i ] ); ?>><?php echo( $j * 100 ); ?>%</option>
						<?php
						}
						?>
					</select>
				</td>
			</tr>
		<?php
			if (0 == ($i % 10) ) { flush(); }
		}
		?>
		</tbody>
	</table>
</div>
<!-- Usage -->
<div id="ilbp-tabs-2">
	<table class="form-table">
		<tr>
			<td>
				<h4><?php _e( 'Using Inline Lightboxes', 'lightboxplus' ) ?></h4>

				<div id="lbp_for_inline_tip">
					<p><?php _e( 'Inline lightboxes are used to display content that exists on the current page.  It can be used to display a form, video or any other content that is contained on the page.  In order to display inline content using Lightbox Plus Colorbox and Colorbox you must at a minimum has the following items set: Link Class, Content ID, Width, Height, and Opacity.', 'lightboxplus' ) ?></p>

					<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
						<h5>
							<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span><?php _e( 'Reusable Inline Example ', 'lightboxplus' ) ?>
						</h5>

						<p><?php _e( 'This is now the preferred method for setting up inline lightboxes.  The following example shows how to setup content for display in a lightbox.  You will need to create a link to the content that contains a class that has the same value as the Link Class for the inline lightbox you are using.', 'lightboxplus' ) ?></p>

						<p class="codebox">
							<code>&lt;a class="lbp-inline-link-1" data-link="lbp-inline-href-1" href="#"><?php _e( 'Reusable Inline HTML Link Name', 'lightboxplus' ) ?>&lt;/a></code>
						</p>

						<p><?php _e( 'You will also need to set up a div element to contain you content.  The div element that contains the content must contains have and id with a value of the Content ID for the inline light box you are using.  Finally if you want the content to be hidden until the visitor clicks the link, wrap the content div with another div and set the value for style to display:none or assign a class that has display:none for a property', 'lightboxplus' ) ?></p>

						<p class="codebox">
							<code>
								&lt;div style="display:none"><br />
								&nbsp;&nbsp;&nbsp;&nbsp;&lt;div class="lbp-inline-href-1" style="padding: 10px;background: #fff"><br />
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php _e( 'Inline Content Goes Here', 'lightboxplus' ) ?>
								<br />
								&nbsp;&nbsp;&nbsp;&nbsp;&lt;/div><br />
								&lt;/div></code>
						</p>

						<p>&nbsp;</p>
					</div>

					<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
						<h5>
							<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span><?php _e( 'Standard Inline Example', 'lightboxplus' ) ?>
						</h5>

						<p><?php _e( 'This method is deprecated in favor of the new method above. The following example shows how to setup content for display in a lightbox.  You will need to create a link to the content that contains a class that has the same value as the Link Class for the inline lightbox you are using.', 'lightboxplus' ) ?></p>

						<p class="codebox">
							<code>&lt;a class="lbp-inline-link-1" href="#"><?php _e( 'Inline HTML Link Name', 'lightboxplus' ) ?>&lt;/a></code>
						</p>

						<p><?php _e( 'You will also need to set up a div element to contain you content.  The div element that contains the content must contains have and id with a value of the Content ID for the inline light box you are using.  Finally if you want the content to be hidden until the visitor clicks the link, wrap the content div with another div and set the value for style to display:none or assign a class that has display:none for a property', 'lightboxplus' ) ?></p>

						<p class="codebox">
							<code>
								&lt;div style="display:none"><br />
								&nbsp;&nbsp;&nbsp;&nbsp;&lt;div id="lbp-inline-href-1" style="padding: 10px;background: #fff"><br />
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php _e( 'Inline Content Goes Here', 'lightboxplus' ) ?>
								<br />
								&nbsp;&nbsp;&nbsp;&nbsp;&lt;/div><br />
								&lt;/div></code>
						</p>

						<p>&nbsp;</p>
					</div>
			</td>
		</tr>
	</table>
</div>
<!-- Demo/Test -->
<div id="ilbp-tabs-3">
	<table class="form-table">
		<tr valign="top">
			<td>
				<p><?php _e( 'Here you can test you settings with various different implementation of Lightbox Plus Colorbox using inline content.  This demo makes use of the first inline lightbox you have set up.  If they do not work try reloading the page and please check that you have the following items set: Link Class, Content ID, Width, Height, and Opacity.  You will not be able to display this example without the minimum options set.', "lightboxplus" ); ?></p>
			</td>
		</tr>

		<?php if ( isset( $inline_reuses[1] ) && 1 == $inline_reuses[1] ) {
			?>
			<tr valign="top">
				<td>
					<h4>Reusable Inline Lightboxes</h4>

					<p class="inline_link_test_item">
						<a class="<?php echo $inline_links[1]; ?>" data-link="<?php echo $inline_hrefs[1]; ?>" href="#"><?php _e( 'Reusable Inline Content Test including form', "lightboxplus" ); ?></a>
					</p>

					<p class="codebox">
						<strong style="font-size:0.8em;">Skeleton code for reusable inline link</strong><br /><br />
						<code>
							&lt;a class="<?php echo $inline_links[1]; ?>" data-link="<?php echo $inline_hrefs[1]; ?>" href="#"><?php _e( 'Reusable Inline Content Test including form', "lightboxplus" ); ?>&lt;/a>
						</code>
					</p>

					<p class="codebox">
						<strong style="font-size:0.8em;">Skeleton code for reusable inline content</strong><br /><br />
						<code>
							&lt;div style="display:none"><br />
							&nbsp;&nbsp;&nbsp;&nbsp;&lt;div class="<?php echo $inline_hrefs[1]; ?>" style="padding: 10px;background: #fff"><br />
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;h3><?php _e( 'TITLE HERE', 'lightboxplus' ); ?>&lt;/h3><br />
							&nbsp;&nbsp;&nbsp;&nbsp;&lt;div><br />
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php _e( 'FORM HERE', 'lightboxplus' ); ?>
							<br />
							&nbsp;&nbsp;&nbsp;&nbsp;&lt;/div><br />
							&nbsp;&nbsp;&nbsp;&nbsp;&lt;p style="text-align: justify;"><br />
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php _e( 'TEXT HERE', 'lightboxplus' ); ?>
							<br />
							&nbsp;&nbsp;&nbsp;&nbsp;&lt;/p><br />
							&lt;/div><br />
						</code>
					</p>
				</td>
			</tr>
		<?php
		} else {
			?>
			<tr valign="top">
				<td>
					<h4>Standard Inline Lightboxes</h4>

					<p class="inline_link_test_item">
						<a class="<?php echo $inline_links[1]; ?>" href="#"><?php _e( 'Standard Inline Content Test including form', "lightboxplus" ); ?></a>
					</p>

					<p class="codebox">
						<strong style="font-size:0.8em;">Skeleton code for standard inline link</strong><br /><br />
						<code>
							&lt;a class="<?php echo $inline_links[1]; ?>" href="#"><?php _e( 'Standard Inline Content Test including form', "lightboxplus" ); ?>&lt;/a>
						</code>
					</p>

					<p class="codebox">
						<strong style="font-size:0.8em;">Skeleton code standard inline content</strong><br /><br />
						<code>
							&lt;div style="display:none"><br />
							&nbsp;&nbsp;&nbsp;&nbsp;&lt;div id="<?php echo $inline_hrefs[1]; ?>" style="padding: 10px;background: #fff"><br />
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;h3><?php _e( 'TITLE HERE', 'lightboxplus' ); ?>&lt;/h3><br />
							&nbsp;&nbsp;&nbsp;&nbsp;&lt;div><br />
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php _e( 'FORM HERE', 'lightboxplus' ); ?>
							<br />
							&nbsp;&nbsp;&nbsp;&nbsp;&lt;/div><br />
							&nbsp;&nbsp;&nbsp;&nbsp;&lt;p style="text-align: justify;"><br />
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php _e( 'TEXT HERE', 'lightboxplus' ); ?>
							<br />
							&nbsp;&nbsp;&nbsp;&nbsp;&lt;/p><br />
							&lt;/div><br />
						</code>
					</p>
				</td>
			</tr>
		<?php
		}
		?>


	</table>
	<!-- end testing -->
</div>
</div>
<p class="submit">
	<input type="submit" name="Submit" class="button-primary save-all-settings" title="<?php _e( 'Save Inline Lightbox Plus Colorbox Settings', 'lightboxplus' ) ?>" value="<?php _e( 'Save Inline Lightbox Settings', 'lightboxplus' ) ?> &raquo;" />
</p>
</div>
</div>
</div>
</form>
<!-- End Inline Lightbox -->