<?php

include('inc/slider-post-type.php');
include('inc/portfolio-setup.php');
include('inc/theme-settings.php');
include('inc/widgets.php');
include('inc/shortcodes.php');
include('inc/metaboxes.php');

function vt_default_options($setting_name) {
	switch ($setting_name) {
		case 'vt_general_settings':
		$options = array (
			'main_sidebar_position' => 'right',
			'page_sidebar_position' => 'none',
			'site_layout' => 'boxed',
			'top_panel_position' => 'static',
			'header_text_rotator' => 'vortex',
			'enable_flexslider' => 'vortex',
		);
		break;
		case 'vt_portfolio_settings':
		$options = array (
			'port_columns' => 4,
			'portfolio_sidebar_position' => 'right'
		);
		break;
		case 'vt_blog_settings':
		$options = array (
			'blog_columns' => '2',
			'single_post_sidebar_position' => 'right'
		);
		break;
		case 'vt_color_settings':
		$options = array (
			'link_color' => '#00d7ef',
			'tpanel_color' => '#4C4C4C',
			'top_wrapper_color' => '#272727',
			'nmenu_color' => '#00d7ef',
			'footer_color' => '#4C4C4C',
			'fwidget_color' => '#777',
			'transparent_fwidget' => 'vortex',
			'footer_link_color' => '#afafaf',
			'details_color' => '#00d7ef',
			'use_color_scheme' => 'vortex',
			'color_scheme' => '#00d7ef'
		);
		break;
		case 'vt_typo_settings':
		$options = array (
			'header_color' => '#7f7f7f',
			'links_hover_color' => '#262626',
			'slider_placeholder_color' => '#fff',
			'sidebar_widget_color' => '#777',
			'sidebar_widget_header' => '#fff',
			'footer_widget_header' => '#d1d1d1',
			'footer_widget_color' => '#fff',
			'body_font_size' => '13',
			'body_font_size_unit' => 'px',
			'body_line_height' => '1',
			'body_line_height_unit' => 'em',
			'header_line_height' => '1.5',
			'header_line_height_unit' => 'em',
			'h1_font_size' => '24.5',
			'h1_font_size_unit' => 'px',
			'h2_font_size' => '20.5',
			'h2_font_size_unit' => 'px',
			'h3_font_size' => '16.5',
			'h3_font_size_unit' => 'px',
			'h4_font_size' => '12.5',
			'h4_font_size_unit' => 'px',
			'content_area_font_size' => '13',
			'content_area_font_size_unit' => 'px',
			'content_area_line_height' => '1.5',
			'content_area_line_height_unit' => 'em',
			'google_fonts' => 'Muli',
			'custom_google_fonts' => '',
			'own_fonts' => '',
		);
		break;
	}
	return $options;
}

function vt_get_option ($option) {
	global $vt_global_option;
	if (!isset($vt_global_option[$option])) {
		$defaults = vt_default_options($option);
		$check = get_option($option, $defaults);

		if (isset($check['reset_settings'])) $vt_global_option[$option] = $defaults;
		else $vt_global_option[$option] = $check;

		$option = $vt_global_option[$option];
	}
	else {
		$option = $vt_global_option[$option];
	}
	return $option;
}

