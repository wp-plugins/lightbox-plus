<?php
    /**
    * @package Lightbox Plus
    * @subpackage lightbox.inline.php
    * @internal 2011.10.03
    * @author Dan Zappone / 23Systems
    * @version 2.4
    */
?>
<!-- Inline Lightbox Settings -->
<div id="poststuff" class="lbp">
    <div class="postbox">
        <h3 class="handle"><?php _e( 'Lightbox Plus - Inline Lightbox Settings','lightboxplus' ); ?></h3>
        <div class="inside toggle">
            <div id="ilbp-tabs">
                <ul>
                    <li><a href="#ilbp-tabs-1"><?php _e( 'General','lightboxplus' ); ?></a></li>
                    <li><a href="#ilbp-tabs-2"><?php _e( 'Usage','lightboxplus' ); ?></a></li>
                    <li><a href="#ilbp-tabs-3"><?php _e( 'Demo/Test','lightboxplus' ); ?></a></li>
                </ul>
                <!-- General -->
                <div id="ilbp-tabs-1">
                    <table class="wp-list-table widefat">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th><b>Link Class</b></th>
                                <th><b>Content ID</b></th>
                                <th style="text-align:center;"><b>Width<br />Height</b></th>
                                <th style="text-align:center;"><b>Inner Width<br />Inner Height</b></th>
                                <th style="text-align:center;"><b>Max Width<br />Max Height</b></th>
                                <th style="text-align:center;"><b>Position</b><br /><div style="font-size:8px;line-height:9px;">Top<br />Right, Bottom<br />Left</div></th>
                                <th><b>Fixed</b></th>
                                <th><b>Auto Open</b></th>
                                <th><b>Overlay Opacity</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                for ($i = 1; $i <= $lightboxPlusOptions['inline_num']; $i++) {
                                    $inline_links            = array();
                                    $inline_hrefs            = array();
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
                                    $inline_position_fixeds  = array();
                                    $inline_opens            = array();
                                    $inline_opacitys         = array();

                                    $inline_links            = $lightboxPlusOptions['inline_links'];
                                    $inline_hrefs            = $lightboxPlusOptions['inline_hrefs'];
                                    $inline_widths           = $lightboxPlusOptions['inline_widths'];
                                    $inline_heights          = $lightboxPlusOptions['inline_heights'];
                                    $inline_inner_widths     = $lightboxPlusOptions['inline_inner_widths'];
                                    $inline_inner_heights    = $lightboxPlusOptions['inline_inner_heights'];
                                    $inline_max_widths       = $lightboxPlusOptions['inline_max_widths'];
                                    $inline_max_heights      = $lightboxPlusOptions['inline_max_heights'];
                                    $inline_position_tops    = $lightboxPlusOptions['inline_position_tops'];
                                    $inline_position_rights  = $lightboxPlusOptions['inline_position_rights'];
                                    $inline_position_bottoms = $lightboxPlusOptions['inline_position_bottoms'];
                                    $inline_position_lefts   = $lightboxPlusOptions['inline_position_lefts'];
                                    $inline_fixeds           = $lightboxPlusOptions['inline_fixeds'];
                                    $inline_opens            = $lightboxPlusOptions['inline_opens'];
                                    $inline_opacitys         = $lightboxPlusOptions['inline_opacitys'];
                                ?>
                                <tr <?php if ($i % 2 == 0) {echo 'class="alternate"';} ?>>
                                    <td><?php _e( 'Inline Lightbox #'.$i, 'lightboxplus' )?>:</td>
                                    <td>
                                        <input type="text" size="15" name="inline_link_<?php echo $i; ?>" id="inline_link_<?php echo $i; ?>" value="<?php if (empty( $inline_links[$i - 1] )) { echo 'lbp-inline-link-'.$i; } else {echo $inline_links[$i - 1];}?>" />
                                    </td>
                                    <td>
                                        <input type="text" size="15" name="inline_href_<?php echo $i; ?>" id="inline_href_<?php echo $i; ?>" value="<?php if (empty( $inline_hrefs[$i - 1] )) { echo 'lbp-inline-href-'.$i; } else {echo $inline_hrefs[$i - 1];}?>" />
                                    </td>
                                    <td align="center">
                                        <input type="text" size="5" name="inline_width_<?php echo $i; ?>" id="inline_width_<?php echo $i; ?>" value="<?php if (empty( $inline_widths[$i - 1] )) { echo '80%'; } else {echo $inline_widths[$i - 1];}?>" /><br />
                                        <input type="text" size="5" name="inline_height_<?php echo $i; ?>" id="inline_height_<?php echo $i; ?>" value="<?php if (empty( $inline_heights[$i - 1] )) { echo '80%'; } else  {echo $inline_heights[$i - 1];}?>" />
                                    </td>
                                    <td align="center">
                                        <input type="text" size="5" name="inline_inner_width_<?php echo $i; ?>" id="inline_inner_width_<?php echo $i; ?>" value="<?php if (empty( $inline_inner_widths[$i - 1] )) { echo 'false'; } else {echo $inline_inner_widths[$i - 1];}?>" /><br />
                                        <input type="text" size="5" name="inline_inner_height_<?php echo $i; ?>" id="inline_inner_height_<?php echo $i; ?>" value="<?php if (empty( $inline_inner_heights[$i - 1] )) { echo 'false'; } else {echo $inline_inner_heights[$i - 1];}?>" />
                                    </td>
                                    <td align="center">
                                        <input type="text" size="5" name="inline_max_width_<?php echo $i; ?>" id="inline_max_width_<?php echo $i; ?>" value="<?php if (empty( $inline_max_widths[$i - 1] )) { echo '80%'; } else {echo $inline_max_widths[$i - 1];}?>" /><br />
                                        <input type="text" size="5" name="inline_max_height_<?php echo $i; ?>" id="inline_max_height_<?php echo $i; ?>" value="<?php if (empty( $inline_max_heights[$i - 1] )) { echo '80%'; } else  {echo $inline_max_heights[$i - 1];}?>" />
                                    </td>
                                    <td align="center">
                                        <input type="text" size="5" name="inline_position_top_<?php echo $i; ?>" id="inline_position_top_<?php echo $i; ?>" value="<?php if (empty( $inline_position_tops[$i - 1] )) { echo ''; } else {echo $inline_position_tops[$i - 1];}?>" /><br />
                                        <input type="text" size="5" name="inline_position_right_<?php echo $i; ?>" id="inline_position_right_<?php echo $i; ?>" value="<?php if (empty( $inline_position_rights[$i - 1] )) { echo ''; } else {echo $inline_position_rights[$i - 1];}?>" /><input type="text" size="5" name="inline_position_bottom_<?php echo $i; ?>" id="inline_position_bottom_<?php echo $i; ?>" value="<?php if (empty( $inline_position_bottoms[$i - 1] )) { echo ''; } else {echo $inline_position_bottoms[$i - 1];}?>" /><br />
                                        <input type="text" size="5" name="inline_position_left_<?php echo $i; ?>" id="inline_position_left_<?php echo $i; ?>" value="<?php if (empty( $inline_position_lefts[$i - 1] )) { echo ''; } else {echo $inline_position_lefts[$i - 1];}?>" />
                                    </td>
                                    <?php
                                        /**
                                        * @todo fix inline fixed and open saving
                                        */
                                    ?>
                                    <td align="center">
                                        <input type="checkbox" name="inline_fixed_<?php echo $i; ?>" id="inline_fixed_<?php echo $i; ?>" value="1"<?php if ( ($inline_fixeds[$i - 1] )) { echo ' checked="checked"'; }?> />
                                    </td>
                                    <td align="center">
                                        <input type="checkbox" name="inline_open_<?php echo $i; ?>" id="inline_open_<?php echo $i; ?>" value="1"<?php if ( ($inline_opens[$i - 1] )) { echo ' checked="checked"'; }?> />
                                    </td>
                                    <td align="center">

                                        <select name="inline_opacity_<?php echo $i; ?>" id="inline_opacity_<?php echo $i; ?>">
                                            <?php 
                                                for($j = 0; $j <= 1.01; $j = $j + .05){ ?>
                                                <option value="<?php echo $j; ?>"<?php if ( $inline_opacitys[$i - 1] == strval($j) ) { echo ' selected="selected"'; }?>><?php echo ($j*100); ?>%</option>
                                                <?php 
                                                } 
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <?php
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
                                <?php _e('Using Inline Lightboxes', 'lightboxplus')?>
                                <div id="lbp_for_inline_tip">
                                    <?php _e( 'In order to display inline content using Lightbox Plus and Colorbox you must at a minimum has the following items set: Inner Width, Inner Height, and Use Iframe must be checked.<br /><br />
                                        <code>
                                        &lt;a class="lbp-inline-link-1" href="#">Inline HTML Content&lt;/a><br />
                                        &lt;div style="display:none"><br />
                                        &nbsp;&nbsp;&nbsp;&nbsp;&lt;div id="lbp-inline-link-1" style="padding: 10px;background: #fff"><br />
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Inline Content Goes Here<br />
                                        &nbsp;&nbsp;&nbsp;&nbsp;&lt;/div><br />
                                        &lt;/div></code>', 'lightboxplus' )?>
                                    <br />
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
                                <?php _e('Here you can test you settings with various different implementation of Lightbox Plus using inline content.  If they do not work please check that you have the following items set: Inner Width, Inner Height, and Use Iframe must be checked.  You will not be able to display any of these without the minimum options set.',"lightboxplus"); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="inline_link_test_item">
                                    <a class="<?php echo $inline_links[0]; ?>" href="#">Inline Content Test including form</a>
                                </p>
                            </td>
                        </tr>
                    </table>
                    <!-- end testing -->
                </div>
            </div>
            <p class="submit">
                <input type="submit" style="padding:5px 30px 5px 30px;" name="Submit" title="<?php _e( 'Save all Lightbox Plus settings', 'lightboxplus' )?>" value="<?php _e( 'Save settings', 'lightboxplus' )?> &raquo;" />
            </p>
        </div>
    </div>
</div>
	<!-- End Inline Lightbox -->