<?php
/**
 * Created by PhpStorm.
 * User: entymon
 * Date: 09/08/2018
 * Time: 23:30
 */

namespace Smooth\Api\Services;


class FilterService
{
	private $allowedHosts = [];
	
	public function __construct()
	{
		$this->allowedHosts[] = getenv('ALLOWED_DEV_API_HOST');
		$this->allowedHosts[] = getenv('ALLOWED_PROD_API_HOST');
		$this->allowedHosts[] = getenv('ALLOWED_DEV_FRONT_END');
		$this->allowedHosts[] = getenv('ALLOWED_PROD_FRONT_END');
		$this->allowedHosts[] = getenv('ALLOWED_PROD_FRONT_END_2');
	}

	/**
	 * Filter function for extendGetPostsQuery()
	 *
	 * @param $where
	 * @param $wp_query
	 * @return string
	 */
	public function keywordPostsWhere( $where, $wp_query )
	{
		global $wpdb;
		if ($keyword = $wp_query->get('keyword')) {
			$escapedValue = esc_sql($wpdb->esc_like($keyword));
			$query = " AND ({$wpdb->prefix}posts.post_title LIKE %{$escapedValue}% OR {$wpdb->prefix}posts.post_content LIKE %{$escapedValue}%) ";
			$where .= $query;
		}
		return $where;
	}

	public function checkIfConnectionAllowed($result)
	{
		if (!empty($result)) return $result;
		if (!in_array($_SERVER['HTTP_HOST'], $this->allowedHosts)) {
			return new \WP_Error( 'rest_not_logged_in', 'You are not allowed to see this content.', array( 'status' => 403 ) );
		}
		return $result;
	}
}
