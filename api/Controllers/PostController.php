<?php
/**
 * Created by PhpStorm.
 * User: entymon
 * Date: 09/08/2018
 * Time: 18:33
 */

namespace Smooth\Api\Controller;

class PostController extends Controller
{
	/**
	 * Get posts
	 *
	 * @param \WP_REST_Request $request
	 * @return \WP_REST_Response.
	 */
	public function getPosts(\WP_REST_Request $request)
	{
		return new \WP_REST_Response(['hello' => 'get all smooths'], 200);
	}

	/**
	 * Get post by ID
	 *
	 * @param \WP_REST_Request $request
	 * @return \WP_REST_Response.
	 */
	public function getPostById(\WP_REST_Request $request)
	{
		return new \WP_REST_Response(['hello' => 'get by id'], 200);
	}

	/**
	 * Get posts by category
	 *
	 * @param \WP_REST_Request $request
	 * @return \WP_REST_Response.
	 */
	public function getPostsByCategory(\WP_REST_Request $request)
	{
		return new \WP_REST_Response(['hello' => 'category'], 200);
	}
}
