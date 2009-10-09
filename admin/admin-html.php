
        <div class="notice">
          <h3><?php _e( 'Reset/Re-initialize Lightbox Plus','lightboxplus' ); ?>: </h3>
  					<form action="<?php echo $location?>&amp;updated=true" method="post" id="lightboxplus_reset" name="lightboxplus_reset">
  					<table>
  					<tr>
              <td valign="top"><?php _e( 'This will immediately remove all existing settings and any files for versions of Lightbox Plus prior to version 1.5 and will also re-initialize the plugin with the new default options. Be absolutely certain you want to do this. <br /><strong><em>If you are upgrading from a version prior to 1.4 it is <strong><em>highly</em></strong> recommended that you reinitialize Lightbox Plus</em></strong>','lightboxplus' ); ?></td>
  					</tr>
  					<tr>
              <td valign="top"><p class="submit"><input type="hidden" name="reinit_lightboxplus" value="1" /><input type="submit" class="btn" name="save" style="padding:5px 30px 5px 30px;" value="<?php _e( 'Reset/Re-initialize Lightbox Plus','lightboxplus' ); ?>" /></p>
  					<input type="hidden" name="action" value="action" /><input type="hidden" name="sub" value="reset" /></td>
  					</tr>
  					</table>
           </form>
         </div>
          
				  <h3><?php _e( 'Lightbox Plus Settings','lightboxplus' ); ?>: </h3>

				  <form name="lightboxplus_settings" method="post" action="<?php echo $location?>&amp;updated=true">
					<input type="hidden" name="action" value="action" /><input type="hidden" name="sub" value="settings" />
					<table class="form-table">
					  <tr valign="top">
						<th scope="row"><?php _e( 'Lightbox Plus Style', 'lightboxplus' )?>: </th>
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
			         </td>
					  </tr>
					  <tr>
              <th scope="row"><?php _e( 'Transition Type', 'lightboxplus' )?>: </th>
              <td>
      					<select name="transition" id="transition">
      					  <option value="elastic"<?php if ( $lightboxPlusOptions['transition']=='elastic' ) echo ' selected="selected"'?>>Elastic</option>
      					  <option value="fade"<?php if ( $lightboxPlusOptions['transition']=='fade' ) echo ' selected="selected"'?>>Fade</option>
      					  <option value="none"<?php if ( $lightboxPlusOptions['transition']=='none' ) echo ' selected="selected"'?>>None</option>
      					</select><br /><?php _e( 'Specifies the transition type. Can be set to "elastic", "fade", or "none".<br /><strong><em>Default: Elastic</em></strong>', 'lightboxplus' )?>
              </td>
            </tr>
					  <tr>
              <th scope="row"><?php _e( 'Resize Speed', 'lightboxplus' )?>: </th>
              <td>
      					<select name="speed" id="speed">
      					  <option value="0"<?php if ( $lightboxPlusOptions['speed']=='0' ) echo ' selected="selected"'?>>0</option>
      					  <option value="50"<?php if ( $lightboxPlusOptions['speed']=='50' ) echo ' selected="selected"'?>>50</option>
      					  <option value="100"<?php if ( $lightboxPlusOptions['speed']=='100' ) echo ' selected="selected"'?>>100</option>
      					  <option value="150"<?php if ( $lightboxPlusOptions['speed']=='150' ) echo ' selected="selected"'?>>150</option>
      					  <option value="200"<?php if ( $lightboxPlusOptions['speed']=='200' ) echo ' selected="selected"'?>>200</option>
      					  <option value="250"<?php if ( $lightboxPlusOptions['speed']=='250' ) echo ' selected="selected"'?>>250</option>
      					  <option value="300"<?php if ( $lightboxPlusOptions['speed']=='300' ) echo ' selected="selected"'?>>300</option>
      					  <option value="350"<?php if ( $lightboxPlusOptions['speed']=='350' ) echo ' selected="selected"'?>>350</option>
      					  <option value="400"<?php if ( $lightboxPlusOptions['speed']=='400' ) echo ' selected="selected"'?>>400</option>
      					  <option value="450"<?php if ( $lightboxPlusOptions['speed']=='450' ) echo ' selected="selected"'?>>450</option>
      					  <option value="500"<?php if ( $lightboxPlusOptions['speed']=='500' ) echo ' selected="selected"'?>>500</option>
      					  <option value="550"<?php if ( $lightboxPlusOptions['speed']=='550' ) echo ' selected="selected"'?>>550</option>
      					  <option value="600"<?php if ( $lightboxPlusOptions['speed']=='600' ) echo ' selected="selected"'?>>600</option>
      					  <option value="650"<?php if ( $lightboxPlusOptions['speed']=='650' ) echo ' selected="selected"'?>>650</option>
      					  <option value="700"<?php if ( $lightboxPlusOptions['speed']=='700' ) echo ' selected="selected"'?>>700</option>
      					  <option value="750"<?php if ( $lightboxPlusOptions['speed']=='750' ) echo ' selected="selected"'?>>750</option>
      					  <option value="800"<?php if ( $lightboxPlusOptions['speed']=='800' ) echo ' selected="selected"'?>>800</option>
      					  <option value="850"<?php if ( $lightboxPlusOptions['speed']=='850' ) echo ' selected="selected"'?>>850</option>
      					  <option value="900"<?php if ( $lightboxPlusOptions['speed']=='900' ) echo ' selected="selected"'?>>900</option>
      					  <option value="950"<?php if ( $lightboxPlusOptions['speed']=='950' ) echo ' selected="selected"'?>>950</option>
      					  <option value="1000"<?php if ( $lightboxPlusOptions['speed']=='1000' ) echo ' selected="selected"'?>>1000</option>
      					  <option value="1050"<?php if ( $lightboxPlusOptions['speed']=='1050' ) echo ' selected="selected"'?>>1050</option>
      					  <option value="1250"<?php if ( $lightboxPlusOptions['speed']=='1250' ) echo ' selected="selected"'?>>1250</option>
      					  <option value="1500"<?php if ( $lightboxPlusOptions['speed']=='1500' ) echo ' selected="selected"'?>>1500</option>
      					  <option value="1750"<?php if ( $lightboxPlusOptions['speed']=='1750' ) echo ' selected="selected"'?>>1750</option>
      					  <option value="2000"<?php if ( $lightboxPlusOptions['speed']=='2000' ) echo ' selected="selected"'?>>2000</option>
      					  <option value="2500"<?php if ( $lightboxPlusOptions['speed']=='2500' ) echo ' selected="selected"'?>>2500</option>
      					  <option value="3000"<?php if ( $lightboxPlusOptions['speed']=='3000' ) echo ' selected="selected"'?>>3000</option>
      					  <option value="3500"<?php if ( $lightboxPlusOptions['speed']=='3500' ) echo ' selected="selected"'?>>3500</option>
      					  <option value="4000"<?php if ( $lightboxPlusOptions['speed']=='4000' ) echo ' selected="selected"'?>>4000</option>
      					  <option value="5000"<?php if ( $lightboxPlusOptions['speed']=='5000' ) echo ' selected="selected"'?>>5000</option>
      					</select><br /><?php _e( 'Controls the speed of the fade and elastic transitions, in milliseconds.<br /><strong><em>Default: 350</em></strong>', 'lightboxplus' )?>
              </td>
            </tr>

					  <tr>
              <th scope="row"><?php _e( 'Maximum Width', 'lightboxplus' )?>: </th>
              <td><input type="text" size="15" name="max_width" id="max_width" value="<?php if ( !empty( $lightboxPlusOptions['max_width'] )) { echo $lightboxPlusOptions['max_width'];} else { echo ''; } ?>" /><br /><?php _e( 'Set a maximum width for loaded content.  Example: "75%", "500px", 500, or false for no maximum width.  <strong><em>Default: false</em></strong>', 'lightboxplus' )?></td>
            </tr>

					  <tr>
              <th scope="row"><?php _e( 'Maximum Height', 'lightboxplus' )?>: </th>
              <td><input type="text" size="15" name="max_height" id="max_height" value="<?php if ( !empty( $lightboxPlusOptions['max_height'] )) { echo $lightboxPlusOptions['max_height'];} else { echo ''; } ?>" /><br /><?php _e( 'Set a maximum height for loaded content.  Example: "75%", "500px",, 500, or false for no maximum height. <strong><em>Default: false</em></strong>', 'lightboxplus' )?></td>
            </tr>

					  <tr>
              <th scope="row"><?php _e( 'Resize', 'lightboxplus' )?>: </th>
              <td><input type="checkbox" name="resize"id="resize" value="1"<?php if ( $lightboxPlusOptions['resize'] ) echo ' checked="checked"';?> /><br /><?php _e( 'If checked and if Maximum Width or Maximum Height have been defined, Lightbx Plus will resize photos to fit within the those values.<br /><strong><em>Default: Checked</em></strong>', 'lightboxplus' )?></td>
            </tr>

					  <tr>
              <th scope="row"><?php _e( 'Overlay Opacity', 'lightboxplus' )?>: </th>
              <td>
      					<select name="opacity">
      					  <option value="0"<?php if ( $lightboxPlusOptions['opacity']=='0' ) echo ' selected="selected"'?>>0%</option>
      					  <option value="0.05"<?php if ( $lightboxPlusOptions['opacity']=='0.05' ) echo ' selected="selected"'?>>5%</option>
      					  <option value="0.1"<?php if ( $lightboxPlusOptions['opacity']=='0.1' ) echo ' selected="selected"'?>>10%</option>
      					  <option value="0.15"<?php if ( $lightboxPlusOptions['opacity']=='0.15' ) echo ' selected="selected"'?>>15%</option>
      					  <option value="0.2"<?php if ( $lightboxPlusOptions['opacity']=='0.2' ) echo ' selected="selected"'?>>20%</option>
      					  <option value="0.25"<?php if ( $lightboxPlusOptions['opacity']=='0.25' ) echo ' selected="selected"'?>>25%</option>
      					  <option value="0.3"<?php if ( $lightboxPlusOptions['opacity']=='0.3' ) echo ' selected="selected"'?>>30%</option>
      					  <option value="0.35"<?php if ( $lightboxPlusOptions['opacity']=='0.35' ) echo ' selected="selected"'?>>35%</option>
      					  <option value="0.4"<?php if ( $lightboxPlusOptions['opacity']=='0.4' ) echo ' selected="selected"'?>>40%</option>
      					  <option value="0.45"<?php if ( $lightboxPlusOptions['opacity']=='0.45' ) echo ' selected="selected"'?>>45%</option>
      					  <option value="0.5"<?php if ( $lightboxPlusOptions['opacity']=='0.5' ) echo ' selected="selected"'?>>50%</option>
      					  <option value="0.55"<?php if ( $lightboxPlusOptions['opacity']=='0.55' ) echo ' selected="selected"'?>>55%</option>
      					  <option value="0.6"<?php if ( $lightboxPlusOptions['opacity']=='0.6' ) echo ' selected="selected"'?>>60%</option>
      					  <option value="0.65"<?php if ( $lightboxPlusOptions['opacity']=='0.65' ) echo ' selected="selected"'?>>65%</option>
      					  <option value="0.7"<?php if ( $lightboxPlusOptions['opacity']=='0.7' ) echo ' selected="selected"'?>>70%</option>
      					  <option value="0.75"<?php if ( $lightboxPlusOptions['opacity']=='0.75' ) echo ' selected="selected"'?>>75%</option>
      					  <option value="0.8"<?php if ( $lightboxPlusOptions['opacity']=='0.8' ) echo ' selected="selected"'?>>80%</option>
      					  <option value="0.85"<?php if ( $lightboxPlusOptions['opacity']=='0.85' ) echo ' selected="selected"'?>>85%</option>
      					  <option value="0.9"<?php if ( $lightboxPlusOptions['opacity']=='0.9' ) echo ' selected="selected"'?>>90%</option>
      					  <option value="0.95"<?php if ( $lightboxPlusOptions['opacity']=='0.95' ) echo ' selected="selected"'?>>95%</option>
      					  <option value="1.0"<?php if ( $lightboxPlusOptions['opacity']=='1.0' ) echo ' selected="selected"'?>>100%</option>
      					</select><br /><?php _e( 'Controls transparency of shadow overlay. Lower numbers are more transparent.<br /><strong><em>Default: 80%</em></strong>', 'lightboxplus' )?>
              </td>
            </tr>

					  <tr>
              <th scope="row"><?php _e( 'Pre-load images', 'lightboxplus' )?>: </th>
              <td><input type="checkbox" name="preloading" value="1"<?php if ( $lightboxPlusOptions['preloading'] ) echo ' checked="checked"';?> /><br /><?php _e( 'Allows for preloading of "Next" and "Previous" content in a shared relation group (same values for the "rel" attribute), after the current content has finished loading. Uncheck to disable.<br /><strong><em>Default: Checked</em></strong>', 'lightboxplus' )?></td>
            </tr>

					  <tr>
              <th scope="row"><?php _e( 'Grouping Labels', 'lightboxplus' )?>: </th>
              <td><input type="text" size="15" name="label_image" id="label_image" value="<?php if (empty( $lightboxPlusOptions['label_image'] )) { echo 'Image'; } else {echo $lightboxPlusOptions['label_image'];}?>" /> # <input type="text" size="15" name="label_of" id="label_of" value="<?php if (empty( $lightboxPlusOptions['label_of'] )) { echo 'of'; } else {echo $lightboxPlusOptions['label_of'];}?>" /> #<br /><?php _e( 'Text format for the content group / gallery count. {current} and {total} are detected and replaced with actual numbers while ColorBox runs.<strong><em>Default: Image {current} of {total}</em></strong>', 'lightboxplus' )?></td>
            </tr>

					  <tr>
              <th scope="row"><?php _e( 'Previous image text', 'lightboxplus' )?>: </th>
              <td><input type="text" size="15" name="previous" id="previous" value="<?php if ( !empty( $lightboxPlusOptions['previous'] )) { echo $lightboxPlusOptions['previous'];} else { echo 'previous'; } ?>" /><br /><?php _e( 'Text for the previous button in a shared relation group (same values for "rel" attribute). <strong><em>Default: previous</em></strong>', 'lightboxplus' )?></td>
            </tr>

					  <tr>
              <th scope="row"><?php _e( 'Next image text', 'lightboxplus' )?>: </th>
              <td><input type="text" size="15" name="next" id="next" value="<?php if ( !empty( $lightboxPlusOptions['next'] )) { echo $lightboxPlusOptions['next'];} else { echo 'next'; } ?>" /><br /><?php _e( 'Text for the next button in a shared relation group (same values for "rel" attribute).  <strong><em>Default: next</em></strong>', 'lightboxplus' )?></td>
            </tr>

					  <tr>
              <th scope="row"><?php _e( 'Close image text', 'lightboxplus' )?>: </th>
              <td><input type="text" size="15" name="close" id="close" value="<?php if ( !empty( $lightboxPlusOptions['close'] )) { echo $lightboxPlusOptions['close'];} else { echo 'close'; } ?>" /><br /><?php _e( 'Text for the close button. The "Esc" key will also close Lightbox Plus. <strong><em>Default: close</em></strong>', 'lightboxplus' )?></td>
            </tr>

					  <tr>
              <th scope="row"><?php _e( 'Overlay Close', 'lightboxplus' )?>: </th>
              <td><input type="checkbox" name="overlay_close" id="overlay_close" value="1"<?php if ( $lightboxPlusOptions['overlay_close'] ) echo ' checked="checked"';?> /><br /><?php _e( 'If checked, enables closing Lightbox Plus by clicking on the background overlay.<br /><strong><em>Default: Checked</em></strong>', 'lightboxplus' )?></td>
            </tr>

					  <tr>
              <th scope="row" colspan="2"><h3><?php _e( 'Slideshow Settings', 'lightboxplus' )?></h3></th>
            </tr>

					  <tr>
              <th scope="row"><?php _e( 'Slideshow', 'lightboxplus' )?>: </th>
              <td><input type="checkbox" name="slideshow" id="slideshow" value="1"<?php if ( $lightboxPlusOptions['slideshow'] ) echo ' checked="checked"';?> /><br /><?php _e( 'If checked, adds slideshow capablity to a content group / gallery. <br /><strong><em>Default: Unchecked</em></strong>', 'lightboxplus' )?></td>
            </tr>

					  <tr>
              <th scope="row"><?php _e( 'Auto-Start Slideshow', 'lightboxplus' )?>: </th>
              <td><input type="checkbox" name="slideshow_auto" id="slideshow_auto" value="1"<?php if ( $lightboxPlusOptions['slideshow_auto'] ) echo ' checked="checked"';?> /><br /><?php _e( 'If checked, the slideshows will automatically start to play when content grou opened. <br /><strong><em>Default: Checked</em></strong>', 'lightboxplus' )?></td>
            </tr>

					  <tr>
              <th scope="row"><?php _e( 'Slideshow Speed', 'lightboxplus' )?>: </th>
              <td>
      					<select name="slideshow_speed" id="slideshow_speed">
      					  <option value="500"<?php if ( $lightboxPlusOptions['slideshow_speed']=='500' ) echo ' selected="selected"'?>>500</option>
      					  <option value="1000"<?php if ( $lightboxPlusOptions['slideshow_speed']=='1000' ) echo ' selected="selected"'?>>1000</option>
      					  <option value="1500"<?php if ( $lightboxPlusOptions['slideshow_speed']=='1500' ) echo ' selected="selected"'?>>1500</option>
      					  <option value="2000"<?php if ( $lightboxPlusOptions['slideshow_speed']=='2000' ) echo ' selected="selected"'?>>2000</option>
      					  <option value="2500"<?php if ( $lightboxPlusOptions['slideshow_speed']=='2500' ) echo ' selected="selected"'?>>2500</option>
      					  <option value="3000"<?php if ( $lightboxPlusOptions['slideshow_speed']=='3000' ) echo ' selected="selected"'?>>3000</option>
      					  <option value="3500"<?php if ( $lightboxPlusOptions['slideshow_speed']=='3500' ) echo ' selected="selected"'?>>3500</option>
      					  <option value="4000"<?php if ( $lightboxPlusOptions['slideshow_speed']=='4000' ) echo ' selected="selected"'?>>4000</option>
      					  <option value="4500"<?php if ( $lightboxPlusOptions['slideshow_speed']=='4500' ) echo ' selected="selected"'?>>4500</option>
      					  <option value="5000"<?php if ( $lightboxPlusOptions['slideshow_speed']=='5000' ) echo ' selected="selected"'?>>5000</option>
      					  <option value="5500"<?php if ( $lightboxPlusOptions['slideshow_speed']=='5500' ) echo ' selected="selected"'?>>5500</option>
      					  <option value="6000"<?php if ( $lightboxPlusOptions['slideshow_speed']=='6000' ) echo ' selected="selected"'?>>6000</option>
      					  <option value="6500"<?php if ( $lightboxPlusOptions['slideshow_speed']=='6500' ) echo ' selected="selected"'?>>6500</option>
      					  <option value="7000"<?php if ( $lightboxPlusOptions['slideshow_speed']=='7000' ) echo ' selected="selected"'?>>7000</option>
      					  <option value="7500"<?php if ( $lightboxPlusOptions['slideshow_speed']=='7500' ) echo ' selected="selected"'?>>7500</option>
      					  <option value="8000"<?php if ( $lightboxPlusOptions['slideshow_speed']=='8000' ) echo ' selected="selected"'?>>8000</option>
      					  <option value="8500"<?php if ( $lightboxPlusOptions['slideshow_speed']=='8500' ) echo ' selected="selected"'?>>8500</option>
      					  <option value="9000"<?php if ( $lightboxPlusOptions['slideshow_speed']=='9000' ) echo ' selected="selected"'?>>9000</option>
                  <option value="9500"<?php if ( $lightboxPlusOptions['slideshow_speed']=='9500' ) echo ' selected="selected"'?>>9500</option>
                  <option value="10000"<?php if ( $lightboxPlusOptions['slideshow_speed']=='10000' ) echo ' selected="selected"'?>>10000</option>
                  <option value="11000"<?php if ( $lightboxPlusOptions['slideshow_speed']=='11000' ) echo ' selected="selected"'?>>11000</option>
                  <option value="12000"<?php if ( $lightboxPlusOptions['slideshow_speed']=='12000' ) echo ' selected="selected"'?>>12000</option>
                  <option value="13000"<?php if ( $lightboxPlusOptions['slideshow_speed']=='13000' ) echo ' selected="selected"'?>>13000</option>
                  <option value="14000"<?php if ( $lightboxPlusOptions['slideshow_speed']=='14000' ) echo ' selected="selected"'?>>14000</option>
                  <option value="15000"<?php if ( $lightboxPlusOptions['slideshow_speed']=='15000' ) echo ' selected="selected"'?>>15000</option>
                  <option value="20000"<?php if ( $lightboxPlusOptions['slideshow_speed']=='20000' ) echo ' selected="selected"'?>>20000</option>
      					</select><br /><?php _e( 'Controls the speed of the slideshow, in milliseconds.<br /><strong><em>Default: 2500</em></strong>', 'lightboxplus' )?>
              </td>
            </tr>

					  <tr>
              <th scope="row"><?php _e( 'Slideshow start text', 'lightboxplus' )?>: </th>
              <td><input type="text" size="15" name="slideshow_start" id="slideshow_start" value="<?php if ( !empty( $lightboxPlusOptions['slideshow_start'] )) { echo $lightboxPlusOptions['slideshow_start'];} else { echo 'start'; } ?>" /><br /><?php _e( 'Text for the slideshow start button. <strong><em>Default: start</em></strong>', 'lightboxplus' )?></td>
            </tr>

					  <tr>
              <th scope="row"><?php _e( 'Slideshow stop text', 'lightboxplus' )?>: </th>
              <td><input type="text" size="15" name="slideshow_stop" id="slideshow_stop" value="<?php if ( !empty( $lightboxPlusOptions['slideshow_stop'] )) { echo $lightboxPlusOptions['slideshow_stop'];} else { echo 'stop'; } ?>" /><br /><?php _e( 'Text for the slideshow stop button.  <strong><em>Default: stop</em></strong>', 'lightboxplus' )?></td>
            </tr>

					  <tr>
              <th scope="row" colspan="2"><h3><?php _e( 'Other Lightbox Plus Settings', 'lightboxplus' )?></h3></th>
            </tr>

					  <tr>
              <th scope="row"><?php _e( 'Use For WP Gallery', 'lightboxplus' )?>: </th>
              <td><input type="checkbox" name="gallery_lightboxplus" id="gallery_lightboxplus" value="1"<?php if ( $lightboxPlusOptions['gallery_lightboxplus'] ) echo ' checked="checked"';?> /><br /><?php _e( 'If checked, Lightbox Plus will add the Lightboxing feature to the WordPress built in gallery feature.  In order for this to work correcly you must set <strong>Link thumbnails to: Image File</strong> or use <code>[gallery link="file"</code> for the gallery options.<br /><strong><em>Default: Unchecked</em></strong>', 'lightboxplus' )?></td>
            </tr>

					  <tr>
              <th scope="row"><?php _e( 'Use Class Method', 'lightboxplus' )?>: </th>
              <td><input type="checkbox" name="class_method" id="class_method" value="1"<?php if ( $lightboxPlusOptions['class_method'] ) echo ' checked="checked"';?> /><br /><?php _e( 'If checked, Lightbox Plus will only lightbox images via <code>class: cboxModal</code> attribute.  Using this method you can manually control which images are affected by Lightbox Plus by adding the cboxModal class to the Advanced Link Settings in the WordPress Edit Image tool or by adding it to the image link URL and checking the <strong>Do Not Auto-Lightbox Images</strong> option.<br /><strong><em>Default: Unchecked</em></strong>', 'lightboxplus' )?></td>
            </tr>

					  <tr>
              <th scope="row"><?php _e( '<strong>Do Not</strong> Auto-Lightbox Images', 'lightboxplus' )?>: </th>
              <td><input type="checkbox" name="auto_lightbox" id="auto_lightbox" value="1"<?php if ( $lightboxPlusOptions['auto_lightbox'] ) echo ' checked="checked"';?> /><br /><?php _e( 'If checked, Lightbox Plus <em>will not</em> automatically add appropriate attibutes (either <code>rel="lightbox[postID]"</code> or <code>class: cboxModal</code>) to Image URL.  You will need to manually add the appropriate attribute for Lightbox Plus to work.<br /><strong><em>Default: Unchecked</em></strong>', 'lightboxplus' )?></td>
            </tr>

					  <tr>
              <th scope="row"><?php _e( '<strong>Do Not</strong> Display Image Title', 'lightboxplus' )?>: </th>
              <td><input type="checkbox" name="display_title" id="display_title" value="1"<?php if ( $lightboxPlusOptions['display_title'] ) echo ' checked="checked"';?> /><br /><?php _e( 'If checked, Lightbox Plus <em>will not</em> display image titles automatically.  This has no effect if the <strong>Do Not Auto-Lightbox Images</strong> option is checked.<br /><strong><em>Default: Unchecked</em></strong>', 'lightboxplus' )?></td>
            </tr>


					 </table>
			    <p class="submit">
			      <input type="submit" style="padding:5px 30px 5px 30px;" name="Submit" value="<?php _e( 'Save settings', 'lightboxplus' )?> &raquo;" />
			    </p>
			  </form>

        <div class="about">
          <h4><?php _e( 'About Lightbox Plus for WordPress','lightboxplus' ); ?>: </h4>
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="float:right;"> <input name="cmd" type="hidden" value="_donations" /> <input name="business" type="hidden" value="dzappone@gmail.com" /> <input name="item_name" type="hidden" value="Dan Zappone" /> <input name="item_number" type="hidden" value="23SDONWP" /> <input name="no_shipping" type="hidden" value="0" /> <input name="no_note" type="hidden" value="1" /> <input name="currency_code" type="hidden" value="EUR" /> <input name="tax" type="hidden" value="0" /> <input name="lc" type="hidden" value="US" /> <input name="bn" type="hidden" value="PP-DonationsBF" /> <input alt="PayPal - The safer, easier way to pay online!" name="submit" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" type="image" /> <img src="https://www.paypal.com/en_US/i/scr/pixel.gif" border="0" alt="" width="1" height="1" />
</form>
					<h5><?php _e( 'Thank you for downloading and installing Lightbox Plus for WordPress<br /><br /><a href="http://www.23systems.net/plugins/lightbox-plus/">Visit plugin site</a> | <a href="http://www.23systems.net/plugins/lightbox-plus/frequently-asked-questions/">FAQ</a> | <a href="http://www.23systems.net/bbpress/forum/lightbox-plus">Support</a> | <a href="http://twitter.com/23systems">Follow on Twitter</a>','lightboxplus' ); ?></h5>
					<?php _e( 'Like many developers I spend a lot of my spare time working on WordPress plugins and themes and any donation to the cause is appreciated.  I know a lot of other developers do the same and I try to donate to them whenever I can.  As a developer I greatly appreciate any donation you can make to help support further development of quality plugins and themes for WordPress.  In keeping with the name of my site <a href="http://www.23systems.net">23Systems</a> a minimum donation of &euro;2.30 to &euro;23.00 is encouraged but I\'ll gladly accept whatever you feel comfortable with. <em>You have my sincere thanks and appreciation</em>.','lightboxplus' ); ?>
				</div>
			</div>