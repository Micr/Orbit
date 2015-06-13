<?php

add_action( 'admin_menu', 'vt_menu' );

function vt_menu() {
	add_theme_page( 'Theme Options', 'Theme Options', 'edit_theme_options', 'theme_settings', 'vt_render_options_page');
}

function vt_theme_styles_disabled() {
	$options = vt_get_option('vt_general_settings');
	return isset($options['disable_theme_styles']);
}

function vt_render_options_page() {
	if (!current_user_can('edit_theme_options'))
	{
		wp_die( __('You do not have sufficient permissions to access this page.') );
		
		
	}
	if (isset($_REQUEST['settings-updated']) && $_REQUEST['settings-updated'] == 'true'){
	?>
	<div id="setting-error-settings_updated" class="updated settings-error"><p><strong>Settings saved.</strong></p></div>
	<?php } 
		$existing_tabs = array(
			'vt_general_settings' => 'General Options',
			'vt_typo_settings' => 'Typography Options',
			'vt_color_settings' => 'Color Options',
			'vt_blog_settings' => 'Blog Options' , 
			'vt_portfolio_settings' => 'Portfolio Options'
		);
	?>
	<div id="vt_options_container">
		<h1 class="theme_options_heading">Change Theme Options</h1>
		<div class="tabbable tabs-left">
			<?php $current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'vt_general_settings';

				echo '<ul class="nav nav-tabs">';
				foreach ( $existing_tabs as $tab_key => $tab_caption ) {
				$active = $current_tab == $tab_key ? ' class="active"' : '';
				echo '<li' . $active . '><a href="?page=theme_settings&tab=' . $tab_key . '">' . $tab_caption . '</a></li>';
				}
				echo '</ul>';

				$tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'vt_general_settings'; ?>
			<div id="tabs-1" class="tab-content span11">
				<form method="post" action="options.php" >
					<?php settings_fields( $tab. '_group'); ?>
					<?php do_settings_sections($tab); ?>
					<?php if( !in_array($tab, array('vt_typo_settings', 'vt_color_settings')) || !vt_theme_styles_disabled()): ?>
						<p class="submit">
							<input name="<?php echo $tab . '[submit_settings]'; ?>" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" class="button button-primary" />
							<input name="<?php echo $tab . '[reset_settings]'; ?>" type="submit" value="<?php esc_attr_e('Reset Defaults'); ?>" class="button-secondary" />
						</p>
					<?php endif; ?>
				</form>
			</div>
		</div>
	</div>
<?php

}


add_action('admin_init', 'vt_settings_admin_init');

