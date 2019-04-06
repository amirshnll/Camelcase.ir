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
			<div class="posts">
					<?php if(have_posts()) : ?>
					<?php while(have_posts()) : the_post(); ?>
					<div class="content">
						<div class="post_image">
							<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
								<?php 
									if (has_post_thumbnail())
										the_post_thumbnail('', array( 'alt' => ''.get_the_title(), 'title' => ''.get_the_title().'' ));
									else
									{
										?>
										<img src="<?php bloginfo('template_url'); ?>/assets/img/default.png" title="<?php the_title(); ?>" alt="<?php the_title(); ?>" />
										<?php
									}
								?>
							</a>
						</div>
						<div class="post_content">
							<div class="post_title">
								<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><h3><?php the_title(); ?></h3></a>
							</div>
							<div class="post_excerpt">
								<div class="cs_justify"><?php the_excerpt();?></div>
								<div class="more_key">
									<a href="<?php the_permalink() ?>" title="خواندن <?php the_title(); ?>">خواندن ادامه مطلب ...</a>
								</div>
							</div>
						</div>
					</div>
					<?php endwhile; ?>
					<?php endif; ?>
					<div class="pagenavi">
						<div class="pagen">
						<?php
							echo paginate_links(
								array(
							    'base'		=> str_replace(999, '%#%', get_pagenum_link(999)),
							    'format' 	=> '?paged=%#%',
							    'current' 	=> max(1, get_query_var('paged')),
							    'total' 	=> $wp_query->max_num_pages,
								)
							);
						?>
						</div>
					</div>
			</div>
			<?php get_sidebar(); ?>
			<div class="clear"></div>
		</div>

		<?php get_footer(); ?>
		
	</body>
</html>