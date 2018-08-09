<?php
/**
 * Created by PhpStorm.
 * User: entymon
 * Date: 09/08/2018
 * Time: 18:33
 */

namespace Smooth\Api\Controllers;

use Smooth\Api\Services\PostService;

class PostController extends Controller
{
	public function __construct()
	{
		$this->service = new PostService();
	}

	/**
	 * Get posts
	 *
	 * @param \WP_REST_Request $request
	 * @return \WP_REST_Response.
	 */
	public function getPosts(\WP_REST_Request $request)
	{
		$args = array(
			'post_status' => 'publish',
			'posts_per_page' => -1
		);

		$query = new \WP_Query( $args );
		$posts = $query->posts;

		$data = [];
		if (!empty($posts)) {
			foreach ($posts as $post) {
				$data[] = $this->service->getPostResponse($post);
			}
		}
		return new \WP_REST_Response( $data, 200 );
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
