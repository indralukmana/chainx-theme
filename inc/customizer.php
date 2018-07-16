<?php
/**
 * Chainx Theme Customizer
 *
 * @package Chainx
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function chainx_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'chainx_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'chainx_customize_partial_blogdescription',
		) );
	}

	/*
	* Custom customizer: background color for header and footer
	*/

	$wp_customize->add_setting( 'theme_background_color', array(
		'default' => '#0099ff',
		'transport' => 'postMessage',
		'type' => 'theme_mod',
		'sanitize_callback' => 'sanitize_hex_color'
	) );

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'theme_background_color',
			array(
				'label' => __( 'Background color for header and footer', 'chainx' ),
				'section' => 'colors',
				'settings' => 'theme_background_color'
			)
		)
	);

}
add_action( 'customize_register', 'chainx_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function chainx_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function chainx_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function chainx_customize_preview_js() {
	wp_enqueue_script( 'chainx-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'chainx_customize_preview_js' );


if ( ! function_exists( 'chainx_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see chainx_custom_header_setup().
	 */
	function chainx_header_style() {
		$header_text_color = get_header_textcolor();
		$header_background_color = get_theme_mod( 'theme_background_color' );

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) != $header_text_color ) {
			

			// If we get this far, we have custom styles. Let's do this.
			?>
			<style type="text/css">
			<?php
			// Has the text been hidden?
			if ( ! display_header_text() ) :
				?>
				.site-title,
				.site-description {
					position: absolute;
					clip: rect(1px, 1px, 1px, 1px);
				}
			<?php
			// If the user has set a custom color for the text use that.
			else :
				?>
				.site-title a,
				.site-description {
					color: #<?php echo esc_attr( $header_text_color ); ?>;
				}
			<?php endif; ?>
			</style>
			<?php
			

		}

		if ($header_background_color != '#0099ff'){ ?>
			<style type="text/css">
				.site-header,
				.site-footer {
					background-color: <?php echo esc_attr($header_background_color) ?>;
				}
			</style>
		<?php
		}
	}
endif;
