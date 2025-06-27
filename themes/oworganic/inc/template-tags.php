<?php
/**
 * Custom template tags for Oworganic
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package WordPress
 * @subpackage Oworganic
 * @since Oworganic 1.0
 */

if ( ! function_exists( 'oworganic_comment_nav' ) ) :
/**
 * Display navigation to next/previous comments when applicable.
 *
 * @since Oworganic 1.0
 */
function oworganic_comment_nav() {
	// Are there comments to navigate through?
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
	?>
	<nav class="navigation comment-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'oworganic' ); ?></h2>
		<div class="nav-links">
			<?php
				if ( $prev_link = get_previous_comments_link( esc_html__( 'Older Comments', 'oworganic' ) ) ) :
					printf( '<div class="nav-previous"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> %s</div>', $prev_link );
				endif;

				if ( $next_link = get_next_comments_link( esc_html__( 'Newer Comments', 'oworganic' ) ) ) :
					printf( '<div class="nav-next">%s <i class="fa fa-long-arrow-right" aria-hidden="true"></i></div>', $next_link );
				endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .comment-navigation -->
	<?php
	endif;
}
endif;

if ( ! function_exists( 'oworganic_post_thumbnail' ) ) {
	function oworganic_post_thumbnail($thumbsize = '', $link = '') {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}
		global $post;
		$link = empty( $link ) ? get_permalink() : $link;
		$html = '';
		if ( is_singular('post') && is_single($post) ) {
			$html .= '<div class="post-thumbnail">';
			$product_thumbnail_id = get_post_thumbnail_id();
			$html .= oworganic_get_attachment_thumbnail($product_thumbnail_id, 'full');
			$html .= '</div>';

		} else {
			$html .= '<figure class="entry-thumb">';
				$html .= '<a class="post-thumbnail" href="'.esc_url($link).'" aria-hidden="true">';
						$product_thumbnail_id = get_post_thumbnail_id();
						$html .= oworganic_get_attachment_thumbnail($product_thumbnail_id, $thumbsize);
				$html .= '</a>';
				
			$html .= '</figure>';
		} // End is_singular()

		return $html;
	}
}

if ( ! function_exists( 'oworganic_post_tags' ) ) {
	function oworganic_post_tags() {
		$posttags = get_the_tags();
		if ( $posttags ) {
			echo '<span class="entry-tags-list"><strong>'.esc_html__( 'Tags: ' , 'oworganic' ).'</strong> ';
			$i = 1;
			$size = count( $posttags );
			foreach ( $posttags as $tag ) {
				echo '<a href="' . get_tag_link( $tag->term_id ) . '">';
				echo esc_attr($tag->name);
				echo '</a>';
				$i ++;
			}
			echo '</span>';
		}
	}
}

if ( ! function_exists( 'oworganic_post_categories' ) ) {
	function oworganic_post_categories( $post ) {
		$cat = wp_get_post_categories( $post->ID );
		$k   = count( $cat );
		echo '<div class="list-categories"><i class="ti-folder"></i>';
		foreach ( $cat as $c ) {
			$categories = get_category( $c );
			$k -= 1;
			if ( $k == 0 ) {
				echo '<a href="' . get_category_link( $categories->term_id ) . '" class="categories-name">' . $categories->name . '</a>';
			} else {
				echo '<a href="' . get_category_link( $categories->term_id ) . '" class="categories-name">' . $categories->name . '</a>, ';
			}
		}
		echo '</div>';
	}
}

if ( ! function_exists( 'oworganic_post_first_categories' ) ) {
	function oworganic_post_first_categories( $post ) {
		$categories = wp_get_post_categories( $post->ID );
		if ( !empty($categories) && !empty($categories[0]) ) {
			echo '<div class="list-categories hidden-xs"><i class="ti-folder"></i>';
			$category = get_category( $categories[0] );
			echo '<a href="' . get_category_link( $category->term_id ) . '" class="categories-name">' . $category->name . '</a>';
			echo '</div>';
		}
	}
}

