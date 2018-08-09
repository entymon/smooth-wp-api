<?php
/**
 * Created by PhpStorm.
 * User: entymon
 * Date: 09/08/2018
 * Time: 23:31
 */

namespace Smooth\Api;


use Smooth\Api\Services\FilterService;

class Filters
{
	public function init()
	{
		add_filter( 'posts_where', [new FilterService(), 'keywordPostsWhere'], 10, 2 );
	}
}