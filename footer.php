<?php $vt_general_options = vt_get_option('vt_general_settings'); ?>
	<div id="footer">
		<div id="footer_widget_area" class="container">
			<div class="row">
			<?php if(isset($vt_general_options['social_media_links_enable'])): ?>
				<div id="social-panel-footer" class="footer-section">
				<h3 class="vt_footer_header">Links</h3>
					<ul>
						<?php foreach ($vt_general_options['social_media_links'] as $name => $value): ?>
							<?php if ($value): ?>
								<li class="s"><a href="<?php echo $value ?>" title="<?php echo $value; ?>"><img class="" src="<?php echo get_bloginfo('template_directory'); ?>/images/<?php echo $name; ?>.png" alt="social media link"/></a></li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
			<?php if ( is_active_sidebar( 'sidebar-f' ) ) : ?>
				<?php dynamic_sidebar( 'sidebar-f' ); ?>
			<?php endif; ?>
			</div>
		</div>
		<div id="copyright">
			<span class="vt_footer_font"><?php if (isset($vt_general_options['copyright_line'])) echo $vt_general_options['copyright_line']; ?></span>
		</div>
	</div>
</div>
<div id="storage" data-config='{<?php echo vt_get_page_js_config(); ?>}' ></div>
<?php wp_footer(); ?>
</body>
</html>