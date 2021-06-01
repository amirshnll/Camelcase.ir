<?php
if ( ! is_active_sidebar( 'footer-widget-area' ) ) {
	return;
}
if ( is_active_sidebar( 'footer-widget-area' ) ) {
	dynamic_sidebar( 'footer-widget-area' );
} ?>