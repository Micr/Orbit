<?php get_header();?>
	<?php if (is_front_page()): ?>
		<div class="container mt20" id="container">
			<div class="row">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; ?>
			</div>
		</div>
	<?php else: ?>
		<?php $vt_general_options = vt_get_option('vt_general_settings'); ?>
		<div class="container pt30" id="container">
			<div class="row">
				<?php if ($vt_general_options['page_sidebar_position'] == 'two'): ?>
					<div id="left_sidebar" class="span3 sidebar">
						<?php dynamic_sidebar('left'); ?>
					</div>
				<?php elseif ($vt_general_options['page_sidebar_position'] == 'left'): ?>
					<div id="left_sidebar" class="span4 sidebar">
						<?php dynamic_sidebar('left'); ?>
					</div>
				<?php endif; ?>
				<div class="<?php echo vt_get_content_class(); ?>" id="content">
					<?php while ( have_posts() ) : the_post(); ?>
						<a href="<?php echo vt_get_post_thumbnail_url(); ?>" title="">
							<?php the_post_thumbnail(); ?>
						</a>
						<h2 id="post-<?php the_ID(); ?>">
							<?php the_title(); ?>
						</h2>
						<?php the_content(); ?>
					<?php endwhile; ?>
				</div>
				<?php if ($vt_general_options['page_sidebar_position'] == 'two'): ?>
					<div id="right_sidebar" class="span3 sidebar">
						<?php dynamic_sidebar('right'); ?>
					</div>
				<?php elseif ($vt_general_options['page_sidebar_position'] == 'right'): ?>
					<div id="right_sidebar" class="span4 sidebar">
						<?php dynamic_sidebar('right'); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>
</div><!-- #wrapper -->
<?php get_footer(); ?>