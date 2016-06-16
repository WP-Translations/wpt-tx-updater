<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
 * Class from Transifex API
 *
 * @since 1.0.0
 */
class WPTXU_Transifex_API
{

	public $slug;
	protected $api_url = 'https://www.transifex.com/api/2/project/';
	protected $args = array();
	private $auth = '';

	public function __construct( $slug ) {

		$this->slug = $slug;

		$this->auth = get_user_meta( get_current_user_id(), 'wptxu_transifex_auth', true );

		$this->args = array(
			'httpversion' => '1.1',
			'method'      => 'GET',
			'timeout'     => 30,
			'headers'    => array(
				'Authorization' => 'Basic '. $this->auth,
				'Content-Type'  => 'Content-Type: application/json',
			),
		);

	}

	public function get_remote_data( $api_endpoint, $prefix_action, $resource ) {

		$cached = wp_remote_get( $api_endpoint, $this->args );
		$http_code = wp_remote_retrieve_response_code( $cached );

		if ( $http_code != '200' ) {
			$response = $http_code;
		} else {
			$response = json_decode( wp_remote_retrieve_body( $cached ) );
		}

		return $response;

	}

	public function _infos_details() {

		$api_endpoint = $this->api_url . $this->slug . '/?details';
		$prefix_action = '_tx_infos_details';

		return $this->get_remote_data( $api_endpoint, $prefix_action, $this->slug );

	}

	public function _infos_by_lang( $resource, $lang_code ) {

		$api_endpoint = $this->api_url . $this->slug . '/resource/' . $resource . '/stats/' . $lang_code;
		$prefix_action = '_tx_infos_lang_' . $lang_code;

		return $this->get_remote_data( $api_endpoint, $prefix_action, $resource );

	}

	public function get_translation( $resource, $lang_code ) {

		$api_endpoint = $this->api_url . $this->slug . '/resource/' . $resource . '/translation/' . $lang_code . '/?mode=onlyreviewed';
		$prefix_action = '_tx_translation_' . $lang_code;

		return $this->get_remote_data( $api_endpoint, $prefix_action, $resource );

	}
}
