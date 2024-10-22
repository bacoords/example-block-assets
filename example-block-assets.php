<?php
/**
 * Plugin Name: Example Block Assets
 * Description: A plugin to demonstrate block assets in WordPress.
 * Version: 1.0.0
 * Author: Brian Coords
 * Author URI: https://www.briancoords.com
 * Text Domain: example-block-assets
 *
 * @package example-block-assets
 */

namespace ExampleBlockAssets;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register custom JavaScript.
 */
function register_custom_javascript() {
	// Register the custom JavaScript file.
	wp_register_script(
		'example-block-assets',
		plugins_url( 'example-block-assets.js', __FILE__ ),
		array(),
		filemtime( plugin_dir_path( __FILE__ ) . 'example-block-assets.js' ),
		true
	);
}
add_action( 'init', __NAMESPACE__ . '\register_custom_javascript' );




/**
 * Enqueue custom assets for specific blocks.
 *
 * @param array $metadata The block metadata.
 * @return array The filtered block metadata.
 */
function filter_core_button_block_metadata( $metadata ) {

	// If the block is a core/button block add the custom assets.
	if ( 'core/button' === $metadata['name'] ) {
		$metadata['viewScript'] = array_merge(
			(array) ( $metadata['viewScript'] ?? array() ),
			array( 'example-block-assets' )
		);
	}
	return $metadata;
}
add_filter( 'block_type_metadata', __NAMESPACE__ . '\filter_core_button_block_metadata' );




/**
 * Register custom CSS.
 */
function register_custom_css() {

	// Register the custom CSS file.
	wp_register_style(
		'example-block-assets',
		plugins_url( 'example-block-assets.css', __FILE__ ),
		array(),
		filemtime( plugin_dir_path( __FILE__ ) . 'example-block-assets.css' )
	);

	wp_enqueue_block_style(
		'core/button',
		array(
			'handle' => 'example-block-assets',
		)
	);
}
add_action( 'init', __NAMESPACE__ . '\register_custom_css' );
