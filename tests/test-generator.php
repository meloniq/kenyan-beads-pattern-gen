<?php
use Meloniq\KenyanBeads\Generator;
use WP_Mock\Tools\TestCase;

final class GeneratorTestCase extends TestCase {

	public function test_empty() : void {
		$generator = new Generator();

		$this->assertStringContainsString( 'bead-empty', $generator->empty() );
	}

	public function test_horizontal() : void {
		$generator = new Generator();

		$this->assertStringContainsString( 'bead-horizontal', $generator->horizontal() );
		$this->assertStringContainsString( 'bead-horizontal', $generator->horizontal( '#000000' ) );
	}

	public function test_vertical() : void {
		$generator = new Generator();

		$this->assertStringContainsString( 'bead-vertical', $generator->vertical() );
		$this->assertStringContainsString( 'bead-vertical', $generator->vertical( '#000000' ) );
	}

	public function test_generate_example() : void {
		$generator = new Generator();

		$example = $generator->generate_example();

		$this->assertStringContainsString( 'bead-container', $example );
		$this->assertStringContainsString( 'bead-empty', $example );
		$this->assertStringContainsString( 'bead-horizontal', $example );
		$this->assertStringContainsString( 'bead-vertical', $example );
	}

}
