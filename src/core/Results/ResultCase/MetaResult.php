<?php
namespace core\Results\ResultCase;

use core\Results\Results as Results;

/**
 * This class create a default list with title and icons
 * @package wp-nice-search
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
		$list_style = $this->resultsWrap();
		$lists = '';
		$lists .= '<' . $list_style['heading_tag'] . '>';
		$lists .= $list_style['heading_text'];
		$lists .= '</' . $list_style['heading_tag'] .'>';
		$post_ids = $this->getPosts();

		if (empty($post_ids)) return $lists;

		$lists .= '<ul class="list-results metalist">';

		foreach ($post_ids as $id) {
			$post_obj = get_post($id);
			$post_title = $post_obj->post_title;
			$post_url = get_permalink($id);
			$post_image_url = wp_get_attachment_thumb_url(
				get_post_thumbnail_id($id)
			);

			// post date
			$format = 'd M, Y';
			$post_date = get_the_date(apply_filters('format_date', $format), $id);
			// get author
			$author = $this->getAuthor($post_obj->post_author);
			// get terms
			$post_terms = $this->getTerms($post_obj);
			// icon array
			$icons = apply_filters(
				'metabox_icon',
				array(
					'icon_date' => 'fa fa-circle',
					'icon_terms' => 'fa fa-circle',
					'icon_author' => 'fa fa-circle'
				)
			);
			// create the list results
			$lists .= '<li>';
			$lists .= '<a href="' . $post_url . '">' . $post_title . '</a>';
			$lists .= '<div class="post-information">';
				$lists .= '<div class="metabox">';
					$lists .= '<span class="post-date">' . $icons['icon_date'] . $post_date . '</span>';
					if (!empty($post_terms)) {
						$lists .= '<span class="post-term">' . $icons['icon_terms'];
						$lists .= @implode(', ', $post_terms);
						$lists .= '</span>';
					}
					$lists .= '<span class="post-author">' . $icons['icon_author'] . '<a href="' . $author['author_url'] . '">' . $author['author_nicename'] . '</a></span>';
				$lists .= '</div>';
			$lists .= '</div>';
			$lists .= '</li>';
		}

		$lists .= '</ul>';

		return $lists;
	}

}