<?php
use Meloniq\KenyanBeads\WPCLI;
use WP_Mock\Tools\TestCase;

final class WPCLITestCase extends TestCase {

	public function test_help() : void {
		Mockery::mock( 'WP_CLI_Command' );

		$wpcli = new WPCLI();

		ob_start();
		$wpcli->help( [], [] );
		$output = ob_get_clean();

		$this->assertStringContainsString( 'hextorgb', $output );
		$this->assertStringContainsString( 'hextowebsafe', $output );
		$this->assertStringContainsString( 'rgbtohex', $output );
	}

	public function test_hextorgb() : void {
		Mockery::mock( 'WP_CLI_Command' );

		$wpcli = new WPCLI();

		// Missing param
		ob_start();
		$wpcli->hextorgb( [], [] );
		$output = ob_get_clean();
		$this->assertStringContainsString( 'Missing or invalid param!', $output );

		// Hex color given
		ob_start();
		$wpcli->hextorgb( ['000000'], [] );
		$output = ob_get_clean();
		$this->assertStringContainsString( 'RGB color:', $output );
	}

	public function test_hextowebsafe() : void {
		Mockery::mock( 'WP_CLI_Command' );

		$wpcli = new WPCLI();

		// Missing param
		ob_start();
		$wpcli->hextowebsafe( [], [] );
		$output = ob_get_clean();
		$this->assertStringContainsString( 'Missing or invalid param!', $output );

		// Hex color given
		ob_start();
		$wpcli->hextowebsafe( ['000000'], [] );
		$output = ob_get_clean();
		$this->assertStringContainsString( 'HEX Websafe color:', $output );
	}

	public function test_rgbtohex() : void {
		Mockery::mock( 'WP_CLI_Command' );

		$wpcli = new WPCLI();

		// Missing param
		ob_start();
		$wpcli->rgbtohex( [], [] );
		$output = ob_get_clean();
		$this->assertStringContainsString( 'Missing or invalid param!', $output );

		// RGB color given
		ob_start();
		$wpcli->rgbtohex( ['0,0,0'], [] );
		$output = ob_get_clean();
		$this->assertStringContainsString( 'HEX color:', $output );
	}

}

// Mock WP_CLI class with static methods
if ( ! class_exists( 'WP_CLI' ) ) {
	class WP_CLI {
		public static function line( $message ) {
			echo $message;
		}
		public static function error( $message ) {
			echo $message;
		}
		public static function success( $message ) {
			echo $message;
		}
	}
}
