<?php

/*
Plugin Name: Random image gallery with fancy zoom
Plugin URI: http://www.gopiplus.com/work/2010/07/18/random-image-gallery-with-fancy-zoom/
Description: This plug-in which allows you to simply and easily show random image anywhere in your template files or using widgets with onclick fancy zoom effect. 
Author: Gopi.R
Version: 5.0
Author URI: http://www.gopiplus.com/work/2010/07/18/random-image-gallery-with-fancy-zoom/
Donate link: http://www.gopiplus.com/work/2010/07/18/random-image-gallery-with-fancy-zoom/
*/

/**
 *     Random image gallery with fancy zoom
 *     Copyright (C) 2011  www.gopiplus.com
 * 
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

function rigwfz_show() 
{
	include_once("select-random-image.php");
    ?><script language="javascript">setupZoom();</script><?php
}

function rigwfz_install() 
{
	add_option('rigwfz_title', "Slideshow Fancyzoom");
	add_option('rigwfz_width', "180");
	add_option('rigwfz_dir', "wp-content/plugins/random-image-gallery-with-fancy-zoom/random-gallery/");
	add_option('rigwfz_title_yes', "YES");
}

add_filter('the_content','rigwfz_show_filter');

function rigwfz_show_filter($content)
{
	return 	preg_replace_callback('/\[RIGWFZ(.*?)\]/sim','rigwfz_show_filter_callback',$content);
}

function rigwfz_show_filter_callback($matches) 
{
	global $wpdb;
	
	$rigwfz_dir = get_option('rigwfz_dir');

	$rigwfz_siteurl = get_option('siteurl') . "/" . $rigwfz_dir ;
	
	$imglist='';
	//$img_folder is the variable that holds the path to the banner images. Mine is images/tutorials/
	// see that you don't forget about the "/" at the end 
	$img_folder = $rigwfz_dir;
	
	mt_srand((double)microtime()*1000);
	
	//use the directory class
	$imgs = dir($img_folder);
	
	//read all files from the  directory, checks if are images and ads them to a list (see below how to display flash banners)
	while ($file = $imgs->read()) {
	if (eregi("gif", $file) || eregi("jpg", $file) || eregi("png", $file))
	$imglist .= "$file ";
	
	} closedir($imgs->handle);
	
	//put all images into an array
	$imglist = explode(" ", $imglist);
	$no = sizeof($imglist)-2;
	
	//generate a random number between 0 and the number of images
	$random = mt_rand(0, $no);
	$image = $imglist[$random];
	
	$mainsiteurl =	get_option('siteurl') . "/wp-content/plugins/random-image-gallery-with-fancy-zoom/";
	
	$rigwfz_width =	get_option('rigwfz_width');
	if(!is_numeric($rigwfz_width))
	{
		$rigwfz_width = 180;
	} 
	
	$rigwfz = $rigwfz . '<div>';
	$rigwfz = $rigwfz . '<a href="'.$rigwfz_siteurl . $image .'" rel="fancyzoom">';
	$rigwfz = $rigwfz . '<img src="'.$mainsiteurl.'crop-random-image.php?AC=YES&DIR='.$rigwfz_dir.'&IMGNAME='.$image.'&MAXWIDTH='.$rigwfz_width.'"> ';
	$rigwfz = $rigwfz . '</a>';
	$rigwfz = $rigwfz . '</div>';
	return $rigwfz;	
}

function rigwfz_widget($args) 
{
	extract($args);
	
	if(get_option('rigwfz_title_yes') == "YES") 
	{
		echo $before_widget . $before_title;
		echo get_option('rigwfz_title');
		echo $after_title;
	}
	
	rigwfz_show();
	
	if(get_option('rigwfz_title_yes') == "YES") 
	{
		echo $after_widget;
	}
}

function rigwfz_admin_option() 
{
	
	echo "<div class='wrap'>";
	echo "<h2>"; 
	echo "Random image gallery with fancy zoom (R I G W F Z)";
	echo "</h2>";
    
	$rigwfz_title = get_option('rigwfz_title');
	$rigwfz_width = get_option('rigwfz_width');
	$rigwfz_dir = get_option('rigwfz_dir');
	$rigwfz_title_yes = get_option('rigwfz_title_yes');
	
	if (@$_POST['rigwfz_submit']) 
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
	echo '<p>Default Image directory:<br>wp-content/plugins/random-image-gallery-with-fancy-zoom/random-gallery/<br>';
	echo 'Dont upload your original images into this defult folder, instead you change this default path to original path.</p>';
	echo '<input name="rigwfz_submit" id="rigwfz_submit" class="button-primary" value="Submit" type="submit" />';
	?>
	</td><td align="center" valign="middle"> </td></tr></table>
	</form>
    <h2>Drag and drop the widget</h2>
	Go to widget menu and drag and drop the "R I G W F Z" widget to your sidebar location. <br />
    <h2>Paste the below php code to your php file</h2>
    <div style="padding-top:7px;padding-bottom:7px;">
    <code style="padding:7px;">
    &lt;?php if (function_exists (rigwfz_show)) rigwfz_show(); ?&gt;
    </code></div>
    <h2>Short code to add images into posts and pages</h2>
    <a target="_blank" href='http://www.gopiplus.com/work/2010/07/18/random-image-gallery-with-fancy-zoom/'>Click here</a> to find the short code. <br> 
	<h2>Plugin live demo and Help</h2>
	<a target="_blank" href='http://www.gopiplus.com/work/2010/07/18/random-image-gallery-with-fancy-zoom/'>Click here</a> to check official website for live demo<br> 
    <br>
	<?php
	echo "</div>";
}

function rigwfz_control()
{
	echo '<p>Random image gallery with fancy zoom. to change the setting goto R I G W F Z link under SETTING tab.';
	echo ' <a href="options-general.php?page=random-image-gallery-with-fancy-zoom/random-image-gallery-with-fancy-zoom.php">';
	echo 'click here</a></p>';
}

function rigwfz_widget_init() 
{
	if(function_exists('wp_register_sidebar_widget')) 	
	{
		wp_register_sidebar_widget('rigwfz', 'R I G W F Z', 'rigwfz_widget');
	}
	
	if(function_exists('wp_register_widget_control')) 	
	{
		wp_register_widget_control('rigwfz', array('R I G W F Z', 'widgets'), 'rigwfz_control');
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
	add_options_page('Random image gallery with fancy zoom - R I G W F Z', 'R I G W F Z', 'manage_options', __FILE__, 'rigwfz_admin_option' );
}

if (is_admin()) 
{
	add_action('admin_menu', 'rigwfz_add_to_menu');
}

function rigwfz_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script( 'FancyZoom', get_option('siteurl').'/wp-content/plugins/random-image-gallery-with-fancy-zoom/rigwfz_js/FancyZoom.js');
		wp_enqueue_script( 'FancyZoomHTML', get_option('siteurl').'/wp-content/plugins/random-image-gallery-with-fancy-zoom/rigwfz_js/FancyZoomHTML.js');
	}	
}
add_action('init', 'rigwfz_add_javascript_files');

add_action('admin_menu', 'rigwfz_add_to_menu');
add_action("plugins_loaded", "rigwfz_widget_init");
register_activation_hook(__FILE__, 'rigwfz_install');
register_deactivation_hook(__FILE__, 'rigwfz_deactivation');
add_action('init', 'rigwfz_widget_init');
?>
