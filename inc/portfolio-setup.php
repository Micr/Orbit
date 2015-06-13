<?php 
add_action('init', 'portfolio_register');

function portfolio_register() {
	$args = array(
		'label' => __('Portfolio'),
		'singular_label' => __('Project'),
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'menu_icon' => get_template_directory_uri() . "/images/port.png",
		'hierarchical' => false,
		'rewrite' => true,
		'has_archive' => true,
		'supports' => array('title', 'editor', 'thumbnail')    
	);

	register_post_type( 'portfolio' , $args );
}

	register_taxonomy("project-type", array("portfolio"), array("hierarchical" => true));

add_filter("manage_portfolio_posts_columns", "project_edit_columns");

function project_edit_columns($columns){
		$columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => "Project",
			"thumbnail" => "Featured Image",
			"description" => "Description",
			"type" => "Type of Project",
		);
	
		return $columns;
}    
  
add_action("manage_posts_custom_column",  "project_custom_columns");   
	
function project_custom_columns($column){
	global $post;
	switch ($column)
	{
		case "description":
			the_excerpt();
			break;
		case "type":
			echo get_the_term_list($post->ID, 'project-type', '', ', ','');
			break;
		case "thumbnail":
			echo the_post_thumbnail('lp_shortcode');
			break;
	}    
}   


add_filter('excerpt_length', 'my_excerpt_length');
  
function my_excerpt_length($length) {

	return 50;

}  
function portfolio_thumbnail_url($pid){
	$image_id = get_post_thumbnail_id($pid);
	$image_url = wp_get_attachment_image_src($image_id,'fullsize');
	$image_url = $image_url[0];
	return $image_url;
}
?>