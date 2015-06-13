<?php

function vt_accordion( $atts, $content ) {
	$result = do_shortcode($content);
		return '<div class="accordion">' . vt_replacer($result) . '</div>';
}

function vt_accordion_section( $atts, $content ) {
	extract( shortcode_atts( array(
	'title' => 'accordion section',
	), $atts ) );

	$result = do_shortcode($content);
	return '<h3>' . $title . '</h3>' . '<div>' . $result . '</div>';
}

function vt_blockquote ($atts, $content) {

	extract( shortcode_atts( array(
	'title' => 'author',
	), $atts ) );

	return vt_replacer('<blockquote><p>'.$content.'</p><small title="'.$title.'" >'.$title.'</small></blockquote>');
}

function vt_button ($atts, $content) {

	extract( shortcode_atts( array(
	'type' => '',
	), $atts ) );

	switch ($type) {
		case 'primary':
			$class = 'btn-primary';
			break;
		case 'info':
			$class = 'btn-info';
			break;
		case 'danger':
			$class = 'btn-danger';
			break;
		case 'success':
			$class = 'btn-success';
			break;
		case 'warning':
			$class = 'btn-warning';
			break;
		case 'inverse':
			$class = 'btn-inverse';
			break;
		default:
			$class = '';
	}
	return vt_replacer('<button class="btn ' . $class . '">' . $content . '</button>');
}

//Google Maps Shortcode
function vt_google_maps ($atts){
	vt_enqueue_google_maps();
	extract( shortcode_atts( array(
	'title' => '',
	'height' => '380',
	'width' => '500',
	'latitude' => '',
	'longitude' => '',
	'zoom' => '15'
	), $atts ) );

	$zoom = '"zoom": ' . $zoom;
	$latitude = '"latitude":' . ' "' . $latitude . '"';
	$longitude = '"longitude":' . ' "' . $longitude . '"';
	$title = '<h1>' . $title . '</h1>';
	return $title . '<div class="google_maps" style="width:' . $width . 'px;height:' . $height . 'px;" data-coordinates=\'{' . $latitude . ',' . $longitude . ',' . $zoom . '}\'></div>';
}

function vt_videos ($atts) {
	extract( shortcode_atts( array(
	'id' => 'YE7VzlLtp-4',
	'site' => 'youtube',
	'title' => ''
	), $atts ) );
	$title = '<h1>' . $title . '</h1>';
	$site = str_replace(' ', '', strtolower($site));
	if ($site == 'youtube'){
		if (substr($id, 0, 6) == '<ifram') {
			return $title . '<div class="embedded_video">' . $id . '</div>';
		}
		else {
			return $title . '<div class="embedded_video"><iframe width="420" height="315" src="http://www.youtube.com/embed/' . $id . '" frameborder="0" allowfullscreen></iframe></div>';
		}
	}
	elseif ($site == 'vimeo'){
		if (substr($id, 0, 6) == '<ifram'){
			return $title . '<div class="embedded_video">' . $id . '</div>';
		}
		else{
			return $title . '<div class="embedded_video"><iframe src="http://player.vimeo.com/video/' . $id . '" width="500" height="281" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>';
		}
	}
}

function vt_recent_posts ($atts) {
 return '';
}

function vt_tabs_shortcode ($atts, $content) {
	extract( shortcode_atts( array(
		'size' => '1/1',
		'title' => ''
	), $atts ) );

	if ($title) {
		$title = '<h1>' . $title . '</h1>';
	}

	$results = vt_replacer(do_shortcode($content));
	$results = explode('vortex_end_tab', $results);
	array_pop($results);
	$nav_tabs = $title . '<div class="tab_widget"><ul class="nav nav-tabs clearfix">';
	$tab_content = '<div class="tab-content">';
	foreach($results as $result) {
		$result = json_decode($result);
		$nav_tabs .= $result->title;
		$tab_content .= $result->result;
	}
	$nav_tabs .= '</ul>';
	$tab_content .= '</div>';
	return vt_replacer($nav_tabs . $tab_content .'</div>');
}

function vt_tab_shortcode ($atts, $content) {
	extract( shortcode_atts( array(
		'title' => 'tab',
		'active' => 'false'
	), $atts ) );

	$active = trim($active);
	$undtitle = str_replace(' ', '_', $title);
	$result = do_shortcode($content);
	$title = '<li' . ($active == 'true'? ' class="active"': '') . '><a href="#' . $undtitle . '" data-toggle="tab" >' . $title . '</a></li>';
	$result = '<div class="tab-pane' . ($active == 'true'? ' active': '') . '" id="' . $undtitle . '">' . $result . '</div>';
	return json_encode(array( 'title' => $title, 'result' => $result)) . 'vortex_end_tab';
}