if ( ! function_exists( 'oworganic_excerpt_more' ) && ! is_admin() ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and a 'Continue reading' link.
 *
 * @since Oworganic 1.0
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function oworganic_excerpt_more( $more ) {
	$link = sprintf( '<br /><a href="%1$s" class="more-link">%2$s</a>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( esc_html__( 'Continue reading %s', 'oworganic' ), '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>' )
		);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'oworganic_excerpt_more' );
endif;

if ( ! function_exists( 'oworganic_display_post_thumb' ) ) {
	function oworganic_display_post_thumb($thumbsize) {
		$post_format = get_post_format();
		$output = '';
        if ( has_post_thumbnail() ) {
            $output = oworganic_post_thumbnail($thumbsize);
        }
	    return $output;
	}
}

function oworganic_get_attachment_thumbnail($attachment_id, $size = 'thumbnail', $icon = false, $attr = '', $wrapper = true) {
	$html = '';

	if ( defined('ELEMENTOR_PATH') && file_exists(ELEMENTOR_PATH . 'includes/libraries/bfi-thumb/bfi-thumb.php') ) {
        require_once( ELEMENTOR_PATH . 'includes/libraries/bfi-thumb/bfi-thumb.php' );
    }
    $image_sizes = get_intermediate_image_sizes();
    $image_sizes[] = 'full';
    if ( !in_array( $size, $image_sizes ) ) {
    	$attachment_size = [
			// Defaults sizes
			0 => null, // Width.
			1 => null, // Height.

			'bfi_thumb' => true,
			'crop' => true,
		];
		$sizes = explode('x', $size);
		if ( count($sizes) == 2 ) {
			$attachment_size[0] = intval($sizes[0]);
			$attachment_size[1] = intval($sizes[1]);
		}
    }
    if ( !empty($attachment_size) ) {
    	$size = $attachment_size;
    }
	$image = wp_get_attachment_image_src($attachment_id, $size, $icon);

	if ( $image ) {
		list($src, $width, $height) = $image;
		$hwstring = image_hwstring($width, $height);
		$size_class = $size;
		if ( is_array( $size_class ) ) {
			$size_class = join( 'x', $size_class );
		}
		$attachment = get_post($attachment_id);

		$default_attr = array(
			'src'	=> $src,
			'class'	=> "attachment-$size_class size-$size_class",
			'alt'	=> trim( strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) ),
		);

		$attr = wp_parse_args( $attr, $default_attr );
		
		// Generate 'srcset' and 'sizes' if not already present.
		if ( oworganic_get_config('image_lazy_loading') ) {
			$src_layzy = oworganic_create_placeholder(array($width, $height));
			$attr['data-src'] = $src;
			$attr['src'] = $src_layzy;
			$attr['class'] .= ' unveil-image';

			if ( empty( $attr['data-srcset'] ) ) {
				$image_meta = wp_get_attachment_metadata( $attachment_id );
				if ( is_array( $image_meta ) ) {
					$size_array = array( absint( $width ), absint( $height ) );
					$srcset = '';
					if ( function_exists('apus_framework_image_srcset') ) {
						$srcset = apus_framework_image_srcset( $size_array, $src, $image_meta, $attachment_id );
					}
					$sizes = wp_calculate_image_sizes( $size_array, $src, $image_meta, $attachment_id );

					if ( $srcset && ( $sizes || ! empty( $attr['sizes'] ) ) ) {
						$attr['data-srcset'] = $srcset;

						if ( empty( $attr['data-sizes'] ) ) {
							$attr['data-sizes'] = $sizes;
						}
					}
				}
			} 
			if ( !empty($attr['srcset'])) {
				unset($attr['srcset']);
			}
			if ( !empty($attr['sizes'])) {
				unset($attr['sizes']);
			}
		} else {
			if ( empty( $attr['srcset'] ) ) {
				$image_meta = wp_get_attachment_metadata( $attachment_id );
				if ( is_array( $image_meta ) ) {
					$size_array = array( absint( $width ), absint( $height ) );
					$srcset = '';
					if ( function_exists('apus_framework_image_srcset') ) {
						$srcset = apus_framework_image_srcset( $size_array, $src, $image_meta, $attachment_id );
					}
					$sizes = wp_calculate_image_sizes( $size_array, $src, $image_meta, $attachment_id );

					if ( $srcset && ( $sizes || ! empty( $attr['sizes'] ) ) ) {
						$attr['srcset'] = $srcset;

						if ( empty( $attr['sizes'] ) ) {
							$attr['sizes'] = $sizes;
						}
					}
				}
			} 
		}

		if ( $wrapper ) {
			$html .= '<div class="image-wrapper">';
		}
		/**
		 * Filters the list of attachment image attributes.
		 *
		 * @since 2.8.0
		 *
		 * @param array        $attr       Attributes for the image markup.
		 * @param WP_Post      $attachment Image attachment post.
		 * @param string|array $size       Requested size. Image size or array of width and height values
		 *                                 (in that order). Default 'thumbnail'.
		 */
		$attr = apply_filters( 'wp_get_attachment_image_attributes', $attr, $attachment, $size );
		$attr = array_map( 'esc_attr', $attr );
		$html .= rtrim("<img $hwstring");
		foreach ( $attr as $name => $value ) {
			$html .= " $name=" . '"' . $value . '"';
		}
		$html .= ' />';

		if ( $wrapper ) {
			$html .= '</div>';
		}
	}

	return $html;
}

add_filter( 'get_the_archive_title_prefix', 'oworganic_get_the_archive_title_prefix' );
function oworganic_get_the_archive_title_prefix($prefix){
	return '';
}

function oworganic_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'oworganic_pingback_header' );