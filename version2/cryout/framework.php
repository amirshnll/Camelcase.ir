<?php
define('_CRYOUT_FRAMEWORK_VERSION', '0.8.3');
if (!defined('_CRYOUT_THEME_REQUIRED_PHP')) define('_CRYOUT_THEME_REQUIRED_PHP', '5.3');
if (!defined('_CRYOUT_THEME_REQUIRED_WP')) define('_CRYOUT_THEME_REQUIRED_WP', '4.1');
if ( FALSE !== phpversion() && version_compare( phpversion(), _CRYOUT_THEME_REQUIRED_PHP, '<' ) ) {
	require get_template_directory() . '/cryout/back-compat-php.php';
}
elseif ( version_compare( $GLOBALS['wp_version'], _CRYOUT_THEME_REQUIRED_WP, '<' ) ) {
	require get_template_directory() . '/cryout/back-compat.php';
}
require_once(get_template_directory() . "/cryout/prototypes.php");
require_once(get_template_directory() . "/cryout/controls.php");
require_once(get_template_directory() . "/cryout/customizer.php");
require_once(get_template_directory() . "/cryout/ajax.php");
require_once(get_template_directory() . "/cryout/demo.php");
if( is_admin() ) {
	require_once(get_template_directory() . "/cryout/admin-functions.php");
	require_once(get_template_directory() . "/cryout/tgmpa-class.php");
}
add_action( 'customize_register', 'cryout_customizer_extras' );
add_action( 'customize_register', array( 'Cryout_Customizer', 'register' ) );
?>