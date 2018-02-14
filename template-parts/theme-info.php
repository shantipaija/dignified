<?php
/**
 * Displays footer site info
 *
 * @package WordPress
 * @subpackage dignified
 * @since 1.0
 * @version 1.0
 */

?>
<div class="site-info">
	<a href="<?php echo esc_url( __( 'https://www.wp.login.plus/doc/dignified-doc/', 'dignified' ) ); ?>"><?php printf( __( '%s', 'dignified' ), 'dignified' ); ?></a>
	<a href="<?php echo esc_url( __( 'https://www.wp.login.plus/', 'dignified' ) ); ?>"><?php printf( __( 'theme by %s', 'dignified' ), 'wp.login.plus' ); ?></a> |
	<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'dignified' ) ); ?>"><?php printf( __( 'Powered by %s', 'dignified' ), 'WordPress' ); ?></a>
</div><!-- .site-info -->
