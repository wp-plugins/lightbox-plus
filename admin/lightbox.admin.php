<?php
    /**
    * @package Lightbox Plus
    * @subpackage lightbox.admin.php
    * @internal 2011.10.03
    * @author Dan Zappone / 23Systems
    * @version 2.4
    */
    if ( !empty( $this->lightboxOptions )) { $lightboxPlusOptions = $this->getAdminOptions( $this->lightboxOptionsName ); }
    /**
    * @todo Add scrolling (Interface)
    * @todo Add photo (General)
    * @todo Add rel (Interface) (i.e Disable Grouping)
    * @todo Add loop (General)
    * @todo Add esc_key (Interface)
    * @todo Add arrow_key (Interface)
    * @done Add top (Position)
    * @done Add bottom (Position)
    * @done Add left (Position)
    * @done Add right (Position)
    * @done Add fixed (Position)
    * @todo Remove this comment
    */
?>
<!-- About Lightbox Plus for WordPress -->

<div id="poststuff" class="lbp">
    <div class="postbox<?php if ( $lightboxPlusOptions['hide_about'] ) echo ' close-me';?>">
        <h3 class="handle"><?php _e( 'About Lightbox Plus for WordPress','lightboxplus' ); ?></h3>
        <div class="inside toggle">
            <div class="donate">
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="hosted_button_id" value="BKVLWU2KWRNAG">
                    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"><img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </form>
                <h4>&mdash; or try a 23Systems affiliate program &mdash;</h4>
                <a href="http://6e772-ccdd75pi48yf3kdqfke0.hop.clickbank.net/?tid=DIGWP" target="_top"  name="Digging into WordPress - Really Learn It"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/aflt-100x26-digwp.jpg'?>" alt="Digging into WordPress - Really Learn It" border="0" /></a>
                <a href="https://www.e-junkie.com/ecom/gb.php?cl=54585&c=ib&aff=107849" target="ejejcsingle" name=""><img src="<?php echo $g_lightbox_plus_url.'/admin/images/aflt-100x26-grvfrm.jpg'?>" alt="Gravity Forms - WordPress Form Management" border="0" /></a><br />
                <a href="https://fundry.com/project/9-lightbox-plus"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/aflt-100x26-fundry.jpg'?>" alt="Fundry - Crowdfunding Software" border="0" /></a>
                <a href="https://www.e-junkie.com/ecom/gb.php?ii=195647&c=ib&aff=107849&cl=12635" target="ejejcsingle" name="How to be a Rockstar WordPress Designer"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/aflt-100x26-rckstr.jpg'?>" alt="How to be a Rockstar WordPress Designer" border="0" /></a>
            </div>
            <h4><?php _e( 'Thank you for downloading and installing Lightbox Plus for WordPress','lightboxplus' ); ?></h4>
            <p style="text-align: justify;">
                <?php _e( 'Lightbox Plus implements ColorBox as a lightbox image overlay tool for WordPress.  ColorBox was created by Jack Moore of <a href="http://colorpowered.com/colorbox/">Color Powered</a> and is licensed under the MIT License. Lightbox Plus allows you to easily integrate and customize a powerful and light-weight lightbox plugin for jQuery into your WordPress site.  You can easily create additional styles by adding a new folder to the css directory under <code>wp-content/plugins/lighbox-plus/css/</code> by duplicating and modifying any of the existing themes or using them as examples to create your own.  See the <a href="http://www.23systems.net/plugins/lightbox-plus/">changelog</a> for important details on this upgrade.','lightboxplus' ); ?>
            </p>
            <p style="text-align: justify;">
                <?php _e( 'I spend a much of my spare time as possible working on <strong>Lightbox Plus</strong> and any donation is appreciated. Donations play a crucial role in supporting Free and Open Source Software projects. So why are donations important? As a developer the more donations I receive the more time I can invest in working on <strong>Lightbox Plus</strong>. Donations help cover the cost of hardware for development and to pay hosting bills. This is critical to the development of free software. I know a lot of other developers do the same and I try to donate to them whenever I can. As a developer I greatly appreciate any donation you can make to help support further development of quality plugins and themes for WordPress. <em>You have my sincere thanks and appreciation for using <strong>Lightbox Plus</strong></em>.','lightboxplus' ); ?>
            </p>
            <h4><?php _e( 'You have my sincere thanks and appreciation for using Lightbox Plus.','lightboxplus' ); ?></h4>
            <div class="clear"></div>
        </div>
    </div>
</div>

