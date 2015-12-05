<?php

namespace core\Results\ResultCase;

use core\Results\Results as Results;

/**
 * This class create a default list with title and icons
 * @package
 * @since 1.0.7
 */
class ImageResult extends Results
{

	/**
	 * create a list results with featured image
	 * @return string $lists
	 */
	public function createList()
	{
		$lists = '';
		$post_ids = $this->getPosts();
		if (empty($post_ids)) return $lists;
		$lists .= '<ul class="list-results imagelist">';
		foreach ($post_ids as $id) {
			$post_title = get_the_title($id);
			$post_url = get_permalink($id);
			$post_image_url = wp_get_attachment_thumb_url(
				get_post_thumbnail_id($id)
			);

			if ($post_image_url == '') {
				$post_image_url = WPNS_URL . 'assist/images/no_photo.jpg';
			}

			$lists .= '<li>';
				$lists .= '<img class="thumbnail" src="' . $post_image_url . '" alt="" width=50 />';
				$lists .= '<div class="post-information">';
					$lists .= '<a href="' . $post_url . '">' . $post_title . '</a>';
				$lists .= '</div>';
			$lists .= '</li>';
		}
		$lists .= '</ul>';
		return $lists;
	}
}