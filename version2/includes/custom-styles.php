<?php
function esotera_body_classes( $classes ) {
	$options = cryout_get_option( array(
		'theme_landingpage', 'theme_layoutalign',  'theme_image_style', 'theme_magazinelayout', 'theme_comclosed', 'theme_contenttitles', 'theme_caption_style',
		'theme_elementborder', 'theme_elementshadow', 'theme_elementborderradius', 'theme_totop', 'theme_menustyle', 'theme_menuposition', 'theme_menulayout', 'theme_topsection',
		'theme_headerresponsive', 'theme_fresponsive', 'theme_comlabels', 'theme_comicons', 'theme_comdate', 'theme_tables', 'theme_normalizetags', 'theme_articleanimation',
	) );
	if ( is_front_page() && $options['theme_landingpage'] && ('page' == get_option('show_on_front')) ) {
		$classes[] = 'esotera-landing-page';
	}
	if ( $options['theme_layoutalign'] ) $classes[] = 'esotera-boxed-layout';
	$classes[] = esc_html( $options['theme_image_style'] );
	$classes[] = esc_html( $options['theme_caption_style'] );
	$classes[] = esc_html( $options['theme_totop'] );
	$classes[] = esc_html( $options['theme_tables'] );
	if ( $options['theme_menustyle'] ) $classes[] = 'esotera-fixed-menu';
	if ( $options['theme_menuposition'] ) $classes[] = 'esotera-over-menu';
	if ( $options['theme_menulayout'] == 0 ) $classes[] = 'esotera-menu-left';
	if ( $options['theme_menulayout'] == 1 ) $classes[] = 'esotera-menu-right';
	if ( $options['theme_menulayout'] == 2 ) $classes[] = 'esotera-menu-center';
	if ( $options['theme_topsection'] ) $classes[] = 'esotera-topsection-reversed';
		else $classes[] = 'esotera-topsection-normal';
	if ( $options['theme_headerresponsive'] ) $classes[] = 'esotera-responsive-headerimage';
			else $classes[] = 'esotera-cropped-headerimage';
	if ( $options['theme_fresponsive'] ) $classes[] = 'esotera-responsive-featured';
		else $classes[] = 'esotera-cropped-featured';
	if ( $options['theme_magazinelayout'] ) {
		switch ( $options['theme_magazinelayout'] ):
			case 1: $classes[] = 'esotera-magazine-one esotera-magazine-layout'; break;
			case 2: $classes[] = 'esotera-magazine-two esotera-magazine-layout'; break;
			case 3: $classes[] = 'esotera-magazine-three esotera-magazine-layout'; break;
		endswitch;
	}
	switch ( $options['theme_comclosed'] ) {
		case 2: $classes[] = 'esotera-comhide-in-posts'; break;
		case 3: $classes[] = 'esotera-comhide-in-pages'; break;
		case 0: $classes[] = 'esotera-comhide-in-posts'; $classes[] = 'esotera-comhide-in-pages'; break;
	}
	if ( $options['theme_comlabels'] == 1 ) $classes[] = 'esotera-comment-placeholder';
	if ( $options['theme_comlabels'] == 2 ) $classes[] = 'esotera-comment-labels';
	if ( $options['theme_comicons'] == 1 ) $classes[] = 'esotera-comment-icons';
	if ( $options['theme_comdate'] == 1 ) $classes[] = 'esotera-comment-date-published';
	$theme_archive_desc = trim( get_the_archive_description() );
	switch ( $options['theme_contenttitles'] ) {
		case 2: $classes[] = 'esotera-hide-page-title'; break;
		case 3: $classes[] = 'esotera-hide-cat-title'; break;
		case 0: $classes[] = 'esotera-hide-page-title'; $classes[] = 'esotera-hide-cat-title'; break;
	}
	if ( $options['theme_elementborder'] ) $classes[] = 'esotera-elementborder';
	if ( $options['theme_elementshadow'] ) $classes[] = 'esotera-elementshadow';
	if ( $options['theme_elementborderradius'] ) $classes[] = 'esotera-elementradius';
	if ( $options['theme_normalizetags'] ) $classes[] = 'esotera-normalizedtags';
if ( !empty( $options['theme_articleanimation'] ) ) $classes[] = 'esotera-article-animation-' . esc_attr( $options['theme_articleanimation'] );
	return $classes;
}
add_filter( 'body_class', 'esotera_body_classes' );
function esotera_custom_styles() {
$options = cryout_get_option();
extract($options);
ob_start();
switch ( $theme_layoutalign ) {
	case 0: ?>
			body:not(.esotera-landing-page) #container, #colophon-inside, .footer-inside, #breadcrumbs-container-inside {
				margin: 0 auto;
				max-width: <?php echo esc_html( $theme_sitewidth ); ?>px;
			}
			body:not(.esotera-landing-page) #container {
				max-width: calc( <?php echo esc_html( $theme_sitewidth ); ?>px - 4em );
			}
	<?php break;
	case 1: ?>
			#site-wrapper {
				max-width: <?php echo esc_html( $theme_sitewidth ); ?>px;
			}
	<?php break;
}
if ( ! esc_html( $theme_menualignment ) ) { ?> .site-header-inside { max-width: <?php echo esc_html( $theme_sitewidth ) ?>px; margin: 0 auto; } <?php }
$colPadding = 0;
$sidebarP = absint( $theme_primarysidebar );
$sidebarS = absint( $theme_secondarysidebar );
?>
#primary 									{ width: <?php echo $sidebarP; ?>px; }
#secondary 									{ width: <?php echo $sidebarS; ?>px; }
#container.one-column .main					{ width: 100%; }
#container.two-columns-right #secondary 	{ float: right; }
#container.two-columns-right .main,
.two-columns-right #breadcrumbs				{ width: calc( <?php echo 100 - (int) $colPadding ?>% - <?php echo $sidebarS; ?>px ); float: left; }
#container.two-columns-left #primary 		{ float: left; }
#container.two-columns-left .main,
.two-columns-left #breadcrumbs				{ width: calc( <?php echo 100 - (int) $colPadding ?>% - <?php echo $sidebarP; ?>px ); float: right; }
#container.three-columns-right #primary,
#container.three-columns-left #primary,
#container.three-columns-sided #primary		{ float: left; }
#container.three-columns-right #secondary,
#container.three-columns-left #secondary,
#container.three-columns-sided #secondary	{ float: left; }
#container.three-columns-right #primary,
#container.three-columns-left #secondary 	{ margin-left: <?php echo esc_html( $colPadding ) ?>%; margin-right: <?php echo esc_html( $colPadding ) ?>%; }
#container.three-columns-right .main,
.three-columns-right #breadcrumbs			{ width: calc( <?php echo 100 - absint( $colPadding ) * 2 ?>% - <?php echo absint( $sidebarS + $sidebarP ); ?>px ); float: left; }
#container.three-columns-left .main,
.three-columns-left #breadcrumbs			{ width: calc( <?php echo 100 - absint( $colPadding ) * 2 ?>% - <?php echo absint( $sidebarS + $sidebarP ); ?>px ); float: right; }
#container.three-columns-sided #secondary 	{ float: right; }
#container.three-columns-sided .main,
.three-columns-sided #breadcrumbs			{ width: calc( <?php echo 100 - absint( $colPadding ) * 2 ?>% - <?php echo absint( $sidebarS + $sidebarP ); ?>px ); float: right; }
.three-columns-sided #breadcrumbs			{ margin: 0 calc( <?php echo absint( $colPadding ) ?>% + <?php echo absint($sidebarS) ?>px ) 0 -1920px; }
<?php if ( in_array( $theme_siteheader, array( 'logo', 'empty' ) ) ) { ?>
	#site-text {
		clip: rect(1px, 1px, 1px, 1px);
		height: 1px;
		overflow: hidden;
		position: absolute !important;
		width: 1px;
		word-wrap: normal !important;
	}
