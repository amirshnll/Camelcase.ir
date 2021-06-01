<?php
if ( post_password_required() ) {
	return;
}
?>
<section id="comments">
	<?php if ( have_comments() ) : ?>
		<h3 id="comments-title">
			<span><?php  printf( _n( 'یک دیدگاه', '%1$s دیدگاه', get_comments_number(), 'esotera' ),
					number_format_i18n( get_comments_number() )); ?>
			</span>
		</h3>
		<ol class="commentlist">
			<?php
			wp_list_comments( array(
				'style'       => 'ol',
				'short_ping'  => true,
				'avatar_size' => 50,
				'callback' => 'esotera_comment',
			) );
			?>
		</ol>
		<?php if ( function_exists( 'the_comments_navigation' ) ) the_comments_navigation();
	endif;
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="nocomments"><?php _e( 'Comments are closed.', 'esotera' ); ?></p>
	<?php endif; ?>
	<?php if ( comments_open() ) comment_form();  ?>
</section>