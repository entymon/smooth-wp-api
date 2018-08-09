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
}