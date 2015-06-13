<?php get_header(); ?>
	<?php if (is_home()): ?>
	<?php $vt_blog_options = vt_get_option('vt_blog_settings');$vt_general_options = vt_get_option('vt_general_settings');$vt_blog_4col = $vt_blog_options['blog_columns'] == '4'; ?>
		<div class="container mtb40" id="container">
			<div class="row" >
				<?php if (in_array($vt_general_options['main_sidebar_position'], array('left','two'))):?>
					<?php if ($vt_general_options['main_sidebar_position'] == 'two' || in_array($vt_blog_options['blog_columns'], array('3','4'))): ?>
						<div id="left_sidebar" class="span3 sidebar">
							<?php dynamic_sidebar('left'); ?>
						</div>
					<?php else: ?>
						<div id="left_sidebar" class="span4 sidebar">
							<?php dynamic_sidebar('left'); ?>
						</div>
					<?php endif; ?>
				<?php endif; ?>
				<div class="<?php echo vt_get_content_class(); ?>" id="content">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php echo vt_if_grid_row_open(); ?>
						<article class="blog-post-wrapper <?php echo vt_get_column_class(); ?>" >
							<?php if ( is_sticky() && ! is_paged() ) : ?>
							<div class="featured-post">
								<?php _e( 'Featured post', 'vortex' ); ?> 
							</div>
							<?php endif; ?>
							<header class="post-header">
								<div class="post-image">
									<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'vortex' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
										<?php the_post_thumbnail(vt_get_blog_thumbnail_size()); ?>
									</a>
								</div>
								<h1 class="post-title ">
									<a class="" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'vortex' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
								</h1>
							</header>
							<small><?php the_time('F jS, Y') ?> <!-- by <?php the_author() ?> --></small>
							<div class="blog-post">
									<div class="post-content">
										<?php the_excerpt(); ?>
										<?php wp_link_pages( array( 'before' => '<div class="page-links ">' . __( 'Pages:', 'vortex' ), 'after' => '</div>' ) ); ?>
									</div>
							</div>
							<footer class="meta_info">
								<div>
									<?php the_tags(); ?>
								</div>
								<div>Categories: <?php $vt_categories = get_the_category(); ?>
									<?php $output = array();foreach ($vt_categories as $category): ?>
										<?php $output[]= '<a class="" href="'.get_category_link($category->term_id ).'" title="' . esc_attr( $category->name ) . '">'.$category->cat_name.'</a>'; ?>
									<?php endforeach; ?>
									<?php echo implode(', ', $output); ?>
								</div>
								<div><p>Written by <a class="" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) );?>"><?php the_author(); ?></a></p></div>
								<?php edit_post_link( 'Edit', '<span class="edit_link vt_globa_text">', '</span>' );?>
							</footer>
						</article>
						<?php echo vt_if_grid_row_close(); ?>
					<?php endwhile; ?>
					<?php vt_content_navigation(); ?>
				</div><!--# content -->
				<?php if (in_array($vt_general_options['main_sidebar_position'], array('right','two'))):?>
					<?php if ($vt_general_options['main_sidebar_position'] == 'two' || in_array($vt_blog_options['blog_columns'], array('3','4'))): ?>
						<div id="right_sidebar" class="span3 sidebar">
							<?php dynamic_sidebar('right'); ?>
						</div>
					<?php else: ?>
						<div id="right_sidebar" class="span4 sidebar">
							<?php dynamic_sidebar('right'); ?>
						</div>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
	<?php else: ?>
		<div class="container mt20" id="container">
			<?php if (is_active_sidebar('sidebar-fpl') || is_active_sidebar('sidebar-fpr')): ?>
				<div class="row">
					<?php if (is_active_sidebar('sidebar-fpl') && is_active_sidebar('sidebar-fpr')): ?>
						<div id="left_sidebar" class="span3 sidebar">
							<?php dynamic_sidebar('sidebar-fpl'); ?>
						</div>
					<?php elseif (is_active_sidebar('sidebar-fpl')): ?>
						<div id="left_sidebar" class="span4 sidebar">
							<?php dynamic_sidebar('sidebar-fpl'); ?>
						</div>
					<?php endif; ?>
					<div class="<?php if (is_active_sidebar('sidebar-fpl') xor is_active_sidebar('sidebar-fpr')) {echo 'span8';} else {echo 'span6';} ?>">
						<?php while ( have_posts() ) : the_post(); ?>
							<?php the_content(); ?>
						<?php endwhile; ?>
					</div>
					<?php if (is_active_sidebar('sidebar-fpl') && is_active_sidebar('sidebar-fpr')): ?>
						<div id="right_sidebar" class="span3 sidebar">
							<?php dynamic_sidebar('sidebar-fpr'); ?>
						</div>
					<?php elseif (is_active_sidebar('sidebar-fpr')): ?>
						<div id="right_sidebar" class="span4 sidebar">
							<?php dynamic_sidebar('sidebar-fpr'); ?>
						</div>
					<?php endif; ?>
				</div>
			<?php else: ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</div><!-- #wrapper -->
<?php get_footer(); ?>