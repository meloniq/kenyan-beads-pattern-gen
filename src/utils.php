<?php
namespace Meloniq\KenyanBeads;

class Utils {

	/**
	 * Convert rgb to hex.
	 *
	 * @param array $rgb
	 *
	 * @return string
	 */
	public static function rgb_to_hex( $rgb ) {
		$range = range( 0, 255 );

		$hex = '#';
		foreach( $rgb as $val ) {
			if ( ! in_array( $val, $range, true ) ) {
				$val = 0;
			}

			// convert to HEX
			$hex .= str_pad( dechex( $val ), 2, '0', STR_PAD_LEFT );
		}

		return $hex;
	}

	/**
	 * Convert hex to rgb.
	 *
	 * @param string $hex
	 *
	 * @return array
	 */
	public static function hex_to_rgb( $hex ) {
		$hex = str_replace( '#', '', $hex );
		if ( strlen( $hex ) != 6 ) {
			return array( 0, 0, 0 );
		}

		$rgb = array();
		for ( $x = 0; $x < 3; $x++ ) {
			$rgb[ $x ] = hexdec( substr( $hex, ( 2 * $x ), 2 ) );
		}

		return $rgb;
	}

	/**
	 * Convert hex to websafe hex.
	 *
	 * @param string $hex
	 *
	 * @return string
	 */
	public static function hex_websafe( $hex ) {
		$rgb = self::hex_to_rgb( $hex );

		$websafe_hex = '#';
		foreach( $rgb as $val ) {
			// round value
			$val = ( round( $val/51 ) * 51 );
			// convert to HEX
			$websafe_hex .= str_pad( dechex( $val ), 2, '0', STR_PAD_LEFT );
		}

		return $websafe_hex;
	}

	/**
	 * Overloads wp_image_editors() to load the extended classes.
	 *
	 * @param string[] $editors Array of available image editor class names. Defaults are 'WP_Image_Editor_Imagick', 'WP_Image_Editor_GD'.
	 *
	 * @return string[] Registered image editors class names.
	 */
	public static function set_image_editors( $editors ) {
		if ( ! class_exists( 'KBPG_Image_Editor_GD' ) ) {
			require_once __DIR__ . '/class-image-editor-gd.php';
		}
		if ( ! class_exists( 'KBPG_Image_Editor_Imagick' ) ) {
			require_once __DIR__ . '/class-image-editor-imagick.php';
		}

		$replaces = array(
			'WP_Image_Editor_GD'      => 'KBPG_Image_Editor_GD',
			'WP_Image_Editor_Imagick' => 'KBPG_Image_Editor_Imagick',
		);

		foreach ( $replaces as $old => $new ) {
			$key = array_search( $old, $editors, true );
			if ( false !== $key ) {
				$editors[ $key ] = $new;
			}
		}

		return $editors;
	}

	/**
	 * Computes the dominant color of the given image and whether it has transparency.
	 *
	 * @param string $file_path The file path.
	 *
	 * @return array|WP_Error Array with the dominant color and has transparency values or WP_Error on error.
	 */
	public static function get_dominant_color_data( $file_path ) {
		$dominant_color_data = array(
			'dominant_color'   => '',
			'has_transparency' => false,
		);

		add_filter( 'wp_image_editors', array( __CLASS__, 'set_image_editors' ) );
		$editor = wp_get_image_editor(
			$file_path,
			array(
				'methods' => array(
					'get_dominant_color',
					'has_transparency',
				),
			)
		);
		remove_filter( 'wp_image_editors', array( __CLASS__, 'set_image_editors' ) );

		if ( is_wp_error( $editor ) ) {
			return $editor;
		}

		$has_transparency = $editor->has_transparency();
		if ( is_wp_error( $has_transparency ) ) {
			return $has_transparency;
		}
		$dominant_color_data['has_transparency'] = $has_transparency;

		$dominant_color = $editor->get_dominant_color();
		if ( is_wp_error( $dominant_color ) ) {
			return $dominant_color;
		}
		$dominant_color_data['dominant_color'] = $dominant_color;

		return $dominant_color_data;
	}

}
