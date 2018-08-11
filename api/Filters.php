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

		add_filter( 'rest_authentication_errors', [new FilterService(), 'checkIfConnectionAllowed'], 10, 1 );

		add_filter( 'rest_authentication_errors', [new FilterService(), 'restrictAccessForUpdates'], 10, 1 );

		add_filter( 'rest_api_init', [new FilterService(), 'restrictRestApiToHosts']);
	}
}