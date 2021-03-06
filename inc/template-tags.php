<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Chainx
 */

if ( ! function_exists( 'chainx_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function chainx_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Published on %s', 'post date', 'chainx' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'chainx_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function chainx_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'Written by %s', 'post author', 'chainx' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'chainx_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the tags and comments.
	 */
	function chainx_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'chainx' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'chainx' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}
	}
endif;

if ( ! function_exists('chainx_edit_link') ):
	/**
	 * Link to edit post
	 */

	function chainx_edit_link(){

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'chainx' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link"> <span class="extra">Admin</span>',
			'</span>'
		);
	}
endif;

if ( ! function_exists('chainx_post_comments') ):
	/**
	 * Displays post comment counts
	 */

	function chainx_post_comments(){
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link"> <span class="extra">Discussion</span>';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'chainx' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}
	}
endif;

if ( ! function_exists('chainx_post_thumbnail') ) :
	/**
	 * Displays category lists
	 */
	function chainx_category_list(){
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'chainx' ) );
		if ( $categories_list ) {
			/* translators: 1: list of categories. */
			printf( '<span class="cat-links">' . esc_html__( '%1$s', 'chainx' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}
	}
endif;

if ( ! function_exists( 'chainx_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function chainx_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'chainx_post_navigation') ):
	/**
	 * Navigation with context
	 */
	function chainx_post_navigation(){
		the_post_navigation( array(
			'next_text'	=>	'<span class="meta-nav" aria-hidden="true">' . __('Next ', 'chainx') . '</span>' 
							.
							'<span class="screen-reader-text">' . __('Next post: ', 'chainx') . '</span>'
							.
							'<span class="post-title">%title</span>',
			'prev_text'	=>	'<span class="meta-nav" aria-hidden="true">' . __('Previous ', 'chainx') . '</span>' 
							.
							'<span class="screen-reader-text">' . __('Previous post: ', 'chainx') . '</span>'
							.
							'<span class="post-title">%title</span>',

		));
	}
endif;

if ( ! function_exists( 'chainx_excerpt_more') ):
	function chainx_excerpt_more( $more ){
		return $more = '...';
	}
	
	add_filter('excerpt_more', 'chainx_excerpt_more');
endif;

if ( ! function_exists( 'chainx_excerpt_length') ):
	function chainx_excerpt_length( $length ){
		return 111;
	}

	add_filter( 'excerpt_length', 'chainx_excerpt_length');
endif;