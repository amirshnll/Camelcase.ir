<?php
add_action( 'after_setup_theme', 'esotera_content_width' );
add_action( 'template_redirect', 'esotera_content_width' );
add_action( 'after_setup_theme', 'esotera_setup' );
function esotera_setup() {
	add_filter( 'esotera_theme_options_array', 'esotera_lpbox_width' );
	$options = cryout_get_option();
	if ($options['theme_editorstyles']) add_editor_style( 'resources/styles/editor-style.css' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
	add_theme_support( 'post-formats', array( 'aside', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'audio', 'video' ) );
	load_theme_textdomain( 'esotera', get_template_directory() . '/cryout/languages' );
	load_theme_textdomain( 'esotera', get_template_directory() . '/languages' );
	load_textdomain( 'cryout', '' );
	add_theme_support( 'custom-background' );
	add_theme_support( 'custom-logo', array( 'height' => (int) $options['theme_headerheight'], 'width' => 240, 'flex-height' => true, 'flex-width'  => true ) );
	add_filter( 'get_custom_logo', 'cryout_filter_wp_logo_img' );
	register_nav_menus( array(
		'primary'	=> __( 'Primary Navigation', 'esotera' ),
		'top'		=> __( 'Side Navigation', 'esotera' ),
		'sidebar'	=> __( 'Left Sidebar', 'esotera' ),
		'footer'	=> __( 'Footer Navigation', 'esotera' ),
		'socials'	=> __( 'Social Icons', 'esotera' ),
	) );
	$fheight = $options['theme_fheight'];
	$falign = (bool)$options['theme_falign'];
	if (false===$falign) {
		$fheight = 0;
	} else {
		$falign = explode( ' ', $options['theme_falign'] );
		if (!is_array($falign) ) $falign = array( 'center', 'center' );
	}
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size(
		apply_filters( 'esotera_thumbnail_image_width', esotera_featured_width() ),
		apply_filters( 'esotera_thumbnail_image_height', $options['theme_fheight'] ),
		false
	);
	add_image_size( 'esotera-featured',
		apply_filters( 'esotera_featured_image_width', esotera_featured_width() ),
		apply_filters( 'esotera_featured_image_height', $fheight ),
		$falign
	);
	add_image_size( 'esotera-featured-lp',
		apply_filters( 'esotera_featured_image_lp_width', ceil( $options['theme_sitewidth'] / apply_filters( 'esotera_lppostslayout_filter', $options['theme_magazinelayout'] ) ) ),
		apply_filters( 'esotera_featured_image_lp_height', $options['theme_fheight'] ),
		$falign
	);
	add_image_size( 'esotera-featured-half',
		apply_filters( 'esotera_featured_image_half_width', 800 ),
		apply_filters( 'esotera_featured_image_falf_height', $options['theme_fheight'] ),
		$falign
	);
	add_image_size( 'esotera-featured-third',
		apply_filters( 'esotera_featured_image_third_width', 512 ),
		apply_filters( 'esotera_featured_image_third_height', $options['theme_fheight'] ),
		$falign
	);
	add_image_size( 'esotera-lpbox-1', $options['theme_lpboxwidth1'], $options['theme_lpboxheight1'], true );
	add_image_size( 'esotera-lpbox-2', $options['theme_lpboxwidth2'], $options['theme_lpboxheight2'], true );
	add_theme_support( 'custom-header', array(
		'flex-height' 	=> true,
		'height'		=> (int) $options['theme_headerheight'],
		'flex-width'	=> true,
		'width'			=> 1920,
		'default-image'	=> get_template_directory_uri() . '/resources/images/headers/under-the-bridge.jpg',
		'video'         => true,
	));
	register_default_headers( array(
		'under-the-bridge' => array(
			'url' => '%s/resources/images/headers/under-the-bridge.jpg',
			'thumbnail_url' => '%s/resources/images/headers/under-the-bridge.jpg',
			'description' => __( 'Under the bridge', 'esotera' )
		),
		'lights' => array(
			'url' => '%s/resources/images/headers/lights.jpg',
			'thumbnail_url' => '%s/resources/images/headers/lights.jpg',
			'description' => __( 'Lights', 'esotera' )
		),
	) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-color-palette', array(
		array(
			'name' => __( 'Accent #1', 'esotera' ),
			'slug' => 'accent-1',
			'color' => $options['theme_accent1'],
		),
		array(
			'name' => __( 'Accent #2', 'esotera' ),
			'slug' => 'accent-2',
			'color' => $options['theme_accent2'],
		),
		array(
			'name' => __( 'Content Headings', 'esotera' ),
			'slug' => 'headings',
			'color' => $options['theme_headingstext'],
		),
 		array(
			'name' => __( 'Site Text', 'esotera' ),
			'slug' => 'sitetext',
			'color' => $options['theme_sitetext'],
		),
		array(
			'name' => __( 'Content Background', 'esotera' ),
			'slug' => 'sitebg',
			'color' => $options['theme_contentbackground'],
		),
 	) );
	add_theme_support( 'editor-font-sizes', array(
		array(
			'name' => __( 'small', 'cryout' ),
			'shortName' => __( 'S', 'cryout' ),
			'size' => intval( intval( $options['theme_fgeneralsize'] ) / 1.6 ),
			'slug' => 'small'
		),
		array(
			'name' => __( 'regular', 'cryout' ),
			'shortName' => __( 'M', 'cryout' ),
			'size' => intval( intval( $options['theme_fgeneralsize'] ) * 1.0 ),
			'slug' => 'regular'
		),
		array(
			'name' => __( 'large', 'cryout' ),
			'shortName' => __( 'L', 'cryout' ),
			'size' => intval( intval( $options['theme_fgeneralsize'] ) * 1.6 ),
			'slug' => 'large'
		),
		array(
			'name' => __( 'larger', 'cryout' ),
			'shortName' => __( 'XL', 'cryout' ),
			'size' => intval( intval( $options['theme_fgeneralsize'] ) * 2.56 ),
			'slug' => 'larger'
		)
	) );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
function esotera_gutenberg_editor_styles() {
	$editorstyles = cryout_get_option('theme_editorstyles');
	if ( ! $editorstyles ) return;
	wp_enqueue_style( 'esotera-gutenberg-editor-styles', get_theme_file_uri( '/resources/styles/gutenberg-editor.css' ), false, _CRYOUT_THEME_VERSION, 'all' );
	wp_add_inline_style( 'esotera-gutenberg-editor-styles', preg_replace( "/[\n\r\t\s]+/", " ", esotera_editor_styles() ) );
}
add_action( 'enqueue_block_editor_assets', 'esotera_gutenberg_editor_styles' );
function esotera_override_load_textdomain( $override, $domain ) {
	if ( 'cryout' === $domain ) {
		global $l10n;
		if ( isset( $l10n[ 'esotera' ] ) )
			$l10n[ $domain ] = $l10n[ 'esotera' ];
		$override = true;
	}
	return $override;
}
add_filter( 'override_load_textdomain', 'esotera_override_load_textdomain', 10, 2 );
function esotera_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'esotera_page_menu_args' );
function esotera_main_menu() { ?>
	<div class="skip-link screen-reader-text">
		<a href="#main" title="<?php esc_attr_e( 'Skip to content', 'esotera' ); ?>"> <?php _e( 'Skip to content', 'esotera' ); ?> </a>
	</div>
	<?php
	wp_nav_menu( array(
		'container'		=> '',
		'menu_id'		=> 'prime_nav',
		'menu_class'	=> '',
		'theme_location'=> 'primary',
		'link_before'	=> '<span>',
		'link_after'	=> '</span>',
		'items_wrap'	=> '<div><ul id="%s" class="%s">%s</ul></div>'

	) );
}
add_action ( 'cryout_access_hook', 'esotera_main_menu' );
function esotera_mobile_menu() {
	wp_nav_menu( array(
		'container'		=> '',
		'menu_id'		=> 'mobile-nav',
		'menu_class'	=> '',
		'theme_location'=> 'primary',
		'link_before'	=> '<span>',
		'link_after'	=> '</span>',
		'items_wrap'	=> '<div><ul id="%s" class="%s">%s</ul></div>'
	) );
}
add_action ( 'cryout_mobilemenu_hook', 'esotera_mobile_menu' );
function esotera_top_menu() {
	if ( has_nav_menu( 'top' ) )
		wp_nav_menu( array(
			'container' 		=> 'nav',
			'container_class'	=> 'topmenu',
			'theme_location'	=> 'top',
			'after'				=> '<span class="sep"> </span>',
			'depth'				=> 1,
			'fallback_cb' 		=> 'wp_page_menu'
		) );
}
add_action ( 'cryout_topmenu_hook', 'esotera_top_menu' );
function esotera_sidebar_menu() {
	if ( has_nav_menu( 'sidebar' ) )
		wp_nav_menu( array(
			'container'			=> 'nav',
			'container_class'	=> 'sidebarmenu widget-container',
			'theme_location'	=> 'sidebar',
			'depth'				=> 1
		) );
}
add_action ( 'cryout_before_primary_widgets_hook', 'esotera_sidebar_menu' , 10 );
function esotera_footer_menu() {
	if ( has_nav_menu( 'footer' ) )
		wp_nav_menu( array(
			'container' 		=> 'nav',
			'container_class'	=> 'footermenu',
			'theme_location'	=> 'footer',
			'after'				=> '<span class="sep">/</span>',
			'depth'				=> 1
		) );
}
add_action ( 'cryout_master_footerbottom_hook', 'esotera_footer_menu' , 10 );
function esotera_socials_menu( $location ) {
	if ( has_nav_menu( 'socials' ) )
		echo strip_tags(
			wp_nav_menu( array(
				'container' => 'nav',
				'container_class' => 'socials',
				'container_id' => $location,
				'theme_location' => 'socials',
				'link_before' => '<span>',
				'link_after' => '</span>',
				'depth' => 0,
				'items_wrap' => '%3$s',
				'walker' => new Cryout_Social_Menu_Walker(),
				'echo' => false,
			) ),
		'<a><div><span><nav>'
		);
}
function esotera_socials_menu_header() { ?>
	<div id="top-section-widget">
		<div class="widget-top-section-inner">
			<section class="top-section-element widget_cryout_socials">
			    <h6 class="social_top_myadd">ما را در شبکه های اجتماعی دنبال کنید.</h6>
				<div class="widget-socials">
					<?php esotera_socials_menu( 'sheader' ) ?>
				</div>
			</section>
		</div>
	</div><?php
}
function esotera_socials_menu_footer() { esotera_socials_menu( 'sfooter' ); }
function esotera_socials_menu_left()   { esotera_socials_menu( 'sleft' );   }
function esotera_socials_menu_right()  { esotera_socials_menu( 'sright' );  }
function cryout_widgets_init() {
	$areas = cryout_get_theme_structure( 'widget-areas' );
	if ( ! empty( $areas ) ):
		foreach ( $areas as $aid => $area ):
			register_sidebar( array(
				'name' 			=> $area['name'],
				'id' 			=> $aid,
				'description' 	=> ( isset( $area['description'] ) ? $area['description'] : '' ),
				'before_widget' => $area['before_widget'],
				'after_widget' 	=> $area['after_widget'],
				'before_title' 	=> $area['before_title'],
				'after_title' 	=> $area['after_title'],
			) );
		endforeach;
	endif;
}
add_action( 'widgets_init', 'cryout_widgets_init' );
function esotera_footer_colophon_class() {
	$opts = cryout_get_option( array( 'theme_footercols', 'theme_footeralign' ) );
	$class = '';
	switch ( $opts['theme_footercols'] ) {
		case '0': 	$class = 'all';		break;
		case '1':	$class = 'one';		break;
		case '2':	$class = 'two';		break;
		case '3':	$class = 'three';	break;
		case '4':	$class = 'four';	break;
	}
	if ( !empty($class) ) echo 'class="footer-' . $class . ' ' . ( $opts['theme_footeralign'] ? 'footer-center' : '' ) . '"';
}
function esotera_widget_header() {
	$headerimage_on_lp = cryout_get_option( 'theme_lpslider' );
	if ( is_active_sidebar( 'widget-area-header' ) && ( !cryout_on_landingpage() || ( cryout_on_landingpage() && ($headerimage_on_lp == 3) ) ) ) { ?>
		<aside id="header-widget-area" <?php cryout_schema_microdata( 'sidebar' ); ?>>
			<?php dynamic_sidebar( 'widget-area-header' ); ?>
		</aside><?php
	}
}
function esotera_widget_before() {
	if ( is_active_sidebar( 'content-widget-area-before' ) ) { ?>
		<aside class="content-widget content-widget-before" <?php cryout_schema_microdata( 'sidebar' ); ?>>
			<?php dynamic_sidebar( 'content-widget-area-before' ); ?>
		</aside><?php
	}
}
function esotera_widget_after() {
	if ( is_active_sidebar( 'content-widget-area-after' ) ) { ?>
		<aside class="content-widget content-widget-after" <?php cryout_schema_microdata( 'sidebar' ); ?>>
			<?php dynamic_sidebar( 'content-widget-area-after' ); ?>
		</aside><?php
	}
}
function esotera_widget_top_section() {
	if ( is_active_sidebar( 'widget-area-top-section' ) ) { ?>
		<div id="top-section-widget">
			<div class="widget-top-section-inner">
				<?php dynamic_sidebar( 'widget-area-top-section' ); ?>
			</div>
		</div><?php
	} else {
		do_action('cryout_header_socials_hook');
	}
}
add_action( 'cryout_header_widget_hook',  'esotera_widget_header' );
add_action( 'cryout_before_content_hook', 'esotera_widget_before' );
add_action( 'cryout_after_content_hook',  'esotera_widget_after' );
add_action( 'cryout_top_section_hook',    'esotera_widget_top_section' );
?>