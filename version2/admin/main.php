<?php
require_once( get_template_directory() . "/admin/defaults.php" );
require_once( get_template_directory() . "/admin/options.php" );
require_once( get_template_directory() . "/includes/tgmpa.php" );
require_once( get_template_directory() . "/includes/custom-styles.php" );
$cryout_theme_settings = apply_filters( 'esotera_theme_structure_array', $esotera_big );
$cryout_theme_options = esotera_get_theme_options();
$cryout_theme_defaults = esotera_get_option_defaults();
function esotera_get_theme_options() {
	$options = wp_parse_args(
		get_option( 'esotera_settings', array() ),
		esotera_get_option_defaults()
	);
	$options = cryout_maybe_migrate_options( $options );
	return apply_filters( 'esotera_theme_options_array', $options );
}
function esotera_get_theme_structure() {
	global $esotera_big;
	return apply_filters( 'esotera_theme_structure_array', $esotera_big );
}
add_action( 'admin_menu', 'esotera_add_page_fn' );
function esotera_admin_scripts( $hook ) {
	global $esotera_page;
	if( $esotera_page != $hook ) {
        	return;
	}
	wp_enqueue_style( 'wp-jquery-ui-dialog' );
	wp_enqueue_style( 'esotera-admin-style', get_template_directory_uri() . '/admin/css/admin.css', NULL, _CRYOUT_THEME_VERSION );
	wp_enqueue_script( 'esotera-admin-js',get_template_directory_uri() . '/admin/js/admin.js', array('jquery-ui-dialog'), _CRYOUT_THEME_VERSION );
	$js_admin_options = array(
		'reset_confirmation' => esc_html( __( 'Reset Esotera Settings to Defaults?', 'esotera' ) ),
	);
	wp_localize_script( 'esotera-admin-js', 'cryout_admin_settings', $js_admin_options );
}
function esotera_add_page_fn() {
	global $esotera_page;
	$esotera_page = add_theme_page( __( 'Esotera Theme', 'esotera' ), __( 'Esotera Theme', 'esotera' ), 'edit_theme_options', 'about-esotera-theme', 'esotera_page_fn' );
	add_action( 'admin_enqueue_scripts', 'esotera_admin_scripts' );
}
function esotera_page_fn() {
	if (!current_user_can('edit_theme_options'))  {
		wp_die( __( 'Sorry, but you do not have sufficient permissions to access this page.', 'esotera') );
	}

?>
<div class="wrap" id="main-page">
	<div id="lefty">
	<?php if( isset($_GET['settings-loaded']) ) { ?>
		<div class="updated fade">
			<p><?php _e('Esotera settings loaded successfully.', 'esotera') ?></p>
		</div> <?php
	} ?>
	<?php
	if ( isset( $_POST['cryout_reset_defaults'] ) ) {
		delete_option( 'esotera_settings' ); ?>
		<div class="updated fade">
			<p><?php _e('Esotera settings have been reset successfully.', 'esotera') ?></p>
		</div> <?php
	} ?>
		<div id="admin_header">
			<img src="<?php echo get_template_directory_uri() . '/admin/images/logo-about-top.png' ?>" />
			<span class="version">
				<?php _e( 'Esotera Theme', 'esotera' ) ?> v<?php echo _CRYOUT_THEME_VERSION; ?> by
				<a href="https://www.cryoutcreations.eu" target="_blank">Cryout Creations</a><br>
				<?php do_action( 'cryout_admin_version' ); ?>
			</span>
		</div>
		<div id="admin_links">
			<a href="https://www.cryoutcreations.eu/wordpress-themes/esotera" target="_blank"><?php _e( 'Read the Docs', 'esotera' ) ?></a>
			<a href="https://www.cryoutcreations.eu/forums/f/wordpress/esotera" target="_blank"><?php _e( 'Browse the Forum', 'esotera' ) ?></a>
			<a class="blue-button" href="https://www.cryoutcreations.eu/priority-support" target="_blank"><?php _e( 'Priority Support', 'esotera' ) ?></a>
		</div>
		<br>
		<div id="description">
			<?php
				$theme = wp_get_theme();
			 	echo esc_html( $theme->get( 'Description' ) );
			?>
		</div>
		<br>
		<div id="customizer-container">
			<a class="button" href="customize.php" id="customizer"> <?php printf( __( 'Customize %s', 'esotera' ), ucwords(_CRYOUT_THEME_NAME) ); ?> </a>
		</div>
		<div id="cryout-export">
			<div>
			<h3 class="hndle"><?php _e( 'Manage Theme Settings', 'esotera' ); ?></h3>

				<form action="" method="post" class="third">
					<input type="hidden" name="cryout_reset_defaults" value="true" />
					<input type="submit" class="button" id="cryout_reset_defaults" value="<?php _e( 'Reset to Defaults', 'esotera' ); ?>" />
				</form>
			</div>
		</div>
	</div>
	<div id="righty">
		<div id="cryout-donate" class="postbox donate">
			<h3 class="hndle"><?php _e( 'Upgrade to Plus', 'esotera' ); ?></h3>
			<div class="inside">
				<p><?php printf( __('Find out what features you\'re missing out on and how the Plus version of %1$s can improve your site.', 'esotera'), cryout_sanitize_tnl(_CRYOUT_THEME_NAME) ); ?></p>
				<a class="button" href="https://www.cryoutcreations.eu/wordpress-themes/esotera" target="_blank" style="display: block;"><?php _e( 'Upgrade to Plus', 'esotera' ); ?></a>
			</div>
		</div>
		<div id="cryout-news" class="postbox news">
			<h3 class="hndle"><?php _e( 'Theme Updates', 'esotera' ); ?></h3>
			<div class="panel-wrap inside">
			</div>
		</div>
	</div>
</div>
<?php } ?>