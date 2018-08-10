<?php
/**
 * Created by PhpStorm.
 * User: entymon
 * Date: 09/08/2018
 * Time: 19:19
 */

namespace Smooth\Api\Entities;

class Post
{
	public $id;
	public $type;
	public $status;
	public $slug;
	public $author;
	public $title;
	public $imageUrl;
	public $content;
	public $excerpt;
	public $category;
	public $tags;
	public $modifiedAt;
	public $createdAt;
}