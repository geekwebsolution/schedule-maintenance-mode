<?php  
$options= smmgk_get_options();
$smmgk_error=false;
$now=current_time( 'timestamp');
if(isset($_POST['Save_Options']))
{ 
	$status=sanitize_text_field($_POST['status']);
	$st_mm=sanitize_text_field($_POST['st_mm']);
	$st_dd=sanitize_text_field($_POST['st_dd']);
	$st_yy=sanitize_text_field($_POST['st_yy']);
	$st_hh=sanitize_text_field($_POST['st_hh']);
	$st_mn=sanitize_text_field($_POST['st_mn']);
	
	$end_mm=sanitize_text_field($_POST['end_mm']);
	$end_dd=sanitize_text_field($_POST['end_dd']);
	$end_yy=sanitize_text_field($_POST['end_yy']);
	$end_hh=sanitize_text_field($_POST['end_hh']);
	$end_mn=sanitize_text_field($_POST['end_mn']);
	$start_schedule_hook="smmgk_start_shedule_maitenance";
	$end_schedule_hook="smmgk_end_shedule_maitenance";
	
	//Y-m-d H:i:s
	$st_time=strtotime($st_yy."-".$st_mm."-".$st_dd." ".$st_hh.":".$st_mn.":00");
	$end_time=strtotime($end_yy."-".$end_mm."-".$end_dd." ".$end_hh.":".$end_mn.":00");
	$nonce=$_POST['_wpnonce'];
	$options['status']=$status;
	$options['start_time']=$st_time;
	$options['end_time']=$end_time;
	$options['maintenance_mode']=0;
	if($st_time <= $now && $end_time >= $now)
    	{ 
    		if($status == 1)
    		$options['maintenance_mode']=1;
    	}
		
	if($st_time > $end_time)
	{ 
		 smmgk_failure_option_msg('Please Insert "End Time" more then "Start Time"!');
		  $smmgk_error=true;
	}
	if(wp_verify_nonce( $nonce, 'smmgk_schedule_maintenance_setting' ) && $smmgk_error==false)
	{
		update_option('smmgk_schedule_maintenance',$options);
		if($status==1)
		{ 
			wp_clear_scheduled_hook($start_schedule_hook);
			wp_clear_scheduled_hook($end_schedule_hook);
			wp_schedule_single_event($st_time, $start_schedule_hook);
			wp_schedule_single_event($end_time, $end_schedule_hook);
			
		}
		smmgk_success_option_msg("Save Setting!");
	}
	else
	{
        smmgk_failure_option_msg('Unable to save data!');
    }
}
if(isset($_POST['Save_Design']))
{
	
	$wpnonce_design=$_POST['wpnonce_design'];
	$options['logo']=sanitize_text_field($_POST['logo']);
	$options['background']=sanitize_text_field($_POST['background']);
	$options['headline']=sanitize_text_field($_POST['headline']);
	$options['countdown'] = (isset($_POST['countdown'])) ? sanitize_text_field($_POST['countdown']) : 0;
	$options['maintenance_content']=sanitize_text_field(htmlentities($_POST['maintenance_content']));
	$options['textcolor']=sanitize_text_field($_POST['textcolor']);
	$options['linkcolor']=sanitize_text_field($_POST['linkcolor']);
	$options['headlinecolor']=sanitize_text_field($_POST['headlinecolor']);
	if(wp_verify_nonce( $wpnonce_design, 'smmgk_schedule_maintenance_design' ))
	{
		update_option('smmgk_schedule_maintenance',$options);
		smmgk_success_option_msg("Save Setting!");
	}
	else
	{
        smmgk_failure_option_msg('Unable to save data!');
    }
}
if(isset($_POST['Save_Seo']))
{
	$seo_favicon=sanitize_text_field($_POST['seo_favicon']);
	$seo_title=sanitize_text_field($_POST['seo_title']);	
	$seo_description=sanitize_text_field($_POST['seo_description']);
	$analytic_code=sanitize_text_field(htmlentities($_POST['analytic_code']));
	$wpnonce_seo=$_POST['wpnonce_seo'];
	$options['seo_favicon']=$seo_favicon;
	$options['seo_title']=$seo_title;
	$options['seo_description']=$seo_description;
	$options['analytic_code']=$analytic_code;
	if(wp_verify_nonce( $wpnonce_seo, 'smmgk_schedule_maintenance_seo' ))
	{
		update_option('smmgk_schedule_maintenance',$options);
		smmgk_success_option_msg("Save Setting!");
	}
	else
	{
        smmgk_failure_option_msg('Unable to save data!');
    }
	
}
$start_time=current_time( 'timestamp');
$end_time=current_time( 'timestamp');
$st_yy=date('Y', $start_time);
$st_mm=date('m', $start_time);
$st_dd=date('d', $start_time);
$st_hh=date('H', $start_time);
$st_mn=date('i', $start_time);
$end_yy=date('Y', $end_time);
$end_mm=date('m', $end_time);
$end_dd=date('d', $end_time);
$end_hh=date('H', $end_time);
$end_mn=date('i', $end_time);
$status=$logo=$background=$headline=$countdown=$maintenance_content=$textcolor=$linkcolor=$headlinecolor=$seo_favicon=$seo_title=$seo_description=$analytic_code="";

