<?php
if (! function_exists( 'cryout_ajax_init' ) ):
function cryout_ajax_init() {
	$identifiers = cryout_get_theme_structure( 'theme_identifiers' );
	$options = cryout_get_option( array(
		_CRYOUT_THEME_PREFIX . '_landingpage',
		_CRYOUT_THEME_PREFIX . '_lppostscount'
	) );

	if ( cryout_on_landingpage() ) {
		$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
		$the_query = new WP_Query(
			apply_filters( 'cryout_landingpage_indexquery',
				array(
					'posts_per_page' => $options[ _CRYOUT_THEME_PREFIX . '_lppostscount'],
					'paged' => $paged
				)
			)
		);
	} else {
		return;
	}
	wp_enqueue_script(
		'cryout_ajax_more',
		get_template_directory_uri(). '/resources/js/ajax.js',
		array('jquery'),
		_CRYOUT_THEME_VERSION,
		true
	);
	$page_number_max = $the_query->max_num_pages;
	$page_number_next = (get_query_var('paged') > 1) ? get_query_var('paged') + 1 : 2;
	wp_localize_script(
		'cryout_ajax_more',
		'cryout_ajax_more',
		array(
			'page_number_next' => $page_number_next,
			'page_number_max' => $page_number_max,
			'page_link_model' => get_pagenum_link(9999999),
			'load_more_str' => cryout_get_option( $identifiers['load_more_optid'] ),
			'content_css_selector' => $identifiers['content_css_selector'],
			'pagination_css_selector' =>  $identifiers['pagination_css_selector'],
		)
	);
}
endif;
if ( 'posts' == get_option( 'show_on_front' )) add_action( 'template_redirect', 'cryout_ajax_init' );
?>