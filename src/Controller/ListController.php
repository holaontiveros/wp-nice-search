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

		foreach ($results as $result) {

			$title = $result->getTitleAttribute();

			$url = $result->getPermalink();

			// get featured image
			$thumbnailUrl = $result->getThumbnailUrl();

			if ($thumbnailUrl == '') $thumbnailUrl = WPNS_IMAGES . 'no_photo.jpg';

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
			$lists .= '<li class="row post-row">';

			if (array_key_exists('wpns_items_featured', $options)) {

				$lists .= '<div class="col-md-1 thumbnail-col">';

				$lists .= '<img class="thumbnail" src="' . $thumbnailUrl . '" alt="" width=50 />';

				$lists .= '</div>';

			}

			$lists .= '<div class="col-md-11 post-information">';

				$lists .= '<h4><a class="post-title" href="' . $url . '">' . $title . '</a></h4>';

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

		return $lists;

	}

}