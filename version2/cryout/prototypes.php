<?php
function cryout_sanitize_tn($input){
	return preg_replace( '/[^a-z0-9-]/i', '-', $input );
}
function cryout_sanitize_tnl($input){
	return ucwords(preg_replace( '/[^a-z0-9]/i', ' ', $input ));
}
function cryout_sanitize_tn_fn($input){
	return preg_replace( '/[^a-z0-9]/i', '_', $input );
}
function cryout_sanitize_tnp($input){
	return preg_replace( '/-[^-]*$/i', '', $input );
}
function cryout_gen_values( $from, $to, $step = 1, $attr = array() ){
	if ( !empty($attr['pre']) && is_array($attr['pre']) )  $data = $attr['pre'];
													  else $data = array();
	if ( !empty($attr['precision']) && is_numeric($attr['precision'] ) )  $precision = $attr['precision'];
								                                     else $precision = 1;
    if ( !empty($attr['um']) ) $um = $attr['um'];
						  else $um = '';
	if ($step < 1):
		for ($i=$from;$i<=$to;$i+=$step) {
			$data[] = number_format($i,$precision).$um;
		}
	else:
		for ($i=$from;$i<=$to;$i+=$step) {
			$data[] = $i.$um;
		}
	endif;
	if ( !empty($attr['post']) && is_array($attr['post']) )  $data = array_merge($data,$attr['post']);
	return $data;
}
function cryout_get_theme_options($sub=''){
	$opts = array();
	if ( function_exists( preg_replace( '/[^a-z0-9]/i', '_', _CRYOUT_THEME_NAME ) . '_get_theme_options') ) $opts = call_user_func( preg_replace( '/[^a-z0-9]/i', '_', _CRYOUT_THEME_NAME) . '_get_theme_options' );
	if ( !empty($sub) && !empty($opts[$sub]) ) return $opts[$sub];
	                                      else return $opts;
}
function cryout_get_theme_structure($sub=''){
	$opts = array();
	if ( function_exists( preg_replace( '/[^a-z0-9]/i', '_', _CRYOUT_THEME_NAME ) . '_get_theme_structure' ) ) $opts = call_user_func( preg_replace( '/[^a-z0-9]/i', '_', _CRYOUT_THEME_NAME ) . '_get_theme_structure' );
	if ( !empty($sub) && !empty($opts[$sub]) ) return $opts[$sub];
	                                      else return $opts;
}
function cryout_get_option($subs = array()) {
	global $cryout_theme_options;
		$opts = cryout_get_theme_options();
	$returns = array();
	if ( is_array($subs)&&!empty($subs) ) {
		foreach ($subs as $sub) {
			if ( isset($opts[$sub]) ) $returns[$sub] = $opts[$sub]; else $returns[$sub] = '';
		}
		return $returns;
	} elseif (!empty($subs)) {
		if ( isset($opts[$subs]) ) return $opts[$subs]; else return '';
	} else {
		return $opts;
	}
	return '';
}
function cryout_maybe_migrate_options( $options ) {
	if (empty($options)) return false;
	global ${_CRYOUT_THEME_NAME . '_big'};
	$theme_structure = ${_CRYOUT_THEME_NAME . '_big'};
	if (empty($theme_structure['migration'])) return $options;
	$migrated = false;
	if ( !empty( $options[_CRYOUT_THEME_NAME . '_db'] ) && !empty( $theme_structure['migration'] ) ) {
		foreach ($theme_structure['migration'] as $version => $pairs) {
			if ( (float)$version > (float)$options[_CRYOUT_THEME_NAME . '_db'] ) {
			foreach ($pairs as $old_key => $new_key) {
				if (isset($options[$old_key])) {
					$options[$new_key] = $options[$old_key];
					unset($options[$old_key]);
				}
			}
			$options[_CRYOUT_THEME_NAME . '_db'] = $version;
			$migrated = true;
			}
		}
	}
	if ($migrated) {
		delete_option( _CRYOUT_THEME_NAME . '_settings');
		update_option( _CRYOUT_THEME_NAME . '_settings', $options );
	}
	return $options;
}
function cryout_is_true( $key ){
	if ( in_array( strtolower($key), array( true, 1, "1" , 'enabled', 'enable', 'show' ) ) ) return true;
	return false;
}
function cryout_color_clean($color){
	if (strlen($color)>1): return "#".str_replace("#","",$color);
	else: return $color;
	endif;
}
function cryout_optset($var,$val1,$val2='',$val3='',$val4=''){
	$vals = array($val1,$val2,$val3,$val4);
	if (in_array($var,$vals)): return false; else: return true; endif;
}
function cryout_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);
   if (preg_match("/^([a-f0-9]{3}|[a-f0-9]{6})$/i",$hex)):
        if(strlen($hex) == 3) {
           $r = hexdec(substr($hex,0,1).substr($hex,0,1));
           $g = hexdec(substr($hex,1,1).substr($hex,1,1));
           $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else {
           $r = hexdec(substr($hex,0,2));
           $g = hexdec(substr($hex,2,2));
           $b = hexdec(substr($hex,4,2));
        }
        $rgb = array($r, $g, $b);
        return implode(",", $rgb);
   else: return "";
   endif;
}
function cryout_hexadder($hex,$inc) {
   $hex = str_replace("#", "", $hex);
   if (preg_match("/^([a-f0-9]{3}|[a-f0-9]{6})$/i",$hex)):
        if(strlen($hex) == 3) {
           $r = hexdec(substr($hex,0,1).substr($hex,0,1));
           $g = hexdec(substr($hex,1,1).substr($hex,1,1));
           $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else {
           $r = hexdec(substr($hex,0,2));
           $g = hexdec(substr($hex,2,2));
           $b = hexdec(substr($hex,4,2));
        }
		$rgb_array = array($r,$g,$b);
		$newhex="#";
		foreach ($rgb_array as $el) {
			$el+=$inc;
			if ($el<=0) { $el='00'; }
			elseif ($el>=255) {$el='ff';}
			else {$el=dechex($el);}
			if(strlen($el)==1)  {$el='0'.$el;}
			$newhex.=$el;
		}
		return $newhex;
   else: return "";
   endif;
}
function cryout_hexdiff($hex,$inc,$f='') {
   $hex = str_replace("#", "", $hex);
   if (preg_match("/^([a-f0-9]{3}|[a-f0-9]{6})$/i",$hex)):
        if(strlen($hex) == 3) {
           $r = hexdec(substr($hex,0,1).substr($hex,0,1));
           $g = hexdec(substr($hex,1,1).substr($hex,1,1));
           $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else {
           $r = hexdec(substr($hex,0,2));
           $g = hexdec(substr($hex,2,2));
           $b = hexdec(substr($hex,4,2));
        }
		$rgb_array = array($r,$g,$b);
		$newhex="#";
		if ( ((int)$r < 102) && ((int)$g < 102) && ((int)$b < 102) ) $sign = +1; else $sign = -1;
		if (!empty($f)) $sign = ($f == '-'? -1 : +1);
		foreach ($rgb_array as $el) {
			$el += $sign * (int)$inc;
			if ( $el<0 ) { $el='00'; }
			elseif ( $el>255 ) { $el='ff'; }
			else { $el = dechex($el); }
			if ( strlen($el)==1 ) { $el='0'.$el; }
			$newhex .= $el;
		}
		return $newhex;
   else: return "";
   endif;
}
function cryout_mobile_body_class( $classes ){
	$browser = ( ! empty( $_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '');
	$keys = 'mobile|android|mobi|tablet|ipad|opera mini|series 60|s60|blackberry';
	if ( preg_match( "/($keys)/i", $browser ) ) : $classes[] = 'mobile'; endif;
	return $classes;
}
function cryout_normalizetags( $tags_html ) {
	return preg_replace( '/font-size:.*?;/i', '', $tags_html );
};
function cryout_clean_gfont( $font, $identifier = '(:\d+)?\/gfont$' ){
	return preg_replace( "/$identifier/i", '', $font );
}
function cryout_font_select( $font, $gfont ) {
	$font = cryout_clean_gfont( $font );
	if ( !empty($gfont) ):
		$fontname = esc_attr( preg_replace( '/[:&].*/', '', preg_replace( '/\+/', ' ', $gfont ) ) );
		if (preg_match('/:(\d{1,4})/',$gfont,$ms)) $weight = $ms[1];
		return "'$fontname'" . ( !empty($weight) ? ";font-weight:$weight" : "");
	else:
		return "$font";
	endif;
}
function cryout_gfontclean( $gfont, $weight = '' ) {
	if (preg_match('/^([\w\s]+):?([\d,]+)?(&a?m?p?;?subset=.*)?$/i', $gfont, $bits)) {
		if (empty($bits[1])) $bits[1] = '';
		if (empty($bits[2])) $bits[2] = $weight; elseif (!empty($weight)) $bits[2] = $weight . ',' . $bits[2];
		if (empty($bits[3])) $bits[3] = '';
		return esc_attr( preg_replace( '/\s+/', '+', $bits[1] . $bits[2] . $bits[3]) );
	} else {
		return esc_attr($gfont);
	}
	return esc_attr( $gfont );
}
function cryout_filter_wp_logo_img( $input ) {
	return preg_replace( '/(height=".*?"|width=".*?")/i', '', $input );
}
function cryout_post_first_image( $postID, $size = 'cryout-featured' ) {
	$args = array(
		'numberposts' 	=> 1,
		'orderby'		=> 'ID',
		'order'			=> 'ASC',
		'post_mime_type'=> 'image',
		'post_parent' 	=> $postID,
		'post_status'	=> 'any',
		'post_type'		=> 'any'
	);
	$attachments = get_children( $args );
	if ($attachments) {
		foreach($attachments as $attachment) {
			$image_attributes = wp_get_attachment_image_src( $attachment->ID, $size ) ?
								wp_get_attachment_image_src( $attachment->ID, $size ) :
								wp_get_attachment_image_src( $attachment->ID );
			$image_attributes['id'] = $attachment->ID;
			return $image_attributes;	}
	}
};
function cryout_get_picture( $attachment_id, $size = '' ){
	$image = wp_get_attachment_image_src( $attachment_id, $size );
	if (!empty($image[0])) return $image;
						  else return array(
							0 => apply_filters( _CRYOUT_THEME_SLUG . '_preview_img_src', ''),
							1 => apply_filters( _CRYOUT_THEME_SLUG . '_preview_img_w', ''),
							2 => apply_filters( _CRYOUT_THEME_SLUG . '_preview_img_h', ''),
						  );
}
function cryout_get_picture_src( $attachment_id, $size ='' ){
	$image = cryout_get_picture( $attachment_id, $size );
	if (!empty($image[0])) return $image[0];
						  else return '';
}
function cryout_get_featured_srcset( $attachment_id, $sizes = array() ) {
	$datas = array();
	foreach ($sizes as $size) {
		if ( $image = wp_get_attachment_image_src( $attachment_id, $size ) ) {
			$datas[$size] = $image;
		}
	}
	$srcset = array();
	foreach ($datas as $data) {
		$src = $data[0];
		$width = $data[1];
		$height = $data[2];
		$srcset[] = "$src ${width}w";
	}
	$srcset = implode(', ', $srcset);
	return $srcset;

}
function cryout_gen_featured_sizes( $default = 1440, $magazinelayout = false, $landingpage = false ) {
	if ( $landingpage ) {
		$magazinelayout = apply_filters( _CRYOUT_THEME_SLUG . '_lppostslayout_filter', $magazinelayout );
	};
	if ( $magazinelayout > 1 ) {
		$column =  50;
	} else {
		$column = 100;
	};
	return "(max-width: 800px) 100vw,(max-width: 1152px) ${column}vw, ${default}px";
}
function cryout_is_landingpage() {
	$landingpage = cryout_get_option( _CRYOUT_THEME_PREFIX . '_landingpage');
	return apply_filters( _CRYOUT_THEME_SLUG . '_is_landingpage', ($landingpage && ('page' == get_option( 'show_on_front' )) ) );
}
function cryout_on_landingpage() {
	$landingpage = cryout_get_option( _CRYOUT_THEME_PREFIX . '_landingpage');
	return apply_filters( _CRYOUT_THEME_SLUG . '_on_landingpage', ( $landingpage && ('page' == get_option( 'show_on_front' )) && is_front_page() ) );
}
if ( ! function_exists( 'cryout_get_layout' ) ) :
function cryout_get_layout( $option_name = '' ) {
	global $post;
	if (empty($option_name)) $option_name = _CRYOUT_THEME_PREFIX . '_sitelayout';
	if ( get_post() && is_singular() ) {
		$meta_layout = get_post_meta( $post->ID, '_cryout_layout', true );
		if (empty($meta_layout)) $meta_layout = get_post_meta( $post->ID, '_' . _CRYOUT_THEME_PREFIX . '_layout', true ); // backwards compatibility
	}
	if ( !empty( $meta_layout ) ) {
		$theme_layout =  $meta_layout;
	}
	else $theme_layout = cryout_get_option( $option_name );
	$theme_layout = apply_filters( _CRYOUT_THEME_SLUG . '_general_layout', $theme_layout );
	return $theme_layout;
}
endif;
function cryout_echo_bgimage( $image_url, $classes = NULL ) {
	echo ' style="background-image: url(' . esc_url( $image_url ) . ')" ';
	if (!empty($classes)):
		if (is_array($classes)) $classes = implode( ' ', $classes );
		echo ' class="' . $classes . '" ';
	endif;
};
function cryout_get_gallery_images() {
       $images = array();
       if ( function_exists( 'get_post_galleries' ) ) {
               $galleries = get_post_galleries( get_the_ID(), false );
               if ( isset( $galleries[0]['ids'] ) )
                       $images = explode( ',', $galleries[0]['ids'] );
       } else {
               $pattern = get_shortcode_regex();
               preg_match( "/$pattern/s", get_the_content(), $match );
               $atts = shortcode_parse_atts( $match[3] );
               if ( isset( $atts['ids'] ) )
                       $images = explode( ',', $atts['ids'] );
       }
       if ( ! $images ) {
               $images = get_posts( array(
                       'fields'         => 'ids',
                       'numberposts'    => 999,
                       'order'          => 'ASC',
                       'orderby'        => 'none',
                       'post_mime_type' => 'image',
                       'post_parent'    => get_the_ID(),
                       'post_type'      => 'attachment',
               ) );
       }
       return $images;
}
function cryout_has_manual_excerpt( $post = null ){
	if ( empty($post) ) global $post;
	if ( !empty( $post->post_excerpt ) ) return apply_filters( 'cryout_has_manual_excerpt', true, $post );
	if ( strpos( $post->post_content, '<!--more-->' ) || strpos( $post->post_content, '<!--nextpage-->' ) ) return apply_filters( 'cryout_has_manual_excerpt', true, $post );
	return apply_filters( 'cryout_has_manual_excerpt', false, $post );
}
function cryout_categories_for_customizer( $what = 0, $label_all = '', $label_off = '', $all = TRUE, $off = TRUE ) {
	$categories = array(); $labels = array();
	$cats = get_categories();
	$categories = array();
	$labels = array();
	if ( count( $cats ) > 0 ):
		if ($off) {
			$categories[] = '-1';
			$labels[] = $label_off;
		};
		if ($all) {
			$categories[] = '';
			$labels[] = $label_all;
		};
		foreach ($cats as $category) {
			$categories[] = $category->category_nicename;
			$labels[] = $category->name . ' (' . $category->category_count . ')';
		}
	endif;
	switch ($what) {
		case 2:
			return $labels;
		break;
		case 1:
			return $categories;
		break;
		case 0:
		default:
			return array_combine($categories,$labels);
		break;
	}
}
function cryout_pages_for_customizer( $what = 0, $label_off = '', $off = TRUE ) {
	$pages = array(); $labels = array();
	$pags = get_pages( );
	if ( count( $pags ) > 0 ):
		if ($off) {
			$pages = array( 0 );
			$labels = array( $label_off );
		};
		foreach ($pags as $page) {
			$pages[] = $page->ID;
			if (!empty($page->post_parent))  $labels[] = "&nbsp;&ndash;&nbsp;".$page->post_title;
										else $labels[] = $page->post_title;
		}
	endif;
	switch ($what) {
		case 2:
			return $labels;
		break;
		case 1:
			return $pages;
		break;
		case 0:
		default:
			return array_combine($pages,$labels);
		break;
	}
}
function cryout_serious_slides_for_customizer( $what = 0, $label_unavailable = '', $label_off = '' ) {
	global $cryout_serious_slider;
	$slides = array(); $labels = array();
	if (!empty($cryout_serious_slider)):
		$sliders = $cryout_serious_slider->get_sliders_list();
		if (count($sliders)>0) {
			foreach ($sliders as $id=>$name) {
				$slides[] = $id;
				$labels[] = $name;
			};
		} else {
			$slides = array( 0 );
			$labels = array( $label_off );
		}
	else:
		$slides = array( 0 );
		$labels = array( $label_unavailable );
	endif;
	switch ($what) {
		case 2:
			return $labels;
		break;
		case 1:
			return $slides;
		break;
		case 0:
		default:
			return array_combine($slides,$labels);
		break;
	}
}
if ( ! function_exists( 'cryout_schema_microdata' ) ) :
function cryout_schema_microdata($location = '', $echo = 1) {
	$output = '';
	switch ($location) {
		case 'body':
			$output = 'itemscope itemtype="http://schema.org/WebPage"';
		break;
		case 'header':
			$output = 'itemscope itemtype="http://schema.org/WPHeader"';
		break;
		case 'blog':
			$output = 'itemscope itemtype="http://schema.org/Blog"';
		break;
		case 'element':
			$output = 'itemscope itemtype="http://schema.org/WebPageElement"';
		break;
		case 'sidebar':
			$output = 'itemscope itemtype="http://schema.org/WPSideBar"';
		break;
		case 'footer':
			$output = 'itemscope itemtype="http://schema.org/WPFooter"';
		break;
		case 'mainEntityOfPage':
			$output = 'itemprop="mainEntityOfPage"';
		break;
		case 'breadcrumbs':
			$output = 'itemprop="breadcrumb"';
		break;
		case 'menu':
			$output = 'itemscope itemtype="http://schema.org/SiteNavigationElement"';
		break;
		case 'site-title':
			$output = 'itemprop="headline"';
		break;

		case 'site-description':
			$output = 'itemprop="description"';
		break;
		case 'blogpost':
			$output = 'itemscope itemtype="http://schema.org/BlogPosting" itemprop="blogPost"';
		break;

		case 'article':
			$output = 'itemscope itemtype="http://schema.org/Article" itemprop="mainEntity"';
		break;
		case 'entry-title':
			$output = 'itemprop="headline"';
		break;
		case 'url':
			$output = 'itemprop="url"';
		break;
		case 'entry-summary':
			$output = 'itemprop="description"';
		break;
		case 'entry-content':
			$output = 'itemprop="articleBody"';
		break;
		case 'text':
			$output = 'itemprop="text"';
		break;
		case 'comment':
			$output = 'itemscope itemtype="http://schema.org/Comment"';
		break;
		case 'comment-author':
			$output = 'itemscope itemtype="http://schema.org/Person" itemprop="creator"';
		break;
		case 'author':
			$output = 'itemscope itemtype="http://schema.org/Person" itemprop="author"';
		break;
		case 'author-url':
			$output = 'itemprop="url"';
		break;
		case 'author-name':
			$output = 'itemprop="name"';
		break;
		case 'author-description':
			$output = 'itemprop="description"';
		break;
		case 'time':
			$output = 'itemprop="datePublished"';
		break;
		case 'time-modified':
			$output = 'itemprop="dateModified"';
		break;
		case 'category':
			$output = '';
		break;
		case 'tags':
			$output = 'itemprop="keywords"';
		break;
		case 'comment-meta':
			$output = 'itemprop="discussionURL"';
		break;
		case 'image':
			$output = 'itemprop="image" itemscope itemtype="http://schema.org/ImageObject"';
		break;
	}
	$output = ' ' . $output;
	if ($echo) echo $output;
		else return $output;
}
endif;
if ( ! function_exists( 'cryout_schema_publisher' ) ):
function cryout_schema_publisher() {
	if ( ! function_exists('get_custom_logo') ) return;
	$html = get_custom_logo();
	preg_match( '@src="([^"]+)"@', $html, $match );
	$src = array_pop( $match );
	if ( empty( $src ) ) $src = get_home_url(); ?>
	<span class="schema-publisher" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
         <span itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
           <meta itemprop="url" content="<?php echo esc_url( $src ) ?>">
         </span>
         <meta itemprop="name" content="<?php esc_attr( bloginfo( 'name' ) ); ?>">
    </span>
<?php
}
endif;
if ( ! function_exists( 'cryout_schema_main' ) ):
function cryout_schema_main() {
	echo '<link itemprop="mainEntityOfPage" href="' . get_page_link() . '" />';
}
endif;
if ( ! function_exists( 'cryout_breadcrumbs' ) ) :
function cryout_breadcrumbs(
			$separator = '<i class="icon-angle-right"></i>',
			$home = '<i class="icon-homebread"></i>',
			$showCurrent = 1,
			$before = '<span class="current">',
			$after = '</span>',
			$wrapper_pre = '<div id="breadcrumbs"> <nav id="breadcrumbs-nav" %2$s>',
			$wrapper_post = '</nav></div><!-- breadcrumbs -->',
			$layout_class = '',
			$text_home,
			$text_archive,
			$text_search,
			$text_tag,
			$text_author,
			$text_404,
			$text_format,
			$text_page
) {
	global $post;
	$homeUrl = home_url();
	$homeLink = sprintf( '<a href="' . esc_url( home_url() ) . '" title="' . $text_home . '">%s<span class="screen-reader-text">' . $text_home . '</span></a>', $home);
	if ( is_front_page() || is_home() ) { return; }
	$exclude_templates = apply_filters( 'cryout_breadcrumbs_excluded_templates', array() );
	if (!empty($exclude_templates)) foreach ($exclude_templates as $exclude_template) {
		if (is_page_template( $exclude_template ) ) return;
	}
	$wrapper_pre = sprintf( $wrapper_pre, $layout_class, cryout_schema_microdata( 'breadcrumbs', 0 ) );
	if ( function_exists('woocommerce_breadcrumb') && is_woocommerce() ){
		$args = array(
			'delimiter' => $separator,
			'wrap_before' => $wrapper_pre . $homeLink . $separator . ' ',
			'wrap_after' => $wrapper_post,
			'before' => '',
			'after' => '',
			'home' => false,
		);
		woocommerce_breadcrumb( $args );
		return;
	};
	echo $wrapper_pre;
	echo $homeLink;
	echo $separator . ' ';
    if ( is_category() ) {
		$queried_object = get_queried_object();
	 	$cat_parents = $queried_object->category_parent;
		if ( !empty( $cat_parents ) ) echo get_category_parents( $cat_parents, TRUE, ' ' . $separator . ' ');
		echo $before . $text_archive .' "' . single_cat_title('', false) . '"' . $after;
    } elseif ( is_search() ) {
		echo $before . $text_search .' "' . get_search_query() . '"' . $after;
    } elseif ( is_day() ) {
		echo '<a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . $separator . ' ';
		echo '<a href="' . esc_url( get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) ) . '">' . get_the_time( 'F' ) . '</a> ' . $separator . ' ';
		echo $before . get_the_time( 'd' ) . $after;
    } elseif ( is_month() ) {
		echo '<a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . $separator . ' ';
		echo $before . get_the_time( 'F' ) . $after;
    } elseif ( is_year() ) {
		echo $before . get_the_time( 'Y' ) . $after;
    } elseif ( is_single() && ! is_attachment() ) {
		if ( get_post_type() != 'post' ) {
			$post_type = get_post_type_object( get_post_type() );
			$slug = $post_type->rewrite;
			echo '<a href="' . $homeUrl . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
			if ( $showCurrent ) echo ' ' . $separator . ' ' . $before . get_the_title() . $after;
		} else {
			$cat = get_the_category(); if ( isset( $cat[0] ) ) { $cat = $cat[0]; } else { $cat = false; }
			if ( $cat ) { $cats = get_category_parents( $cat, TRUE, ' ' . $separator . ' '); } else { $cats = false; }
			if ( ! $showCurrent && $cats ) $cats = preg_replace( "#^(.+)\s$separator\s$#", "$1", $cats );
			echo $cats;
			if ( $showCurrent ) echo $before . get_the_title() . $after;
		}
    } elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' && ! is_404() ) {
		$post_type = get_post_type_object( get_post_type() );
		if (!empty($post_type->labels->singular_name)) echo $before . $post_type->labels->singular_name . $after;
	} elseif ( is_attachment() ) {
		$parent = get_post( $post->post_parent );
		$cat = get_the_category( $parent->ID ); if ( isset( $cat[0] ) ) { $cat = $cat[0]; } else { $cat = false; }
		if ( $cat ) echo get_category_parents( $cat, TRUE, ' ' . $separator . ' ');
		echo '<a href="' . esc_url( get_permalink( $parent ) ). '">' . $parent->post_title . '</a>';
		if ( $showCurrent ) echo ' ' . $separator . ' ' . $before . get_the_title() . $after;
    } elseif ( is_page() && ! $post->post_parent ) {
		if ( $showCurrent ) echo $before . get_the_title() . $after;
    } elseif ( is_page() && $post->post_parent ) {
		$parent_id  = $post->post_parent;
		$breadcrumbs = array();
		while ( $parent_id ) {
			$page = get_page( $parent_id );
			$breadcrumbs[] = '<a href="' . esc_url( get_permalink( $page->ID ) ) . '">' . get_the_title( $page->ID ) . '</a>';
			$parent_id  = $page->post_parent;
		}
		$breadcrumbs = array_reverse( $breadcrumbs );
		for ( $i = 0; $i < count( $breadcrumbs ); $i++ ) {
			echo $breadcrumbs[$i];
			if ( $i != count( $breadcrumbs ) - 1 ) echo ' ' . $separator . ' ';
		}
		if ( $showCurrent ) echo ' ' . $separator . ' ' . $before . get_the_title() . $after;
    } elseif ( is_tag() ) {
		echo $before . $text_tag .' "' . single_tag_title( '', false ) . '"' . $after;
    } elseif ( is_author() ) {
		global $author;
		$userdata = get_userdata( $author );
		echo $before . $text_author . ' ' . $userdata->display_name . $after;
    } elseif ( is_404() ) {
		echo $before . $text_404 . $after;
    } elseif ( get_post_format() ) {
		echo $before . '"' . ucwords( get_post_format() ) . '" ' . $text_format . $after;
    }
    if ( get_query_var( 'paged' ) ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo $text_page . ' ' . get_query_var( 'paged' );
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
    echo $wrapper_post;
}
endif;
class Cryout_Social_Menu_Walker extends Walker_Nav_Menu {
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
		$args = apply_filters( 'cryout_social_menu_item_args', $args, $item, $depth );
		$class_names = join( ' ', apply_filters( 'cryout_social_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
		$id = apply_filters( 'cryout_social_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? esc_attr( $item->attr_title )	: '';
		$atts['target'] = ! empty( $item->target )     ? esc_attr( $item->target )		: '';
		$atts['rel']    = ! empty( $item->xfn )        ? esc_attr( $item->xfn ) 		: '';
		$atts['href']   = ! empty( $item->url )        ? esc_url( $item->url )			: '';
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}
		$title = apply_filters( 'the_title', $item->title, $item->ID );
		$title = apply_filters( 'cryout_social_menu_item_title', $title, $item, $args, $depth );
		$item_output = $args->before;
		$item_output .= '<a'. $attributes .' '. $class_names .'>';
		$item_output .= $args->link_before . $title . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;
		$output .= apply_filters( 'cryout_social_menu_start_el', $item_output, $item, $depth, $args );
	}
	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
	}
}
function cryout_localize_id( $id, $type = 'post' ) {
	if ( empty($id) ) return;
	if ( function_exists('pll_get_post') )
		return pll_get_post( $id );
	if ( function_exists('wpml_object_id_filter') )
		return wpml_object_id_filter( $id, $type );
	elseif ( function_exists('icl_object_id') )
		return icl_object_id( $id );
	return $id;
}
function cryout_localize_cat( $slug, $tax = 'category' ) {
	if (empty($slug)) return $slug;
	$cat = get_term_by( 'slug', esc_attr($slug), $tax );
	if (empty($cat)) return false;
	$id = $cat->term_id;
	if ( function_exists('pll_get_term') )
		return pll_get_term( $id );
	if ( function_exists('wpml_object_id_filter') )
		return wpml_object_id_filter( $id, $tax );
	elseif ( function_exists('icl_object_id') )
		return icl_object_id( $id, $tax );
	return $id;
}
function cryout_localize_code() {
	if ( function_exists('pll_current_language') )
		return pll_current_language();
	if ( defined('ICL_LANGUAGE_CODE') )
		return ICL_LANGUAGE_CODE;
	return '';
} ?>