function vt_style_overrides() {

	$color_settings = vt_get_option('vt_color_settings');
	if (isset($color_settings['use_color_scheme'])) {

		foreach(array('link_color','nmenu_color','details_color') as $index) {
			$color_settings[$index] = $color_settings['color_scheme'];
		}

	}
	$typo_settings = vt_get_option('vt_typo_settings');
	$general_settings = vt_get_option('vt_general_settings');
	if ($typo_settings['own_fonts']) $typo_settings['own_fonts'] .= ',';

	$header_hsv = vt_rgb2hsv(vt_hex_to_rgb_array($color_settings['top_wrapper_color']));

	if (!isset($general_settings['disable_theme_styles'])): ?>
<style type="text/css">
	body {
		font-size: <?php echo $typo_settings['body_font_size'].$typo_settings['body_font_size_unit']; ?>;
		line-height: <?php echo $typo_settings['body_line_height'].$typo_settings['body_line_height_unit']; ?>;
		font-family: <?php echo $typo_settings['own_fonts']; ?> <?php echo urldecode($typo_settings['google_fonts']) . ','; ?> sans-serif;
	}
	input[type="submit"] {
		font-family: <?php echo $typo_settings['own_fonts']; ?> <?php echo urldecode($typo_settings['google_fonts']) . ','; ?> sans-serif;
	}
	<?php if($general_settings['site_layout'] == 'boxed'): ?>
	#outer-container {
		max-width: 980px;
		margin: 20px auto 0;
	}
	<?php endif; ?>	
	<?php if($general_settings['top_panel_position'] == 'fixed'): ?>
	#top-panel {
		position: fixed;
		z-index: 99999;
		top: 0;
	}
		<?php if(is_admin_bar_showing()): ?>
			html {
				margin-top: 68px !important;
			}
		<?php else: ?>
			html {
				margin-top: 40px !important;
			}
		<?php endif; ?>
	<?php endif; ?>
	a, .filter a:hover {
		color: <?php echo $color_settings['link_color']; ?>
	}
	.filter .active a:hover {
		color: #fff;
	}
	#footer a {
		color: <?php echo $color_settings['footer_link_color']; ?>
	}
	#top-panel {
		background-color: <?php echo $color_settings['tpanel_color']; ?>;
	}
	input[type="search"] {
		border: 1px solid <?php echo $color_settings['tpanel_color']; ?>;
	}
	#top-wrapper {
		background-color: <?php echo $color_settings['top_wrapper_color']; ?>;
	}
	#menu-wrapper, .sub-menu {
		background-color: <?php echo $color_settings['nmenu_color']; ?>;
	}
	#slider-placeholder h1 {
		color: <?php echo $typo_settings['slider_placeholder_color']; ?>;
	}
	#footer {
		background-color: <?php echo $color_settings['footer_color']; ?>;
	}
	.vt_global_hover:hover {
		background-color: rgba(255, 255, 255, 1);
		color: <?php echo $color_settings['nmenu_color']; ?>;
		box-shadow: 0px 0px 5px <?php echo $color_settings['nmenu_color']; ?> inset;
	}
	.carousel-img-cover {
		background-color: <?php echo $color_settings['color_scheme']; ?>
	}
	a:hover, .nav-menu a:hover .icon-angle-right {
		color: <?php echo $typo_settings['links_hover_color']; ?>;
	}
	#top-wrapper a:hover {
		color: <?php echo $color_settings['link_color']; ?>;
	}
	.widget a {
		color: <?php echo $typo_settings['sidebar_widget_color']; ?>;
	}
	.sidebar .widget-title,
	#core .widget-title {
		color: <?php echo $typo_settings['sidebar_widget_header']; ?>;
	}
	.footer-section .vt_footer_header, .footer-section .vt_footer_header a {
		color: <?php echo $typo_settings['footer_widget_header']; ?>;
	}
	.footer-section {
		color: <?php echo $typo_settings['footer_widget_color']; ?>
	}
	h1 {
		font-size: <?php echo $typo_settings['h1_font_size'].$typo_settings['h1_font_size_unit']; ?>;
	}
	h2 {
		font-size: <?php echo $typo_settings['h2_font_size'].$typo_settings['h2_font_size_unit']; ?>;
	}
	h3 {
		font-size: <?php echo $typo_settings['h3_font_size'].$typo_settings['h3_font_size_unit']; ?>;
	}
	h4 {
		font-size: <?php echo $typo_settings['h4_font_size'].$typo_settings['h4_font_size_unit']; ?>;
	}
	h1,h2,h3,h4,h5,h6,h1 a,h2 a,h3 a,h4 a,h5 a,h6 a {
		color: <?php echo $typo_settings['header_color']; ?>;
		line-height: <?php echo $typo_settings['header_line_height'].$typo_settings['header_line_height_unit']; ?>;
	}
	#wrapper {
		font-size: <?php echo $typo_settings['content_area_font_size'].$typo_settings['content_area_font_size_unit']; ?>;
		line-height: <?php echo $typo_settings['content_area_line_height'].$typo_settings['content_area_line_height_unit']; ?>;
	}
	.pagination_numbers .page-numbers,
	#portfolio_item_wrapper nav a,
	.post-nav-links > a,
	.filter .active a,
	.drop-circ-inverse,
	.drop-square-inverse,
	.sidebar .widget-title {
		background-color: <?php echo $color_settings['details_color']; ?>;
	}
	.theme_color_color,
	.drop-square,
	.drop-circ,
	.widget a.lp_more,
	.ib_main_icon {
		color: <?php echo $color_settings['details_color'];?>;
	}
	.carousel_wrapper .wp-post-image {
		border-bottom: 5px solid <?php echo $color_settings['details_color']; ?>;
	}
	.drop-square, 
	.drop-square-inverse,
	.drop-circ, 
	.drop-circ-inverse {
		border-color: <?php echo $color_settings['details_color']; ?>;
	}
	input[type="submit"] {
		background-color: <?php echo $color_settings['details_color']; ?>;
	}

	.blog .post-image img {
		border-bottom: 5px solid <?php echo $color_settings['details_color'];?>;
	}

	#top-panel {
		border-top-color: <?php echo $color_settings['details_color'];?>;
	}

	textarea:focus,
	input[type="text"]:focus,
	input[type="password"]:focus,
	input[type="datetime"]:focus,
	input[type="datetime-local"]:focus,
	input[type="date"]:focus,
	input[type="month"]:focus,
	input[type="time"]:focus,
	input[type="week"]:focus,
	input[type="number"]:focus,
	input[type="email"]:focus,
	input[type="url"]:focus,
	input[type="search"]:focus,
	input[type="tel"]:focus,
	input[type="color"]:focus,
	.uneditable-input:focus {
		border-color: rgba(<?php echo vt_hex_to_rgb($color_settings['details_color']); ?>, 0.8);
		outline: 0;
		outline: thin dotted \9;
		-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(<?php echo vt_hex_to_rgb($color_settings['details_color']); ?>, 0.6);
		-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(<?php echo vt_hex_to_rgb($color_settings['details_color']); ?>, 0.6);
		box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(<?php echo vt_hex_to_rgb($color_settings['details_color']); ?>, 0.6);
	}
	<?php if ($header_hsv['v'] > 50): ?>
		.header_text_rotator p {
			color: #555;
		}
	<?php else: ?>
		.header_text_rotator p {
			color: #fff;
		}
	<?php endif; ?>
