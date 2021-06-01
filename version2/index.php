<?php get_header(); ?>
<div id="container" class="<?php echo esotera_get_layout_class(); ?>">
	<main id="main" role="main" class="main">
		<?php cryout_before_content_hook(); ?>
		<?php if ( have_posts() ) : ?>
			<div id="content-masonry" class="content-masonry" <?php cryout_schema_microdata( 'blog' ); ?>>
				<?php
				while ( have_posts() ) : the_post();
					get_template_part( 'content/content', get_post_format() );
				endwhile;
				?>
			</div>
			<?php esotera_pagination(); ?>
		<?php else :
			get_template_part( 'content/content', 'notfound' );
		endif; ?>
		<?php cryout_after_content_hook(); ?>
	</main>
	<?php esotera_get_sidebar(); ?>
</div>
<?php get_footer(); ?>