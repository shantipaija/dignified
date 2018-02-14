<?php
/**
 * dignified Customizer
 *
 * @package dignified
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function dignified_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->remove_control('header_textcolor');
	$wp_customize->remove_control('background_color');
}
add_action( 'customize_register', 'dignified_customize_register' );

/**
 * Options for dignified Customizer.
 */
function dignified_customizer( $wp_customize ) {

	/* Main option Settings Panel */
	$wp_customize->add_panel('dignified_main_options', array(
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Dignified Options', 'dignified' ),
		'description' => __( 'Panel to update dignified theme options', 'dignified' ), // Include html tags such as <p>.
		'priority' => 10,// Mixed with top-level-section hierarchy.
	));


	/* Main option Settings Panel */
	$wp_customize->add_panel('dignified_homepage_options', array(
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Dignified HomePage Options', 'dignified' ),
		'description' => __( 'Panel to update dignified homepage options', 'dignified' ), // Include html tags such as <p>.
		'priority' => 10,// Mixed with top-level-section hierarchy.
	));

	// add "Content Options" section
	$wp_customize->add_section( 'dignified_content_section' , array(
		'title'      => esc_html__( 'Content Options', 'dignified' ),
		'priority'   => 50,
		'panel' => 'dignified_main_options',
	) );
	// add setting for excerpts/full posts toggle
	$wp_customize->add_setting( 'dignified_excerpts', array(
		'default'           => 0,
		'sanitize_callback' => 'dignified_sanitize_checkbox',
	) );
	// add checkbox control for excerpts/full posts toggle
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'dignified_excerpts', array(
		'label'     => esc_html__( 'Show post excerpts in Home, Archive, and Category pages', 'dignified' ),
		'section'   => 'dignified_content_section',
		'priority'  => 10,
		'type'      => 'epsilon-toggle',
	) ) );

	$wp_customize->add_setting( 'dignified_page_comments', array(
		'default' => 1,
		'sanitize_callback' => 'dignified_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'dignified_page_comments', array(
		'label'     => esc_html__( 'Display Comments on Static Pages?', 'dignified' ),
		'section'   => 'dignified_content_section',
		'priority'  => 20,
		'type'      => 'epsilon-toggle',
	) ) );


	// add setting for Show/Hide posts date toggle
	$wp_customize->add_setting( 'dignified_post_date', array(
		'default'           => 1,
		'sanitize_callback' => 'dignified_sanitize_checkbox',
	) );
	// add checkbox control for Show/Hide posts date toggle
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'dignified_post_date', array(
		'label'     => esc_html__( 'Show post date?', 'dignified' ),
		'section'   => 'dignified_content_section',
		'priority'  => 30,
		'type'      => 'epsilon-toggle',
	) ) );

	// add setting for Show/Hide posts Author Bio toggle
	$wp_customize->add_setting( 'dignified_post_author_bio', array(
		'default'           => 1,
		'sanitize_callback' => 'dignified_sanitize_checkbox',
	) );
	// add checkbox control for Show/Hide posts Author Bio toggle
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'dignified_post_author_bio', array(
		'label'     => esc_html__( 'Show Author Bio?', 'dignified' ),
		'section'   => 'dignified_content_section',
		'priority'  => 40,
		'type'      => 'epsilon-toggle',
	) ) );



	/* dignified Main Options */
	$wp_customize->add_section('dignified_slider_options', array(
		'title' => __( 'Slider options', 'dignified' ),
		'priority' => 31,
		'panel' => 'dignified_homepage_options',
	));
	$wp_customize->add_setting( 'dignified[dignified_slider_checkbox]', array(
		'default' => 0,
		'type' => 'option',
		'sanitize_callback' => 'dignified_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'dignified[dignified_slider_checkbox]', array(
		'label' => esc_html__( 'Check if you want to enable slider', 'dignified' ),
		'section'   => 'dignified_slider_options',
		'priority'  => 5,
		'type'      => 'epsilon-toggle',
	) ) );
	$wp_customize->add_setting( 'dignified[dignified_slider_link_checkbox]', array(
		'default' => 1,
		'type' => 'option',
		'sanitize_callback' => 'dignified_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'dignified[dignified_slider_link_checkbox]', array(
		'label' => esc_html__( 'Turn "off" this option to remove the link from the slides', 'dignified' ),
		'section'   => 'dignified_slider_options',
		'priority'  => 6,
		'type'      => 'epsilon-toggle',
	) ) );

	// Pull all the categories into an array
	global $options_categories;
	$wp_customize->add_setting('dignified[dignified_slide_categories]', array(
		'default' => '',
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'dignified_sanitize_slidecat',
	));
	$wp_customize->add_control('dignified[dignified_slide_categories]', array(
		'label' => __( 'Slider Category', 'dignified' ),
		'section' => 'dignified_slider_options',
		'type'    => 'select',
		'description' => __( 'Select a category for the featured post slider', 'dignified' ),
		'choices'    => $options_categories,
	));

	$wp_customize->add_setting('dignified[dignified_slide_number]', array(
		'default' => 3,
		'type' => 'option',
		'sanitize_callback' => 'dignified_sanitize_number',
	));
	$wp_customize->add_control('dignified[dignified_slide_number]', array(
		'label' => __( 'Number of slide items', 'dignified' ),
		'section' => 'dignified_slider_options',
		'description' => __( 'Enter the number of slide items', 'dignified' ),
		'type' => 'text',
	));
