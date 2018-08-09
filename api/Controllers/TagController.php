<?php
/**
 * Created by PhpStorm.
 * User: entymon
 * Date: 09/08/2018
 * Time: 19:03
 */

namespace Smooth\Api\Controllers;


class TagController extends Controller
{
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
}