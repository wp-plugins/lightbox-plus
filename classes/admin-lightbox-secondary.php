<?php
/**
 * @package    Lightbox Plus Colorbox
 * @subpackage admin-lightbox-secondary.php
 * @internal   2013.01.16
 * @author     Dan Zappone / 23Systems
 * @version    2.7
 * @$Id: admin-lightbox-secondary.php 937943 2014-06-24 17:06:54Z dzappone $
 * @$URL: http://plugins.svn.wordpress.org/lightbox-plus/trunk/admin/admin-lightbox-secondary.php $
 */

//$g_lbp_base_options           = get_option( $this->lbp_options_base_name );
$g_lbp_secondary_options = get_option( $this->lbp_options_secondary_name );

?>
<!-- Secondary Lightbox Settings -->
<form name="lightboxplus-settings-secondary" id="lightboxplus-settings-secondary" method="post" action="<?php echo LBP_ADMIN_PAGE; ?>">
<input type="hidden" name="action" value="secondary" />
<input type="hidden" name="sub" id="secondary-sub" value="secondary" />

<div id="poststuff-secondary" class="lbp poststuff">
<div class="postbox"> <!-- add  close-me  to class to set auto closed -->
<h3 class="handle"><?php _e( 'Lightbox Plus Colorbox - Secondary Lightbox Settings', 'lightboxplus' ); ?></h3>

<div class="inside toggle">
<div id="slbp-tabs">
<ul>
	<li><a href="#slbp-tabs-1"><?php _e( 'General', 'lightboxplus' ); ?></a></li>
	<li><a href="#slbp-tabs-2"><?php _e( 'Size', 'lightboxplus' ); ?></a></li>
	<li><a href="#slbp-tabs-3"><?php _e( 'Position', 'lightboxplus' ); ?></a></li>
	<li><a href="#slbp-tabs-4"><?php _e( 'Interface', 'lightboxplus' ); ?></a></li>
	<li><a href="#slbp-tabs-5"><?php _e( 'Slideshow', 'lightboxplus' ); ?></a></li>
	<li><a href="#slbp-tabs-6"><?php _e( 'Other', 'lightboxplus' ); ?></a></li>
	<li><a href="#slbp-tabs-7"><?php _e( 'Usage', 'lightboxplus' ); ?></a></li>
	<li><a href="#slbp-tabs-8"><?php _e( 'Demo/Test', 'lightboxplus' ); ?></a></li>
