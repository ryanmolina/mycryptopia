<?php
/**
 * Child-Theme functions and definitions
 */

function crypton_blog_child_scripts() {
    wp_enqueue_style('crypton_blog-parent-style', get_template_directory_uri(). '/style.css' );
    wp_enqueue_script('helper-script', get_stylesheet_directory_uri(). '/js/helper.js', null, null, true);
    wp_enqueue_script('ico-calendar-script', get_stylesheet_directory_uri(). '/js/ico-calendar.js', array('jquery'), null, true); 
    wp_enqueue_script('marketcap-script', get_stylesheet_directory_uri(). '/js/marketcap.js', array('jquery'), null, true);
    wp_enqueue_script('tablesorter-jquery', "https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.14/js/jquery.tablesorter.min.js", array('jquery'), null, true);
}
add_action( 'wp_enqueue_scripts', 'crypton_blog_child_scripts' );


function defer_parsing_of_js ( $url ) {
	if ( FALSE === strpos( $url, '.js' ) ) return $url;
	if ( strpos( $url, 'jquery.js' ) ) return $url;
	return "$url' defer ";
}
add_filter( 'clean_url', 'defer_parsing_of_js', 11, 1 ); 
?>