function vt_settings_admin_init(){

	register_setting( 'vt_general_settings_group', 'vt_general_settings', 'theme_settings_validate' );
	add_settings_section('general_main', 'General Options', 'vt_general_section_text', 'vt_general_settings');
	add_settings_field('main_sidebar_position', 'Main sidebar position', 'vt_main_sidebar_position', 'vt_general_settings', 'general_main');
	add_settings_field('page_sidebar_position', 'Page sidebar position', 'vt_page_sidebar_position', 'vt_general_settings', 'general_main');
	add_settings_field('site_layout', 'Site layout', 'vt_site_layout', 'vt_general_settings', 'general_main');
	add_settings_field('top_panel_position', 'Top panel postion', 'vt_top_panel_position', 'vt_general_settings', 'general_main');
	add_settings_field('header_text_rotator', '', 'vt_header_text_rotator', 'vt_general_settings', 'general_main');
	add_settings_field('header_text_rotator_fields', 'Header text rotator fields', 'vt_header_text_rotator_fields', 'vt_general_settings', 'general_main');
	add_settings_field('top_panel_links_enable', '', 'vt_top_panel_links_enable', 'vt_general_settings', 'general_main');
	add_settings_field('top_panel_links', 'Top panel links', 'vt_top_panel_links', 'vt_general_settings', 'general_main');
	add_settings_field('top_header_links_enable', '', 'vt_top_header_links_enable', 'vt_general_settings', 'general_main');
	add_settings_field('top_header_links', 'Top header links', 'vt_top_header_links', 'vt_general_settings', 'general_main');
	add_settings_field('social_media_links_enable', '', 'vt_social_media_links_enable', 'vt_general_settings', 'general_main');
	add_settings_field('social_media_links', 'Social media links', 'vt_social_media_links', 'vt_general_settings', 'general_main');
	add_settings_field('google_api_key', 'Google API key', 'vt_google_api_key', 'vt_general_settings', 'general_main');
	add_settings_field('twitter_auth', 'Twitter authorization fields', 'vt_twitter_auth', 'vt_general_settings', 'general_main');
	add_settings_field('copyright_line', 'Copyright info', 'vt_copyright_line', 'vt_general_settings', 'general_main');
	add_settings_field('disable_theme_styles', 'Disable theme styles', 'vt_disable_theme_styles', 'vt_general_settings', 'general_main');

	register_setting( 'vt_portfolio_settings_group', 'vt_portfolio_settings', 'theme_settings_validate' );
	add_settings_section('portfolio_main', 'Portfolio Options', 'vt_theme_section_text', 'vt_portfolio_settings');
	add_settings_field('port_columns', 'Number Of Columns', 'vt_number_columns_portfolio_field', 'vt_portfolio_settings', 'portfolio_main');
	add_settings_field('use_pagination', 'Use pagination', 'vt_portfolio_use_pagination', 'vt_portfolio_settings', 'portfolio_main');
	add_settings_field('portfolio_sidebar_position', 'Portfolio post sidebar position', 'vt_portfolio_sidebar_position', 'vt_portfolio_settings', 'portfolio_main');

	register_setting( 'vt_blog_settings_group', 'vt_blog_settings', 'theme_settings_validate' );
	add_settings_section('blog_main', 'Blog Options', 'vt_blog_section_text', 'vt_blog_settings');
	add_settings_field('blog_columns', 'Number Of Columns', 'vt_number_columns_blog_field', 'vt_blog_settings', 'blog_main');
	add_settings_field('single_post_sidebar_position', 'Single post sidebar position', 'vt_blog_sidebar_position', 'vt_blog_settings', 'blog_main');


	register_setting( 'vt_color_settings_group', 'vt_color_settings', 'theme_settings_validate' );
	add_settings_section('color_main', 'Color Options', 'vt_color_section_text', 'vt_color_settings');
	if (!vt_theme_styles_disabled()) {
		add_settings_field('use_color_scheme', 'Use Color Scheme', 'vt_use_color_scheme', 'vt_color_settings', 'color_main');
		add_settings_field('color_scheme', 'Color Scheme', 'vt_color_scheme', 'vt_color_settings', 'color_main');
		add_settings_field('link_color', 'Link color', 'vt_color_options', 'vt_color_settings', 'color_main');
		add_settings_field('tpanel_color', 'Top panel color', 'vt_tpanel_color', 'vt_color_settings', 'color_main');
		add_settings_field('top_wrapper_color', 'Header color', 'vt_header_color', 'vt_color_settings', 'color_main');
		add_settings_field('nmenu_color', 'Navigation menu color', 'vt_nav_menu_color', 'vt_color_settings', 'color_main');
		add_settings_field('footer_color', 'Footer color', 'vt_footer_color', 'vt_color_settings', 'color_main');
		add_settings_field('transparent_fwidget', 'Transparent footer widget background', 'vt_transparent_fwidget', 'vt_color_settings', 'color_main');
		add_settings_field('fwidget_color', 'Footer widget color', 'vt_footer_widget_color', 'vt_color_settings', 'color_main');
		add_settings_field('footer_link_color', 'Footer link color', 'vt_footer_link_color', 'vt_color_settings', 'color_main');
		add_settings_field('details_color', 'Details Color', 'vt_details_color', 'vt_color_settings', 'color_main');
	}

	register_setting( 'vt_typo_settings_group', 'vt_typo_settings', 'theme_settings_validate' );
	add_settings_section('typo_main', 'Typography Options', 'vt_typo_section_text', 'vt_typo_settings');
	if (!vt_theme_styles_disabled()) {
		add_settings_field('header_color', 'Headings color', 'vt_headings_color', 'vt_typo_settings', 'typo_main');
		add_settings_field('links_hover_color', 'Links hover color', 'vt_links_hover_color', 'vt_typo_settings', 'typo_main');
		add_settings_field('slider_placeholder_color', 'Slider placeholder text color', 'vt_slider_placeholder_color', 'vt_typo_settings', 'typo_main');
		add_settings_field('sidebar_widget_color', 'Sidebar widgets text color', 'vt_sidebar_widgets_color', 'vt_typo_settings', 'typo_main');
		add_settings_field('sidebar_widget_header', 'Sidebar widgets headings', 'vt_sidebar_widgets_header', 'vt_typo_settings', 'typo_main');
		add_settings_field('footer_widget_color', 'Footer widgets text', 'vt_footer_widgets_color', 'vt_typo_settings', 'typo_main');
		add_settings_field('footer_widget_header', 'Footer widgets headings', 'vt_footer_widgets_header', 'vt_typo_settings', 'typo_main');
		add_settings_field('body_font_size', 'Default font size', 'vt_body_font_size', 'vt_typo_settings', 'typo_main');
		add_settings_field('body_line_height', 'Default line height', 'vt_body_line_height', 'vt_typo_settings', 'typo_main');
		add_settings_field('header_line_height', 'Header line height', 'vt_header_line_height', 'vt_typo_settings', 'typo_main');
		add_settings_field('h1_font_size', 'H1 font size', 'vt_h1_font_size', 'vt_typo_settings', 'typo_main');
		add_settings_field('h2_font_size', 'H2 font size', 'vt_h2_font_size', 'vt_typo_settings', 'typo_main');
		add_settings_field('h3_font_size', 'H3 font size', 'vt_h3_font_size', 'vt_typo_settings', 'typo_main');
		add_settings_field('h4_font_size', 'H4 font size', 'vt_h4_font_size', 'vt_typo_settings', 'typo_main');
		add_settings_field('content_area_font_size', 'Content area font size', 'vt_content_area_font_size', 'vt_typo_settings', 'typo_main');
		add_settings_field('content_area_line_height', 'Content area line height', 'vt_content_area_line_height', 'vt_typo_settings', 'typo_main');
		add_settings_field('google_fonts', 'Google Fonts', 'vt_google_fonts', 'vt_typo_settings', 'typo_main');
		add_settings_field('own_fonts', 'Use own font families(comma separated)', 'vt_own_fonts', 'vt_typo_settings', 'typo_main');
	}
}

