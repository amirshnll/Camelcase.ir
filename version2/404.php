<?php get_header(); ?>
	<div id="container" class="<?php echo esotera_get_layout_class(); ?>">
		<main id="main" role="main" class="main">
			<?php cryout_before_content_hook(); ?>
			<header id="post-0" class="pad-container error404 not-found" <?php cryout_schema_microdata( 'element' ); ?>>
				<h1 class="entry-title" <?php cryout_schema_microdata( 'entry-title' ); ?>><?php _e( 'Not Found', 'esotera' ); ?></h1>
					<p <?php cryout_schema_microdata( 'text' ); ?>><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'esotera' ); ?></p>
					<?php get_search_form(); ?>
			</header>
			<?php cryout_empty_page_hook(); ?>
			<?php cryout_after_content_hook(); ?>
		</main>
		<?php esotera_get_sidebar(); ?>
	</div>
<?php get_footer(); ?>