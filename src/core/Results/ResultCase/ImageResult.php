<?php

namespace WPNS\WPNS\core\Results\ResultCase;

use WPNS\core\Results\Results as Results;

/**
 * This class create a default list with title and icons
 * @package
 * @since 1.0.7
 */
class ImageResult extends Results
{
	/**
	 * Initiliaze
	 */
	public function __construct($s = '')
	{
		$this->keyword = $s;
		parent::__construct();
	}
	
	/**
	 * create a list results with featured image
	 * @return string $lists
	 */
	public function createList()
	{
		$list_style = $this->resultsWrap();
		$lists = '';
		$lists .= '<' . $list_style['heading_tag'] . '>';
		$lists .= $list_style['heading_text'];
		$lists .= '</' . $list_style['heading_tag'] .'>';
		$post_ids = $this->getPosts();
		if (empty($post_ids)) { 
			$lists .= '<p class="no-results">';
			$lists .= apply_filters('no_results', __('No results are found.'));
			$lists .= '</p>';
			return $lists;
		}
		$lists .= '<ul class="list-results imagelist">';
		foreach ($post_ids as $id) {
			$post_title = get_the_title($id);
			$post_url = get_permalink($id);
			$post_image_url = wp_get_attachment_thumb_url(
				get_post_thumbnail_id($id)
			);

			// featured image
			if ($post_image_url == '') {
				$no_image = WPNS_URL . 'assist/images/no_photo.jpg';
				$post_image_url = apply_filters('no_image', $no_image);
			}

			$lists .= '<li class="post-row">';
				$lists .= '<div class="thumbnail-col">';
				$lists .= '<img class="thumbnail" src="' . $post_image_url . '" alt="" width=50 />';
				$lists .= '</div>';
				$lists .= '<div class="post-information">';
					$lists .= '<a class="post-title" href="' . $post_url . '">' . $post_title . '</a>';
				$lists .= '</div>';
			$lists .= '</li>';
		}
		$lists .= '</ul>';
		return $lists;
	}
}