if(isset($options['status'])) 				$status=$options['status'];
if(isset($options['start_time']))
{
	$start_time=$options['start_time'];
	$st_yy=date('Y', $start_time);
	$st_mm=date('m', $start_time);
	$st_dd=date('d', $start_time);
	$st_hh=date('H', $start_time);
	$st_mn=date('i', $start_time);
}
if(isset($options['end_time']))
{
	$end_time=$options['end_time'];
	$end_yy=date('Y', $end_time);
	$end_mm=date('m', $end_time);
	$end_dd=date('d', $end_time);
	$end_hh=date('H', $end_time);
	$end_mn=date('i', $end_time);
}
if(isset($options['logo'])) 				$logo=$options['logo'];
if(isset($options['background'])) 			$background=$options['background'];
if(isset($options['headline'])) 			$headline=$options['headline'];
if(isset($options['countdown'])) 			$countdown=$options['countdown'];
if(isset($options['maintenance_content'])) 	$maintenance_content=$options['maintenance_content'];
if(isset($options['textcolor'])) 			$textcolor=$options['textcolor'];
if(isset($options['linkcolor'])) 			$linkcolor=$options['linkcolor'];
if(isset($options['headlinecolor'])) 		$headlinecolor=$options['headlinecolor'];
if(isset($options['seo_favicon'])) 			$seo_favicon=$options['seo_favicon'];
if(isset($options['seo_title'])) 			$seo_title=$options['seo_title'];
if(isset($options['seo_description'])) 		$seo_description=$options['seo_description'];
if(isset($options['analytic_code'])) 		$analytic_code=wp_unslash($options['analytic_code']);
global $smmgk_months;
?>
<div class="wrap">
	<h2>Schedule Maintenance Mode</h2>
	<h2 class="nav-tab-wrapper smmgk_maintenance-tabing">
		<a href="?page=smmgk-schedule-maintenance-mode&tab=general_setting" class="nav-tab <?php if((isset($_REQUEST['tab']) &&$_REQUEST['tab'] =='general_setting') || !isset($_REQUEST['tab'])){ echo 'smmgk_active_tab';} ?>"><span class="dashicons dashicons-admin-tools"></span> General Setting</a>
		<a href="?page=smmgk-schedule-maintenance-mode&tab=design" class="nav-tab <?php if(isset($_REQUEST['tab']) && $_REQUEST['tab']=='design'){ echo 'smmgk_active_tab';} ?>"> <span class="dashicons dashicons-art"></span>Design</a>
		<a href="?page=smmgk-schedule-maintenance-mode&tab=seo" class="nav-tab <?php if(isset($_REQUEST['tab']) && $_REQUEST['tab']=='seo'){ echo 'smmgk_active_tab';} ?>"> <span class="dashicons dashicons-search"></span>SEO</a>
		<a href="<?php echo site_url(); ?>?smmgk_preview=true" target="_blank"class="nav-tab"> <span class="dashicons dashicons-share-alt2"></span> Live Preview</a>
		
	</h2>
	<div class='inner'>
		<?php 
	if(isset($_REQUEST['tab']) && $_REQUEST['tab']=='design'){ ?>
		<form method="POST" class="smmgk-design-form">
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row">Logo</th>
						<td>
							<input type="text" name="logo" id="smmgk_logo" value=<?php echo $logo; ?>>
							<input id="smmgk_logo_button" type="button" value="Media Image Library" />
							<p class="description">Upload a logo or teaser image (or) enter the url to your image.</p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">Background Image</th>
						<td>
							<input type="text" name="background" id="smmgk_background" value=<?php echo $background; ?>>
							<input id="smmgk_background_button" type="button" value="Media Image Library" />
							<p class="description">Upload a logo or teaser image (or) enter the url to your image.</p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">Headline</th>
						<td>
							<input type="text" name="headline" value="<?php echo $headline; ?>">
							<p class="description">Enter a headline for your page.</p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">CountDown</th>
						<td>
							<input type="checkbox" name="countdown" value="1" <?php if($countdown==1){ echo "checked"; } ?>> Enable<br>
							<p class="description">its a showing CountDown on maintenance page.</p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">Maintenance Message</th>
						<td>
							<?php 
				$editor_id = 'maintenance_content';
				wp_editor( htmlspecialchars_decode(stripslashes($maintenance_content)), $editor_id );
				?>
							<p class="description">Enter a Content message which is showing durring enable maintenance mode.</p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">Text Color</th>
						<td>
							<input type="text" name="textcolor" class="smmgk_colorpicker" value="<?php echo $textcolor; ?>">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">Link Color</th>
						<td>
							<input type="text" name="linkcolor" class="smmgk_colorpicker" value="<?php echo $linkcolor; ?>">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">Headline Color</th>
						<td>
							<input type="text" name="headlinecolor" class="smmgk_colorpicker" value="<?php echo $headlinecolor; ?>">
						</td>
					</tr>
				</tbody>
			</table>
			<input type="hidden" id="_wpnonce" name="wpnonce_design" value="<?php echo $nonce = wp_create_nonce('smmgk_schedule_maintenance_design'); ?>" />
			<input class="button-primary" type="submit" value="Update" name="Save_Design">
		</form>
		<?php }
	elseif (isset($_REQUEST['tab']) && $_REQUEST['tab']=='seo'){ 
?>
		<form method="POST" class="smmgk-seo-tab">
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row">Favicon</th>
						<td>
							<input type="text" name="seo_favicon" id="seo_favicon" value=<?php echo $seo_favicon; ?>>
							<input id="seo_favicon_button" type="button" value="Media Image Library" />
							<p class="description">Favicons are displayed in a browser tab.</p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">SEO Title</th>
						<td>
							<input type="text" name="seo_title" value="<?php echo $seo_title; ?>">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">SEO Meta Description</th>
						<td>
							<input type="text" name="seo_description" value="<?php echo $seo_description;?>">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">Analytics Code</th>
						<td>
							<textarea name="analytic_code" rows="6"><?php echo $analytic_code; ?></textarea>
						</td>
					</tr>
				</tbody>
			</table>
			<input type="hidden" id="_wpnonce" name="wpnonce_seo" value="<?php echo $nonce = wp_create_nonce('smmgk_schedule_maintenance_seo'); ?>" />
			<input class="button-primary" type="submit" value="Update" name="Save_Seo">
		</form>
		<?php
	}
 else {?>
			<form method="POST">
				<table class="form-table">
					<tbody>
						<tr valign="top">
							<th scope="row">Status </th>
							<td>
								<select id="" name="status">
									<option value="1" <?php if($status==1){ echo "selected"; } ?>>Enabled</option>
									<option value="0" <?php if($status==0){ echo "selected"; } ?>>Disabled</option>
								</select>
								<p class="description">If status is enable then it will be automatically showing maintenance page between start time and end time, and after end time status will be disable.</p>
							</td>
						</tr> 
						<tr valign="top">
							<th scope="row">Start Time (GMT)</th>
							<td>
								<div class="timestamp-wrap">
									<span class="screen-reader-text">Month</span>
									<select id="mm" name="st_mm">
				<?php  foreach($smmgk_months as $key =>$value) {?>
					<option value="<?php echo $key; ?>" data-text="<?php echo $value; ?>" <?php if($st_mm==$key) { echo "selected";} ?>><?php echo $key."-".$value; ?></option>
				<?php } ?>
				</select>
									<span class="screen-reader-text">Day</span><input type="text" id="dd" name="st_dd" value="<?php echo $st_dd; ?>" size="2" maxlength="2" autocomplete="off">,
									<span class="screen-reader-text">Year</span><input type="text" id="yy" name="st_yy" value="<?php echo $st_yy; ?>" size="4" maxlength="4" autocomplete="off"> @
									<span class="screen-reader-text">Hour</span><input type="text" id="hh" name="st_hh" value="<?php echo $st_hh; ?>" size="2" maxlength="2" autocomplete="off">:
									<span class="screen-reader-text">Minute</span><input type="text" id="mn" name="st_mn" value="<?php echo $st_mn; ?>" size="2" maxlength="2" autocomplete="off"> <span class="smmgk_gmt">GMT</span></div>
								<p class="description">The start time (m-d-Y H:i) that enable to showing maintenance page</p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">End Time (GMT)</th>
							<td>
								<div class="timestamp-wrap">
									<span class="screen-reader-text">Month</span>
									<select id="mm" name="end_mm">
										<?php  foreach($smmgk_months as $key =>$value) {?>
											<option value="<?php echo $key; ?>" data-text="<?php echo $value; ?>" <?php if( $end_mm==$key){ echo "selected";}?> ><?php echo $key."-".$value; ?></option>
										<?php } ?>
									</select>
									<span class="screen-reader-text">Day</span><input type="text" id="dd" name="end_dd" value="<?php echo $end_dd; ?>" size="2" maxlength="2" autocomplete="off">,
									<span class="screen-reader-text">Year</span><input type="text" id="yy" name="end_yy" value="<?php echo $end_yy; ?>" size="4" maxlength="4" autocomplete="off"> @
									<span class="screen-reader-text">Hour</span><input type="text" id="hh" name="end_hh" value="<?php echo $end_hh; ?>" size="2" maxlength="2" autocomplete="off">:
									<span class="screen-reader-text">Minute</span><input type="text" id="mn" name="end_mn" value="<?php echo $end_mn; ?>" size="2" maxlength="2" autocomplete="off"> <span class="smmgk_gmt">GMT</span>
								</div>
								<p class="description">The end time (m-d-Y H:i) that disable to showing maintenance page</p>
							</td>
						</tr>
					</tbody>
				</table>
				<input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo $nonce = wp_create_nonce('smmgk_schedule_maintenance_setting'); ?>" />
				<p class="description smmgk_current_gmt">Current GMT time is: <strong><?php echo date("m-d-Y @ H:i",$now); ?></strong></p>
				<input class="button-primary" type="submit" value="Update" name="Save_Options">
		</form>
			<?php }?>
	</div>
</div>
<script>
	(function($) {
		// Add Color Picker to all inputs that have 'color-field' class
		$(function() {
			$('.smmgk_colorpicker').wpColorPicker();
		});
	})(jQuery);
	    
</script>