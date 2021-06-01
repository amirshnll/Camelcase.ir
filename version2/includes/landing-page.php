<?php
if ( ! function_exists('esotera_lpslider' ) ):
function esotera_lpslider() {
	$options = cryout_get_option( array( 'theme_lpslider', 'theme_lpsliderimage', 'theme_lpslidertitle', 'theme_lpslidertext', 'theme_lpslidershortcode', 'theme_lpsliderserious', 'theme_lpslidercta1text', 'theme_lpslidercta1link', 'theme_lpslidercta2text', 'theme_lpslidercta2link'  ) );
?>
<section class="lp-slider">
<?php
if ( $options['theme_lpslider'] )
	switch ( $options['theme_lpslider'] ):
		case 1:
			if ( is_string( $options['theme_lpsliderimage'] ) ) {
				$image = $options['theme_lpsliderimage'];
			}
			else {
				list( $image, ) = wp_get_attachment_image_src( $options['theme_lpsliderimage'], 'full' );
			}
			esotera_lpslider_output( array(
				'image' => $image,
				'title' => $options['theme_lpslidertitle'],
				'content' => $options['theme_lpslidertext'],
				'lpslidercta1text' => $options['theme_lpslidercta1text'],
				'lpslidercta1link' => $options['theme_lpslidercta1link'],
				'lpslidercta2text' => $options['theme_lpslidercta2text'],
				'lpslidercta2link' => $options['theme_lpslidercta2link'],
			) );
		break;
		case 2:
			?> <div class="lp-dynamic-slider"> <?php
			echo do_shortcode( $options['theme_lpslidershortcode'] );
			?> </div><?php
		break;
		case 3:
		break;
		case 4:
			?> <div class="lp-dynamic-slider"> <?php
				if ( ! empty( $options['theme_lpsliderserious'] ) ) {
					echo do_shortcode( '[serious-slider id="' . $options['theme_lpsliderserious'] . '"]' );
				}
			?> </div><?php
		break;
		default:
		break;
	endswitch; ?>
	</section>
	<?php
}
endif;
if ( ! function_exists( 'esotera_lpslider_output' ) ):
function esotera_lpslider_output( $data ){
extract($data);
$anim = cryout_get_option( 'theme_lpslidertitle_anim' ) ? 'animated-title' : '';
if ( empty( $image ) && empty( $title ) && empty( $content ) && empty( $lpslidercta1text ) && empty( $lpslidercta2text ) ) return; ?>
	<div class="lp-staticslider <?php echo $anim; ?>">
		<?php if ( ! empty( $image ) ) { ?>
			<img class="lp-staticslider-image" alt="<?php echo esc_attr( $title ) ?>" src="<?php echo esc_url( $image ); ?>">
		<?php } ?>
		<div class="staticslider-caption">
			<div class="staticslider-caption-inside">
				<?php if ( ! empty( $title ) ) { ?> <h2 class="staticslider-caption-title"><span><?php echo do_shortcode( wp_kses_post( $title ) ) ?></span></h2><?php } ?>
				<?php if ( ! empty( $title ) && ! empty( $content ) )	{ ?><span class="staticslider-sep"></span><?php } ?>
				<?php if ( ! empty( $content ) ) { ?> <div class="staticslider-caption-text"><span><?php echo do_shortcode( wp_kses_post( $content ) ) ?></span></div><?php } ?>
				<div class="staticslider-caption-buttons">
					<?php if ( ! empty( $lpslidercta1text ) ) { echo '<a class="staticslider-button" href="' . esc_url( $lpslidercta1link ) . '">' . esc_html( $lpslidercta1text ) . '</a>'; } ?>
					<?php if ( ! empty( $lpslidercta2text ) ) { echo '<a class="staticslider-button" href="' . esc_url( $lpslidercta2link ) . '">' . esc_html( $lpslidercta2text ) . '</a>'; } ?>
				</div>
			</div>
		</div>
	</div>
<?php
}
endif;
if ( ! function_exists( 'esotera_lpblocks' ) ):
function esotera_lpblocks( $sid = 1 ) {
	$maintitle = cryout_get_option( 'theme_lpblockmaintitle'.$sid );
	$maindesc = cryout_get_option( 'theme_lpblockmaindesc'.$sid );
	$pageids = cryout_get_option( apply_filters('esotera_blocks_ids', array( 'theme_lpblockone'.$sid, 'theme_lpblocktwo'.$sid, 'theme_lpblockthree'.$sid, 'theme_lpblockfour'.$sid), $sid ) );
	$icon = cryout_get_option( apply_filters('esotera_blocks_icons', array( 'theme_lpblockoneicon'.$sid, 'theme_lpblocktwoicon'.$sid, 'theme_lpblockthreeicon'.$sid, 'theme_lpblockfouricon'.$sid ), $sid ) );
	$blockscontent = cryout_get_option( 'theme_lpblockscontent'.$sid );
	$blocksclick = cryout_get_option( 'theme_lpblocksclick'.$sid );
	$blocksreadmore = cryout_get_option( 'theme_lpblocksreadmore'.$sid );
	$count = 1;
	$pagecount = count( array_filter( $pageids, function ($v) { return $v > 0; } ) );
	if ( empty( $pagecount ) ) return;
	if ( -1 == $blockscontent ) return;
	?>
	<section id="lp-blocks<?php echo $sid ?>" class="lp-blocks lp-blocks<?php echo $sid ?> lp-blocks-rows-<?php echo apply_filters('esotera_blocks_perrow', $pagecount, $sid) ?>">
		<?php if(  ! empty( $maintitle ) || ! empty( $maindesc ) ) { ?>
			<header class="lp-section-header">
				<?php if( ! empty( $maintitle ) ) { ?><h2 class="lp-section-title"> <?php echo do_shortcode( wp_kses_post( $maintitle ) ) ?></h2><?php } ?>
				<?php if( ! empty( $maindesc ) ) { ?><div class="lp-section-desc"> <?php echo do_shortcode( wp_kses_post( $maindesc ) ) ?></div><?php } ?>
			</header>
		<?php } ?>
		<div class="lp-blocks-inside">
			<?php foreach ( $pageids as $key => $pageid ) {
				$pageid = cryout_localize_id( $pageid );
				if ( intval( $pageid ) > 0 ) {
					$page = get_post( $pageid );

					switch ( $blockscontent ) {
						case '0': $text = ''; break;
						case '2': $text = apply_filters( 'the_content', get_post_field( 'post_content', $pageid ) ); break;
						case '1': default: if (has_excerpt( $pageid )) $text = get_the_excerpt( $pageid ); else $text = esotera_custom_excerpt( apply_filters( 'the_content', get_post_field( 'post_content', $pageid ) ) ); break;
					};
					$iconid = preg_replace('/(\d)$/','icon$1', $key);
					$data[$count] = array(
						'title' => apply_filters('esotera_block_title', get_the_title( $pageid ), $pageid ),
						'text'	=> $text,
						'icon'	=> ( ( $icon[$iconid] != 'no-icon' ) ? $icon[$iconid] : '' ),
						'link'	=> apply_filters( 'esotera_block_url', get_permalink( $pageid ), $pageid ),
						'target' => apply_filters( 'esotera_block_target', '', $pageid ),
						'click'	=> $blocksclick,
						'id' 	=> $count,
						'readmore' => $blocksreadmore,
					);
					esotera_lpblock_output( $data[$count] );
					$count++;
				}
			} ?>
		</div>
	</section>
<?php
wp_reset_postdata();
}
endif;
if ( ! function_exists( 'esotera_lpblock_output' ) ):
function esotera_lpblock_output( $data ) { ?>
	<?php extract($data) ?>
			<div class="lp-block block<?php echo absint( $id ); ?>">
				<?php if ( $click ) { ?><a href="<?php echo esc_url( $link ); ?>" aria-label="<?php echo esc_attr( $title ); ?>"<?php echo $target ?>><?php } ?>
					<?php if ( ! empty ( $icon ) )	{ ?>
                        <div class="lp-block-icon">
                            <i class="blicon-<?php echo esc_attr( $icon ); ?>"></i>
                            <i class="blicon-<?php echo esc_attr( $icon ); ?>"></i>
                        </div>
                     <?php } ?>
				<?php if ( $click ) { ?></a> <?php } ?>
					<div class="lp-block-content">
						<?php if ( ! empty ( $title ) ) { ?><h4 class="lp-block-title"><?php echo do_shortcode( $title ) ?></h4><?php } ?>
						<?php if ( ! empty ( $text ) ) { ?><div class="lp-block-text"><?php echo do_shortcode( $text ) ?></div><?php } ?>
					</div>
                <?php if ( ! empty ( $readmore ) ) { ?><div class="lp-block-padder"></div><a class="lp-block-readmore" href="<?php echo esc_url( $link ); ?>" <?php echo esc_attr( $target ); ?>> <?php echo do_shortcode( wp_kses_post( $readmore ) ); ?> <em class="screen-reader-text">"<?php echo esc_attr( $title ) ?>"</em> </a><?php } ?>
			</div>
	<?php
}
endif;
if ( ! function_exists( 'esotera_lpboxes' ) ):
function esotera_lpboxes( $sid = 1 ) {
	$options = cryout_get_option(
				array(
					 'theme_lpboxmaintitle' . $sid,
					 'theme_lpboxmaindesc' . $sid,
					 'theme_lpboxcat' . $sid,
					 'theme_lpboxrow' . $sid,
					 'theme_lpboxcount' . $sid,
					 'theme_lpboxlayout' . $sid,
					 'theme_lpboxmargins' . $sid,
					 'theme_lpboxanimation' . $sid,
					 'theme_lpboxreadmore' . $sid,
					 'theme_lpboxlength' . $sid,
				 )
			 );
	if ( ( $options['theme_lpboxcount' . $sid] <= 0 ) || ( $options['theme_lpboxcat' . $sid] == '-1' ) ) return;
 	$box_counter = 1;
	$animated_class = "";
	if ( $options['theme_lpboxanimation' . $sid] == 1 ) $animated_class = 'lp-boxes-animated';
	if ( $options['theme_lpboxanimation' . $sid] == 2 ) $animated_class = 'lp-boxes-static';
	if ( $options['theme_lpboxanimation' . $sid] == 3 ) $animated_class = 'lp-boxes-animated lp-boxes-animated2';
	if ( $options['theme_lpboxanimation' . $sid] == 4 ) $animated_class = 'lp-boxes-static lp-boxes-static2';
	$custom_query = new WP_query();
    if ( ! empty( $options['theme_lpboxcat' . $sid] ) ) $cat = $options['theme_lpboxcat' . $sid]; else $cat = '';
	$args = apply_filters( 'esotera_boxes_query_args', array(
		'showposts' => $options['theme_lpboxcount' . $sid],
		'cat' => cryout_localize_cat( $cat ),
		'ignore_sticky_posts' => 1,
		'lang' => cryout_localize_code()
	), $options['theme_lpboxcat' . $sid], $sid );
    $custom_query->query( $args );
    if ( $custom_query->have_posts() ) : ?>
		<section id="lp-boxes-<?php echo absint( $sid ) ?>" class="lp-boxes lp-boxes-<?php echo absint( $sid ) ?> <?php  echo esc_attr( $animated_class ) ?> lp-boxes-rows-<?php echo absint( $options['theme_lpboxrow' . $sid] ); ?>">
			<?php if( $options['theme_lpboxmaintitle' . $sid] || $options['theme_lpboxmaindesc' . $sid] ) { ?>
				<header class="lp-section-header">
					<?php if ( ! empty( $options['theme_lpboxmaintitle' . $sid] ) ) { ?> <h2 class="lp-section-title"> <?php echo do_shortcode( wp_kses_post( $options['theme_lpboxmaintitle' . $sid] ) ) ?></h2><?php } ?>
					<?php if ( ! empty( $options['theme_lpboxmaindesc' . $sid] ) ) { ?><div class="lp-section-desc"> <?php echo do_shortcode( wp_kses_post( $options['theme_lpboxmaindesc' . $sid] ) ) ?></div><?php } ?>
				</header>
			<?php } ?>
			<div class="<?php if ( $options['theme_lpboxlayout' . $sid] == 2 ) { echo 'lp-boxes-inside'; } else { echo 'lp-boxes-outside'; }?>
						<?php if ( $options['theme_lpboxmargins' . $sid] == 2 ) { echo 'lp-boxes-margins'; }?>
						<?php if ( $options['theme_lpboxmargins' . $sid] == 1 ) { echo 'lp-boxes-padding'; }?>">
    		<?php while ( $custom_query->have_posts() ) :
		            $custom_query->the_post();
					if ( cryout_has_manual_excerpt( $custom_query->post ) ) {
						$excerpt = get_the_excerpt();
					} elseif ( has_excerpt() ) {
						$excerpt = esotera_custom_excerpt( get_the_excerpt(), $options['theme_lpboxlength' . $sid] );
					} else {
						$excerpt = esotera_custom_excerpt( get_the_content(), $options['theme_lpboxlength' . $sid] );
					};
		            $box = array();
		            $box['colno'] = $box_counter++;
		            $box['counter'] = $options['theme_lpboxcount' . $sid];
		            $box['title'] = apply_filters('esotera_box_title', get_the_title(), get_the_ID() );
		            $box['content'] = $excerpt;
		            list( $box['image'], ) = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'esotera-lpbox-' . $sid );
					$box['link'] = apply_filters( 'esotera_box_url', get_permalink(), get_the_ID() );
					$box['readmore'] = do_shortcode( wp_kses_post( $options['theme_lpboxreadmore' . $sid] ) );
					$box['target'] = apply_filters( 'esotera_box_target', '', get_the_ID() );

					$box['image'] = apply_filters('esotera_preview_img_src', $box['image']);

            		esotera_lpbox_output( $box );
        		endwhile; ?>
			</div>
		</section>
