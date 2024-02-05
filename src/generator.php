<?php
namespace Meloniq\KenyanBeads;

class Generator {

	/**
	 * Bead container.
	 *
	 * @var string
	 */
	private $bead = '<div class="bead %s"><span style="%s"></span></div>';

	/**
	 * Bead qty height.
	 *
	 * @var int
	 */
	private $bead_qty_height = 0;

	/**
	 * Bead qty length.
	 *
	 * @var int
	 */
	private $bead_qty_length = 0;

	/**
	 * Bead square size px.
	 * Avg 14px (Bead 16px x Empty 12px).
	 *
	 * @var int
	 */
	private $square_size = 14;

	/**
	 * Image path.
	 *
	 * @var string
	 */
	private $image_path = '';

	/**
	 * Color scheme.
	 *
	 * @var string
	 */
	private $color_scheme = 'full';

	/**
	 * Constructor.
	 *
	 * @param string $image_path Image path.
	 * @param string $color_scheme Color scheme. Optional.
	 *
	 * @return void
	 */
	public function __construct( $image_path, $color_scheme = 'full' ) {
		if ( ! file_exists( $image_path ) ) {
			return;
		}

		$schemes = array( 'full', 'simplified', 'basic' );
		if ( ! in_array( $color_scheme, $schemes, true ) ) {
			$color_scheme = 'full';
		}

		$this->image_path      = $image_path;
		$this->bead_qty_height = $this->calculate_bead_height();
		$this->bead_qty_length = $this->calculate_bead_length();
		$this->color_scheme    = $color_scheme;
	}

	/**
	 * Empty bead/place.
	 *
	 * @return string
	 */
	public function empty() : string {
		return sprintf( $this->bead, 'bead-empty', '' );
	}

	/**
	 * Bread horizontal.
	 *
	 * @param string $color HEX Color (e.g. #000000). Optional.
	 *
	 * @return string
	 */
	public function horizontal( $color = '' ) : string {
		$style = '%colorplaceholder%';
		if ( ! empty( $color ) ) {
			$style = 'background-color: ' . $color . ';';
		}

		return sprintf( $this->bead, 'bead-horizontal', $style );
	}

	/**
	 * Bead vertical.
	 *
	 * @param string $color HEX Color (e.g. #000000). Optional.
	 *
	 * @return string
	 */
	public function vertical( $color = '' ) : string {
		$style = '%colorplaceholder%';
		if ( ! empty( $color ) ) {
			$style = 'background-color: ' . $color . ';';
		}

		return sprintf( $this->bead, 'bead-vertical', $style );
	}

	/**
	 * Bead generate example.
	 *
	 * @return string
	 */
	public function generate_example() : string {

		$html = '<div class="bead-scroll-container"><div class="bead-container">';
		for ( $i = 1; $i <= $this->bead_qty_height; $i++ ) {
			$row_class = ( $i % 2 !== 0 ) ? 'bead-row-odd' : 'bead-row-even';
			$html .= sprintf( '<div class="bead-line %s">', $row_class );
			for ( $j = 1; $j <= $this->bead_qty_length; $j++ ) {
				if ( ( $i % 2 !== 0 ) && ( $j === 1 || $j === $this->bead_qty_length ) ) {
					$html .= $this->empty();
				} else if ( ( $i % 2 !== 0 ) && ( $j % 2 !== 0 ) ) {
					$html .= $this->empty();
				} else if ( ( $i % 2 === 0 ) && ( $j % 2 === 0 ) ) {
					$html .= $this->empty();
				} else if ( $j % 2 === 0 ) {
					$html .= $this->vertical( '#ff0000' );//#ffffff
				} else {
					$html .= $this->horizontal( '#ff0000' );//#000000
				}
			}
			$html .= '</div>';
		}
		$html .= '</div></div>';

		return $html;
	}

	/**
	 * Generate pattern.
	 *
	 * @return string
	 */
	public function generate_pattern() : string {
		$pattern = $this->get_generated_pattern();

		$html = '<div class="bead-scroll-container"><div class="bead-container">';
		for ( $i = 0; $i < $this->bead_qty_height; $i++ ) {
			$row_class = ( $i % 2 === 0 ) ? 'bead-row-odd' : 'bead-row-even';
			$html .= sprintf( '<div class="bead-line %s">', $row_class );
			for ( $j = 0; $j < $this->bead_qty_length; $j++ ) {
				$html .= $pattern[$i][$j];
			}
			$html .= '</div>';
		}
		$html .= '</div></div>';

		return $html;
	}

	/**
	 * Get generated pattern.
	 *
	 * @return array
	 */
	public function get_generated_pattern() : array {
		$colors = $this->split_image_and_get_color();

		$pattern = array();
		for ( $i = 0; $i < $this->bead_qty_height; $i++ ) {
			for ( $j = 0; $j < $this->bead_qty_length; $j++ ) {
				if ( ( $i % 2 === 0 ) && ( $j === 0 || $j === $this->bead_qty_length - 1 ) ) {
					$pattern[$i][$j] = $this->empty();
				} else if ( ( $i % 2 === 0 ) && ( $j % 2 === 0 ) ) {
					$pattern[$i][$j] = $this->empty();
				} else if ( ( $i % 2 !== 0 ) && ( $j % 2 !== 0 ) ) {
					$pattern[$i][$j] = $this->empty();
				} else if ( $j % 2 !== 0 ) {
					$pattern[$i][$j] = $this->vertical( $colors[$i][$j]['hex'] );
				} else {
					$pattern[$i][$j] = $this->horizontal( $colors[$i][$j]['hex'] );
				}
			}
		}

		return $pattern;
	}

