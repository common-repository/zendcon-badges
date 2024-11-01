<?php
/*
Plugin Name: ZendCon Badge
Plugin URI: http://www.zendcon.com/
Description: Displays a sidebar image for ZendCon
Version: 1.1.1
Author: Kevin Schroeder
License: New BSD
*/

wp_register_sidebar_widget('zendcon_images', 'ZendCon Badge', 'zendcon_display_image');

if (function_exists('add_action')) {
//	add_action('init', 'zendcon_init');
	add_action('admin_menu', 'zendcon_init');
}

function zendcon_init()
{
	
	add_option('zendcon_type');
	add_option('zendcon_size');
	add_options_page(
		'ZendCon',
	    'ZendCon',
	     'administrator',
	    __FILE__,
	    'zendcon_handle_settings'
	);	
}

function zendcon_display_image()
{
	
	$imageUrl = sprintf(
		'%s/wp-content/plugins/zendcon-badges/images/%s-%d.gif',
		get_bloginfo('url'),
		htmlspecialchars(get_option('zendcon_type')),
		get_option('zendcon_size')
	);
	switch (get_option('zendcon_type')) {
		case 'speaker':
			$linkUrl = 'http://www.zendcon.com/speaker';
			break;
		default:
			$linkUrl = 'http://www.zendcon.com/';
			break;		
	}
	
	echo sprintf(
		'<div style="text-align: center; "><a href="%s"><img src="%s" border="0"/></a></div>',
		$linkUrl,
		$imageUrl
	); 
}

function zendcon_handle_settings()
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		update_option('zendcon_type', $_POST['zendcon_type']);
		update_option('zendcon_size', $_POST['zendcon_size']);
	}
	?>
<div class="wrap" style="width: 300px; ">
<h2><?php _e('ZendCon Settings', 'zendcon'); ?></h2>

<form action="" method="post" id="zendcon-conf" >

<label for="zendcon_type" style="float: left; "><?php _e('Type of attendee'); ?></label>
<select name="zendcon_type" style="float: right; width: 100px; ">
	<option value="speaker" <?php echo get_option('zendcon_type')=='speaker'?'selected':''?>>Speaker</option>
	<option value="attendee" <?php echo get_option('zendcon_type')=='attendee'?'selected':''?>>Attendee</option>
	<option value="sponsor" <?php echo get_option('zendcon_type')=='sponsor'?'selected':''?>>Sponsor</option>
	<option value="exhibitor" <?php echo get_option('zendcon_type')=='exhibitor'?'selected':''?>>Exhibitor</option>
</select>
<br clear="all" />
<label for="zendcon_size" style="float: left; "><?php _e('Image Size'); ?></label>
<select name="zendcon_size"  style="float: right; width: 100px; ">
	<option value="1" <?php echo get_option('zendcon_size')=='1'?'selected':''?>>273px</option>
	<option value="2" <?php echo get_option('zendcon_size')=='2'?'selected':''?>>200px</option>
	<option value="3" <?php echo get_option('zendcon_size')=='3'?'selected':''?>>150px</option>
</select>

<br clear="all" />
        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes', 'lightsocial') ?>" />
        </p>

</form>
</div>
<?php 
}