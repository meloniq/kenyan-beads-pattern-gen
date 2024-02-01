<?php
use Meloniq\KenyanBeads\Settings;
use WP_Mock\Matcher\AnyInstance;
use WP_Mock\Tools\TestCase;

final class SettingsTestCase extends TestCase {

	public function test_hook_expectations() : void {
		$anySettings = new AnyInstance( Settings::class );

		WP_Mock::expectActionAdded( 'admin_menu', array( $anySettings, 'add_settings_page' ) );
		WP_Mock::expectActionAdded( 'admin_enqueue_scripts', array( $anySettings, 'admin_styles' ) );

		new Settings();

		$this->assertConditionsMet();
	}

	public function test_init() : void {
		$settings = new Settings();

		$this->assertConditionsMet();
	}

}