function vt_general_section_text() {

}

function vt_theme_section_text() {

}

function vt_blog_section_text() {

}

function vt_color_section_text() {
	if (vt_theme_styles_disabled()) {
		echo '<p class="ts_disabled" > Theme styles are disabled. Uncheck <b>Disable Theme Styles</b> in General Options tab to enable this section</p>';
	}
}

function vt_typo_section_text() {
	if (vt_theme_styles_disabled()) {
		echo '<p class="ts_disabled" > Theme styles are disabled. Uncheck <b>Disable Theme Styles</b> in General Options tab to enable this section</p>';
	}
}

function vt_main_sidebar_position () {
	$options = vt_get_option('vt_general_settings');
	$units = array('right', 'left', 'none', 'two');
	?>
		<select name="vt_general_settings[main_sidebar_position]">
		<?php foreach ($units as $unit): ?>
			<option value="<?php echo $unit;?>" <?php selected($options['main_sidebar_position'], $unit)?>><?php echo $unit;?></option>
		<?php endforeach; ?>
		</select>
<?php
}

function vt_page_sidebar_position () {
	$options = vt_get_option('vt_general_settings');
	$units = array('right', 'left', 'none', 'two');
	?>
		<select name="vt_general_settings[page_sidebar_position]">
		<?php foreach ($units as $unit): ?>
			<option value="<?php echo $unit;?>" <?php selected($options['page_sidebar_position'], $unit)?>><?php echo $unit;?></option>
		<?php endforeach; ?>
		</select>
<?php
}

function vt_site_layout () {
	$options = vt_get_option('vt_general_settings');
	$units = array('boxed', 'full_size');
	?>
		<select name="vt_general_settings[site_layout]">
			<option value="boxed" <?php selected($options['site_layout'], 'boxed')?>>Boxed</option>
			<option value="full_width" <?php selected($options['site_layout'], 'full_width')?>>Full width</option>
		</select>
	<?php
}

function vt_top_panel_position() {
	$options = vt_get_option('vt_general_settings');
	$units = array('fixed', 'static');
	?>
		<select name="vt_general_settings[top_panel_position]">
			<option value="fixed" <?php selected($options['top_panel_position'], 'fixed')?>>Fixed</option>
			<option value="static" <?php selected($options['top_panel_position'], 'static')?>>Static</option>
		</select>
	<?php
}

function vt_header_text_rotator () {
	$options = vt_get_option('vt_general_settings');
	?>
	<label class="checkbox"><input data-for="text_rotator_field" class="enabler" type="checkbox" name="vt_general_settings[header_text_rotator]" <?php checked(isset($options['header_text_rotator'])); ?> value="true" /> Enable Header Text Rotator </label>
	<?php
}

function vt_header_text_rotator_fields () {
	$options = vt_get_option('vt_general_settings');
	echo '<div class="fields-parent">Add a field <button class="add-field button button-primary"> <b>+</b> </button><button class="remove-field button button-primary"> <b>-</b> </button></div>';
	echo '';
	if (isset($options['header_text_rotator_fields']['quote']))
		$count = count($options['header_text_rotator_fields']['quote']);
	else 
		$count = 3;
	for ($i = 0; $i < $count; $i++): ?>
	<label><input class="text_rotator_field" type="text" name="vt_general_settings[header_text_rotator_fields][quote][]" value="<?php echo isset($options['header_text_rotator_fields']['quote'][$i]) ? esc_attr( $options['header_text_rotator_fields']['quote'][$i] ) : ''; ?>" /> Quote <?php echo $i+1; ?></label><br/>
	<label><input class="text_rotator_field" type="text" name="vt_general_settings[header_text_rotator_fields][author][]" value="<?php echo isset($options['header_text_rotator_fields']['author'][$i]) ? esc_attr( $options['header_text_rotator_fields']['author'][$i] ) : ''; ?>" /> Author <?php echo $i+1; ?></label><br/>
	<?php endfor;
}

