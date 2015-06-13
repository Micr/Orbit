<?php

add_action( 'widgets_init', 'load_vortex_widgets' );

function load_vortex_widgets() {
	register_widget( 'VT_Twitter_Widget' );
	register_widget( 'VT_Portfolio_Widget' );
	register_widget( 'VT_Last_Posts_Widget' );
	register_widget( 'VT_Google_Maps_Widget' );
}

class VT_Twitter_Widget extends WP_Widget {

	function VT_Twitter_Widget() {

		$widget_ops = array( 'classname' => 'twitter', 'description' => __('This widget displays a user\'s latest tweets', 'twitter') );

		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'twitter-widget' );

		$this->WP_Widget( 'twitter-widget', __('Twitter Widget', 'twitter'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$creds = vt_get_option('vt_general_settings');
		$creds = $creds['twitter_auth'];
		$pass = true;
		foreach ($creds as $cred) {
			if (!isset($cred) || !trim(strlen($cred))) {
				$pass = false;
				break;
			}
		}
		$title = apply_filters('widget_title', $instance['title'] );
		if ($pass) {

			include_once ('codebird.php');
			Codebird::setConsumerKey(trim($creds['consumer_key']), trim($creds['consumer_secret']));

			$cb = Codebird::getInstance();

			$cb->setToken(trim($creds['access_token']), trim($creds['access_token_secret']));

			if (is_numeric($instance['count'])) {
				$count = $instance['count'];
			}
			else $count = 3;

			$reply =  $cb->statuses_userTimeline('count=' . $count);
			
			$output = '';
			
			$now = time();
			
			foreach ($reply as $status) {
				if (!is_object($status)) continue;
				$replaced = preg_replace('/(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?/', '<a href="$0">$0</a>', $status->text);
				$output .= '<div class="vt-tweet"><p>' . $replaced . '</p>';
				$tweet_time = strtotime($status->created_at);
				$gap = $now - $tweet_time;
				$arr = array(
					'year' => YEAR_IN_SECONDS,
					'week' => WEEK_IN_SECONDS, 
					'day' => DAY_IN_SECONDS, 
					'hour' => HOUR_IN_SECONDS, 
					'minute' => MINUTE_IN_SECONDS
				);
				foreach ($arr as $key => $value) {
					$number = $gap/$value;
					if ($number >= 1 && $number < 2) {
						$output .= '<p class="twitter_time"> About 1 ' . $key . ' ago</p>';
						break;
					}
					elseif ($number >= 2) {
						$output .= '<p class="twitter_time"> About ' . floor($number) . ' ' . $key . 's' . ' ago</p>';
						break;
					}
					elseif ($key == 'minute' && $number < 1) {
						if ($gap == 1)
							$output .= '<p class="twitter_time"> About 1 second ago</p>';
						else
							$output .= '<p class="twitter_time"> About ' . $gap . ' seconds ago</p>';
						break;
					}
				}

				$output .= "</div>";
			}
			
			echo $before_widget;

			if ( $title )
				echo $before_title . $title . $after_title;

			echo $output;

			echo $after_widget;
		}
		else
		{

			echo $before_widget;
			if ( $title )
				echo $before_title . $title . $after_title;

			echo '<p> Supply your Twitter authorization fields to see your tweets </p>'.$after_widget;
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = $new_instance['title'];
		$instance['count'] = strip_tags( $new_instance['count'] );

		return $instance;
	}

	function form( $instance ) {

		$defaults = array( 'title' => __('Twitter Status', 'twitter'), 'count' => '3');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e('Number of tweets:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" style="width:100%;" />
		</p>
	<?php
	}
}

class VT_Last_Posts_Widget extends WP_Widget {

	function VT_Last_Posts_Widget() {

		$widget_ops = array( 'classname' => 'last_posts', 'description' => __('This widget displays last posts with an exrept and a thumbnail', 'vortex') );

		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'last-posts-widget' );

		$this->WP_Widget( 'last-posts-widget', __('Latest Posts', 'vortex'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', $instance['title'] );
		echo $before_widget;

		if ( $title && ($instance['variant'] == '1' || ($instance['variant'] == '2' && $instance['controls'] == 2)) ) {
			echo $before_title . $title . $after_title;
		}

		if($instance['variant'] == '1') {
			$query = new WP_Query('posts_per_page=' . $instance['number']);
			if ($query->have_posts()) {
				while ( $query->have_posts()) {
					echo '<div class="latest_post clearfix">';
					$query->next_post(); 
					if (has_post_thumbnail($query->post->ID)) {
						echo '<a class="latest_posts_img" href="' . get_permalink($query->post->ID) .'" >' . get_the_post_thumbnail($query->post->ID, array(50,50)).'</a>';
					}
					echo '<h4 class=""><a class="" href="' . get_permalink($query->post->ID). '" >' . get_the_title($query->post->ID) .'</a></h4>';
					echo '<div>' . date("F j, Y", strtotime($query->posts[$query->current_post]->post_date)) . '</div>';
					echo '</div>';
				}
			}
		}
		elseif ($instance['variant'] == '2') {

			$data = array(
				'width' => 220
			);

			$controls = '';

			if ($instance['controls'] == 1) {
				$data = array_merge($data, array(
					'top' => "true",
				));
				$controls = '<div class="top_controls"><h2 class="top-controls-title">' . $title . '</h2><div class="controls-holder"><a class="cust-bx-prev"></a><a class="cust-bx-next" ></a></div></div>';
			}
			$data = json_encode($data);
			$result = '<div class="carousel_wrapper lp-shortcode">' . $controls;
			$result .= '<div class="carousel" data-options=\'' . $data . '\'>';
			$query = new WP_Query('posts_per_page=' . $instance['number']);
			if ($query->have_posts()) {
				while ( $query->have_posts()) {
					$result .= '<div class="caro_item">';
						$query->next_post(); 
						if (has_post_thumbnail($query->post->ID)) {
							$result .= '<div class="caro-image"><a href="' . get_permalink($query->post->ID) . '"><img class="icon" src="' . get_template_directory_uri() . '/images/link.png" alt="link icon" /></a>';
							$result .= '<a class="carousel-img-cover" href="' . get_permalink($query->post->ID) .'" ></a>';
							$result .= '<a href="' . get_permalink($query->post->ID) .'" >' . get_the_post_thumbnail($query->post->ID, 'lp_shortcode').'</a></div>';
						}
							$result .= '<h3 class="post-title carousel-item-title"><a class="show" href="' . get_permalink($query->post->ID). '" >' . get_the_title($query->post->ID) .'</a></h3>';
							$result .= '<div class="lp-shortcode-excerpt">' . strip_tags(mb_substr($query->posts[$query->current_post]->post_content, 0, 30), '<p><a><b><strong><i>') . '<a class="lp_more" href="' . get_permalink($query->post->ID) .'" >&hellip;<span>(More)</span></a></div>';
					$result .= '</div>';
				}
				echo $result . '</div></div>';
			}
		}
		else
		{
			echo '<p> There is no posts </p>';
		}
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = $new_instance['title'];
		$instance['number'] = strip_tags( $new_instance['number'] );
		$instance['variant'] = strip_tags( $new_instance['variant'] );
		$instance['controls'] = strip_tags( $new_instance['controls'] );

		return $instance;
	}

	function form( $instance ) {

		$defaults = array( 'title' => __('Latest posts', 'vortex'), 'variant' => '1', 'controls' => 'top', 'number' => '4');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e('Number of posts:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" style="width:100%;" />
		</p>

		<label for="<?php echo $this->get_field_id( 'variant' ); ?>"><?php _e('Variant:', 'hybrid'); ?></label>
		<select id="<?php echo $this->get_field_id( 'variant' ); ?>" name="<?php echo $this->get_field_name( 'variant' ); ?>">
			<option value="1" <?php selected($instance['variant'], 1); ?>>Small widget</option>
			<option value="2" <?php selected($instance['variant'], 2); ?>>Big widget</option>
		</select>
		<label for="<?php echo $this->get_field_id( 'controls' ); ?>"><?php _e('Controls:', 'hybrid'); ?></label>
		<select id="<?php echo $this->get_field_id( 'controls' ); ?>" name="<?php echo $this->get_field_name( 'controls' ); ?>">
			<option value="1" <?php selected($instance['controls'], 1); ?>>Top</option>
			<option value="2" <?php selected($instance['controls'], 2); ?>>Sides</option>
		</select>

		<?php
	}
}

class VT_Portfolio_Widget extends WP_Widget {

	function VT_Portfolio_Widget() {

		$widget_ops = array( 'classname' => 'portfolio_widget', 'description' => __('This widget displays last portfolio projects in a carousel', 'vortex') );

		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'portfolio-widget' );

		$this->WP_Widget( 'portfolio-widget', __('Portfolio', 'vortex'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', $instance['title'] );
		echo $before_widget;

		if ( $title && ($instance['variant'] == '1' || ($instance['variant'] == '2' && $instance['controls'] == 2)) ) {
			echo $before_title . $title . $after_title;
		}

		if($instance['variant'] == '1') {
			$query = new WP_Query('posts_per_page=' . $instance['number'] . '&post_type=portfolio');
			if ($query->have_posts()) {
				while ( $query->have_posts()) {
					echo '<div class="latest_post clearfix">';
					$query->next_post(); 
					if (has_post_thumbnail($query->post->ID)) {
						echo '<a class="latest_posts_img" href="' . get_permalink($query->post->ID) .'" >' . get_the_post_thumbnail($query->post->ID, array(50,50)).'</a>';
					}
					echo '<h4 class=""><a class="" href="' . get_permalink($query->post->ID). '" >' . get_the_title($query->post->ID) .'</a></h4>';
					echo '<div>' . date("F j, Y", strtotime($query->posts[$query->current_post]->post_date)) . '</div>';
					echo '</div>';
				}
			}
		}
		elseif ($instance['variant'] == '2') {

			$data = array(
				'width' => 220
			);

			$controls = '';

			if ($instance['controls'] == 1) {
				$data = array_merge($data, array(
					'top' => "true",
				));
				$controls = '<div class="top_controls"><h2 class="top-controls-title">' . $title . '</h2><div class="controls-holder"><a class="cust-bx-prev"></a><a class="cust-bx-next" ></a></div></div>';
			}
			$data = json_encode($data);
			$result = '<div class="carousel_wrapper lp-shortcode">' . $controls;
			$result .= '<div class="carousel" data-options=\'' . $data . '\'>';
			$query = new WP_Query('posts_per_page=' . $instance['number'] . '&post_type=portfolio');
			if ($query->have_posts()) {
				while ( $query->have_posts()) {
					$result .= '<div class="caro_item">';
						$query->next_post(); 
						if (has_post_thumbnail($query->post->ID)) {
							$result .= '<div class="caro-image"><a href="' . get_permalink($query->post->ID) . '"><img class="icon" src="' . get_template_directory_uri() . '/images/link.png" alt="link icon" /></a>';
							$result .= '<a class="carousel-img-cover" href="' . get_permalink($query->post->ID) .'" ></a>';
							$result .= '<a href="' . get_permalink($query->post->ID) .'" >' . get_the_post_thumbnail($query->post->ID, 'lp_shortcode').'</a></div>';
						}
							$result .= '<h3 class="carousel-item-title"><a class="show" href="' . get_permalink($query->post->ID). '" >' . get_the_title($query->post->ID) .'</a></h3>';
					$result .= '</div>';
				}
				echo $result . '</div></div>';
			}
		}
		else
		{
			echo '<p> There is no projects </p>';
		}
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = $new_instance['title'];
		$instance['number'] = strip_tags( $new_instance['number'] );
		$instance['variant'] = strip_tags( $new_instance['variant'] );
		$instance['controls'] = strip_tags( $new_instance['controls'] );

		return $instance;
	}

	function form( $instance ) {

		$defaults = array( 'title' => __('Portfolio', 'vortex'), 'variant' => '1', 'controls' => 'top', 'number' => '4');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'vortex'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e('Number of projects to show:', 'vortex'); ?></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" style="width:100%;" />
		</p>

		<label for="<?php echo $this->get_field_id( 'variant' ); ?>"><?php _e('Variant:', 'vortex'); ?></label>
		<select id="<?php echo $this->get_field_id( 'variant' ); ?>" name="<?php echo $this->get_field_name( 'variant' ); ?>">
			<option value="1" <?php selected($instance['variant'], 1); ?>>Small widget</option>
			<option value="2" <?php selected($instance['variant'], 2); ?>>Carousel</option>
		</select>
		<label for="<?php echo $this->get_field_id( 'controls' ); ?>"><?php _e('Controls:', 'vortex'); ?></label>
		<select id="<?php echo $this->get_field_id( 'controls' ); ?>" name="<?php echo $this->get_field_name( 'controls' ); ?>">
			<option value="1" <?php selected($instance['controls'], 1); ?>>Top</option>
			<option value="2" <?php selected($instance['controls'], 2); ?>>Sides</option>
		</select>

		<?php
	}
}

class VT_Google_Maps_Widget extends WP_Widget {

	function VT_Google_Maps_Widget() {

		$widget_ops = array( 'classname' => 'google_maps_widget', 'description' => __('Google Maps widget', 'vortex') );

		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'google_maps-widget' );

		$this->WP_Widget( 'google_maps-widget', __('Google Maps Widget', 'vortex'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		vt_enqueue_google_maps();
		extract( $args );
		$creds = vt_get_option('vt_general_settings');
		$creds = $creds['google_api_key'];
		$title = apply_filters('widget_title', $instance['title'] );
		if ($creds) {

			echo $before_widget;

			if ( $title )
				echo $before_title . $title . $after_title;
			$latitude = '"latitude":' . ' "' . $instance['latitude'] . '"';
			$longitude = '"longitude":' . ' "' . $instance['longitude'] . '"';
			$zoom = '"zoom": ' . $instance['zoom'];

			echo '<div class="google_maps" style="height:' . (int)$instance['height'] . 'px;" data-coordinates=\'{' . $latitude . ', ' . $longitude . ', ' . $zoom . '}\'></div>';

			echo '<div class="mt20">' . wpautop($instance['text']) . '</div>';

			echo $after_widget;
		}
		else
		{

			echo $before_widget;
			if ( $title )
				echo $before_title . $title . $after_title;

			echo '<p>Supply Google API key</p>'.$after_widget;
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] =  $new_instance['title'];
		$instance['height'] = strip_tags( $new_instance['height'] );
		$instance['text'] =  $new_instance['text'];
		$instance['latitude'] = strip_tags( $new_instance['latitude'] );
		$instance['longitude'] = strip_tags( $new_instance['longitude'] );
		$instance['zoom'] = strip_tags( $new_instance['zoom'] );

		return $instance;
	}

	function form( $instance ) {

		$defaults = array( 'title' => __('Google Maps', 'vortex'), 
			'height' => '200', 
			'text' => '', 
			'latitude' => '',
			'longitude' => '',
			'zoom' => 15
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'latitude' ); ?>"><?php _e('Latitude:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'latitude' ); ?>" name="<?php echo $this->get_field_name( 'latitude' ); ?>" value="<?php echo $instance['latitude']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'longitude' ); ?>"><?php _e('Longitude:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'longitude' ); ?>" name="<?php echo $this->get_field_name( 'longitude' ); ?>" value="<?php echo $instance['longitude']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'zoom' ); ?>"><?php _e('Zoom:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'zoom' ); ?>" name="<?php echo $this->get_field_name( 'zoom' ); ?>" value="<?php echo $instance['zoom']; ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e('Height:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" value="<?php echo $instance['height']; ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e('Text:', 'hybrid'); ?></label>
			<textarea id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" style="width:100%;" ><?php echo $instance['text']; ?></textarea>
		</p>
	<?php
	}
}

?>