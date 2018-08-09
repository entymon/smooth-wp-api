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
		$object->description = $term->description;

		return $object;
	}
}