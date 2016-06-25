<?php
/**
 * [Description]
 * 
 * @author Duy Nguyen
 * @since  1.1.0
 */

namespace WPNS\Database\Model;

use Corcel\Term;
use Corcel\Options;

class Terms extends Term
{
	public function getTermUrl()
	{
		$termName = $this->slug;

		$taxonomy = $this->getTaxonomy()->getResults()->taxonomy;

		$options = new Options;

		$url = $options->where('option_name', 'home')->first()->option_value;

		if ($taxonomy == 'category') {

			$url .= 'category/' . $termName;

		} else {

			$url .= $taxonomy . '/' . $termName;

		}

		return $url;

	}

	public function getTaxonomy()
	{
		return $this->belongsTo('WPNS\Database\Model\Taxonomy', 'term_id');
	}
}