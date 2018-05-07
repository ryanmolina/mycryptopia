<?php
/**
 * Child-Theme functions and definitions
 */
@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );

function crypton_blog_child_scripts() {
	$parent_style = 'crypton_blog-parent-style';
    wp_enqueue_style($parent_style, get_template_directory_uri(). '/style.css' );
    wp_enqueue_style('crypton_blog-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
    wp_enqueue_script('helper-script', get_stylesheet_directory_uri(). '/js/helper.js', null, null, true);
    wp_enqueue_script('ico-calendar-script', get_stylesheet_directory_uri(). '/js/ico-calendar.js', array('jquery'), null, true); 
    wp_enqueue_script('marketcap-script', get_stylesheet_directory_uri(). '/js/marketcap.js', array('jquery'), null, true);
    wp_enqueue_script('tablesorter-jquery', "https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.14/js/jquery.tablesorter.min.js", array('jquery'), null, true);
}
add_action( 'wp_enqueue_scripts', 'crypton_blog_child_scripts' );


?>