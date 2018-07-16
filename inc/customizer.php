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

		/*
	* Custom customizer: background color for header and footer
	*/

	$wp_customize->add_setting( 'interactive_link_color', array(
		'default' => '#b51c35',
		'transport' => 'postMessage',
		'type' => 'theme_mod',
		'sanitize_callback' => 'sanitize_hex_color'
	) );

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'interactive_link_color',
			array(
				'label' => __( 'Interactive link color', 'chainx' ),
				'section' => 'colors',
				'settings' => 'interactive_link_color'
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
		$interactive_link_color = get_theme_mod( 'interactive_link_color' );

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


	/*
	 * Do we have a custom interactive color?
	 */
	if ( '#b51c35' != $interactive_link_color ) { ?>
		<style type="text/css">
			.site-title a, 
			.menu a, 
			.site-description, 
			.dropdown-symbol,
			a:hover,
			a:focus, 
			a:active,
			.page-content a:focus, .page-content a:hover,
			.entry-content a:focus,
			.entry-content a:hover,
			.entry-summary a:focus,
			.entry-summary a:hover,
			.comment-content a:focus,
			.comment-content a:hover,
			.cat-links a {
				color: <?php echo esc_attr( $interactive_link_color ); ?>;
			}
			
			.page-content a,
			.entry-content a,
			.entry-summary a,
			.comment-content a,
			.post-navigation .post-title,
			.comment-navigation a:hover, 
			.comment-navigation a:focus,
			.posts-navigation a:hover,
			.posts-navigation a:focus,
			.post-navigation a:hover,
			.post-navigation a:focus,
			.paging-navigation a:hover,
			.paging-navigation a:focus,
			.entry-title a:hover, 
			.entry-title a:focus,
			.entry-meta a:focus, 
			.entry-meta a:hover,
			.entry-footer a:focus,
			.entry-footer a:hover,
			.reply a:hover, 
			.reply a:focus,
			.comment-form .form-submit input:hover, 
			.comment-form .form-submit input:focus,
			.widget a:hover, 
			.widget a:focus {
				border-color: <?php echo esc_attr( $interactive_link_color ); ?>;
			}
			
			.comment-navigation a:hover, 
			.comment-navigation a:focus,
			.posts-navigation a:hover,
			.posts-navigation a:focus,
			.post-navigation a:hover,
			.post-navigation a:focus,
			.paging-navigation a:hover,
			.paging-navigation a:focus,
			.continue-reading a:focus, 
			.continue-reading a:hover,
			.cat-links a:focus, 
			.cat-links a:hover,
			.reply a:hover, 
			.reply a:focus,
			.comment-form .form-submit input:hover, 
			.comment-form .form-submit input:focus {
				background-color: <?php echo esc_attr( $interactive_link_color ); ?>;
			}
			
			@media screen and (min-width: 900px) {
				.no-sidebar .post-content__wrap .entry-meta a:hover, 
				.no-sidebar .post-content__wrap .entry-meta a:focus {
					border-color: <?php echo esc_attr( $interactive_link_color ); ?>;
				}
			}
		</style>
	<?php
	} 
	}
endif;
