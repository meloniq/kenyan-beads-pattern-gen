<?php
namespace Meloniq\KenyanBeads;

use WP_CLI;
use WP_CLI_Command;

/**
 * Class extends WP CLI with custom commands to manage plugin from command line.
 */
class WPCLI extends WP_CLI_Command {

	/**
	 * Subcommand to list all available commands.
	 *
	 * Examples:
	 * wp kbpg help
	 *
	 * @subcommand help
	 */
	public function help( $args, $assoc_args ) {

		WP_CLI::line( 'hextorgb     <hex color> ' . sprintf( __( 'Convert HEX color to RGB, where <hex color> can be: %s', KBPG_TD ), '000000' ) );
		WP_CLI::line( 'hextowebsafe <hex color> ' . sprintf( __( 'Convert HEX color to HEX Websafe, where <hex color> can be: %s', KBPG_TD ), '000000' ) );
		WP_CLI::line( 'rgbtohex     <rgb color> ' . sprintf( __( 'Convert RGB color to HEX, where <rgb color> can be: %s', KBPG_TD ), '0,0,0' ) );
	}

	/**
	 * Subcommand to set position of language bar.
	 *
	 * Examples:
	 * wp kbpg hextorgb 000000
	 *
	 * @subcommand hextorgb
	 */
	public function hextorgb( $args, $assoc_args ) {

		if ( empty( $args[0] ) ) {
			$message = sprintf( __( 'Missing or invalid param! Valid can be: %s', KBPG_TD ), '000000' );
			WP_CLI::error( $message );
			return;
		}

		$rgb = Utils::hex_to_rgb( $args[0] );

		$message = sprintf( __( 'RGB color: %s', KBPG_TD ), implode( ',', $rgb ) );
		WP_CLI::success( $message );
	}

	/**
	 * Subcommand to convert HEX color to HEX Websafe.
	 *
	 * Examples:
	 * wp kbpg hextowebsafe 000000
	 *
	 * @subcommand hextowebsafe
	 */
	public function hextowebsafe( $args, $assoc_args ) {

		if ( empty( $args[0] ) ) {
			$message = sprintf( __( 'Missing or invalid param! Valid can be: %s', KBPG_TD ), '000000' );
			WP_CLI::error( $message );
			return;
		}

		$hex = Utils::hex_websafe( $args[0] );

		$message = sprintf( __( 'HEX Websafe color: %s', KBPG_TD ), $hex );
		WP_CLI::success( $message );
	}

	/**
	 * Subcommand to convert RGB color to HEX.
	 *
	 * Examples:
	 * wp kbpg rgbtohex 0,0,0
	 *
	 * @subcommand rgbtohex
	 */
	public function rgbtohex( $args, $assoc_args ) {

		if ( empty( $args[0] ) ) {
			$message = sprintf( __( 'Missing or invalid param! Valid can be: %s', KBPG_TD ), '0,0,0' );
			WP_CLI::error( $message );
			return;
		}

		$rgb = explode( ',', $args[0] );
		$hex = Utils::rgb_to_hex( $rgb );

		$message = sprintf( __( 'HEX color: %s', KBPG_TD ), $hex );
		WP_CLI::success( $message );
	}

}
