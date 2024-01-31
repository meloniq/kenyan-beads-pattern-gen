<?php
use Meloniq\KenyanBeads\Utils;
use WP_Mock\Tools\TestCase;

final class UtilsTestCase extends TestCase {

	public function test_rgb_to_hex() : void {
		$this->assertEquals( '#000000', Utils::rgb_to_hex( array( 0, 0, 0 ) ) );
		$this->assertEquals( '#ffffff', Utils::rgb_to_hex( array( 255, 255, 255 ) ) );
		$this->assertEquals( '#ff0000', Utils::rgb_to_hex( array( 255, 0, 0 ) ) );
		$this->assertEquals( '#00ff00', Utils::rgb_to_hex( array( 0, 255, 0 ) ) );
		$this->assertEquals( '#0000ff', Utils::rgb_to_hex( array( 0, 0, 255 ) ) );
		$this->assertEquals( '#ff00ff', Utils::rgb_to_hex( array( 255, 0, 255 ) ) );
		$this->assertEquals( '#00ffff', Utils::rgb_to_hex( array( 0, 255, 255 ) ) );
		$this->assertEquals( '#ffff00', Utils::rgb_to_hex( array( 255, 255, 0 ) ) );
		$this->assertEquals( '#c0c0c0', Utils::rgb_to_hex( array( 192, 192, 192 ) ) );
		$this->assertEquals( '#808080', Utils::rgb_to_hex( array( 128, 128, 128 ) ) );
		$this->assertEquals( '#800000', Utils::rgb_to_hex( array( 128, 0, 0 ) ) );
		$this->assertEquals( '#808000', Utils::rgb_to_hex( array( 128, 128, 0 ) ) );
		$this->assertEquals( '#008000', Utils::rgb_to_hex( array( 0, 128, 0 ) ) );
		$this->assertEquals( '#800080', Utils::rgb_to_hex( array( 128, 0, 128 ) ) );
		$this->assertEquals( '#008080', Utils::rgb_to_hex( array( 0, 128, 128 ) ) );
		$this->assertEquals( '#000080', Utils::rgb_to_hex( array( 0, 0, 128 ) ) );
	}

	public function test_hex_to_rgb() : void {
		$this->assertEquals( array( 0, 0, 0 ), Utils::hex_to_rgb( '#000000' ) );
		$this->assertEquals( array( 255, 255, 255 ), Utils::hex_to_rgb( '#ffffff' ) );
		$this->assertEquals( array( 255, 0, 0 ), Utils::hex_to_rgb( '#ff0000' ) );
		$this->assertEquals( array( 0, 255, 0 ), Utils::hex_to_rgb( '#00ff00' ) );
		$this->assertEquals( array( 0, 0, 255 ), Utils::hex_to_rgb( '#0000ff' ) );
		$this->assertEquals( array( 255, 0, 255 ), Utils::hex_to_rgb( '#ff00ff' ) );
		$this->assertEquals( array( 0, 255, 255 ), Utils::hex_to_rgb( '#00ffff' ) );
		$this->assertEquals( array( 255, 255, 0 ), Utils::hex_to_rgb( '#ffff00' ) );
		$this->assertEquals( array( 192, 192, 192 ), Utils::hex_to_rgb( '#c0c0c0' ) );
		$this->assertEquals( array( 128, 128, 128 ), Utils::hex_to_rgb( '#808080' ) );
		$this->assertEquals( array( 128, 0, 0 ), Utils::hex_to_rgb( '#800000' ) );
		$this->assertEquals( array( 128, 128, 0 ), Utils::hex_to_rgb( '#808000' ) );
		$this->assertEquals( array( 0, 128, 0 ), Utils::hex_to_rgb( '#008000' ) );
		$this->assertEquals( array( 128, 0, 128 ), Utils::hex_to_rgb( '#800080' ) );
		$this->assertEquals( array( 0, 128, 128 ), Utils::hex_to_rgb( '#008080' ) );
		$this->assertEquals( array( 0, 0, 128 ), Utils::hex_to_rgb( '#000080' ) );
	}

