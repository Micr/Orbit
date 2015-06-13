<?php

	add_action('init', 'vt_flexslider_register');

	function vt_flexslider_register() {
		$args = array(
			'label' => __('Flexslider'),
			'singular_label' => __('Flexslider'),
			'menu_icon' => get_template_directory_uri() . "/images/slidericon.png",
			'public' => true,
			'publicly_queryable' => false,
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => true,
			'has_archive' => true,
			'supports' => array('title', 'editor', 'thumbnail')    
		);

		register_post_type( 'flexslider' , $args );
	}

?>