	/**
	 * Calculate bead height.
	 *
	 * @return int
	 */
	public function calculate_bead_height() : int {
		$size   = getimagesize( $this->image_path );
		$height = $size[1];

		return $this->calculate_bead_qty( $height );
	}

	/**
	 * Calculate bead length.
	 *
	 * @return int
	 */
	public function calculate_bead_length() : int {
		$size   = getimagesize( $this->image_path );
		$length = $size[0];

		return $this->calculate_bead_qty( $length );
	}

	/**
	 * Helper to calculate qty of beads.
	 *
	 * @param int $size Size.
	 *
	 * @return int
	 */
	public function calculate_bead_qty( $size ) : int {
		$qty = $size / $this->square_size;

		// round fractions down
		$qty = floor( $qty );

		// Have to be min 3.
		if ( $qty < 3 ) {
			$qty = 3;
		}

		// Have to be odd number.
		if ( $qty % 2 === 0 ) {
			$qty++;
		}

		return $qty;
	}

	/**
	 * Get bead qty.
	 *
	 * @return array
	 */
	public function get_bead_qty() : array {
		return array(
			'height' => $this->bead_qty_height,
			'length' => $this->bead_qty_length,
		);
	}

	/**
	 * Split image into pieces and get dominant color.
	 *
	 * @return array
	 */
	public function split_image_and_get_color() : array {
		if ( ! file_exists( $this->image_path ) ) {
			return array();
		}

		// PNG vs. JPEG
		if ( 'image/png' === mime_content_type( $this->image_path ) ) {
			$image = @imagecreatefrompng( $this->image_path );
		} else if ( 'image/jpeg' === mime_content_type( $this->image_path ) ) {
			$image = imagecreatefromjpeg( $this->image_path );
		} else {
			return array();
		}

		$width  = imagesx( $image );
		$height = imagesy( $image );
		$square = $this->square_size;

		$pieces = array();
		for ( $i = 0; $i < $this->bead_qty_height; $i++ ) {
			for ( $j = 0; $j < $this->bead_qty_length; $j++ ) {
				if ( ( $i % 2 === 0 ) && ( $j === 0 || $j === $this->bead_qty_length - 1 ) ) {
					continue;
				} else if ( ( $i % 2 === 0 ) && ( $j % 2 === 0 ) ) {
					continue;
				} else if ( ( $i % 2 !== 0 ) && ( $j % 2 !== 0 ) ) {
					continue;
				} else if ( $j % 2 !== 0 ) {
					// vertical
					$x      = ( $j * $square ) + ( ( $square - 2 ) / 2 );
					$y      = $i * $square;
					$width  = $square - 2;
					$height = $square + ( ( $square - 2 ) / 2 );
				} else {
					// horizontal
					$x      = $j * $square;
					$y      = ( $i * $square ) + ( ( $square - 2 ) / 2 );
					$width  = $square + ( ( $square - 2 ) / 2 );
					$height = $square - 2;
				}

				$img_tmp = imagecrop( $image, array( 'x' => $x, 'y' => $y, 'width' => $width, 'height' => $height ) );
				// If crop failed, skip.
				if ( $img_tmp === false ) {
					continue;
				}

				$color = $this->get_dominant_color( $img_tmp );
				// If no color, skip.
				if ( ! $color ) {
					continue;
				}

				$pieces[ $i ][ $j ] = array(
					'x'   => $x,
					'y'   => $y,
					'hex' => $color,
				);

			}
		}

		return $pieces;
	}

	/**
	 * Get dominant color from an image.
	 *
	 * @param GDImage $image Image resource.
	 *
	 * @return string Dominant hex color string, or empty string on failure.
	 */
	public function get_dominant_color( $image ) {

		if ( ! $image ) {
			return '';
		}

		// The logic here is resize the image to 1x1 pixel, then get the color of that pixel.
		$shorted_image = imagecreatetruecolor( 1, 1 );
		imagecopyresampled( $shorted_image, $image, 0, 0, 0, 0, 1, 1, imagesx( $image ), imagesy( $image ) );

		$rgb = imagecolorat( $shorted_image, 0, 0 );
		$r   = ( $rgb >> 16 ) & 0xFF;
		$g   = ( $rgb >> 8 ) & 0xFF;
		$b   = $rgb & 0xFF;
		$hex = Utils::rgb_to_hex( array( $r, $g, $b ) );

		if ( ! $hex ) {
			return '';
		}

		if ( 'full' === $this->color_scheme ) {
			return $hex;
		}

		return Utils::hex_websafe( $hex, $this->color_scheme );
	}

}
