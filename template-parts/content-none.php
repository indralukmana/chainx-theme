<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Chainx
 */

?>

<header class="page-header">
	<h1 class="page-title">
		<?php 
			if ( is_404() ) {
				esc_html_e( 'Page is not available', 'chainx' );
			} else if( is_search() ) {
				/* translators: %s = search query */
				printf( 
					esc_html__( 'We cannot find &ldquo;%s&rdquo;', 'chainx' ),
					get_search_query()	
				);
			} else {
				esc_html_e( 'Nothing Found', 'chainx' );
			}
		?>
	</h1>
</header><!-- .page-header -->

<section class="no-results not-found">

	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) :

			printf(
				'<p>' . wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'chainx' ),
					array(
						'a' => array(
							'href' => array(),
						),
					)
				) . '</p>',
				esc_url( admin_url( 'post-new.php' ) )
			);

		elseif ( is_search() ) :
			?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'chainx' ); ?></p>
			<?php
			get_search_form();

		else :
			?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'chainx' ); ?></p>
			<?php
			get_search_form();

		endif;
		?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
