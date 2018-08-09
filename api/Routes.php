<?php
/**
 * Created by PhpStorm.
 * User: entymon
 * Date: 23/05/2018
 * Time: 16:10
 */

namespace Smooth\Api;

use Smooth\Api\Services\IndexService;

class Routes extends \WP_REST_Controller
{

	/**
	 * @var Routes
	 */
	private $service;

	public function init()
	{
		add_action('rest_api_init', [$this, 'registerSmoothRoutes']);
	}

	/**
	 * Register the routes for the objects of the controller.
	 */
	public function registerSmoothRoutes()
	{
		$version = '1';
		$namespace = '/smooth/v' . $version . '/api';

		/**
		 * Posts
		 */

		register_rest_route($namespace, '/posts', array(
			array(
				'methods' => \WP_REST_Server::READABLE,
				'callback' => array($this, 'getPosts'),
				'permission_callback' => array($this, 'getPermissionsCheck'),
				'args' => array(),
			)
		));

		register_rest_route($namespace, '/posts/(?P<id>\d+)', array(
			array(
				'methods' => \WP_REST_Server::READABLE,
				'callback' => array($this, 'getPostById'),
				'permission_callback' => array($this, 'getPermissionsCheck'),
				'args' => array(),
			)
		));

		register_rest_route($namespace, '/posts/(?P<category>[a-zA-Z\-]+)', array(
			array(
				'methods' => \WP_REST_Server::READABLE,
				'callback' => array($this, 'getPostsByCategory'),
				'permission_callback' => array($this, 'getPermissionsCheck'),
				'args' => array(),
			)
		));

		/**
		 * Categories
		 */

		register_rest_route($namespace, '/categories', array(
			array(
				'methods' => \WP_REST_Server::READABLE,
				'callback' => array($this, 'getCategories'),
				'permission_callback' => array($this, 'getPermissionsCheck'),
				'args' => array(),
			)
		));

		register_rest_route($namespace, '/categories/(?P<id>\d+)', array(
			array(
				'methods' => \WP_REST_Server::READABLE,
				'callback' => array($this, 'getCategoryById'),
				'permission_callback' => array($this, 'getPermissionsCheck'),
				'args' => array(),
			)
		));

		/**
		 * Tags
		 */

		register_rest_route($namespace, '/tags', array(
			array(
				'methods' => \WP_REST_Server::READABLE,
				'callback' => array($this, 'getTags'),
				'permission_callback' => array($this, 'getPermissionsCheck'),
				'args' => array(),
			)
		));
	}

	/**
	 * GET /smooth/v1/posts
	 * GET /smooth/v1/posts?page=1
	 * GET /smooth/v1/posts?page=1&limit=5
	 *
	 * Get posts
	 *
	 * @param \WP_REST_Request $request
	 * @return \WP_REST_Response.
	 */
	public function getPosts(\WP_REST_Request $request)
	{
		return new \WP_REST_Response( ['hello' => 'get all smooths'], 200 );
	}

	/**
	 * GET /smooth/v1/posts/{id}
	 *
	 * Get post by ID
	 *
	 * @param \WP_REST_Request $request
	 * @return \WP_REST_Response.
	 */
	public function getPostById(\WP_REST_Request $request)
	{
		return new \WP_REST_Response( ['hello' => 'get by id'], 200 );
	}

	/**
	 * GET /smooth/v1/posts/{categorySlug}
	 * GET /smooth/v1/posts/{categorySlug}?page=1
	 * GET /smooth/v1/posts/{categorySlug}?page=1&limit=10
	 *
	 * Get posts by category
	 *
	 * @param \WP_REST_Request $request
	 * @return \WP_REST_Response.
	 */
	public function getPostsByCategory(\WP_REST_Request $request)
	{
		return new \WP_REST_Response( ['hello' => 'category'], 200 );
	}

	/**
	 * GET /smooth/v1/categories
	 *
	 * Get categories
	 *
	 * @param \WP_REST_Request $request
	 * @return \WP_REST_Response.
	 */
	public function getCategories(\WP_REST_Request $request)
	{
		return new \WP_REST_Response( ['hello' => 'category'], 200 );
	}

	/**
	 * GET /smooth/v1/categories/{id}
	 *
	 * Get category by ID
	 *
	 * @param \WP_REST_Request $request
	 * @return \WP_REST_Response.
	 */
	public function getCategoryById(\WP_REST_Request $request)
	{
		return new \WP_REST_Response( ['hello' => 'category by ID'], 200 );
	}

	/**
	 * GET /smooth/v1/tags
	 *
	 * Get tags
	 *
	 * @param \WP_REST_Request $request
	 * @return \WP_REST_Response.
	 */
	public function getTags(\WP_REST_Request $request)
	{
		return new \WP_REST_Response( ['hello' => 'tags'], 200 );
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