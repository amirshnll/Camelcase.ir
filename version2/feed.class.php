<?php
if ( !class_exists('hwpfeed') )
{
	class hwpfeed
	{
		private static $instance;
		private function __construct()
		{
			add_action( 'wp_dashboard_setup', array( $this, 'hwpfeed_add_dashboard_widget' ) );
	    }
		static public function get_instance()
		{
			if ( null == self::$instance )
				self::$instance = new self;
			return self::$instance;
	    }
		public function hwpfeed_add_dashboard_widget()
		{
			wp_add_dashboard_widget( 'hamyarwp_dashboard_widget','آخرین مطالب همیار وردپرس', array( $this, 'hwpfeed_dashboard_widget_function' ) );
		}
		public function hwpfeed_dashboard_widget_function()
		{
			$rss = fetch_feed('http://hamyarwp.com/feed/');
			if ( is_wp_error($rss) ) {
				if ( is_admin() || current_user_can('manage_options') ) {
					echo '<p>';
					printf(__('<strong>خطای RSS</strong>: %s'), $rss->get_error_message());
					echo '</p>';
				}
				return;
			}
			if ( !$rss->get_item_quantity() )
			{
				echo '<p>مطلبی برای نمایش وجود ندارد.</p>';
				$rss->__destruct();
				unset($rss);
				return;
			}
			echo '<ul>' . PHP_EOL;
			if ( !isset($items) )
				$items =5;
				foreach ( $rss->get_items(0, $items) as $item )
				{
					$publisher = $site_link = $link = $content = $date = '';
					$link = esc_url( strip_tags( $item->get_link() ) );
					$title = esc_html( $item->get_title() );
					$content = $item->get_content();
					$content = wp_html_excerpt($content, 250) . ' ...';
					echo "<li><a class=\"rsswidget\" target=\"_blank\" href=\"$link\">$title</a>".PHP_EOL."<div class=\"rssSummary\">$content</div></li>".PHP_EOL;
				}
			echo '</ul>' . PHP_EOL;
			$rss->__destruct();
			unset($rss);
		}
	}
	hwpfeed::get_instance();
} ?>