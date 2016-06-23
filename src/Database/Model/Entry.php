<?php
/**
 * [Description]
 * 
 * @author Duy Nguyen
 * @since  1.1.0
 */

namespace WPNS\Database\Model;

use Corcel\Post;
use Corcel\Options;

class Entry extends Post
{
	public function getFeaturedImageUrl()
	{
		if ($this->thumbnail()->getResults() == null) return null;

		return $this->thumbnail()->getResults()->attachment->guid;

	}

	public function author()
	{
		return $this->belongsTo('WPNS\Database\Model\Author', 'post_author')->getResults()->all()->all()[0];
	}

	public function terms()
	{
		$terms = [];

		foreach ($this->taxonomies()->getResults()->all() as $tax) {

			$terms[] = $tax->term()->getResults()->name;

		}

		return $terms;
	}

	public function getPermalink()
	{
		$permalink = '';

		$url = Options::get('home') . '?p=' . $this->ID;

		$search = '/\?p=.*/';

		$structure = Options::get('permalink_structure');

		if ($structure == '/%postname%/') {

			$permalink = preg_replace($search, $this->getSlugAttribute(), $url);

		}

		return $permalink;
	}
}