<?php
function esotera_add_meta_boxes( $post ) {
    global $wp_meta_boxes;
	$layout_context = apply_filters( 'esotera_layout_meta_box_context', 'side' ); // 'normal', 'side', 'advanced'
	$layout_priority = apply_filters( 'esotera_layout_meta_box_priority', 'default' ); // 'high', 'core', 'low', 'default'
    add_meta_box(
		'esotera_layout',
		__( 'Static Page Layout', 'esotera' ),
		'esotera_layout_meta_box',
		'page',
		$layout_context,
		$layout_priority
	);
}
add_action( 'add_meta_boxes', 'esotera_add_meta_boxes' );
function esotera_layout_meta_box() {
	global $post;
    	global $esotera_big;
	$options = $esotera_big['options'][0];
	$custom = ( get_post_custom( $post->ID ) ? get_post_custom( $post->ID ) : false );
	$layout = ( isset( $custom['_cryout_layout'][0] ) ? $custom['_cryout_layout'][0] : '0' );
    ?>
	<p>
    	<?php foreach ($options['choices'] as $value => $data ) {
            $data['url'] = esc_url( sprintf( $data['url'], get_template_directory_uri() ) ); ?>
    		<label>
                <input type="radio" name="_cryout_layout" <?php checked( $value == $layout ); ?> value="<?php echo esc_attr( $value ); ?>" />
                <span><img src="<?php echo $data['url'] ?>" alt="<?php echo esc_html(  $data['label'] ) ?>" title="<?php echo esc_html(  $data['label'] ) ?>"/></span>
            </label>

    	<?php } ?>
    	<label id="cryout_layout_default">
            <input type="radio" name="_cryout_layout" <?php checked( '0' == $layout ); ?> value="0" />
            <span><img src="<?php echo get_template_directory_uri() ?>/admin/images/0def.png" alt="<?php _e( 'Default Theme Layout', 'esotera' ); ?>" title="<?php _e( 'Default Theme Layout', 'esotera' ); ?>" /></span>
        </label>
	</p>
	<?php
}
function esotera_meta_style( $hook ) {
    if ( 'post.php' != $hook && 'post-new.php' != $hook && 'page.php' != $hook ) {
        return;
    }
    wp_enqueue_style( 'esotera_meta_style', get_template_directory_uri() . '/admin/css/meta.css', NULL, _CRYOUT_THEME_VERSION );
}
add_action( 'admin_enqueue_scripts', 'esotera_meta_style' );
function esotera_save_custom_post_metadata() {
	global $post;
	if ( ! isset( $post ) || ! is_object( $post ) ) {
		return;
	}
    	global $esotera_big;
    	$valid_layouts = $esotera_big['options'][0]['choices'];
	$layout = ( isset( $_POST['_cryout_layout'] ) && array_key_exists( $_POST['_cryout_layout'], $valid_layouts ) ? $_POST['_cryout_layout'] : '0' );
	update_post_meta( $post->ID, '_cryout_layout', $layout );
}
add_action( 'publish_page', 'esotera_save_custom_post_metadata' );
add_action( 'draft_page',   'esotera_save_custom_post_metadata' );
add_action( 'future_page',  'esotera_save_custom_post_metadata' );
?>