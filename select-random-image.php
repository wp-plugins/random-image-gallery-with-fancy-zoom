<?php

/**
 *     Random image gallery with fancy zoom
 *     Copyright (C) 2011 - 2015 www.gopiplus.com
 *     http://www.gopiplus.com/work/2010/07/18/random-image-gallery-with-fancy-zoom/
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
 
//$rigwfz_abspath = dirname(__FILE__);
$rigwfz_dir = get_option('rigwfz_dir');

$rigwfz_siteurl = get_option('siteurl') . "/" . $rigwfz_dir ;

$imglist='';
//$img_folder is the variable that holds the path to the banner images. Mine is images/tutorials/
// see that you don't forget about the "/" at the end 
$img_folder = $rigwfz_dir;

mt_srand((double)microtime()*1000);

if(!is_dir($img_folder))
{
	_e('Image folder does not exists', 'random-image-gallery-with-fancy-zoom');
	return true;
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
	
	//display image
	echo '<div>';
	echo '<a href="'.$rigwfz_siteurl . $image .'" id="nooverlay">';
	echo '<img src="'.$mainsiteurl.'crop-random-image.php?AC=YES&DIR='.$rigwfz_dir.'&IMGNAME='.$image.'&MAXWIDTH='.$rigwfz_width.'"> ';
	echo '</a>';
	echo '</div>';
}
else
{
	_e('No image found in the folder', 'random-image-gallery-with-fancy-zoom');
}
 ?>