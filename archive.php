<?php get_header();?>
<?php $vt_blog_options = vt_get_option('vt_blog_settings'); ?>
<?php $vt_general_options = vt_get_option('vt_general_settings'); ?>
<?php $vt_blog_4col = $vt_blog_options['blog_columns'] == '4'; ?>
		<div class="container mtb40">
			<div class="row">
				<?php if (in_array($vt_general_options['main_sidebar_position'], array('left','two'))):?>
					<?php if ($vt_general_options['main_sidebar_position'] == 'two' || (in_array($vt_blog_options['blog_columns'], array('3','4')) && $wp_query->post_count > 2)): ?>
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
						<div class="blog-post-wrapper <?php echo vt_get_column_class(); ?>" >
							<a class="" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'vortex' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
								<?php the_post_thumbnail(vt_get_blog_thumbnail_size()); ?>
							</a>
							<h2 id="post-<?php the_ID(); ?>">
								<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">
									<?php the_title(); ?>
								</a>
							</h2>
							<small><?php the_time('F jS, Y') ?> <!-- by <?php the_author() ?> --></small>
							<div class="blog-post">
									<div class="post-content">
										<?php the_excerpt();?>
										<?php wp_link_pages( array( 'before' => '<div class="page-links ">' . __( 'Pages:', 'vortex' ), 'after' => '</div>' ) ); ?>
									</div>
							</div>
							<div class="meta_info">
								<div>
									<?php the_tags('<i class="icon-tags"> </i>'); ?>
								</div>
								<div><i class="icon-list"> </i><?php $vt_categories = get_the_category(); ?>
									<?php $output = array();foreach ($vt_categories as $category): ?>
										<?php $output[]= '<a class="" href="'.get_category_link($category->term_id ).'" title="' . esc_attr( $category->name ) . '">'.$category->cat_name.'</a>'; ?>
									<?php endforeach; ?>
									<?php echo implode(', ', $output); ?>
								</div>
								<div><p><i class="icon-user"> </i><a class="" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) );?>"><?php the_author(); ?></a></p></div>
								<?php edit_post_link( 'Edit', '<span class="edit_link vt_globa_text">', '</span>' );?>
							</div>
						</div>
						<?php echo vt_if_grid_row_close(); ?>
					<?php endwhile; ?>
					<?php vt_content_navigation(); ?>
				</div>
				<?php if (in_array($vt_general_options['main_sidebar_position'], array('right','two'))):?>
					<?php if ($vt_general_options['main_sidebar_position'] == 'two' || (in_array($vt_blog_options['blog_columns'], array('3','4')) && $wp_query->post_count > 2)): ?>
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
	</div><!-- #wrapper -->
<?php get_footer(); ?>