function vt_top_panel_links_enable () {
	$options = vt_get_option('vt_general_settings');
	?>
	<div class="offsetted-text">Precede all external web links with <b><em>http://</em></b> and mail links with <b><em>mailto:</em></b></div>
	<label class="checkbox"><input data-for="top_panel_links_field" class="enabler" type="checkbox" name="vt_general_settings[top_panel_links_enable]" <?php checked(isset($options['top_panel_links_enable'])); ?> value="true" /> Enable top panel links </label>
	<?php
}

function vt_top_panel_links () {
	$options = vt_get_option('vt_general_settings');
	if (isset($options['top_panel_links'])) { 
		$name = count($options['top_panel_links']['name']);
		$url = count($options['top_panel_links']['url']);
		$count = max($name, $url);
	}
	else {
		$count = 3;
	}
	if ($count < 3) $count = 3;
	for ($i = 0; $i < $count; $i++): ?>
	<label><input class="top_panel_links_field" type="text" name="vt_general_settings[top_panel_links][name][]" value="<?php echo isset($options['top_panel_links']['name'][$i]) ? esc_attr( $options['top_panel_links']['name'][$i] ) : ''; ?>" /> Link <?php echo $i+1; ?> text</label><br/>
	<label><input class="top_panel_links_field" type="text" name="vt_general_settings[top_panel_links][url][]" value="<?php echo isset($options['top_panel_links']['url'][$i]) ? esc_attr( $options['top_panel_links']['url'][$i] ) : ''; ?>" /> Link <?php echo $i+1; ?> url</label><br/><br/>
	<?php endfor;
}

function vt_top_header_links_enable () {
	$options = vt_get_option('vt_general_settings');
	?>
	<label class="checkbox"><input data-for="top_header_links" class="enabler" type="checkbox" name="vt_general_settings[top_header_links_enable]" <?php checked(isset($options['top_header_links_enable'])); ?> value="true" /> Enable top panel links </label>
	<?php
}

function vt_top_header_links () {
	$options = vt_get_option('vt_general_settings');
	if (isset($options['top_header_links'])) { 
		$name = count($options['top_header_links']['name']);
		$url = count($options['top_header_links']['url']);
		$count = max($name, $url);
	}
	else {
		$count = 3;
	}
	if ($count < 3) $count = 3;
	for ($i = 0; $i < $count; $i++): ?>
	<label><input class="top_header_links" type="text" name="vt_general_settings[top_header_links][name][]" value="<?php echo isset($options['top_header_links']['name'][$i]) ? esc_attr( $options['top_header_links']['name'][$i] ) : ''; ?>" /> Link <?php echo $i+1; ?> text</label><br/>
	<label><input class="top_header_links" type="text" name="vt_general_settings[top_header_links][url][]" value="<?php echo isset($options['top_header_links']['url'][$i]) ? esc_attr( $options['top_header_links']['url'][$i] ) : ''; ?>" /> Link <?php echo $i+1; ?> url</label><br/><br/>
	<?php endfor;
}

function vt_social_media_links_enable () {
	$options = vt_get_option('vt_general_settings');
	?>
	<label class="checkbox"><input data-for="social_media_links" class="enabler" type="checkbox" name="vt_general_settings[social_media_links_enable]" <?php checked(isset($options['social_media_links_enable'])); ?> value="true" /> Enable top panel links </label>
	<?php
}

function vt_social_media_links() {
	$options = vt_get_option('vt_general_settings');
	$links = isset($options['social_media_links']) ? $options['social_media_links'] : array();
	$defaults = array (
		'twitter',
		'facebook',
		'rss',
		'mail',
		'youtube',
		'vimeo',
		'tumblr',
		'stumbleupon',
		'linkedin',
		'googleplus',
		'flickr',
		'pinterest',
	);
	foreach ($defaults as $default) {
		if (!isset($links[$default])) $links[$default] = '';
	}
	foreach ($links as $name => $value): ?>
	<label><input class="social_media_links" type="text" name="vt_general_settings[social_media_links][<?php echo $name; ?>]" value="<?php echo $value; ?>" /> <?php echo ucfirst($name); ?> link</label><br/>
	<?php endforeach;
}

function vt_google_api_key () {
	$options = vt_get_option('vt_general_settings');
	if (!isset($options['google_api_key'])) $options['google_api_key'] = '';
	?>
	<p>If you dont have a google api key yet, you can get one <a href="https://code.google.com/apis/console/">here</a></p>
	<label><input type="text" name="vt_general_settings[google_api_key]" value="<?php echo trim($options['google_api_key']); ?>" /> Your Google API key</label><br/>
	<?php
}

