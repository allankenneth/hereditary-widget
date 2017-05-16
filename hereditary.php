<?php
/*
Plugin Name: hereditary widget
Plugin URI: http://hereditary.allankenneth.com
Description: Hereditary widget
Author: Allan
Version: 1
Author URI: https://allankenneth.com
*/

class Hereditary_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'hereditary_widget',
			'description' => 'Hereditary Widget. Show Child/Sibling pages as a menu.',
		);
		parent::__construct( 'hereditary_widget', 'Hereditary Widget', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		$queried_object = get_queried_object();
		if ( $queried_object ) {
		    $post_id = $queried_object->ID;
		}
		$children = get_pages('child_of='.$post_id);
		$parent = $queried_object->post_parent;
		$siblings =  get_pages('child_of='.$parent);
		if( count($children) != 0) {
			$hereditary = array(
				'depth' => 1,
				'exclude' => $excludes,
				'title_li' => '',
				'child_of' => $post_id,
			);
		// But if there aren't any children, and this isn't a 
		// top-level page, then we're going to show the siblings 
		// of this page
		} elseif($parent != 0) {
			$hereditary = array(
				'depth' => 1,
				'exclude' => $excludes,
				'title_li' => '',
				'child_of' => $parent,
			);
		}
		echo '<ul class="nav nav-pills nav-stacked">';
		wp_list_pages($hereditary);
		echo '</ul>';
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
	}
}
add_action( 'widgets_init', function(){
	register_widget( 'Hereditary_Widget' );
});