</style>
	<?php endif;
}
add_action( 'wp_head', 'vt_style_overrides' );

function vt_replacer ($input) {
	return preg_replace('/<br[^>]*>/', '', $input);
}

function vortex_theme_setup () {
	global $wp_version;
	if ( version_compare( $wp_version, '3.0', '>=' ) ) :
		add_theme_support( 'automatic-feed-links' ); 
	else :
		automatic_feed_links();
	endif;

	if ( version_compare( $wp_version, '3.4', '>=' ) ) :
		$header_args = array(
			'default-image'          => get_template_directory_uri() . '/images/hplaceholder.png',
		);
		add_theme_support( 'custom-header', $header_args );
	else :
		add_custom_image_header();
	endif;

	add_theme_support('custom-header', $header_args);

	add_theme_support('custom-background');
	add_theme_support( 'post-thumbnails' );  
	add_image_size( 'post-size', 720, 540, true );
	add_image_size( 'port-2-col', 460, 345, true );
	add_image_size( 'port-3-col', 300, 225, true );
	add_image_size( 'lp_shortcode', 220, 165, true );
	add_image_size( 'lp_widget', 50, 50, true );
}
add_action( 'after_setup_theme', 'vortex_theme_setup' );



function vortex_admin_scripts_styles () {

	global $wp_version;

	wp_register_style( 'googleFonts', 'http://fonts.googleapis.com/css?family=Merriweather+Sans');  
	wp_enqueue_style( 'googleFonts' );

	wp_register_script( 'admorbit', get_template_directory_uri() . '/js/adm_orbit.js' ); 
	wp_enqueue_script( 'admorbit' );

	wp_register_style( 'vt-jquery-ui', get_template_directory_uri() . '/css/jquery-ui/adm.jquery-ui-1.10.1.custom.min.css' );  
	wp_enqueue_style( 'vt-jquery-ui' );

	if (isset($_REQUEST['page']) && $_REQUEST['page'] == 'theme_settings' ||
		get_post_type() == 'flexslider') {

		wp_register_script( 'admorbit', get_template_directory_uri() . '/js/adm_orbit.js' ); 
		wp_enqueue_script( 'admorbit' );

		wp_register_style( 'vt-admin-style', get_template_directory_uri() . '/css/admin-style.css' );  
		wp_enqueue_style( 'vt-admin-style' );
	}

	if ( 3.5 <= $wp_version ){
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
	}
	else {
		wp_enqueue_style( 'farbtastic' );
		wp_enqueue_script( 'farbtastic' );
	}
}