function vt_twitter_auth () {
	$options = vt_get_option('vt_general_settings');
	if (!isset($options['twitter_auth']['consumer_key'])) $options['twitter_auth']['consumer_key'] = '';
	if (!isset($options['twitter_auth']['consumer_secret'])) $options['twitter_auth']['consumer_secret'] = '';
	if (!isset($options['twitter_auth']['access_token'])) $options['twitter_auth']['access_token'] = '';
	if (!isset($options['twitter_auth']['access_token_secret'])) $options['twitter_auth']['access_token_secret'] = '';
	?>
	<p>If you dont have twitter api credentials yet, you can get them <a href="https://dev.twitter.com/apps/new">here</a></p>
	<label><input type="text" name="vt_general_settings[twitter_auth][consumer_key]" value="<?php echo trim($options['twitter_auth']['consumer_key']); ?>" /> Consumer key</label><br/>
	<label><input type="text" name="vt_general_settings[twitter_auth][consumer_secret]" value="<?php echo trim($options['twitter_auth']['consumer_secret']); ?>" /> Consumer secret</label><br/>
	<label><input type="text" name="vt_general_settings[twitter_auth][access_token]" value="<?php echo trim($options['twitter_auth']['access_token']); ?>" /> Access token</label><br/>
	<label><input type="text" name="vt_general_settings[twitter_auth][access_token_secret]" value="<?php echo trim($options['twitter_auth']['access_token_secret']); ?>" /> Access token secret</label><br/>
	<?php
}

function vt_copyright_line() {
	$options = vt_get_option('vt_general_settings');
	if (!isset($options['copyright_line'])) $options['copyright_line'] = '';
	?>
	<label><input type="text" name="vt_general_settings[copyright_line]" value="<?php echo trim($options['copyright_line']); ?>" /></label><br/>
	<?php
}

function vt_disable_theme_styles () {
	$options = vt_get_option('vt_general_settings');
	?>
	<label class="checkbox"><input class="enabler" type="checkbox" name="vt_general_settings[disable_theme_styles]" <?php checked(isset($options['disable_theme_styles'])); ?> value="true" /> Check this if you want to use theme's style.css rules(editable from Appearance > Editor)</label>
	<?php
}

function vt_number_columns_portfolio_field() {
	$options = vt_get_option('vt_portfolio_settings');
	?>
	<label class="radio"><input id='port_columns_one' name='vt_portfolio_settings[port_columns]' <?php checked( $options['port_columns'], 1 ); ?> type='radio' value='1' /> One column</label><br />
	<label class="radio"><input id='port_columns_two' name='vt_portfolio_settings[port_columns]' <?php checked( $options['port_columns'], 2 ); ?> type='radio' value='2' /> Two columns</label><br />
	<label class="radio"><input id='port_columns_three' name='vt_portfolio_settings[port_columns]' <?php checked( $options['port_columns'], 3 ); ?> type='radio' value='3' /> Three columns</label><br />
	<label class="radio"><input id='port_columns_four' name='vt_portfolio_settings[port_columns]' <?php checked( $options['port_columns'], 4 ); ?> type='radio' value='4' /> Four columns</label><br />
	<?php
}

function vt_portfolio_use_pagination () {
	$options = vt_get_option('vt_portfolio_settings');
	?>
	<label class="checkbox"><input class="enabler" type="checkbox" name="vt_portfolio_settings[use_pagination]" <?php checked(isset($options['use_pagination'])); ?> value="true" /></label>
	<?php
}

function vt_portfolio_sidebar_position () {
	$options = vt_get_option('vt_portfolio_settings');
	$units = array('right', 'left', 'none', 'two');
	?>
		<select name="vt_portfolio_settings[portfolio_sidebar_position]">
		<?php foreach ($units as $unit): ?>
			<option value="<?php echo $unit;?>" <?php selected($options['portfolio_sidebar_position'], $unit)?>><?php echo $unit;?></option>
		<?php endforeach; ?>
		</select>
<?php
}

function vt_number_columns_blog_field() {
	$options = vt_get_option('vt_blog_settings');
	$sidebars = vt_get_option('vt_general_settings');
	?>
	<div class="span3">
		<label class="radio"><input id='blog_columns_one' name='vt_blog_settings[blog_columns]' <?php checked( $options['blog_columns'], '1' ); ?> type='radio' value='1' /> One coulumn</label><br />
		<label class="radio"><input id='blog_columns_two' name='vt_blog_settings[blog_columns]' <?php checked( $options['blog_columns'], '2' ); ?> type='radio' value='2' /> Two columns</label><br />
		<label class="radio"><input id='blog_columns_three' name='vt_blog_settings[blog_columns]' <?php checked( $options['blog_columns'], '3' ); ?> type='radio' value='3' /> Three columns</label><br />
		<label class="radio"><input id='blog_columns_four' name='vt_blog_settings[blog_columns]' <?php checked( $options['blog_columns'], '4' ); ?> type='radio' value='4' /> Four columns</label><br />
	</div>
	<p class="span4"><b>Sidebars take one column space, so to have more blog columns disable some sidebars</b></p>
	<?php
}


function vt_blog_sidebar_position () {
	$options = vt_get_option('vt_blog_settings');
	$units = array('right', 'left', 'none', 'two');
	?>
		<select name="vt_blog_settings[single_post_sidebar_position]">
		<?php foreach ($units as $unit): ?>
			<option value="<?php echo $unit;?>" <?php selected($options['single_post_sidebar_position'], $unit)?>><?php echo $unit;?></option>
		<?php endforeach; ?>
		</select>
<?php
}

