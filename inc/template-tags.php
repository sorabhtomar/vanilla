<?php


if ( ! function_exists( 'vanilla_entry_meta' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function vanilla_entry_meta() {
		echo '<div class="entry-meta">';
		if ( is_sticky() && is_home() && ! is_paged() ) {
			printf( '<span class="sticky-post entry-meta__item">%s</span>', __( 'Featured', 'vanilla' ) );
		}

		$format = get_post_format();
		if ( current_theme_supports( 'post-formats', $format ) ) {
			printf( '<span class="entry-format entry-meta__item">%1$s<a href="%2$s">%3$s</a></span>',
				sprintf( '<span class="screen-reader-text">%s </span>', _x( 'Format', 'Used before post format.', 'vanilla' ) ),
				esc_url( get_post_format_link( $format ) ),
				get_post_format_string( $format )
			);
		}

		if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
			$time_string = '<time class="entry-date published updated entry-meta__item" datetime="%1$s">%2$s</time>';

			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="entry-date published entry-meta__item" datetime="%1$s">%2$s</time><time class="updated entry-meta__item" datetime="%3$s">%4$s</time>';
			}

			$time_string = sprintf( $time_string,
				esc_attr( get_the_date( 'c' ) ),
				get_the_date(),
				esc_attr( get_the_modified_date( 'c' ) ),
				get_the_modified_date()
			);

			printf( '<span class="posted-on entry-meta__item"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
				_x( 'Posted on', 'Used before publish date.', 'vanilla' ),
				esc_url( get_permalink() ),
				$time_string
			);
		}

		if ( 'post' == get_post_type() ) {
			if ( is_singular() || is_multi_author() ) {
				printf( '<span class="byline entry-meta__item"><span class="author vcard"><span class="screen-reader-text">%1$s </span><a class="url fn n" href="%2$s">%3$s</a></span></span>',
					_x( 'Author', 'Used before post author name.', 'vanilla' ),
					esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
					get_the_author()
				);
			}

			$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'vanilla' ) );
			if ( $categories_list ) {
				printf( '<span class="cat-links entry-meta__item"><span class="screen-reader-text">%1$s </span>%2$s</span>',
					_x( 'Categories', 'Used before category names.', 'vanilla' ),
					$categories_list
				);
			}

			$tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'vanilla' ) );
			if ( $tags_list ) {
				printf( '<span class="tags-links entry-meta__item"><span class="screen-reader-text">%1$s </span>%2$s</span>',
					_x( 'Tags', 'Used before tag names.', 'vanilla' ),
					$tags_list
				);
			}
		}

		if ( is_attachment() && wp_attachment_is_image() ) {
			// Retrieve attachment metadata.
			$metadata = wp_get_attachment_metadata();

			printf( '<span class="full-size-link entry-meta__item"><span class="screen-reader-text">%1$s </span><a href="%2$s">%3$s &times; %4$s</a></span>',
				_x( 'Full size', 'Used before full size attachment link.', 'vanilla' ),
				esc_url( wp_get_attachment_url() ),
				$metadata['width'],
				$metadata['height']
			);
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link entry-meta__item">';
			/* translators: %s: post title */
			comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'vanilla' ), get_the_title() ) );
			echo '</span>';
		}

		echo '</div>';
	}
endif;

if ( ! function_exists( 'vanilla_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function vanilla_entry_footer() {

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( esc_html__( 'Leave a comment', 'vanilla' ), esc_html__( '1 Comment', 'vanilla' ), esc_html__( '% Comments', 'vanilla' ) );
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'vanilla' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;
