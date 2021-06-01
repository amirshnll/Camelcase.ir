<?php
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
add_action('woocommerce_before_shop_loop_item_title', 'esotera_woocommerce_before_buttons', 15);
add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 16);
add_action('woocommerce_before_shop_loop_item_title', 'esotera_woocommerce_after_buttons', 17);
function esotera_woocommerce_before_buttons() {
    echo "<div class='woocommerce-buttons-container'>";
}
function esotera_woocommerce_after_buttons() {
    echo "</div><!--.woocommerce-buttons-container-->";
}
add_action('woocommerce_before_shop_loop_item_title', 'esotera_woocommerce_before_thumbnail', 5);
add_action('woocommerce_before_shop_loop_item_title', 'esotera_woocommerce_after_thumbnail', 20);
function esotera_woocommerce_before_thumbnail() {
    echo "<div class='woocommerce-thumbnail-container'>";
}
function esotera_woocommerce_after_thumbnail() {
    echo "</div><!--.woocommerce-thumbnail-container-->";
}
add_filter('loop_shop_columns', 'cryout_woo_loop_columns', 999);
if (!function_exists('cryout_woo_loop_columns')) {
	function cryout_woo_loop_columns() {
		return 3;
	}
}
?>