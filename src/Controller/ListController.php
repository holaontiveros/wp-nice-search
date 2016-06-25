<?php
/**
 * 
 * @author Duy Nguyen
 * @since  1.1.0
 */

namespace WPNS\Controller;

use Illuminate\Routing\Controller as Controller;
use WPNS\Controller\SearchController;

class ListController extends Controller
{
	public function createList(SearchController $search)
	{
		$results = $search->search();

		$options = $search->getOptions();

		$lists = '';

		$lists .= '<ul class="list-results">';

		foreach ($results as $result) {

			$title = $result->getTitleAttribute();

			$url = $result->getPermalink();

			//$url = '';

			// get featured image
			$featuredImage = $result->getFeaturedImageUrl();

			// get terms
			$terms = $result->terms();

			// get author
			$authorName = $result->author()->getAuthorFullName();

			$authorUrl = $result->author()->getAuthorUrl();

			// get date
			$format = 'd M, Y';

			$publishDate = $result->getCreatedAtAttribute()->format($format);

			$icons = [
				'icon_date' => '<i class="fa fa-circle"></i>',
				'icon_terms' => '<i class="fa fa-circle"></i>',
				'icon_author' => '<i class="fa fa-circle"></i>'
			];

			// create the list results
			$lists .= '<li class="post-row">';

			if (array_key_exists('wpns_items_featured', $options)) {

				$lists .= '<div class="thumbnail-col">';

				$lists .= '<img class="thumbnail" src="' . $featuredImage . '" alt="" width=50 />';

				$lists .= '</div>';

			}

			$lists .= '<div class="post-information">';

				$lists .= '<a class="post-title" href="' . $url . '">' . $title . '</a>';

			if (array_key_exists('wpns_items_meta', $options)) {

				$lists .= '<div class="metabox">';

					$lists .= '<span class="wpns-post-date">' . $icons['icon_date'] . '<date>' . $publishDate . '</date></span>';

					if (!empty($terms)) {

						$lists .= '<span class="wpns-post-term">' . $icons['icon_terms'];

						$lists .= implode(', ', $terms);

						$lists .= '</span>';

					}

					$lists .= '<span class="wpns-post-author">' . $icons['icon_author'] . '<a href="' . $authorUrl . '">' . $authorName . '</a></span>';

				$lists .= '</div>';
				
			}

			$lists .= '</div>';

			$lists .= '</li>';
		}

		$lists .= '</ul>';

		return $lists;

	}

}