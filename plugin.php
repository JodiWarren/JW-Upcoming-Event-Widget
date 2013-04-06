<?php
/*
Plugin Name: JW's Simple Countdown Widget
Description: A widget to display a countdown
Version: 1.0
Author: Jodi
Author URI: http://www.jodiwarren.com
Author Email: jodi@jodiwarren.com
Text Domain: jw-countdown-locale
Domain Path: /lang/
Network: false
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Copyright 2012 Jodi (jodi@jodiwarren.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class jw_Countdown extends WP_Widget {

	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/

	/**
	 * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {

		// load plugin text domain
		add_action( 'init', array( $this, 'widget_textdomain' ) );

		// Hooks fired when the Widget is activated and deactivated
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

		parent::__construct(
			'jw-countdown-id',
			__( 'JW\'s Simple Countdown Widget', 'jw-countdown-locale' ),
			array(
				'classname'		=>	'jw-countdown-class',
				'description'	=>	__( 'A widget to display a countdown.', 'jw-countdown-locale' )
			)
		);

		// Register admin styles and scripts
		add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );

		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_scripts' ) );

	} // end constructor

	/*--------------------------------------------------*/
	/* Widget API Functions
	/*--------------------------------------------------*/

	/**
	 * Outputs the content of the widget.
	 *
	 * @param	array	args		The array of form elements
	 * @param	array	instance	The current instance of the widget
	 */
	public function widget( $args, $instance ) {

		extract( $args, EXTR_SKIP );

		echo $before_widget;

		$event = apply_filters( 'jw_countdowner_event', $instance['event'] );
		$band_name = apply_filters( 'jw_countdowner_band_name', $instance['band_name'] );
		$event_time = apply_filters( 'jw_countdowner_event_time', $instance['event_time'] );
		$event_date = apply_filters( 'jw_countdowner_event_date', $instance['event_date'] );
		$live_message = apply_filters( 'jw_countdowner_live_message', $instance['live_message'] );
		$date_passed = false;
		$time_left = '';

		date_default_timezone_set('Europe/London');

		// Compares difference between now and the inputted date. The function 'date_create' will create a date object from a supplied string, or create one from the current time if there's no argument supplied.
		if (strtotime("now") > strtotime($event_time . ' ' . $event_date)) {
			$date_passed = true;

		} else {
			$time_left = date_diff(date_create(), date_create($event_time . ' ' . $event_date));
		}

		include( plugin_dir_path( __FILE__ ) . '/views/widget.php' );

		echo $after_widget;

	} // end widget

	/**
	 * Processes the widget's options to be saved.
	 *
	 * @param	array	new_instance	The previous instance of values before the update.
	 * @param	array	old_instance	The new instance of values to be generated via the update.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['event'] = strip_tags( $new_instance['event'] );
		$instance['band_name'] = strip_tags( $new_instance['band_name'] );
	    $instance['event_time'] = strip_tags( $new_instance['event_time'] );
	    $instance['event_date'] = strip_tags( $new_instance['event_date'] );
	    $instance['live_message'] = strip_tags( $new_instance['live_message'] );

		return $instance;

	} // end widget

	/**
	 * Generates the administration form for the widget.
	 *
	 * @param	array	instance	The array of keys and values for the widget.
	 */
	public function form( $instance ) {

		$instance = wp_parse_args(
			(array) $instance
		);

		if ( ! empty( $instance['event'] ) ) {
		        $event = $instance['event'];
	    }
	    else {
	        $event = __( 'Event Name', 'jw-countdown-locale' );
	    }

	    if ( ! empty( $instance['band_name'] ) ) {
	        $band_name = $instance['band_name'];
	    }
	    else {
	        $band_name = '';
	    }

	    if ( ! empty( $instance['event_date'] ) ) {
	        $event_date = $instance['event_date'];
	    }
	    else {
	        $event_date = date( 'Y-m-d' );
	    }

	    if ( ! empty( $instance['event_time'] ) ) {
	        $event_time = $instance['event_time'];
	    }
	    else {
	        $event_time = '';
	    }
	    if ( ! empty( $instance['live_message'] ) ) {
	        $live_message = $instance['live_message'];
	    }
	    else {
	        $live_message = "It's happening right now!";
	    }

		// Display the admin form
		include( plugin_dir_path(__FILE__) . '/views/admin.php' );

	} // end form

	/*--------------------------------------------------*/
	/* Public Functions
	/*--------------------------------------------------*/

	/**
	 * Loads the Widget's text domain for localization and translation.
	 */
	public function widget_textdomain() {

		load_plugin_textdomain( 'jw-countdown-locale', false, plugin_dir_path( __FILE__ ) . '/lang/' );

	} // end widget_textdomain

	/**
	 * Fired when the plugin is activated.
	 *
	 * @param		boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public function activate( $network_wide ) {
	} // end activate

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog
	 */
	public function deactivate( $network_wide ) {
	} // end deactivate

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {

		wp_enqueue_style( 'jw-countdown-admin-styles', plugins_url( 'jw-upcoming-event/css/jquery-ui-fresh.css' ) );
		wp_enqueue_style( 'jw-countdown-admin-styles', plugins_url( 'jw-upcoming-event/css/admin.css' ) );

	} // end register_admin_styles

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */
	public function register_admin_scripts() {

		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'jw-countdown-admin-script', plugins_url( 'jw-upcoming-event/js/admin.js' ), array('jquery') );

	} // end register_admin_scripts

	/**
	 * Registers and enqueues widget-specific styles.
	 */
	public function register_widget_styles() {

		wp_enqueue_style( 'jw-countdown-widget-styles', plugins_url( 'jw-upcoming-event/css/widget.css' ) );

	} // end register_widget_styles

	/**
	 * Registers and enqueues widget-specific scripts.
	 */
	public function register_widget_scripts() {

		wp_enqueue_script( 'jw-countdown-script', plugins_url( 'jw-upcoming-event/js/widget.js' ), array('jquery') );

	} // end register_widget_scripts

} // end class

add_action( 'widgets_init', create_function( '', 'register_widget("jw_Countdown");' ) );
