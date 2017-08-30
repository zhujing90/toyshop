<?php
//Shortcodes

add_shortcode( 'advanced_categories', 'tm_advanced_categories_shortcode' );

function tm_advanced_categories_shortcode( $atts ) {

	extract( shortcode_atts( array(
		'from_cat' => '',
		'select_only_with_images' => true,
		'show_image' => true,
		'show_name' => false,
		'show_description' => false,
		'columns' => '4'
	), $atts ) );

	//global $tm_theme_texdomain;

	if ( '' != $from_cat) {
		$parent_cat = get_term_by( 'slug', $from_cat, 'product_cat' );
		$args = array(
		    'hide_empty'    => false, 
		    'parent'         => $parent_cat->term_id
		); 
	} else {
		$args = array(
		    'hide_empty'    => false
		);
	}
	$prod_cats = get_terms( 'product_cat', $args );
	if ( $prod_cats ) {
		$container_class = '';
		switch ($columns) {
			case '1':
				$container_class = 'cols_1';
				$col_num = 1;
				break;
			case '2':
				$container_class = 'cols_2';
				$col_num = 2;
				break;
			case '3':
				$container_class = 'cols_3';
				$col_num = 3;
				break;
			case '4':
				$container_class = 'cols_4';
				$col_num = 4;
				break;
			case '5':
				$container_class = 'cols_5';
				$col_num = 5;
				break;
			case '6':
				$container_class = 'cols_6';
				$col_num = 6;
				break;
			default:
				$container_class = 'cols_6';
				$col_num = 6;
				break;
		}
		
		$output = "<ul class='advanced_categories " . $container_class . "'>\n";
		$cat_iterator = 0;
		foreach ( $prod_cats as $cat ) {

			$cat_link = get_term_link( $cat, 'product_cat' );

			$visible_trigger = true;
			if ( true == $select_only_with_images ) {
				$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
				$image = wp_get_attachment_url( $thumbnail_id );
				if (!$image) {
					$visible_trigger = false;
				}
			}
			if ( true == $visible_trigger ) {
				$cat_iterator++;
				$item_class = '';
				if ( 1 == $cat_iterator % $col_num ) {
					$item_class = ' first';
				} elseif ( 0 == $cat_iterator % $col_num ) {
					$item_class = ' last';
				}
				$output .= "<li class='advanced_categories_item" . $item_class . "'>\n";
					$output .= "<div class='advanced_categories_item_inner'>\n";
						if ( true == $show_image ) {
							$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
							$image = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' );
							$output .= "<figure>\n";
								$output .= "<a href='" . $cat_link . "'><img src='" . $image[0] . "' alt='" . $cat->name . "'></a>\n";
							$output .= "</figure>\n";
						}
						if ( true == $show_name ) {
							$output .= "<h4><a href='" . $cat_link . "'>" . $cat->name . "</a></h4>\n";
						}
						if ( true == $show_description && $cat->description != '' ) {
							$output .= "<div class='cat_desc'>" . $cat->description . "</div>\n";
						}
					$output .= "</div>\n";
				$output .= "</li>\n";
			}

		}
		$output .= "</ul>\n";
	} else {
		$output = __( 'There is no categories has been found', CURRENT_THEME );
	}

	return $output;
	
}

//Custom element
function shortcode_custom_element($atts, $content = null) {
	extract(shortcode_atts(array(
			'element' => 'div',
			'css_class' => 'my_class',
			'inner_wrapper' => false 
	), $atts));

	$output = '<'.$element.' class="'.esc_attr( $css_class ).'">';
	if (true == $inner_wrapper) {
		$output .= '<div class="'.esc_attr( $css_class ).'_wrap_inner">';
	}
		$output .= do_shortcode($content);
	if (true == $inner_wrapper) {
		$output .= '</div>';
	}
	$output .= '</'.$element.'>';

	return $output;
}
add_shortcode('custom_element', 'shortcode_custom_element');


/**
 * Banner
 *
 */
