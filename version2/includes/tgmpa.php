<?php
add_action( 'tgmpa_register', 'cryout_register_addon_plugins' );
function cryout_register_addon_plugins() {
	$plugins = array(
		array(
			'name'               => 'Cryout Serious Slider',
			'slug'               => 'cryout-serious-slider',
			'required'           => false,
			'version'            => '0.6',
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => 'Force Regenerate Thumbnails',
			'slug'               => 'force-regenerate-thumbnails',
			'required'           => false,
			'version'            => '2.0.0',
			'force_activation'   => false,
			'force_deactivation' => false,
		),
	);
	$config = array(
		'id'           => 'esotera',
		'default_path' => '',
		'menu'         => 'esotera-addons',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
		'strings'      => array(
			'page_title'                      => __( 'Esotera Suggested Plugins', 'cryout' ),
			'menu_title'                      => __( 'Esotera Addons', 'cryout' ),
			'installing'                      => __( 'Installing Plugin: %s', 'cryout' ),
			'updating'                        => __( 'Updating Plugin: %s', 'cryout' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 'cryout' ),
			'notice_can_install_required'     => _n_noop(
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				'cryout'
			),
			'notice_can_install_recommended'  => _n_noop(
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'cryout'
			),
			'notice_ask_to_update'            => _n_noop(
				'The following plugin should be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins should be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'cryout'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'cryout'
			),
			'notice_can_activate_required'    => _n_noop(
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'cryout'
			),
			'notice_can_activate_recommended' => _n_noop(
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'cryout'
			),
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'cryout'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'cryout'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'cryout'
			),
			'return'                          => __( 'Return to Suggested Plugins Installer', 'cryout' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'cryout' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'cryout' ),
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'cryout' ),
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'cryout' ),
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'cryout' ),
			'dismiss'                         => __( 'Dismiss this notice', 'cryout' ),
			'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'cryout' ),
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'cryout' ),
			'nag_type'                        => 'notice-info',
		),
	);
	tgmpa( $plugins, $config );
}
?>