<?php endif;
	wp_reset_postdata();
}
endif;
if ( ! function_exists( 'esotera_lpbox_output' ) ):
function esotera_lpbox_output( $data ) {
	$randomness = array ( 6, 8, 1, 5, 2, 7, 3, 4 );
	extract($data); ?>
			<div class="lp-box box<?php echo absint( $colno ); ?> ">
					<div class="lp-box-image lpbox-rnd<?php echo $randomness[$colno%8]; ?>">
                        <a class="lp-box-imagelink" <?php if( ! empty( $link ) ) { ?> href="<?php echo esc_url( $link ); ?>" <?php echo esc_attr( $target ); } ?>><span class="screen-reader-text"> <?php echo esc_attr( $title ); ?></span>  </a>
						<?php if( ! empty( $image ) ) { ?><img alt="<?php echo esc_attr( $title ) ?>" src="<?php echo esc_url( $image ) ?>" /> <?php } ?>
                        <span class="box-overlay"></span>
					</div>
					<div class="lp-box-content">
						<div class="lp-box-text">
                            <?php if ( ! empty( $title ) ) { ?><h5 class="lp-box-title">
                                <?php if ( !empty( $readmore ) && !empty( $link ) ) { ?> <a href="<?php echo esc_url( $link ); ?>" <?php echo esc_attr( $target ); ?>><?php } ?>
                                    <?php echo do_shortcode( $title ); ?>
                                <?php if ( !empty( $readmore ) && !empty( $link ) ) { ?> </a> <?php } ?>
                            </h5><?php } ?>
							<?php if ( ! empty( $content ) ) { ?>
								<div class="lp-box-text-inside"> <?php echo do_shortcode( $content ) ?> </div>
							<?php } ?>
    						<?php if( ! empty( $readmore ) ) { ?>
    							<a class="lp-box-readmore" href="<?php if( ! empty( $link ) ) { echo esc_url( $link ); } ?>" <?php echo esc_attr( $target ); ?>><span> <?php echo do_shortcode( wp_kses_post( $readmore ) ) ?></span> <em class="screen-reader-text">"<?php echo esc_attr( $title ) ?>"</em> </a>
    						<?php } ?>
                        </div>
					</div>
			</div>
	<?php
}
endif;
if ( ! function_exists( 'esotera_lptext' ) ):
function esotera_lptext( $what = 'one' ) {
	$pageid = cryout_get_option( 'theme_lptext' . $what );
	$pageid = cryout_localize_id( $pageid );
	if ( intval( $pageid ) > 0 ) {
		$page = get_post( $pageid );
		$data = array(
			'title' => apply_filters( 'esotera_text_title', get_the_title( $pageid ), $pageid ),
			'text'	=> apply_filters( 'the_content', get_post_field( 'post_content', $pageid ) ),
			'class' => apply_filters( 'esotera_text_class', '', $pageid ),
			'id' 	=> $what,
		);
		list( $data['image'], ) = wp_get_attachment_image_src( get_post_thumbnail_id( $pageid ), 'full' );
		esotera_lptext_output( $data );
	}
}
endif;
if ( ! function_exists( 'esotera_lptext_output' ) ):
function esotera_lptext_output( $data ){ ?>
	<section class="lp-text <?php echo ( ! empty( $data['image'] ) ) ? ' lp-text-hasimage ': '' ?><?php echo esc_attr( $data['class'] ); ?>" id="lp-text-<?php echo esc_attr( $data['id'] ); ?>"<?php if( ! empty( $data['image'] ) ) { ?> style="background-image: url( <?php echo esc_url( $data['image'] ); ?>);" <?php } ?> >
        <div class="lp-text-inside">

    		<div class="lp-text-card">
    			<?php if( ! empty( $data['title'] ) ) { ?><h3 class="lp-text-title"><?php echo do_shortcode( $data['title'] ) ?></h3><?php } ?>
    			<?php if( ! empty( $data['text'] ) ) { ?><div class="lp-text-content"><?php echo do_shortcode( $data['text'] ) ?></div><?php } ?>
    		</div>
        </div>
	</section><!-- .lp-text-<?php echo esc_attr( $data['id'] ); ?> -->
<?php
}
endif;
if ( ! function_exists( 'esotera_lpindex' ) ):
function esotera_lpindex() {
	$theme_lpposts = cryout_get_option('theme_lpposts');
	switch ($theme_lpposts) {
		case 2:
			if ( have_posts() ) :
					?><section id="lp-page"> <div class="lp-page-inside"><?php
					get_template_part( 'content/content', 'page' );
					?></div></section><?php
			endif;
		break;
		case 1:
			if ( get_query_var('paged') ) $paged = get_query_var('paged');
			elseif ( get_query_var('page') ) $paged = get_query_var('page');
			else $paged = 1;
			$custom_query = new WP_query( array('posts_per_page'=>5,'paged'=>$paged) );

			if ( $custom_query->have_posts() ) :  ?>
				<section id="lp-posts"> <div class="lp-posts-inside">
				<header class="lp-section-header">
				    <h2 class="lp-section-title">مجله آموزشی</h2></h2>
				<div class="lp-section-desc">جدیدترین محتوای سایت ما را با موضوعات برنامه نویسی، طراحی وب، هوش مصنوعی، بانک اطلاعاتی، ساختمان داده و الگوریتم، پروژه دانشجویی در این بخش مطالعه کنید و لذت ببرید.</div>
				</header>
				<p>&nbsp;</p>
				<div id="content-masonry" class="content-masonry" <?php cryout_schema_microdata( 'blog' ); ?>>
				<?php
					while ( $custom_query->have_posts() ) : $custom_query->the_post();
						get_template_part( 'content/content', get_post_format() );
					endwhile; ?>
				</div>
				</div></section>
				<?php esotera_pagination();
				wp_reset_postdata();
			else :
			endif;
		break;
		case 0:
		default: break;
	}
}
endif; ?>