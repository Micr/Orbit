<?php
/*
Template Name: Contact
*/
?>
<?php get_header();?>
	<div class="container">
		<?php while ( have_posts() ) : the_post(); ?>
		<div class="mtb40"><?php the_content(); ?></div>
		<?php if (get_post_meta(get_the_ID(), 'disable_google_map', true) == ''): ?>
			<div class="google_maps" style="height:380px;" data-coordinates='<?php echo '{"latitude":"' . get_post_meta(get_the_ID(), 'latitude', true) . '", "longitude":"' . get_post_meta(get_the_ID(), 'longitude', true) . '", "zoom":' . get_post_meta(get_the_ID(), 'zoom', true) . '}';?>' ></div>
		<?php endif; ?>
		<?php endwhile; ?>
	</div>
	<div class="container">
		<?php echo vt_contact_form_shortcode(); ?>
	</div>
</div>
<?php get_footer();?>