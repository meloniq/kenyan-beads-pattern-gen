<?php
namespace Meloniq\KenyanBeads;

use WP_REST_Controller;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;
use WP_Error;

class Rest extends WP_REST_Controller {
	protected $namespace = 'kbpg/v1';

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ), 10 );
	}

	/**
	 * Register the routes for the objects of the controller.
	 *
	 * @return void
	 */
	public function register_routes() {

		register_rest_route( $this->namespace, '/pattern/(?P<id>[\d]+)', array(
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_item' ),
				'permission_callback' => '__return_true',
				'args'                => array(
					'context' => array(
						'default' => 'view',
					),
				),
			),
		) );

	}

	/**
	 * Get pattern.
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 *
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_item( $request ) {
		$image_id = $request->get_param( 'id' );

		if ( empty( $image_id ) ) {
			return new WP_Error(
				'id_invalid',
				__( 'ID is invalid', KBPG_TD ),
				array(
					'status' => 403,
				)
			);
		}

		switch_to_blog( BLOG_ID_CURRENT_SITE );

		$image_path = Utils::get_image_path( $image_id );
		if ( ! $image_path ) {
			return new WP_Error(
				'image_not_found',
				__( 'Image not found.', KBPG_TD ),
				array(
					'status' => 404,
				)
			);
		}

		$generator = new Generator( $image_path );
		$bead_qty  = $generator->get_bead_qty();
		$image_url = Utils::get_image_url( $image_id );

		$pattern = array(
			'id'         => $image_id,
			'height'     => $bead_qty['height'],
			'width'      => $bead_qty['length'],
			'image_path' => $image_path,
			'image_url'  => $image_url,
			'html'       => $generator->generate_pattern(),
			'pattern'    => $generator->get_generated_pattern(),
		);

		restore_current_blog();

		return new WP_REST_Response( $pattetn, 200 );
	}





}
