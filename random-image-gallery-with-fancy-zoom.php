<?php

/*
Plugin Name: Random image gallery with fancy zoom
Plugin URI: http://gopi.coolpage.biz/demo/2009/08/29/random-image-gallery-with-fancy-zoom/
Description: Random image gallery with fancy zoom  
Author: Gopi.R
Version: 1.0
Author URI: http://gopi.coolpage.biz/demo/about/
Donate link: http://gopi.coolpage.biz/demo/2009/08/29/random-image-gallery-with-fancy-zoom/
*/

function rigwfz_show() 
{
	$rigwfz_siteurl = get_option('siteurl') . "/wp-content/plugins/random-image-gallery-with-fancy-zoom/";
	?>
    <script src="<?php echo $rigwfz_siteurl; ?>/rigwfz_js/FancyZoom.js" type="text/javascript"></script>
	<script src="<?php echo $rigwfz_siteurl; ?>/rigwfz_js/FancyZoomHTML.js" type="text/javascript"></script>
	<?php include("select-random-image.php"); ?>
    <script language="javascript">setupZoom();</script>
    <?php
}

function rigwfz_install() 
{
	add_option('rigwfz_title', "Slideshow Fancyzoom");
	add_option('rigwfz_width', "180");
	add_option('rigwfz_dir', "wp-content/plugins/random-image-gallery-with-fancy-zoom/random-gallery/");
	add_option('rigwfz_title_yes', "YES");
}

function rigwfz_widget($args) 
{
	extract($args);
	echo $before_widget . $before_title;
	if(get_option('rigwfz_title_yes') == "YES") 
	{
		echo get_option('rigwfz_title');
	}
	echo $after_title;
	rigwfz_show();
	echo $after_widget;
}

function rigwfz_admin_option() 
{
	include_once("extra.php");
	echo "<div class='wrap'>";
	echo "<h2>"; 
	echo wp_specialchars( "Random image gallery with fancy zoom (R I G W F Z)" ) ;
	echo "</h2>";
    
	$rigwfz_title = get_option('rigwfz_title');
	$rigwfz_width = get_option('rigwfz_width');
	$rigwfz_dir = get_option('rigwfz_dir');
	$rigwfz_title_yes = get_option('rigwfz_title_yes');
	
	if ($_POST['rigwfz_submit']) 
	{
		$rigwfz_title = stripslashes($_POST['rigwfz_title']);
		$rigwfz_width = stripslashes($_POST['rigwfz_width']);
		$rigwfz_dir = stripslashes($_POST['rigwfz_dir']);
		$rigwfz_title_yes = stripslashes($_POST['rigwfz_title_yes']);
		
		update_option('rigwfz_title', $rigwfz_title );
		update_option('rigwfz_width', $rigwfz_width );
		update_option('rigwfz_dir', $rigwfz_dir );
		update_option('rigwfz_title_yes', $rigwfz_title_yes );
	}
	?>
	<form name="form_hsa" method="post" action="">
	<table width="100%" border="0" cellspacing="0" cellpadding="3"><tr><td align="left">
	<?php
	echo '<p>Title:<br><input  style="width: 450px;" maxlength="200" type="text" value="';
	echo $rigwfz_title . '" name="rigwfz_title" id="rigwfz_title" /></p>';
	echo '<p>Width:<br><input  style="width: 250px;" maxlength="3" type="text" value="';
	echo $rigwfz_width . '" name="rigwfz_width" id="rigwfz_width" />(Only Number)</p>';
	echo '<p>Display Sidebar Title:<br><input maxlength="3" style="width: 250px;" type="text" value="';
	echo $rigwfz_title_yes . '" name="rigwfz_title_yes" id="rigwfz_title_yes" />(YES/NO)</p>';
	echo '<p>Image directory:<br><input  style="width: 550px;" type="text" value="';
	echo $rigwfz_dir . '" name="rigwfz_dir" id="rigwfz_dir" /></p>';
	echo '<p>Default Image directory:<br>wp-content/plugins/random-image-gallery-with-fancy-zoom/random-gallery/</p>';
	echo '<input name="rigwfz_submit" id="rigwfz_submit" class="button-primary" value="Submit" type="submit" />';
	?>
	</td><td align="center" valign="middle"> <?php if (function_exists (timepass)) timepass(); ?> </td></tr></table>
	</form>
    <hr />
    We can use this plug-in in two different way.<br />
	1.	Go to widget menu and drag and drop the "R I G W F Z" widget to your sidebar location. or <br />
	2.	Copy and past the below mentioned code to your desired template location.
    <h2><?php echo wp_specialchars( 'Paste the below code to your desired template location!' ); ?></h2>
    <div style="padding-top:7px;padding-bottom:7px;">
    <code style="padding:7px;">
    &lt;?php if (function_exists (rigwfz_show)) rigwfz_show(); ?&gt;
    </code></div>
    <h2><?php echo wp_specialchars( 'About Plugin' ); ?></h2>
    Plug-in created by <a target="_blank" href='http://gopi.coolpage.biz/demo/about/'>Gopi</a>. || 
    <a target="_blank" href='http://gopi.coolpage.biz/demo/2009/08/29/random-image-gallery-with-fancy-zoom/'>click here</a> to post suggestion or comments or how to improve this plugin. || 
    <a target="_blank" href='http://gopi.coolpage.biz/demo/2009/08/29/random-image-gallery-with-fancy-zoom/'>click here</a> to see Live demo. || 
    <a target="_blank" href='http://gopi.coolpage.biz/demo/2009/08/29/random-image-gallery-with-fancy-zoom/'>click here</a> 
    To download my other plugins. || 
    Dont use two times in same page, Chance there to conflict with one another. ||
    Don't use both "random-image-gallery-with-light-box" plug-in and this "random-image-gallery-with-fancy-zoom" plug-in in same page ||
    Clicking the above ad will not affect the site, to remove the ad simply remove this "timepass()" function from page!!<br>
    <br>
	<?php
	echo "</div>";
}

function rigwfz_control()
{
	echo '<p>Random image gallery with fancy zoom.<br> To change the setting goto R I G W F Z link under SETTING tab.';
	echo ' <a href="options-general.php?page=random-image-gallery-with-fancy-zoom/random-image-gallery-with-fancy-zoom.php">';
	echo 'click here</a></p>';
}

function rigwfz_widget_init() 
{
  	register_sidebar_widget(__('R I G W F Z'), 'rigwfz_widget');   
	
	if(function_exists('register_sidebar_widget')) 	
	{
		register_sidebar_widget('R I G W F Z', 'rigwfz_widget');
	}
	
	if(function_exists('register_widget_control')) 	
	{
		register_widget_control(array('R I G W F Z', 'widgets'), 'rigwfz_control',400,400);
	} 
}

function rigwfz_deactivation() 
{
	delete_option('rigwfz_title');
	delete_option('rigwfz_width');
	delete_option('rigwfz_dir');
	delete_option('rigwfz_title_yes');
}

function rigwfz_add_to_menu() 
{
	add_options_page('Apple - Pizza', 'R I G W F Z', 7, __FILE__, 'rigwfz_admin_option' );
}

add_action('admin_menu', 'rigwfz_add_to_menu');
add_action("plugins_loaded", "rigwfz_widget_init");
register_activation_hook(__FILE__, 'rigwfz_install');
register_deactivation_hook(__FILE__, 'rigwfz_deactivation');
add_action('init', 'rigwfz_widget_init');
?>
