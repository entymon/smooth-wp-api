<?php
/**
 * Created by PhpStorm.
 * User: entymon
 * Date: 23/05/2018
 * Time: 16:10
 */

namespace Smooth\Api;

use Smooth\Api\Services\IndexService;

class IndexController extends \WP_REST_Controller
{

	/**
	 * @var IndexService
	 */
	private $service;

	public function init()
	{
		$this->service = new IndexService();
		add_action('rest_api_init', [$this, 'registerSmoothRoutes']);
	}

	/**
	 * Register the routes for the objects of the controller.
	 */
	public function registerSmoothRoutes()
	{
		$version = '1';
		$namespace = '/smooth/v' . $version . '/api';

		register_rest_route($namespace, '/posts', array(
			array(
				'methods' => \WP_REST_Server::READABLE,
				'callback' => array($this, 'getPosts'),
				'permission_callback' => array($this, 'getPermissionsCheck'),
				'args' => array(),
			)
		));
	}

	/**
	 * Grab posts
	 *
	 * @param \WP_REST_Request $request
	 * @return \WP_REST_Response.
	 */
	public function getPosts(\WP_REST_Request $request)
	{
		return new \WP_REST_Response( ['hello' => 'smooth'], 200 );
	}

	/**
	 * Check if a given request has access to get items
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return bool
	 */
	public function getPermissionsCheck( $request ) {
		return true; // use to make readable by all
	}
}