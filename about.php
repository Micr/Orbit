<?php 
/* 
Template Name: About
*/ 
get_header(); ?>
		<div class="container mt20" id="container">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; ?>
		</div>
	</div>
<?php get_footer(); ?>