<!-- Settings/Options -->
<form name="lightboxplus_settings" method="post" action="<?php echo $location?>&amp;updated=settings">
    <input type="hidden" name="action" value="action" />
    <input type="hidden" name="sub" value="settings" />
    <div id="poststuff" class="lbp">
        <div class="postbox">
            <h3 class="handle"><?php _e( 'Lightbox Plus - Base Settings','lightboxplus' ); ?></h3>
            <div class="inside toggle">
                <div id="blbp-tabs">
                    <ul>
                        <li><a href="#blbp-tabs-1"><?php _e( 'General','lightboxplus' ); ?></a></li>
                        <li><a href="#blbp-tabs-2"><?php _e( 'Styles','lightboxplus' ); ?></a></li>
                        <li><a href="#blbp-tabs-3"><?php _e( 'Advanced','lightboxplus' ); ?></a></li>
                    </ul>
                    <!-- General -->
                    <div id="blbp-tabs-1" title="General">
                        <table class="form-table" title="General">
                            <tr>
                                <th scope="row">
                                    <?php _e( 'Use Secondary Lightbox', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="checkbox" name="lightboxplus_multi" id="lightboxplus_multi" value="1"<?php if ( $lightboxPlusOptions['lightboxplus_multi'] ) echo ' checked="checked"';?> />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_lightboxplus_multi_tip">
                                        <?php _e( 'If checked, Lightbox Plus will create a secondary lightbox with an additional set of controls.  This secondary lightbox can be used to create inline or iFramed content using a class to specify the content. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php _e( 'Add Inline Lightboxes', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="checkbox" name="use_inline" id="use_inline" value="1"<?php if ( $lightboxPlusOptions['use_inline'] ) echo ' checked="checked"';?> />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"> <img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_use_inline_tip">
                                        <?php _e( 'If checked, Lightbox Plus will add the selected number of addtional lightboxes that you can use to manuall add inline lightboxed content to.  Additional controls will be available at the bottom of the Lightbox Plus admin page. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="base_gen">
                                <th scope="row">
                                    <?php _e( 'Number of Inline Lightboxes:', 'lightboxplus' )?>: </th>
                                <td>
                                    <select name="inline_num" id="inline_num">
                                        <?php for ($i = 1; $i <= 100; $i++) {
                                            ?>
                                            <option value="<?php echo $i; ?>"<?php if ( $lightboxPlusOptions['inline_num']==$i ) echo ' selected="selected"'?>><?php echo $i; ?></option>
                                            <?php  
                                            }
                                        ?>
                                    </select>
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"> <img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_inline_num_tip">
                                        <?php _e( 'Select the number of inline lightboxes (up to 100). <strong><em>Default: 1</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php _e( 'Hide "About Lightbox Plus"', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="checkbox" name="hide_about" id="hide_about" value="1"<?php if ( $lightboxPlusOptions['hide_about'] ) echo ' checked="checked"';?> />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"> <img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_hide_about_tip">
                                        <?php _e( 'If checked will keep "About Lightbox Plus for WordPress" closed. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!-- Styles -->
                    <div id="blbp-tabs-2">
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row">
                                    <?php _e( 'Lightbox Plus Style', 'lightboxplus' )?>: </th>
                                <td>
                                    <select name="lightboxplus_style">
                                        <?php
                                            foreach ( $styles as $key => $value) {
                                                if ( $lightboxPlusOptions['lightboxplus_style'] == urlencode( $key)) {
                                                    echo("<option value=\"".urlencode( $key)."\" selected=\"selected\">".$this->setProperName( $key)."</option>\n");
                                                } else {
                                                    echo("<option value=\"".urlencode( $key)."\">".$this->setProperName( $key)."</option>\n");
                                                }
                                            }
                                        ?>
                                    </select>
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_lightboxplus_style_tip">
                                        <?php _e('Select Lightbox Plus theme/style here. <strong><em>Default: Shadowed</em></strong>',"lightboxplus"); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php _e( 'Use Custom Styles', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="checkbox" name="use_custom_style" id="use_custom_style" value="1"<?php if ( $lightboxPlusOptions['use_custom_style'] ) echo ' checked="checked"';?> />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_use_custom_style_tip">
                                        <?php _e( 'If checked, the built in stylsheets for Lightbox Plus will be located at <code>wp-content/lbp-css</code>.  Lightbox Plus will attempt to create this directory and copy default styles to it.  This will allow you to create custom styles in that directory with fear of the styles being deleted when you upgrade he plugin. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php _e( 'Disable Lightbox CSS', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="checkbox" name="disable_css" id="disable_css" value="1"<?php if ( $lightboxPlusOptions['disable_css'] ) echo ' checked="checked"';?> />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_disable_css_tip">
                                        <?php _e( 'If checked, the built in stylsheets for Lightbox Plus will be disabled.  This will allow you to include customized Lightbox Plus styles in your theme stylesheets which can reduce files loaded, and making editing easier. Note, that if you do not have the Lightbox styles set in your stylesheet your Lightboxed images will appear at the top of your page. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!-- Advanced -->
                    <div id="blbp-tabs-3">
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row">
                                    <?php _e( 'Use per page/post', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="checkbox" name="use_perpage" id="use_perpage" value="1"<?php if ( $lightboxPlusOptions['use_perpage'] ) echo ' checked="checked"';?> />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_lightboxplus_perpage_tip">
                                        <?php _e('If checked allows you specify which posts or pages to load Lightbox Plus on while writing the post or page. <strong><em>Default: Unchecked</em></strong>',"lightboxplus"); ?>
                                    </div>
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

    <!-- Primary Lightbox Settings -->
    <div id="poststuff" class="lbp">
        <div class="postbox">
            <h3 class="handle"><?php _e( 'Lightbox Plus - Primary Lightbox Settings','lightboxplus' ); ?></h3>
            <div class="inside toggle">
                <div id="plbp-tabs">
                    <ul>
                        <li><a href="#plbp-tabs-1"><?php _e( 'General','lightboxplus' ); ?></a></li>
                        <li><a href="#plbp-tabs-2"><?php _e( 'Size','lightboxplus' ); ?></a></li>
                        <li><a href="#plbp-tabs-3"><?php _e( 'Postition','lightboxplus' ); ?></a></li>
                        <li><a href="#plbp-tabs-4"><?php _e( 'Interface','lightboxplus' ); ?></a></li>
                        <li><a href="#plbp-tabs-5"><?php _e( 'Slideshow','lightboxplus' ); ?></a></li>
                        <li><a href="#plbp-tabs-6"><?php _e( 'Other','lightboxplus' ); ?></a></li>
                        <li><a href="#plbp-tabs-7"><?php _e( 'Usage','lightboxplus' ); ?></a></li>
                        <li><a href="#plbp-tabs-8"><?php _e( 'Demo/Test','lightboxplus' ); ?></a></li>
                    </ul>
                    <!-- General -->
                    <div id="plbp-tabs-1">
                        <table class="form-table">
                            <tr>
                                <th scope="row">
                                    <?php _e( 'Transition Type', 'lightboxplus' )?>: </th>
                                <td>
                                    <select name="transition" id="transition">
                                        <option value="elastic"<?php if ( $lightboxPlusOptions['transition']=='elastic' ) echo ' selected="selected"'?>>Elastic</option>
                                        <option value="fade"<?php if ( $lightboxPlusOptions['transition']=='fade' ) echo ' selected="selected"'?>>Fade</option>
                                        <option value="none"<?php if ( $lightboxPlusOptions['transition']=='none' ) echo ' selected="selected"'?>>None</option>
                                    </select>
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_transition_tip">
                                        <?php _e( 'Specifies the transition type. Can be set to "elastic", "fade", or "none". <strong><em>Default: Elastic</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php _e( 'Resize Speed', 'lightboxplus' )?>: </th>
                                <td>
                                    <select name="speed" id="speed">
                                        <?php 
                                            for($i = 0;$i <= 5001;){ ?>
                                            <option value="<?php echo $i; ?>"<?php if ( $lightboxPlusOptions['speed'] == strval($i) ) echo ' selected="selected"'?>><?php echo $i; ?></option>
                                            <?php  
                                                if ($i >= 2000) { $i = $i + 500; }
                                                elseif ($i >= 1250) { $i = $i + 250; }
                                                else { $i = $i + 50; }
                                            } 
                                        ?>
                                    </select>
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_speed_tip">
                                        <?php _e( 'Controls the speed of the fade and elastic transitions, in milliseconds. <strong><em>Default: 300</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php _e( 'Overlay Opacity', 'lightboxplus' )?>: </th>
                                <td>
                                    <select name="opacity">
                                        <?php 
                                            for($i = 0; $i <= 1.01; $i = $i + .05){ ?>
                                            <option value="<?php echo $i; ?>"<?php if ( $lightboxPlusOptions['opacity'] == strval($i) ) { echo ' selected="selected"'; }?>><?php echo ($i*100); ?>%</option>
                                            <?php 
                                            } 
                                        ?>
                                    </select>
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_opacity_tip">
                                        <?php _e( 'Controls transparency of shadow overlay. Lower numbers are more transparent. <strong><em>Default: 80%</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php _e( 'Pre-load images', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="checkbox" name="preloading" value="1"<?php if ( $lightboxPlusOptions['preloading'] ) echo ' checked="checked"';?> />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_preloading_tip">
                                        <?php _e( 'Allows for preloading of "Next" and "Previous" content in a shared relation group (same values for the "rel" attribute), after the current content has finished loading. Uncheck to disable. <strong><em>Default: Checked</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!-- Size -->
                    <div id="plbp-tabs-2">
                        <table class="form-table">
                            <tr>
                                <th scope="row">
                                    <?php _e( 'Width', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="text" size="15" name="width" id="width" value="<?php if ( !empty( $lightboxPlusOptions['width'] )) { echo $lightboxPlusOptions['width'];} else { echo ''; } ?>" />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_width_tip">
                                        <?php _e( 'Set a fixed total width. This includes borders and buttons. Example: "100%", "500px", or 500, or false for no defined width.  <strong><em>Default: false</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php _e( 'Height', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="text" size="15" name="height" id="height" value="<?php if ( !empty( $lightboxPlusOptions['height'] )) { echo $lightboxPlusOptions['height'];} else { echo ''; } ?>" />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_height_tip">
                                        <?php _e( 'Set a fixed total height. This includes borders and buttons. Example: "100%", "500px", or 500, or false for no defined height. <strong><em>Default: false</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php _e( 'Inner Width', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="text" size="15" name="inner_width" id="inner_width" value="<?php if ( !empty( $lightboxPlusOptions['inner_width'] )) { echo $lightboxPlusOptions['inner_width'];} else { echo ''; } ?>" />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_inner_width_tip">
                                        <?php _e( 'This is an alternative to "width" used to set a fixed inner width. This excludes borders and buttons. Example: "50%", "500px", or 500, or false for no inner width.  <strong><em>Default: false</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php _e( 'Inner Height', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="text" size="15" name="inner_height" id="inner_height" value="<?php if ( !empty( $lightboxPlusOptions['inner_height'] )) { echo $lightboxPlusOptions['inner_height'];} else { echo ''; } ?>" />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_inner_height_tip">
                                        <?php _e( 'This is an alternative to "height" used to set a fixed inner height. This excludes borders and buttons. Example: "50%", "500px", or 500 or false for no inner height. <strong><em>Default: false</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php _e( 'Initial Width', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="text" size="15" name="initial_width" id="initial_width" value="<?php if ( !empty( $lightboxPlusOptions['initial_width'] )) { echo $lightboxPlusOptions['initial_width'];} else { echo ''; } ?>" />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_initial_width_tip">
                                        <?php _e( 'Set the initial width, prior to any content being loaded.  <strong><em>Default: 300</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php _e( 'Initial Height', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="text" size="15" name="initial_height" id="initial_height" value="<?php if ( !empty( $lightboxPlusOptions['initial_height'] )) { echo $lightboxPlusOptions['initial_height'];} else { echo ''; } ?>" />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_initial_height_tip">
                                        <?php _e( 'Set the initial height, prior to any content being loaded. <strong><em>Default: 100</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php _e( 'Maximum Width', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="text" size="15" name="max_width" id="max_width" value="<?php if ( !empty( $lightboxPlusOptions['max_width'] )) { echo $lightboxPlusOptions['max_width'];} else { echo ''; } ?>" />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_max_width_tip">
                                        <?php _e( 'Set a maximum width for loaded content.  Example: "75%", "500px", 500, or false for no maximum width.  <strong><em>Default: false</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php _e( 'Maximum Height', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="text" size="15" name="max_height" id="max_height" value="<?php if ( !empty( $lightboxPlusOptions['max_height'] )) { echo $lightboxPlusOptions['max_height'];} else { echo ''; } ?>" />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_max_height_tip">
                                        <?php _e( 'Set a maximum height for loaded content.  Example: "75%", "500px", 500, or false for no maximum height. <strong><em>Default: false</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php _e( 'Resize', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="checkbox" name="resize" id="resize" value="1"<?php if ( $lightboxPlusOptions['resize'] ) echo ' checked="checked"';?> />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_resize_tip">
                                        <?php _e( 'If checked and if Maximum Width or Maximum Height have been defined, Lightbx Plus will resize photos to fit within the those values. <strong><em>Default: Checked</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!-- Position -->
                    <div id="plbp-tabs-3">
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php _e( 'Top', 'lightboxplus' )?>: </th>
                                <td><input name="top" type="text" id="top" size="8" maxlength="8" value="<?php if ( !empty( $lightboxPlusOptions['top'] )) { echo $lightboxPlusOptions['top'];} else { echo ''; } ?>" /><a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_top_tip">
                                        <?php _e( 'Accepts a pixel or percent value (50, "50px", "10%"). Controls vertical positioning instead of using the default position of being centered in the viewport. <strong><em>Default: null</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php _e( 'Right', 'lightboxplus' )?>: </th>
                                <td><input name="right" type="text" id="right" size="8" maxlength="8" value="<?php if ( !empty( $lightboxPlusOptions['right'] )) { echo $lightboxPlusOptions['right'];} else { echo ''; } ?>" /><a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_top_tip">
                                        <?php _e( 'Accepts a pixel or percent value (50, "50px", "10%"). Controls horizontal positioning instead of using the default position of being centered in the viewport. <strong><em>Default: null</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php _e( 'Bottom', 'lightboxplus' )?>: </th>
                                <td><input name="bottom" type="text" id="bottom" size="8" maxlength="8" value="<?php if ( !empty( $lightboxPlusOptions['bottom'] )) { echo $lightboxPlusOptions['bottom'];} else { echo ''; } ?>" /><a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_top_tip">
                                        <?php _e( 'SetAccepts a pixel or percent value (50, "50px", "10%"). Controls vertical positioning instead of using the default position of being centered in the viewport. <strong><em>Default: false</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php _e( 'Left', 'lightboxplus' )?>: </th>
                                <td><input name="left" type="text" id="left" size="8" maxlength="8" value="<?php if ( !empty( $lightboxPlusOptions['left'] )) { echo $lightboxPlusOptions['left'];} else { echo ''; } ?>" /><a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_top_tip">
                                        <?php _e( 'SetAccepts a pixel or percent value (50, "50px", "10%"). Controls horizontal positioning instead of using the default position of being centered in the viewport. <strong><em>Default: false</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php _e( 'Fixed', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="checkbox" name="fixed" id="fixed" value="1"<?php if ( $lightboxPlusOptions['fixed'] ) echo ' checked="checked"';?> />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_fixed_tip">
                                        <?php _e( 'If check, the lightbox will always be displayed in a fixed position within the viewport. In otherwords it will stay within the viewport while scolling on the page.  This is unlike the default absolute positioning relative to the document. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!-- Interface -->
                    <div id="plbp-tabs-4">
                        <table class="form-table">
                            <tr>
                                <th scope="row" colspan="2"><strong><?php _e( 'General Interface Options', 'lightboxplus' )?></strong></th>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php _e( 'Close image text', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="text" size="15" name="close" id="close" value="<?php if (empty( $lightboxPlusOptions['close'] )) { echo ''; } else { echo $lightboxPlusOptions['close'];} ?>" />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_close_tip">
                                        <?php _e( 'Text for the close button.  If Overlay Close or ESC Key Close are check those options will also close the lightbox. <strong><em>Default: close</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php _e( 'Overlay Close', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="checkbox" name="overlay_close" id="overlay_close" value="1"<?php if ( $lightboxPlusOptions['overlay_close'] ) echo ' checked="checked"';?> />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_overlay_close_tip">
                                        <?php _e( 'If checked, enables closing Lightbox Plus by clicking on the background overlay. <strong><em>Default: Checked</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php _e( 'ESC Key Close', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="checkbox" name="esc_key" id="esc_key" value="1"<?php if ( $lightboxPlusOptions['esc_key'] ) echo ' checked="checked"';?> />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_esc_key_tip">
                                        <?php _e( 'If checked, enables closing Lightbox Plus using the ESC key. <strong><em>Default: Checked</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php _e( 'Scroll Bars', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="checkbox" name="scrolling" id="scrolling" value="1"<?php if ( $lightboxPlusOptions['scrolling'] ) echo ' checked="checked"';?> />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_scrolling_tip">
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
                                    <input type="checkbox" name="rel" id="rel" value="nofollow"<?php if ( $lightboxPlusOptions['rel'] == 'nofollow' ) echo ' checked="checked"';?> />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_nogrouping_tip">
                                        <?php _e( 'If checked will disable grouping of images and previous/next label. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="grouping_prim">
                                <th scope="row">
                                    <?php _e( 'Grouping Labels', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="text" size="15" name="label_image" id="label_image" value="<?php if (empty( $lightboxPlusOptions['label_image'] )) { echo ''; } else {echo $lightboxPlusOptions['label_image'];}?>" />
                                    #
                                    <input type="text" size="15" name="label_of" id="label_of" value="<?php if (empty( $lightboxPlusOptions['label_of'] )) { echo ''; } else {echo $lightboxPlusOptions['label_of'];}?>" />
                                    # <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_label_image_tip">
                                        <?php _e( 'Text format for the content group / gallery count. {current} and {total} are detected and replaced with actual numbers while ColorBox runs. <strong><em>Default: Image {current} of {total}</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="grouping_prim">
                                <th scope="row">
                                    <?php _e( 'Previous image text', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="text" size="15" name="previous" id="previous" value="<?php if (empty( $lightboxPlusOptions['previous'] )) { echo ''; } else { echo $lightboxPlusOptions['previous'];} ?>" />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_previous_tip">
                                        <?php _e( 'Text for the previous button in a shared relation group (same values for "rel" attribute). <strong><em>Default: previous</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="grouping_prim">
                                <th scope="row">
                                    <?php _e( 'Next image text', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="text" size="15" name="next" id="next" value="<?php if (empty( $lightboxPlusOptions['next'] )) { echo ''; } else { echo $lightboxPlusOptions['next'];} ?>" />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_next_tip">
                                        <?php _e( 'Text for the next button in a shared relation group (same values for "rel" attribute).  <strong><em>Default: next</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="grouping_prim">
                                <th scope="row">
                                    <?php _e( 'Arrow key navigation', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="checkbox" name="arrow_key" id="arrow_key" value="1"<?php if ( $lightboxPlusOptions['arrow_key'] ) echo ' checked="checked"';?> />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_arrow_key_tip">
                                        <?php _e( 'If checked, enables the left and right arrow keys for navigating between the items in a group. <strong><em>Default: Checked</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="grouping_prim">
                                <th scope="row">
                                    <?php _e( 'Loop image group', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="checkbox" name="loop" id="loop" value="1"<?php if ( $lightboxPlusOptions['loop'] ) echo ' checked="checked"';?> />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_loop_tip">
                                        <?php _e( 'If checked, enables the ability to loop back to the beginning of the group when on the last element. <strong><em>Default: Checked</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!-- Slideshow -->
                    <div id="plbp-tabs-5">
                        <table class="form-table">
                            <tr>
                                <th scope="row">
                                    <?php _e( 'Slideshow', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="checkbox" name="slideshow" id="slideshow" value="1"<?php if ( $lightboxPlusOptions['slideshow'] ) echo ' checked="checked"';?> />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_slideshow_tip">
                                        <?php _e( 'If checked, adds slideshow capablity to a content group / gallery. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="slideshow_prim">
                                <th scope="row">
                                    <?php _e( 'Auto-Start Slideshow', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="checkbox" name="slideshow_auto" id="slideshow_auto" value="1"<?php if ( $lightboxPlusOptions['slideshow_auto'] ) echo ' checked="checked"';?> />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_slideshow_auto_tip">
                                        <?php _e( 'If checked, the slideshows will automatically start to play when content grou opened. <strong><em>Default: Checked</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="slideshow_prim">
                                <th scope="row">
                                    <?php _e( 'Slideshow Speed', 'lightboxplus' )?>: </th>
                                <td>
                                    <select name="slideshow_speed" id="slideshow_speed">
                                        <?php 
                                            for($i = 500;$i <= 20001;){ ?>
                                            <option value="<?php echo $i; ?>"<?php if ( $lightboxPlusOptions['slideshow_speed'] == strval($i) ) echo ' selected="selected"'?>><?php echo $i; ?></option>
                                            <?php  
                                                if ($i >= 15000) { $i = $i + 5000; }
                                                elseif ($i >= 10000) { $i = $i + 1000; }
                                                else { $i = $i + 500; }
                                            } 
                                        ?>
                                    </select>
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_slideshow_speed_tip">
                                        <?php _e( 'Controls the speed of the slideshow, in milliseconds. <strong><em>Default: 2500</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="slideshow_prim">
                                <th scope="row">
                                    <?php _e( 'Slideshow start text', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="text" size="15" name="slideshow_start" id="slideshow_start" value="<?php if ( !empty( $lightboxPlusOptions['slideshow_start'] )) { echo $lightboxPlusOptions['slideshow_start'];} else { echo 'start'; } ?>" />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_slideshow_start_tip">
                                        <?php _e( 'Text for the slideshow start button. <strong><em>Default: start</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="slideshow_prim">
                                <th scope="row">
                                    <?php _e( 'Slideshow stop text', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="text" size="15" name="slideshow_stop" id="slideshow_stop" value="<?php if ( !empty( $lightboxPlusOptions['slideshow_stop'] )) { echo $lightboxPlusOptions['slideshow_stop'];} else { echo 'stop'; } ?>" />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_slideshow_stop_tip">
                                        <?php _e( 'Text for the slideshow stop button.  <strong><em>Default: stop</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!-- Other -->
                    <div id="plbp-tabs-6">
                        <table class="form-table">
                            <tr>
                                <th scope="row">
                                    <?php _e( 'Use WP Caption for LBP Caption', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="checkbox" name="use_caption_title" id="use_caption_title" value="1"<?php if ( $lightboxPlusOptions['use_caption_title'] ) echo ' checked="checked"';?> />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_use_caption_title_tip">
                                        <?php _e( 'If checked, Lightbox Plus will attempt to use the displayed caption for the image on the page as the caption for the image in the Lightbox Plus overlay. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php _e( 'Use For WP Gallery', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="checkbox" name="gallery_lightboxplus" id="gallery_lightboxplus" value="1"<?php if ( $lightboxPlusOptions['gallery_lightboxplus'] ) echo ' checked="checked"';?> />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_gallery_lightboxplus_tip">
                                        <?php _e( 'If checked, Lightbox Plus will add the Lightboxing feature to the WordPress built in gallery feature.  In order for this to work correcly you must set <strong>Link thumbnails to: Image File</strong> or use <code>[gallery link="file"</code> for the gallery options. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                            <tr>
                                <th scope="row">
                                    <?php _e( 'Seperate Galleries in Post?', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="checkbox" name="multiple_galleries" id="multiple_galleries" value="1"<?php if ( $lightboxPlusOptions['multiple_galleries'] ) echo ' checked="checked"';?> /><a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_multiple_galleries_tip">
                                        <?php _e( 'If the option to separate multiple gallries in a single post is check Lightbox Plus will create separate sets of lightbox display for each gallery in the post. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php _e( 'Use Class Method', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="checkbox" name="use_class_method" id="use_class_method" value="1"<?php if ( $lightboxPlusOptions['use_class_method'] ) echo ' checked="checked"';?> />
                                    Class name:
                                    <input type="text" size="15" name="class_name" id="class_name" value="<?php if (empty( $lightboxPlusOptions['class_name'] )) { echo 'cboxModal'; } else {echo $lightboxPlusOptions['class_name'];}?>" />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"> <img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_use_class_method_tip">
                                        <?php _e( 'If checked, Lightbox Plus will only lightbox images using a class instead of the <code>rel=lightbox[]</code> attribute.  Using this method you can manually control which images are affected by Lightbox Plus by adding the class to the Advanced Link Settings in the WordPress Edit Image tool or by adding it to the image link URL and checking the <strong>Do Not Auto-Lightbox Images</strong> option. You can also specify the name of the class instead of using the default. <strong><em>Default: Unchecked / Default cboxModal</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row">
                                    <?php _e( 'Auto-Lightbox Text Links', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="checkbox" name="text_links" id="text_links" value="1"<?php if ( $lightboxPlusOptions['text_links'] ) echo ' checked="checked"';?> />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_text_links_tip">
                                        <?php _e( 'If checked, Lightbox Plus will lightbox images that are linked to images via text as well as those link by images.  Use with care as there is a small possibility that you will get double or triple images in the lightbox display if you have invalidly nested html. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php _e( '<strong>Do Not</strong> Auto-Lightbox Images', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="checkbox" name="no_auto_lightbox" id="no_auto_lightbox" value="1"<?php if ( $lightboxPlusOptions['no_auto_lightbox'] ) echo ' checked="checked"';?> />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_no_auto_lightbox_tip">
                                        <?php _e( 'If checked, Lightbox Plus <em>will not</em> automatically add appropriate attibutes (either <code>rel="lightbox[postID]"</code> or <code>class: cboxModal</code>) to Image URL.  You will need to manually add the appropriate attribute for Lightbox Plus to work. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php _e( '<strong>Do Not</strong> Display Image Title', 'lightboxplus' )?>: </th>
                                <td>
                                    <input type="checkbox" name="no_display_title" id="no_display_title" value="1"<?php if ( $lightboxPlusOptions['no_display_title'] ) echo ' checked="checked"';?> />
                                    <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>"><img src="<?php echo $g_lightbox_plus_url.'/admin/images/help.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
                                    <div class="lbp-bigtip" id="lbp_no_display_title_tip">
                                        <?php _e( 'If checked, Lightbox Plus <em>will not</em> display image titles automatically.  This has no effect if the <strong>Do Not Auto-Lightbox Images</strong> option is checked. <strong><em>Default: Unchecked</em></strong>', 'lightboxplus' )?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!-- Usage -->
                    <div id="plbp-tabs-7">
                        <table class="form-table">
                            <tr>
                                <td>
                                <h4><?php _e( 'Basic Usage of Lightbox Plus'); ?></h4>
                                <div id="lbp_for_video_tip">
                                    <?php _e( 'ENTER CONTENT HERE', 'lightboxplus' )?>
                                </div>
                            </tr>
                        </table>
                    </div>
                    <!-- Demo/Test -->
                    <div id="plbp-tabs-8">  
                        <table class="form-table">
                            <tr valign="top">
                                <td>
                                    <?php _e('Here you can test your settings for Lightbox Plus using image and text links.  If they do not work please check your settings and ensure that you have transition type and resize speed set ',"lightboxplus"); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="primary_test_item"><a href="<?php echo $g_lightbox_plus_url ?>/screenshot-1.jpg" <?php if ( $lightboxPlusOptions['use_class_method'] ) { echo 'class="'.$lightboxPlusOptions['class_name'].'"'; } else { echo 'rel="lightbox[test demo]"'; } ?> title="Screenshot 1"><img title="Screenshot 1" src="<?php echo $g_lightbox_plus_url ?>/screenshot-1.jpg" alt="Screenshot 1" width="120" height="90" /></a><br />
                                        <a href="<?php echo $g_lightbox_plus_url ?>/screenshot-2.jpg" <?php if ( $lightboxPlusOptions['use_class_method'] ) { echo 'class="'.$lightboxPlusOptions['class_name'].'"'; } else { echo 'rel="lightbox[test demo]"'; } ?> title="Screenshot 2">Screenshot 2 Text Link</a></p>
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
                    <input type="submit" style="padding:5px 30px 5px 30px;" name="Submit" title="<?php _e( 'Save all Lightbox Plus settings', 'lightboxplus' )?>" value="<?php _e( 'Save settings', 'lightboxplus' )?> &raquo;" />
                </p>
            </div>
        </div>
        <?php
            if ($lightboxPlusOptions['lightboxplus_multi']) {
                require('lightbox.secondary.php');
            }
            if ($lightboxPlusOptions['use_inline']) {
                require('lightbox.inline.php');
            }
        ?>
    </div>
</form>

<!-- Reset/Re-initialize -->
<div id="poststuff" class="lbp">
    <div class="postbox close-me">
        <h3 class="handle"><?php _e( 'Lightbox Plus - Reset/Re-initialize','lightboxplus' ); ?></h3>
        <div class="inside toggle">
            <!-- Secondary Settings -->
            <div class="ui-widget">
                <div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;"> 
                    <p>
                        <span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
                        <?php _e( 'This will immediately remove all existing settings and any files for versions of Lightbox Plus prior to version 1.5 (if needed) and will also re-initialize the plugin with the new default options. Be absolutely certain you want to do this. <br /><br /><strong><em>If you are upgrading from a version prior to 1.4 it is <strong><em>highly</em></strong> recommended that you reinitialize Lightbox Plus</em></strong>','lightboxplus' ); ?>
                    </p>
                    <form action="<?php echo $location?>&amp;updated=reset" method="post" id="lightboxplus_reset" name="lightboxplus_reset">
                        <input type="hidden" name="action" value="action" />
                        <input type="hidden" name="sub" value="reset" />
                        <p class="submit">
                            <input type="hidden" name="reinit_lightboxplus" value="1" />
                            <input type="submit" class="btn" name="save" style="padding:5px 30px 5px 30px;" title="<?php _e( 'Resets and re-initializes all Lightbox Plus settings', 'lightboxplus' )?>" value="<?php _e( 'Reset/Re-initialize Lightbox Plus','lightboxplus' ); ?>" />
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inline Demo Form -->
<div style="display:none">
    <div id="<?php echo $inline_hrefs[0]; ?>" style="padding: 10px;background: #fff">
        <h3><?php _e( 'About Lightbox Plus for WordPress','lightboxplus' ); ?>: </h3>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="hosted_button_id" value="BKVLWU2KWRNAG">
            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"><img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
        </form>
        <h5>
            <?php _e( 'Thank you for downloading and installing Lightbox Plus for WordPress<br /><br /><a href="http://www.23systems.net/plugins/lightbox-plus/">Visit plugin site</a> | <a href="http://www.23systems.net/plugins/lightbox-plus/frequently-asked-questions/">FAQ</a> | <a href="http://www.23systems.net/bbpress/forum/lightbox-plus">Support</a> | <a href="http://twitter.com/23systems">Follow on Twitter</a> | <a href="http://www.facebook.com/pages/Austin-TX/23Systems-Web-Devsign/94195762502">Add Facebook Page</a>','lightboxplus' ); ?>
        </h5>
        <p>
            <?php _e( 'Lightbox Plus implements ColorBox as a lightbox image overlay tool for WordPress.  ColorBox was created by Jack Moore of <a href="http://colorpowered.com/colorbox/">Color Powered</a> and is licensed under the MIT License. Lightbox Plus allows you to easily integrate and customize a powerful and light-weight lightbox plugin for jQuery into your WordPress site.  You can easily create additional styles by adding a new folder to the css directory under <code>wp-content/plugins/lighbox-plus/css/</code> by duplicating and modifying any of the existing themes or using them as examples to create your own.  See the <a href="http://www.23systems.net/plugins/lightbox-plus/">changelog</a> for important details on this upgrade.','lightboxplus' ); ?>
        </p>
        <p>
            <?php _e( 'I spend a much of my spare time as possible working on <strong>Lightbox Plus</strong> and any donation is appreciated. Donations play a crucial role in supporting Free and Open Source Software projects. So why are donations important? As a developer the more donations I receive the more time I can invest in working on <strong>Lightbox Plus</strong>. Donations help cover the cost of hardware for development and to pay hosting bills. This is critical to the development of free software. I know a lot of other developers do the same and I try to donate to them whenever I can. As a developer I greatly appreciate any donation you can make to help support further development of quality plugins and themes for WordPress. <em>You have my sincere thanks and appreciation for using <strong>Lightbox Plus</strong></em>.','lightboxplus' ); ?>
        </p>
    </div>
</div>

<!-- Fix for end of page conent -->
<div class="clear">&nbsp;</div>