<?php

get_header(); ?>

		<div id="container" class="container">

			<article >
				<header class="post-header">
					<h1 class="post-title"><?php echo 'The content you are looking for is not available.'; ?></h1>
				</header>

				<div class="post-content">
					<p><?php _e( 'You can try using search to get better results.', 'vortex' ); ?></p>
					<?php get_search_form(); ?>
				</div>
			</article>
			<div id="sidebar" class="">
				<?php dynamic_sidebar('sidebar-sphs'); ?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>