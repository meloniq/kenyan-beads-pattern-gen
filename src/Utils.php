<?php
namespace Meloniq\KenyanBeads;

class Utils {

	/**
	 * Convert rgb to hex.
	 *
	 * @param array $rgb The color in RGB.
	 *
	 * @return string
	 */
	public static function rgb_to_hex( $rgb ) : string {
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
	 * @param string $hex The hex color.
	 *
	 * @return array
	 */
	public static function hex_to_rgb( $hex ) : array {
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
	 * @param string $hex The hex color.
	 * @param string $color_scheme 'simplified' or 'basic'
	 *
	 * @return string
	 */
	public static function hex_websafe( $hex, $color_scheme = 'simplified' ) : string {
		$rgb = self::hex_to_rgb( $hex );

		$closest_color = self::get_closest_color( $rgb, $color_scheme );

		return $closest_color['hex'];
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

	/**
	 * Get simplified color palette.
	 *
	 * @return array
	 */
	public static function get_simplified_color_palette() : array {
		$palette = array(
			array(
				'name' => 'white',
				'hex'  => '#ffffff',
				'rgb'  => array( 255, 255, 255 ),
			),
			array(
				'name' => 'silver',
				'hex'  => '#c0c0c0',
				'rgb'  => array( 192, 192, 192 ),
			),
			array(
				'name' => 'gray',
				'hex'  => '#808080',
				'rgb'  => array( 128, 128, 128 ),
			),
			array(
				'name' => 'black',
				'hex'  => '#000000',
				'rgb'  => array( 0, 0, 0 ),
			),
			array(
				'name' => 'red',
				'hex'  => '#ff0000',
				'rgb'  => array( 255, 0, 0 ),
			),
			array(
				'name' => 'maroon',
				'hex'  => '#800000',
				'rgb'  => array( 128, 0, 0 ),
			),
			array(
				'name' => 'yellow',
				'hex'  => '#ffff00',
				'rgb'  => array( 255, 255, 0 ),
			),
			array(
				'name' => 'olive',
				'hex'  => '#808000',
				'rgb'  => array( 128, 128, 0 ),
			),
			array(
				'name' => 'lime',
				'hex'  => '#00ff00',
				'rgb'  => array( 0, 255, 0 ),
			),
			array(
				'name' => 'green',
				'hex'  => '#008000',
				'rgb'  => array( 0, 128, 0 ),
			),
			array(
				'name' => 'aqua',
				'hex'  => '#00ffff',
				'rgb'  => array( 0, 255, 255 ),
			),
			array(
				'name' => 'teal',
				'hex'  => '#008080',
				'rgb'  => array( 0, 128, 128 ),
			),
			array(
				'name' => 'blue',
				'hex'  => '#0000ff',
				'rgb'  => array( 0, 0, 255 ),
			),
			array(
				'name' => 'navy',
				'hex'  => '#000080',
				'rgb'  => array( 0, 0, 128 ),
			),
			array(
				'name' => 'fuchsia',
				'hex'  => '#ff00ff',
				'rgb'  => array( 255, 0, 255 ),
			),
			array(
				'name' => 'purple',
				'hex'  => '#800080',
				'rgb'  => array( 128, 0, 128 ),
			),
		);

		return $palette;
	}

	/**
	 * Get basic color palette.
	 *
	 * @return array
	 */
	public static function get_basic_color_palette() : array {
		$basic_colors= array(
			'white',
			'black',
			'red',
			'yellow',
			'green',
			'blue',
			'fuchsia',
		);

		$simplified_palette = self::get_simplified_color_palette();

		$palette = array();
		foreach ( $simplified_palette as $color ) {
			if ( in_array( $color['name'], $basic_colors, true ) ) {
				$palette[] = $color;
			}
		}

		return $palette;
	}

	/**
	 * Get color distance.
	 *
	 * @param array $rgb1 The first color in RGB.
	 * @param array $rgb2 The second color in RGB.
	 *
	 * @return float
	 */
	public static function get_color_distance( $rgb1, $rgb2 ) : float {
		$delta_r = $rgb1[0] - $rgb2[0];
		$delta_g = $rgb1[1] - $rgb2[1];
		$delta_b = $rgb1[2] - $rgb2[2];

		$v1 = $delta_r * $delta_r + $delta_g * $delta_g + $delta_b * $delta_b;
		//$v2 = ( $delta_r * .299 )^2 + ( $delta_g * .587 )^2 + ( $delta_b * .114 )^2;

		return sqrt( $v1 );
	}

	/**
	 * Get closest color.
	 *
	 * @param array $rgb_color The color in RGB.
	 * @param string $color_scheme 'simplified' or 'basic'
	 *
	 * @return array
	 */
	public static function get_closest_color( $rgb_color, $color_scheme ) : array {
		if ( 'basic' === $color_scheme ) {
			$palette = self::get_basic_color_palette();
		} else {
			$palette = self::get_simplified_color_palette();
		}

		$closest_color = array(
			'name' => 'black',
			'hex'  => '#000000',
			'rgb'  => array( 0, 0, 0 ),
		);

		$min_distance = sqrt( 3 * 255 * 255 ); // 3 color channels, each 0-255
		foreach ( $palette as $basic_color ) {
			$distance = self::get_color_distance( $rgb_color, $basic_color['rgb'] );
			if ( $distance < $min_distance ) {
				$min_distance = $distance;
				$closest_color = $basic_color;
			}
		}

		return $closest_color;
	}

	/**
	 * Get image path.
	 *
	 * @param int $attachment_id The attachment ID.
	 *
	 * @return string
	 */
	public static function get_image_path( $attachment_id ) {
		$metadata = wp_get_attachment_metadata( $attachment_id );
		if ( ! $metadata ) {
			return '';
		}

		$upload_dir = wp_get_upload_dir();
		$image_file = path_join( dirname( $metadata['file'] ), $metadata['sizes']['medium']['file'] );
		$image_path = trailingslashit( $upload_dir['basedir'] ) . $image_file;

		return $image_path;
	}

	/**
	 * Get image URL.
	 *
	 * @param int $attachment_id The attachment ID.
	 *
	 * @return string
	 */
	public static function get_image_url( $attachment_id ) {
		$metadata = wp_get_attachment_metadata( $attachment_id );
		if ( ! $metadata ) {
			return '';
		}

		$upload_dir = wp_get_upload_dir();
		$image_file = path_join( dirname( $metadata['file'] ), $metadata['sizes']['medium']['file'] );
		$image_url  = trailingslashit( $upload_dir['baseurl'] ) . $image_file;

		return $image_url;
	}

}
