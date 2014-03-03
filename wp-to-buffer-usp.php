<?php
/**
* Plugin Name: WP to Buffer: USP Connector
* Plugin URI: http://www.wpcube.co.uk/plugins/wordpress-to-buffer-pro
* Version: 1.0
* Author: WP Cube
* Author URI: http://www.wpcube.co.uk
* Description: Connects the User Submitted Posts Plugin with WP to Buffer, ensuring User Submitted Posts are published to Buffer.
* License: GPL2
*/

/**
* When a Post meta key is updated, checks if it is an USP meta key
* and that the Post has been published (i.e. isn't pending or awaiting
* moderation). If the Post is published, this function calls the 
* WP to Buffer publish() function, which will publish to Buffer if the plugin's
* settings permit this.
*/
function uspWPToBufferConnector($meta_id, $object_id, $meta_key, $meta_value) {
	global $WPToBuffer;
	
	// Check key and value is from USP
	if ($meta_key != 'is_submission') return;
	if (!$meta_value) return;
	
	// Check Post is published and not a draft or pending
	$post = get_post($object_id);
	if ($post->post_status != 'publish') return;
	
	// Buffer
	$WPToBuffer->publish($object_id, true);
}
add_action('added_post_meta', 'uspWPToBufferConnector', 1, 4);
?>
