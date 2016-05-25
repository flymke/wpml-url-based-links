<?php
/*
Plugin Name: WPML URL-based links
Description: If you use different domains per language (see this <a href="https://wpml.org/faq/server-setting-for-languages-in-different-domains/" target="_blank">link</a>), this plugin will help you that all links, image urls etc. within the content are pointing to the right URL to stay SEO friendly. No configuration necessary. <strong>Note: This is not an official WPML Plugin</strong>.
Author: Michael Schönrock
Author URI: http://www.halloecho.de/
Version: 0.1
Plugin Slug: wpml-url-based-links
*/


/**
 * Changes the URL in the content
 *
 */
function wpml_url_content_filter( $content ) {
		
	global $sitepress;
	
	$sitepress->get_current_language();

	$pattern = '/^(https?:\/\/)?([\da-z\.-]+)(.*)/i';
	
	preg_match($pattern, get_option('home'), $matches, PREG_OFFSET_CAPTURE);
	$current_home_url = $matches[2][0];
	
	preg_match($pattern, icl_get_home_url(), $matches, PREG_OFFSET_CAPTURE);
	$current_wpml_url = $matches[2][0];
	
	if($current_home_url != $current_wpml_url) {
		// different domains per language are used => filter content
		$content = str_ireplace($current_home_url, $current_wpml_url, $content);
	}
	
    // Return the content.
    return $content;
}


if ( function_exists('icl_object_id') ) {
	add_filter( 'the_content', 'wpml_url_content_filter', 20 );
}