if ( !function_exists( 'banner_shortcode' ) ) {

	function banner_shortcode( $atts, $content = null, $shortcodename = '' ) {
		extract( shortcode_atts(
			array(
				'img'          => '',
				'banner_link'  => '',
				'title'        => '',
				'text'         => '',
				'btn_text'     => '',
				'target'       => '',
				'custom_class' => ''
			), $atts));

		// Get the URL to the content area.
		$content_url = untrailingslashit( content_url() );

		// Find latest '/' in content URL.
		$last_slash_pos = strrpos( $content_url, '/' );

		// 'wp-content' or something else.
		$content_dir_name = substr( $content_url, $last_slash_pos - strlen( $content_url ) + 1 );

		$pos = strpos( $img, $content_dir_name );

		if ( false !== $pos ) {

			$img_new = substr( $img, $pos + strlen( $content_dir_name ), strlen( $img ) - $pos );
			$img     = $content_url . $img_new;

		}

		$output =  '<a href="'. $banner_link .'" class="banner-wrap '.$custom_class.'">';
		if ($img !="") {
			$output .= '<figure class="featured-thumbnail">';
			if ($banner_link != "") {
				$output .= '<span  title="'. $title .'"><img src="' . $img .'" title="'. $title .'" alt="" /></span>';
			} else {
				$output .= '<img src="' . $img .'" title="'. $title .'" alt="" />';
			}
			$output .= '</figure>';
		}

		$output .= '<div class="banner_content-wrapper">';

		if ($title!="") {
			$output .= '<h5>';
			$output .= $title;
			$output .= '</h5>';
		}
		if ($text!="") {
			$output .= '<p>';
			$output .= $text;
			$output .= '</p>';
		}
		if ($btn_text!="") {
			$output .=  '<div class="link-align banner-btn"><span title="'.$btn_text.'" class="btn btn-link"
target="'.$target.'">';
			$output .= $btn_text;
			$output .= '</span></div>';
		}

		$output .= '</div>';
		$output .= '</a><!-- .banner-wrap (end) -->';

		$output = apply_filters( 'cherry_plugin_shortcode_output', $output, $atts, $shortcodename );

		return $output;
	}
	add_shortcode('banner', 'banner_shortcode');

}


/**
 * Post Grid
 *
 */
