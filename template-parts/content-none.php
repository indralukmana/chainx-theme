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

<section id="primary" class="content-area not-found <?php if( is_404() ){ echo 'error-404'; } else { echo 'no-results'; } ?>">
	<main id="main" class="site-main" role="main">
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

			
			elseif ( is_404() ) :
					?>
	
					<p><?php esc_html_e( 'Sorry, the page you are looking for does not exist. Check out the recent articles or do a search below.', 'chainx' ); ?></p>
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

		<?php
			if ( is_404() || is_search() ) {
		?>
				<h2 class="page-title secondary-title"><?php esc_html_e( 'Recent posts:', 'chainx'); ?></h2>

		<?php
				$query = array(
					'posts_per_page' => 6
				);

				$posts = new WP_Query( $query );

				if( $posts->have_posts() ){
					while ( $posts->have_posts() ){
						$posts->the_post();
						get_template_part( 'template-parts/content', get_post_format() );
					}
				}

				wp_reset_postdata();
			}
		?>
	</main> <!-- #main -->

</section><!-- .no-results -->

<?php

get_sidebar();
get_footer();