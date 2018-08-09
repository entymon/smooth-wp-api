<?php

namespace Smooth\Api\Services;

use Smooth\Api\Entities\Post;

class PostService extends Service
{
	const FIRST_ELEMENT = 0;

	/**
	 * @param \WP_Post $post
	 * @return \Smooth\Api\Entities\Post
	 */
	public function getPostResponse(\WP_Post $post)
	{
		$object = new Post();
		$object->id = $post->ID;
		$object->type = $post->post_type;
		$object->status = $post->post_status;
		$object->slug = $post->post_name;
		$object->author = $post->post_author;
		$object->title = $post->post_title;
		$object->content = $post->post_content;
		$object->excerpt = $post->post_excerpt;
		$object->category = $this->getCategory($post->ID);
		$object->tags = $this->getTags($post->ID);
		$object->modifiedAt = $post->post_modified;
		$object->createdAt = $post->post_date;

		return $object;
	}

	/**
	 * Get post category
	 *
	 * @param $postId
	 * @return null \ \Smooth\Api\Entities\Category
	 */
	private function getCategory($postId)
	{
		$categories = get_the_category($postId);
		if (!empty($categories)) {
			return TermService::getTermResponse($categories[self::FIRST_ELEMENT]);
		}
		return null;
	}

	/**
	 * Get post tags
	 *
	 * @param $postId
	 * @return array [\Smooth\Api\Entities\Category]
	 */
	private function getTags($postId)
	{
		$tags = [];
		$terms = get_the_tags($postId);
		if (!empty($terms)) {
			foreach ($terms as $tag) {
				$tags[] = TermService::getTermResponse($tag);
			}
		}
		return $tags;
	}
}