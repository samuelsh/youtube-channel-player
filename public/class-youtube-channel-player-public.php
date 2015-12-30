<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Youtube_Channel_Player
 * @subpackage Youtube_Channel_Player/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Youtube_Channel_Player
 * @subpackage Youtube_Channel_Player/public
 * @author     Your Name <email@example.com>
 */
class Youtube_Channel_Player_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $Youtube_Channel_Player    The ID of this plugin.
	 */
	private $Youtube_Channel_Player;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $Youtube_Channel_Player       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $Youtube_Channel_Player, $version ) {

		$this->Youtube_Channel_Player = $Youtube_Channel_Player;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Youtube_Channel_Player_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Youtube_Channel_Player_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->Youtube_Channel_Player, plugin_dir_url( __FILE__ ) . 'css/plugin-name-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Youtube_Channel_Player_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Youtube_Channel_Player_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->Youtube_Channel_Player, plugin_dir_url( __FILE__ ) . 'js/plugin-name-public.js', array( 'jquery' ), $this->version, false );

	}

}
