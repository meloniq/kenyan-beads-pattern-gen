<?php
/**
 * Plugin Name:       Kenyan Beads Pattern Generator
 * Plugin URI:        https://blog.meloniq.net/
 * Description:       Kenyan Beads Pattern Generator.
 *
 * Requires at least: 6.4
 * Requires PHP:      8.0
 * Version:           1.0
 *
 * Author:            MELONIQ.NET
 * Author URI:        https://blog.meloniq.net
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       kenyan-beads
 *
 * @package           meloniq
 */

namespace Meloniq\KenyanBeads;

// If this file is accessed directly, then abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'KBPG_TD', 'kenyan-beads' );
define( 'KBPG_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'KBPG_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// Include the autoloader so we can dynamically include the rest of the classes.
require_once trailingslashit( dirname( __FILE__ ) ) . 'vendor/autoload.php';

/**
 * Setup Plugin data.
 *
 * @return void
 */
function setup() {
	global $kbpg_kenyan_beads;

	$kbpg_kenyan_beads['settings'] = new Settings();
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\setup' );

/**
 * Load WP-CLI command.
 *
 * @return void
 */
function load_wp_cli() {
	if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
		return;
	}

	\WP_CLI::add_command( 'kbpg', __NAMESPACE__ . '\WPCLI' );
}
add_action( 'init', __NAMESPACE__ . '\load_wp_cli' );
