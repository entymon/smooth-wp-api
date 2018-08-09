<?php
/**
 * Created by PhpStorm.
 * User: entymon
 * Date: 09/08/2018
 * Time: 19:03
 */

namespace Smooth\Api\Controllers;


use Smooth\Api\Services\TermService;

class TagController extends Controller
{
	public function __construct()
	{
		$this->service = new TermService();
	}

	/**
	 * Get tags
	 *
	 * @param \WP_REST_Request $request
	 * @return \WP_REST_Response.
	 */
	public function getTags(\WP_REST_Request $request)
	{
		$query = new \WP_Term_Query([
			'taxonomy' => 'post_tag',
			'hide_empty' => false
		]);
		$terms = $query->terms;

		$categories = [];
		if (!empty($terms)) {
			foreach ($terms as $term) {
				if ($term->slug !== $this->uncategorized) {
					$categories[] = $this->service->getTermResponse($term);
				}
			}
		}

		$response = $this->service->getResponse(count($categories), $categories);
		return new \WP_REST_Response($response, 200);
	}
}