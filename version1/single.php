		<?php get_header(); ?>

		<div class="advertisment">
			<span>تبلیغات</span>
			<div class="advertisment_content">
<div class="anetwork">
    <script type="text/javascript">
;!( function( w, d ) {
'use strict';
var ad = { user: "1464700847", width: 728, height: 90, id: 'anetwork-' + ~~( Math.random() * 999999  ) },
h = d.head || d.getElementsByTagName( 'head' )[ 0 ],
s = location.protocol + '//static-cdn.anetwork.ir/aw/aw.js';
if ( typeof w.anetworkParams != 'object' )
w.anetworkParams = {};
d.write( '<div id="' + ad.id + '" style="display: inline-block"></div>' );
w.anetworkParams[ ad.id ] = ad;
d.write( '<script type="text/javascript" src="' + s + '" async></scri' + 'pt>' );
})( this, document );</script>
</div>
<a href="https://my.mihanwebhost.com/aff.php?aff=6375" title="میهن وب هاست"><img src="http://camelcase.ir/wp-content/uploads/mihanwebhost.gif" title="" alt="میهن وب هاست" /></a>
				<!--<a href="#" title="تبلیغات برنامه نویسی"><img src="<?php bloginfo('template_url'); ?>/assets/img/ads728.png" title="تبلیغات برنامه نویسی" alt="تبلیغات برنامه نویسی" /></a>-->
			</div>
		</div>

		<div class="wrapper">
			<div class="posts">
				<?php if(have_posts()): ?>
				<?php while(have_posts()): the_post(); ?>
				<div class="content" id="cs_margin_top">
					<div class="post_content_single">
						<div class="post_title_single">
							<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><h3><?php the_title(); ?></h3></a>
						</div>
						<div class="post_detail">
							<p>نویسنده : <?php the_author(); ?></p>
							<p>نظرات : <?php comments_number('0','1','%'); ?> دیدگاه</p>
<?php
setPostViews(get_the_ID());
$number_view_count_en = getPostViews(get_the_ID());
if(!is_numeric($number_view_count_en) || empty($number_view_count_en))
{
$view_count_fa ="۰";
}
else
{
$en = array("0","1","2","3","4","5","6","7","8","9");
$fa = array("۰","۱","۲","۳","۴","۵","۶","۷","۸","۹");
$view_count_fa = str_replace($en, $fa, $number_view_count_en);
}
?>
							<p>بازدید : <?php echo $view_count_fa; ?> بازدید</p>
							<p>تاریخ : <?php the_time('d F Y'); ?></p>
						</div>

						<!-- TAblighatBalaiePost -->

						<div class="post_text">
							<div class="post_image_large">
								<?php if (has_post_thumbnail()) the_post_thumbnail('home-thumb'); ?>
							</div>
							<?php the_content(); ?>
						</div>
						
						<!-- TAblighatPaiinePost -->

						<div class="tags">
							<span id="fontsize15">موضوع : </span><span class="cs_justify"><?php the_category('&nbsp;&nbsp;') ?></span>
							<p></p>
							<span id="fontsize15">برچسب ها : </span><div class="cs_justify"><?php the_tags('<h4>', '</h4><h4>', '</h4>'); ?></div>
						</div>
						<div class="coments">
							<?php comments_template(); ?>
						</div>
					</div>
				</div>
				<?php endwhile; ?>
				<?php endif; ?>

<p><strong>مطالب زیر را از دست ندهید:</strong></p>
<?php
$tags = wp_get_post_tags($post->ID);
if ($tags) {
  $first_tag = $tags[0]->term_id;
  $args=array(
    'tag__in' => array($first_tag),
    'post__not_in' => array($post->ID),
    'showposts'=>2,
    'caller_get_posts'=>1
   );
  
  $rel_posts = new WP_Query($args);
  if( $rel_posts->have_posts() ) {
    while ($rel_posts->have_posts()) : $rel_posts->the_post(); ?>
  
<div class="rel_posts">
<div class="rel_thumb"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail(array(130,130)); ?></a></div>
<div class="rel_link"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></div>
<div class="clear"></div>
</div>
<?php
endwhile;
}
}
?>

			</div>
			<?php get_sidebar(); ?>
			<div class="clear"></div>
		</div>

		<?php get_footer(); ?>
	</body>
</html>