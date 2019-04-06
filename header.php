<!doctype html>
<html dir="rtl" lang="fa">
	<head>
		<meta charset="utf-8">
		<title><?php 
    		if(is_home())
    		    bloginfo('name');
    		elseif(is_category())
    		    single_cat_title();
    		elseif(is_single())
    		    single_post_title();
    		elseif(is_page())
    		    single_post_title();
    		else
    		    wp_title('',true);
		?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="geo.region" content="IR" />
		<meta name="googlebot" content="index,follow" /> 
		<meta name="robots" content="index, follow" />
		<meta name="generator" content="camelcase.ir" />
		<meta name="author" content="http://camelcase.ir/">
        <meta property="og:locale" content="fa-IR" />
        <meta property="og:site_name" content="آموزش برنامه نویسی" />
        <meta property="og:title" content="آموزش برنامه نویسی" />
        <meta property="og:type" content="School Programming" />
        <meta property="og:url" content="http://camelcase.ir" />
        <meta property="dc:creator" content="http://www.camelcase.ir/" />
        <meta property="og:image" content="<?php bloginfo('template_url'); ?>/assets/img/favicon.png" />
        <meta property="og:description" content="انتشار مقالات، آموزش ها و کتابچه های الکترونیکی در حوزه ی برنامه نویسی به زبان شیرین فارسی در خدمت تمام ایرانیان دنیا" />
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />
		<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/assets/img/favicon.png" type="image/png" />
		<script src="<?php bloginfo('template_url'); ?>/assets/js/jquery-2.1.0.min.js"></script>
		<script>jQuery(document).ready(function(a){var b=100,c=250,d=500;a(window).scroll(function(){a(this).scrollTop()<b?a(".topbutton").fadeOut(d):a(".topbutton").fadeIn(d)}),a(".topbutton").on("click",function(){return a("html, body").animate({scrollTop:0},c),!1})});</script>
		<meta name="description" content="انتشار مقالات، آموزش ها و کتابچه های الکترونیکی در حوزه ی برنامه نویسی به زبان شیرین فارسی در خدمت تمام ایرانیان دنیا" />
<meta name="keywords" content="برنامه نویسی,طراحی وب,آموزش برنامه نویسی فارسی,اچ تی ام ال,سی شارپ,جاوا,پی اچ پی,مقالات برنامه نویسی,کتابچه های الکترونیکی,آموزش ویدویی,آموزش فارسی,آموزش برنامه نویسی فارسی,html,css,java,c#,csharp,php,codeigniter,programming,iran,web,web desgin" />		
		<?php wp_head(); ?>
	</head>
	
	<body>
		<div class="header">
			<div class="header_content">
				<div class="header_menu">
					<ul>
						<li><a href="http://camelcase.ir/" title="خانه">خانه</a></li>
						<li><a href="https://telegram.me/camelcase_ir/" title="کانال تلگرام" rel="nofollow" target="_blank">کانال تلگرام</a></li>
						<li><a href="https://instagram.com/camelcase_ir/" title="صفحه اینستاگرام" rel="nofollow" target="_blank">صفحه اینستاگرام</a></li>
						<li><a href="http://camelcase.ir/about/" title="درباره ما">درباره ما</a></li>
						<li><a href="http://camelcase.ir/contact/" title="تماس با ما">تماس با ما</a></li>
					</ul>
				</div>
				<div class="header_search">
					<form method="get" action="http://www.google.com/search" target="_blank">
						<input type="hidden" name="sitesearch" value="camelcase.ir" />
						<input type="text" value="جستجو کنید" onblur="if (this.value == '') this.value = 'جستجو کنید';" onfocus="if (this.value == 'جستجو کنید') this.value = '';" name="q" class="search_input" />
						<input type="image" src="<?php bloginfo('template_url'); ?>/assets/img/search.png" class="search_submit" alt="جستجو کنید" /><span></span>
						<input type="hidden" name="domains" value="camelcase.ir"/>
					</form>
				</div>
				<div class="clear"></div>
			</div>
		</div>

		<div class="intero">
			<div class="intero_icons"></div>
			<div class="intero_logo"><img src="<?php bloginfo('template_url'); ?>/assets/img/logo.png" title="آموزش برنامه نویسی" alt="آموزش برنامه نویسی" /></div>
		</div>

		<div class="category">
			<ul>
				<?php #wp_list_categories('title_li=&orderby=id&hide_empty=0&parent=0'); 
				$cats = get_categories( array('parent' => 0, 'orderby' => 'id', 'hide_empty' => 0) ); echo showCamelCaseCats($cats); ?>
			</ul>
		</div>