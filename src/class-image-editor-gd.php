<?php
/**
 * WordPress Image Editor Class for Image Manipulation through GD
 * with dominant color detection.
 *
 * @see WP_Image_Editor
 */
class KBPG_Image_Editor_GD extends WP_Image_Editor_GD {

	/**
	 * Get dominant color from a file.
	 *
	 * @return string|WP_Error Dominant hex color string, or an error on failure.
	 */
	public function get_dominant_color() {

		if ( ! $this->image ) {
			return new WP_Error( 'image_editor_dominant_color_error_no_image', __( 'Dominant color detection no image found.', KBPG_TD ) );
		}
		// The logic here is resize the image to 1x1 pixel, then get the color of that pixel.
		$shorted_image = imagecreatetruecolor( 1, 1 );
		imagecopyresampled( $shorted_image, $this->image, 0, 0, 0, 0, 1, 1, imagesx( $this->image ), imagesy( $this->image ) );

		$rgb = imagecolorat( $shorted_image, 0, 0 );
		$r   = ( $rgb >> 16 ) & 0xFF;
		$g   = ( $rgb >> 8 ) & 0xFF;
		$b   = $rgb & 0xFF;
		$hex = Utils::rgb_to_hex( array( $r, $g, $b ) );
		if ( ! $hex ) {
			return new WP_Error( 'image_editor_dominant_color_error', __( 'Dominant color detection failed.', KBPG_TD ) );
		}

		return $hex;
	}


	/**
	 * Looks for transparent pixels in the image.
	 * If there are none, it returns false.
	 *
	 * @return bool|WP_Error True or false based on whether there are transparent pixels, or an error on failure.
	 */
	public function has_transparency() {

		if ( ! $this->image ) {
			return new WP_Error( 'image_editor_has_transparency_error_no_image', __( 'Transparency detection no image found.', KBPG_TD ) );
		}

		// Walk through the pixels and look transparent pixels.
		$w = imagesx( $this->image );
		$h = imagesy( $this->image );
		for ( $x = 0; $x < $w; $x++ ) {
			for ( $y = 0; $y < $h; $y++ ) {
				$rgb  = imagecolorat( $this->image, $x, $y );
				$rgba = imagecolorsforindex( $this->image, $rgb );
				if ( $rgba['alpha'] > 0 ) {
					return true;
				}
			}
		}
		return false;
	}
}