function vortex_scripts_styles() {

	$options = vt_get_option('vt_typo_settings');
	$general_options = vt_get_option('vt_general_settings');

	wp_register_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.custom.32766.js' );
	wp_enqueue_script( 'modernizr' );
	
	wp_register_script( 'css3media', get_template_directory_uri() . '/js/respond.js' );
	wp_enqueue_script( 'css3media' );

	if (is_page_template('contact.php') && isset($general_options['google_api_key'])) {
		wp_register_script( 'googlemaps', "http://maps.googleapis.com/maps/api/js?key=" . $general_options['google_api_key'] . "&sensor=false" );
		wp_enqueue_script('googlemaps');
	}

	wp_register_script( 'quicksand', get_template_directory_uri() . '/js/jquery.quicksand.js', 'jquery' );
	wp_enqueue_script( 'quicksand' );

	wp_register_script( 'jqeasing', get_template_directory_uri() . '/js/jquery.easing.1.3.js', 'jquery' );
	wp_enqueue_script( 'jqeasing' );

	wp_register_script( 'prettyPhoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js' );  
	wp_enqueue_script( 'prettyPhoto' );

	wp_register_script( 'flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js' );  
	wp_enqueue_script( 'flexslider' );

	wp_register_script( 'bxslider', get_template_directory_uri() . '/js/jquery.bxslider.min.js' );  
	wp_enqueue_script( 'bxslider' );

	//bootstrap
	wp_register_script( 'bootstrap', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js' );  
	wp_enqueue_script( 'bootstrap' );  

	wp_register_style( 'bootstrap', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css' );  
	wp_enqueue_style( 'bootstrap' );

	wp_register_style( 'fontAwesome', get_template_directory_uri() . '/font-awesome/css/font-awesome.min.css' );  
	wp_enqueue_style( 'fontAwesome' ); 

	//end bootstrap
	/* jQuery ui */
	wp_register_script( 'jquery-ui-accordion', false ); 
	wp_enqueue_script( 'jquery-ui-accordion' ); 
	wp_register_script( 'jquery-ui-tabs', false ); 
	wp_enqueue_script( 'jquery-ui-tabs' ); 

	//styles
	wp_register_style( 'jquery-ui', get_template_directory_uri() . '/css/jquery-ui/jquery-ui-1.10.0.custom.min.css' );
	wp_enqueue_style( 'jquery-ui');

	wp_register_style( 'flexslider', get_template_directory_uri() . '/css/flexslider.css' );
	wp_enqueue_style( 'flexslider');

	wp_register_style( 'prettyPhoto', get_template_directory_uri() . '/css/prettyPhoto.css' );  
	wp_enqueue_style( 'prettyPhoto' );


	wp_register_style( 'bxslider', get_template_directory_uri() . '/css/bxslider/jquery.bxslider.css' );  
	wp_enqueue_style( 'bxslider' );

	wp_register_style( 'googleFonts', 'http://fonts.googleapis.com/css?family=' . $options['google_fonts']);  
	wp_enqueue_style( 'googleFonts' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	wp_enqueue_style( 'vortex-style', get_stylesheet_uri() );
}
add_action( 'admin_enqueue_scripts', 'vortex_admin_scripts_styles' );
add_action( 'wp_enqueue_scripts', 'vortex_scripts_styles' );


register_nav_menu( 'primary', __( 'Primary Menu', 'vortex' ) );

function vortex_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Right sidebar', 'vortex' ),
		'id' => 'right',
		'description' => __( 'Appears on posts and pages on the right side', 'vortex' ),
		'before_widget' => '<aside id="%1$s" class="sidebar_widget widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Left sidebar', 'vortex' ),
		'id' => 'left',
		'description' => __( 'Appears on posts and pages on the left side', 'vortex' ),
		'before_widget' => '<aside id="%1$s" class="sidebar_widget widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer widget area', 'vortex' ),
		'id' => 'sidebar-f',
		'description' => __( 'Appears in Footer', 'vortex' ),
		'before_widget' => '<div class="footer-section span3"><div class="footer-divider"></div><div id="%1$s" class="vt_footer_pretty_box %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3 class="vt_footer_header">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Single post horizontal sidebar', 'vortex' ),
		'id' => 'sidebar-sphs',
		'description' => __( 'Appears on single post pages at the bottom of the page, good for last posts or portfolio widgets', 'vortex' ),
		'before_widget' => '<div class="divider-none"></div><aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Front page left sidebar', 'vortex' ),
		'id' => 'sidebar-fpl',
		'description' => __( 'Appears on the left side of a frontpage', 'vortex' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Front page right sidebar', 'vortex' ),
		'id' => 'sidebar-fpr',
		'description' => __( 'Appears on the right side of a frontpage', 'vortex' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Front page core sidebar', 'vortex' ),
		'id' => 'sidebar-c',
		'description' => __( 'Appears on the right side of a frontpage', 'vortex' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'vortex_widgets_init' );

function vortex_customize_register( $wp_customize )
{
$wp_customize->add_section( 'mytheme_new_section_name' , array(
    'title'      => __('Visible Section Name','vortex'),
    'priority'   => 30,
) );
}
add_action( 'customize_register', 'vortex_customize_register' );

/* ===================================================== */

function vt_content_navigation() {
	global $wp_query;

	if (is_search()) {
		$older = "Older entries";
		$newer = "Newer entries";
	}
	else {
		$older = "Older posts";
		$newer = "Newer posts";
	}

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="pagination" class="navigation" role="navigation">
			<h3 class=""><?php _e( 'Post navigation', 'vortex' ); ?></h3>
			<div class="post-nav-links">
				<?php next_posts_link( __( '<span class="">&larr;</span> ' . $older, 'vortex' ) ); ?>
				<?php previous_posts_link( __( $newer . ' <span class="">&rarr;</span>', 'vortex' ) ); ?>
			</div>
		</nav>
	<?php endif;
}

function new_excerpt_more($more) {
	global $post;
	return ' <a href="'. get_permalink($post->ID) . '"><span class="lp_more">Read the Rest...</span></a>';
}
add_filter('excerpt_more', 'new_excerpt_more');

function vt_get_content_class() {

	global $wp_query;

	$options = vt_get_option('vt_general_settings');
	$blog_options = vt_get_option('vt_blog_settings');
	$port_settings = vt_get_option('vt_portfolio_settings');

	if (!is_singular()) {
		if ($options['main_sidebar_position'] == 'none') {
			$result = 'span12';
		}
		elseif (in_array($options['main_sidebar_position'], array('left','right'))) {
			if (in_array($blog_options['blog_columns'], array('3','4')) && $wp_query->post_count > 2 ) {
				$result = 'span9';
			}
			else {
				$result = 'span8';
			}
		}
		else {
			$result = 'span6';
		}
	}
	else {
		if (is_single()) {
			if ( 'portfolio' == get_post_type() ) {
				if ($port_settings['portfolio_sidebar_position'] == 'none') {
					$result = 'span12';
				}
				elseif (in_array($port_settings['portfolio_sidebar_position'], array('left','right'))) {
					$result = 'span8';
				}
				else {
					$result = 'span6';
				}
			}
			else {
				if ($blog_options['single_post_sidebar_position'] == 'none') {
					$result = 'span12';
				}
				elseif (in_array($blog_options['single_post_sidebar_position'], array('left','right'))) {
					$result = 'span8';
				}
				else {
					$result = 'span6';
				}
			}
		}
		else {
			if ($options['page_sidebar_position'] == 'none') {
				$result = 'span12';
			}
			elseif (in_array($options['page_sidebar_position'], array('left','right'))) {
				$result = 'span8';
			}
			else {
				$result = 'span6';
			}
		}
	}
	return $result;
}

function vt_handle_small_counts($sidebar_position, $columns_number) {

	global $wp_query;
	if ($sidebar_position == 'two') {
		if ($wp_query->post_count == 1) {
			if (in_array($columns_number, array('4','3','2'))) {
				return 'span6';
			}
			return false;
		}
		return false;
	}
	if (in_array($sidebar_position, array('left','right'))) {
		if ($wp_query->post_count == 2) {
			if (in_array($columns_number, array('4','3'))) {
				return 'span4';
			}
			return false;
		}
		elseif ($wp_query->post_count == 1) {
			if (in_array($columns_number, array('4','3','2'))) {
				return 'span8';
			}
			return false;
		}
		return false;
	}

	if ($wp_query->post_count == 3) {
		if ($columns_number == '4') {
			return 'span4';
		}
		return false;
	}
	if ($wp_query->post_count == 2) {
		if (in_array($columns_number, array('4','3'))) {
			return 'span6';
		}
		return false;
	}
	elseif ($wp_query->post_count == 1) {
		if (in_array($columns_number, array('4','3','2'))) {
			return 'span12';
		}
		return false;
	}
	return false;
}

function vt_get_column_class () {

	static $result;
	if ($result) return $result;

	$options = vt_get_option('vt_general_settings');
	$blog_options = vt_get_option('vt_blog_settings');

	$result = vt_handle_small_counts($options['main_sidebar_position'], $blog_options['blog_columns']);

	if (!$result) {
		if ($options['main_sidebar_position'] == 'two') {
			if ($blog_options['blog_columns'] == '1') {
				$result = 'span6';
			}
			else {
				$result = 'span3';
			}
		}
		elseif (in_array($options['main_sidebar_position'], array('left','right'))) {

			if ($blog_options['blog_columns'] == '1') {
				$result = 'span8';
			}
			elseif ($blog_options['blog_columns'] == '2') {
				$result = 'span4';
			}
			else {
				$result = 'span3';
			}
		}
		else {
			switch ($blog_options['blog_columns']) {
				case '1':
				$result = 'span12';
				break;
				case '2':
				$result = 'span6';
				break;
				case '3':
				$result = 'span4';
				break;
				default:
				$result = 'span3';
			}
		}
	}
	return $result;
}

function vt_get_blog_thumbnail_size () {

	return 'post-size';
}

function vt_if_grid_row_open() {

	$result = false;
	global $wp_query;

	$general_options = vt_get_option('vt_general_settings');
	$blog_options = vt_get_option('vt_blog_settings');

	if ($general_options['main_sidebar_position'] == 'two') {
		if (in_array($blog_options['blog_columns'], array('2','3','4'))){
			if(!($wp_query->current_post % 2)) {
				$result = true;
			}
		}
		else {
			$result = true;
		}
	}
	elseif (in_array($general_options['main_sidebar_position'], array('left','right'))) {
		if (in_array($blog_options['blog_columns'], array('3','4'))) {
			if(!($wp_query->current_post % 3)) {
				$result = true;
			}
		}
		elseif ($blog_options['blog_columns'] == '2') {
			if(!($wp_query->current_post % 2)) {
				$result = true;
			}
		}
		else {
			$result = true;
		}
	}
	else {
		if ($blog_options['blog_columns'] == '4') {
			if(!($wp_query->current_post % 4)) {
				$result = true;
			}
		}
		elseif ($blog_options['blog_columns'] == '3') {
			if(!($wp_query->current_post % 3)) {
				$result = true;
			}
		}
		elseif ($blog_options['blog_columns'] == '2') {
			if(!($wp_query->current_post % 2)) {
				$result = true;
			}
		}
		else {
			$result = true;
		}
	}

	if ($result) {
		return '<div class="row">';
	}
	else {
		return '';
	}
}

function vt_if_grid_row_close() {

	$result = false;
	global $wp_query;

	$general_options = vt_get_option('vt_general_settings');
	$blog_options = vt_get_option('vt_blog_settings');

	if ($general_options['main_sidebar_position'] == 'two') {
		if (in_array($blog_options['blog_columns'], array('2','3','4'))){
			if($wp_query->current_post % 2) {
				$result = true;
			}
		}
		else {
			$result = true;
		}
	}
	elseif (in_array($general_options['main_sidebar_position'], array('left','right'))) {
		if (in_array($blog_options['blog_columns'], array('3','4'))) {
			if($wp_query->current_post % 3 == 2) {
				$result = true;
			}
		}
		elseif ($blog_options['blog_columns'] == '2') {
			if($wp_query->current_post % 2) {
				$result = true;
			}
		}
		else {
			$result = true;
		}
	}
	else {
		if ($blog_options['blog_columns'] == '4') {
			if($wp_query->current_post % 4 == 3) {
				$result = true;
			}
		}
		elseif ($blog_options['blog_columns'] == '3') {
			if($wp_query->current_post % 3 == 2) {
				$result = true;
			}
		}
		elseif ($blog_options['blog_columns'] == '2') {
			if($wp_query->current_post % 2) {
				$result = true;
			}
		}
		else {
			$result = true;
		}
	}

	if ($result || $wp_query->current_post == $wp_query->post_count - 1) {
		return '</div>';
	}
	else {
		return '';
	}
}

function vt_get_portfolio_item_class() {

	$options = vt_get_option('vt_portfolio_settings');
	$option = $options['port_columns'];
	$result = array (
		'1' => '',
		'2' => 'span6',
		'3' => 'span4',
		'4' => 'span3'
	);
	return $result[$option];
}

add_filter('widget_tag_cloud_args','set_number_tags');
function set_number_tags($args) {
$args = array('smallest'    => 13, 'largest'    => 13);
return $args;
}

function vt_get_post_thumbnail_url () {
	$array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
	return $array[0];
}

function vt_get_port_group_container_class() {
	$options = vt_get_option('vt_portfolio_settings');
	return $options['port_columns'];
}

function vt_allow_flexslider() {

	$query = new WP_Query("post_type=flexslider");
	if ($query->post_count) {
		$meta = get_post_meta($query->posts[0]->ID, "allowed_pages", true);
		if ($meta) {
			if (is_front_page() && in_array('fpage', $meta)) return true;
			if (is_home() && in_array('blog', $meta)) return true;
			if (is_single() && 'portfolio' == get_post_type() && in_array('portipage', $meta)) return true;
			if (is_post_type_archive() && 'portfolio' == get_post_type() && in_array('portpage', $meta)) return true;
			if (is_search() && in_array('spage', $meta)) return true;
			if (is_tag() && in_array('tpage', $meta)) return true;
			if (is_category() && in_array('cpage', $meta)) return true;
			if (is_author() && in_array('upage', $meta)) return true;
			if (is_archive() && in_array('apage', $meta)) return true;
			if (is_404() && in_array('4page', $meta)) return true;
			if (is_single() && 'post' == get_post_type() && in_array('post', $meta)) return true;
			if (is_page() && in_array(get_queried_object_id(), $meta)) return true;
		}
	}

	return false;
}

function vt_render_flexslider () {
	$query = new WP_Query('post_type=flexslider');
	$result = '<div id="slidershadow_top"></div><div id="slider" class=""><div class="flexslider" ><ul class="slides">';
	if ($query->have_posts()) {
		while ( $query->have_posts()) {
				$query->next_post();
					if (!$query->posts[$query->current_post]->post_content) {
						vt_render_slider_placeholder();
						return;
					}
					$transition = get_post_meta($query->post->ID, 'transition');
					$element = new SimpleXMLElement( '<div>' . $query->posts[$query->current_post]->post_content . '</div>');
					for($i = 0;; $i++) {
						if (!isset($element->a[$i])) break;
						$result .= '<li><img width="1170" height="400" src="' . (string)$element->a[$i]["href"] . '" alt="slide" /></li>';
					}
		}
		$result .= '</ul></div></div><div id="slidershadow_bot"></div><div id="slider_meta" data-options="' . $transition[0] . '" ></div>';
		?>
			<div class="container" >
				<div class="flex-container" >
					<?php echo $result; ?>
				</div>
			</div>
		<?php
	}
	else {
		return 'Slider is not set up';
	}
}

function vt_render_slider_placeholder() {
	global $wp_query;

	if (is_home()) $result = 'Blog';
	if (is_front_page())  $result = 'Home';
	elseif (get_post_type() == 'portfolio' && is_post_type_archive()) $result = 'Portfolio';
	elseif (is_tax('project-type')) $result = 'Portfolio, Project Type: ' . single_term_title("", false);
	elseif (is_single() && get_post_type() == 'portfolio') $result = wp_title("Project: ", false);
	elseif (is_single() && get_post_type() == 'post') $result = wp_title("", false);
	elseif (is_tag()) $result = wptexturize('Posts tagged "' . trim(wp_title("", false)) . '"');
	elseif (is_category()) $result = wptexturize('Posts in category "' . trim(wp_title("", false)) . '"');
	elseif (is_date()) $result = wptexturize('Posts from period: "' . trim(wp_title("", false)) . '"');
	elseif (is_author()) $result = 'Posts by ' . trim(wp_title("", false));
	elseif (is_page()) $result = wp_title("", false);
	elseif (is_search()) $result = "Search results";
	else $result = wp_title("", false);
	?>
			<div id="slider-placeholder">
				<div class="container">
					<?php echo '<h1>' . $result . '</h1>';?>
				</div>
			</div>
	<?php 
}

function vt_enqueue_google_maps () {
	static $count = 0;
	if ($count) return;
	$general_options = vt_get_option('vt_general_settings');

	wp_register_script( 'googlemaps', "http://maps.googleapis.com/maps/api/js?key=" . $general_options['google_api_key'] . "&sensor=false" );
	wp_enqueue_script('googlemaps');
	$count++;
}

function vt_get_pagination_numbers () {
	global $wp_query;

	$big = 999999999;

	echo paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages,
		'prev_text'=> __('<i class="icon-double-angle-left"></i> Previous'),
		'next_text'=> __('Next <i class="icon-double-angle-right"></i>'),
	) );
}



