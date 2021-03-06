<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Chainx
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if (has_post_thumbnail()) { ?>
		<figure class='featured-image index-image'>
			<?php chainx_post_thumbnail('chainx-index-image'); ?>
		</figure>
	<?php } ?>

	<div class='post__content'>

		<header class="entry-header">
			<?php chainx_category_list(); ?>
			<?php
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;

			if ( 'post' === get_post_type() ) :
				?>
				<div class="entry-meta">
					<?php
					chainx_posted_by();
					chainx_posted_on();
					chainx_post_comments();
					chainx_edit_link();
					?>
				</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php
				$post_length_setting = get_theme_mod('post_length_setting');
				
				if ( 'excerpt' === $post_length_setting ){
					the_excerpt();
				} else {
					the_content();
				}
			?>
		</div><!-- .entry-content -->

		<div class="continue-reading">
			<?php
			$more_link = sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'chainx' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			);
			?>

			<a href=' <?php echo esc_url( get_permalink() ) ?> ' rel="bookmark">
				<?php echo $more_link ?>
			</a>
		</div> <!-- .continue-reading -->

	</div>
</article><!-- #post-<?php the_ID(); ?> -->
