<?php
/**
 * Created by PhpStorm.
 * User: entymon
 * Date: 23/05/2018
 * Time: 16:10
 */

namespace Smooth\Api;

class Routes extends \WP_REST_Controller
{

	/**
	 * @var Routes
	 */
	private $service;

	private $version = 1;

	protected $namespace;

	public function init()
	{
		$this->namespace = '/smooth/v' . $this->version . '/api';

		add_action('rest_api_init', [$this, 'registerPostsRoutes']);
		add_action('rest_api_init', [$this, 'registerCategoriesRoutes']);
		add_action('rest_api_init', [$this, 'registerTagsRoutes']);
	}

	/**
	 * Post Routes
	 */
	public function registerPostsRoutes()
	{
		/**
		 * GET /smooth/v1/posts
		 * GET /smooth/v1/posts?page=1
		 * GET /smooth/v1/posts?page=1&limit=5
		 */
		register_rest_route($this->namespace, '/posts', array(
			array(
				'methods' => \WP_REST_Server::READABLE,
				'callback' => array($this, 'getPosts'),
				'permission_callback' => array($this, 'getPermissionsCheck'),
				'args' => array(),
			)
		));

		/**
		 * GET /smooth/v1/posts/{id}
		 */
		register_rest_route($this->namespace, '/posts/(?P<id>\d+)', array(
			array(
				'methods' => \WP_REST_Server::READABLE,
				'callback' => array($this, 'getPostById'),
				'permission_callback' => array($this, 'getPermissionsCheck'),
				'args' => array(),
			)
		));

		/**
		 * GET /smooth/v1/posts/{categorySlug}
		 * GET /smooth/v1/posts/{categorySlug}?page=1
		 * GET /smooth/v1/posts/{categorySlug}?page=1&limit=10
		 */
		register_rest_route($this->namespace, '/posts/(?P<category>[a-zA-Z\-]+)', array(
			array(
				'methods' => \WP_REST_Server::READABLE,
				'callback' => array($this, 'getPostsByCategory'),
				'permission_callback' => array($this, 'getPermissionsCheck'),
				'args' => array(),
			)
		));
	}

	/**
	 * Category Routes
	 */
	public function registerCategoriesRoutes()
	{
		/**
		 * GET /smooth/v1/categories
		 */
		register_rest_route($this->namespace, '/categories', array(
			array(
				'methods' => \WP_REST_Server::READABLE,
				'callback' => array($this, 'getCategories'),
				'permission_callback' => array($this, 'getPermissionsCheck'),
				'args' => array(),
			)
		));

		/**
		 * GET /smooth/v1/categories/{id}
		 */
		register_rest_route($this->namespace, '/categories/(?P<id>\d+)', array(
			array(
				'methods' => \WP_REST_Server::READABLE,
				'callback' => array($this, 'getCategoryById'),
				'permission_callback' => array($this, 'getPermissionsCheck'),
				'args' => array(),
			)
		));
	}

	/**
	 * Tag Routes
	 */
	public function registerTagsRoutes()
	{
		/**
		 * GET /smooth/v1/tags
		 */
		register_rest_route($this->namespace, '/tags', array(
			array(
				'methods' => \WP_REST_Server::READABLE,
				'callback' => array($this, 'getTags'),
				'permission_callback' => array($this, 'getPermissionsCheck'),
				'args' => array(),
			)
		));
	}

	/**
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