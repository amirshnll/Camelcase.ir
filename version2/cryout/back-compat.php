<?php
function cryout_compat_notice_text() {
	return sprintf( __( '<strong>%1$s requires at least WordPress version %2$s. Your site is running version %3$s.</strong><br>The theme will not be able to function on the curent setup. Please upgrade.', 'cryout' ), ucwords(preg_replace('/[^a-z0-9]/i',' ',_CRYOUT_THEME_NAME)), _CRYOUT_THEME_REQUIRED_WP, $GLOBALS['wp_version'] );
}
function cryout_compat_upgrade_notice() {
	printf( '<div class="notice notice-error"><br><p>%s</p><br></div>', cryout_compat_notice_text() );
}
add_action( 'admin_notices', 'cryout_compat_upgrade_notice' );

function cryout_compat_customize_notice() {
	wp_die( cryout_compat_notice_text(), '', array( 'back_link' => true, ) );
}
add_action( 'load-customize.php', 'cryout_compat_customize_notice' );

function cryout_compat_preview_notice() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( cryout_compat_notice_text() );
	}
}
add_action( 'template_redirect', 'cryout_compat_preview_notice' );
if (!is_admin()) die();
?>