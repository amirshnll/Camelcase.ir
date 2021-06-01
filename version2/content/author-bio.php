<?php
$theme_heading_tag = ( is_single() ) ? 'h4' : 'h1';
?>
<?php if ( get_the_author_meta( 'description' ) ) : ?>
<section id="author-info" <?php cryout_schema_microdata( 'author' ); ?>>
		<div id="author-avatar" <?php cryout_schema_microdata( 'image' );?>>
			<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'esotera_author_bio_avatar_size', 80 ), '', '', array( 'extra_attr' => cryout_schema_microdata( 'url', 0) ) ); ?>
		</div>
		<div id="author-description"  <?php cryout_schema_microdata( 'author-description' ); ?>>
			<<?php echo $theme_heading_tag ?> class="page-title">
				<?php echo ' <span' . cryout_schema_microdata( 'author-name', 0) . '>' . esc_attr( get_the_author() ) . '</span>'; ?>
			</<?php echo $theme_heading_tag ?>>
			<div class="author-text"><?php the_author_meta( 'description' ); ?></div>
			<?php if ( is_single() ) { ?>
				<div id="author-link">
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"  <?php cryout_schema_microdata( 'author-url' ); ?>>
						<?php printf( __( 'View all posts by ', 'esotera' ) . ' %s ', get_the_author() ); ?>
					</a>
					<p class="socials my_social_authors">
					<?php if(!empty(get_user_meta(get_the_author_meta('ID'),'facebook'))) { ?>
                       <a href="<?php the_author_meta('facebook'); ?>" title="facebook" target="_blank" id="facebook"></a>
                    <?php } ?>
                    <?php if(!empty(get_user_meta(get_the_author_meta('ID'),'twitter'))) { ?>
                       <a href="https://twitter.com/<?php the_author_meta('twitter'); ?>" title="twitter" target="_blank" id="twitter"></a>
                    <?php } ?>
                    <?php if(!empty(get_user_meta(get_the_author_meta('ID'),'linkedin'))) { ?>
                       <a href="<?php the_author_meta('linkedin'); ?>" title="linkedin" target="_blank" id="linkedin"></a>
                    <?php } ?>
                    <?php if(!empty(get_user_meta(get_the_author_meta('ID'),'instagram'))) { ?>
                       <a href="<?php the_author_meta('instagram'); ?>" title="instagram" target="_blank" id="instagram"></a>
                    <?php } ?>
                    </p>
				</div>
			<?php } ?>
		</div>
</section>
<?php endif; ?>