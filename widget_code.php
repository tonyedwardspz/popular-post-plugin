<?php

class Portfolio_Popular_Widget extends WP_Widget {
	// constructor for the widget
	public function __construct() {
		// widget actual processes
		parent::__construct(
			'portfolio_popular_widget', //unique ID
			'Popular Posts', // Title of the widget
			array('description' => __('Displays the popular posts'))// array of settings
		);
	}
	public function form( $instance ) {
		// outputs the options form on admin

		//get the set title or assign default
		$title = (isset($instance['title'])) ? $instance['title'] : 'Popular Posts';
		
		// create the widget for the admin area
		?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title: '); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
					   name="<?php echo $this->get_field_name('title'); ?>"
					   type="text" value="<?php echo esc_attr('title'); ?>" />
			</p>
		<?php
	}
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = array();
		$instance['title'] = strip_tags($new_instance['title']); // remove potentially malicious code
		return $instance;
	}
	public function widget( $args, $instance ) {
		popular_poularity_list();
	}
}
register_widget( 'Portfolio_Popular_Widget' );

?>