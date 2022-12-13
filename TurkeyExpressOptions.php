<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.fiverr.com/m4hd1bd
 * @since             1.0.0
 * @package           TurkeyExpressOptions
 *
 * @wordpress-plugin
 * Plugin Name:       Turkey Express Options
 * Plugin URI:        https://www.fiverr.com/m4hd1bd
 * Description:       Custom Options for TurkeyExpress
 * Version:           1.0.0
 * Author:            M4hd1BD
 * Author URI:        https://www.fiverr.com/m4hd1bd
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       TurkeyExpress
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'TurkeyExpressOptions', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-turkey-express-options-activator.php
 */
function activate_TurkeyExpressOptions() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-turkey-express-options-activator.php';
	TurkeyExpressOptions_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-turkey-express-options-deactivator.php
 */
function deactivate_TurkeyExpressOptions() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-turkey-express-options-deactivator.php';
	TurkeyExpressOptions_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_TurkeyExpressOptions' );
register_deactivation_hook( __FILE__, 'deactivate_TurkeyExpressOptions' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-turkey-express-options.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_TurkeyExpressOptions() {

	$plugin = new TurkeyExpressOptions();
	$plugin->run();

}
run_TurkeyExpressOptions();
