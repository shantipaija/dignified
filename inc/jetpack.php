<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package dignified
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function dignified_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'type'      => 'click',
		'container' => 'main',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'dignified_jetpack_setup' );