<?php }
?>
html
					{ font-family: <?php echo cryout_font_select( $theme_fgeneral, $theme_fgeneralgoogle ) ?>;
					  font-size: <?php echo esc_html( $theme_fgeneralsize ) ?>px; font-weight: <?php echo esc_html( $theme_fgeneralweight ) ?>;
					  line-height: <?php echo esc_html( (float) $theme_lineheight ) ?>;
				   	  <?php echo ( ! empty( $theme_fgeneralvariant ) ) ? 'text-transform: ' . $theme_fgeneralvariant : ''; ?>; }
#site-title 		{ font-family: <?php echo cryout_font_select( $theme_fsitetitle, $theme_fsitetitlegoogle ) ?>;
					  font-size: <?php echo esc_html( $theme_fsitetitlesize ) ?>em; font-weight: <?php echo esc_html( $theme_fsitetitleweight ) ?>;}
#site-text  		{ <?php echo ( ! empty( $theme_fsitetitlevariant ) ) ? 'text-transform: ' . $theme_fsitetitlevariant : ''; ?>; }
#access ul li a 	{ font-family: <?php echo cryout_font_select( $theme_fmenu, $theme_fmenugoogle ) ?>;
					  font-size: <?php echo esc_html( $theme_fmenusize ) ?>em; font-weight: <?php echo esc_html( $theme_fmenuweight ) ?>;
					  <?php echo ( ! empty( $theme_fmenuvariant ) ) ? 'text-transform: ' . $theme_fmenuvariant : ''; ?>; }
.widget-title,
#comments-title, #reply-title,
.related-posts .related-main-title
 					{ font-family: <?php echo cryout_font_select( $theme_fwtitle, $theme_fwtitlegoogle ) ?>;
					  font-size: <?php echo esc_html( $theme_fwtitlesize ) ?>em; font-weight: <?php echo esc_html( $theme_fwtitleweight ) ?>;
					  line-height: <?php echo esc_html( (float) $theme_fwtitlelineheight ) ?>; margin-bottom: <?php echo esc_html( (float) $theme_fwtitlespace ) ?>em;
					  <?php echo ( ! empty( $theme_fwtitlevariant ) ) ? 'text-transform: ' . $theme_fwtitlevariant : ''; ?>; }
.widget-container 	{ font-family: <?php echo cryout_font_select( $theme_fwcontent, $theme_fwcontentgoogle ) ?>;
				      font-size: <?php echo esc_html( $theme_fwcontentsize ) ?>em; font-weight: <?php echo esc_html( $theme_fwcontentweight ) ?>; }
.widget-container ul li { line-height: <?php echo esc_html( (float) $theme_fwcontentlineheight ) ?>;
					<?php echo ( ! empty( $theme_fwcontentvariant ) ) ? 'text-transform: ' . $theme_fwcontentvariant : ''; ?>; }
.entry-title,
.main .page-title
					{ font-family: <?php echo cryout_font_select( $theme_ftitles, $theme_ftitlesgoogle ) ?>;
					  font-size: <?php echo esc_html( $theme_ftitlessize ) ?>em; font-weight: <?php echo esc_html( $theme_ftitlesweight ) ?>;
					  <?php echo ( ! empty( $theme_ftitlesvariant ) ) ? 'text-transform: ' . $theme_ftitlesvariant : ''; ?>; }
body:not(.single) .entry-meta > span
					{ font-family: <?php echo cryout_font_select( $theme_metatitles, $theme_metatitlesgoogle ) ?>;
					  font-size: <?php echo esc_html( $theme_metatitlessize ) ?>em;
					  font-weight: <?php echo esc_html( $theme_metatitlesweight ) ?>;
					  <?php echo ( ! empty( $theme_metatitlesvariant ) ) ? 'text-transform: ' . $theme_metatitlesvariant : ''; ?>; }
/* single post titles/metas */
.single .entry-title,
.singular-title 	{ font-family: <?php echo cryout_font_select( $theme_singletitle, $theme_singletitlegoogle ) ?>;
					  font-size: <?php echo esc_html( $theme_singletitlesize ) ?>em; font-weight: <?php echo esc_html( $theme_singletitleweight ) ?>;
					  line-height: <?php echo esc_html( (float) $theme_singletitlelineheight ) ?>;
					  <?php echo ( ! empty( $theme_singletitlevariant ) ) ? 'text-transform: ' . $theme_singletitlevariant : ''; ?>; }
.single .entry-meta > span
					{ font-family: <?php echo cryout_font_select( $theme_singlemeta, $theme_singlemetagoogle ) ?>;
					  font-size: <?php echo esc_html( $theme_singlemetasize ) ?>em; font-weight: <?php echo esc_html( $theme_singlemetaweight ) ?>;
					  <?php echo ( ! empty( $theme_singlemetavariant ) ) ? 'text-transform: ' . $theme_singlemetavariant : ''; ?>; }
					  <?php
$font_root = 2.6;
for ( $i = 1; $i <= 6; $i++ ) {
		$size = round( ( $font_root - ( 0.27 * $i ) ) * ( preg_replace( "/[^\d]/", "", esc_html( $theme_fheadingssize ) ) / 100), 5 ); ?>
		h<?php echo $i ?> { font-size: <?php echo $size ?>em; } <?php
} ?>
h1, h2, h3, h4, h5, h6
					{ font-family: <?php echo cryout_font_select( $theme_fheadings, $theme_fheadingsgoogle ) ?>;
					  font-weight: <?php echo esc_html( $theme_fheadingsweight ) ?>;
					  <?php echo ( ! empty( $theme_fheadingsvariant ) ) ? 'text-transform: ' . $theme_fheadingsvariant : ''; ?>; }
.lp-staticslider .staticslider-caption-title,
.seriousslider-theme .seriousslider-caption-title,
.lp-section-title, .lp-text-title
					{ font-family: <?php echo cryout_font_select( $theme_fgeneral, $theme_fgeneralgoogle ) ?>;}
.entry-content h1, .entry-summary h1,
.entry-content h2, .entry-summary h2,
.entry-content h3, .entry-summary h3,
.entry-content h4, .entry-summary h4,
.entry-content h5, .entry-summary h5,
.entry-content h6, .entry-summary h6 {
	 line-height: <?php echo esc_html( (float) $theme_fheadingslineheight ) ?>;
	 margin-bottom: <?php echo esc_html( (float) $theme_fheadingsspace ) ?>em;
}
a.continue-reading-link,
.lp-block-readmore,
.lp-box-readmore,
#cryout_ajax_more_trigger,
.lp-port-readmore,
.comment .reply,
a.staticslider-button, .seriousslider-theme .seriousslider-caption-buttons a.seriousslider-button,
nav#mobile-menu a,
button, input[type="button"], input[type="submit"], input[type="reset"],
#nav-fixed a + a,
.wp-block-button { font-family: <?php echo cryout_font_select( $theme_fheadings, $theme_fheadingsgoogle ) ?>; }
.lp-text-title { font-family: <?php echo cryout_font_select( $theme_fgeneral, $theme_fgeneralgoogle ) ?>; font-weight: 700;}
blockquote cite 	{ font-family: <?php echo cryout_font_select( $theme_fgeneral, $theme_fgeneralgoogle ) ?>; }
<?php ?>
body { color: <?php echo esc_html( $theme_sitetext ) ?>; background-color: <?php echo esc_html( $theme_sitebackground ) ?>; }
.lp-staticslider .staticslider-caption-text a { color: <?php echo esc_html( $theme_menubackground ); ?>; }
#site-header-main,
.menu-search-animated .searchform input[type="search"], #access .menu-search-animated .searchform,
.site-header-bottom-fixed, .esotera-over-menu .site-header-bottom.header-fixed .site-header-bottom-fixed { background-color: <?php echo esc_html( $theme_menubackground ) ?>; }
.esotera-over-menu .site-header-bottom-fixed	{ background: transparent; }
.esotera-over-menu .header-fixed.site-header-bottom #site-title a,
.esotera-over-menu .header-fixed.site-header-bottom #site-description { color: <?php echo esc_html( $theme_accent1 ) ?>; }
.esotera-over-menu #site-title a,
.esotera-over-menu #site-description,
.esotera-over-menu #access > div > ul > li,
.esotera-over-menu #access > div > ul > li > a,
.esotera-over-menu .site-header-bottom:not(.header-fixed) #nav-toggle,
#breadcrumbs-container span, #breadcrumbs-container a, #breadcrumbs-container i {
	color: <?php echo esc_html( $theme_menubackground ) ?>; }