function vt_use_color_scheme () {
	$options = vt_get_option('vt_color_settings');
	?>
	<label class="checkbox"><input class="color_scheme_enabler" type="checkbox" name="vt_color_settings[use_color_scheme]" <?php checked(isset($options['use_color_scheme'])); ?> value="true" /></label>
	<?php
}

function vt_color_scheme () {
	$options = vt_get_option( 'vt_color_settings' );
	?>
	<div class="color-picker" style="position: relative;">
		<input id="color_scheme" class="color" type="text" name="vt_color_settings[color_scheme]" value="<?php echo esc_attr( $options['color_scheme'] ); ?>" />
		<div style="position: absolute;" id="cp_color_scheme" class="colorpicker"></div>
	</div>
	<?php
}

function vt_color_options() {
	$options = vt_get_option( 'vt_color_settings' );
	?>
	<div class="color-picker" style="position: relative;">
		<input id="link_color" class="color" type="text" name="vt_color_settings[link_color]" value="<?php echo esc_attr( $options['link_color'] ); ?>" />
		<div style="position: absolute;" id="cp_link_color" class="colorpicker"></div>
	</div>
	<?php
}

function vt_tpanel_color() {
	$options = vt_get_option( 'vt_color_settings' );
	?>
	<div class="color-picker" style="position: relative;">
		<input id="tpanel_color" class="color" type="text" name="vt_color_settings[tpanel_color]" value="<?php echo esc_attr( $options['tpanel_color'] ); ?>" />
		<div style="position: absolute;" id="cp_tpanel_color" class="colorpicker"></div>
	</div>
	<?php
}

function vt_header_color() {
	$options = vt_get_option( 'vt_color_settings' );
	?>
	<div class="color-picker" style="position: relative;">
		<input id="top_wrapper_color" class="color" type="text" name="vt_color_settings[top_wrapper_color]" value="<?php echo esc_attr( $options['top_wrapper_color'] ); ?>" />
		<div style="position: absolute;" id="cp_top_wrapper_color" class="colorpicker"></div>
	</div>
	<?php
}

function vt_nav_menu_color () {
	$options = vt_get_option( 'vt_color_settings' );
	?>
	<div class="color-picker" style="position: relative;">
		<input id="nmenu_color" class="color" type="text" name="vt_color_settings[nmenu_color]" value="<?php echo esc_attr( $options['nmenu_color'] ); ?>" />
		<div style="position: absolute;" id="cp_nmenu_color" class="colorpicker"></div>
	</div>
	<?php
}

function vt_footer_color() {
	$options = vt_get_option( 'vt_color_settings' );
	?>
	<div class="color-picker" style="position: relative;">
		<input id="footer_color" class="color" type="text" name="vt_color_settings[footer_color]" value="<?php echo esc_attr( $options['footer_color'] ); ?>" />
		<div style="position: absolute;" id="cp_footer_color" class="colorpicker"></div>
	</div>
	<?php
}

function vt_footer_widget_color () {
	$options = vt_get_option( 'vt_color_settings' );
	?>
	<div class="color-picker" style="position: relative;">
		<input id="fwidget_color" class="color" type="text" name="vt_color_settings[fwidget_color]" value="<?php echo esc_attr( $options['fwidget_color'] ); ?>" />
		<div style="position: absolute;" id="cp_fwidget_color" class="colorpicker"></div>
	</div>
	<?php
}

function vt_transparent_fwidget () {
	$options = vt_get_option( 'vt_color_settings' );
	?>
	<label><input id="transparent_fwidget" type="checkbox" name="vt_color_settings[transparent_fwidget]" value="vortex" <?php checked( isset($options['transparent_fwidget']) ); ?> /></label>
	<?php
}

function vt_footer_link_color () {
	$options = vt_get_option( 'vt_color_settings' );
	?>
	<div class="color-picker" style="position: relative;">
		<input id="footer_link_color" class="color" type="text" name="vt_color_settings[footer_link_color]" value="<?php echo esc_attr( $options['footer_link_color'] ); ?>" />
		<div style="position: absolute;" id="cp_footer_link_color" class="colorpicker"></div>
	</div>
	<?php
}

function vt_details_color () {
	$options = vt_get_option( 'vt_color_settings' );
	?>
	<div class="color-picker" style="position: relative;">
		<input id="details_color" class="color" type="text" name="vt_color_settings[details_color]" value="<?php echo esc_attr( $options['details_color'] ); ?>" />
		<div style="position: absolute;" id="cp_details_color" class="colorpicker"></div>
	</div>
	<?php
}

function vt_headings_color () {
	$options = vt_get_option( 'vt_typo_settings' );
	?>
	<div class="color-picker" style="position: relative;">
		<input id="header_color" class="color" type="text" name="vt_typo_settings[header_color]" value="<?php echo esc_attr( $options['header_color'] ); ?>" />
		<div style="position: absolute;" id="cp_header_color" class="colorpicker"></div>
	</div>
	<?php
}