</ul>
<!-- General -->
<div id="slbp-tabs-1">
	<input type="hidden" name="ready_sec" value="1" />
	<table class="form-table">
		<tr>
			<th scope="row">
				<label for="transition_sec"><?php _e( 'Transition Type', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<select name="transition_sec" id="transition_sec" title="<?php _e( "Specifies the transition type. Can be set to 'elastic', 'fade', or 'none'. DEFAULT:  Elastic", 'lightboxplus' ) ?>">
					<option value="elastic"<?php selected( 'elastic', $g_lbp_secondary_options['transition_sec'] ); ?>>Elastic</option>
					<option value="fade"<?php selected( 'fade', $g_lbp_secondary_options['transition_sec'] ); ?>>Fade</option>
					<option value="none"<?php selected( 'none', $g_lbp_secondary_options['transition_sec'] ); ?>>None</option>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="speed_sec"><?php _e( 'Resize Speed', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<select name="speed_sec" id="speed_sec" title="<?php _e( 'Controls the speed of the fade and elastic transitions, in milliseconds. DEFAULT:  350', 'lightboxplus'  ) ?>">
					<?php
					for ( $i = 0; $i <= 5001; ) {
						?>
						<option value="<?php echo $i; ?>"<?php selected($i, $g_lbp_secondary_options['speed_sec']); ?>><?php echo $i; ?></option>
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
				<label for="opacity_sec"><?php _e( 'Overlay Opacity', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<select name="opacity_sec" id="opacity_sec" title="<?php _e( 'Controls transparency of shadow overlay. Lower numbers are more transparent. DEFAULT:  80%', 'lightboxplus'  ) ?>">
					<?php
					for ( $i = 0; $i <= 1.01; $i = $i + .05 ) {
						?>
						<option value="<?php echo $i; ?>"<?php selected($i, $g_lbp_secondary_options['opacity_sec']); ?>><?php echo( $i * 100 ); ?>%</option>
					<?php
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="preloading_sec"><?php _e( 'Pre-load images', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="checkbox" title="<?php _e( "Allows for preloading of 'Next' and 'Previous' content in a shared relation group (same values for the 'rel' attribute), after the current content has finished loading. Uncheck to disable. DEFAULT:  Checked", 'lightboxplus'  ) ?>" name="preloading_sec" id="preloading_sec" value="1"<?php checked( '1', $g_lbp_secondary_options['preloading_sec'] ); ?> />
			</td>
		</tr>
	</table>
</div>
<!-- Size -->
<div id="slbp-tabs-2">
	<table class="form-table">
		<tr>
			<th scope="row">
				<label for="width_sec"><?php _e( 'Width', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" title="<?php _e( "Set a fixed total width. This includes borders and buttons. Example: '100%', '500px', or 500, or false for no defined width.  DEFAULT: false", 'lightboxplus' ) ?>" size="15" name="width_sec" id="width_sec" value="<?php if ( ! empty( $g_lbp_secondary_options['width_sec'] ) ) {
					echo $g_lbp_secondary_options['width_sec'];
				} else {
					echo '';
				} ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="height_sec"><?php _e( 'Height', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" title="<?php _e( "Set a fixed total height. This includes borders and buttons. Example: '100%', '500px', or 500, or false for no defined height. DEFAULT: false", 'lightboxplus'  ) ?>" size="15" name="height_sec" id="height_sec" value="<?php if ( ! empty( $g_lbp_secondary_options['height_sec'] ) ) {
					echo $g_lbp_secondary_options['height_sec'];
				} else {
					echo '';
				} ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="inner_width_sec"><?php _e( 'Inner Width', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" title="<?php _e( "This is an alternative to 'width' used to set a fixed inner width. This excludes borders and buttons. Example: '50%', '500px', or 500, or false for no inner width.  DEFAULT:  false", 'lightboxplus'  ) ?>" size="15" name="inner_width_sec" id="inner_width_sec" value="<?php if ( ! empty( $g_lbp_secondary_options['inner_width_sec'] ) ) {
					echo $g_lbp_secondary_options['inner_width_sec'];
				} else {
					echo '';
				} ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="inner_height_sec"><?php _e( 'Inner Height', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" title="<?php _e( "This is an alternative to 'height' used to set a fixed inner height. This excludes borders and buttons. Example: '50%', '500px', or 500 or false for no inner height. DEFAULT:  false", 'lightboxplus'  ) ?>" size="15" name="inner_height_sec" id="inner_height_sec" value="<?php if ( ! empty( $g_lbp_secondary_options['inner_height_sec'] ) ) {
					echo $g_lbp_secondary_options['inner_height_sec'];
				} else {
					echo '';
				} ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="initial_width_sec"><?php _e( 'Initial Width', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" title="<?php _e( 'Set the initial width, prior to any content being loaded.  DEFAULT:  300', 'lightboxplus'  ) ?>" size="15" name="initial_width_sec" id="initial_width_sec" value="<?php if ( ! empty( $g_lbp_secondary_options['initial_width_sec'] ) ) {
					echo $g_lbp_secondary_options['initial_width_sec'];
				} else {
					echo '';
				} ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="initial_height_sec"><?php _e( 'Initial Height', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" title="<?php _e( 'Set the initial height, prior to any content being loaded. DEFAULT:  100', 'lightboxplus'  ) ?>" size="15" name="initial_height_sec" id="initial_height_sec" value="<?php if ( ! empty( $g_lbp_secondary_options['initial_height_sec'] ) ) {
					echo $g_lbp_secondary_options['initial_height_sec'];
				} else {
					echo '';
				} ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="max_width_sec"><?php _e( 'Maximum Width', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" title="<?php _e( 'Set a maximum width for loaded content.  Example: "75%", "500px", 500, or false for no maximum width.  DEFAULT:  false', 'lightboxplus'  ) ?>" size="15" name="max_width_sec" id="max_width_sec" value="<?php if ( ! empty( $g_lbp_secondary_options['max_width_sec'] ) ) {
					echo $g_lbp_secondary_options['max_width_sec'];
				} else {
					echo '';
				} ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="max_height_sec"><?php _e( 'Maximum Height', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" title="<?php _e( "Set a maximum height for loaded content.  Example: '75%', '500px', 500, or false for no maximum height. DEFAULT:  false", 'lightboxplus'  ) ?>" size="15" name="max_height_sec" id="max_height_sec" value="<?php if ( ! empty( $g_lbp_secondary_options['max_height_sec'] ) ) {
					echo $g_lbp_secondary_options['max_height_sec'];
				} else {
					echo '';
				} ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="resize_sec"><?php _e( 'Resize', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="resize_sec" value="0" />
				<input type="checkbox" title="<?php _e( 'If checked and if Maximum Width or Maximum Height have been defined, Lightbx Plus will resize photos to fit within the those values. DEFAULT:  Checked', 'lightboxplus'  ) ?>" name="resize_sec" id="resize_sec" value="1"<?php checked( '1', $g_lbp_secondary_options['resize_sec'] ); ?> />
			</td>
		</tr>
	</table>
</div>
<!-- Position -->
<div id="slbp-tabs-3">
	<table class="form-table">
		<tr>
			<th scope="row">
				<label for="top_sec"><?php _e( 'Top', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input name="top_sec" type="text" title="<?php _e( "Accepts a pixel or percent value (50, '50px', '10%'). Controls vertical positioning instead of using the default position of being centered in the viewport. DEFAULT:  null", 'lightboxplus'  ) ?>" id="top_sec" size="8" maxlength="8" value="<?php if ( ! empty( $g_lbp_secondary_options['top'] ) ) {
					echo $g_lbp_secondary_options['top'];
				} else {
					echo '';
				} ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="right_sec"><?php _e( 'Right', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input name="right_sec" type="text" title="<?php _e( "Accepts a pixel or percent value (50, '50px', '10%'). Controls horizontal positioning instead of using the default position of being centered in the viewport. DEFAULT:  null", 'lightboxplus'  ) ?>" id="right_sec" size="8" maxlength="8" value="<?php if ( ! empty( $g_lbp_secondary_options['right'] ) ) {
					echo $g_lbp_secondary_options['right'];
				} else {
					echo '';
				} ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="bottom_sec"><?php _e( 'Bottom', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input name="bottom_sec" type="text" title="<?php _e( "Accepts a pixel or percent value (50, '50px', '10%'). Controls vertical positioning instead of using the default position of being centered in the viewport. DEFAULT:  false", 'lightboxplus'  ) ?>" id="bottom_sec" size="8" maxlength="8" value="<?php if ( ! empty( $g_lbp_secondary_options['bottom'] ) ) {
					echo $g_lbp_secondary_options['bottom'];
				} else {
					echo '';
				} ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="left_sec"><?php _e( 'Left', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input name="left_sec" type="text" title="<?php _e( "SetAccepts a pixel or percent value (50, '50px', '10%'). Controls horizontal positioning instead of using the default position of being centered in the viewport. DEFAULT:  false", 'lightboxplus'  ) ?>" id="left_sec" size="8" maxlength="8" value="<?php if ( ! empty( $g_lbp_secondary_options['left'] ) ) {
					echo $g_lbp_secondary_options['left'];
				} else {
					echo '';
				} ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="fixed_sec"><?php _e( 'Fixed', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="fixed_sec" value="0" />
				<input type="checkbox" title="<?php _e( 'If check, the lightbox will always be displayed in a fixed position within the viewport. In otherwords it will stay within the viewport while scolling on the page.  This is unlike the default absolute positioning relative to the document. DEFAULT:  Unchecked', 'lightboxplus'  ) ?>" name="fixed_sec" id="fixed_sec" value="1"<?php if ( isset( $g_lbp_secondary_options['fixed'] ) ) {
					checked( '1', $g_lbp_secondary_options['fixed'] );
				} ?> />
			</td>
		</tr>
	</table>
</div>
<!-- Interface -->
<div id="slbp-tabs-4">
	<table class="form-table">
		<tr>
			<th scope="row"></th>
			<td><strong><?php _e( 'General Interface Options', 'lightboxplus' ) ?></strong></td>
		</tr>
		<tr class="grouping_sec">
			<th scope="row">
				<label for="close_sec"><?php _e( 'Close image text', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" title="<?php _e( 'Text for the close button. If Overlay Close or ESC Key Close are check those options will also close the lightbox. DEFAULT:  close', 'lightboxplus'  ) ?>" size="15" name="close_sec" id="close_sec" value="<?php if ( empty( $g_lbp_secondary_options['close_sec'] ) ) {
					echo '';
				} else {
					echo $g_lbp_secondary_options['close_sec'];
				} ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="overlay_close_sec"><?php _e( 'Overlay Close', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="overlay_close_sec" value="0" />
				<input type="checkbox" title="<?php _e( 'If checked, enables closing Lightbox Plus Colorbox by clicking on the background overlay. DEFAULT:  Checked', 'lightboxplus'  ) ?>" name="overlay_close_sec" id="overlay_close_sec" value="1"<?php checked( '1', $g_lbp_secondary_options['overlay_close_sec'] ); ?> />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="esc_key_sec"><?php _e( 'ESC Key Close', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="esc_key_sec" value="0" />
				<input type="checkbox" title="<?php _e( 'If checked, enables closing Lightbox Plus Colorbox using the ESC key. DEFAULT:  Checked', 'lightboxplus'  ) ?>" name="esc_key_sec" id="esc_key_sec" value="1"<?php checked( '1', $g_lbp_secondary_options['esc_key_sec'] ); ?> />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="scrolling_sec"><?php _e( 'Scroll Bars', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="scrolling_sec" value="0" />
				<input type="checkbox" title="<?php _e( 'If unchecked, Lightbox Plus Colorbox will hide scrollbars for overflowing content. DEFAULT:  Checked', 'lightboxplus'  ) ?>" name="scrolling_sec" id="scrolling_sec" value="1"<?php checked( '1', $g_lbp_secondary_options['scrolling_sec'] ); ?> />
			</td>
		</tr>
		<tr>
			<th scope="row"></th>
			<td><strong><?php _e( 'Image Grouping', 'lightboxplus' ) ?></strong></td>
		</tr>
		<tr>
			<th scope="row">
				<label for="rel_sec"><?php _e( 'Disable grouping', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="rel_sec" value="0" />
				<input type="checkbox" title="<?php _e( 'If checked will disbale the useage of grouping labels. DEFAULT:  Unchecked', 'lightboxplus'  ) ?>" id="rel_sec" name="rel_sec" value="nofollow"<?php if ( $g_lbp_secondary_options['rel_sec'] == 'nofollow' ) {
					echo ' checked="checked"';
				} ?> />
			</td>
		</tr>
		<tr class="grouping_sec">
			<th scope="row">
				<label for="label_imag_sec"><?php _e( 'Grouping Labels', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" title="<?php _e( 'Text format for the content group / gallery count. {current} and {total} are detected and replaced with actual numbers while Colorbox runs.DEFAULT:  Image {current} of {total}', 'lightboxplus'  ) ?>" size="15" name="label_image_sec" id="label_imag_sec" value="<?php if ( empty( $g_lbp_secondary_options['label_image_sec'] ) ) {
					echo '';
				} else {
					echo $g_lbp_secondary_options['label_image_sec'];
				} ?>" />
				#
				<input type="text" title="<?php _e( 'Text format for the content group / gallery count. {current} and {total} are detected and replaced with actual numbers while Colorbox runs.DEFAULT:  Image {current} of {total}', 'lightboxplus'  ) ?>" size="15" name="label_of_sec" id="label_of_sec" value="<?php if ( empty( $g_lbp_secondary_options['label_of_sec'] ) ) {
					echo '';
				} else {
					echo $g_lbp_secondary_options['label_of_sec'];
				} ?>" />
				#
			</td>
		</tr>
		<tr class="grouping_sec">
			<th scope="row">
				<label for="previous_sec"><?php _e( 'Previous image text', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" title="<?php _e( "Text for the previous button in a shared relation group (same values for 'rel' attribute). DEFAULT:  previous", 'lightboxplus'  ) ?>" size="15" name="previous_sec" id="previous_sec" value="<?php if ( empty( $g_lbp_secondary_options['previous_sec'] ) ) {
					echo '';
				} else {
					echo $g_lbp_secondary_options['previous_sec'];
				} ?>" />
			</td>
		</tr>
		<tr class="grouping_sec">
			<th scope="row">
				<label for="next_sec"><?php _e( 'Next image text', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" title="<?php _e( "Text for the next button in a shared relation group (same values for 'rel' attribute).  DEFAULT:  next", 'lightboxplus'  ) ?>" size="15" name="next_sec" id="next_sec" value="<?php if ( empty( $g_lbp_secondary_options['next_sec'] ) ) {
					echo '';
				} else {
					echo $g_lbp_secondary_options['next_sec'];
				} ?>" />
			</td>
		</tr>
		<tr class="grouping_sec">
			<th scope="row">
				<label for="arrow_key_sec"><?php _e( 'Arrow key navigation', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="arrow_key_sec" value="0" />
				<input type="checkbox" title="<?php _e( 'If checked, enables the left and right arrow keys for navigating between the items in a group. DEFAULT:  Checked', 'lightboxplus'  ) ?>" name="arrow_key_sec" id="arrow_key_sec" value="1"<?php checked( '1', $g_lbp_secondary_options['arrow_key_sec'] ); ?> />
			</td>
		</tr>
		<tr class="grouping_sec">
			<th scope="row">
				<label for="loop_sec"><?php _e( 'Loop image group', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="loop_sec" value="0" />
				<input type="checkbox" title="<?php _e( 'If checked, enables the ability to loop back to the beginning of the group when on the last element. DEFAULT:  Checked', 'lightboxplus'  ) ?>" name="loop_sec" id="loop_sec" value="1"<?php checked( '1', $g_lbp_secondary_options['loop_sec'] ); ?> />
			</td>
		</tr>
	</table>
</div>
<!-- Slideshow -->
<div id="slbp-tabs-5">
	<table class="form-table">
		<tr>
			<th scope="row">
				<label for="slideshow_sec"><?php _e( 'Slideshow', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="slideshow_sec" value="0" />
				<input type="checkbox" title="<?php _e( 'If checked, adds slideshow capablity to a content group / gallery. DEFAULT:  Unchecked', 'lightboxplus'  ) ?>" name="slideshow_sec" id="slideshow_sec" value="1"<?php if ( isset( $g_lbp_secondary_options['slideshow_auto'] ) ) {
					checked( '1', $g_lbp_secondary_options['slideshow_sec'] );
				} ?> />
			</td>
		</tr>
		<tr class="slideshow_sec">
			<th scope="row">
				<label for="slideshow_auto_sec"><?php _e( 'Auto-Start Slideshow', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="slideshow_auto_sec" value="0" />
				<input type="checkbox" title="<?php _e( 'If checked, the slideshows will automatically start to play when content grou opened. DEFAULT:  Checked', 'lightboxplus'  ) ?>" name="slideshow_auto_sec" id="slideshow_auto_sec" value="1"<?php if ( isset( $g_lbp_secondary_options['slideshow_auto'] ) ) {
					checked( '1', $g_lbp_secondary_options['slideshow_auto'] );
				} ?> />
			</td>
		</tr>
		<tr class="slideshow_sec">
			<th scope="row">
				<label for="slideshow_speed_sec"><?php _e( 'Slideshow Speed', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<select name="slideshow_speed_sec" id="slideshow_speed_sec" title="<?php _e( 'Controls the speed of the slideshow, in milliseconds. DEFAULT:  2500', 'lightboxplus'  ) ?>">
					<?php
					for ( $i = 500; $i <= 20001; ) {
						?>
						<option value="<?php echo $i; ?>"<?php selected ($i, $g_lbp_secondary_options['slideshow_speed_sec']); ?>><?php echo $i; ?></option>
						<?php
						if ( 15000 <= $i ) {
							$i += 5000;
						} elseif ( 10000 <= $i ) {
							$i += 1000;
						} else {
							$i += 500;
						}
					}
					?>
				</select>
			</td>
		</tr>
		<tr class="slideshow_sec">
			<th scope="row">
				<label for="slideshow_start_sec"><?php _e( 'Slideshow start text', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" title="<?php _e( 'Text for the slideshow start button. DEFAULT:  start', 'lightboxplus'  ) ?>" size="15" name="slideshow_start_sec" id="slideshow_start_sec" value="<?php if ( ! empty( $g_lbp_secondary_options['slideshow_start_sec'] ) ) {
					echo $g_lbp_secondary_options['slideshow_start_sec'];
				} else {
					echo 'start';
				} ?>" />
			</td>
		</tr>
		<tr class="slideshow_sec">
			<th scope="row">
				<label for="slideshow_stop_sec"><?php _e( 'Slideshow stop text', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="text" title="<?php _e( 'Text for the slideshow stop button.  DEFAULT:  stop', 'lightboxplus'  ) ?>" size="15" name="slideshow_stop_sec" id="slideshow_stop_sec" value="<?php if ( ! empty( $g_lbp_secondary_options['slideshow_stop_sec'] ) ) {
					echo $g_lbp_secondary_options['slideshow_stop_sec'];
				} else {
					echo 'stop';
				} ?>" />
			</td>
		</tr>
	</table>
</div>
<!-- Other -->
<div id="slbp-tabs-6">
	<table class="form-table">
		<tr>
			<th scope="row">
				<label for="photo_sec"><?php _e( 'File as photo', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="photo_sec" value="0">
				<input type="checkbox" title="<?php _e( "If checked, this setting forces Lightbox Plus Colorbox to display a link as a photo. Use this when automatic photo detection fails (such as using a url like 'photo.php' instead of 'photo.jpg'). DEFAULT:  Unchecked", 'lightboxplus'  ) ?>" name="photo_sec" id="photo_sec" value="1"<?php checked( '1', $g_lbp_secondary_options['photo_sec'] ); ?> />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="iframe_sec"><?php _e( 'Use iFrame', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="iframe_sec" value="0" />
				<input type="checkbox" title="<?php _e( 'If checked, specifies that content should be displayed in an iFrame. Must be used when using Lightbox Plus Colorbox to display content from another site.  Can be used to display external web pages, video and more. DEFAULT:  Checked', 'lightboxplus'  ) ?>" name="iframe_sec" id="iframe_sec" value="1"<?php checked( '1', $g_lbp_secondary_options['iframe_sec'] ); ?> />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="class_name_sec"><?php _e( 'Secondary Class Name', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<!-- Class name: -->
				<input type="text" title="<?php _e( "If checked, Lightbox Plus Colorbox will only lightbox images using a class instead of the 'rel=lightbox[]' attribute.  Using this method you can manually control which images are affected by Lightbox Plus Colorbox by adding the class to the Advanced Link Settings in the WordPress Edit Image tool or by adding it to the image link URL and checking the 'Do Not Auto-Lightbox Images' option. You can also specify the name of the class instead of using the default. DEFAULT:  Unchecked / Default lbp_secondary", 'lightboxplus'  ) ?>" size="15" name="class_name_sec" id="class_name_sec" value="<?php if ( empty( $g_lbp_secondary_options['class_name_sec'] ) ) {
					echo 'lbpModal';
				} else {
					echo $g_lbp_secondary_options['class_name_sec'];
				} ?>" />
			</td>
		</tr>

		<tr>
			<th scope="row">
				<label for="no_display_title_sec"><?php _e( '<strong>Do Not</strong> Display Image Title', 'lightboxplus' ) ?></label>:
			</th>
			<td>
				<input type="hidden" name="no_display_title_sec" value="0" />
				<input type="checkbox" title="<?php _e( "If checked, Lightbox Plus Colorbox will not display image titles automatically.  This has no effect if the 'Do Not Auto-Lightbox Images' option is checked. DEFAULT:  Unchecked", 'lightboxplus'  ) ?>" name="no_display_title_sec" id="no_display_title_sec" value="1"<?php checked( '1', $g_lbp_secondary_options['no_display_title_sec'] ); ?> />
			</td>
		</tr>
	</table>
</div>
<!-- Usage -->
<div id="slbp-tabs-7">
	<table class="form-table">
		<tr>
			<td>
				<h4><?php _e( 'Secondary Lightbox General Usage', 'lightboxplus' ); ?></h4>

				<p><?php _e( 'A secondary lightbox can be used to display internal and external web pages, video or interactive flash. Secondary lightboxes must be set up manually and can use either a rel="lightbox[id]" attribute or a class="lbpModal" attribute to associate the link/content with the a lightbox.  The following examples show different methods to use secondary lightboxes.', 'lightboxplus' ); ?></p>
				<h4><?php _e( 'Using Secondary Lightbox for Video Content', 'lightboxplus' ); ?></h4>

				<p><?php _e( 'A secondary lightbox can be used to display video from either an internal or external source.  In order to display video using Lightbox Plus Colorbox and Colorbox you must at a minimum have the following items set: Inner Width, Inner Height, and Use Iframe must be checked.', 'lightboxplus' ) ?></p>

				<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
					<h5>
						<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span><?php _e( 'YouTube Example', 'lightboxplus' ) ?>
					</h5>

					<p><?php _e( 'For YouTube videos to load you cannot use the share link which looks like this: <code>http://youtu.be/17jymDn0W6U</code>.  However you can get the required link from the embed option that you get from YouTube. The embed links look like this: <code>&lt;iframe width="420" height="315" src="http://www.youtube.com/embed/17jymDn0W6U" frameborder="0" allowfullscreen>&lt;/iframe></code>. You will need to copy the URL (in this case: <code>http://www.youtube.com/embed/17jymDn0W6U</code>) and create your link as follows:', 'lightboxplus' ) ?></p>

					<p class="codebox">
						<code>&lt;a title="The Known Universe" class="lbpModal" href="http://www.youtube.com/embed/17jymDn0W6U"><?php _e( 'YouTube Flash / Video (Iframe/Direct Link To YouTube Video)', 'lightboxplus' ) ?>&lt;/a></code>
					</p>
					<h5>
						<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span><?php _e( 'Vimeo Example', 'lightboxplus' ) ?>
					</h5>

					<p><?php _e( 'In the case of Vimeo you can again use the link provided from the embed option (in this case: <code>http://player.vimeo.com/video/9730308?title=0&amp;byline=0&amp;portrait=0</code>) to create your link as follows:', 'lightboxplus' ) ?></p>

					<p class="codebox">
						<code>&lt;a title="Projection Animation Test" class="lbpModal" href="http://player.vimeo.com/video/9730308?title=0&amp;byline=0&amp;portrait=0"><?php _e( 'Vimeo Flash / Video (Iframe/Direct Link To Vimeo)', 'lightboxplus' ) ?>&lt;/a></code>
					</p>
				</div>
				<p><?php _e( 'For locally hosted video you must use the Inline Lightbox option unless you have a similar setup to YouTube or Vimeo for video display.  See inline lightbox usage for how to display locally hosted video.  Additional video options may be possible but you will have to experiment to see what works.', 'lightboxplus' ) ?></p>

				<h4><?php _e( 'Using Secondary Lightbox for External Content', 'lightboxplus' ) ?></h4>

				<p><?php _e( 'A secondary lightbox can be used to show a web page, text, or other content hosted either locally or on another server.  In order to display external content using Lightbox Plus Colorbox and Colorbox you must at a minimum has the following items set: Inner Width, Inner Height, and Use Iframe must be checked.', 'lightboxplus' ) ?></p>

				<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
					<h5>
						<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span><?php _e( 'External Site Example', 'lightboxplus' ) ?>
					</h5>

					<p><?php _e( 'In the case of an external webpage you merely need to specify the URL to display.  In this case we are using the class method for instantiating the lightbox.  When the user clicks the link instead of redirecting the browser to another page it opens the page within the lightbox.', 'lightboxplus' ) ?></p>

					<p class="codebox">
						<code>&lt;a class="lbpModal" href="http://wordpress.org/extend/plugins/lightbox-plus/">External Content (Iframe/Direct Link To WordPress plugins)&lt;/a></code>
					</p>
					<h5>
						<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span><?php _e( 'Local Text File Example', 'lightboxplus' ) ?>
					</h5>

					<p><?php _e( 'In the case of an local content webpage you merely need to specify the local URL to display.  In this case we are using the class method for instantiating the lightbox.  When the user clicks the link instead of opening the text file the file is opened within the lightbox.', 'lightboxplus' ) ?></p>

					<p class="codebox">
						<code>&lt;a class="lbpModal" href="<?php echo LBP_URL; ?>/readme.txt">Locally Hosted Content (Iframe/Direct Link To Text File)&lt;/a></code>
					</p>
				</div>

				<h4><?php _e( 'Using Secondary Lightbox for Other Content', 'lightboxplus' ) ?></h4>
				<?php _e( 'Finally, a secondary lightbox can be used to load interactive flash files such as games, quizzes or other content.  In order to display interactive flash, you must at a minimum have the following items set: Inner Width, Inner Height, and Use Iframe must be checked.', 'lightboxplus' ) ?>
				<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
					<h5>
						<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span><?php _e( 'Interactive Flash Example', 'lightboxplus' ) ?>
					</h5>

					<p><?php _e( 'In the case of an local content webpage you merely need to specify the local URL of the SWF file.  In this case we are using the class method for instantiating the lightbox.  When the user clicks the link instead of opening the SWF file in a browser window the file is opened within the lightbox.', 'lightboxplus' ) ?></p>

					<p class="codebox">
						<code>&lt;a href="<?php echo LBP_ASSETS_URL; ?>/examples/trivia.swf" class="lbpModal" title="Interactive Flash Demo">Interactive Flash (Iframe/Local Flash File)&lt;/a></code>
					</p>
				</div>
			</td>
		</tr>
	</table>
</div>
<!-- Demo/Test -->
<div id="slbp-tabs-8">
	<table class="form-table">
		<tr valign="top">
			<td>
				<?php _e( 'Here you can test you settings with various different implementations of Lightbox Plus Colorbox for Video, External Pages and Interactive Flash.  If they do not work please check that you have the following items set: Inner Width, Inner Height, and Use Iframe must be checked.  You will not be able to display any of these without the minimum options set.', "lightboxplus" ); ?>
			</td>
		</tr>
		<tr>
			<td>
				<p>
					<a href="<?php echo LBP_URL ?>screenshot-2.jpg"<?php
					if ( isset( $g_lbp_secondary_options['class_name_sec'] ) ) {
						echo ' class="' . $g_lbp_secondary_options['class_name_sec'] . '"';
					}
					if ( isset( $g_lbp_secondary_options['output_htmlv'] ) ) {
						echo ' data-' . $g_lbp_secondary_options['data_name'] . '="secondary-demo"';
					} else {
						echo ' rel="lightbox[secondary-demo]"';
					}
					?> title="Secondary Lightbox - Screenshot 2">Secondary Lightbox - Screenshot 2 - Text Link</a></p>

				<p class="codebox">
					<code>&lt;a href="<?php echo LBP_URL ?>screenshot-2.jpg"<?php
						if ( isset( $g_lbp_secondary_options['class_name_sec'] ) ) {
							echo ' class="' . $g_lbp_secondary_options['class_name_sec'] . '"';
						}
						if ( isset( $g_lbp_secondary_options['output_htmlv'] ) ) {
							echo ' data-' . $g_lbp_secondary_options['data_name'] . '="secondary-demo"';
						} else {
							echo ' rel="lightbox[secondary-demo]"';
						}
						?> title="Secondary Lightbox - Screenshot 2">Secondary Lightbox - Screenshot 2 - Text Link&lt;/a></code>
				</p>

				<p><a href="http://www.youtube.com/embed/17jymDn0W6U"<?php
					if ( isset( $g_lbp_secondary_options['class_name_sec'] ) ) {
						echo ' class="' . $g_lbp_secondary_options['class_name_sec'] . '"';
					}
					if ( isset( $g_lbp_secondary_options['output_htmlv'] ) ) {
						echo ' data-' . $g_lbp_secondary_options['data_name'] . '="secondary-demo"';
					} else {
						echo ' rel="lightbox[secondary-demo]"';
					}
					?> title="Secondary Lightbox - Video Test">Secondary Lightbox - Video Test</a>

				<p class="codebox"><code>&lt;a href="http://www.youtube.com/embed/17jymDn0W6U"<?php
						if ( isset( $g_lbp_secondary_options['class_name_sec'] ) ) {
							echo ' class="' . $g_lbp_secondary_options['class_name_sec'] . '"';
						}
						if ( isset( $g_lbp_secondary_options['output_htmlv'] ) ) {
							echo ' data-' . $g_lbp_secondary_options['data_name'] . '="secondary-demo"';
						} else {
							echo ' rel="lightbox[secondary-demo]"';
						}
						?> title="Secondary Lightbox - Video Test">Secondary Lightbox - Video Test&lt;/a></code></p>

				<p>
					<a title="Lightbox Plus Colorbox Forums" href="http://lightboxplus.rocks"<?php
					if ( isset( $g_lbp_secondary_options['class_name_sec'] ) ) {
						echo ' class="' . $g_lbp_secondary_options['class_name_sec'] . '"';
					}
					if ( isset( $g_lbp_base_options['output_htmlv'] ) ) {
						echo ' data-' . $g_lbp_base_options['data_name'] . '="secondary-demo"';
					} else {
						echo ' rel="lightbox[secondary-demo]"';
					}
					?>>Secondary Lightbox - External Page Test</a></p>

				<p class="codebox"><code>&lt;a href="http://lightboxplus.rocks"<?php
						if ( isset( $g_lbp_secondary_options['class_name_sec'] ) ) {
							echo ' class="' . $g_lbp_secondary_options['class_name_sec'] . '"';
						}
						if ( isset( $g_lbp_base_options['output_htmlv'] ) ) {
							echo ' data-' . $g_lbp_base_options['data_name'] . '="secondary-demo"';
						} else {
							echo ' rel="lightbox[secondary-demo]"';
						}
						?> title="Lightbox Plus Colorbox Forums">Secondary Lightbox - External Page Test&lt;/a></code>
				</p>

				<p><a href="<?php echo LBP_ASSETS_URL ?>/examples/trivia.swf"<?php
					if ( isset( $g_lbp_secondary_options['class_name_sec'] ) ) {
						echo ' class="' . $g_lbp_secondary_options['class_name_sec'] . '"';
					}
					if ( isset( $g_lbp_secondary_options['output_htmlv'] ) ) {
						echo ' data-' . $g_lbp_secondary_options['data_name'] . '="secondary-demo"';
					} else {
						echo ' rel="lightbox[secondary-demo]"';
					}
					?> title="Secondary Lightbox - Interactive Flash">Secondary Lightbox - Interactive Flash</a></p>

				<p class="codebox"><code>&lt;a href="<?php echo LBP_ASSETS_URL ?>/examples/trivia.swf"<?php
						if ( isset( $g_lbp_secondary_options['class_name_sec'] ) ) {
							echo ' class="' . $g_lbp_secondary_options['class_name_sec'] . '"';
						}
						if ( isset( $g_lbp_secondary_options['output_htmlv'] ) ) {
							echo ' data-' . $g_lbp_secondary_options['data_name'] . '="secondary-demo"';
						} else {
							echo ' rel="lightbox[secondary-demo]"';
						}
						?> title="Secondary Lightbox - Interactive Flash">Secondary Lightbox - Interactive Flash&lt;/a></code>
				</p>
			</td>
		</tr>
	</table>
</div>
</div>
<p class="submit">
	<input type="submit" name="Submit" class="button-primary save-all-settings" id="save-secondary" title="<?php _e( 'Save Secondary Lightbox Plus Colorbox Settings', 'lightboxplus' ) ?>" value="<?php _e( 'Save Secondary Lightbox Settings', 'lightboxplus' ) ?> &raquo;" />
</p>
</div>
</div>
</div>
</form>
<!-- Begin Secondary Lightbox -->