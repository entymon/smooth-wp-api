<?php
/**
 * Created by PhpStorm.
 * User: entymon
 * Date: 09/08/2018
 * Time: 19:01
 */

namespace Smooth\Api\Controllers;


use Smooth\Api\Services\TermService;

class CategoryController extends Controller
{
	private $uncategorized = 'uncategorized';

	public function __construct()
	{
		$this->service = new TermService();
	}

	/**
	 * Get categories
	 *
	 * @param \WP_REST_Request $request
	 * @return \WP_REST_Response.
	 */
	public function getCategories(\WP_REST_Request $request)
	{
		$query = new \WP_Term_Query([
			'taxonomy' => 'category',
			'hide_empty' => false
		]);

		$categories = [];
		$terms = $query->terms;
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
}