function vt_column_shortcode ($atts, $content) {
	extract( shortcode_atts( array(
		'size' => '1/1',
		'title' => '',
		'style' => '',
		'type' => '',
		'do_shortcode' => ''
	), $atts ) );

	if ($style) $style = 'style="' . $style . '"';
	if (empty($do_shortcode)) {
		$result = do_shortcode($content);
	}
	else {
		$result = $content;
	}

	switch ($size) {
		case '1/1':
		$size = 'span12';
		break;
		case '3/4':
		$size = 'span9';
		break;
		case '2/3':
		$size = 'span8';
		break;
		case '1/2':
		$size = 'span6';
		break;
		case '5/12':
		$size = 'span5';
		break;
		case '1/3':
		$size = 'span4';
		break;
		case '1/4':
		$size = 'span3';
		break;
		case '1/6':
		$size = 'span2';
		break;
		case '1/12':
		$size = 'span1';
		break;
	}
	$title = $title ? '<h1>' . $title . '</h1>': '';
	if ($type) return vt_replacer('<div class="well" ' . $style . '>' . $title . $result . '</div>');
	return vt_replacer('<div class="' . $size . '" ' . $style . '>' . $title . $result . '</div>');
}

function vt_icon_box_shortcode ($atts, $content) {
	extract( shortcode_atts( array(
		'icon' => 'icon-circle',
		'size' => ''
	), $atts ) );
	return '<div class="icon_box span3"><p class="pagination-centered"><i class="ib_main_icon ' . $icon . (strlen($size) ? ' ' . $size : '') . '"></i></p><p class="icon_box_p">' . $content . '</p></div>';
}

function vt_row_shortcode($atts, $content) {
	return '<div class="row">' . vt_replacer(do_shortcode($content)) . '</div>';
}

function vt_divider_shortcode ($atts) {
	extract( shortcode_atts( array(
		'size' => '1/1',
		'style' => 'stripes'
	), $atts ) );
	return '<div class="divider-' . $style . '"></div>';
}

function vt_carousel_shortcode ($atts, $content, $tag) {

	$options = vt_get_option('vt_general_settings');
	$blog_options = vt_get_option('vt_blog_settings');
	$port_options = vt_get_option('vt_portfolio_settings');

	extract( shortcode_atts( array(
		'controls' => '',
		'title' => '',
		'amount' => '-1',
		'width' => 220,
		'max_items' => 4,
		'item_margin' => 20,
		'move_slides' => 2
	), $atts ) );

	$data = array(
		'width' => $width,
		'max_items' => $max_items,
		'item_margin' => $item_margin,
		'move_slides' => $move_slides
	);

	if ($controls) {
		$controls = '<div class="top_controls"><h2 class="top-controls-title">' . $title . '</h2><div class="controls-holder"><a class="cust-bx-prev"></a><a class="cust-bx-next" ></a></div></div>';
		$data = array_merge($data, array(
			'top' => "true",
		));
	}
	else {
		$controls = '';
	}
	$data = json_encode($data);
	if ($tag == 'latest_posts') {
		$result = '<div class="carousel_wrapper lp-shortcode">'  . $controls . '<div class="carousel" data-options=\'' . $data . '\'>';
		$query = new WP_Query('posts_per_page=12');

		if ($query->have_posts()) {
			while ( $query->have_posts()) {
				$result .= '<div class="caro_item" >';
					$query->next_post(); 

					if (has_post_thumbnail($query->post->ID)) {
						$result .= '<div class="caro-image"><a href="' . get_permalink($query->post->ID) . '"><img class="icon" src="' . get_template_directory_uri() . '/images/link.png" alt="carousel item" /></a>
						<a class="carousel-img-cover" href="' . get_permalink($query->post->ID) .'" ></a>
						<a href="' . get_permalink($query->post->ID) .'" >' . get_the_post_thumbnail($query->post->ID, 'lp_shortcode').'</a></div>';
					}
						$result .= '<h3 class="carousel-item-title" ><a class="show" href="' . get_permalink($query->post->ID). '" >' . get_the_title($query->post->ID) .'</a></h3>';
						$result .= '<div class="lp-shortcode-excerpt">' . strip_tags(mb_substr($query->posts[$query->current_post]->post_content, 0, 30), '<p><a><b><strong><i>') . '<a href="' . get_permalink($query->post->ID) .'" >&hellip;<span class="lp_more">(More)</span></a></div>';
				$result .= '</div>';
			}
			$result .= '</div></div>';
		}
		else
		{
			$result = '<p> There is no posts </p>';
		}
	}
	elseif ($tag == 'carousel') {
		$inner = do_shortcode($content);
		$string = '<h1 class="vt-shortcode-title">' . $title . '</h1><div class="carousel_wrapper" >' . $controls;
		$string .= '<ul class="carousel" data-options=\'' . $data . '\'>';
		$string .= $inner . '</ul></div>';
		$result = vt_replacer($string);
	}
	else {
		$string = '<div class="carousel_wrapper portfolio-shortcode">'. $controls;
		$string .= '<ul class="carousel" data-options=\'' . $data . '\'>';
		$the_query = new WP_Query( array('post_type' => 'portfolio', 'posts_per_page' => $amount) );

		while ( $the_query->have_posts() ) :
			$the_query->next_post();
			$tbnl = get_the_post_thumbnail($the_query->post->ID, 'lp_shortcode');
			if (empty($tbnl)) $tbnl = '<img src="' . get_template_directory_uri() . '/images/missing_thumbnail.png" />';
			$string .= '<li class="caro_item"><div class="caro-image"><a href="' . get_permalink($the_query->post->ID) . '"><img class="icon" src="' . get_template_directory_uri() . '/images/link.png" alt="carousel item" /></a>';
			$string .= '<a class="carousel-img-cover" href="' . get_permalink($the_query->post->ID) .'" ></a>';
			$string .= '<a href="' . get_permalink($the_query->post->ID) . '">' . $tbnl . '</a></div><div><h3 class="carousel-item-title" ><a href="' . get_permalink($the_query->post->ID) . '">' . $the_query->post->post_title . '</a></h3></div></li>';
		endwhile;

		$result = $string . '</ul></div>';
	}

	return $result;
}