function vt_links_hover_color () {
	$options = vt_get_option( 'vt_typo_settings' );
	?>
	<div class="color-picker" style="position: relative;">
		<input id="links_hover_color" class="color" type="text" name="vt_typo_settings[links_hover_color]" value="<?php echo esc_attr( $options['links_hover_color'] ); ?>" />
		<div style="position: absolute;" id="cp_links_hover_color" class="colorpicker"></div>
	</div>
	<?php
}

function vt_slider_placeholder_color () {
	$options = vt_get_option( 'vt_typo_settings' );
	?>
	<div class="color-picker" style="position: relative;">
		<input id="slider_placeholder_color" class="color" type="text" name="vt_typo_settings[slider_placeholder_color]" value="<?php echo esc_attr( $options['slider_placeholder_color'] ); ?>" />
		<div style="position: absolute;" id="cp_slider_placeholder_color" class="colorpicker"></div>
	</div>
	<?php
}

function vt_sidebar_widgets_color () {
	$options = vt_get_option( 'vt_typo_settings' );
	?>
	<div class="color-picker" style="position: relative;">
		<input id="sidebar_widget_color" class="color" type="text" name="vt_typo_settings[sidebar_widget_color]" value="<?php echo esc_attr( $options['sidebar_widget_color'] ); ?>" />
		<div style="position: absolute;" id="cp_sidebar_widget_color" class="colorpicker"></div>
	</div>
	<?php
}

function vt_sidebar_widgets_header () {
	$options = vt_get_option( 'vt_typo_settings' );
	?>
	<div class="color-picker" style="position: relative;">
		<input id="sidebar_widget_header" class="color" type="text" name="vt_typo_settings[sidebar_widget_header]" value="<?php echo esc_attr( $options['sidebar_widget_header'] ); ?>" />
		<div style="position: absolute;" id="cp_sidebar_widget_header" class="colorpicker"></div>
	</div>
	<?php
}

function vt_footer_widgets_color () {
	$options = vt_get_option( 'vt_typo_settings' );
	?>
	<div class="color-picker" style="position: relative;">
		<input id="footer_widget_color" class="color" type="text" name="vt_typo_settings[footer_widget_color]" value="<?php echo esc_attr( $options['footer_widget_color'] ); ?>" />
		<div style="position: absolute;" id="cp_footer_widget_color" class="colorpicker"></div>
	</div>
	<?php
}

function vt_footer_widgets_header () {
	$options = vt_get_option( 'vt_typo_settings' );
	?>
	<div class="color-picker" style="position: relative;">
		<input id="footer_widget_header" class="color" type="text" name="vt_typo_settings[footer_widget_header]" value="<?php echo esc_attr( $options['footer_widget_header'] ); ?>" />
		<div style="position: absolute;" id="cp_footer_widget_header" class="colorpicker"></div>
	</div>
	<?php
}

function vt_body_font_size() {
	$options = vt_get_option( 'vt_typo_settings' );
	$units = array( 'px', 'pt', 'em', '%' );
	?>
		<label> 
			<input name='vt_typo_settings[body_font_size]' type='text' value='<?php echo $options['body_font_size']; ?>' />
		</label>
		<select name="vt_typo_settings[body_font_size_unit]">
			<?php foreach ($units as $unit): ?>
				<option value="<?php echo $unit;?>" <?php selected($options['body_font_size_unit'], $unit)?>><?php echo $unit;?></option>
			<?php endforeach; ?>
		</select>
	<?php
	}

function vt_body_line_height() {
	$options = vt_get_option( 'vt_typo_settings' );
	$units = array( 'px', 'pt', 'em', '%' );
	?>
	<label> 
		<input name='vt_typo_settings[body_line_height]' type='text' value='<?php echo $options['body_line_height']; ?>' />
	</label>
	<select name="vt_typo_settings[body_line_height_unit]">
		<?php foreach ($units as $unit): ?>
			<option value="<?php echo $unit;?>" <?php selected($options['body_line_height_unit'], $unit)?>><?php echo $unit;?></option>
		<?php endforeach; ?>
	</select>
	<?php
}

function vt_header_line_height() {
	$options = vt_get_option( 'vt_typo_settings' );
	$units = array( 'px', 'pt', 'em', '%' );
	?>
	<label> 
		<input name='vt_typo_settings[header_line_height]' type='text' value='<?php echo $options['header_line_height']; ?>' />
	</label>
	<select name="vt_typo_settings[header_line_height_unit]">
		<?php foreach ($units as $unit): ?>
			<option value="<?php echo $unit;?>" <?php selected($options['header_line_height_unit'], $unit)?>><?php echo $unit;?></option>
		<?php endforeach; ?>
	</select>
	<?php
}