function vt_query_portfolio_posts( $query ) {

	if (is_post_type_archive('portfolio') || is_tax('project-type')) {
		if ($query->is_main_query()){

			$options = vt_get_option('vt_portfolio_settings');
			$query->set('post_type', 'portfolio');
			$items = -1;

			if (vt_use_pagination('portfolio')) {
				switch ($items = $options['port_columns']) {
					case 1:
						$items = '2';
						break;
					case 2:
						$items = '4';
						break;
					case 3:
						$items = '6';
						break;
					case 4:
						$items = '8';
						break;
				}
			}
			$query->set('posts_per_page', $items);
		}
	}

}
add_action( 'pre_get_posts', 'vt_query_portfolio_posts' );

function vt_get_portfolio_thumbnail_size () {
	$options = vt_get_option('vt_portfolio_settings');
	switch ($options['port_columns']) {
		case 1:
			$thumb_dims = 'post-size';
			break;
		case 2:
			$thumb_dims = 'port-2-col';
			break;
		case 3:
			$thumb_dims = 'port-2-col';
			break;
		case 4:
			$thumb_dims = 'port-3-col';
			break;
	}
	return $thumb_dims;
}

function vt_portfolio_term_list() {
	$term_list = '';
	$terms = get_terms('project-type');
	$count = count($terms);
	if ($count > 0) {
			foreach ($terms  as $term) {
				$term_list  .= '<li><a href="javascript:void(0)" class="'.  $term->slug .'">' . $term->name . '</a></li>';  
			}  
	}
	return $term_list;
}