/*
	$wp_customize->add_setting('dignified[dignified_slide_height]', array(
		'default' => 500,
		'type' => 'option',
		'sanitize_callback' => 'dignified_sanitize_number',
	));
	$wp_customize->add_control('dignified[dignified_slide_height]', array(
		'label' => __( 'Height of slider ', 'dignified' ),
		'section' => 'dignified_slider_options',
		'description' => __( 'Enter the height for slider', 'dignified' ),
		'type' => 'text',
	));
*/
	$wp_customize->add_section('dignified_layout_options', array(
		'title' => __( 'Layout Options', 'dignified' ),
		'priority' => 31,
		'panel' => 'dignified_main_options',
	));
	$wp_customize->add_section('dignified_style_color_options', array(
		'title' => __( 'Color Schemes', 'dignified' ),
		'priority' => 31,
		'panel' => 'dignified_main_options',
	));

	// Layout options
	global $site_layout;
	$wp_customize->add_setting('dignified[site_layout]', array(
		'default' => 'side-pull-left',
		'type' => 'option',
		'sanitize_callback' => 'dignified_sanitize_layout',
	));
	$wp_customize->add_control('dignified[site_layout]', array(
		'label' => __( 'Website Layout Options', 'dignified' ),
		'section' => 'dignified_layout_options',
		'type'    => 'select',
		'description' => __( 'Choose between different layout options to be used as default', 'dignified' ),
		'choices'    => $site_layout,
	));

	// Colorful Template Styles options
	global $style_color;
	$wp_customize->add_setting('dignified[style_color]', array(
		'default' => 'white',
		'type' => 'option',
		'sanitize_callback' => 'dignified_sanitize_template',
	));
	$wp_customize->add_control('dignified[style_color]', array(
		'label' => __( 'Color Schemes', 'dignified' ),
		'section' => 'dignified_style_color_options',
		'type'    => 'select',
		'description' => __( 'Choose between different color template options to be used as default', 'dignified' ),
		'choices'    => $style_color,
	));

	//Background color
	$wp_customize->add_setting('dignified[background_color]', array(
		'default' => sanitize_hex_color( 'cccccc' ),
		'type'  => 'option',
		'sanitize_callback' => 'dignified_sanitize_hexcolor',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dignified[background_color]', array(
		'label' => __( 'Background Color', 'dignified' ),
		//'description'   => __( 'Background Color','dignified' ),
		'section' => 'dignified_style_color_options',
	)));

	if ( class_exists( 'WooCommerce' ) ) {
		$wp_customize->add_setting('dignified[woo_site_layout]', array(
			'default' => 'full-width',
			'type' => 'option',
			'sanitize_callback' => 'dignified_sanitize_layout',
		));
		$wp_customize->add_control('dignified[woo_site_layout]', array(
			'label' => __( 'WooCommerce Page Layout Options', 'dignified' ),
			'section' => 'dignified_layout_options',
			'type'    => 'select',
			'description' => __( 'Choose between different layout options to be used as default for all woocommerce pages', 'dignified' ),
			'choices'    => $site_layout,
		));
	}

	$wp_customize->add_setting('dignified[element_color_hover]', array(
		// 'default' => sanitize_hex_color( '#DADADA' ),
		'type'  => 'option',
		'sanitize_callback' => 'dignified_sanitize_hexcolor',
	));


	 /* dignified Call To Action Options */
	$wp_customize->add_section('dignified_action_options', array(
		'title' => __( 'Call To Action (CTA)', 'dignified' ),
		'priority' => 31,
		'panel' => 'dignified_homepage_options',
	));


	$wp_customize->add_setting('dignified[cfa_bg_color]', array(
		// 'default' => sanitize_hex_color( '#FFF' ),
		'type'  => 'option',
		'sanitize_callback' => 'dignified_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dignified[cfa_bg_color]', array(
		'label' => __( 'CTA Section : Background Color', 'dignified' ),
		'description'   => __( 'Default used if no color is selected','dignified' ),
		'section' => 'dignified_action_options',
	)));


	$wp_customize->add_setting('dignified[w2f_cfa_text]', array(
		'default' => '',
		'type' => 'option',
		'sanitize_callback' => 'dignified_sanitize_strip_slashes',
	));
	$wp_customize->add_control('dignified[w2f_cfa_text]', array(
		'label' => __( 'Call To Action - Message Text', 'dignified' ),
		'description' => sprintf( __( 'Enter the text for CTA section', 'dignified' ) ),
		'section' => 'dignified_action_options',
		'type' => 'textarea',
	));


	$wp_customize->add_setting('dignified[cfa_color]', array(
		// 'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
		'type'  => 'option',
		'sanitize_callback' => 'dignified_sanitize_hexcolor',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dignified[cfa_color]', array(
		'label' => __( 'Call To Action - Message Text Color', 'dignified' ),
		'description'   => __( 'Default used if no color is selected','dignified' ),
		'section' => 'dignified_action_options',
	)));


	$wp_customize->add_setting('dignified[w2f_cfa_button]', array(
		'default' => '',
		'type' => 'option',
		'sanitize_callback' => 'dignified_sanitize_nohtml',
	));

	$wp_customize->add_control('dignified[w2f_cfa_button]', array(
		'label' => __( 'CTA Button Text', 'dignified' ),
		'section' => 'dignified_action_options',
		'description' => __( 'Enter the text for CTA button', 'dignified' ),
		'type' => 'text',
	));

	$wp_customize->add_setting('dignified[w2f_cfa_link]', array(
		'default' => '',
		'type' => 'option',
		'sanitize_callback' => 'esc_url_raw',
	));
	$wp_customize->add_control('dignified[w2f_cfa_link]', array(
		'label' => __( 'CTA button link', 'dignified' ),
		'section' => 'dignified_action_options',
		'description' => __( 'Enter the link for CTA button', 'dignified' ),
		'type' => 'text',
	));



	$wp_customize->add_setting('dignified[cfa_btn_txt_color]', array(
		// 'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
		'type'  => 'option',
		'sanitize_callback' => 'dignified_sanitize_hexcolor',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dignified[cfa_btn_txt_color]', array(
		'label' => __( 'CTA Button Text Color', 'dignified' ),
		'description'   => __( 'Default used if no color is selected','dignified' ),
		'section' => 'dignified_action_options',
	)));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dignified[element_color_hover]', array(
		'label' => __( 'CTA Button Color on hover', 'dignified' ),
		'description'   => __( 'Default used if no color is selected','dignified' ),
		'section' => 'dignified_action_options',
		'settings' => 'dignified[element_color_hover]',
	)));

	$wp_customize->add_setting('dignified[cfa_btn_color]', array(
		// 'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
		'type'  => 'option',
		'sanitize_callback' => 'dignified_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dignified[cfa_btn_color]', array(
		'label' => __( 'CTA Button Border Color', 'dignified' ),
		'description'   => __( 'Default used if no color is selected','dignified' ),
		'section' => 'dignified_action_options',
	)));


	/* this setting overrides other buttons */
	/*
		$wp_customize->add_setting('dignified[element_color]', array(
			'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
			'type'  => 'option',
			'sanitize_callback' => 'dignified_sanitize_hexcolor',
		));
		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dignified[element_color]', array(
			'label' => __( 'CTA Button Color', 'dignified' ),
			'description'   => __( 'Default used if no color is selected','dignified' ),
			'section' => 'dignified_action_options',
			'settings' => 'dignified[element_color]',
		)));

		*/
	/* dignified Typography Options */
	$wp_customize->add_section('dignified_typography_options', array(
		'title' => __( 'Typography', 'dignified' ),
		'priority' => 31,
		'panel' => 'dignified_main_options',
	));
	// Typography Defaults
	$typography_defaults = array(
		'size'  => '14px',
		'face'  => 'Open Sans',
		'style' => 'normal',
		'color' => '#6B6B6B',
	);

	// Typography Options
	global $typography_options;
	$wp_customize->add_setting('dignified[main_body_typography][size]', array(
		'default' => $typography_defaults['size'],
		'type' => 'option',
		'sanitize_callback' => 'dignified_sanitize_typo_size',
	));
	$wp_customize->add_control('dignified[main_body_typography][size]', array(
		'label' => __( 'Main Body Text', 'dignified' ),
		'description' => __( 'Used in p tags', 'dignified' ),
		'section' => 'dignified_typography_options',
		'type'    => 'select',
		'choices'    => $typography_options['sizes'],
	));
	$wp_customize->add_setting('dignified[main_body_typography][face]', array(
		'default' => $typography_defaults['face'],
		'type' => 'option',
		'sanitize_callback' => 'dignified_sanitize_typo_face',
	));
	$wp_customize->add_control('dignified[main_body_typography][face]', array(
		'section' => 'dignified_typography_options',
		'type'    => 'select',
		'choices'    => $typography_options['faces'],
	));
	$wp_customize->add_setting('dignified[main_body_typography][style]', array(
		'default' => $typography_defaults['style'],
		'type' => 'option',
		'sanitize_callback' => 'dignified_sanitize_typo_style',
	));
	$wp_customize->add_control('dignified[main_body_typography][style]', array(
		'section' => 'dignified_typography_options',
		'type'    => 'select',
		'choices'    => $typography_options['styles'],
	));
	$wp_customize->add_setting('dignified[main_body_typography][color]', array(
		// 'default' => sanitize_hex_color( '#6B6B6B' ),
		'type'  => 'option',
		'sanitize_callback' => 'dignified_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dignified[main_body_typography][color]', array(
		'section' => 'dignified_typography_options',
	)));
	$wp_customize->add_setting('dignified[main_body_typography][subset]', array(
        'default' => '',
        'type' => 'option',
        'sanitize_callback' => 'esc_html'
    ));
    $wp_customize->add_control('dignified[main_body_typography][subset]', array(
        'label' => __('Font Subset', 'dignified'),
        'section' => 'dignified_typography_options',
        'description' => __('Enter the Google fonts subset', 'dignified'),
        'type' => 'text'
    ));

	$wp_customize->add_setting('dignified[heading_color]', array(
		// 'default' => sanitize_hex_color( '#444' ),
		'type'  => 'option',
		'sanitize_callback' => 'dignified_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dignified[heading_color]', array(
		'label' => __( 'Heading Color', 'dignified' ),
		'description'   => __( 'Color for all headings (h1-h6)','dignified' ),
		'section' => 'dignified_typography_options',
	)));
	$wp_customize->add_setting('dignified[link_color]', array(
		// 'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
		'type'  => 'option',
		'sanitize_callback' => 'dignified_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dignified[link_color]', array(
		'label' => __( 'Link Color', 'dignified' ),
		'description'   => __( 'Default used if no color is selected','dignified' ),
		'section' => 'dignified_typography_options',
	)));
	$wp_customize->add_setting('dignified[link_hover_color]', array(
		// 'default' => sanitize_hex_color( '#000000' ),
		'type'  => 'option',
		'sanitize_callback' => 'dignified_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dignified[link_hover_color]', array(
		'label' => __( 'Link:hover Color', 'dignified' ),
		'description'   => __( 'Default used if no color is selected','dignified' ),
		'section' => 'dignified_typography_options',
	)));

	/* dignified Header Options */
	$wp_customize->add_section('dignified_header_options', array(
		'title' => __( 'Header Menu', 'dignified' ),
		'priority' => 31,
		'panel' => 'dignified_main_options',
	));

	$wp_customize->add_setting('dignified[sticky_menu]', array(
		'default' => 0,
		'type' => 'option',
		'sanitize_callback' => 'dignified_sanitize_checkbox',
	));
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'dignified[sticky_menu]', array(
		'label' => __( 'Sticky Menu', 'dignified' ),
		'description' => sprintf( __( 'Check to show fixed header', 'dignified' ) ),
		'section' => 'dignified_header_options',
		'type' => 'epsilon-toggle',
	) ) );