#bmobile #site-title a {
	color: <?php echo esc_html( $theme_accent1 ) ?>;
}
.esotera-over-menu .lp-staticslider .staticslider-caption-inside,
.esotera-over-menu .seriousslider-theme .seriousslider-caption-inside {
	<?php  ?>
}
#access > div > ul > li,
#access > div > ul > li > a,
.esotera-over-menu .header-fixed.site-header-bottom #access > div > ul > li:not([class*='current']),
.esotera-over-menu .header-fixed.site-header-bottom #access > div > ul > li:not([class*='current']) > a,
.esotera-over-menu .header-fixed.site-header-bottom .top-section-element.widget_cryout_socials a::before,
.top-section-element.widget_cryout_socials a::before
											{ color: <?php echo esc_html( $theme_menutext ) ?>; }
.hamburger .hamburger-inner 				{ background-color: <?php echo esc_html( $theme_menutext ) ?>; }
.esotera-over-menu .site-header-bottom:not(.header-fixed) .hamburger .hamburger-inner
											{ background-color: <?php echo esc_html( $theme_menubackground ) ?>; }
.esotera-over-menu .header-fixed.site-header-bottom .top-section-element.widget_cryout_socials a:hover::before,
.top-section-element.widget_cryout_socials a:hover::before
											{ color: <?php echo esc_html( $theme_menubackground ) ?>; }
#access ul.sub-menu li a, #access ul.children li a,
.site-header-top 					{ color: <?php echo esc_html( $theme_submenutext ) ?>;
									  background-color: <?php echo esc_html( $theme_submenubackground ) ?>;}
.topmenu ul li a 					{ color: <?php echo esc_html( $theme_submenutext ) ?>; }
#access ul.sub-menu li a:hover,
#access ul.children li a:hover 					{ color: <?php echo esc_html( $theme_accent1 ) ?>;	}
#access > div > ul > li.current_page_item > a,
#access > div > ul > li.current-menu-item > a,
#access > div > ul > li.current_page_ancestor > a,
#access > div > ul > li.current-menu-ancestor > a,
<?php ?>
.esotera-over-menu .header-fixed.site-header-bottom #access > div > ul > li > a
											{ color: <?php echo esc_html( $theme_activeitemtext ) ?>; }
#access ul.children > li.current_page_item > a,
#access ul.sub-menu > li.current-menu-item > a,
#access ul.children > li.current_page_ancestor > a,
#access ul.sub-menu > li.current-menu-ancestor > a
											{ opacity: 0.95; }
#access > div > ul ul > li a:not(:only-child)::after
											{ border-left-color: <?php echo esc_html( $theme_submenubackground ) ?>; }
#access > div > ul > li > ul::before 		{ border-bottom-color: <?php echo esc_html( $theme_submenubackground ) ?>; }
.searchform .searchsubmit					{ color: <?php echo esc_html( cryout_hexdiff( $theme_sitetext, -51 ) ); ?>; }
#access ul li.special1 > a {
	background-color: <?php echo esc_html( cryout_hexdiff( $theme_menubackground, 15 ) ); ?>;
}
#access ul li.special2 > a {
	background-color: <?php echo esc_html( $theme_menutext ); ?>;
	color: <?php echo esc_html( $theme_menubackground ) ?>;
}
#access ul li.accent1 > a {
	background-color: <?php echo esc_html( $theme_accent1 ); ?>;
	color: <?php echo esc_html( $theme_menubackground ) ?>;
}
#access ul li.accent2 > a {
	background-color: <?php echo esc_html( $theme_accent2 ); ?>;
	color: <?php echo esc_html( $theme_menubackground ) ?>;
}
#access ul li.accent1 > a:hover,
#access ul li.accent2 > a:hover {
	color: <?php echo esc_html( $theme_menubackground ) ?>;
}
#access > div > ul > li.accent1 > a > span::before,
#access > div > ul > li.accent2 > a > span::before {
	background-color: <?php echo esc_html( $theme_menubackground ) ?>;
}
body:not(.esotera-landing-page) article.hentry,
body:not(.esotera-landing-page) .main,
body.esotera-boxed-layout:not(.esotera-landing-page) #container
											{ background-color: <?php echo esc_html( $theme_contentbackground ) ?>; }
.pagination a, .pagination span 			{ background-color: <?php echo esc_html( cryout_hexdiff( $theme_contentbackground, 12 ) ); ?>; }
.pagination a:not(.prev):not(.next):hover	{ background-color: <?php echo esc_html( $theme_accent1 ); ?>; color: <?php echo esc_html( $theme_contentbackground) ?>; }
#header-overlay,
.lp-staticslider::after, .seriousslider-theme::after
											{	background-color: <?php echo esc_html( $theme_overlaybackground1 ); ?>;
												background: -webkit-linear-gradient( <?php echo absint( $theme_overlayangle - 90 ) . 'deg, ' . esc_html( $theme_overlaybackground1 ) . ' ' . absint( $theme_overlaybackgroundposition1 ) . '%, ' . esc_html( $theme_overlaybackground2 ) . ' ' . absint( $theme_overlaybackgroundposition2 ) . '%' ;?>);
												background: linear-gradient( <?php echo absint( $theme_overlayangle ) . 'deg, ' . esc_html( $theme_overlaybackground1 ) . ' ' . absint( $theme_overlaybackgroundposition1 ) . '%, ' . esc_html( $theme_overlaybackground2 ) . ' ' . absint( $theme_overlaybackgroundposition2 ) . '%' ;?>);
												opacity: <?php echo esc_html( $theme_overlayopacity/100 ); ?>; }
.lp-staticslider .staticslider-caption-inside,
.seriousslider-theme .seriousslider-caption-inside
										{ color: <?php echo esc_html(  $theme_overlaytext ) ;?>; }
<?php if ( ! is_rtl() ):
	if ( $theme_sitelayout == '2cSr' || $theme_sitelayout == '2cSl' || $theme_sitelayout == '3cSs' ) { ?>
	<?php } if ( $theme_sitelayout == '3cSr' ) { ?>
	#secondary  { margin-left: 0; }
	#primary  { padding-left: 3%; padding-right: 0; }
	<?php } if ( $theme_sitelayout == '3cSl' ) { ?>
	#secondary  { padding-right: 3%; padding-left: 0; }
	#primary  { margin-right: 0; }
		<?php }
endif; ?>
<?php if ( is_rtl() ):
	if ( $theme_sitelayout == '2cSr' || $theme_sitelayout == '2cSl' || $theme_sitelayout == '3cSs' ) { ?>
	<?php } if ( $theme_sitelayout == '3cSr' ) { ?>
	body #secondary  { margin-right: 0; }
	body #primary  { padding-right: 3%; padding-left: 0; }
	<?php } if ( $theme_sitelayout == '3cSl' ) { ?>
	body #secondary  { padding-left: 3%; padding-right: 3%; }
	body #primary  { margin-left: 0; }
		<?php }
