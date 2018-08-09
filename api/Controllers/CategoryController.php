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
	const FIRST_ELEMENT = 0;

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

	/**
	 * Get category by ID
	 *
	 * @param \WP_REST_Request $request
	 * @return \WP_REST_Response.
	 */
	public function getCategoryById(\WP_REST_Request $request)
	{
		$query = new \WP_Term_Query([
			'taxonomy' => 'category',
			'hide_empty' => false,
			'term_taxonomy_id' => (int) $request->get_param('id'),
		]);
		$terms = $query->terms;

		$category = null;
		if (!empty($terms)) {
			$category = $this->service->getTermResponse($terms[self::FIRST_ELEMENT]);
		}

		$response = $this->service->getResponse(count($terms), $category);
		return new \WP_REST_Response($response, 200);
	}
}