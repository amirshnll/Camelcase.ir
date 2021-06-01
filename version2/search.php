<?php get_header(); ?>
	<div id="container" class="<?php echo esotera_get_layout_class(); ?>">
		<main id="main" role="main" class="main">
			<?php cryout_before_content_hook(); ?>
			<?php if ( have_posts() ) : ?>
				<header class="page-header content-search pad-container" <?php cryout_schema_microdata( 'element' ); ?>>
					<h1 class="page-title" <?php cryout_schema_microdata( 'entry-title' ); ?>>
						<?php printf( __( 'Search Results for: %s', 'esotera' ), '<strong>' . get_search_query() . '</strong>' ); ?>
					</h1><br>
					<?php get_search_form(); ?>
				</header>
				<div id="content-masonry" class="content-masonry" <?php cryout_schema_microdata( 'blog' ); ?>>
					<?php
					while ( have_posts() ) : the_post();
						get_template_part( 'content/content', get_post_format() );
					endwhile;
					?>
				</div>
				<?php
				esotera_pagination();
			else :
				get_template_part( 'content/content', 'notfound' );
				?> <div id="content-masonry"></div> <?php
				cryout_empty_page_hook();
			endif; ?>
			<?php cryout_after_content_hook(); ?>
		</main>
		<?php esotera_get_sidebar(); ?>
	</div>
<?php get_footer(); ?>