endif; ?>
<?php if ( ! empty( $theme_primarybackground ) ) { ?>
	#primary .widget-container				{ background-color: <?php echo esc_html( $theme_primarybackground ) ?>;  border-color: <?php echo  esc_html (cryout_hexdiff ($theme_primarybackground, 17 )) ?>; padding: 1.5em 2.5em; }
	@media (max-width: 1024px) { .cryout #container #primary .widget-container { padding: 1em; } }
<?php } ?>
<?php if ( ! empty( $theme_secondarybackground ) ) { ?>
	#secondary .widget-container			{ background-color: <?php echo esc_html( $theme_secondarybackground ) ?>; border-color: <?php echo  esc_html (cryout_hexdiff ($theme_secondarybackground, 17 )) ?>; padding: 1.5em 2.5em;}
	@media (max-width: 1024px) { .cryout #container #secondary .widget-container { padding: 1em; } }
<?php } ?>

#colophon, #footer 							{ background-color: <?php echo esc_html( $theme_footerbackground ) ?>;
 											  color: <?php echo esc_html( $theme_footertext ) ?>; }
.post-thumbnail-container .featured-image-overlay::before {
	background: -webkit-gradient(linear, left top, left bottom, from(#000), to(<?php echo esc_html( $theme_accent2 ) ?>));
	background: linear-gradient(to bottom, #000, <?php echo esc_html( $theme_accent2 ) ?>);
}
.post-thumbnail-container .featured-image-overlay::after {
	background-color: <?php echo esc_html( $theme_accent1 ) ?>;
	background: -webkit-gradient(linear, left top, left bottom, from(<?php echo esc_html( $theme_accent1 ) ?>), to(<?php echo esc_html( $theme_accent2 ) ?>));
	background: linear-gradient(to bottom, <?php echo esc_html( $theme_accent2 ) ?>, <?php echo esc_html( $theme_accent1 ) ?>);
}
body:not(.esotera-magazine-one) .main #content-masonry .post-thumbnail-container + .entry-after-image
											{ background-color: <?php echo esc_html( $theme_contentbackground ) ?>;}
.main #content-masonry .post-thumbnail-container:hover + .entry-after-image .entry-title a
											{ color: <?php echo esc_html( $theme_accent1 ) ?>; }
@media (max-width: 720px) {
	.esotera-magazine-one .main #content-masonry  .post-thumbnail-container + .entry-after-image
											{  background-color: <?php echo esc_html( $theme_contentbackground ) ?>; }
							}
.entry-title a:active, .entry-title a:hover { color: <?php echo esc_html( $theme_accent1 ) ?>; }
span.entry-format 							{ color: <?php echo esc_html( $theme_accent1 ) ?>; }

.main #content-masonry .format-link .entry-content a { background-color:  <?php echo esc_html( $theme_accent1 ) ?>; color: <?php echo esc_html( $theme_contentbackground ) ?>; }
.main #content-masonry .format-link::after { color: <?php echo esc_html( $theme_contentbackground ) ?>; }
.cryout article.hentry.format-image,
.cryout article.hentry.format-audio,
.cryout article.hentry.format-video 		{ background-color: <?php echo esc_html( cryout_hexdiff( $theme_contentbackground, 10 ) ) ?>; }
.format-aside, .format-quote 				{ border-color: <?php echo esc_html( cryout_hexdiff( $theme_contentbackground, 33 ) ) ?>; }
.single #author-info						{ border-color: <?php echo esc_html( cryout_hexdiff( $theme_contentbackground, 17 ) ) ?>; }
.entry-content h5, .entry-content h6,
.lp-text-content h5, .lp-text-content h6 	{ color: <?php echo esc_html( $theme_accent2 ) ?>; }
.entry-content blockquote::before,
.entry-content blockquote::after 			{ color: rgba(<?php echo cryout_hex2rgb( esc_html( $theme_sitetext ) ) ?>,0.2); }
.entry-content h1, .entry-content h2,
.entry-content h3, .entry-content h4,
.lp-text-content h1, .lp-text-content h2,
.lp-text-content h3, .lp-text-content h4	{ color: <?php echo esc_html( $theme_headingstext ) ?>; }
.entry-title, .page-title 					{ color: <?php echo esc_html( $theme_titletext ) ?>; }
a 											{ color: <?php echo esc_html( $theme_accent1 ); ?>; }
a:hover, .entry-meta span a:hover,
.comments-link a 							{ color: <?php echo esc_html( $theme_accent2 ); ?>; }
.comments-link a:hover 						{ color: <?php echo esc_html( $theme_accent1 ); ?>; }
.socials a									{ background: <?php echo esc_html( $theme_footertext) ?>; }
.socials a::before, .socials a::after		{ color: <?php echo esc_html( $theme_footerbackground ) ?>; }
.site-header-top .socials a					{ background: <?php echo esc_html( $theme_submenutext) ?>; }
.site-header-top .socials a::before,
.site-header-top .socials a::after			{ color: <?php echo esc_html( $theme_submenubackground ) ?>; }
.esotera-normalizedtags #content .tagcloud a
											{ color: <?php echo esc_html($theme_contentbackground) ?>;
											  background-color: <?php echo esc_html( $theme_accent1 ) ?>; }
.esotera-normalizedtags #content .tagcloud a:hover
											{ background-color: <?php echo esc_html( $theme_accent2 ) ?>; }
#nav-fixed i								{ background-color: <?php echo esc_html( cryout_hexdiff( $theme_contentbackground, 36 ) ) ?>; }
#nav-fixed .nav-next:hover i,
#nav-fixed .nav-previous:hover i			{ background-color: <?php echo esc_html( $theme_accent2); ?>; }
#nav-fixed a:hover + a,
#nav-fixed a + a:hover						{ background-color: rgba(<?php echo esc_html( cryout_hex2rgb( $theme_accent2 ) ) ?>,1); }
#nav-fixed i, #nav-fixed span				{ color: <?php echo esc_html( $theme_contentbackground ) ?>; }
a#toTop::before 							{ color: <?php echo esc_html( $theme_accent1 ) ?>; }
a#toTop::after								{ color: <?php echo esc_html( $theme_accent2 ) ?>; }
<?php if( $theme_totop != 'esotera-totop-disabled' ) { ?>
	@media (max-width: 800px) {
		.cryout #footer-bottom .footer-inside { padding-top: 2.5em; }
		.cryout .footer-inside a#toTop {background-color: <?php echo esc_html( $theme_accent1 ) ?>;  color: <?php echo esc_html( $theme_sitebackground ) ?>;}
		.cryout .footer-inside a#toTop:hover { opacity: 0.8;}
	}
<?php } ?>
.lp-box-readmore::before	{
	background-color: <?php echo esc_html( $theme_accent1 )?>;
	background-image: -webkit-linear-gradient(to right,<?php echo esc_html( $theme_accent1 )?>,<?php echo esc_html( $theme_accent2 ) ?>,<?php echo esc_html( $theme_accent1 )?>,<?php echo esc_html( $theme_accent2 ) ?>);
	background-image: linear-gradient(to right,<?php echo esc_html( $theme_accent1 )?>,<?php echo esc_html( $theme_accent2 ) ?>,<?php echo esc_html( $theme_accent1 )?>,<?php echo esc_html( $theme_accent2 ) ?>); }
.lp-box-readmore, .lp-box-readmore:hover	{ color: <?php echo esc_html( $theme_contentbackground ) ?>; }
.entry-meta .icon-metas:before				{ color: <?php echo esc_html( cryout_hexdiff( $theme_sitetext, -69) ) ?>; }
.esotera-caption-one .main .wp-caption .wp-caption-text 	{ border-bottom-color: <?php echo esc_html( cryout_hexdiff( $theme_contentbackground, 17 ) ) ?>; }
.esotera-caption-two .main .wp-caption .wp-caption-text 	{ background-color: <?php echo esc_html( cryout_hexdiff( $theme_contentbackground,10 ) ) ?>; }
.esotera-image-one .entry-content img[class*="align"],
.esotera-image-one .entry-summary img[class*="align"],
.esotera-image-two .entry-content img[class*='align'],
.esotera-image-two .entry-summary img[class*='align'] 	{ border-color: <?php echo esc_html( cryout_hexdiff( $theme_contentbackground, 17 ) ) ?>; }
.esotera-image-five .entry-content img[class*='align'],
.esotera-image-five .entry-summary img[class*='align'] 	{ border-color: <?php echo esc_html( $theme_accent1 ); ?>; }
/* diffs */
span.edit-link a.post-edit-link,
span.edit-link a.post-edit-link:hover,
span.edit-link .icon-edit:before			{ color: <?php echo esc_html( $theme_sitetext, 19 ) ?>; }
.searchform 								{ border-color: <?php echo esc_html( cryout_hexdiff( $theme_contentbackground, 20 ) ) ?>; }
.entry-meta span, .entry-meta a, .entry-utility span, .entry-utility a, .entry-meta time,
#breadcrumbs-nav 							{ color: <?php echo esc_html( cryout_hexdiff( $theme_sitetext, -55) ) ?>; }
.footermenu ul li span.sep					{ color: <?php echo esc_html( $theme_accent1 ) ?>; }
.entry-meta a::after, .entry-utility a::after
											{ background: <?php echo esc_html( $theme_accent2 ) ?>; }
.footermenu ul li a:hover 					{ color: <?php echo esc_html( $theme_accent1 ); ?>; }
.footermenu ul li a::after 					{ background: <?php echo esc_html( $theme_accent1 ); ?>; }
span.entry-sticky							{ background-color: <?php echo esc_html( $theme_accent1 ) ?>;  color: <?php echo esc_html( $theme_contentbackground ); ?>; }
#commentform								{ <?php if ( $theme_comformwidth ) { echo 'max-width:' . esc_html( $theme_comformwidth ) . 'px;';}?>}
code, #nav-below .nav-previous a:before, #nav-below .nav-next a:before
											{ background-color: <?php echo esc_html( cryout_hexdiff( $theme_contentbackground, 17 ) ) ?>; }
pre, .comment-author						{ border-color: <?php echo esc_html( cryout_hexdiff( $theme_contentbackground, 17 ) ) ?>; }
.commentlist .comment-body, .commentlist .pingback
											{ background-color: <?php echo esc_html( cryout_hexdiff( $theme_contentbackground, 10 ) ) ?>; }
.commentlist img.avatar						{ background-color: <?php echo esc_html( $theme_contentbackground ) ?>; }
.comment-meta a 							{ color: <?php echo esc_html( cryout_hexdiff( $theme_sitetext, -79) ) ?>; }
.commentlist .reply a 						{ color: <?php echo esc_html( cryout_hexdiff( $theme_sitetext, -79) ) ?>;  }
.commentlist .reply a:hover					{ color: <?php echo esc_html( $theme_accent1 ) ?>; }
select, input[type], textarea 				{ color: <?php echo esc_html( $theme_sitetext ); ?>;
											  border-color: <?php echo esc_html( cryout_hexdiff( $theme_contentbackground, 22 ) ) ?>; }
.searchform input[type="search"],
.searchform input[type="search"]:hover,
.searchform input[type="search"]:focus		{ background-color: <?php echo esc_html( $theme_contentbackground ) ?>; }
#content .searchform input[type="search"] 	{ border-color: <?php echo esc_html( cryout_hexdiff( $theme_contentbackground, 22 ) ) ?>; }
#content .searchform:hover input[type="search"]
											{ border-color: <?php echo esc_html( $theme_accent2 ) ?>; }
#content .searchform input[type="search"]:focus
											{ border-color: <?php echo esc_html( $theme_accent1 ) ?>; }
input[type]:hover, textarea:hover, select:hover,
input[type]:focus, textarea:focus, select:focus
											{ border-color: <?php echo esc_html( cryout_hexdiff( $theme_contentbackground, 35 ) ) ?>; }
button, input[type="button"], input[type="submit"], input[type="reset"],
.entry-meta .author-avatar					 {
											  background-color: <?php echo esc_html( $theme_accent1 )?>;
										  	  background-image: -webkit-linear-gradient(to right,<?php echo esc_html( $theme_accent1 )?>,<?php echo esc_html( $theme_accent2 ) ?>,<?php echo esc_html( $theme_accent1 )?>,<?php echo esc_html( $theme_accent2 ) ?>);
										  	  background-image: linear-gradient(to right,<?php echo esc_html( $theme_accent1 )?>,<?php echo esc_html( $theme_accent2 ) ?>,<?php echo esc_html( $theme_accent1 )?>,<?php echo esc_html( $theme_accent2 ) ?>);
											  color: <?php echo esc_html( $theme_contentbackground ) ?>; }
button:hover, input[type="button"]:hover, input[type="submit"]:hover, input[type="reset"]:hover
											{ background-color: <?php echo esc_html( $theme_accent2 ) ?>; }
.comment-form-comment, .comment-form-author, .comment-form-email, .comment-form-url,
[class*='comment-form-'] input:hover, [class*='comment-form-'] input:focus,
.comment-form-comment textarea:hover, .comment-form-comment textarea:focus
											{ border-color: <?php echo esc_html( cryout_hexdiff( $theme_contentbackground, 10 ) ) ?>;
												background: <?php echo esc_html( cryout_hexdiff( $theme_contentbackground, 10 ) ) ?>; }
.comment-form-author input, .comment-form-email input, .comment-form-url input, .comment-form-comment textarea
										  { background-color: <?php echo esc_html( $theme_contentbackground ) ?>;  }
hr											{ background-color: <?php echo esc_html(cryout_hexdiff($theme_contentbackground, 15 ) ) ?>; }
.cryout-preloader-inside .bounce1 { border-top-color: <?php echo esc_html( $theme_accent1 ) ?>; }
.cryout-preloader-inside .bounce2 { border-top-color: <?php echo esc_html( $theme_accent2 ) ?>; }
/* gutenberg */
.wp-block-image.alignwide {
	margin-left: calc( ( <?php echo intval($theme_elementpadding * 1.50) ?>% + 4em ) * -1 );
	margin-right: calc( ( <?php echo intval($theme_elementpadding * 1.50) ?>% + 4em ) * -1 );
}
.wp-block-image.alignwide img {
	width: calc( <?php echo intval( 100 + $theme_elementpadding * 3 ) ?>% + 8em );
	max-width: calc( <?php echo intval( 100 + $theme_elementpadding * 3 ) ?>% + 8em );
}
.has-accent-1-color, .has-accent-1-color:hover	{ color: <?php echo esc_html( $theme_accent1 ) ?>; }
.has-accent-2-color, .has-accent-2-color:hover	{ color: <?php echo esc_html( $theme_accent2 ) ?>; }
.has-headings-color, .has-headings-color:hover 	{ color: <?php echo esc_html( $theme_headingstext ) ?>; }
.has-sitetext-color, .has-sitetext-color:hover	{ color: <?php echo esc_html( $theme_sitetext ) ?>; }
.has-sitebg-color, .has-sitebg-color:hover 		{ color: <?php echo esc_html( $theme_contentbackground ) ?>; }
.has-accent-1-background-color 				{ background-color: <?php echo esc_html( $theme_accent1 ) ?>; }
.has-accent-2-background-color 				{ background-color: <?php echo esc_html( $theme_accent2 ) ?>; }
.has-headings-background-color 				{ background-color: <?php echo esc_html( $theme_headingstext ) ?>; }
.has-sitetext-background-color 				{ background-color: <?php echo esc_html( $theme_sitetext ) ?>; }
.has-sitebg-background-color 				{ background-color: <?php echo esc_html( $theme_contentbackground ) ?>; }
.has-small-font-size 						{ font-size: <?php echo intval( intval($theme_fgeneralsize) / 1.2 ) ?>px; }
.has-regular-font-size 						{ font-size: <?php echo intval( intval($theme_fgeneralsize) * 1.0 ) ?>px; }
.has-large-font-size 						{ font-size: <?php echo intval( intval($theme_fgeneralsize) * 1.2 ) ?>px; }
.has-larger-font-size 						{ font-size: <?php echo intval( intval($theme_fgeneralsize) * 1.44 ) ?>px; }
.has-huge-font-size 						{ font-size: <?php echo intval( intval($theme_fgeneralsize) * 1.44 ) ?>px; }
/* woocommerce */
.woocommerce-thumbnail-container .woocommerce-buttons-container a,
.woocommerce-page #respond input#submit.alt, .woocommerce a.button.alt,
.woocommerce-page button.button.alt, .woocommerce input.button.alt,
.woocommerce #respond input#submit, .woocommerce a.button,
.woocommerce button.button, .woocommerce input.button {
	font-family: <?php echo cryout_font_select( $theme_fheadings, $theme_fheadingsgoogle ) ?>;
}
.woocommerce ul.products li.product .woocommerce-loop-category__title,
.woocommerce ul.products li.product .woocommerce-loop-product__title,
.woocommerce ul.products li.product h3,
.woocommerce div.product .product_title,
.woocommerce .woocommerce-tabs h2 {
	font-family: <?php echo cryout_font_select( $theme_fgeneral, $theme_fgeneralgoogle ) ?>;
}
.woocommerce ul.products li.product .woocommerce-loop-category__title,
.woocommerce ul.products li.product .woocommerce-loop-product__title,
.woocommerce ul.products li.product h3,
.woocommerce .star-rating {
	color: <?php echo esc_html( $theme_accent2 ) ?>;
}
.woocommerce-page #respond input#submit.alt, .woocommerce a.button.alt,
.woocommerce-page button.button.alt, .woocommerce input.button.alt,
.woocommerce #respond input#submit, .woocommerce a.button,
.woocommerce button.button, .woocommerce input.button
											{ background-color: <?php echo esc_html( $theme_accent1 ) ?>;
											  color: <?php echo esc_html( $theme_contentbackground ) ?>;
											  line-height: <?php echo esc_html( (float) $theme_lineheight ) ?>; }
.woocommerce #respond input#submit:hover, .woocommerce a.button:hover,
.woocommerce button.button:hover, .woocommerce input.button:hover
											{ background-color: <?php echo esc_html( cryout_hexdiff( $theme_accent2, 0 ) ) ?>;
										 	 color: <?php echo esc_html( $theme_contentbackground ) ?>;}
.woocommerce-page #respond input#submit.alt, .woocommerce a.button.alt,
.woocommerce-page button.button.alt, .woocommerce input.button.alt
											{
											  background-color: <?php echo esc_html( $theme_accent1 )?>;
											  background-image: -webkit-linear-gradient(to right,<?php echo esc_html( $theme_accent1 )?>,<?php echo esc_html( $theme_accent2 ) ?>,<?php echo esc_html( $theme_accent1 )?>,<?php echo esc_html( $theme_accent2 ) ?>);
											  background-image: linear-gradient(to right,<?php echo esc_html( $theme_accent1 )?>,<?php echo esc_html( $theme_accent2 ) ?>,<?php echo esc_html( $theme_accent1 )?>,<?php echo esc_html( $theme_accent2 ) ?>);
											  color: <?php echo esc_html( $theme_contentbackground ) ?>;
										  	  line-height: <?php echo esc_html( (float) $theme_lineheight ) ?>; }
.woocommerce-page #respond input#submit.alt:hover, .woocommerce a.button.alt:hover,
.woocommerce-page button.button.alt:hover, .woocommerce input.button.alt:hover
											{ background-color: <?php echo esc_html( cryout_hexdiff( $theme_accent2, -34 ) ) ?>;
											  color: <?php echo esc_html( $theme_contentbackground ) ?>;}
.woocommerce div.product .woocommerce-tabs ul.tabs li.active
											{ border-bottom-color: <?php echo esc_html( $theme_contentbackground ) ?>; }
.woocommerce #respond input#submit.alt.disabled,
.woocommerce #respond input#submit.alt.disabled:hover,
.woocommerce #respond input#submit.alt:disabled,
.woocommerce #respond input#submit.alt:disabled:hover,
.woocommerce #respond input#submit.alt[disabled]:disabled,
.woocommerce #respond input#submit.alt[disabled]:disabled:hover,
.woocommerce a.button.alt.disabled, .woocommerce a.button.alt.disabled:hover,
.woocommerce a.button.alt:disabled, .woocommerce a.button.alt:disabled:hover,
.woocommerce a.button.alt[disabled]:disabled,
.woocommerce a.button.alt[disabled]:disabled:hover,
.woocommerce button.button.alt.disabled,
.woocommerce button.button.alt.disabled:hover,
.woocommerce button.button.alt:disabled,
.woocommerce button.button.alt:disabled:hover,
.woocommerce button.button.alt[disabled]:disabled,
.woocommerce button.button.alt[disabled]:disabled:hover,
.woocommerce input.button.alt.disabled,
.woocommerce input.button.alt.disabled:hover,
.woocommerce input.button.alt:disabled,
.woocommerce input.button.alt:disabled:hover,
.woocommerce input.button.alt[disabled]:disabled,
.woocommerce input.button.alt[disabled]:disabled:hover
											{ background-color: <?php echo esc_html( $theme_accent2 ) ?>; }
.woocommerce div.product .product_title,
.woocommerce ul.products li.product .price,
.woocommerce div.product p.price,
.woocommerce div.product span.price
											{ color: <?php echo esc_html( cryout_hexdiff( $theme_accent2, 0 ) ); ?> }
.woocommerce .quantity .qty					{ background-color: <?php echo esc_html( cryout_hexdiff( $theme_contentbackground, 17 ) ) ?>; }
.woocommerce-checkout #payment 				{ background: <?php echo esc_html( cryout_hexdiff( $theme_contentbackground, 10 ) ) ?>; }
.woocommerce .widget_price_filter .ui-slider .ui-slider-handle
											{ background: <?php echo esc_html( cryout_hexdiff( $theme_accent2, 0 ) ) ?>; }
.woocommerce div.product .products > h2,
.woocommerce .cart-collaterals h2 			{ font-family: <?php echo cryout_font_select( $theme_fwtitle, $theme_fwtitlegoogle ) ?>;
										 	  font-size: <?php echo esc_html( $theme_fwtitlesize ) ?>em; font-weight: <?php echo esc_html( $theme_fwtitleweight ) ?>;
										 	  line-height: <?php echo esc_html( (float) $theme_fwtitlelineheight ) ?>;
										 	  <?php echo ( ! empty( $theme_fwtitlevariant ) ) ? 'text-transform: ' . $theme_fwtitlevariant : ''; ?>; }
.woocommerce div.product .products > h2::after,
.woocommerce .cart-collaterals h2::after 	{ background-color: <?php echo esc_html( $theme_accent1 )?> ;
											  background: -webkit-linear-gradient(to right,<?php echo esc_html( $theme_accent1 )?>,<?php echo esc_html( $theme_accent2 ) ?>);
											  background: linear-gradient(to right,<?php echo esc_html( $theme_accent1 )?>,<?php echo esc_html( $theme_accent2 ) ?>); }
.woocommerce .main .page-title {
	/*font-size: <?php echo round( ( $font_root - ( 3 ) ) / 100 * ( preg_replace( "/[^\d]/", "", esc_html( $theme_fheadingssize ) ) / 100), 5 ); ?>em; */
}
/* mobile menu */
nav#mobile-menu, #mobile-menu .menu-main-search
 											{ background-color: <?php echo esc_html( $theme_menubackground ) ?>; }
#mobile-menu .mobile-arrow 					{ color: <?php echo esc_html( $theme_sitetext ) ?>; }
<?php
?>
.main .entry-content, .main .entry-summary 	{ text-align: <?php echo esc_html( $theme_textalign ) ?>; }
.main p, .main ul, .main ol, .main dd, .main pre, .main hr
											{ margin-bottom: <?php echo esc_html( $theme_paragraphspace ) ?>em; }
.main p 									{ text-indent: <?php echo esc_html( $theme_parindent ) ?>;}
.main a.post-featured-image 				{ background-position: <?php echo esc_html( $theme_falign ) ?>; }
#header-widget-area 						{ width: <?php echo esc_html( $theme_headerwidgetwidth ) ?>;
											<?php switch ( esc_html( $theme_headerwidgetalign ) ) {
												case 'left': ?> left: 10px; <?php break;
												case 'right': ?> right: 10px; <?php break;
												case 'center': ?>  left: calc(50% - <?php echo esc_html( $theme_headerwidgetwidth ) ?> / 2); <?php break;
											} ?> }
.esotera-stripped-table .main thead th,
.esotera-bordered-table .main thead th,
.esotera-stripped-table .main td, .esotera-stripped-table .main th,
.esotera-bordered-table .main th, .esotera-bordered-table .main td
											{ border-color: <?php echo esc_html( cryout_hexdiff( $theme_contentbackground, 22 ) ) ?>; }
.esotera-clean-table .main th,
.esotera-stripped-table .main tr:nth-child(even) td,
.esotera-stripped-table .main tr:nth-child(even) th
											{ background-color: <?php echo esc_html( cryout_hexdiff( $theme_contentbackground, 7 ) ) ?>; }
<?php if ( $theme_fpost && ( $theme_fheight > 0 ) ) { ?>
.esotera-cropped-featured .main .post-thumbnail-container
											{ height: <?php echo esc_html( $theme_fheight ) ?>px; }
.esotera-responsive-featured .main .post-thumbnail-container
											{ max-height: <?php echo esc_html( $theme_fheight ) ?>px; height: auto; }
<?php } ?>

<?php
if ( empty( $theme_contentbackground ) ) {  ?> #primary, #colophon { border: 0; box-shadow: none; } <?php }
?>
article.hentry .article-inner,
#content-masonry article.hentry .article-inner {
		padding: <?php echo esc_html( $theme_elementpadding ) ?>%;
}
<?php if ( $theme_elementpadding ) { ?>
#breadcrumbs-nav,
body.woocommerce.woocommerce-page #breadcrumbs-nav,
.pad-container  							{ padding: <?php echo esc_html( $theme_elementpadding ) ?>%; }
.esotera-magazine-two.archive #breadcrumbs-nav,
.esotera-magazine-two.archive .pad-container,
.esotera-magazine-two.search #breadcrumbs-nav,
.esotera-magazine-two.search .pad-container
											{ padding: <?php echo esc_html( $theme_elementpadding/2 ) ?>%; }
.esotera-magazine-three.archive #breadcrumbs-nav,
.esotera-magazine-three.archive .pad-container,
.esotera-magazine-three.search #breadcrumbs-nav,
.esotera-magazine-three.search .pad-container
											{ padding: <?php echo esc_html( $theme_elementpadding/3 ) ?>%; }
<?php } ?>
.site-header-bottom 						{ height:<?php echo intval( $theme_menuheight + 1 ) ?>px; }
.site-header-bottom .site-header-inside
											{ height:<?php echo intval( $theme_menuheight ) ?>px; }
.menu-search-animated, .hamburger,
#sheader-container, .identity, #nav-toggle
											{ height: <?php echo intval( $theme_menuheight ) ?>px;
											  line-height: <?php echo intval( $theme_menuheight ) ?>px; }
#access div > ul > li > a,
#access ul li[class*="icon"]::before  		{ line-height:<?php echo intval( $theme_menuheight ) ?>px; }

#branding		 							{ height:<?php echo intval( $theme_menuheight ) ?>px; }

.esotera-responsive-headerimage #masthead #header-image-main-inside
											{ max-height: <?php echo esc_html( $theme_headerheight ) ?>px; }
.esotera-cropped-headerimage #masthead #header-image-main-inside
											{ height: <?php echo esc_html( $theme_headerheight ) ?>px; }

.esotera-cropped-headerimage #container:not(.esotera-landing-page) .main
											{ margin-top: -<?php echo esc_html( $theme_headerheight * $theme_headeroverlap_pc/100 ) ?>px; }
.esotera-cropped-headerimage #breadcrumbs-container
											{ top: -<?php echo esc_html( $theme_headerheight * $theme_headeroverlap_pc/100) ?>px; }
.esotera-responsive-headerimage #container:not(.esotera-landing-page) .main
											{ margin-top: -<?php echo esc_html( $theme_headeroverlap_px ) ?>px; }
.esotera-responsive-headerimage #breadcrumbs-container
											{ top: -<?php echo esc_html( $theme_headeroverlap_px) ?>px; }
<?php if ( is_front_page() && function_exists( 'the_custom_header_markup' ) && has_header_video() ) { ?>
	.esotera-responsive-headerimage #masthead #header-image-main-inside { max-height: none; }
	.esotera-cropped-headerimage #masthead #header-image-main-inside { height: auto; }
<?php } ?>
<?php if ( $theme_sitetagline ) {?> #site-description { display: block; } <?php } ?>
<?php if (! display_header_text() ) { ?>
	#site-text 								{ display: none; }
<?php }; ?>
<?php if ( esc_html( $theme_menuposition ) ) { ?>
	#header-widget-area						{ top: <?php echo intval( $theme_menuheight )+10 ?>px; }
<?php }; ?>
<?php
$header_image = esotera_header_image_url();
if ( empty( $header_image ) ) { ?>
@media (min-width: 1152px) {
	<?php if ( esc_html( $theme_menuposition ) ) { ?>
	body:not(.esotera-landing-page) #site-wrapper
											{ margin-top: <?php echo intval( $theme_menuheight ) ?>px; }
	<?php } ?>
	body:not(.esotera-landing-page) #masthead
											{ border-bottom: 1px solid <?php echo esc_html( cryout_hexdiff( $theme_menubackground, 17 ) ); ?>; }
}
<?php }; ?>
.esotera-landing-page .lp-blocks-inside,
.esotera-landing-page .lp-boxes-inside,
.esotera-landing-page .lp-text-inside,
.esotera-landing-page .lp-posts-inside,
.esotera-landing-page .lp-page-inside,
.esotera-landing-page .lp-section-header,
.esotera-landing-page .content-widget		{ max-width: <?php echo esc_html( $theme_sitewidth ) ?>px;	}
.lp-staticslider .staticslider-caption,
.seriousslider.seriousslider-theme .seriousslider-caption
											{ max-width: <?php echo esc_html($theme_sitewidth) ?>px; }
.esotera-landing-page .content-widget 		{ margin: 0 auto; }
a.staticslider-button:nth-child(2n+1),
.seriousslider-theme .seriousslider-caption-buttons a:nth-child(2n+1)
 											{
												color: <?php echo esc_html( $theme_contentbackground ); ?>;
												background: transparent; }

a.staticslider-button:nth-child(2n),
.seriousslider-theme .seriousslider-caption-buttons a:nth-child(2n)
											{
												color: <?php echo esc_html( $theme_accent1 ); ?>;
												border-color: <?php echo esc_html( $theme_contentbackground ); ?>;
												background-color: <?php echo esc_html( $theme_contentbackground ); ?>; }
<?php if ( $theme_lpslider == 3 ) { ?> .esotera-landing-page #header-image-main-inside { display: block; } <?php } ?>
.lp-section-header .lp-section-title::after,
.main .lp-text-title::after, .widget-title::after,
#comments-title::after, #reply-title::after,
.related-posts .related-main-title::after	{
											background-color: <?php echo esc_html( $theme_accent1 )?> ;
											background: -webkit-linear-gradient(to right,<?php echo esc_html( $theme_accent1 )?>,<?php echo esc_html( $theme_accent2 ) ?>);
											background: linear-gradient(to right,<?php echo esc_html( $theme_accent1 )?>,<?php echo esc_html( $theme_accent2 ) ?>);}
.lp-section-desc 							{ color: <?php echo esc_html( cryout_hexdiff( $theme_sitetext, -40 ) ) ?>; }
.lp-blocks 									{ background-color: <?php echo esc_html( $theme_lpblocksbg ) ?>; }
.lp-boxes 									{ background-color: <?php echo esc_html( $theme_lpboxesbg ) ?>; }
.lp-text 									{ background-color: <?php echo esc_html( $theme_lptextsbg ) ?>; }
#lp-posts, #lp-page 						{ background-color: <?php echo esc_html( $theme_lppostsbg ) ?>; }
body .lp-block 								{ border-color: <?php echo esc_html( cryout_hexdiff( $theme_contentbackground, 28 ) ) ;?>; }
.lp-block i[class^=blicon]::before 			{ color: <?php echo esc_html( $theme_accent1 ); ?>; }
.lp-block .lp-block-title 					{ color: <?php echo esc_html( $theme_accent1 ); ?>; }
.lp-block:hover .lp-block-title 			{ color: <?php echo esc_html( $theme_accent2 ); ?>; }
.lp-blocks1 .lp-block i[class^=blicon] +i[class^=blicon]::before
											{ color: <?php echo esc_html( $theme_accent2 ); ?>; }
.lp-block-readmore							{ color: <?php echo esc_html( cryout_hexdiff( $theme_sitetext, -80 ) ) ;?>; }
.lp-block-readmore:hover					{ color: <?php echo esc_html( $theme_accent1 ); ?>; }
.lp-text-title 								 { color: <?php echo esc_html( $theme_accent2 ); ?>; }
.lp-text-image + .lp-text-card				 { background-color: <?php echo esc_html( $theme_contentbackground ); ?>; }
.lp-text-image + .lp-text-card::before		 { background-color: <?php echo esc_html( $theme_accent1 ); ?>; }
.lp-box, .lp-boxes-animated .lp-box-content,
.lp-boxes-static .lp-box-content::before	{ background-color: <?php echo esc_html( $theme_contentbackground ); ?>; }
.lp-boxes-static .box-overlay				{ background-color: <?php echo esc_html( $theme_accent1 )?>;
											  background: -webkit-linear-gradient(to right,<?php echo esc_html( $theme_accent1 )?>,<?php echo esc_html( $theme_accent2 ) ?>);
											  background: linear-gradient(to right,<?php echo esc_html( $theme_accent1 )?>,<?php echo esc_html( $theme_accent2 ) ?>);}
.lp-boxes-static .lp-box:nth-child(odd) .box-overlay {
											background-color: <?php echo esc_html( $theme_accent2 )?>;
											background: -webkit-linear-gradient(to right,<?php echo esc_html( $theme_accent2 )?>,<?php echo esc_html( $theme_accent1 ) ?>);
											background: linear-gradient(to right,<?php echo esc_html( $theme_accent2 )?>,<?php echo esc_html( $theme_accent1 ) ?>);}
.lp-box-title 			 					{ color:  <?php echo esc_html( $theme_headingstext ) ?>; }
.lp-box-title:hover 						{ color:  <?php echo esc_html( $theme_accent1 ) ?>; }
.lp-boxes-1 .lp-box .lp-box-image 			{ height: <?php echo intval ( (int) $theme_lpboxheight1 ); ?>px; }
.lp-boxes-animated .box-overlay				{ background-color:  <?php echo esc_html( $theme_accent1 ) ?>; }
.lp-boxes-animated .lp-box:nth-child(odd) .box-overlay
											{ background-color:  <?php echo esc_html( $theme_accent2 ) ?>; }
#cryout_ajax_more_trigger,
.lp-port-readmore		 					{ color: <?php echo esc_html( $theme_accent2 ); ?>; }
<?php
for ($i=1; $i<=8; $i++) { ?>
	.lpbox-rnd<?php echo $i ?> { background-color:  <?php echo esc_html( cryout_hexdiff( $theme_lpboxesbg, 50+5*$i ) ) ?>; }
<?php }
	return apply_filters( 'esotera_custom_styles', preg_replace('/(([\w-]+):\s*?;?\s*?([;}]))/i', '', ob_get_clean() ) );
}
function esotera_editor_styles() {
	$options = cryout_get_option();
	extract($options);

	switch ( $theme_sitelayout ) {
		case '1c':
			$theme_primarysidebar = $theme_secondarysidebar = 0;
			break;
		case '2cSl':
			$theme_secondarysidebar = 0;
			break;
		case '2cSr':
			$theme_primarysidebar = 0;
			break;
		default:
			break;
	}
	$content_body = floor( (int) $theme_sitewidth - ( (int) $theme_primarysidebar + (int) $theme_secondarysidebar ) );
	ob_start();
	if ( function_exists( 'register_block_type' ) && is_admin() ) {
		$scope = '.wp-block';
	} else if ( ! is_admin() ) {
		$scope = '';
	} ?>
/* Standard blocks */
body.mce-content-body, .wp-block { max-width: <?php echo esc_html( $content_body ); ?>px; }
/* Width of "wide" blocks */
.wp-block[data-align="wide"] { max-width: 1080px; }
/* Width of "full-wide" blocks */
.wp-block[data-align="full"] { max-width: none; }
body.mce-content-body, .block-editor .edit-post-visual-editor {
	background-color: <?php echo esc_html( $theme_contentbackground ) ?>	}
body.mce-content-body, .wp-block {
	max-width: <?php echo esc_html( $content_body ); ?>px;
	font-family: <?php echo cryout_font_select( $theme_fgeneral, $theme_fgeneralgoogle ) ?>;
	font-size: <?php echo esc_html( $theme_fgeneralsize ) ?>;
	line-height: <?php echo esc_html( floatval($theme_lineheight) ) ?>;
	color: <?php echo esc_html( $theme_sitetext ); ?>; }
.block-editor .editor-post-title__block .editor-post-title__input {
	color: <?php echo esc_html( $theme_accent2 ) ?>; }
<?php
$font_root = 2.6;
for ( $i = 1; $i <= 6; $i++ ) {
$size = round( ( $font_root - ( 0.27 * $i ) ) * ( preg_replace( "/[^\d]/", "", esc_html( $theme_fheadingssize ) ) / 100), 5 ); ?>
h<?php echo $i ?> { font-size: <?php echo $size ?>em; } <?php
} ?>
%%scope%% h1, %%scope%% h2, %%scope%% h3, %%scope%% h4, %%scope%% h5, %%scope%% h6 {
	font-family: <?php echo cryout_font_select( $theme_fheadings, $theme_fheadingsgoogle ) ?>;
	font-weight: <?php echo esc_html( $theme_fheadingsweight ) ?>;
	color: <?php echo esc_html( $theme_headingstext ) ?>; }
%%scope%% blockquote::before, %%scope%% blockquote::after {
	color: rgba(<?php echo cryout_hex2rgb( esc_html( $theme_sitetext ) ) ?>,0.1); }
%%scope%% a 		{ color: <?php echo esc_html( $theme_accent1 ); ?>; }
%%scope%% a:hover	{ color: <?php echo esc_html( $theme_accent2 ); ?>; }
%%scope%% code		{ background-color: <?php echo esc_html(cryout_hexdiff( $theme_contentbackground, 17 ) ) ?>; }
%%scope%% pre		{ border-color: <?php echo esc_html(cryout_hexdiff( $theme_contentbackground, 17 ) ) ?>; }
%%scope%% select,
%%scope%% input[type],
%%scope%% textarea {
	color: <?php echo esc_html( $theme_sitetext ); ?>;
	background-color: <?php echo esc_html( cryout_hexdiff( $theme_contentbackground, 10 ) ) ?>;
	border-color: <?php echo esc_html( cryout_hexdiff( $theme_contentbackground, 17 ) ) ?>
}
%%scope%% p, %%scope%% ul, %%scope%% ol, %%scope%% dd, %%scope%% pre, %%scope%% hr {
	margin-bottom: <?php echo floatval( $theme_paragraphspace ) ?>em;
}
%%scope%% p { text-indent: <?php echo floatval( $theme_parindent ) ?>em; }
<?php
	return apply_filters( 'esotera_editor_styles', str_replace( '%%scope%%', $scope, ob_get_clean() ) );
}
function esotera_editor_styles_output() {
	header( 'Content-type: text/css' );
	echo esotera_editor_styles();
	exit();
}
function cryout_customize_theme_identification() {
	ob_start();
	?> #customize-theme-controls [id*="cryout-"] h3.accordion-section-title::before { content: "ES"; border: 1px solid #d41d70; color: #d41d70; } <?php
	return ob_get_clean();
} ?>