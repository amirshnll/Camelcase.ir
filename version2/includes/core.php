<?php
if ( ! function_exists( 'esotera_content_width' ) ) :
function esotera_content_width() {
	global $content_width;
	$deviation = 0.85;
	$options = cryout_get_option( array(
		'theme_sitelayout', 'theme_landingpage', 'theme_magazinelayout', 'theme_sitewidth', 'theme_primarysidebar', 'theme_secondarysidebar',
   ) );
	$content_width = 0.98 * (int)$options['theme_sitewidth'];
	switch( $options['theme_sitelayout'] ) {
		case '2cSl': case '3cSl': case '3cSr': case '3cSs': $content_width -= (int)$options['theme_primarysidebar']; // primary sidebar
		case '2cSr': case '3cSl': case '3cSr': case '3cSs': $content_width -= (int)$options['theme_secondarysidebar']; break; // secondary sidebar
	}
	if ( is_front_page() && $options['theme_landingpage'] ) {
		$width = ceil( (int)$content_width / apply_filters('esotera_lppostslayout_filter', (int)$options['theme_magazinelayout']) );
		$content_width = ceil($width);
		return;
	}
	if ( is_archive() ) {
		switch ( $options['theme_magazinelayout'] ):
			case 1: $content_width = floor($content_width*0.4); break;
			case 2: $content_width = floor($content_width*0.94/2); break;
			case 3: $content_width = floor($content_width*0.94/3); break;
		endswitch;
	};
	$content_width = floor($content_width*$deviation);
}
endif;
if ( ! function_exists( 'esotera_featured_width' ) ) :
function esotera_featured_width() {
	$options = cryout_get_option( array(
		'theme_sitelayout', 'theme_landingpage', 'theme_magazinelayout', 'theme_sitewidth', 'theme_primarysidebar', 'theme_secondarysidebar',
		'theme_lplayout',
	) );
	$width = (int)$options['theme_sitewidth'];
	$deviation = 0.02 * $width;
	switch( $options['theme_sitelayout'] ) {
		case '2cSl': case '3cSl': case '3cSr': case '3cSs': $width -= (int)$options['theme_primarysidebar'] + $deviation;
		case '2cSr': case '3cSl': case '3cSr': case '3cSs': $width -= (int)$options['theme_secondarysidebar'] + $deviation; break;
	}
	if ( is_front_page() && $options['theme_landingpage'] ) {
		$width = ceil( (int)$options['theme_sitewidth'] / apply_filters('esotera_lppostslayout_filter', (int)$options['theme_magazinelayout'] ) );
		return ceil($width);
	}
	if ( ! is_singular() ) {
		switch ( $options['theme_magazinelayout'] ):
			case 1: $width = ceil($width*0.4); break;
			case 2: $width = ceil($width*0.94/2); break;
			case 3: $width = ceil($width*0.94/3); break;
		endswitch;
	};
	return ceil($width);
}
endif;
if ( ! function_exists( 'esotera_header_image_url' ) ) :
function esotera_header_image_url() {
	$headerlimits = cryout_get_option('theme_headerlimits');
	if ($headerlimits) $limit = 0.75; else $limit = 0;
	$theme_fheader = cryout_get_option( 'theme_fheader' );
	$theme_headerh = floor( cryout_get_option( 'theme_headerheight' ) * $limit );
	$theme_headerw = floor( cryout_get_option( 'theme_sitewidth' ) * $limit );
	global $post;
	$header_image = FALSE;
	if ( get_header_image() != '' ) { $header_image = get_header_image(); }
	if ( is_singular() && has_post_thumbnail( $post->ID ) && $theme_fheader &&
		( $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'esotera-header' ) )
		 ) :
			if ( ( absint($image[1]) >= $theme_headerw ) && ( absint($image[2]) >= $theme_headerh ) ) {
				$header_image = $image[0];
			} else {
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
				if ( ( absint($image[1]) >= $theme_headerw ) && ( absint($image[2]) >= $theme_headerh ) ) {
					$header_image = $image[0];
				} else {
				}
			}
	endif;
	return $header_image;
}
endif;
add_action ( 'cryout_headerimage_hook', 'esotera_header_image', 99 );
if ( ! function_exists( 'esotera_header_image' ) ) :
function esotera_header_image() {
	$header_image = esotera_header_image_url();
	if ( is_front_page() && function_exists( 'the_custom_header_markup' ) && has_header_video() ) {
		the_custom_header_markup();
	} elseif ( ! empty( $header_image ) ) { ?>
			<div id="header-overlay"></div>
			<div class="header-image" <?php echo cryout_echo_bgimage( esc_url( $header_image ) ) ?>></div>
			<img class="header-image" alt="<?php if ( is_single() ) the_title_attribute(); elseif ( is_archive() ) echo strip_tags( get_the_archive_title() ); else echo get_bloginfo( 'name' ) ?>" src="<?php echo esc_url( $header_image ) ?>" />
			<?php cryout_header_widget_hook(); ?>
	<?php }
}
endif;
if ( ! function_exists( 'esotera_title_and_description' ) ) :
function esotera_title_and_description() {
	$options = cryout_get_option( array( 'theme_logoupload', 'theme_siteheader' ) );
	if ( in_array( $options['theme_siteheader'], array( 'logo', 'both' ) ) ) {
		echo esotera_logo_helper( $options['theme_logoupload'] );
	}
	if ( in_array( $options['theme_siteheader'], array( 'title', 'both', 'logo', 'empty' ) ) ) {
		$heading_tag = ( is_front_page() || ( is_home() ) ) ? 'h1' : 'div';
		echo '<div id="site-text">';
		echo '<' . $heading_tag . cryout_schema_microdata( 'site-title', 0 ) . ' id="site-title">';
		echo '<span> <a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'description' ) ) . '" rel="home">' . esc_attr( get_bloginfo( 'name' ) ) . '</a> </span>';
		echo '</' . $heading_tag . '>';
		echo '<span id="site-description" ' . cryout_schema_microdata( 'site-description', 0 ) . ' >' . esc_attr( get_bloginfo( 'description' ) ). '</span>';
		echo '</div>';
	}
}
endif;
add_action ( 'cryout_branding_hook', 'esotera_title_and_description' );
function esotera_logo_helper( $theme_logo ) {
	if ( function_exists( 'the_custom_logo' ) ) {
		$wp_logo = str_replace( 'class="custom-logo-link"', 'id="logo" class="custom-logo-link" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '"', get_custom_logo() );
		if ( ! empty( $wp_logo ) ) return '<div class="identity">' . $wp_logo . '</div>';
	} else {
		if ( ! empty( $theme_logo ) ) :
			$img = wp_get_attachment_image_src( $theme_logo, 'full' );
			return '<div class="identity"><a id="logo" href="' . esc_url( home_url( '/' ) ) . '" ><img title="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'" alt="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'" src="' . esc_url( $img[0] ) . '" /></a></div>';
		endif;
	}
	return '';
}
add_action( 'cryout_after_inner_hook', 'cryout_schema_publisher' );
add_action( 'cryout_singular_after_inner_hook', 'cryout_schema_publisher' );
add_action( 'cryout_after_inner_hook', 'cryout_schema_main' );
add_action( 'cryout_singular_after_inner_hook', 'cryout_schema_main' );
function esotera_back_top() {
	echo '<a id="toTop"><span class="screen-reader-text">' . __('Back to Top', 'esotera') . '</span><i class="icon-back2top"></i> </a>';
}
add_action ( 'cryout_master_footerbottom_hook', 'esotera_back_top' );
if ( ! function_exists( 'esotera_pagination' ) ) :
function esotera_pagination( $pages = '', $range = 2, $prefix ='' ) {
	$pagination = cryout_get_option( 'theme_pagination' );
	if ( $pagination && function_exists( 'the_posts_pagination' ) ):
		the_posts_pagination( array(
			'prev_text' => '<i class="icon-pagination-left"></i>',
			'next_text' => '<i class="icon-pagination-right"></i>',
			'mid_size' => $range
		) );
	else:
		esotera_content_nav( 'nav-old-below' );
	endif;
}
endif;
if ( ! function_exists( 'esotera_nextpage_links' ) ) :
function esotera_nextpage_links( $defaults ) {
	$args = array(
		'link_before'      => '<em>',
		'link_after'       => '</em>',
	);
	$r = wp_parse_args( $args, $defaults );
	return $r;
}
endif;
add_filter( 'wp_link_pages_args', 'esotera_nextpage_links' );
add_action( 'cryout_master_footer_hook', 'esotera_master_footer' );
function esotera_master_footer() {
	$the_theme = wp_get_theme();
	do_action( 'cryout_footer_hook' );
	echo '<div style="display:block;float:right;clear: right;">' . __( "Powered by", "esotera" ) .
		'<a target="_blank" href="' . esc_html( $the_theme->get( 'ThemeURI' ) ) . '" title="';
	echo 'Esotera WordPress Theme by ' . 'Cryout Creations"> ' . 'Esotera' .'</a> &amp; <a target="_blank" href="' . "http://wordpress.org/";
	echo '" title="' . esc_attr__( "Semantic Personal Publishing Platform", "esotera") . '"> ' . sprintf( " %s", "WordPress" ) . '</a>.</div>';
}
add_action( 'cryout_master_footer_hook', 'esotera_copyright' );
function esotera_copyright() {
    echo '<div id="site-copyright">' . do_shortcode( wp_kses_post( cryout_get_option( 'theme_copyright' ) ) ). '</div>';
}
if ( ! function_exists( 'esotera_get_sidebar' ) ) :
function esotera_get_sidebar() {
	$layout = cryout_get_layout();
	switch( $layout ) {
		case '2cSl':
			get_sidebar( 'left' );
		break;
		case '2cSr':
			get_sidebar( 'right' );
		break;
		case '3cSl' : case '3cSr' : case '3cSs' :
			get_sidebar( 'left' );
			get_sidebar( 'right' );
		break;

		default:
		break;
	}
}
endif;
if ( ! function_exists( 'esotera_get_layout_class' ) ) :
function esotera_get_layout_class() {
	$layout = cryout_get_layout();
	switch( $layout ) {
		case '2cSl': $class = "two-columns-left"; break;
		case '2cSr': $class = "two-columns-right"; break;
		case '3cSl': $class = "three-columns-left"; break;
		case '3cSr' : $class = "three-columns-right"; break;
		case '3cSs' : $class = "three-columns-sided"; break;
		case '1c':
		default: return "one-column"; break;
	}
	return apply_filters( 'esotera_general_layout_class', $class, $layout );
}
endif;
add_filter( 'body_class', 'cryout_mobile_body_class');
if ( ! function_exists( 'esotera_breadcrumbs' ) ) :
function esotera_breadcrumbs() {
	cryout_breadcrumbs(
		'<i class="icon-bread-arrow"></i>',
		'<i class="icon-bread-home"></i>',
		1,
		'<span class="current">',
		'</span>',
		'<div id="breadcrumbs-container" class="cryout %1$s"><div id="breadcrumbs-container-inside"><div id="breadcrumbs"> <nav id="breadcrumbs-nav" %2$s>',
		'</nav></div></div></div><!-- breadcrumbs -->',
		esotera_get_layout_class(),
		__( 'Home', 'esotera' ),
		__( 'Archive for category', 'esotera' ),
		__( 'Search results for', 'esotera' ),
		__( 'Posts tagged', 'esotera' ),
		__( 'Articles posted by', 'esotera' ),
		__( 'Not Found', 'esotera' ),
		__( 'Post format', 'esotera' ),
		__( 'Page', 'esotera' )
	);
}
endif;
if ( ! function_exists( 'cryout_search_menu' ) ) :
function cryout_search_menu( $items, $args ) {
$options = cryout_get_option( array( 'theme_searchboxmain', 'theme_searchboxfooter' ) );
	if( $args->theme_location == 'primary' && $options['theme_searchboxmain'] ) {
		$container_class = 'menu-main-search';
		$items .= "<li class='" . $container_class . " menu-search-animated'>
			<a role='link' href=''><i class='icon-search2'></i><span class='screen-reader-text'>" . __('Search', 'esotera') . "</span></a>" . get_search_form( false ) . "
			<i class='icon-cancel'></i>
		</li>";
	}
	if( $args->theme_location == 'footer' && $options['theme_searchboxfooter'] ) {
		$container_class = 'menu-footer-search';
		$items .= "<li class='" . $container_class . "'>" . get_search_form( false ) . "</li>";
	}
	return $items;
}
endif;
if ( ! function_exists( 'cryout_burger_menu' ) ) :
function cryout_burger_menu( $items, $args = array() ) {
	$button_html = "<li class='menu-burger'>
			<button class='hamburger hamburger--squeeze' type='button'>
			  	<span class='hamburger-box'>
			    	<span class='hamburger-inner'></span>
			  </span>
			  <em>" . __('More', 'esotera') . "</em>
			</button>
		</li>";
	if (isset($args->theme_location)) {
		if( $args->theme_location == 'primary' ) {
			$items .= $button_html;
		}
	} elseif (isset($args['menu_id']) && ('prime_nav' == $args['menu_id'])) {
		$items = preg_replace( '/<\/ul>/is', $button_html . '</ul>', $items );
	};
	return $items;
}
endif;
if ( TRUE === cryout_get_option( 'theme_normalizetags' ) ) add_filter( 'wp_generate_tag_cloud', 'cryout_normalizetags' );
function esotera_preloader() {
	$theme_preloader = cryout_get_option( 'theme_preloader' );
	if ( ( $theme_preloader == 1) || ( $theme_preloader == 2 && (is_front_page() || is_home()) ) ): ?>
		<div class="cryout-preloader">
			<div class="cryout-preloader-inside">
				<div class="bounce1"></div>
				<div class="bounce2"></div>
			</div>
		</div>
	<?php endif;
}
add_action( 'cryout_body_hook', 'esotera_preloader' );
if ( ! function_exists( 'esotera_master_hook' ) ) :
function esotera_master_hook() {
	$theme_interim_options = cryout_get_option( array(
		'theme_breadcrumbs',
		'theme_searchboxmain',
		'theme_searchboxfooter',
		'theme_comlabels')
	);
	if ( $theme_interim_options['theme_breadcrumbs'] )  add_action( 'cryout_main_hook', 'esotera_breadcrumbs' );
	if ( $theme_interim_options['theme_searchboxmain'] || $theme_interim_options['theme_searchboxfooter'] ) add_filter( 'wp_nav_menu_items', 'cryout_search_menu', 10, 2);
	if ( has_nav_menu( 'top' ) ) add_filter( 'wp_nav_menu_items', 'cryout_burger_menu', 10, 2);
	if ( has_nav_menu( 'top' ) ) add_filter( 'wp_page_menu', 'cryout_burger_menu', 12, 2);
	if ( $theme_interim_options['theme_comlabels'] == 1) {
		add_filter( 'comment_form_default_fields', 'esotera_comments_form' );
		add_filter( 'comment_form_field_comment', 'esotera_comments_form_textarea' );
	}
	if ( cryout_get_option( 'theme_socials_header' ) ) 		add_action( 'cryout_header_socials_hook', 'esotera_socials_menu_header', 10 );
	if ( cryout_get_option( 'theme_socials_footer' ) ) 		add_action( 'cryout_master_footerbottom_hook', 'esotera_socials_menu_footer', 17 );
	if ( cryout_get_option( 'theme_socials_left_sidebar' ) ) 	add_action( 'cryout_before_primary_widgets_hook', 'esotera_socials_menu_left', 5 );
	if ( cryout_get_option( 'theme_socials_right_sidebar' ) ) 	add_action( 'cryout_before_secondary_widgets_hook', 'esotera_socials_menu_right', 5 );
};
endif;
add_action( 'wp', 'esotera_master_hook' );
function esotera_lpbox_width( $options = array() ) {
	if ( $options['theme_lpboxlayout1'] == 1 ) {
		$totalwidth = 1920;
	} else {
		$totalwidth = $options['theme_sitewidth'];
	}
	if ( $options['theme_lpboxanimation1'] === 2 ) { $totalwidth = $totalwidth / 2; }
	$options['theme_lpboxwidth1'] = intval ( $totalwidth / $options['theme_lpboxrow1'] );

	if ( $options['theme_lpboxlayout2'] == 1 ) {
		$totalwidth = 1920;
	} else {
		$totalwidth = $options['theme_sitewidth'];
	}
	if ( $options['theme_lpboxanimation2'] === 2 ) { $totalwidth = $totalwidth / 2; }
	$options['theme_lpboxwidth2'] = intval ( $totalwidth / $options['theme_lpboxrow2'] );
	return $options;
}
function esotera_custom_excerpt( $text = '', $length = 35, $more = '...' ) {
	$raw_excerpt = $text;
	$moretag = false;
	if (strpos( $text, '<!--nextpage-->' )) $explodemore = explode('<!--nextpage-->', $text);
	if (strpos( $text, '<!--more-->' )) $explodemore = explode('<!--more-->', $text);
	if (!empty($explodemore[1])) {
		$text = $explodemore[0];
		$moretag = true;
	}
	if ( '' != $text ) {
		$text = strip_shortcodes( $text );
		$text = str_replace(']]>', ']]&gt;', $text);
		$excerpt_length = apply_filters( 'esotera_custom_excerpt_length', $length );
		if ($excerpt_length == 0) return '';
		$excerpt_more = apply_filters( 'esotera_custom_excerpt_more', $more );
		if (!$moretag) {
			$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
		}
	}
	return apply_filters( 'esotera_custom_excerpt', $text, $raw_excerpt );
}
add_action( 'template_redirect', 'cryout_ajax_init' ); ?>