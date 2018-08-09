<?php
/**
 * Created by PhpStorm.
 * User: entymon
 * Date: 09/08/2018
 * Time: 19:09
 */

namespace Smooth\Api\Services;

use Smooth\Api\Entities\Category;

class TermService extends Service
{
	/**
	 * Get Category | Term
	 *
	 * @param \WP_Term $term
	 * @return \Smooth\Api\Entities\Category
	 */
	public static function getTermResponse(\WP_Term $term)
	{
		$object = new Category();
		$object->id = $term->term_id;
		$object->name = $term->name;
		$object->slug = $term->slug;
		$object->itemsIn = $term->count;
		$object->description = $term->description;

		return $object;
	}

	/**
	 * @param int $total
	 * @param int $limit
	 * @param int $page
	 * @param array $data
	 * @return array
	 */
	public function getResponse($total = 0, $data = [])
	{
		return [
			'meta' => [
				'totalItems' => $total,
			],
			'data' => $data
		];
	}

	/**
	 * Gets term ID by slug
	 *
	 * @return null | int
	 */
	public function getCategoryIdBySlug($slug)
	{
		global $wpdb;
		$query = sprintf("SELECT t.term_id AS termId FROM {$wpdb->prefix}terms AS t WHERE slug = '%s'", $slug);
		$result = $wpdb->get_row($query, OBJECT);

		if ($result) {
			return (int) $result->termId;
		}
		return null;
	}
}