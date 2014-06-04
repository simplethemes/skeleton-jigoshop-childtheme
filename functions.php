<?php
/**
 * @package Skeleton WordPress Theme Framework
 * @subpackage skeleton
 * @author Simple Themes - www.simplethemes.com
 *
 * Layout Hooks:
 *
 * skeleton_above_header // Opening header wrapper
 * skeleton_header // header tag and logo/header text
 * skeleton_header_extras // Additional content may be added to the header
 * skeleton_below_header // Closing header wrapper
 * skeleton_navbar // main menu wrapper
 * skeleton_before_content // Opening content wrapper
 * skeleton_after_content // Closing content wrapper
 * skeleton_before_sidebar // Opening sidebar wrapper
 * skeleton_after_sidebar // Closing sidebar wrapper
 * skeleton_footer // Footer
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, skeleton_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage skeleton
 * @since skeleton 2.0
 */

// remove default jigoshop wrappers
remove_action( 'jigoshop_before_main_content', 'jigoshop_output_content_wrapper', 10);
remove_action( 'jigoshop_after_main_content', 'jigoshop_output_content_wrapper_end', 10);

// add skeleton wrappers
add_action('jigoshop_before_main_content', 'skeleton_content_wrap', 10);
add_action('jigoshop_after_main_content', 'skeleton_content_wrap_close', 10);

// disable default jigoshop styles

function skeleton_unload_jigoshop_styles() {
	wp_dequeue_style( 'jigoshop_styles');
	wp_dequeue_style( 'jigoshop_theme_styles');
}
add_filter ('wp_enqueue_scripts','skeleton_unload_jigoshop_styles');


// add jigoshop styles from theme level

function skeleton_load_jigoshop_styles() {
	wp_enqueue_style('skeleton_jigoshop_styles', get_stylesheet_directory_uri().'/jigoshop/css/frontend.css', array(), '1.0', 'screen, projection');
}
add_filter ('wp_enqueue_scripts','skeleton_load_jigoshop_styles');

// override theme thumbnailer so that jigoshop can handle the featured image display

function skeleton_thumbnailer($content) {
	global $post;
	global $id;
	$size = 'squared150';
	$align = 'alignleft scale-with-grid';
	$image = get_the_post_thumbnail($id, $size, array('class' => $align));
	if (is_page() || is_single()) {
	$content =  $image . $content;
	}
	return $content;
}
add_filter('the_content','skeleton_thumbnailer');


?>