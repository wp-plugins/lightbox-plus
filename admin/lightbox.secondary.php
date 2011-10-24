<?php
    /**
    * @package Lightbox Plus
    * @subpackage lightbox.secondary.php
    * @internal 2011.10.03
    * @author Dan Zappone / 23Systems
    * @version 2.4
    */ 
    /**
    * @todo Add scrolling_sec (Interface)
    * @todo Add photo_sec (General)
    * @todo Add rel_sec (Interface) (i.e Disable Grouping)
    * @todo Add loop_sec (General)
    * @todo Add esc_key_sec (Interface)
    * @todo Add arrow_key_sec (Interface)
    * @done Add top_sec (Position)
    * @done Add bottom_sec (Position)
    * @done Add left_sec (Position)
    * @done Add right_sec (Position)
    * @done Add fixed_sec (Position)
    * @todo Remove this comment
    */
?>
<!-- Secondary Lightbox Settings -->
<div id="poststuff" class="lbp">
    <div class="postbox"> <!-- add  close-me  to class to set auto closed -->
        <h3 class="handle"><?php _e( 'Lightbox Plus - Secondary Lightbox Settings','lightboxplus' ); ?></h3>
        <div class="inside toggle">
            <div id="slbp-tabs">
                <ul>
                    <li><a href="#slbp-tabs-1"><?php _e( 'General','lightboxplus' ); ?></a></li>
                    <li><a href="#slbp-tabs-2"><?php _e( 'Size','lightboxplus' ); ?></a></li>
                    <li><a href="#slbp-tabs-3"><?php _e( 'Postition','lightboxplus' ); ?></a></li>
                    <li><a href="#slbp-tabs-4"><?php _e( 'Interface','lightboxplus' ); ?></a></li>
                    <li><a href="#slbp-tabs-5"><?php _e( 'Slideshow','lightboxplus' ); ?></a></li>
                    <li><a href="#slbp-tabs-6"><?php _e( 'Other','lightboxplus' ); ?></a></li>
                    <li><a href="#slbp-tabs-7"><?php _e( 'Usage','lightboxplus' ); ?></a></li>
                    <li><a href="#slbp-tabs-8"><?php _e( 'Demo/Test','lightboxplus' ); ?></a></li>
                </ul>
                <!-- General -->
                <div id="slbp-tabs-1">
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <?php _e( 'Transition Type', 'lightboxplus' )?>: </th>
                            <td>
                                <select name="transition_sec" id="transition_sec">
                                    <option value="elastic"<?php if ( $lightboxPlusOptions['transition_sec']=='elastic' ) echo ' selected="selected"'?>>Elastic</option>
                                    <option value="fade"<?php if ( $lightboxPlusOptions['transition_sec']=='fade' ) echo ' selected="selected"'?>>Fade</option>
                                    <option value="none"<?php if ( $lightboxPlusOptions['transition_sec']=='none' ) echo ' selected="selected"'?>>None</option>
                                </select>
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_transition_sec_tip">
                                    <?php _e( 'Specifies the transition type. Can be set to "elastic", "fade", or "none". <strong><em>Default: Elastic</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <?php _e( 'Resize Speed', 'lightboxplus' )?>: </th>
                            <td>
                                <select name="speed_sec" id="speed_sec">
                                    <?php 
                                        for($i = 0; $i <= 5001;){ ?>
                                        <option value="<?php echo $i; ?>"<?php if ( $lightboxPlusOptions['speed_sec'] == strval($i) ) echo ' selected="selected"'?>><?php echo $i; ?></option>
                                        <?php  
                                            if ($i >= 2000) { $i = $i + 500; }
                                            elseif ($i >= 1250) { $i = $i + 250; }
                                            else { $i = $i + 50; }
                                        } 
                                    ?>
                                </select>
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_speed_sec_tip">
                                    <?php _e( 'Controls the speed of the fade and elastic transitions, in milliseconds. <strong><em>Default: 350</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <?php _e( 'Overlay Opacity', 'lightboxplus' )?>: </th>
                            <td>
                                <select name="opacity_sec">
                                    <?php 
                                        for($i = 0; $i <= 1.01; $i = $i + .05){ ?>
                                        <option value="<?php echo $i; ?>"<?php if ( $lightboxPlusOptions['opacity_sec'] == strval($i) ) { echo ' selected="selected"'; }?>><?php echo ($i*100); ?>%</option>
                                        <?php 
                                        } 
                                    ?>
                                </select>
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_opacity_sec_tip">
                                    <?php _e( 'Controls transparency of shadow overlay. Lower numbers are more transparent. <strong><em>Default: 80%</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <?php _e( 'Pre-load images', 'lightboxplus' )?>: </th>
                            <td>
                                <input type="checkbox" name="preloading_sec" value="1"<?php if ( $lightboxPlusOptions['preloading_sec'] ) echo ' checked="checked"';?> />
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_preloading_sec_tip">
                                    <?php _e( 'Allows for preloading of "Next" and "Previous" content in a shared relation group (same values for the "rel" attribute), after the current content has finished loading. Uncheck to disable. <strong><em>Default: Checked</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- Size -->
                <div id="slbp-tabs-2">
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <?php _e( 'Width', 'lightboxplus' )?>: </th>
                            <td>
                                <input type="text" size="15" name="width_sec" id="width_sec" value="<?php if ( !empty( $lightboxPlusOptions['width_sec'] )) { echo $lightboxPlusOptions['width_sec'];} else { echo ''; } ?>" />
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_width_sec_tip">
                                    <?php _e( 'Set a fixed total width. This includes borders and buttons. Example: "100%", "500px", or 500, or false for no defined width.  <strong><em>Default: false</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <?php _e( 'Height', 'lightboxplus' )?>: </th>
                            <td>
                                <input type="text" size="15" name="height_sec" id="height_sec" value="<?php if ( !empty( $lightboxPlusOptions['height_sec'] )) { echo $lightboxPlusOptions['height_sec'];} else { echo ''; } ?>" />
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_height_sec_tip">
                                    <?php _e( 'Set a fixed total height. This includes borders and buttons. Example: "100%", "500px", or 500, or false for no defined height. <strong><em>Default: false</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <?php _e( 'Inner Width', 'lightboxplus' )?>: </th>
                            <td>
                                <input type="text" size="15" name="inner_width_sec" id="inner_width_sec" value="<?php if ( !empty( $lightboxPlusOptions['inner_width_sec'] )) { echo $lightboxPlusOptions['inner_width_sec'];} else { echo ''; } ?>" />
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_inner_width_sec_tip">
                                    <?php _e( 'This is an alternative to "width" used to set a fixed inner width. This excludes borders and buttons. Example: "50%", "500px", or 500, or false for no inner width.  <strong><em>Default: false</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <?php _e( 'Inner Height', 'lightboxplus' )?>: </th>
                            <td>
                                <input type="text" size="15" name="inner_height_sec" id="inner_height_sec" value="<?php if ( !empty( $lightboxPlusOptions['inner_height_sec'] )) { echo $lightboxPlusOptions['inner_height_sec'];} else { echo ''; } ?>" />
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_inner_height_sec_tip">
                                    <?php _e( 'This is an alternative to "height" used to set a fixed inner height. This excludes borders and buttons. Example: "50%", "500px", or 500 or false for no inner height. <strong><em>Default: false</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <?php _e( 'Initial Width', 'lightboxplus' )?>: </th>
                            <td>
                                <input type="text" size="15" name="initial_width_sec" id="initial_width_sec" value="<?php if ( !empty( $lightboxPlusOptions['initial_width_sec'] )) { echo $lightboxPlusOptions['initial_width_sec'];} else { echo ''; } ?>" />
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_initial_width_sec_tip">
                                    <?php _e( 'Set the initial width, prior to any content being loaded.  <strong><em>Default: 300</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <?php _e( 'Initial Height', 'lightboxplus' )?>: </th>
                            <td>
                                <input type="text" size="15" name="initial_height_sec" id="initial_height_sec" value="<?php if ( !empty( $lightboxPlusOptions['initial_height_sec'] )) { echo $lightboxPlusOptions['initial_height_sec'];} else { echo ''; } ?>" />
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_initial_height_sec_tip">
                                    <?php _e( 'Set the initial height, prior to any content being loaded. <strong><em>Default: 100</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <?php _e( 'Maximum Width', 'lightboxplus' )?>: </th>
                            <td>
                                <input type="text" size="15" name="max_width_sec" id="max_width_sec" value="<?php if ( !empty( $lightboxPlusOptions['max_width_sec'] )) { echo $lightboxPlusOptions['max_width_sec'];} else { echo ''; } ?>" />
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_max_width_sec_tip">
                                    <?php _e( 'Set a maximum width for loaded content.  Example: "75%", "500px", 500, or false for no maximum width.  <strong><em>Default: false</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <?php _e( 'Maximum Height', 'lightboxplus' )?>: </th>
                            <td>
                                <input type="text" size="15" name="max_height_sec" id="max_height_sec" value="<?php if ( !empty( $lightboxPlusOptions['max_height_sec'] )) { echo $lightboxPlusOptions['max_height_sec'];} else { echo ''; } ?>" />
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_max_height_sec_tip">
                                    <?php _e( 'Set a maximum height for loaded content.  Example: "75%", "500px", 500, or false for no maximum height. <strong><em>Default: false</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <?php _e( 'Resize', 'lightboxplus' )?>: </th>
                            <td>
                                <input type="checkbox" name="resize_sec" id="resize_sec" value="1"<?php if ( $lightboxPlusOptions['resize_sec'] ) echo ' checked="checked"';?> />
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_resize_sec_tip">
                                    <?php _e( 'If checked and if Maximum Width or Maximum Height have been defined, Lightbx Plus will resize photos to fit within the those values. <strong><em>Default: Checked</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- Position -->
                <div id="slbp-tabs-3">
                    <table class="form-table">
                        <tr>
                            <th scope="row"><?php _e( 'Top', 'lightboxplus' )?>: </th>
                            <td><input name="top_sec" type="text" id="top_sec" size="8" maxlength="8" value="<?php if ( !empty( $lightboxPlusOptions['top'] )) { echo $lightboxPlusOptions['top'];} else { echo ''; } ?>" /><a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_top_tip">
                                    <?php _e( 'Accepts a pixel or percent value (50, "50px", "10%"). Controls vertical positioning instead of using the default position of being centered in the viewport. <strong><em>Default: null</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php _e( 'Right', 'lightboxplus' )?>: </th>
                            <td><input name="right_sec" type="text" id="right_sec" size="8" maxlength="8" value="<?php if ( !empty( $lightboxPlusOptions['right'] )) { echo $lightboxPlusOptions['right'];} else { echo ''; } ?>" /><a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_top_tip">
                                    <?php _e( 'Accepts a pixel or percent value (50, "50px", "10%"). Controls horizontal positioning instead of using the default position of being centered in the viewport. <strong><em>Default: null</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php _e( 'Bottom', 'lightboxplus' )?>: </th>
                            <td><input name="bottom_sec" type="text" id="bottom_sec" size="8" maxlength="8" value="<?php if ( !empty( $lightboxPlusOptions['bottom'] )) { echo $lightboxPlusOptions['bottom'];} else { echo ''; } ?>" /><a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_top_tip">
                                    <?php _e( 'SetAccepts a pixel or percent value (50, "50px", "10%"). Controls vertical positioning instead of using the default position of being centered in the viewport. <strong><em>Default: false</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php _e( 'Left', 'lightboxplus' )?>: </th>
                            <td><input name="left_sec" type="text" id="left_sec" size="8" maxlength="8" value="<?php if ( !empty( $lightboxPlusOptions['left'] )) { echo $lightboxPlusOptions['left'];} else { echo ''; } ?>" /><a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_top_tip">
                                    <?php _e( 'SetAccepts a pixel or percent value (50, "50px", "10%"). Controls horizontal positioning instead of using the default position of being centered in the viewport. <strong><em>Default: false</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <?php _e( 'Fixed', 'lightboxplus' )?>: </th>
                            <td>
                                <input type="checkbox" name="fixed_sec" id="fixed_sec" value="1"<?php if ( $lightboxPlusOptions['fixed'] ) echo ' checked="checked"';?> />
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_fixed_tip">
                                    <?php _e( 'If check, the lightbox will always be displayed in a fixed position within the viewport. In otherwords it will stay within the viewport while scolling on the page.  This is unlike the default absolute positioning relative to the document. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- Interface -->
                <div id="slbp-tabs-4">
                    <table class="form-table">
                        <tr>
                            <th scope="row" colspan="2"><strong><?php _e( 'General Interface Options', 'lightboxplus' )?></strong></th>
                        </tr>
                        <tr class="grouping_sec">
                            <th scope="row">
                                <?php _e( 'Close image text', 'lightboxplus' )?>: </th>
                            <td>
                                <input type="text" size="15" name="close_sec" id="close_sec" value="<?php if (empty( $lightboxPlusOptions['close_sec'] )) { echo ''; } else { echo $lightboxPlusOptions['close_sec'];} ?>" />
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_close_sec_tip">
                                    <?php _e( 'Text for the close button. If Overlay Close or ESC Key Close are check those options will also close the lightbox. <strong><em>Default: close</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <?php _e( 'Overlay Close', 'lightboxplus' )?>: </th>
                            <td>
                                <input type="checkbox" name="overlay_close_sec" id="overlay_close_sec" value="1"<?php if ( $lightboxPlusOptions['overlay_close_sec'] ) echo ' checked="checked"';?> />
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_overlay_close_sec_tip">
                                    <?php _e( 'If checked, enables closing Lightbox Plus by clicking on the background overlay. <strong><em>Default: Checked</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <?php _e( 'ESC Key Close', 'lightboxplus' )?>: </th>
                            <td>
                                <input type="checkbox" name="esc_key_sec" id="esc_key_sec" value="1"<?php if ( $lightboxPlusOptions['esc_key_sec'] ) echo ' checked="checked"';?> />
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_esc_key_sec_tip">
                                    <?php _e( 'If checked, enables closing Lightbox Plus using the ESC key. <strong><em>Default: Checked</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <?php _e( 'Scroll Bars', 'lightboxplus' )?>: </th>
                            <td>
                                <input type="checkbox" name="scrolling_sec" id="scrolling_sec" value="1"<?php if ( $lightboxPlusOptions['scrolling_sec'] ) echo ' checked="checked"';?> />
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_scrolling_sec_tip">
                                    <?php _e( 'If unchecked, Lightbox Plus will hide scrollbars for overflowing content. <strong><em>Default: Checked</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" colspan="2"><strong><?php _e( 'Image Grouping', 'lightboxplus' )?></strong></th>
                        </tr>
                        <tr>
                            <th scope="row">
                                <?php _e( 'Disable grouping', 'lightboxplus' )?>: </th>
                            <td>
                                <input type="checkbox" id="rel_sec" name="rel_sec" value="nofollow"<?php if ( $lightboxPlusOptions['rel_sec'] == 'nofollow' ) echo ' checked="checked"';?> />
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_nogrouping_sec_tip">
                                    <?php _e( 'If checked will disbale the useage of grouping labels. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                        <tr class="grouping_sec">
                            <th scope="row">
                                <?php _e( 'Grouping Labels', 'lightboxplus' )?>: </th>
                            <td>
                                <input type="text" size="15" name="label_image_sec" id="label_imag_sece" value="<?php if (empty( $lightboxPlusOptions['label_image_sec'])) { echo ''; } else {echo $lightboxPlusOptions['label_image_sec'];}?>" />
                                #
                                <input type="text" size="15" name="label_of_sec" id="label_of_sec" value="<?php if (empty( $lightboxPlusOptions['label_of_sec'] )) { echo ''; } else {echo $lightboxPlusOptions['label_of_sec'];}?>" />
                                # <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_label_image_sec_tip">
                                    <?php _e( 'Text format for the content group / gallery count. {current} and {total} are detected and replaced with actual numbers while ColorBox runs.<strong><em>Default: Image {current} of {total}</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                        <tr class="grouping_sec">
                            <th scope="row">
                                <?php _e( 'Previous image text', 'lightboxplus' )?>: </th>
                            <td>
                                <input type="text" size="15" name="previous_sec" id="previous_sec" value="<?php if (empty( $lightboxPlusOptions['previous_sec'])) { echo ''; } else { echo $lightboxPlusOptions['previous_sec'];} ?>" />
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_previous_sec_tip">
                                    <?php _e( 'Text for the previous button in a shared relation group (same values for "rel" attribute). <strong><em>Default: previous</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                        <tr class="grouping_sec">
                            <th scope="row">
                                <?php _e( 'Next image text', 'lightboxplus' )?>: </th>
                            <td>
                                <input type="text" size="15" name="next_sec" id="next_sec" value="<?php if (empty( $lightboxPlusOptions['next_sec'])) { echo ''; } else { echo $lightboxPlusOptions['next_sec'];} ?>" />
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_next_sec_tip">
                                    <?php _e( 'Text for the next button in a shared relation group (same values for "rel" attribute).  <strong><em>Default: next</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                        <tr class="grouping_sec">
                            <th scope="row">
                                <?php _e( 'Arrow key navigation', 'lightboxplus' )?>: </th>
                            <td>
                                <input type="checkbox" name="arrow_key_sec" id="arrow_key_sec" value="1"<?php if ( $lightboxPlusOptions['arrow_key_sec'] ) echo ' checked="checked"';?> />
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_arrow_key_sec_tip">
                                    <?php _e( 'If checked, enables the left and right arrow keys for navigating between the items in a group. <strong><em>Default: Checked</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                        <tr class="grouping_sec">
                            <th scope="row">
                                <?php _e( 'Loop image group', 'lightboxplus' )?>: </th>
                            <td>
                                <input type="checkbox" name="loop_sec" id="loop_sec" value="1"<?php if ( $lightboxPlusOptions['loop_sec'] ) echo ' checked="checked"';?> />
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_loop_sec_tip">
                                    <?php _e( 'If checked, enables the ability to loop back to the beginning of the group when on the last element. <strong><em>Default: Checked</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- Slideshow -->
                <div id="slbp-tabs-5">
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <?php _e( 'Slideshow', 'lightboxplus' )?>: </th>
                            <td>
                                <input type="checkbox" name="slideshow_sec" id="slideshow_sec" value="1"<?php if ( $lightboxPlusOptions['slideshow_sec'] ) echo ' checked="checked"';?> />
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_slideshow_sec_tip">
                                    <?php _e( 'If checked, adds slideshow capablity to a content group / gallery. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                        <tr class="slideshow_sec">
                            <th scope="row">
                                <?php _e( 'Auto-Start Slideshow', 'lightboxplus' )?>: </th>
                            <td>
                                <input type="checkbox" name="slideshow_auto_sec" id="slideshow_auto_sec" value="1"<?php if ( $lightboxPlusOptions['slideshow_auto'] ) echo ' checked="checked"';?> />
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_slideshow_auto_sec_tip">
                                    <?php _e( 'If checked, the slideshows will automatically start to play when content grou opened. <strong><em>Default: Checked</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                        <tr class="slideshow_sec">
                            <th scope="row">
                                <?php _e( 'Slideshow Speed', 'lightboxplus' )?>: </th>
                            <td>
                                <select name="slideshow_speed_sec" id="slideshow_speed_sec">
                                    <?php 
                                        for($i = 500;$i <= 20001;){ ?>
                                        <option value="<?php echo $i; ?>"<?php if ( $lightboxPlusOptions['slideshow_speed_sec'] == strval($i) ) echo ' selected="selected"'?>><?php echo $i; ?></option>
                                        <?php  
                                            if ($i >= 15000) { $i = $i + 5000; }
                                            elseif ($i >= 10000) { $i = $i + 1000; }
                                            else { $i = $i + 500; }
                                        } 
                                    ?>
                                </select>
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_slideshow_speed_sec_tip">
                                    <?php _e( 'Controls the speed of the slideshow, in milliseconds. <strong><em>Default: 2500</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                        <tr class="slideshow_sec">
                            <th scope="row">
                                <?php _e( 'Slideshow start text', 'lightboxplus' )?>: </th>
                            <td>
                                <input type="text" size="15" name="slideshow_start_sec" id="slideshow_start_sec" value="<?php if ( !empty( $lightboxPlusOptions['slideshow_start_sec'] )) { echo $lightboxPlusOptions['slideshow_start_sec'];} else { echo 'start'; } ?>" />
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_slideshow_start_sec_tip">
                                    <?php _e( 'Text for the slideshow start button. <strong><em>Default: start</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                        <tr class="slideshow_sec">
                            <th scope="row">
                                <?php _e( 'Slideshow stop text', 'lightboxplus' )?>: </th>
                            <td>
                                <input type="text" size="15" name="slideshow_stop_sec" id="slideshow_stop_sec" value="<?php if ( !empty( $lightboxPlusOptions['slideshow_stop_sec'] )) { echo $lightboxPlusOptions['slideshow_stop_sec'];} else { echo 'stop'; } ?>" />
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_slideshow_stop_sec_tip">
                                    <?php _e( 'Text for the slideshow stop button.  <strong><em>Default: stop</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- Other -->
                <div id="slbp-tabs-6">
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <?php _e( 'Use iFrame', 'lightboxplus' )?>: </th>
                            <td>
                                <input type="checkbox" name="iframe_sec" id="iframe_sec" value="1"<?php if ( $lightboxPlusOptions['iframe_sec'] ) echo ' checked="checked"';?> />
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_iframe_sec_tip">
                                    <?php _e( 'If checked, specifies that content should be displayed in an iFrame. Must be used when using Lightbox Plus to display content from another site.  Can be used to display external web pages, video and more. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <?php _e( 'Use Class Method', 'lightboxplus' )?>: </th>
                            <td>
                                <input type="checkbox" name="use_class_method_sec" id="use_class_method_sec" value="1"<?php if ( $lightboxPlusOptions['use_class_method_sec'] ) echo ' checked="checked"';?> />
                                Class name:
                                <input type="text" size="15" name="class_name_sec" id="class_name_sec" value="<?php if (empty( $lightboxPlusOptions['class_name_sec'] )) { echo 'lbpModal'; } else {echo $lightboxPlusOptions['class_name_sec'];}?>" />
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"> <img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_use_class_method_sec_tip">
                                    <?php _e( 'If checked, Lightbox Plus will only lightbox images using a class instead of the <code>rel=lightbox[]</code> attribute.  Using this method you can manually control which images are affected by Lightbox Plus by adding the class to the Advanced Link Settings in the WordPress Edit Image tool or by adding it to the image link URL and checking the <strong>Do Not Auto-Lightbox Images</strong> option. You can also specify the name of the class instead of using the default. <strong><em>Default: Unchecked / Default cboxModal</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <?php _e( '<strong>Do Not</strong> Display Image Title', 'lightboxplus' )?>: </th>
                            <td>
                                <input type="checkbox" name="no_display_title_sec" id="no_display_title_sec" value="1"<?php if ( $lightboxPlusOptions['no_display_title_sec'] ) echo ' checked="checked"';?> />
                                <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                <div class="lbp-bigtip" id="lbp_no_display_title_sec_tip">
                                    <?php _e( 'If checked, Lightbox Plus <em>will not</em> display image titles automatically.  This has no effect if the <strong>Do Not Auto-Lightbox Images</strong> option is checked. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- Usage -->
                <div id="slbp-tabs-7">
                    <table class="form-table">
                        <tr>
                            <td>
                            <h4><?php _e( 'Using Secondary Lightbox for Video Content'); ?></h4>
                            <div id="lbp_for_video_tip">
                                <?php _e( 'In order to display video using Lightbox Plus and Colorbox you must at a minimum have the following items set: Inner Width, Inner Height, and Use Iframe must be checked.<br /><br />
                                    <code>&lt;a title="Projection Animation Test" class="lbpModal" href="http://www.youtube.com/v/pUPrCCP73Ws">YouTube Flash / Video (Iframe/Direct Link To YouTube)&lt;/a></code><br />
                                    <code>&lt;a title="Projection Animation Test" class="lbpModal" href="http://vimeo.com/moogaloop.swf?clip_id=9730308&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1">Vimeo Flash / Video (Iframe/Direct Link To Vimeo)&lt;/a></code>', 'lightboxplus' )?>
                            </div>
                        </tr>
                        <tr>
                            <td>
                                <h4><?php _e( 'Using Secondary Lightbox for External Content'); ?></h4>
                                <div id="lbp_for_external_tip">
                                    <?php _e( 'In order to display external content using Lightbox Plus and Colorbox you must at a minimum has the following items set: Inner Width, Inner Height, and Use Iframe must be checked.<br /><br />
                                        <code>&lt;a class="lbpModal" href="http://wordpress.org/extend/plugins/lightbox-plus/">External Content (Iframe/Direct Link To WordPress plugins)&lt;/a></code>', 'lightboxplus' )?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4><?php _e( 'Using Secondary Lightbox for Other Content'); ?></h4>
                                <div id="lbp_for_other_tip">
                                    <?php _e( 'In order to display other content, such as interactive flash, using Lightbox Plus and Colorbox you must at a minimum has the following items set: Inner Width, Inner Height, and Use Iframe must be checked.<br /><br />
                                        <code>&lt;a href="'.$g_lightbox_plus_url.'/trivia.swf" class="lbpModal" title="Interactive Flash Demo">Interactive Flash (Iframe/Local Flash File)&lt;/a></code>', 'lightboxplus' )?>
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
                                <?php _e('Here you can test you settings with various different implementations of Lightbox Plus for Video, External Pages and Interactive Flash.  If they do not work please check that you have the following items set: Inner Width, Inner Height, and Use Iframe must be checked.  You will not be able to display any of these without the minimum options set.',"lightboxplus"); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="secondary_test_item">
                                    <a href="<?php echo $g_lightbox_plus_url ?>/screenshot-2.jpg" <?php if ( $lightboxPlusOptions['class_name_sec'] ) { echo 'class="'.$lightboxPlusOptions['class_name_sec'].'"'; } ?> title="Secondary Lightbox - Screenshot 2">Secondary Lightbox - Screenshot 2 - Text Link</a><br /><code>&lt;a href="<?php echo $g_lightbox_plus_url ?>/screenshot-2.jpg" <?php if ( $lightboxPlusOptions['class_name_sec'] ) { echo 'class="'.$lightboxPlusOptions['class_name_sec'].'"'; } ?> title="Secondary Lightbox - Screenshot 2">Secondary Lightbox - Screenshot 2 - Text Link&lt;/a></code><br /><br />
                                    <a title="The Known Universe" href="http://www.youtube.com/v/17jymDn0W6U" <?php if ( $lightboxPlusOptions['class_name_sec'] ) { echo 'class="'.$lightboxPlusOptions['class_name_sec'].'"'; } ?>>Secondary Lightbox - Video Test</a><br /><code>&lt;a title="The Known Universe" href="http://www.youtube.com/v/17jymDn0W6U" <?php if ( $lightboxPlusOptions['class_name_sec'] ) { echo 'class="'.$lightboxPlusOptions['class_name_sec'].'"'; } ?>>Secondary Lightbox - Video Test&lt;/a></code><br /><br />
                                    <a title="23Systems Lightbox Plus Forums" href="http://www.23systems.net/forums/forum/lightbox-plus/" <?php if ( $lightboxPlusOptions['class_name_sec'] ) { echo 'class="'.$lightboxPlusOptions['class_name_sec'].'"'; } ?>>Secondary Lightbox - External Page Test</a><br /><code>&lt;a title="23Systems Lightbox Plus Forums" href="http://www.23systems.net/forums/forum/lightbox-plus/" <?php if ( $lightboxPlusOptions['class_name_sec'] ) { echo 'class="'.$lightboxPlusOptions['class_name_sec'].'"'; } ?>>Secondary Lightbox - External Page Test&lt;/a></code><br /><br />
                                    <a href="<?php echo $g_lightbox_plus_url ?>/trivia.swf" <?php if ( $lightboxPlusOptions['class_name_sec'] ) { echo 'class="'.$lightboxPlusOptions['class_name_sec'].'"'; } ?> title="Secondary Lightbox - Interactive Flash">Secondary Lightbox - Interactive Flash</a><br /><code>&lt;a href="<?php echo $g_lightbox_plus_url ?>/trivia.swf" <?php if ( $lightboxPlusOptions['class_name_sec'] ) { echo 'class="'.$lightboxPlusOptions['class_name_sec'].'"'; } ?> title="Secondary Lightbox - Interactive Flash">Secondary Lightbox - Interactive Flash&lt;/a></code></p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <p class="submit">
                <input type="submit" style="padding:5px 30px 5px 30px;" name="Submit" title="<?php _e( 'Save all Lightbox Plus settings', 'lightboxplus' )?>" value="<?php _e( 'Save settings', 'lightboxplus' )?> &raquo;" />
            </p>
        </div>
    </div>
	</div>
	<!-- Begin Secondary Lightbox -->