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
		$generator = new Generator();
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Kenyan Beads Pattern Generator', KBPG_TD ); ?></h1>
			<p><?php esc_html_e( 'This plugin generates a Kenyan Beads pattern.', KBPG_TD ); ?></p>
			<?php echo $generator->generate_example(); ?>
		</div>
		<?php
	}

}
