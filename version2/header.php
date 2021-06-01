<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<?php cryout_meta_hook(); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php cryout_header_hook(); wp_head(); ?>
</head>
<body <?php body_class(); cryout_schema_microdata( 'body' );?>>
	<?php wp_body_open(); ?>
	<?php cryout_body_hook(); ?>
<div id="site-wrapper">
	<header id="masthead" class="cryout" <?php cryout_schema_microdata( 'header' ) ?> role="banner">
		<div id="site-header-main">
			<div class="site-header-top">
				<div class="site-header-inside">
					<?php do_action( 'cryout_top_section_hook' ) ?>
					<div id="top-section-menu" role="navigation"  aria-label="<?php esc_attr_e( 'Top Menu', 'esotera' ) ?>" <?php cryout_schema_microdata( 'menu' ); ?>>
						<?php cryout_topmenu_hook(); ?>
					</div>
					<i class="icon-cancel icon-cancel-hamburger"></i>
				</div>
			</div>
			<nav id="mobile-menu">
				<span id="nav-cancel"><i class="icon-cancel"></i></span>
				<?php cryout_mobilemenu_hook(); ?>
			</nav>
			<div class="site-header-bottom">
				<div class="site-header-bottom-fixed">
					<div class="site-header-inside">
						<div id="branding">
							<?php cryout_branding_hook();?>
						</div>
						<a id="nav-toggle"><i class="icon-menu"></i></a>
						<nav id="access" role="navigation"  aria-label="<?php esc_attr_e( 'Primary Menu', 'esotera' ) ?>" <?php cryout_schema_microdata( 'menu' ); ?>>
							<?php cryout_access_hook();?>
						</nav>
					</div>
				</div>
			</div>
		</div>
		<div id="header-image-main">
			<div id="header-image-main-inside">
				<?php cryout_headerimage_hook(); ?>
			</div>
		</div>
	</header>
	<?php cryout_breadcrumbs_hook(); ?>
	<?php cryout_absolute_top_hook(); ?>
	<div id="content" class="cryout">
		<?php cryout_main_hook(); ?>