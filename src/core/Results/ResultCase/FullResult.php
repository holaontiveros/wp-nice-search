<?php

namespace core\Results\ResultCase;

use core\Results\Results as Results;

/**
 * This class create a default list with title and icons
 * @package wpns
 * @since 1.0.7
 */
class FullResult extends Results
{
	/**
	 * Initiliaze
	 * @since 1.0.7
	 */
	public function __construct($s = '')
	{
		$this->keyword = $s;
		parent::__construct();
	}

	/**
	 * create a list results with full compnents
	 * @uses getPosts()
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
			$lists .= '<p>No results are found.</p>';
			return $lists;
		}

		$lists .= '<ul class="list-results fulllist">';

		foreach ($post_ids as $id) {
			$post_obj = get_post($id);
			$post_title = $post_obj->post_title;
			$post_url = get_permalink($id);
			$post_image_url = wp_get_attachment_thumb_url(
				get_post_thumbnail_id($id)
			);

			// featured image
			if ($post_image_url == '') {
				$no_image = WPNS_URL . 'assist/images/no_photo.jpg';
				$post_image_url = apply_filters('no_image', $no_image);
			}
			// get terms
			$post_terms = $this->getTerms($post_obj);
			// get author
			$author = $this->getAuthor($post_obj->post_author);
			// get date
			$format = 'd M, Y';
			$post_date = get_the_date(apply_filters('format_date', $format), $id);
			// icon array
			$icons = apply_filters(
				'metabox_icon',
				array(
					'icon_date' => '<i class="fa fa-circle"></i>',
					'icon_terms' => '<i class="fa fa-circle"></i>',
					'icon_author' => '<i class="fa fa-circle"></i>'
				)
			);

			// create the list results
			$lists .= '<li class="post-row">';
			$lists .= '<div class="thumbnail-col">';
			$lists .= '<img class="thumbnail" src="' . $post_image_url . '" alt="" width=50 />';
			$lists .= '</div>';
			$lists .= '<div class="post-information">';
				$lists .= '<a class="post-title" href="' . $post_url . '">' . $post_title . '</a>';
				$lists .= '<div class="metabox">';
					$lists .= '<span class="wpns-post-date">' . $icons['icon_date'] . '<date>' . $post_date . '</date></span>';
					if (!empty($post_terms)) {
						$lists .= '<span class="wpns-post-term">' . $icons['icon_terms'];
						$lists .= @implode(', ', $post_terms);
						$lists .= '</span>';
					}
					$lists .= '<span class="wpns-post-author">' . $icons['icon_author'] . '<a href="' . $author['author_url'] . '">' . $author['author_nicename'] . '</a></span>';
				$lists .= '</div>';
			$lists .= '</div>';
			$lists .= '</li>';
		}

		$lists .= '</ul>';

		return $lists;
	}
}