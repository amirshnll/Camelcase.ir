<?php
function esotera_excerpt_length_words( $length ) {
	if ( is_admin() ) {
		return $length;
	}
	return absint( cryout_get_option( 'theme_excerptlength' ) );
}
add_filter( 'excerpt_length', 'esotera_excerpt_length_words' );
function esotera_custom_excerpt_more() {
	if ( ! is_attachment() ) {
		 echo wp_kses_post( esotera_continue_reading_link() );
	}
}
add_action( 'cryout_post_excerpt_hook', 'esotera_custom_excerpt_more', 10 );
function esotera_continue_reading_link() {
	$theme_excerptcont = cryout_get_option( 'theme_excerptcont' );
	return '<a class="continue-reading-link" href="'. esc_url( get_permalink() ) . '"><span>' . wp_kses_post( $theme_excerptcont ). '</span><i class="icon-continue-reading"></i><i class="icon-continue-reading"></i><em class="screen-reader-text">"' . get_the_title() . '"</em></a>';
}
add_filter( 'the_content_more_link', 'esotera_continue_reading_link' );
function esotera_auto_excerpt_more( $more ) {
	if ( is_admin() ) {
		return $more;
	}
	return wp_kses_post( cryout_get_option( 'theme_excerptdots' ) );
}
add_filter( 'excerpt_more', 'esotera_auto_excerpt_more' );
function esotera_more_link( $more_link, $more_link_text ) {
	$theme_excerptcont = cryout_get_option( 'theme_excerptcont' );
	$new_link_text = $theme_excerptcont;
	if ( preg_match( "/custom=(.*)/", $more_link_text, $m ) ) {
		$new_link_text = $m[1];
	}
	$more_link = str_replace( $more_link_text, $new_link_text, $more_link );
	$more_link = str_replace( 'more-link', 'continue-reading-link', $more_link );
	return $more_link;
}
add_filter( 'the_content_more_link', 'esotera_more_link', 10, 2 );
function esotera_remove_gallery_css( $css ) {
	return preg_replace( "#<style>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'esotera_remove_gallery_css' );
if ( ! function_exists( 'esotera_posted_category' ) ) :
function esotera_posted_category() {
	if ( 'post' !== get_post_type() ) return;
	$theme_meta_category = cryout_get_option( 'theme_meta_blog_category' );
	if ( is_single() ) {
		$theme_meta_category = cryout_get_option( 'theme_meta_single_category' );
	}
	if ( $theme_meta_category && get_the_category_list() ) {
		echo '<span class="bl_categ"' . cryout_schema_microdata( 'category', 0 ) . '>' .
					'<i class="icon-category icon-metas" title="' . esc_attr__( "Categories", "esotera" ) . '"></i>' .
					'<span class="category-metas"> '
					 . get_the_category_list( ' <span class="sep">/</span> ' ) .
				'</span></span>';
	}
}
endif;
if ( ! function_exists( 'esotera_posted_author' )) :
function esotera_posted_author() {
	if ( 'post' !== get_post_type() ) return;
	$theme_meta_blog_author = cryout_get_option( 'theme_meta_blog_author' );
	if ( $theme_meta_blog_author ) {
		echo sprintf(
			'<span class="author vcard"' . cryout_schema_microdata( 'author', 0 ) . '>
				<i class="icon-author icon-metas" title="' . esc_attr__( "Author", "esotera" ) . '"></i>
				<a class="url fn n" rel="author" href="%1$s" title="%2$s"' . cryout_schema_microdata( 'author-url', 0 ) . '>
					<em' .  cryout_schema_microdata( 'author-name', 0 ) . '>%3$s</em></a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'esotera' ), get_the_author() ),
			get_the_author()
		);
	}
}
endif;
if ( ! function_exists( 'esotera_posted_author_single' )) :
function esotera_posted_author_single() {
	$theme_meta_single_author = cryout_get_option( 'theme_meta_single_author' );
	global $post;
	$author_id = $post->post_author;
	if ( $theme_meta_single_author ) {
		echo sprintf(
			'<span class="author-avatar" >' . get_avatar( $author_id ) . '</span>' .
			'<span class="author vcard"' . cryout_schema_microdata( 'author', 0 ) . '>' .
				'<a class="url fn n" rel="author" href="%1$s" title="%2$s"' . cryout_schema_microdata( 'author-url', 0 ) . '>
					<em' .  cryout_schema_microdata( 'author-name', 0 ) . '>%3$s</em></a>' .
			'</span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID', 	$author_id ) ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'esotera' ), get_the_author_meta( 'display_name', $author_id) ),
			get_the_author_meta( 'display_name', $author_id)
		);
	}
}
endif;
if ( ! function_exists( 'esotera_posted_date' ) ) :
function esotera_posted_date() {
	if ( 'post' !== get_post_type() ) return;
	$theme_meta_date = cryout_get_option( 'theme_meta_blog_date' );
	$theme_meta_time = cryout_get_option( 'theme_meta_blog_time' );
	if ( is_single() ) {
		$theme_meta_date = cryout_get_option( 'theme_meta_single_date' );
		$theme_meta_time = cryout_get_option( 'theme_meta_single_time' );
	}
	if ( $theme_meta_date || $theme_meta_time ) {
		$date = ''; $time = '';
		if ( $theme_meta_date ) { $date = get_the_date(); }
		if ( $theme_meta_time ) { $time = esc_attr( get_the_time() ); }
		?>
		<span class="onDate date" >
				<i class="icon-date icon-metas" title="<?php esc_attr_e( "Date", "esotera" ) ?>"></i>
				<time class="published" datetime="<?php echo get_the_time( 'c' ) ?>" <?php cryout_schema_microdata( 'time' ) ?>>
					<?php echo $date . ( ( $theme_meta_date && $theme_meta_time ) ? ', ' : '' ) . $time ?>
				</time>
				<time class="updated" datetime="<?php echo get_the_modified_time( 'c' )  ?>" <?php cryout_schema_microdata( 'time-modified' ) ?>><?php echo get_the_modified_date();?></time>
		</span>
		<?php
	}
};
endif;
if ( ! function_exists( 'esotera_posted_tags' ) ) :
function esotera_posted_tags() {
	if ( 'post' !== get_post_type() ) return;
	$theme_meta_tag  = cryout_get_option( 'theme_meta_blog_tag' );
	if ( is_single() ) {
		$theme_meta_tag = cryout_get_option( 'theme_meta_single_tag' );
	}
	$tag_list = get_the_tag_list( '<span class="sep">#</span>', ' <span class="sep">#</span>' );
	if ( $theme_meta_tag && $tag_list ) { ?>
		<span class="tags" <?php cryout_schema_microdata( 'tags' ) ?>>
				<i class="icon-tag icon-metas" title="<?php esc_attr_e( 'Tagged', 'esotera' ) ?>"></i>&nbsp;<?php echo $tag_list ?>
		</span>
		<?php
	}
}
endif;
if ( ! function_exists( 'esotera_posted_edit' ) ) :
function esotera_posted_edit() {
	edit_post_link( sprintf( __( 'Edit %s', 'esotera' ), '<em class="screen-reader-text">"' . get_the_title() . '"</em>' ), '<span class="edit-link"><i class="icon-edit icon-metas"></i> ', '</span>' );
};
endif;
if ( ! function_exists( 'esotera_meta_format' ) ) :
function esotera_meta_format() {
	if ( 'post' !== get_post_type() ) return;
	$format = get_post_format();
	if ( current_theme_supports( 'post-formats', $format ) ) {
		printf( '<span class="entry-format"><a href="%1$s"><i class="icon-%2$s" title="%3$s"></i> %2$s</a></span>',
			esc_url( get_post_format_link( $format ) ),
			$format,
			get_post_format_string( $format )
		);
	}
}
endif;
if ( ! function_exists( 'esotera_meta_sticky' ) ) :
function esotera_meta_sticky() {
	if ( is_sticky() ) echo '<span class="entry-sticky">' . __('Featured', 'esotera') . '</span>';
}
endif;
function esotera_meta_infos() {
	if ( is_single() ) {
		add_action( 'cryout_post_meta_hook',	'esotera_posted_author_single', 10 );
		add_action( 'cryout_post_meta_hook',	'esotera_posted_date', 30 );
		add_action( 'cryout_post_meta_hook', 	'esotera_comments_on_single', 50 );
		add_action( 'cryout_post_title_hook',	'esotera_posted_category', 20 );
		add_action( 'cryout_post_title_hook',	'esotera_posted_edit', 60 );
		add_action( 'cryout_post_utility_hook',	'esotera_posted_tags', 40 );
	} else {
		add_action( 'cryout_post_meta_hook', 'esotera_posted_author', 15 );
		add_action( 'cryout_post_thumbnail_hook', 'esotera_comments_on', 50 );
		add_action( 'cryout_post_thumbnail_hook', 'esotera_posted_category', 20 );
		add_action( 'cryout_post_utility_hook',	'esotera_posted_tags', 30 );
		add_action( 'cryout_post_meta_hook', 'esotera_posted_date', 40 );
	}
	add_action( 'cryout_meta_format_hook', 'esotera_meta_format', 10 );
	add_action( 'cryout_post_title_hook', 'esotera_meta_sticky', 9 );
}
add_action( 'wp_head', 'esotera_meta_infos' );
function esotera_remove_category_tag( $text ) {
	$text = str_replace( 'rel="category tag"', 'rel="tag"', $text );
	return $text;
}
if ( ! function_exists( 'esotera_content_nav' ) ) :
function esotera_content_nav( $nav_id ) {
	global $wp_query;
	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $nav_id; ?>" class="navigation">
			<span class="nav-previous">
				 <?php next_posts_link( '<i class="icon-angle-left"></i>' . __( 'Older posts', 'esotera' ) ); ?>
			</span>
			<span class="nav-next">
				<?php previous_posts_link( __( 'Newer posts', 'esotera' ) . '<i class="icon-angle-right"></i>' ); ?>
			</span>
		</nav><!-- #<?php echo $nav_id; ?> -->
	<?php endif;
};
endif;
if ( ! function_exists( 'esotera_set_featured_srcset_picture' ) ) :
function esotera_set_featured_srcset_picture() {
	global $post;
	$options = cryout_get_option( array( 'theme_fpost', 'theme_fauto', 'theme_falign', 'theme_magazinelayout', 'theme_landingpage' ) );
	switch ( apply_filters( 'esotera_lppostslayout_filter', $options['theme_magazinelayout'] ) ) {
		case 3: $featured = 'esotera-featured-third'; break;
		case 2: $featured = 'esotera-featured-half'; break;
		case 1: default: $featured = 'esotera-featured'; break;
	}
	$use_srcset = apply_filters( 'esotera_featured_srcset', true );
	if ( function_exists('has_post_thumbnail') && has_post_thumbnail() && $options['theme_fpost']) {
		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'esotera-featured' );
		$fimage_id = get_post_thumbnail_id( $post->ID );
	} elseif ( $options['theme_fpost'] && $options['theme_fauto'] && empty($featured_image) ) {
		$featured_image = cryout_post_first_image( $post->ID, 'esotera-featured' );
		$fimage_id = $featured_image['id'];
	} else {
		$featured_image[0] = apply_filters('esotera_preview_img_src', '');
		$featured_image[1] = apply_filters('esotera_preview_img_w', '');
		$featured_image[2] = apply_filters('esotera_preview_img_h', '');
		$fimage_id = FALSE;
	};
	if ( ! empty( $featured_image[0] ) ) {
		$featured_width = esotera_featured_width();
		?>
		<div class="post-thumbnail-container" <?php cryout_schema_microdata( 'image' ); ?>>
			<div class="entry-meta">
				<?php do_action('cryout_post_thumbnail_hook'); ?>
			</div>
			<a class="post-featured-image" href="<?php echo esc_url( get_permalink( $post->ID ) ) ?>" title="<?php echo esc_attr( get_post_field( 'post_title', $post->ID ) ) ?>" <?php cryout_echo_bgimage( $featured_image[0] ) ?>>
			</a>
			<picture class="responsive-featured-image">
				<source media="(max-width: 1152px)" sizes="<?php echo cryout_gen_featured_sizes( $featured_width, $options['theme_magazinelayout'], $options['theme_landingpage'] ) ?>" srcset="<?php echo cryout_get_picture_src( $fimage_id, 'esotera-featured-third' ); ?> 512w">
				<source media="(max-width: 800px)" sizes="<?php echo cryout_gen_featured_sizes( $featured_width, $options['theme_magazinelayout'], $options['theme_landingpage'] ) ?>" srcset="<?php echo cryout_get_picture_src( $fimage_id, 'esotera-featured-half' ); ?> 800w">
				<?php if ( cryout_on_landingpage() ) { ?><source sizes="<?php echo cryout_gen_featured_sizes( $featured_width, $options['theme_magazinelayout'], $options['theme_landingpage'] ) ?>" srcset="<?php echo cryout_get_picture_src( $fimage_id, 'esotera-featured-lp' ); ?> <?php printf( '%sw', $featured_width ) ?>">
				<?php } ?>
				<img alt="<?php the_title_attribute();?>" <?php cryout_schema_microdata( 'url' ); ?> src="<?php echo cryout_get_picture_src( $fimage_id, 'esotera-featured' ); ?>" />
			</picture>
			<meta itemprop="width" content="<?php echo $featured_image[1]; // width ?>">
			<meta itemprop="height" content="<?php echo $featured_image[2]; // height ?>">
			<div class="featured-image-overlay">
				<a class="featured-image-link" href="<?php echo esc_url( get_permalink( $post->ID ) ) ?>" title="<?php echo esc_attr( get_post_field( 'post_title', $post->ID ) ) ?>"></a>
			</div>
		</div>
	<?php } else { ?>
		<div class="entry-meta">
			<?php do_action('cryout_post_thumbnail_hook'); ?>
		</div>
		<?php
	}
}
endif;
if ( cryout_get_option( 'theme_fpost' ) ) add_action( 'cryout_featured_hook', 'esotera_set_featured_srcset_picture' );
?>