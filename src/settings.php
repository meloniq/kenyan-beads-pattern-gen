<?php
namespace Meloniq\KenyanBeads;

class Settings {

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );
	}

	/**
	 * Add settings page.
	 *
	 * @return void
	 */
	public function add_settings_page() {
		add_management_page(
			__( 'Kenyan Beads Pattern Generator', KBPG_TD ),
			__( 'Kenyan Beads Pattern Generator', KBPG_TD ),
			'manage_options',
			'kenyan-beads',
			array( $this, 'render' )
		);
	}

	/**
	 * Enqueue admin styles.
	 *
	 * @return void
	 */
	public function admin_styles() {
		wp_enqueue_style(
			'kenyan-beads-admin',
			KBPG_PLUGIN_URL . 'assets/style.css',
			array(),
			''
		);
	}

	/**
	 * Render settings page.
	 *
	 * @return void
	 */
	public function render() {
		$files = array(
			'example-black-verdana.png',
			'example-transparent-verdana.png',
			'example-black-times.png',
			'example-transparent-times.png',
			'flag-poland.png',
			'flag-sweden.png',
			'flag-kenya.png',
		);
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Kenyan Beads Pattern Generator', KBPG_TD ); ?></h1>
			<p><?php esc_html_e( 'This plugin generates a Kenyan Beads pattern.', KBPG_TD ); ?></p>
			<?php
			//echo $generator->generate_example();
			foreach ( $files as $file_name ) {
				$this->generate_example( $file_name );
			}
			?>
		</div>
		<?php
	}

	/**
	 * Generate example.
	 *
	 * @param string $file_name The file name.
	 *
	 * @return void
	 */
	public function generate_example( $file_name ) {
		$image_path = KBPG_PLUGIN_DIR . 'assets/' . $file_name;
		$image_url  = KBPG_PLUGIN_URL . 'assets/' . $file_name;
		$generator  = new Generator( $image_path );
		$bead_qty   = $generator->get_bead_qty();
		$text       = __( 'Height: %1$d beads, Length: %2$d beads, File: %3$s', KBPG_TD )
	?>
		<p><?php printf( $text, $bead_qty['height'], $bead_qty['length'], $file_name ); ?></p>
		<p><img src="<?php echo esc_url( $image_url ); ?>" /></p>
	<?php
		echo $generator->generate_pattern();
	}

}
