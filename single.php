<?php get_header();?>
<?php $blog_settings = vt_get_option('vt_blog_settings'); ?>
		<div class="container mtb40" id="container">
			<div class="row">
				<?php if ($blog_settings['single_post_sidebar_position'] == 'two'): ?>
					<div id="left_sidebar" class="span3 sidebar">
						<?php dynamic_sidebar('left'); ?>
					</div>
				<?php elseif ($blog_settings['single_post_sidebar_position'] == 'left'): ?>
					<div id="left_sidebar" class="span4 sidebar">
						<?php dynamic_sidebar('left'); ?>
					</div>
				<?php endif; ?>
				<div class="<?php echo vt_get_content_class(); ?>" id="content">
					<?php while ( have_posts() ) : the_post(); ?>
						<article class="blog-post-wrapper">
							<header class="post-header">
								<a href="<?php echo vt_get_post_thumbnail_url(); ?>" title="">
									<?php the_post_thumbnail('post-size'); ?>
								</a>
								<h1 id="post-<?php the_ID(); ?>" class="post-title">
									<?php the_title(); ?>
								</h1>
							</header>
								<?php if ( comments_open() ) : ?>
									<div class="comments-link">
										<?php comments_popup_link( '<span>Comment <i class="icon-comment"></i></span>' ); ?>
									</div>
								<?php endif;?>
							<div class="vt-post-date">
								<small ><?php the_time('F jS, Y') ?> <!-- by <?php the_author() ?> --></small>
							</div>
							<div class="blog-post">
								<div class="post-content">
									<?php the_content( __( 'Continue reading <span class="">&rarr;</span>', 'vortex' ) ); ?>
									<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'vortex' ), 'after' => '</div>' ) ); ?>
								</div>
								<div class="author_avatar">
									<?php echo get_avatar( get_the_author_meta( 'user_email' )); ?>
								</div>
								<div class="author_description">
									<h4><?php printf( 'About %s', get_the_author() ); ?></h4>
									<p><?php the_author_meta( 'description' ); ?></p>
									<div class="author_link">
										<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
											<?php printf( 'View all posts by %s <span class="">&rarr;</span>', get_the_author() ); ?>
										</a>
									</div>
								</div>
							</div>
						</article>
						<nav class="navigation" role="navigation">
							<h3 class=""><?php _e( 'Post navigation', 'vortex' ); ?></h3>
							<div class="post-nav-links">
							<?php previous_post_link('%link', __( '<i class="icon-arrow-left"></i> Previous post', 'vortex' ) ); ?>
							<?php next_post_link('%link', __( 'Next post <i class="icon-arrow-right"></i>', 'vortex' ) ); ?>
							</div>
						</nav>
					<?php comments_template( '', true ); ?>
					<?php endwhile; ?>
				</div>
				<?php if ($blog_settings['single_post_sidebar_position'] == 'two'): ?>
					<div id="right_sidebar" class="span3 sidebar">
						<?php dynamic_sidebar('right'); ?>
					</div>
				<?php elseif ($blog_settings['single_post_sidebar_position'] == 'right'): ?>
					<div id="right_sidebar" class="span4 sidebar">
						<?php dynamic_sidebar('right'); ?>
					</div>
				<?php endif; ?>
			</div>
			<div class="row">
				<div id="sidebar" class="span12">
					<?php dynamic_sidebar('sidebar-sphs'); ?>
				</div>
			</div>
		</div>
	</div><!-- #wrapper -->
<?php get_footer(); ?>