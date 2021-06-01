<?php get_header(); ?>
	<div id="container" class="<?php echo esotera_get_layout_class(); ?>">
		<main id="main" role="main" class="main">
			<?php cryout_before_content_hook(); ?>
			<?php get_template_part( 'content/content', 'page' ); ?>
			<?php cryout_after_content_hook(); ?>
		</main>
		<?php esotera_get_sidebar(); ?>
	</div>
<?php get_footer(); ?>