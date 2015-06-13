<?php
get_header(); ?>
	<section id="container" class="container mtb40">
		<div class="row">
			<div id="content" class="span8">
				<?php if (have_posts()): ?>
				<header class="header">
					<h1 class="header"><?php printf( __( 'You searched for: %s', 'vortex' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</header>
					<?php while ( have_posts() ) : the_post(); ?>
						<article class="blog-post-wrapper" >
							<header class="post-header">
							<?php the_post_thumbnail('post-size'); ?>
								<h1 class="post-title">
									<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'vortex' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
								</h1>
								<?php if ( comments_open() ) : ?>
									<div class="comments-link">
										<?php comments_popup_link( '<span class="vt_global_text">Comment</span>' ); ?>
									</div>
								<?php endif;?>
							</header>
							<div class="post-summary">
								<?php the_excerpt(); ?>
							</div>
							<footer>
								<small><?php the_time('F jS, Y') ?> <!-- by <?php the_author() ?> --></small>
								<div class="author_avatar">
									<?php echo get_avatar( get_the_author_meta( 'user_email' )); ?>
								</div>
								<div class="author_description">
									<h4><?php printf( 'About %s', get_the_author() ); ?></h2>
									<p><?php the_author_meta( 'description' ); ?></p>
									<div class="author_link">
										<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
											<?php printf( 'View all posts by %s <span class="">&rarr;</span>', get_the_author() ); ?>
										</a>
									</div>
								</div>
							</footer>
						</article>
					<?php endwhile; ?>
				<?php else: ?>
				<article>
					<header class="header">
						<h1 class="header mtb40"><?php echo __( 'Nothing found matching your request', 'vortex' ); ?></h1>
					</header>
					<div class="post-content">
						<p class="mtb40"><?php _e( 'Please try searching again using different keywords', 'vortex' ); ?></p>
						<?php get_search_form(); ?>
					</div>
				</article>
				<?php endif; ?>
			</div>
			<div class="sidebar span4">
				<?php dynamic_sidebar('right'); ?>
			</div>
			<?php vt_content_navigation(); ?>
		</div>
			<div class="row">
				<div class="sidebar span12">
					<?php dynamic_sidebar('sidebar-sphs'); ?>
				</div>
			</div>
	</section>
</div>
<?php get_footer(); ?>