//header-text-color
	$wp_customize->add_setting('dignified[header_text_color]', array(
		'default' => '', //sanitize_hex_color( '#ffffff' ),
		'type'  => 'option',
		'sanitize_callback' => 'dignified_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dignified[header_text_color]', array(
		'label' => __( 'Header Text Color', 'dignified' ),
		'description'   => __( 'Default used if no color is selected','dignified' ),
		'section' => 'dignified_header_options',
	)));
//header-text-color

	$wp_customize->add_setting('dignified[nav_bg_color]', array(
		'default' => '', //sanitize_hex_color( '#ffffff' ),
		'type'  => 'option',
		'sanitize_callback' => 'dignified_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dignified[nav_bg_color]', array(
		'label' => __( 'Top nav background color', 'dignified' ),
		'description'   => __( 'Default used if no color is selected','dignified' ),
		'section' => 'dignified_header_options',
	)));

	$wp_customize->add_setting('dignified[nav_link_color]', array(
		// 'default' => sanitize_hex_color( '#000000' ),
		'type'  => 'option',
		'sanitize_callback' => 'dignified_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dignified[nav_link_color]', array(
		'label' => __( 'Top nav item color', 'dignified' ),
		'description'   => __( 'Link color','dignified' ),
		'section' => 'dignified_header_options',
	)));

	$wp_customize->add_setting('dignified[nav_item_hover_color]', array(
		// 'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
		'type'  => 'option',
		'sanitize_callback' => 'dignified_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dignified[nav_item_hover_color]', array(
		'label' => __( 'Top nav item hover color', 'dignified' ),
		'description'   => __( 'Link:hover color','dignified' ),
		'section' => 'dignified_header_options',
	)));

	$wp_customize->add_setting('dignified[nav_dropdown_bg]', array(
		// 'default' => sanitize_hex_color( '#ffffff' ),
		'type'  => 'option',
		'sanitize_callback' => 'dignified_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dignified[nav_dropdown_bg]', array(
		'label' => __( 'Top nav dropdown background color', 'dignified' ),
		'description'   => __( 'Background of dropdown item hover color','dignified' ),
		'section' => 'dignified_header_options',
	)));

	$wp_customize->add_setting('dignified[nav_dropdown_item]', array(
		// 'default' => sanitize_hex_color( '#636467' ),
		'type'  => 'option',
		'sanitize_callback' => 'dignified_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dignified[nav_dropdown_item]', array(
		'label' => __( 'Top nav dropdown item color', 'dignified' ),
		'description'   => __( 'Dropdown item color','dignified' ),
		'section' => 'dignified_header_options',
	)));

	$wp_customize->add_setting('dignified[nav_dropdown_item_hover]', array(
		// 'default' => sanitize_hex_color( '#FFF' ),
		'type'  => 'option',
		'sanitize_callback' => 'dignified_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dignified[nav_dropdown_item_hover]', array(
		'label' => __( 'Top nav dropdown item hover color', 'dignified' ),
		'description'   => __( 'Dropdown item hover color','dignified' ),
		'section' => 'dignified_header_options',
	)));

	$wp_customize->add_setting('dignified[nav_dropdown_bg_hover]', array(
		// 'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
		'type'  => 'option',
		'sanitize_callback' => 'dignified_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dignified[nav_dropdown_bg_hover]', array(
		'label' => __( 'Top nav dropdown item background hover color', 'dignified' ),
		'description'   => __( 'Background of dropdown item hover color','dignified' ),
		'section' => 'dignified_header_options',
	)));

	/* dignified Footer Options */
	$wp_customize->add_section('dignified_footer_options', array(
		'title' => __( 'Footer', 'dignified' ),
		'priority' => 31,
		'panel' => 'dignified_main_options',
	));
	$wp_customize->add_setting('dignified[footer_widget_bg_color]', array(
		// 'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
		'type'  => 'option',
		'sanitize_callback' => 'dignified_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dignified[footer_widget_bg_color]', array(
		'label' => __( 'Footer widget area background color', 'dignified' ),
		'section' => 'dignified_footer_options',
	)));

	$wp_customize->add_setting('dignified[footer_bg_color]', array(
		// 'default' => sanitize_hex_color( '#1F1F1F' ),
		'type'  => 'option',
		'sanitize_callback' => 'dignified_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dignified[footer_bg_color]', array(
		'label' => __( 'Footer background color', 'dignified' ),
		'section' => 'dignified_footer_options',
	)));

	$wp_customize->add_setting('dignified[footer_text_color]', array(
		// 'default' => sanitize_hex_color( '#999' ),
		'type'  => 'option',
		'sanitize_callback' => 'dignified_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dignified[footer_text_color]', array(
		'label' => __( 'Footer text color', 'dignified' ),
		'section' => 'dignified_footer_options',
	)));

	$wp_customize->add_setting('dignified[footer_link_color]', array(
		// 'default' => sanitize_hex_color( '#DADADA' ),
		'type'  => 'option',
		'sanitize_callback' => 'dignified_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dignified[footer_link_color]', array(
		'label' => __( 'Footer link color', 'dignified' ),
		'section' => 'dignified_footer_options',
	)));

	$wp_customize->add_setting('dignified[custom_footer_text]', array(
		//'default' => 'dignified',
		'type' => 'option',
		'sanitize_callback' => 'dignified_sanitize_strip_slashes',
	));
	$wp_customize->add_control('dignified[custom_footer_text]', array(
		'label' => __( 'Footer information', 'dignified' ),
		'description' => sprintf( __( 'Footer Text (like Copyright Message)', 'dignified' ) ),
		'section' => 'dignified_footer_options',
		'type' => 'textarea',
	));

	/* dignified Social Options */
	$wp_customize->add_section('dignified_social_options', array(
		'title' => __( 'Social', 'dignified' ),
		'priority' => 31,
		'panel' => 'dignified_main_options',
	));
	$wp_customize->add_setting('dignified[social_color]', array(
		// 'default' => sanitize_hex_color( '#DADADA' ),
		'type'  => 'option',
		'sanitize_callback' => 'dignified_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dignified[social_color]', array(
		'label' => __( 'Social icon color', 'dignified' ),
		'description' => sprintf( __( 'Default used if no color is selected', 'dignified' ) ),
		'section' => 'dignified_social_options',
	)));

	$wp_customize->add_setting('dignified[social_footer_color]', array(
		// 'default' => sanitize_hex_color( '#DADADA' ),
		'type'  => 'option',
		'sanitize_callback' => 'dignified_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dignified[social_footer_color]', array(
		'label' => __( 'Footer social icon color', 'dignified' ),
		'description' => sprintf( __( 'Default used if no color is selected', 'dignified' ) ),
		'section' => 'dignified_social_options',
	)));

	$wp_customize->add_setting('dignified[footer_social]', array(
		'default' => 0,
		'type' => 'option',
		'sanitize_callback' => 'dignified_sanitize_checkbox',
	));
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'dignified[footer_social]', array(
		'label' => __( 'Footer Social Icons', 'dignified' ),
		'description' => sprintf( __( 'Check to show social icons in footer', 'dignified' ) ),
		'section' => 'dignified_social_options',
		'type' => 'epsilon-toggle',
	) ) );

}
add_action( 'customize_register', 'dignified_customizer' );



