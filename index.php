<?php get_header();?>
		<div class="container" id="container">
			<div class="row">
				<div class="span8" id="content">
					<?php while ( have_posts() ) : the_post(); ?>
						<h2 id="post-<?php the_ID(); ?>">
							<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">
								<?php the_title(); ?>
							</a>
						</h2>
						<small><?php the_time('F jS, Y') ?> <!-- by <?php the_author() ?> --></small>
						<?php the_content(); ?>
					<?php endwhile; ?>
				</div>
				<div class="clear"></div>
				<div class="span4" id="sidebar">
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
	</div><!-- #wrapper -->
<?php get_footer(); ?>