	public function test_hex_websafe() : void {
		// black
		$this->assertEquals( '#000000', Utils::hex_websafe( '#000000' ) );
		$this->assertEquals( '#000000', Utils::hex_websafe( '#000001' ) );
		$this->assertEquals( '#000000', Utils::hex_websafe( '#000002' ) );
		$this->assertEquals( '#000000', Utils::hex_websafe( '#000003' ) );
		$this->assertEquals( '#000000', Utils::hex_websafe( '#000004' ) );
		$this->assertEquals( '#000000', Utils::hex_websafe( '#000005' ) );
		$this->assertEquals( '#000000', Utils::hex_websafe( '#000006' ) );
		$this->assertEquals( '#000000', Utils::hex_websafe( '#000007' ) );
		$this->assertEquals( '#000000', Utils::hex_websafe( '#000008' ) );
		$this->assertEquals( '#000000', Utils::hex_websafe( '#000009' ) );
		$this->assertEquals( '#000000', Utils::hex_websafe( '#00000a' ) );
		$this->assertEquals( '#000000', Utils::hex_websafe( '#00000b' ) );
		$this->assertEquals( '#000000', Utils::hex_websafe( '#00000c' ) );
		$this->assertEquals( '#000000', Utils::hex_websafe( '#00000d' ) );
		$this->assertEquals( '#000000', Utils::hex_websafe( '#00000e' ) );
		$this->assertEquals( '#000000', Utils::hex_websafe( '#00000f' ) );

		// white
		$this->assertEquals( '#ffffff', Utils::hex_websafe( '#ffffff' ) );
		$this->assertEquals( '#ffffff', Utils::hex_websafe( '#fffffe' ) );
		$this->assertEquals( '#ffffff', Utils::hex_websafe( '#fffffd' ) );
		$this->assertEquals( '#ffffff', Utils::hex_websafe( '#fffffc' ) );
		$this->assertEquals( '#ffffff', Utils::hex_websafe( '#fffffb' ) );
		$this->assertEquals( '#ffffff', Utils::hex_websafe( '#fffffa' ) );
		$this->assertEquals( '#ffffff', Utils::hex_websafe( '#fffff9' ) );
		$this->assertEquals( '#ffffff', Utils::hex_websafe( '#fffff8' ) );
		$this->assertEquals( '#ffffff', Utils::hex_websafe( '#fffff7' ) );
		$this->assertEquals( '#ffffff', Utils::hex_websafe( '#fffff6' ) );
		$this->assertEquals( '#ffffff', Utils::hex_websafe( '#fffff5' ) );
		$this->assertEquals( '#ffffff', Utils::hex_websafe( '#fffff4' ) );
		$this->assertEquals( '#ffffff', Utils::hex_websafe( '#fffff3' ) );
		$this->assertEquals( '#ffffff', Utils::hex_websafe( '#fffff2' ) );
		$this->assertEquals( '#ffffff', Utils::hex_websafe( '#fffff1' ) );
		$this->assertEquals( '#ffffff', Utils::hex_websafe( '#fffff0' ) );

		// red
		$this->assertEquals( '#ff0000', Utils::hex_websafe( '#ff0000' ) );
		$this->assertEquals( '#ff0000', Utils::hex_websafe( '#ff0001' ) );
		$this->assertEquals( '#ff0000', Utils::hex_websafe( '#ff0002' ) );
		$this->assertEquals( '#ff0000', Utils::hex_websafe( '#ff0003' ) );
		$this->assertEquals( '#ff0000', Utils::hex_websafe( '#ff0004' ) );
		$this->assertEquals( '#ff0000', Utils::hex_websafe( '#ff0005' ) );

		// yellow
		$this->assertEquals( '#ffff00', Utils::hex_websafe( '#ffff00' ) );
		$this->assertEquals( '#ffff00', Utils::hex_websafe( '#ffff01' ) );
		$this->assertEquals( '#ffff00', Utils::hex_websafe( '#ffff02' ) );
		$this->assertEquals( '#ffff00', Utils::hex_websafe( '#ffff03' ) );
		$this->assertEquals( '#ffff00', Utils::hex_websafe( '#ffff04' ) );
		$this->assertEquals( '#ffff00', Utils::hex_websafe( '#ffff05' ) );

		// green
		$this->assertEquals( '#00ff00', Utils::hex_websafe( '#00ff00' ) );
		$this->assertEquals( '#00ff00', Utils::hex_websafe( '#00ff01' ) );
		$this->assertEquals( '#00ff00', Utils::hex_websafe( '#00ff02' ) );
		$this->assertEquals( '#00ff00', Utils::hex_websafe( '#00ff03' ) );
		$this->assertEquals( '#00ff00', Utils::hex_websafe( '#00ff04' ) );
		$this->assertEquals( '#00ff00', Utils::hex_websafe( '#00ff05' ) );

		// cyan
		$this->assertEquals( '#00ffff', Utils::hex_websafe( '#00ffff' ) );
		$this->assertEquals( '#00ffff', Utils::hex_websafe( '#00fffe' ) );
		$this->assertEquals( '#00ffff', Utils::hex_websafe( '#00fffd' ) );
		$this->assertEquals( '#00ffff', Utils::hex_websafe( '#00fffc' ) );
		$this->assertEquals( '#00ffff', Utils::hex_websafe( '#00fffb' ) );
		$this->assertEquals( '#00ffff', Utils::hex_websafe( '#00fffa' ) );

		// blue
		$this->assertEquals( '#0000ff', Utils::hex_websafe( '#0000ff' ) );
		$this->assertEquals( '#0000ff', Utils::hex_websafe( '#0000fe' ) );
		$this->assertEquals( '#0000ff', Utils::hex_websafe( '#0000fd' ) );
		$this->assertEquals( '#0000ff', Utils::hex_websafe( '#0000fc' ) );
		$this->assertEquals( '#0000ff', Utils::hex_websafe( '#0000fb' ) );
		$this->assertEquals( '#0000ff', Utils::hex_websafe( '#0000fa' ) );

		// magenta
		$this->assertEquals( '#ff00ff', Utils::hex_websafe( '#ff00ff' ) );
		$this->assertEquals( '#ff00ff', Utils::hex_websafe( '#ff00fe' ) );
		$this->assertEquals( '#ff00ff', Utils::hex_websafe( '#ff00fd' ) );
		$this->assertEquals( '#ff00ff', Utils::hex_websafe( '#ff00fc' ) );
		$this->assertEquals( '#ff00ff', Utils::hex_websafe( '#ff00fb' ) );
		$this->assertEquals( '#ff00ff', Utils::hex_websafe( '#ff00fa' ) );
	}

	public function test_set_image_editors() : void {
		$original_editors = array( 'WP_Image_Editor_Imagick', 'WP_Image_Editor_GD' );
		$custom_editors = array( 'KBPG_Image_Editor_Imagick', 'KBPG_Image_Editor_GD' );

		Mockery::mock( 'WP_Image_Editor_Imagick' );
		Mockery::mock( 'WP_Image_Editor_GD' );

		$this->assertEquals( $custom_editors, Utils::set_image_editors( $original_editors ) );
	}

}