function vt_h1_font_size() {
	$options = vt_get_option( 'vt_typo_settings' );
	$units = array( 'px', 'pt', 'em', '%' );
	?>
	<label> 
		<input name='vt_typo_settings[h1_font_size]' type='text' value='<?php echo $options['h1_font_size']; ?>' />
	</label>
	<select name="vt_typo_settings[h1_font_size_unit]">
		<?php foreach ($units as $unit): ?>
			<option value="<?php echo $unit;?>" <?php selected($options['h1_font_size_unit'], $unit)?>><?php echo $unit;?></option>
		<?php endforeach; ?>
	</select>
	<?php
}

function vt_h2_font_size() {
	$options = vt_get_option( 'vt_typo_settings' );
	$units = array( 'px', 'pt', 'em', '%' );
	?>
	<label> 
		<input name='vt_typo_settings[h2_font_size]' type='text' value='<?php echo $options['h2_font_size']; ?>' />
	</label>
	<select name="vt_typo_settings[h2_font_size_unit]">
		<?php foreach ($units as $unit): ?>
			<option value="<?php echo $unit;?>" <?php selected($options['h2_font_size_unit'], $unit)?>><?php echo $unit;?></option>
		<?php endforeach; ?>
	</select>
	<?php
}

function vt_h3_font_size() {
	$options = vt_get_option( 'vt_typo_settings' );
	$units = array( 'px', 'pt', 'em', '%' );
	?>
	<label> 
		<input name='vt_typo_settings[h3_font_size]' type='text' value='<?php echo $options['h3_font_size']; ?>' />
	</label>
	<select name="vt_typo_settings[h3_font_size_unit]">
		<?php foreach ($units as $unit): ?>
			<option value="<?php echo $unit;?>" <?php selected($options['h3_font_size_unit'], $unit)?>><?php echo $unit;?></option>
		<?php endforeach; ?>
	</select>
	<?php
}

function vt_h4_font_size() {
	$options = vt_get_option( 'vt_typo_settings' );
	$units = array( 'px', 'pt', 'em', '%' );
	?>
	<label> 
		<input name='vt_typo_settings[h4_font_size]' type='text' value='<?php echo $options['h4_font_size']; ?>' />
	</label>
	<select name="vt_typo_settings[h4_font_size_unit]">
		<?php foreach ($units as $unit): ?>
			<option value="<?php echo $unit;?>" <?php selected($options['h4_font_size_unit'], $unit)?>><?php echo $unit;?></option>
		<?php endforeach; ?>
	</select>
	<?php
}

function vt_content_area_font_size() {
	$options = vt_get_option( 'vt_typo_settings' );
	$units = array( 'px', 'pt', 'em', '%' );
	?>
	<label> 
		<input name='vt_typo_settings[content_area_font_size]' type='text' value='<?php echo $options['content_area_font_size']; ?>' />
	</label>
	<select name="vt_typo_settings[content_area_font_size_unit]">
		<?php foreach ($units as $unit): ?>
			<option value="<?php echo $unit;?>" <?php selected($options['content_area_font_size_unit'], $unit)?>><?php echo $unit;?></option>
		<?php endforeach; ?>
	</select>
	<?php
}

function vt_content_area_line_height() {
	$options = vt_get_option( 'vt_typo_settings' );
	$units = array( 'px', 'pt', 'em', '%' );
	?>
	<label> 
		<input name='vt_typo_settings[content_area_line_height]' type='text' value='<?php echo $options['content_area_line_height']; ?>' />
	</label>
	<select name="vt_typo_settings[content_area_line_height_unit]">
		<?php foreach ($units as $unit): ?>
			<option value="<?php echo $unit;?>" <?php selected($options['content_area_line_height_unit'], $unit)?>><?php echo $unit;?></option>
		<?php endforeach; ?>
	</select>
	<?php
}

function vt_google_fonts() {
	$general_options = vt_get_option('vt_general_settings');
	if (isset($general_options['google_api_key']) && strlen($general_options['google_api_key'])) {
		$options = vt_get_option('vt_typo_settings');
		$ch = file_get_contents("https://www.googleapis.com/webfonts/v1/webfonts?key=" . $general_options['google_api_key']);
		$fonts = json_decode($ch);
		$items = $fonts->items; ?>
		<select id="vt_gfonts_family" name="vt_typo_settings[google_fonts]">
			<?php foreach ($items as $item): ?> 
				<option value="<?php echo urlencode($item->family); ?>" <?php selected($options['google_fonts'], urlencode($item->family)); ?>><?php echo $item->family; ?></option>
			<?php endforeach; ?>
		</select>
		<div id="more_font_options"></div>
		<?php
	}
	else {
		echo 'You need to enter your Google API key in General settings. You can get one <a href="https://code.google.com/apis/console/">here</a>';
	}
}

function vt_own_fonts () {
	$options = vt_get_option('vt_typo_settings');
	?>
	<label><input name='vt_typo_settings[own_fonts]' type='text' value='<?php echo $options['own_fonts']; ?>' /></label>
	<?php
}

function theme_settings_validate($input) {
	return $input;
}
?>