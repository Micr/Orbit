<?php

add_action( 'add_meta_boxes', 'vt_flexslider_metabox' );
add_action( 'save_post', 'vt_slider_transition_save' );
add_action('admin_init','my_meta_init');

function my_meta_init () {
	if (isset($_GET['post']) || isset($_POST['post_ID'])) {
		$post_id = isset($_GET['post']) ? $_GET['post'] : $_POST['post_ID'] ;
		$template_file = get_post_meta($post_id,'_wp_page_template',TRUE);

		if ($template_file == 'contact.php') {
			add_action( 'add_meta_boxes', 'vt_contact_metabox' );
			add_action( 'save_post', 'vt_contact_page_save' );
		}
	}
}

function vt_flexslider_metabox() {
	add_meta_box(
		'mb_option_transition',
		__( 'Slider Options', 'vortex' ),
		'vt_render_slider_metabox',
		'flexslider'
	);
}

function vt_render_slider_metabox( $post ) {

	wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );

	if (isset($_REQUEST['post'])) {
		$transition = get_post_meta( $_REQUEST['post'], $key = 'transition', $single = true );
		$allowed_pages = get_post_meta( $_REQUEST['post'], $key = 'allowed_pages', $single = true );
	}
	else {
		$transition = 'fade';
		$allowed_pages = array('fpage');
	}

	$query = new WP_Query("post_type=page&posts_per_page=-1");

	$pages = array();
	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->next_post();
			$pages[$query->post->ID] = $query->post->post_title;
		}
	}

	$allowed_array = array(
		'fpage' => 'Frontpage',
		'blog' => 'Blog index page',
		'portpage' => 'Portfolio index page',
		'portipage' => 'Portfolio item page',
		'cpage' => 'Category page',
		'tpage' => 'Tag page',
		'apage' => 'Archive page',
		'spage' => 'Search page',
		'upage' => 'Author page',
		'4page' => '404 page',
		'post' => 'Single post',
		'page_array' => $pages
	);

	echo '<label for="allowed_pages">';
	_e("Show slider on following pages (hold down Control/Command key to select multiple values):", 'vortex' );
	echo '</label> ';

	?>
		<select id="allowed_pages" name="allowed_pages[]" multiple="multiple">
			<?php foreach ($allowed_array as $slug => $value): ?>
				<?php if ($slug == 'page_array'): ?>
					<?php foreach ($pages as $id => $title): ?>
						<option value="<?php echo $id; ?>" <?php if ($allowed_pages) selected(in_array($id, $allowed_pages)); ?>><?php echo $title; ?></option>
					<?php endforeach; ?>
				<?php else: ?>
				<option value="<?php echo $slug; ?>" <?php if ($allowed_pages) selected(in_array($slug, $allowed_pages)); ?>><?php echo $value; ?></option>
				<?php endif; ?>
			<?php endforeach; ?>
		</select>

	<?php
	echo '<label for="slider_transition">';
	_e("Transition type", 'vortex' );
	echo '</label> ';
	?>
	<select id="slider_transition" name="slider_transition">
		<option value="slide" <?php echo selected(esc_attr($transition), 'slide'); ?>>Slide</option>
		<option value="fade" <?php echo selected(esc_attr($transition), 'fade'); ?>>Fade</option>
	</select>
  <?php
}

function vt_slider_transition_save( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return;

	if ( !isset( $_POST['myplugin_noncename'] ) || !wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename( __FILE__ ) ) )
		return;

	if ( !current_user_can( 'edit_themes', $post_id ) )
		return;

	$post_ID = $_POST['post_ID'];
	$mydata = sanitize_text_field( $_POST['slider_transition'] ); 
	$allow_pages = array_map('sanitize_text_field', $_POST['allowed_pages']);

	add_post_meta($post_ID, 'transition', $mydata, true) or
	update_post_meta($post_ID, 'transition', $mydata);
	add_post_meta($post_ID, 'allowed_pages', $allow_pages, true) or
	update_post_meta($post_ID, 'allowed_pages', $allow_pages);

}

function vt_contact_metabox() {
	add_meta_box(
		'mb_option_contact',
		__( 'Contact Page Options', 'vortex' ),
		'vt_render_contact_metabox',
		'page'
	);
}

function vt_render_contact_metabox( $post ) {

	wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );

	$disable = get_post_meta( $_REQUEST['post'], $key = 'disable_google_map', $single = true );
	$latitude = get_post_meta( $_REQUEST['post'], $key = 'latitude', $single = true );
	$longitude = get_post_meta( $_REQUEST['post'], $key = 'longitude', $single = true );
	$zoom = get_post_meta( $_REQUEST['post'], $key = 'zoom', $single = true );
	?>
	<h2>Google Map Options</h2>
	<label><input type="checkbox" name="disable_google_map" <?php checked(!empty($disable)); ?> /> Disable Google Map</label><br/>
	<label><input type="text" name="latitude" value="<?php echo trim($latitude); ?>" /> Latitude</label><br/>
	<label><input type="text" name="longitude" value="<?php echo trim($longitude); ?>" /> Longitude</label><br/>
	<label><input type="text" name="zoom" value="<?php echo trim($zoom); ?>" /> Zoom</label><br/>
	<?php
}

function vt_contact_page_save( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return;

	if ( !isset( $_POST['myplugin_noncename'] ) || !wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename( __FILE__ ) ) )
		return;

	if ( !current_user_can( 'edit_pages', $post_id ) )
		return;

	$post_ID = $_POST['post_ID'];

	if (isset($_POST['disable_google_map'])) {
		add_post_meta($post_ID, 'disable_google_map', 'vortex', true);
	}
	else {
		delete_post_meta($post_ID, 'disable_google_map');
	}

	$mydata = sanitize_text_field( $_POST['latitude'] );

	add_post_meta($post_ID, 'latitude', $mydata, true) or
	update_post_meta($post_ID, 'latitude', $mydata);

	$mydata = sanitize_text_field( $_POST['longitude'] );

	add_post_meta($post_ID, 'longitude', $mydata, true) or
	update_post_meta($post_ID, 'longitude', $mydata);

	$mydata = sanitize_text_field( $_POST['zoom'] );

	add_post_meta($post_ID, 'zoom', $mydata, true) or
	update_post_meta($post_ID, 'zoom', $mydata);
}
?>