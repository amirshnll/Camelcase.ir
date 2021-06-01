<?php
$cryout_demo_randomness = array( 6, 8, 1, 5, 2, 9, 7, 3, 4, 10 );
$cryout_demo_index = 0;
function cryout_demo_image_src(){
	global $cryout_demo_randomness;
	global $cryout_demo_index;
	if ( $cryout_demo_index >= count( $cryout_demo_randomness ) ) $cryout_demo_index=0;
	$filename = "{$cryout_demo_randomness[$cryout_demo_index]}.jpg";
	$cryout_demo_index++;
	return get_template_directory_uri() . '/resources/images/demo/' . $filename;
}
function cryout_demo_thumbnail( $input ) {
	if ( empty( $input ) ) {
		return cryout_demo_image_src();
	}
	return $input;
}
function cryout_is_demo() {
	$current_theme = wp_get_theme();
	$theme_slug = $current_theme->Template;
	$active_theme = cryout_get_wp_option( 'template' );
	return apply_filters( 'cryout_is_demo', ( $active_theme != strtolower( $theme_slug ) && ! is_child_theme() ) );
}
function cryout_get_wp_option( $opt_name ) {
	$alloptions = wp_cache_get( 'alloptions', 'options' );
	$alloptions = maybe_unserialize( $alloptions );
	return isset( $alloptions[ $opt_name ] ) ? maybe_unserialize( $alloptions[ $opt_name ] ) : false;
}
if ( cryout_is_demo() ) { add_filter( _CRYOUT_THEME_SLUG . '_preview_img_src', 'cryout_demo_thumbnail' ); }
?>