if (!function_exists('posts_grid_shortcode')) {

	function posts_grid_shortcode( $atts, $content = null, $shortcodename = '' ) {
		extract(shortcode_atts(array(
			'type'            => 'post',
			'category'        => '',
			'custom_category' => '',
			'tag'             => '',
			'columns'         => '3',
			'rows'            => '3',
			'order_by'        => 'date',
			'order'           => 'DESC',
			'thumb_width'     => '370',
			'thumb_height'    => '250',
			'meta'            => '',
			'excerpt_count'   => '15',
			'link'            => 'yes',
			'link_text'       => __('Read more', CHERRY_PLUGIN_DOMAIN),
			'custom_class'    => ''
		), $atts));

		$spans = $columns;
		$rand  = rand();

		// columns
		switch ($spans) {
			case '1':
				$spans = 'span12';
				break;
			case '2':
				$spans = 'span6';
				break;
			case '3':
				$spans = 'span4';
				break;
			case '4':
				$spans = 'span3';
				break;
			case '6':
				$spans = 'span2';
				break;
		}

		// check what order by method user selected
		switch ($order_by) {
			case 'date':
				$order_by = 'post_date';
				break;
			case 'title':
				$order_by = 'title';
				break;
			case 'popular':
				$order_by = 'comment_count';
				break;
			case 'random':
				$order_by = 'rand';
				break;
		}

		// check what order method user selected (DESC or ASC)
		switch ($order) {
			case 'DESC':
				$order = 'DESC';
				break;
			case 'ASC':
				$order = 'ASC';
				break;
		}

		// show link after posts?
		switch ($link) {
			case 'yes':
				$link = true;
				break;
			case 'no':
				$link = false;
				break;
		}

		global $post;
		global $my_string_limit_words;

		$numb = $columns * $rows;

		// WPML filter
		$suppress_filters = get_option('suppress_filters');

		$args = array(
			'post_type'         => $type,
			'category_name'     => $category,
			$type . '_category' => $custom_category,
			'tag'               => $tag,
			'numberposts'       => $numb,
			'orderby'           => $order_by,
			'order'             => $order,
			'suppress_filters'  => $suppress_filters
		);

		$posts      = get_posts($args);
		$i          = 0;
		$count      = 1;
		$output_end = '';
		$countul = 0;

		if ($numb > count($posts)) {
			$output_end = '</ul>';
		}

		$output = '<ul class="posts-grid row-fluid unstyled '. $custom_class .' ul-item-'.$countul.'">';


		foreach ( $posts as $j => $post ) {
			$post_id = $posts[$j]->ID;
			//Check if WPML is activated
			if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
				global $sitepress;

				$post_lang = $sitepress->get_language_for_element( $post_id, 'post_' . $type );
				$curr_lang = $sitepress->get_current_language();
				// Unset not translated posts
				if ( $post_lang != $curr_lang ) {
					unset( $posts[$j] );
				}
				// Post ID is different in a second language Solution
				if ( function_exists( 'icl_object_id' ) ) {
					$posts[$j] = get_post( icl_object_id( $posts[$j]->ID, $type, true ) );
				}
			}

			setup_postdata($posts[$j]);
			$excerpt        = get_the_excerpt();
			$attachment_url = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'full' );
			$url            = $attachment_url['0'];
			$image          = aq_resize($url, $thumb_width, $thumb_height, true);
			$mediaType      = get_post_meta($post_id, 'tz_portfolio_type', true);
			$prettyType     = 0;

			if ($count > $columns) {
				$count = 1;
				$countul ++;
				$output .= '<ul class="posts-grid row-fluid unstyled '. $custom_class .' ul-item-'.$countul.'">';
			}

			$output .= '<li class="'. $spans .' list-item-'.$count.'">';
			if ($meta == 'yes') {
				// begin post meta
				$output .= '<div class="post_meta">';

				// post date
				$output .= '<span class="post_date">';
				$output .= '<time datetime="'.get_the_time('Y-m-d\TH:i:s', $post_id).'">' .get_the_date(). '</time>';
				$output .= '</span>';

				$output .= '</div>';
				// end post meta
			}
			if(has_post_thumbnail($post_id) && $mediaType == 'Image') {

				$prettyType = 'prettyPhoto-'.$rand;

				$output .= '<figure class="featured-thumbnail thumbnail">';
				$output .= '<a href="'.$url.'" title="'.get_the_title($post_id).'" rel="' .$prettyType.'">';
				$output .= '<img  src="'.$image.'" alt="'.get_the_title($post_id).'" />';
				$output .= '<span class="zoom-icon"></span></a></figure>';
			} elseif ($mediaType != 'Video' && $mediaType != 'Audio') {

				$thumbid = 0;
				$thumbid = get_post_thumbnail_id($post_id);

				$images = get_children( array(
					'orderby'        => 'menu_order',
					'order'          => 'ASC',
					'post_type'      => 'attachment',
					'post_parent'    => $post_id,
					'post_mime_type' => 'image',
					'post_status'    => null,
					'numberposts'    => -1
				) );

				if ( $images ) {

					$k = 0;
					//looping through the images
					foreach ( $images as $attachment_id => $attachment ) {
						$prettyType = "prettyPhoto-".$rand ."[gallery".$i."]";
						//if( $attachment->ID == $thumbid ) continue;

						$image_attributes = wp_get_attachment_image_src( $attachment_id, 'full' ); // returns an array
						$img = aq_resize( $image_attributes[0], $thumb_width, $thumb_height, true ); //resize & crop img
						$alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
						$image_title = $attachment->post_title;

						if ( $k == 0 ) {
							if (has_post_thumbnail($post_id)) {
								$output .= '<figure class="featured-thumbnail thumbnail">';
								$output .= '<a href="'.$image_attributes[0].'" title="'.get_the_title($post_id).'" rel="' .$prettyType.'">';
								$output .= '<img src="'.$image.'" alt="'.get_the_title($post_id).'" />';
							} else {
								$output .= '<figure class="featured-thumbnail thumbnail">';
								$output .= '<a href="'.$image_attributes[0].'" title="'.get_the_title($post_id).'" rel="' .$prettyType.'">';
								$output .= '<img  src="'.$img.'" alt="'.get_the_title($post_id).'" />';
							}
						} else {
							$output .= '<figure class="featured-thumbnail thumbnail" style="display:none;">';
							$output .= '<a href="'.$image_attributes[0].'" title="'.get_the_title($post_id).'" rel="' .$prettyType.'">';
						}
						$output .= '<span class="zoom-icon"></span></a></figure>';
						$k++;
					}
				} elseif (has_post_thumbnail($post_id)) {
					$prettyType = 'prettyPhoto-'.$rand;
					$output .= '<figure class="featured-thumbnail thumbnail">';
					$output .= '<a href="'.$url.'" title="'.get_the_title($post_id).'" rel="' .$prettyType.'">';
					$output .= '<img  src="'.$image.'" alt="'.get_the_title($post_id).'" />';
					$output .= '<span class="zoom-icon"></span></a></figure>';
				}
			} else {

				// for Video and Audio post format - no lightbox
				$output .= '<figure class="featured-thumbnail thumbnail"><a href="'.get_permalink($post_id).'" title="'.get_the_title($post_id).'">';
				$output .= '<img  src="'.$image.'" alt="'.get_the_title($post_id).'" />';
				$output .= '</a></figure>';
			}

			$output .= '<div class="clear"></div>';

			$output .= '<h5><a href="'.get_permalink($post_id).'" title="'.get_the_title($post_id).'">';
			$output .= get_the_title($post_id);
			$output .= '</a></h5>';

			$output .= cherry_get_post_networks(array('post_id' => $post_id, 'display_title' => false, 'output_type' => 'return'));
			if($excerpt_count >= 1){
				$output .= '<p class="excerpt">';
				$output .= wp_trim_words($excerpt,$excerpt_count);
				$output .= '</p>';
			}
			if($link){
				$output .= '<a href="'.get_permalink($post_id).'" class="btn btn-primary" title="'.get_the_title($post_id).'">';
				$output .= $link_text;
				$output .= '</a>';
			}
			$output .= '</li>';
			if ($j == count($posts)-1) {
				$output .= $output_end;
			}
			if ($count % $columns == 0) {
				$output .= '</ul><!-- .posts-grid (end) -->';
			}
			$count++;
			$i++;

		} // end for
		wp_reset_postdata(); // restore the global $post variable

		$output = apply_filters( 'cherry_plugin_shortcode_output', $output, $atts, $shortcodename );

		return $output;
	}
	add_shortcode('posts_grid', 'posts_grid_shortcode');
}


