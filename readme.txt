=== Random image gallery with fancy zoom ===
Contributors: Gopi.R 
Donate link: http://gopi.coolpage.biz/demo/2009/08/29/random-image-gallery-with-fancy-zoom/
Author URI: http://gopi.coolpage.biz/demo/about/
Plugin URI: http://gopi.coolpage.biz/demo/2009/08/29/random-image-gallery-with-fancy-zoom/
Tags: image, random, rotating, fancy zoom, effect, gallery, plugin, sidebar,
Requires at least: 2.8
Tested up to: 2.8.4
Stable tag: 1.0
	
This plug-in which allows you to simply and easily show random image 
anywhere in your template files or using widgets with onclick fancy zoom effect.

== Description ==

[Live Demo](http://gopi.coolpage.biz/demo/2009/08/29/random-image-gallery-with-fancy-zoom/)	 	
[More info](http://gopi.coolpage.biz/demo/2009/08/29/random-image-gallery-with-fancy-zoom/)		 		
[Comments/Suggestion](http://gopi.coolpage.biz/demo/2009/08/29/random-image-gallery-with-fancy-zoom/)	 	
[About author](http://gopi.coolpage.biz/demo/about/) 	

The "Random image gallery with fancy zoom" plug-in which allows you to simply and easily show random image Anywhere in your template files or using widgets with onclick fancy zoom effect. You can upload the images directly into 
The folder or you can set the existing image folder; this will automatically generate the thumbnail image.

We can use this plug-in in two different way.
1. Go to widget menu and drag and drop the "R I G W F Z" widget to your sidebar location. or 
2. Copy and past the below mentioned code to your desired template location.
		
<code><?php if (function_exists (rigwfz_show)) rigwfz_show(); ?></code>

**Feature**   	
1. Simple. 	
2. Easy installation.   	
3. Fancy zoom effect.   
3. Random image.   
3. Automatic thumbnail image.

**To Update the Scrolling setting:**   
Go to 'R I G W F Z' link under SETTINGS TAB. 		

== Installation ==

**Installation Instruction & Configuration**  

* Unpack the *.zip file and extract the /random-image-gallery-with-fancy-zoom/ folder.    
* Drop the 'random-image-gallery-with-fancy-zoom' folder into your 'wp-content/plugins' folder    
* In word press administration panels, click on plug-in from the menu.    
* You should see your new 'Random image gallery with fancy zoom' plug-in listed under Inactive plug-in tab.    
* To turn the word presses plug-in on, click activate.    
* Go to 'R I G W F Z' link under SETTINGS TAB to update the setting.
* Copy and paste the mentioned code to your desired template location or drag and drop the widget!.  
<code><?php if (function_exists (rigwfz_show)) rigwfz_show(); ?></code>

== Frequently Asked Questions ==

**Thumbnail not display?**  
To create thumbnail the “GD support” must be enabled to your PHP setting (its default enabled mode, if not please check your phpinfo file and contact your server).  
  
**Where to change the thumbnail width**  
Go to 'R I G W F Z' link under SETTINGS TAB to update the setting, the height of the image automatically resized based on your width.  

**Close button not display in light box effect?** 
Open "rigwfz_js/FancyZoom.js" file and set full path to mentioned variables zoomImagesURI .

"wp-content/plugins/random-image-gallery-with-fancy-zoom/rigwfz_img/"

to

"http://yourwebsitename.com/wp-content/plugins/random-image-gallery-with-fancy-zoom/rigwfz_img/"

== Screenshots ==

1. admin setting page.

2. front end without light box.

3. front end with light box.

== Changelog ==

1.0	 first version