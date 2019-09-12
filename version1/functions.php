<?php

	function excerpt($length) {
		return 40;
	}

	function more($more) {
		return ' ...';
	}

	add_filter('excerpt_more', 'more');
	add_filter('excerpt_length', 'excerpt');

	if (function_exists('add_theme_support'))
	{
	    add_theme_support('post-thumbnails');
		add_image_size('post-thumb', 255, 177, true);
	}

	if (function_exists('register_sidebar'))
		register_sidebar(
			array(
			'name'          => 'sidebar',
			'description'   => 'ناحيه قرار گيری ابزارک های شما',
			'before_widget' => '<div class="block">',
			'after_widget'  => '</div>',
			'before_title'  => '<span>',
			'after_title'   => '</span>',
			)
		);

	function register_my_menus()
	{
		register_nav_menus(
			array(
				'top-menu' => __( 'منوی بالا' )
			)
		);
	}

	add_filter('widget_categories_args', 'wpb_force_empty_cats');
	function wpb_force_empty_cats($cat_args)
	{
	    $cat_args['hide_empty'] = 0;
	    return $cat_args;
	}

	function getPostViews($postID)
	{
		$count_key = 'post_views_count';
		$count = get_post_meta($postID, $count_key, true);
		if($count=='')
		{
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
			return "0";
		}
		return $count.'';
	}
	
	function setPostViews($postID)
	{
		$count_key = 'post_views_count';
		$count = get_post_meta($postID, $count_key, true);
		if($count=='')
		{
			$count = 0;
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
		}
		else
		{
			$count++;
			update_post_meta($postID, $count_key, $count);
		}
	}
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

	add_filter('login_errors',create_function('$a', "return null;"));

	function fa_number($number)
	{
		if(!is_numeric($number) || empty($number))
			return '۰';
		$en = array("0","1","2","3","4","5","6","7","8","9");
		$fa = array("۰","۱","۲","۳","۴","۵","۶","۷","۸","۹");
		return str_replace($en, $fa, $number);
	}
	
	add_filter('xmlrpc_enabled', '__return_false');

    function showCamelCaseCats($cats) {
        $output = "";
        foreach ($cats as $cat) {
            $name = $cat->name;
            $output .= '<li><a href="' . get_term_link( $cat ) . '" title="' . $name . '"><h2>' . $name . '</h2></a>';

            $output .= "</li>\n";
        }
        return $output;
    }

?>