/**
 * Carousel OWL
 */
if ( !function_exists('shortcode_carousel_owl') ) {
	function shortcode_carousel_owl( $atts, $content = null, $shortcodename = '' ) {
		wp_enqueue_script( 'owl-carousel', CHERRY_PLUGIN_URL . 'lib/js/owl-carousel/owl.carousel.min.js', array('jquery'), '1.31', true );

		extract( shortcode_atts( array(
			'title'              => '',
			'posts_count'        => 10,
			'post_type'          => 'blog',
			'post_status'        => 'publish',
			'visibility_items'   => 5,
			'thumb'              => 'yes',
			'thumb_width'        => 220,
			'thumb_height'       => 180,
			'more_text_single'   => '',
			'categories'         => '',
			'excerpt_count'      => 15,
			'date'               => 'yes',
			'author'             => 'yes',
			'comments'           => 'no',
			'auto_play'          => 0,
			'display_navs'       => 'yes',
			'display_pagination' => 'yes',
			'custom_class'       => ''
		), $atts ) );

		$random_ID          = uniqid();
		$posts_count        = intval( $posts_count );
		$thumb              = $thumb == 'yes' ? true : false;
		$thumb_width        = absint( $thumb_width );
		$thumb_height       = absint( $thumb_height );
		$excerpt_count      = absint( $excerpt_count );
		$visibility_items   = absint( $visibility_items );
		$auto_play          = absint( $auto_play );
		$date               = $date == 'yes' ? true : false;
		$author             = $author == 'yes' ? true : false;
		$comments           = $comments == 'yes' ? true : false;
		$display_navs       = $display_navs == 'yes' ? 'true' : 'false';
		$display_pagination = $display_pagination == 'yes' ? 'true' : 'false';
		$itemcounter = 0;

		switch ( strtolower( str_replace(' ', '-', $post_type) ) ) {
			case 'blog':
				$post_type = 'post';
				break;
			case 'portfolio':
				$post_type = 'portfolio';
				break;
			case 'testimonial':
				$post_type = 'testi';
				break;
			case 'services':
				$post_type = 'services';
				break;
			case 'our-team':
				$post_type = 'team';
				break;
		}

		$get_category_type = $post_type == 'post' ? 'category' : $post_type.'_category';
		$categories_ids = array();
		foreach ( explode(',', str_replace(', ', ',', $categories)) as $category ) {
			$get_cat_id = get_term_by( 'name', $category, $get_category_type );
			if ( $get_cat_id ) {
				$categories_ids[] = $get_cat_id->term_id;
			}
		}
		$get_query_tax = $categories_ids ? 'tax_query' : '';

		$suppress_filters = get_option('suppress_filters'); // WPML filter

		// WP_Query arguments
		$args = array(
			'post_status'         => $post_status,
			'posts_per_page'      => $posts_count,
			'ignore_sticky_posts' => 1,
			'post_type'           => $post_type,
			'suppress_filters'    => $suppress_filters,
			"$get_query_tax"      => array(
				array(
					'taxonomy' => $get_category_type,
					'field'    => 'id',
					'terms'    => $categories_ids
				)
			)
		);

		// The Query
		$carousel_query = new WP_Query( $args );
		if ( $carousel_query->have_posts() ) :

			$output = '<div class="carousel-wrap ' . $custom_class . '">';
			$output .= $title ? '<h2>' . $title . '</h2>' : '';
			$output .= '<div id="owl-carousel-' . $random_ID . '" class="owl-carousel-' . $post_type . ' owl-carousel" data-items="' . $visibility_items . '" data-auto-play="' . $auto_play . '" data-nav="' . $display_navs . '" data-pagination="' . $display_pagination . '">';

			while ( $carousel_query->have_posts() ) : $carousel_query->the_post();
				$post_id         = $carousel_query->post->ID;
				$post_title      = esc_html( get_the_title( $post_id ) );
				$post_title_attr = esc_attr( strip_tags( get_the_title( $post_id ) ) );
				$format          = get_post_format( $post_id );
				$format          = (empty( $format )) ? 'format-standart' : 'format-' . $format;
				if ( get_post_meta( $post_id, 'tz_link_url', true ) ) {
					$post_permalink = ( $format == 'format-link' ) ? esc_url( get_post_meta( $post_id, 'tz_link_url', true ) ) : get_permalink( $post_id );
				} else {
					$post_permalink = get_permalink( $post_id );
				}
				if ( has_excerpt( $post_id ) ) {
					$excerpt = wp_strip_all_tags( get_the_excerpt() );
				} else {
					$excerpt = wp_strip_all_tags( strip_shortcodes (get_the_content() ) );
				}

				$output .= '<div class="item ' . $format . ' item-list-'.$itemcounter.'">';

				// post thumbnail

				if ($post_type == 'product') {
					global $product;

					if ( $rating_html = $product->get_rating_html() ) :
						$output .= '<span class="rating">'.$rating_html.'</span>';
					endif;
				}

				if ( $thumb ) :

					if ( has_post_thumbnail( $post_id ) ) {
						$attachment_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
						$url            = $attachment_url['0'];
						$image          = aq_resize($url, $thumb_width, $thumb_height, true);

						$output .= '<figure>';
						$output .= '<a href="' . $post_permalink . '" title="' . $post_title . '">';
						$output .= '<img src="' . $image . '" alt="' . $post_title . '" />';
						$output .= '</a>';
						$output .= '</figure>';

					} else {

						$attachments = get_children( array(
							'orderby'        => 'menu_order',
							'order'          => 'ASC',
							'post_type'      => 'attachment',
							'post_parent'    => $post_id,
							'post_mime_type' => 'image',
							'post_status'    => null,
							'numberposts'    => 1
						) );
						if ( $attachments ) {
							foreach ( $attachments as $attachment_id => $attachment ) {
								$image_attributes = wp_get_attachment_image_src( $attachment_id, 'full' );
								$img              = aq_resize( $image_attributes[0], $thumb_width, $thumb_height, true );
								$alt              = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );

								$output .= '<figure>';
								$output .= '<a href="' . $post_permalink.'" title="' . $post_title . '">';
								$output .= '<img src="' . $img . '" alt="' . $alt . '" />';
								$output .= '</a>';
								$output .= '</figure>';
							}
						}
					}

				endif;

				if ($post_type == 'product') {
					global $product;

					if ( $price_html = $product->get_price_html() ) :
						$output .= '<span class="price">'.$price_html.'</span>';
					endif;
				}

				$output .= '<div class="desc">';

				// post date
				$output .= $date ? '<time datetime="' . get_the_time( 'Y-m-d\TH:i:s', $post_id ) . '">' . get_the_date() . '</time>' : '';

				// post author
				$output .= $author ? '<em class="author">&nbsp;<span>' . __('by ', CHERRY_PLUGIN_DOMAIN) . '</span>&nbsp;<a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ).'">' . get_the_author_meta( 'display_name' ) . '</a> </em>' : '';

				// post comment count
				if ( $comments == 'yes' ) {
					$comment_count = $carousel_query->post->comment_count;
					if ( $comment_count >= 1 ) :
						$comment_count = $comment_count . ' <span>' . __( 'Comments', CHERRY_PLUGIN_DOMAIN ) . '</span>';
					else :
						$comment_count = $comment_count . ' <span>' . __( 'Comment', CHERRY_PLUGIN_DOMAIN ) . '</span>';
					endif;
					$output .= '<a href="'. $post_permalink . '#comments" class="comments_link">' . $comment_count . '</a>';
				}

				// post title
				if ( !empty($post_title{0}) ) {
					$output .= '<h5><a href="' . $post_permalink . '" title="' . $post_title_attr . '">';
					$output .= $post_title;
					$output .= '</a></h5>';
				}

				// post excerpt
				if ( !empty($excerpt{0}) ) {
					$output .= $excerpt_count > 0 ? '<p class="excerpt">' . wp_trim_words( $excerpt, $excerpt_count ) . '</p>' : '';
				}

				// post more button
				$more_text_single = esc_html( wp_kses_data( $more_text_single ) );
				if ( $more_text_single != '' ) {
					$output .= '<a href="' . get_permalink( $post_id ) . '" class="btn btn-primary" title="' . $post_title_attr . '">';
					$output .= __( $more_text_single, CHERRY_PLUGIN_DOMAIN );
					$output .= '</a>';
				}
				$output .= '</div>';
				$output .= '</div>';
				$itemcounter++;
			endwhile;
			$output .= '</div></div>';
		endif;

		// Restore original Post Data
		wp_reset_postdata();

		$output = apply_filters( 'cherry_plugin_shortcode_output', $output, $atts, $shortcodename );

		return $output;
	}
	add_shortcode( 'carousel_owl', 'shortcode_carousel_owl' );
}

if (!function_exists('triangle_block_shortcode')) {
	function triangle_block_shortcode( $atts, $content = null, $shortcodename = '' ) {
		extract(shortcode_atts(array(
			'custom_class'  => ''
		), $atts));

		$output = '<div class="triangle_block '.$custom_class.'">';
		$output .= '<div class="container">';
		$output .= do_shortcode($content);
		$output .= '</div>';
		$output .= '</div>';

		$output = apply_filters( 'cherry_plugin_shortcode_output', $output, $atts, $shortcodename );

		return $output;
	}
	add_shortcode('triangle_block', 'triangle_block_shortcode');
}


?>