<?php cryout_absolute_bottom_hook(); ?>
		<aside id="colophon" role="complementary" <?php cryout_schema_microdata( 'sidebar' );?>>
			<div id="colophon-inside" <?php esotera_footer_colophon_class();?>>
				<?php get_sidebar( 'footer' );?>
			</div>
		</aside>
	</div>
	<footer id="footer" class="cryout" role="contentinfo" <?php cryout_schema_microdata( 'footer' );?>>
		<div id="footer-top">
			<div class="footer-inside">
				<?php cryout_master_footer_hook(); ?>
			</div>
		</div>
		<div id="footer-bottom">
			<div class="footer-inside">
				<?php cryout_master_footerbottom_hook(); ?>
				<strong class="copyright"><?php do_action('wordpress_theme_initialize') ?></strong>
			</div>
		</div>
	</footer>
</div>
	<?php wp_footer(); ?>
</body>
</html>