/**
 * Sanitzie checkbox for WordPress customizer
 */
function dignified_sanitize_checkbox( $input ) {
	if ( 1 == $input ) {
		return 1;
	} else {
		return '';
	}
}
/**
 * Adds sanitization callback function: colors
 * @package dignified
 */
function dignified_sanitize_hexcolor( $color ) {
	$unhashed = sanitize_hex_color_no_hash( $color );
	if ( $unhashed ) {
		return '#' . $unhashed;
	}
	return $color;
}

/**
 * Adds sanitization callback function: Nohtml
 * @package dignified
 */
function dignified_sanitize_nohtml( $input ) {
	return wp_filter_nohtml_kses( $input );
}

/**
 * Adds sanitization callback function: Number
 * @package dignified
 */
function dignified_sanitize_number( $input ) {
	if ( isset( $input ) && is_numeric( $input ) ) {
		return $input;
	}
}

/**
 * Adds sanitization callback function: Strip Slashes
 * @package dignified
 */
function dignified_sanitize_strip_slashes( $input ) {
	return wp_kses_stripslashes( $input );
}

/**
 * Adds sanitization callback function: Sanitize Text area
 * @package dignified
 */
function dignified_sanitize_textarea( $input ) {
	return sanitize_text_field( $input );
}

/**
 * Adds sanitization callback function: Slider Category
 * @package dignified
 */
