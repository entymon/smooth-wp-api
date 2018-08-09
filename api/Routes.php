<?php
/**
 * Created by PhpStorm.
 * User: entymon
 * Date: 23/05/2018
 * Time: 16:10
 */

namespace Smooth\Api;

use Smooth\Api\Controllers\CategoryController;
use Smooth\Api\Controllers\PostController;
use Smooth\Api\Controllers\TagController;

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
				'callback' => array(new PostController(), 'getPosts'),
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
				'callback' => array(new PostController(), 'getPostById'),
				'permission_callback' => array($this, 'getPermissionsCheck'),
				'args' => array(),
			)
		));

		/**
		 * GET /smooth/v1/posts/category/{categorySlug}
		 * GET /smooth/v1/posts/category/{categorySlug}?page=1
		 * GET /smooth/v1/posts/category/{categorySlug}?page=1&limit=10
		 */
		register_rest_route($this->namespace, '/posts/category/(?P<category>[a-zA-Z\-]+)', array(
			array(
				'methods' => \WP_REST_Server::READABLE,
				'callback' => array(new PostController(), 'getPostsByCategory'),
				'permission_callback' => array($this, 'getPermissionsCheck'),
				'args' => array(),
			)
		));

		/**
		 * GET /smooth/v1/posts/tag/{tagSlug}
		 * GET /smooth/v1/posts/tag/{tagSlug}?page=1
		 * GET /smooth/v1/posts/tag/{tagSlug}?page=1&limit=10
		 */
		register_rest_route($this->namespace, '/posts/tag/(?P<tag>[a-zA-Z\-]+)', array(
			array(
				'methods' => \WP_REST_Server::READABLE,
				'callback' => array(new PostController(), 'getPostsByTag'),
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
				'callback' => array(new CategoryController(), 'getCategories'),
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
				'callback' => array(new CategoryController(), 'getCategoryById'),
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
				'callback' => array(new TagController(), 'getTags'),
				'permission_callback' => array($this, 'getPermissionsCheck'),
				'args' => array(),
			)
		));
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