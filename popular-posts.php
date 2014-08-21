<?php
/*
Plugin Name: Tony's Portfolio Popular Post Widget
Plugin URI: https://github.com/tonyedwardspz/popular-post-plugin
Description: A super simple plugin to display popular posts
Version: 1.0
Author: Tony Edwards
Author URI: http://www.purelywebdesign.co.uk
Licence: GPL2
*/


// get the current number of views and add 1 each time.
// use the wp_head hook to call the function
function popular_add_view(){
	
	if (is_single()) {

		// get the current number of views
		global $post;
		$current_views = get_post_meta($post->ID, "pop_post_views", true);
		
		// if its not already set, set it to 0
		if (!isset($current_views) OR empty($current_views) OR !is_numeric($current_views)){
			$current_views = 0;
		}
		$new_views = $current_views + 1;
		update_post_meta($post->ID, "pop_post_views", $new_views);
		return $new_views;
	}
}
add_action("wp_head", "popular_add_view");

// get the current number of views
function popular_get_view_count(){
	global $post;
	$current_views = get_post_meta($post->ID, "pop_post_views", true);
	if(!isset($current_views) OR empty($current_views) OR !is_numeric($current_views)){
		$current_views = 0;
	}
	return $current_views;
}

// find the current number of views for a post and display it
function popular_show_views($singular = "view", $plural = "views", 
	$before = "This post has: "){

	global $post;
	$current_views = popular_get_view_count();

	$views_text = $before . $current_views . " ";

	if($current_views == 1){
		$views_text .= $singular;
	}
	else{
		$views_text .= $plural;
	}

	echo $views_text;
}

// display a list of posts ordered by popularity
function popular_popularity_list($post_count = 10){
	$args = array(
		"posts_per_page" => 10,
		"post_type" => "post",
		"post_status" => "publish",
		"meta_key" => "pop_post_views",
		"orderby" => "meta_value_num",
		"order" => "DESC"
	);

	// get the popular posts
	$popular_list = new WP_Query($args);

	if($popular_list -> have_posts()){
		echo '<ul class="popular-posts">';
	}

	// while there are posts remaining, loop through them, creatin list items
	while ($popular_list -> have_posts()) : $popular_list -> the_post();
		echo '<li><a href="'.get_permalink($post -> ID).'">'.the_title('','', false).'</a></li>';
	endwhile;

	if ($popular_list -> have_posts()){
		echo '</ul>';
	}
}

?>