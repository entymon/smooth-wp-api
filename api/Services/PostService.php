<?php

namespace Smooth\Api\Services;

use Smooth\Api\Entities\Post;

class PostService extends Service
{
	const FIRST_ELEMENT = 0;

	/**
	 * Returns total number of posts
	 * by default: published
	 *
	 * @param string $status
	 * @return int
	 */
	public function getNumberOfPosts($status = 'publish')
	{
		global $wpdb;
		$query = sprintf("SELECT COUNT(*) AS count FROM {$wpdb->prefix}posts AS p WHERE p.post_status = '%s' AND p.post_type = 'post'", $status);
		$result = $wpdb->get_row($query, OBJECT);
		if ($result) {
			return (int)$result->count;
		}
		return 0;
	}

	/**
	 * Returns total number of post for given category
	 *
	 * @param $categorySlug
	 * @param string $status
	 * @return int
	 */
	public function getNumberOfPostsInCategory($categorySlug, $status = 'publish')
	{
		global $wpdb;
		$query = sprintf(
			"SELECT COUNT(*) AS count 
							FROM {$wpdb->prefix}posts AS p 
							LEFT JOIN {$wpdb->prefix}term_relationships as tr ON tr.object_id = p.ID
							LEFT JOIN {$wpdb->prefix}terms as t ON t.term_id = tr.term_taxonomy_id
							WHERE p.post_status = '%s' AND p.post_type = 'post' AND t.slug = '%s'",
			$status, $categorySlug);
		$result = $wpdb->get_row($query, OBJECT);
		if ($result) {
			return (int)$result->count;
		}
		return 0;
	}

	/**
	 * Get total of posts by keyword
	 *
	 * @param $keyword
	 * @return null
	 */
	public function getCountPostsByKeyword($keyword)
	{
		global $wpdb;
		$query = "SELECT count(*) AS amount FROM {$wpdb->prefix}posts AS p WHERE p.post_title LIKE '%{$keyword}%' OR p.post_content LIKE '%{$keyword}%'";
		$result = $wpdb->get_row($query);
		if ($result) {
			return $result->amount;
		}
		return null;
	}

	/**
	 * Get results by keyword
	 *
	 * @param $keyword
	 * @param int $page
	 * @param int $limit
	 * @return array
	 */
	public function getPostsByKeyword($keyword, $page = 0, $limit = -1)
	{
		global $wpdb;
		$query = "SELECT * FROM {$wpdb->prefix}posts AS p WHERE p.post_title LIKE '%{$keyword}%' OR p.post_content LIKE '%{$keyword}%' ";

		if ($limit !== -1 && $page !== 1) {
			$offset = ($page - 1) * $limit;
			$query .= " LIMIT {$limit} OFFSET {$offset}";
		} elseif ($limit !== -1) {
			$query .= " LIMIT {$limit}";
		}

		$result = $wpdb->get_results($query);
		if ($result) {
			return $result;
		}
		return [];
	}

	/**
	 * @param int $total
	 * @param int $limit
	 * @param int $page
	 * @param array $data
	 * @return array
	 */
	public function getResponse($total = 0, $limit = -1, $page = 1, $data = [])
	{
		return [
			'meta' => [
				'totalItems' => round($total, 0),
				'totalPages' => ($limit !== -1 && $limit !== 0) ? ceil($total / $limit) : 1,
				'currentPage' => $page,
				'limit' => $limit,
			],
			'data' => $data
		];
	}

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
		$object->imageUrl = $this->getImage($post->ID);
		$object->content = $post->post_content;
		$object->excerpt = $post->post_excerpt;
		$object->category = $this->getCategory($post->ID);
		$object->tags = $this->getTags($post->ID);
		$object->modifiedAt = $post->post_modified;
		$object->createdAt = $post->post_date;

		return $object;
	}

	/**
	 * @param \stdClass $post
	 * @return \Smooth\Api\Entities\Post
	 */
	public function getPostResponseStdClass(\stdClass $post)
	{
		$object = new Post();
		$object->id = $post->ID;
		$object->type = $post->post_type;
		$object->status = $post->post_status;
		$object->slug = $post->post_name;
		$object->author = $post->post_author;
		$object->title = $post->post_title;
		$object->imageUrl = $this->getImage($post->ID);
		$object->content = $post->post_content;
		$object->excerpt = $post->post_excerpt;
		$object->category = $this->getCategory($post->ID);
		$object->tags = $this->getTags($post->ID);
		$object->modifiedAt = $post->post_modified;
		$object->createdAt = $post->post_date;

		return $object;
	}

	public function getImage($postId)
	{
		$imageUrl = '';
		if (has_post_thumbnail($postId)) {
			$imageData = wp_get_attachment_image_src(get_post_thumbnail_id($postId), 'single-post-thumbnail');
			if (!empty($imageData)) {
				return $imageData[self::FIRST_ELEMENT];
			}
		}
		return $imageUrl;
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