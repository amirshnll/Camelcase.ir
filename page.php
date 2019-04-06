		<?php get_header(); ?>

		<div class="advertisment">
			<span>تبلیغات</span>
			<div class="advertisment_content">
<div class="anetwork">
</div>
<a href="https://my.mihanwebhost.com/aff.php?aff=6375" title="میهن وب هاست"><img src="http://camelcase.ir/wp-content/uploads/mihanwebhost.gif" title="" alt="میهن وب هاست" /></a>
				<!--<a href="#" title="تبلیغات برنامه نویسی"><img src="<?php bloginfo('template_url'); ?>/assets/img/ads728.png" title="تبلیغات برنامه نویسی" alt="تبلیغات برنامه نویسی" /></a>-->
			</div>
		</div>

		<div class="wrapper">
			<div class="posts" id="page_posts">
				<?php if(have_posts()): ?>
				<?php while(have_posts()): the_post(); ?>
				<div class="content" id="cs_margin_top">
					<div class="post_content_single">
						<div class="post_title_single">
							<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><h3><?php the_title(); ?></h3></a>
						</div>
						<div class="post_text">
							<div class="post_image_large">
								<?php if (has_post_thumbnail()) the_post_thumbnail('home-thumb'); ?>
							</div>
							<?php the_content(); ?>
						</div>
					</div>
				</div>
				<?php endwhile; ?>
				<?php endif; ?>
			</div>
			<?php get_sidebar(); ?>
			<div class="clear"></div>
		</div>

		<?php get_footer(); ?>
	</body>
</html>