function vt_carousel_item_shortcode ($atts, $content) {

	extract( shortcode_atts( array(
	'title' => '',
	'alt' => ''
	), $atts ) );

	$result = '<li class="caro_item">' . '<img src="' . $content . '" title="' . $title . '" alt="' . $alt . '" />' . '</li>';
	return $result;
}

function vt_contact_form_shortcode () {
	if( isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['message'])) {
		$to_email = get_option( 'admin_email' );
		$subject = ( empty( $_POST['subject'] ) ? '(no subject)' : esc_attr( $_POST['subject'] ) );
		$from_name = esc_attr( $_POST['sender_name'] );
		$from_email = esc_attr( $_POST['email'] );
		$message = esc_attr( $_POST['message'] );
		$headers = 'From: ' . $from_name . ' <' . $from_email . '>' . "\r\n";
		mail( $to_email, $subject, $message, $headers );
		$result = '<div class="alert alert-success" ><button type="button" class="close" data-dismiss="alert">&times;</button>Your email have been sent succesfully!</div>';
		return $result;
	}

	$form = '<div id="respond" class="contact_form">';
	if( isset($_POST['submit'])) {
		if (empty($_POST['email'])) $form .= '<div class="alert alert-error" ><button type="button" class="close" data-dismiss="alert">&times;</button>You forgot to specify your email address</div>';
		elseif (empty($_POST['message'])) $form .= '<div class="alert alert-error" ><button type="button" class="close" data-dismiss="alert">&times;</button>You forgot to enter the message</div>';
	}
	$form .= '<form id="commentform" method="post" action="' . get_permalink() . '">';
	$form .= '<p class="comment-notes">Your email address will not be published. Required fields are marked <span class="required">*</span></p>';
	$form .= '<p class="comment-form-author"><label for="author">Name <span class="required">*</span></label> <input type="text" aria-required="true" size="30" value="" name="sender_name" id="author" placeholder="Name" ></p>';
	$form .= '<p class="comment-form-email"><label for="email">Email <span class="required">*</span></label> <input type="text" aria-required="true" size="30" value="" name="email" id="email" placeholder="Email" ></p>';
	$form .= '<p class="comment-form-email"><label for="subject">Subject </label><input type="text" aria-required="true" size="30" value="" name="subject" id="subject" placeholder="Subject" ></p>';
	$form .= '<p class="comment-form-comment"><label for="comment">Message</label><textarea aria-required="true" rows="8" cols="45" name="message" id="comment"></textarea></p>';
	$form .= '<p class="form-submit">';
	$form .= '<input type="hidden" name="submit" value="1" />';
	$form .= '<input type="submit" value="Send E-mail" id="submit" />';
	$form .= '</p></form></div>';
	return $form;
}

add_shortcode( 'vt_contact', 'vt_contact_form_shortcode' );
add_shortcode( 'carousel_item', 'vt_carousel_item_shortcode' );
add_shortcode( 'carousel', 'vt_carousel_shortcode' );
add_shortcode( 'latest_posts', 'vt_carousel_shortcode' );
add_shortcode( 'divider', 'vt_divider_shortcode' );
add_shortcode( 'row', 'vt_row_shortcode' );
add_shortcode( 'icon_box', 'vt_icon_box_shortcode' );
add_shortcode( 'column', 'vt_column_shortcode' );
add_shortcode( 'tab', 'vt_tab_shortcode' );
add_shortcode( 'tabs', 'vt_tabs_shortcode' );
add_shortcode( 'recent_posts', 'recent_posts' );
add_shortcode( 'portfolio', 'vt_carousel_shortcode' );
add_shortcode( 'video', 'vt_videos' );
add_shortcode( 'google_maps', 'vt_google_maps' );
add_shortcode( 'button', 'vt_button' );
add_shortcode( 'blockquote', 'vt_blockquote' );
add_shortcode( 'accordion', 'vt_accordion' );
add_shortcode( 'accordion_section', 'vt_accordion_section' );

?>