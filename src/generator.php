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
	 * Bead qty high.
	 *
	 * @var int
	 */
	private $bead_qty_high = 11;

	/**
	 * Bead qty length.
	 *
	 * @var int
	 */
	private $bead_qty_length = 121;

	/**
	 * Bead square size px.
	 *
	 * @var int
	 */
	private $square_size = 112;

	/**
	 * Empty bead/place.
	 *
	 * @return string
	 */
	public function empty() {
		return sprintf( $this->bead, 'bead-empty', '' );
	}

	/**
	 * Bread horizontal.
	 *
	 * @param string $color HEX Color (e.g. #000000). Optional.
	 *
	 * @return string
	 */
	public function horizontal( $color = '' ) {
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
	public function vertical( $color = '' ) {
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
	public function generate_example() {
		$this->bead_qty_high   = 11; // min 3, have to be odd number
		$this->bead_qty_length = 111; // min 3, have to be odd number

		$html = '<div class="bead-scroll-container"><div class="bead-container">';
		for ( $i = 1; $i <= $this->bead_qty_high; $i++ ) {
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
					$html .= $this->vertical( '#ffffff' );
				} else {
					$html .= $this->horizontal( '#000000' );
				}
			}
			$html .= '</div>';
		}
		$html .= '</div></div>';

		return $html;
	}

}