function dignified_sanitize_slidecat( $input ) {
	global $options_categories;
	if ( array_key_exists( $input, $options_categories ) ) {
		return $input;
	} else {
		return '';
	}
}

/**
 * Adds sanitization callback function: Sidebar Layout
 * @package dignified
 */
function dignified_sanitize_layout( $input ) {
	global $site_layout;
	if ( array_key_exists( $input, $site_layout ) ) {
		return $input;
	} else {
		return '';
	}
}

/**
 * Adds sanitization callback function: Color Template
 * @package dignified
 */
function dignified_sanitize_template( $input ) {
	global $style_color;
	if ( array_key_exists( $input, $style_color ) ) {
		return $input;
	} else {
		return '';
	}
}

/**
 * Adds sanitization callback function: Typography Size
 * @package dignified
 */
function dignified_sanitize_typo_size( $input ) {
	global $typography_options, $typography_defaults;
	if ( array_key_exists( $input, $typography_options['sizes'] ) ) {
		return $input;
	} else {
		return $typography_defaults['size'];
	}
}
/**
 * Adds sanitization callback function: Typography Face
 * @package dignified
 */
function dignified_sanitize_typo_face( $input ) {
	global $typography_options, $typography_defaults;
	if ( array_key_exists( $input, $typography_options['faces'] ) ) {
		return $input;
	} else {
		return $typography_defaults['face'];
	}
}
/**
 * Adds sanitization callback function: Typography Style
 * @package dignified
 */
