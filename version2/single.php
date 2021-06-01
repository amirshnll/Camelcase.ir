<?php get_header();
if ( 2 == cryout_get_option( 'theme_singlenav' ) ) { ?>
	<nav id="nav-fixed">
		<div class="nav-previous"><?php previous_post_link( '%link', '<i class="icon-fixed-nav"></i>' );  previous_post_link( '%link', '<span>%title</span>' );  ?></div>
		<div class="nav-next"><?php next_post_link( '%link', '<i class="icon-fixed-nav"></i>' ); next_post_link( '%link', '<span>%title</span>' );  ?></div>
	</nav>
<?php } ?>
<div id="container" class="<?php echo esotera_get_layout_class(); ?>">
	<main id="main" role="main" class="main">
		<?php cryout_before_content_hook(); ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); cryout_schema_microdata( 'article' );?>>
				<div class="schema-image">
					<?php cryout_featured_hook(); ?>
				</div>
				<div class="article-inner">
					<header>
						<div class="entry-meta beforetitle-meta">
							<?php cryout_post_title_hook(); ?>
						</div>
						<?php the_title( '<h1 class="entry-title singular-title" ' . cryout_schema_microdata('entry-title', 0) . '>', '</h1>' ); ?>
						<div class="entry-meta aftertitle-meta">
							<?php cryout_post_meta_hook(); ?>
						</div>
					</header>
					<?php cryout_singular_before_inner_hook();  ?>
					<div class="entry-content" <?php cryout_schema_microdata('entry-content'); ?>>
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'esotera' ), 'after' => '</span></div>' ) ); ?>
					</div>
					<footer class="entry-meta entry-utility">
						<?php cryout_post_utility_hook(); ?>
					</footer>
				</div>
				<?php cryout_singular_after_inner_hook();  ?>
			</article>
					<?php if ( get_the_author_meta( 'description' ) ) {
							get_template_part( 'content/author-bio' );
					} ?>
					<?php if ( 1 == cryout_get_option ('theme_singlenav') ) : ?>
						<nav id="nav-below" class="navigation" role="navigation">
							<div class="nav-previous"><em><?php _e('Previous Post', 'esotera');?></em><?php previous_post_link( '%link', '<span>%title</span>' ); ?></div>
							<div class="nav-next"><em><?php _e('Next Post', 'esotera');?></em><?php next_post_link( '%link', '<span>%title</span>' ); ?></div>
						</nav>
					<?php endif; ?>
					<?php cryout_singular_before_comments_hook();  ?>
					<?php comments_template( '', true ); ?>
		<?php endwhile; ?>
		<?php cryout_after_content_hook(); ?>
	</main>
	<?php esotera_get_sidebar(); ?>
</div>
<?php get_footer(); ?>