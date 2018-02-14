<?php

add_action( 'customize_register', 'dignified_welcome_customize_register' );

function dignified_welcome_customize_register( $wp_customize ) {

		global $dignified_required_actions, $dignified_recommended_plugins;
		$theme_slug = 'dignified';
		$customizer_recommended_plugins = array();
	if ( is_array( $dignified_recommended_plugins ) ) {
		foreach ( $dignified_recommended_plugins as $k => $s ) {
			if ( $s['recommended'] ) {
				$customizer_recommended_plugins[ $k ] = $s;
			}
		}
	}

		$wp_customize->add_section(
			new Epsilon_Section_Recommended_Actions(
				$wp_customize,
				'epsilon_recomended_section',
				array(
					'title'                         => esc_html__( 'Recomended Actions', 'dignified' ),
					'social_text'                   => esc_html__( 'We are social :', 'dignified' ),
					'plugin_text'                   => esc_html__( 'Recomended Plugins :', 'dignified' ),
					'actions'                       => $dignified_required_actions,
					'plugins'                       => $customizer_recommended_plugins,
					'theme_specific_option'         => $theme_slug . '_show_required_actions',
					'theme_specific_plugin_option'  => $theme_slug . '_show_recommended_plugins',
					'facebook'                      => '//www.facebook.com/LogHQ/',
					'twitter'                       => '//www.twitter.com/logHQ/',
					'wp_review'                     => false,  // Review this theme on w.org
					'priority'                      => 0,
				)
			)
		);

		$wp_customize->add_section(
			new Epsilon_Section_Pro(
				$wp_customize,
				'epsilon-section-pro',
				array(
					'title'       => esc_html__( 'Dignified', 'dignified' ),
					'button_text' => esc_html__( 'Documentation', 'dignified' ),
					'button_url'  => esc_url_raw( 'https://wp.login.plus/doc/dignified/' ),
					'priority'    => 0,
				)
			)
		);

}

add_action( 'customize_controls_enqueue_scripts', 'dignified_welcome_scripts_for_customizer', 0 );

function dignified_welcome_scripts_for_customizer() {
	wp_enqueue_style( 'dignified-welcome-screen-customizer-css', get_template_directory_uri() . '/inc/welcome-screen/css/welcome_customizer.css' );
	wp_enqueue_style( 'plugin-install' );
	wp_enqueue_script( 'plugin-install' );
	wp_enqueue_script( 'updates' );
	wp_add_inline_script( 'plugin-install', 'var pagenow = "customizer";' );
	wp_enqueue_script( 'dignified-welcome-screen-customizer-js', get_template_directory_uri() . '/inc/welcome-screen/js/welcome_customizer.js', array( 'customize-controls' ), '1.0', true );

	wp_localize_script( 'dignified-welcome-screen-customizer-js', 'dignifiedWelcomeScreenObject', array(
		'ajaxurl'                  => admin_url( 'admin-ajax.php' ),
		'template_directory'       => get_template_directory_uri(),
	) );

}

// Load the system checks ( used for notifications )
require get_template_directory() . '/inc/welcome-screen/class-dignified-notify-system.php';

// Welcome screen
if ( is_admin() ) {
	global $dignified_required_actions, $dignified_recommended_plugins;
	$dignified_recommended_plugins = array(
		'notice-box-loghq'    => array(
			'recommended' => true,
		),
	);
	/*
	 * id - unique id; required
	 * title
	 * description
	 * check - check for plugins (if installed)
	 * plugin_slug - the plugin's slug (used for installing the plugin)
	 *
	 */


	$dignified_required_actions = array();
	require get_template_directory() . '/inc/welcome-screen/class-dignified-welcome.php';
}// End if().