function dignified_sanitize_typo_style( $input ) {
	global $typography_options, $typography_defaults;
	if ( array_key_exists( $input, $typography_options['styles'] ) ) {
		return $input;
	} else {
		return $typography_defaults['style'];
	}
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function dignified_customize_preview_js() {
	wp_enqueue_script( 'dignified_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20140317', true );
}
add_action( 'customize_preview_init', 'dignified_customize_preview_js' );

/*
 * Customizer Slider Toggle {category and numb of slides}
 */
add_action( 'customize_controls_print_footer_scripts', 'dignified_slider_toggle' );

function dignified_slider_toggle() {
	?>
<script>
	jQuery(document).ready(function() {
		/* This one shows/hides the an option when a checkbox is clicked. */
		jQuery('#customize-control-dignified-dignified_slide_categories, #customize-control-dignified-dignified_slide_number').hide();
		jQuery('#customize-control-dignified-dignified_slider_checkbox input').click(function() {
			jQuery('#customize-control-dignified-dignified_slide_categories, #customize-control-dignified-dignified_slide_number').fadeToggle(400);
		});

		if (jQuery('#customize-control-dignified-dignified_slider_checkbox input:checked').val() !== undefined) {
			jQuery('#customize-control-dignified-dignified_slide_categories, #customize-control-dignified-dignified_slide_number').show();
		}
	});
</script>
<?php
}
