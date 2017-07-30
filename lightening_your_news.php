<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/Kovaloff
 * @since             1.0.0
 * @package           Lightening_your_news
 *
 * @wordpress-plugin
 * Plugin Name:       Light News Ticker
 * Plugin URI:        https://github.com/Kovaloff
 * Description:       Light News Ticker generator
 * Version:           1.0.0
 * Author:            Artem Kovalov
 * Author URI:        https://github.com/Kovaloff
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       lightening_your_news
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-lightening_your_news-activator.php
 */
function activate_lightening_your_news() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-lightening_your_news-activator.php';
	Lightening_your_news_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-lightening_your_news-deactivator.php
 */
function deactivate_lightening_your_news() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-lightening_your_news-deactivator.php';
	Lightening_your_news_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_lightening_your_news' );
register_deactivation_hook( __FILE__, 'deactivate_lightening_your_news' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-lightening_your_news.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_lightening_your_news() {

	$plugin = new Lightening_your_news();
	$plugin->run();

}
run_lightening_your_news();
