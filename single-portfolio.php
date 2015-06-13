<?php get_header();?>
		<?php $options = vt_get_option('vt_portfolio_settings'); ?>
		<div class="container pt30">
			<div class="row">
				<?php if ($options['portfolio_sidebar_position'] == 'two'): ?>
					<div id="left_sidebar" class="span3 sidebar">
						<?php dynamic_sidebar('left'); ?>
					</div>
				<?php elseif ($options['portfolio_sidebar_position'] == 'left'): ?>
					<div id="left_sidebar" class="span4 sidebar">
						<?php dynamic_sidebar('left'); ?>
					</div>
				<?php endif; ?>
			<div class="<?php echo vt_get_content_class(); ?>" id="portfolio_item_wrapper">

				<?php while ( have_posts() ) : the_post(); ?>
					<div >
						<a id="portfolio_post_img" href="<?php echo portfolio_thumbnail_url($post->ID); ?>">
							<?php the_post_thumbnail('post-size'); ?>
						</a>
					</div>
					<h2 id="post-<?php the_ID(); ?>">
						<?php the_title(); ?>
					</h2>
					<div class="portfolio-post">
						<?php the_content(); ?>
					</div>
				<?php endwhile; ?>
				<nav class="navigation" role="navigation">
					<h3 class=""><?php _e( 'Post navigation', 'vortex' ); ?></h3>
					<div class="post-nav-links">
					<?php previous_post_link('%link', __( '<i class="icon-arrow-left"></i> Previous post', 'vortex' ) ); ?>
					<?php next_post_link('%link', __( 'Next post <i class="icon-arrow-right"></i>', 'vortex' ) ); ?>
					</div>
				</nav>
			</div>
				<?php if ($options['portfolio_sidebar_position'] == 'two'): ?>
					<div id="right_sidebar" class="span3 sidebar">
						<?php dynamic_sidebar('right'); ?>
					</div>
				<?php elseif ($options['portfolio_sidebar_position'] == 'right'): ?>
					<div id="right_sidebar" class="span4 sidebar">
						<?php dynamic_sidebar('right'); ?>
					</div>
				<?php endif; ?>
			</div>
			<div class="divider-none"></div>
			<?php echo vt_carousel_shortcode(array('title' => 'Latest Projects', 'controls' => 'top'), '', 'portfolio'); ?>
		</div>
	</div><!-- #wrapper -->
<?php get_footer(); ?>