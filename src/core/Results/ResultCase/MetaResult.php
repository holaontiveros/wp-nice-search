<?php

namespace core\Results\ResultCase;

use core\Results\Results as Results;

/**
 * This class create a default list with title and icons
 * @package
 * @since 1.0.7
 */
class MetaResult extends Results
{

	/**
	 * create a list results with featured image
	 *
	 * @TODO get terms for post
	 *
	 * @since 1.0.6
	 * @uses getPosts()
	 * @return string $lists
	 */
	public function createList()
	{
		$lists = '';
		$post_ids = $this->getPosts();

		if (empty($post_ids)) return $lists;

		$lists .= '<ul>';

		foreach ($post_ids as $id) {
			$post_obj = get_post($id);
			$post_title = $post_obj->post_title;
			$post_url = get_permalink($id);
			$post_image_url = wp_get_attachment_thumb_url(
				get_post_thumbnail_id($id)
			);
			$post_date = get_the_date('d M, Y', $id);
			$post_author = get_user_meta($post_obj->post_author);
			$first_name = $post_author['first_name'][0];
			$last_name = $post_author['last_name'][0];
			if ($first_name == '' && $last_name == '') {
				$post_author_name = $post_author['nickname'][0];
			} else {
				$post_author_name = $first_name . ' ' . $last_name;
			}
			//$post_terms = $this->getTerms($id);

			// create the list results
			$lists .= '<li>';
			$lists .= '<a href="' . $post_url . '">' . $post_title . '</a>';
			$lists .= '<span>';
				$lists .= '<span>' . $post_date . '</span>';
				$lists .= '<span>' . $post_author_name . '</span>';
			$lists .= '</span>';
			$lists .= '</li>';
		}

		$lists .= '</ul>';

		return $lists;
	}

}