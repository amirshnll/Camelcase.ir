<?php
function cryout_truncate_words($string,$words=20, $ellipsis=' ...') {
	 $new = preg_replace('/((\w+\W+\'*){'.($words-1).'}(\w+))(.*)/', '${1}', $string);
	 return $new.$ellipsis;
}
function cryout_fetch_feed() {
	$theme_news = fetch_feed( array( 'http://www.cryoutcreations.eu/cat/wordpress-themes/' . _CRYOUT_THEME_SLUG . '/feed/') );
	$maxitems = 0;
	if ( ! is_wp_error( $theme_news ) ) {
			$maxitems = $theme_news->get_item_quantity( 10 );
			$news_items = $theme_news->get_items( 0, $maxitems );
	}
	?>
         <ul class="news-list">
            <?php if ( $maxitems == 0 ) : echo '<li>' . __( 'No update news.', 'cryout' ) . '</li>'; else :
						foreach( $news_items as $news_item ) : ?>
                    	<li>
                        	<a class="news-header" target="_blank" href='<?php echo esc_url( $news_item->get_permalink() ); ?>'><?php echo esc_html( $news_item->get_title() ); ?></a>
							<span class="news-item-date"><?php _e('Posted on','cryout'); echo $news_item->get_date(' j F Y'); ?></span>
							<a class="news-more" target="_blank" href='<?php echo esc_url( $news_item->get_permalink() ); ?>'><?php _e('Read the full post','cryout');?> &#8594;</a>
                        </li>
						<?php endforeach;
				endif; ?>
          </ul>
<?php die();
}
add_action('wp_ajax_cryout_feed_action', 'cryout_fetch_feed');
?>