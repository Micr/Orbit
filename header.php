<?php $vt_general_options = vt_get_option('vt_general_settings'); ?>
<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
	<head >
	<title><?php
		if ( is_single() ) { single_post_title(); }       
		elseif ( is_home() || is_front_page() ) { bloginfo('name'); print ' | '; bloginfo('description'); }
		elseif ( is_page() ) { single_post_title(''); }
		elseif ( is_search() ) { bloginfo('name'); print ' | Search results for ' . esc_html($s); }
		elseif ( is_404() ) { bloginfo('name'); print ' | Not Found'; }
		else { bloginfo('name'); wp_title('|'); }
	?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="description" content="<?php bloginfo('description'); ?>" />
	<meta name="keywords" content="" />
	<?php wp_enqueue_script("jquery"); ?>
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	<?php wp_head(); ?>
	<script type="text/javascript" src="<?php bloginfo("template_url"); ?>/js/theme-main.js"></script>
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
</head>

<body <?php body_class(); ?>>
	<div class="clearfix" id="top-panel">
		<div class="container" id="top-panel-wrapper">
			<?php if(isset($vt_general_options['top_panel_links_enable'])): ?>
				<div id="news-wrapper">
				<?php for ($i = 0; $i < count($vt_general_options['top_panel_links']['name']); $i++): ?>
					<?php if (strlen($vt_general_options['top_panel_links']['name'][$i])): ?>
						<span class="news<?php if ($i == 0) echo '-first'?>"><a href="<?php echo $vt_general_options['top_panel_links']['url'][$i]; ?>"><?php echo $vt_general_options['top_panel_links']['name'][$i]; ?></a></span>
					<?php endif; ?>
				<?php endfor; ?>
				</div>
			<?php endif; ?>
			<div id="search-container"><?php get_search_form(true); ?></div>
		</div>
	</div>
	<div id="outer-container">
	<div id="top-wrapper">
		<div id="top-container" class="container">
			<div class="row">
				<div id="header" class="span12">
					<div id="logo">
						<a class="logo" href="<?php echo site_url(); ?>">
							<img class="header-image" src="<?php header_image() ?>" alt="logo" />
						</a>

					</div>
					<?php if(isset($vt_general_options['top_header_links_enable'])): ?>
						<div id="header-links" >
							<?php for ($i = 0; $i < count($vt_general_options['top_header_links']['name']); $i++): ?>
								<?php if (strlen($vt_general_options['top_header_links']['name'][$i])): ?>
									<a href="<?php echo $vt_general_options['top_header_links']['url'][$i]; ?>"><?php echo $vt_general_options['top_header_links']['name'][$i]; ?></a>
								<?php endif; ?>
							<?php endfor; ?>
						</div>
					<?php endif; ?>
					<?php if(isset($vt_general_options['social_media_links_enable'])): ?>
						<div id="social-panel" >
							<ul>
								<?php foreach ($vt_general_options['social_media_links'] as $name => $value): ?>
									<?php if ($value): ?>
										<li class="s"><a href="<?php echo $value ?>" title="<?php echo $value; ?>"><img class="" src="<?php echo get_bloginfo('template_directory'); ?>/images/<?php echo $name; ?>.png" alt="social media link"/></a></li>
									<?php endif; ?>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>
					<?php if(isset($vt_general_options['header_text_rotator']) && isset($vt_general_options['header_text_rotator_fields']['quote'])): ?>
						<ul class="vt_news_feed" >
							<?php for ($i = 0; $i < count($vt_general_options['header_text_rotator_fields']['quote']); $i++): ?>
								<?php if (!empty($vt_general_options['header_text_rotator_fields']['quote'][$i])): ?>
									<li class="vt_news_feed_item">
										<blockquote class="header_text_rotator">
											<p>
												<?php echo $vt_general_options['header_text_rotator_fields']['quote'][$i]; ?>
											</p>
											<small title="<?php echo $vt_general_options['header_text_rotator_fields']['author'][$i]; ?>" >
												<?php echo $vt_general_options['header_text_rotator_fields']['author'][$i]; ?>
											</small>
										</blockquote>
									</li>
								<?php endif; ?>
							<?php endfor; ?>
						</ul>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix" id="menu-wrapper">
		<div class="container" id="nav-menu">
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
		</div>
	</div>
	<div id="core" class="clearfix">
		<?php if (vt_allow_flexslider()): ?>
			<?php echo vt_render_flexslider(); ?>
		<?php else: ?>
			<?php echo vt_render_slider_placeholder();?>
		<?php endif; ?>
		<?php if(is_front_page() && is_active_sidebar('sidebar-c')):?>
			<div class="container">
				<div class="row">
					<div class="core-divider span12"></div>
						<div class="span12">
							<?php dynamic_sidebar('sidebar-c'); ?>
						</div>
					<div class="core-divider span12"></div>
				</div>
			</div>
		<?php endif; ?>
	</div>
	<div id="wrapper">