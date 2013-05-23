<?php
/*
Plugin Name: WP Video Lightbox
Version: 1.5
Plugin URI: http://www.tipsandtricks-hq.com/?p=2700
Author: Tips and Tricks HQ, Ruhul Amin
Author URI: http://www.tipsandtricks-hq.com/
Description: Simple video lightbox plugin to display videos in a nice overlay popup. It also supports images, flash, YouTube, iFrame.
*/
define('WP_LICENSE_MANAGER_VERSION', "1.5");
define('WP_VID_LIGHTBOX_URL', plugins_url('',__FILE__));

add_shortcode('video_lightbox_vimeo5', 'wp_vid_lightbox_vimeo5_handler');
add_shortcode('video_lightbox_youtube', 'wp_vid_lightbox_youtube_handler');

function wp_vid_lightbox_vimeo5_handler($atts) 
{
	extract(shortcode_atts(array(
		'video_id' => '',
		'width' => '',	
		'height' => '',
		'anchor' => '',	
	), $atts));
	if(empty($video_id) || empty($width) || empty($height) ||empty($anchor)){
		return "<p>Error! You must specify a value for the Video ID, Width, Height and Anchor parameters to use this shortcode!</p>";
	}
	
	if (preg_match("/http/", $anchor)){ // Use the image as the anchor
    	$anchor_replacement = '<img src="'.$anchor.'" class="video_lightbox_anchor_image" alt="" />';
    }
    else    {
    	$anchor_replacement = $anchor;
    }    
    $href_content = 'http://vimeo.com/'.$video_id.'?width='.$width.'&amp;height='.$height;		
	$output = "";
	$output .= '<a rel="wp-video-lightbox" href="'.$href_content.'" title="">'.$anchor_replacement.'</a>';	
	return $output;
}

function wp_vid_lightbox_youtube_handler($atts)
{
	extract(shortcode_atts(array(
		'video_id' => '',
		'width' => '',	
		'height' => '',
		'anchor' => '',	
	), $atts));
	if(empty($video_id) || empty($width) || empty($height) ||empty($anchor)){
		return "<p>Error! You must specify a value for the Video ID, Width, Height and Anchor parameters to use this shortcode!</p>";
	}
	
	if (preg_match("/http/", $anchor)){ // Use the image as the anchor
    	$anchor_replacement = '<img src="'.$anchor.'" class="video_lightbox_anchor_image" alt="" />';
    }
    else{
    	$anchor_replacement = $anchor;
    }
    $href_content = 'http://www.youtube.com/watch?v='.$video_id.'&amp;width='.$width.'&amp;height='.$height;
	$output = '<a rel="wp-video-lightbox" href="'.$href_content.'" title="">'.$anchor_replacement.'</a>';
	return $output;
}

function wp_vid_lightbox_init()
{
    if (!is_admin()) 
    {
		wp_enqueue_script('jquery');
		wp_register_script('jquery.prettyphoto', WP_VID_LIGHTBOX_URL.'/js/jquery.prettyPhoto.js', array('jquery'), '3.1.4');
		wp_enqueue_script('jquery.prettyphoto');
		wp_register_script('video-lightbox', WP_VID_LIGHTBOX_URL.'/js/video-lightbox.js', array('jquery'), '3.1.4');
		wp_enqueue_script('video-lightbox');
		wp_register_style('jquery.prettyphoto', WP_VID_LIGHTBOX_URL.'/css/prettyPhoto.css');
		wp_enqueue_style('jquery.prettyphoto');
    }
}

add_action('init', 'wp_vid_lightbox_init');
