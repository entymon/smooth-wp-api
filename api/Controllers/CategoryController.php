<?php
/**
 * Created by PhpStorm.
 * User: entymon
 * Date: 09/08/2018
 * Time: 19:01
 */

namespace Smooth\Api\Controllers;


class CategoryController extends Controller
{
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
}