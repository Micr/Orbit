<?php
get_header();?>

	<section id="container" class="container mtb40" >
		<div class="row" >
			<div id="content" class="span8">

				<?php if ( have_posts() ) : ?>

					<?php
						the_post();
					?>

					<header class="archive-header">
						<h1 class="archive-title"><?php printf( __( 'Author Archives: %s', 'vortex' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' ); ?></h1>
					</header>

					<?php
						rewind_posts();
					?>

					<?php vt_content_navigation(); ?>

						<div class="author_avatar">
							<?php echo get_avatar( get_the_author_meta( 'user_email' )); ?>
						</div>
						<div class="author_description">
							<h4><?php printf( 'About %s', get_the_author() ); ?></h4>
							<p><?php the_author_meta( 'description' ); ?></p>
						</div>
						<?php while ( have_posts() ) : the_post(); ?>
							<article class="blog-post-wrapper" >
								<header class="post-header">
									<a class="" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'vortex' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
										<?php the_post_thumbnail('post-size'); ?>
									</a>
									<h1 class="post-title">
										<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'vortex' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
									</h1>
								</header>
								<small><?php the_time('F jS, Y') ?> <!-- by <?php the_author() ?> --></small>
								<div class="blog-post">
									<div class="post-content">
										<?php the_content( __( 'Continue reading <span class="">&rarr;</span>', 'vortex' ) ); ?>
										<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'vortex' ), 'after' => '</div>' ) ); ?>
									</div>
								</div>
								<footer class="meta_info">
									<div><?php the_tags(); ?></div>
									<div>Categories: <?php the_category(', '); ?></div>
									<?php edit_post_link( 'Edit', '<span class="edit_link">', '</span>' );?>
								</footer>
							</article>
						<?php endwhile; ?>

					<?php vt_content_navigation(); ?>

				<?php else : ?>
					<div></div>
				<?php endif; ?>

			</div>
			<div id="sidebar" class="span4 sidebar">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</section>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>