<?php
/**
 * Created by PhpStorm.
 * User: entymon
 * Date: 09/08/2018
 * Time: 18:33
 */

namespace Smooth\Api\Controllers;

use Smooth\Api\Entities\Post;
use Smooth\Api\Services\PostService;

class PostController extends Controller
{
	const FIRST_ELEMENT = 0;

	private $limit = -1;

	private $page = 1;

	private $postType = 'post';

	public function __construct()
	{
		$this->service = new PostService();
	}

	/**
	 * Get posts
	 *
	 * Optional parameters:
	 * - limit [int] number of items on page (default: -1)
	 * - page [int] page counted from 1 (default: 1)
	 *
	 * - search_keyword [string] - search by keyword
	 *
	 * @param \WP_REST_Request $request
	 * @return \WP_REST_Response.
	 */
	public function getPosts(\WP_REST_Request $request)
	{
		$params = $request->get_params();

		if (isset($params['limit'])) $this->limit = (int) $params['limit'];
		if (isset($params['page'])) $this->page = (int) $params['page'];

		$totalPosts = $this->service->getNumberOfPosts();

		$args = array(
			'post_status' => 'publish',
			'post_type' => $this->postType,
			'posts_per_page' => $this->limit,
			'paged' => $this->page
		);

		$data = [];
		if (isset($params['keyword'])) {

			$totalPosts = $this->service->getCountPostsByKeyword($params['keyword']);
			$posts = $this->service->getPostsByKeyword($params['keyword'], $this->page, $this->limit);

			if (!empty($posts)) {
				foreach ($posts as $post) {
					$data[] = $this->service->getPostResponseStdClass($post);
				}
			}

		} else {
			$query = new \WP_Query( $args );
			$posts = $query->posts;
			if (!empty($posts)) {
				foreach ($posts as $post) {
					$data[] = $this->service->getPostResponse($post);
				}
			}

		}



		$response = $this->service->getResponse($totalPosts, $this->limit, $this->page, $data);
		return new \WP_REST_Response($response, 200);
	}

	/**
	 * Get post by ID
	 *
	 * @param \WP_REST_Request $request
	 * @return \WP_REST_Response.
	 */
	public function getPostById(\WP_REST_Request $request)
	{
		$args = array(
			'p' => (int) $request->get_param('id'),
		);

		$query = new \WP_Query($args);
		$posts = $query->posts;

		$response = $this->service->getResponse(0.1, 1, 1, null);
		if (!empty($posts)) {
			$data = $this->service->getPostResponse($posts[self::FIRST_ELEMENT]);
			$response = $this->service->getResponse(1, 1, 1, $data);
		}
		return new \WP_REST_Response($response, 200);
	}

	/**
	 * Get posts by category
	 *
	 * @param \WP_REST_Request $request
	 * @return \WP_REST_Response.
	 */
	public function getPostsByCategory(\WP_REST_Request $request)
	{
		$params = $request->get_params();
		if (isset($params['limit'])) $this->limit = (int) $params['limit'];
		if (isset($params['page'])) $this->page = (int) $params['page'];

		$categorySlug = $request->get_param('category');
		$totalPosts = $this->service->getNumberOfPostsInCategory($categorySlug);

		$args = array(
			'post_type' => 'post',
			'posts_per_page' => $this->limit,
			'paged' => $this->page,
			'tax_query' => array(
				'taxonomy' => 'category',
				'field'    => 'slug',
				'terms'    => array( $categorySlug ),
			),
		);
		$query = new \WP_Query( $args );
		$posts = $query->posts;

		$data = [];
		if (!empty($posts)) {
			foreach ($posts as $post) {
				$data[] = $this->service->getPostResponse($post);
			}
		}

		$response = $this->service->getResponse($totalPosts, $this->limit, $this->page, $data);
		return new \WP_REST_Response($response, 200);
	}

	/**
	 * Get posts by tag
	 *
	 * @param \WP_REST_Request $request
	 * @return \WP_REST_Response.
	 */
	public function getPostsByTag(\WP_REST_Request $request)
	{
		$params = $request->get_params();
		if (isset($params['limit'])) $this->limit = (int) $params['limit'];
		if (isset($params['page'])) $this->page = (int) $params['page'];

		$tagSlug = $request->get_param('tag');
		$totalPosts = $this->service->getNumberOfPostsInCategory($tagSlug);

		$args = array(
			'post_type' => 'post',
			'posts_per_page' => $this->limit,
			'paged' => $this->page,
			'tag' => $tagSlug
		);
		$query = new \WP_Query( $args );
		$posts = $query->posts;

		$data = [];
		if (!empty($posts)) {
			foreach ($posts as $post) {
				$data[] = $this->service->getPostResponse($post);
			}
		}

		$response = $this->service->getResponse($totalPosts, $this->limit, $this->page, $data);
		return new \WP_REST_Response($response, 200);
	}
}
