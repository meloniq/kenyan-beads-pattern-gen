<?php
use Meloniq\KenyanBeads\Settings;
use WP_Mock\Tools\TestCase;

final class SettingsTestCase extends TestCase {

	public function test_init() : void {
		$settings = new Settings();

		$this->assertConditionsMet();
	}

}
