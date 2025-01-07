<?php
namespace Meloniq\KenyanBeads;

class Frontend {

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'blocks_init' ) );
	}

	/**
	 * Registers the block using the metadata loaded from the `block.json` file.
	 * Registers also all assets so they can be enqueued.
	 *
	 * @return void
	 */
	public function blocks_init() {
		wp_register_style(
			'kbpg-select-image-style',
			plugins_url( 'build/blocks/select-image/style-index.css', KBPG_PLUGIN_DIR ),
			array(),
			'1.0.0'
		);

		register_block_type( KBPG_PLUGIN_DIR . '/build/blocks/select-image', array(
			'render_callback' => array( $this, 'render_select_image' ),
		) );
	}


	/**
	 * Render callback for the select-image block.
	 *
	 * @param array $attributes The block attributes.
	 *
	 * @return string
	 */
	public function render_select_image( $attributes ) {
		$image_id = $attributes['attachmentId'];
		if ( ! $image_id ) {
			return '';
		}

		$image_path = Utils::get_image_path( $image_id );
		if ( ! $image_path ) {
			return '';
		}

		$generator = new Generator( $image_path );
		$bead_qty  = $generator->get_bead_qty();
		$text      = __( 'Height: %1$d beads, Length: %2$d beads', KBPG_TD );

		$html = '<p>' . sprintf( $text, $bead_qty['height'], $bead_qty['length'] ) . '</p>';

		$image_url = Utils::get_image_url( $image_id );
		if ( $image_url ) {
			$html .= sprintf( '<p><img src="%s" /></p>', esc_url( $image_url ) );
		}

		$html .= $generator->generate_pattern();

		return $html;
	}

}