function vt_use_pagination ($type) {
	switch ($type) {
		case 'portfolio':
			$return = vt_get_option('vt_portfolio_settings');
			$return = isset($return['use_pagination']);
	}
	return $return;
}

function vt_hex_to_rgb ($hex) {
	$hex = substr($hex, 1, 7);
	$r = hexdec(substr($hex, 0, 2));
	$g = hexdec(substr($hex, 2, 2));
	$b = hexdec(substr($hex, 4, 2));

	return "$r, $g, $b";
}

function vt_hex_to_rgb_array ($hex) {
	$hex = substr($hex, 1, 7);
	$r = hexdec(substr($hex, 0, 2));
	$g = hexdec(substr($hex, 2, 2));
	$b = hexdec(substr($hex, 4, 2));

	return array($r, $g, $b);
}

function vt_get_page_js_config() {
	$color_options = vt_get_option('vt_color_settings');
	$general_options = vt_get_option('vt_general_settings');
	if (isset($general_options['disable_theme_styles'])) {
		$config = '"color_scheme": "#ffffff"';
	}
	else {
		$config = '"color_scheme": "' . $color_options['color_scheme'] . '"';
	}
	$config .= ',"img_path": "' . get_template_directory_uri() . '/"';
	return $config;
}


function remove_category_list_rel( $output ) {
	return str_replace( ' rel="category"', '', $output );
}

add_filter( 'wp_list_categories', 'remove_category_list_rel' );
add_filter( 'the_category', 'remove_category_list_rel' );

function vt_rgb2hsv ($rgb) {

	$r = $rgb[0]/255;
	$g = $rgb[1]/255;
	$b = $rgb[2]/255;
	$v = max($r, $g, $b);
	$diff = $v - min($r, $g, $b);

	if ($diff == 0) {
		$h = $s = 0;
	} else {
		$s = $diff / $v;
		$rr = vt_diffc($r, $v, $diff);
		$gg = vt_diffc($g, $v, $diff);
		$bb = vt_diffc($b, $v, $diff);

		if ($r === $v) {
			$h = $bb - $gg;
		}else if ($g === $v) {
			$h = (1 / 3) + $rr - $bb;
		}else if ($b === $v) {
			$h = (2 / 3) + $gg - $rr;
		}
		if ($h < 0) {
			$h += 1;
		}else if ($h > 1) {
			$h -= 1;
		}
	}
	return array(
		'h' => round($h * 360),
		's' => round($s * 100),
		'v' => round($v * 100)
	);
}

function vt_diffc($c, $v, $diff){
	return ($v - $c) / 6 / $diff + 1 / 2;
};

?> 