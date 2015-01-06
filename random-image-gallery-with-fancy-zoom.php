<?php
/*
Plugin Name: Random image gallery with fancy zoom
Plugin URI: http://www.gopiplus.com/work/2010/07/18/random-image-gallery-with-fancy-zoom/
Description: This plug-in which allows you to simply and easily show random image anywhere in your template files or using widgets with onclick JQuery fancy zoom effect. 
Author: Gopi Ramasamy
Version: 9.5
Author URI: http://www.gopiplus.com/work/2010/07/18/random-image-gallery-with-fancy-zoom/
Donate link: http://www.gopiplus.com/work/2010/07/18/random-image-gallery-with-fancy-zoom/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

function rigwfz_show() 
{
	global $rigwfzload;
	$mainsiteurl =	get_option('siteurl') . "/wp-content/plugins/random-image-gallery-with-fancy-zoom/ressources/";
	global $ScriptInserted;
	if (!isset($ScriptInserted) || $ScriptInserted !== true)
	{
		$ScriptInserted = true;
		?>
		<script type="text/javascript">
		jQuery(function(){
			jQuery.fn.fancyzoom.defaultsOptions.imgDir='<?php echo $mainsiteurl; ?>';
			jQuery('#nooverlay').fancyzoom({Speed:400,showoverlay:false});
		});
		</script>
		<?php
	}
	include_once("select-random-image.php");
}

function rigwfz_install() 
{
	add_option('rigwfz_title', "Image with fancy zoom");
	add_option('rigwfz_width', "180");
	add_option('rigwfz_dir', "wp-content/plugins/random-image-gallery-with-fancy-zoom/random-gallery/");
	add_option('rigwfz_title_yes', "YES");
}

add_shortcode( 'random-fanzy-zoom', 'rigwfz_shortcode' );

function rigwfz_shortcode( $atts ) 
{
	global $wpdb;
	global $rigwfzload;
	
	$rigwfz_dir = get_option('rigwfz_dir');

	$rigwfz_siteurl = get_option('siteurl') . "/" . $rigwfz_dir ;
	
	$imglist='';
	//$img_folder is the variable that holds the path to the banner images. Mine is images/tutorials/
	// see that you don't forget about the "/" at the end 
	$img_folder = $rigwfz_dir;
	
	mt_srand((double)microtime()*1000);
	
	if(!is_dir($img_folder))
	{
		$rigwfz = __('Image folder does not exists', 'random-image-gallery');
		return $rigwfz;
	}

	//use the directory class
	$imgs = dir($img_folder);
	
	//read all files from the  directory, checks if are images and ads them to a list (see below how to display flash banners)
	while ($file = $imgs->read()) 
	{
		if(strpos(strtoupper($file), '.JPG') > 0 or strpos(strtoupper($file), '.GIF') >0 or strpos(strtoupper($file), '.GIF') > 0 )
		{
			$imglist .= "$file ";
		}
	} 
	closedir($imgs->handle);
	
	//put all images into an array
	$imglist = explode(" ", $imglist);
	$no = sizeof($imglist)-2;
	
	if($no >= 0)
	{
		//generate a random number between 0 and the number of images
		$random = mt_rand(0, $no);
		$image = $imglist[$random];
		$mainsiteurl =	get_option('siteurl') . "/wp-content/plugins/random-image-gallery-with-fancy-zoom/";
		
		$rigwfz_width =	get_option('rigwfz_width');
		if(!is_numeric($rigwfz_width))
		{
			$rigwfz_width = 180;
		} 
		$rigwfz = "";
		$myrand = rand(1, 15);
		global $ScriptInserted;
		//if (!isset($ScriptInserted) || $ScriptInserted !== true)
		//{
			$ScriptInserted = true;
			$rigwfz = $rigwfz . ' <script type="text/javascript"> ';
			$rigwfz = $rigwfz . ' jQuery(function(){ ';
			$rigwfz = $rigwfz . " jQuery.fn.fancyzoom.defaultsOptions.imgDir='".$mainsiteurl."ressources/';";
			$rigwfz = $rigwfz . " jQuery('#nooverlay".$myrand."').fancyzoom({Speed:400,showoverlay:false}); ";
			$rigwfz = $rigwfz . ' }); ';
			$rigwfz = $rigwfz . ' </script> ';
		//}
		
		$rigwfz = $rigwfz . '<div>';
		$rigwfz = $rigwfz . '<a href="'.$rigwfz_siteurl . $image .'" id="nooverlay'.$myrand.'">';
		$rigwfz = $rigwfz . '<img src="'.$mainsiteurl.'crop-random-image.php?AC=YES&DIR='.$rigwfz_dir.'&IMGNAME='.$image.'&MAXWIDTH='.$rigwfz_width.'"> ';
		$rigwfz = $rigwfz . '</a>';
		$rigwfz = $rigwfz . '</div>';
	}
	else
	{
		$rigwfz = __('No image found in the folder', 'random-image-gallery');
	}
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
	?>
	<div class="wrap">
		<div class="form-wrap">
			<div id="icon-edit" class="icon32 icon32-posts-post"></div>
			<h2><?php _e('Random image gallery with fancy zoom', 'random-image-gallery'); ?></h2>
			<h3><?php _e('Settings', 'random-image-gallery'); ?></h3>
			<?php
			$rigwfz_title = get_option('rigwfz_title');
			$rigwfz_width = get_option('rigwfz_width');
			$rigwfz_dir = get_option('rigwfz_dir');
			$rigwfz_title_yes = get_option('rigwfz_title_yes');		
			if (isset($_POST['rigwfz_form_submit']) && $_POST['rigwfz_form_submit'] == 'yes')
			{
				check_admin_referer('rigwfz_form_setting');	
				$rigwfz_title = stripslashes($_POST['rigwfz_title']);
				$rigwfz_width = stripslashes($_POST['rigwfz_width']);
				$rigwfz_dir = stripslashes($_POST['rigwfz_dir']);
				$rigwfz_title_yes = stripslashes($_POST['rigwfz_title_yes']);
				update_option('rigwfz_title', $rigwfz_title );
				update_option('rigwfz_width', $rigwfz_width );
				update_option('rigwfz_dir', $rigwfz_dir );
				update_option('rigwfz_title_yes', $rigwfz_title_yes );	
				?>
				<div class="updated fade">
					<p><strong><?php _e('Details successfully updated.', 'random-image-gallery'); ?></strong></p>
				</div>
				<?php
			}
			?>
			<form name="rigwfz_form" method="post" action="">
			
			<label for="tag-title"><?php _e('Enter widget title', 'random-image-gallery'); ?></label>
			<input name="rigwfz_title" id="rigwfz_title" type="text" value="<?php echo $rigwfz_title; ?>" size="50" maxlength="150" />
			<p><?php _e('Please enter your widget title.', 'random-image-gallery'); ?></p>
			
			<label for="tag-title"><?php _e('Width', 'random-image-gallery'); ?></label>
			<input name="rigwfz_width" id="rigwfz_width" type="text" value="<?php echo $rigwfz_width; ?>" maxlength="3" />
			<p><?php _e('Please enter your image width.', 'random-image-gallery'); ?></p>
			
			<label for="tag-title"><?php _e('Sidebar title display', 'random-image-gallery'); ?></label>
			<select name="rigwfz_title_yes" id="rigwfz_title_yes">
				<option value='YES'  <?php if($rigwfz_title_yes == 'YES') { echo "selected='selected'" ; } ?>>YES</option>
				<option value='NO' <?php if($rigwfz_title_yes == 'NO') { echo "selected='selected'" ; } ?>>NO</option>
			</select>
			<p><?php _e('Do you want to show title on your sidebar? This option is only for widget.', 'random-image-gallery'); ?></p>
			
			<label for="tag-title"><?php _e('Image directory', 'random-image-gallery'); ?></label>
			<input name="rigwfz_dir" id="rigwfz_dir" type="text" value="<?php echo $rigwfz_dir; ?>" size="100" maxlength="150" />
			<p><?php _e('Please enter your image directory. In which directory you have all your images?', 'random-image-gallery'); ?>
			(Ex: wp-content/plugins/random-image-gallery-with-fancy-zoom/random-gallery/)
			</p>
			
			<p style="padding-top:8px;">
				<input name="rigwfz_submit" id="rigwfz_submit" class="button" value="<?php _e('Submit', 'random-image-gallery'); ?>" type="submit" />
				<input type="hidden" name="rigwfz_form_submit" value="yes"/>
				<?php wp_nonce_field('rigwfz_form_setting'); ?>
			</p>
			</form>
		</div>
		<h3><?php _e('Plugin configuration option', 'random-image-gallery'); ?></h3>
		<ol>
			<li><?php _e('Add directly in to the theme using PHP code.', 'random-image-gallery'); ?></li>
			<li><?php _e('Drag and drop the widget to your sidebar.', 'random-image-gallery'); ?></li>
			<li><?php _e('Add the images in the posts or pages using short code.', 'random-image-gallery'); ?></li>
		</ol>
		<p class="description"><?php _e('Check official website for more information', 'random-image-gallery'); ?> 
		<a target="_blank" href="http://www.gopiplus.com/work/2010/07/18/random-image-gallery-with-fancy-zoom/"><?php _e('click here', 'random-image-gallery'); ?></a></p>
	</div>
	<?php
}

function rigwfz_control()
{
	echo '<p><b>';
	_e('message ticker', 'random-image-gallery');
	echo '.</b> ';
	_e('Check official website for more information', 'random-image-gallery');
	?> <a target="_blank" href="http://www.gopiplus.com/work/2010/07/18/random-image-gallery-with-fancy-zoom/"><?php _e('click here', 'random-image-gallery'); ?></a></p><?php
}

function rigwfz_widget_init() 
{
	if(function_exists('wp_register_sidebar_widget')) 	
	{
		wp_register_sidebar_widget('rigwfz', __('FancyZoom images', 'random-image-gallery'), 'rigwfz_widget');
	}
	
	if(function_exists('wp_register_widget_control')) 	
	{
		wp_register_widget_control('rigwfz', array( __('FancyZoom images', 'random-image-gallery'), 'widgets'), 'rigwfz_control');
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
	if (is_admin()) 
	{
		add_options_page( __('FancyZoom images', 'random-image-gallery'), 
				__('FancyZoom images', 'random-image-gallery'), 'manage_options', 'random-image-gallery-with-fancy-zoom', 'rigwfz_admin_option' );
	}
}

function rigwfz_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'jquery.fancyzoom.min', get_option('siteurl').'/wp-content/plugins/random-image-gallery-with-fancy-zoom/js/jquery.fancyzoom.min.js');
	}	
}

function rigwfz_textdomain() 
{
	  load_plugin_textdomain( 'random-image-gallery', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action('plugins_loaded', 'rigwfz_textdomain');
add_action('admin_menu', 'rigwfz_add_to_menu');
add_action('wp_enqueue_scripts', 'rigwfz_add_javascript_files');
add_action("plugins_loaded", "rigwfz_widget_init");
register_activation_hook(__FILE__, 'rigwfz_install');
register_deactivation_hook(__FILE__, 'rigwfz_deactivation');
add_action('init', 'rigwfz_widget_init');
?>