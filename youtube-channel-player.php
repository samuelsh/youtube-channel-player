<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Youtube_Channel_Player
 *
 * @wordpress-plugin
 * Plugin Name:       Youtube Channel Player
 * Plugin URI:        https://gtihub.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            dogen
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       youtube-channel-player
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-youtube-channel-player-activator.php
 */
function activate_youtube_channel_player() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-youtube-channel-player-activator.php';
	Youtube_Channel_Player_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-youtube-channel-player-deactivator.php
 */
function deactivate_youtube_channel_player() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-youtube-channel-player-deactivator.php';
	Youtube_Channel_Player_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_youtube_channel_player' );
register_deactivation_hook( __FILE__, 'deactivate_youtube_channel_player' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-youtube-channel-player.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_youtube_channel_player() {

	$plugin = new Youtube_Channel_Player();
	$plugin->run();

}
run_youtube_channel_player();
