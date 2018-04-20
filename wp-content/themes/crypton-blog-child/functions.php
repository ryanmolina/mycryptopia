<?php
/**
 * Child-Theme functions and definitions
 */

function crypton_blog_child_scripts() {
    wp_enqueue_style( 'crypton_blog-parent-style', get_template_directory_uri(). '/style.css' );
    wp_enqueue_script('crypton_blog-parent-script', get_stylesheet_directory_uri(). '/js/ico-calendar.js', array('jquery'), null, true);
}
add_action( 'wp_enqueue_scripts', 'crypton_blog_child_scripts' );
 
?>