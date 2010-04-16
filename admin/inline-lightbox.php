	<!-- Begin Inline Lightbox -->
	<div id="poststuff" class="lbp">
		<div class="postbox">
			<h3>
				<?php _e( 'Lightbox Plus - Inline Lightbox Settings','lightboxplus' ); ?>: </h3>
			<div class="inside">
			  <!-- Base Settings -->
				<div id="poststuff" class="lbp">
				<table class="form-table"><!-- Instructions -->
				  <tr>
				    <td>
              <a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>" onclick="toggleVisibility('lbp_for_inline_tip');">Using Inline Lightboxes <img src="<?php echo $g_lightbox_plus_url.'/admin/information.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
            </td>
				    <td>
            </td>
				    <td>

            </td>
				  </tr>
				  <tr>
				    <td colspan="3">
              <div class="lbp-bigtip" id="lbp_for_inline_tip">
                <?php _e( 'In order to display video using Lightbox Plus and Colorbox you must at a minimum has the following items set: Inner Width, Inner Height, and Use Iframe must be checked.<br /><br />
                <code>&lt;a title="Projection Animation Test" class="lbpModal" href="http://www.youtube.com/v/pUPrCCP73Ws">YouTube Flash / Video (Iframe/Direct Link To YouTube)&lt;/a></code><br />
    <code>&lt;a title="Projection Animation Test" class="lbpModal" href="http://vimeo.com/moogaloop.swf?clip_id=9730308&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1">Vimeo Flash / Video (Iframe/Direct Link To Vimeo)&lt;/a></code>', 'lightboxplus' )?>
                <br /><a title="Projection Animation Test" class="lbpModal" href="http://vimeo.com/moogaloop.swf?clip_id=9730308&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1">Demo (using current settings)</a>
              </div>

				    </td>
				  </tr>
				</table>
				
					<div class="postbox">
						<h3>
							<?php _e( 'Inline Lightbox - Individual Settings','lightboxplus' ); ?>: </h3>
						<div class="inside toggle">
						
						  
							<table class="form-table widefat">
							 <thead>
								<tr>
                  <th>&nbsp;</th>
                  <th><b>Link Class</b></th>
                  <th><b>Content ID</b></th>
                  <th><b>Width</b></th>
                  <th><b>Height</b></th>
                </tr>
               </thead>
               <tbody>
                <?php 
                  for ($i = 1; $i <= $lightboxPlusOptions['inline_num']; $i++) {
                  $inline_links = array();
                  $inline_hrefs = array();
                  $inline_widths = array();
                  $inline_heights = array();
                  $inline_links = $lightboxPlusOptions['inline_links'];
                  $inline_hrefs = $lightboxPlusOptions['inline_hrefs'];
                  $inline_widths = $lightboxPlusOptions['inline_widths'];
                  $inline_heights = $lightboxPlusOptions['inline_heights'];
                ?>
                <tr <?php if ($i % 2 == 0) {echo 'class="alternate"';} ?>>
                  <td><?php _e( 'Inline Lightbox #'.$i, 'lightboxplus' )?>:</td>
                  <td>
                  	<input type="text" size="25" name="inline_link_<?php echo $i; ?>" id="inline_link_<?php echo $i; ?>" value="<?php if (empty( $inline_links[$i - 1] )) { echo 'lbp-inline-link-'.$i; } else {echo $inline_links[$i - 1];}?>" />
                  </td>
                  <td>
                   <input type="text" size="25" name="inline_href_<?php echo $i; ?>" id="inline_href_<?php echo $i; ?>" value="<?php if (empty( $inline_hrefs[$i - 1] )) { echo 'lbp-inline-href-'.$i; } else {echo $inline_hrefs[$i - 1];}?>" />
                  </td>
                  <td>
                    <input type="text" size="10" name="inline_width_<?php echo $i; ?>" id="inline_width_<?php echo $i; ?>" value="<?php if (empty( $inline_widths[$i - 1] )) { echo '50%'; } else {echo $inline_widths[$i - 1];}?>" />
                  </td>
                  <td>
                    <input type="text" size="10" name="inline_height_<?php echo $i; ?>" id="inline_height_<?php echo $i; ?>" value="<?php if (empty( $inline_heights[$i - 1] )) { echo '50%'; } else  {echo $inline_heights[$i - 1];}?>" />
                  </td>
                </tr>
								<?php
                }
                ?>							
                </tbody>
							</table>
						</div>
					</div>
					<!-- begin testin - wrap in postbox -->
      		<div class="postbox close-me"><h3 class="hndle" title="Click to toggle"><?php _e( 'Secondary Lightbox - Test Area','lightboxplus' ); ?>:</h3>
      			<div class="inside toggle">
      				<table class="form-table">
      				  <tr valign="top">
      				    <th scope="row">
      				      <?php _e( 'Inline Test Link', 'lightboxplus' )?>:
      				    </th>
      				    <td>
      				      <input type="text" name="inline_link_test" id="inline_link_test" value="&lt;a class='<?php echo $inline_links[0]; ?>' href='#'>Inline HTML Form&lt;/a>" />
      				    <td>
      				  </tr>
      					<tr valign="top">
      						<th scope="row">
      							<?php _e( 'Inline Test HTML', 'lightboxplus' )?>: </th>
      						<td>
      						<textarea rows="7" name="inline_html_test" id="inline_html_test" class="inline_html_test" value="" />
<h3>Contact Us</h3>
We would love to hear from you.
<p><label for="inline_name">Name:</label>
<input type="text" name="inline_name" id="inline_name" tabindex="1" /></p>
<p><label for="inline_email">Email:</label>
<input type="text" name="inline_email" id="inline_email" tabindex="2" /></p>
<p><label for="inline_message">Message:</label>
<input type="text" name="inline_message" id="inline_message" tabindex="3"  /></p>
                  </textarea>
      							<a class="lbp-info" title="<?php _e('Click for Help!', 'lightboxplus')?>" onclick="toggleVisibility('lbp_inline_test_tip');"><img src="<?php echo $g_lightbox_plus_url.'/admin/information.png'?>" alt="<?php _e('Click for Help!', 'lightboxplus'); ?>" /></a>
      							<div class="lbp-tip" id="lbp_inline_test_tip">
      								<?php _e('Enter test markup box this box then click outside the box to view your test code. Note, you must add your own <code>class="'.$lightboxPlusOptions['class_name_sec'].'"</code> attributes to test your code.',"lightboxplus"); ?>
      							</div>
      						</td>
      					</tr>
      					<tr>
      						<th scope="row">
      							<?php _e( 'Result: ', 'lightboxplus' )?>: </th>
      						<td>
					          <p class="inline_link_test_item">
                      <a class="<?php echo $inline_links[0]; ?>" href="#">Inline Test Form</a>
                    </p>
                      <div style="display: none;">
                      <div id="<?php echo $inline_hrefs[0]; ?>" style="padding: 10px; background: #fff;">
                      
                      <p class="inline_html_test_item">
                      <h3>Contact Us</h3>
                      We would love to hear from you.
                      	<p><label for="inline_name">Name:</label>
                      	<input type="text" name="inline_name" id="inline_name" tabindex="1" /></p>
                      	<p><label for="inline_email">Email:</label>
                      	<input type="text" name="inline_email" id="inline_email" tabindex="2" /></p>
                      	<p><label for="inline_message">Message:</label>
                      	<input type="text" name="inline_message" id="inline_message" tabindex="3"  /></p>
                      </p>
                      
                      </div>
                      </div>  
      						</td>
      					</tr>
      				</table>
      			</div>
      		</div>
					<script type="text/javascript">
				  	<!--
            jQuery("textarea.inline_link_test").change(function () {
              var test_str = jQuery("input.inline_link_test").val();
              jQuery("p.inline_link_test_item").html(test_str);
            });
            jQuery("textarea.inline_html_test").change(function () {
              var test_str = jQuery("textarea.inline_html_test").val();
              jQuery("p.inline_html_test_item").html(test_str);
            });
            //-->
					</script>	
				<!-- end testing -->
				</div>
				<p class="submit">
					<input type="submit" style="padding:5px 30px 5px 30px;" name="Submit" title="<?php _e( 'Save all Lightbox Plus settings', 'lightboxplus' )?>" value="<?php _e( 'Save settings', 'lightboxplus' )?> &raquo;" />
				</p>
			</div>
		</div>
	</div>
	<!-- Begin Inline Lightbox -->