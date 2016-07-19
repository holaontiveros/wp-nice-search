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
	public function getThumbnailMeta()
	{
		var_dump($this->thumbnail()->getResults());
	}

	public function getFeaturedImageUrl()
	{
		if ($this->thumbnail()->getResults() == null) return null;

		return $this->thumbnail()->getResults()->attachment->guid;

	}

	public function taxonomies()
	{
		return $this->belongsToMany('WPNS\Database\Model\Taxonomy', 'term_relationships', 'object_id', 'term_taxonomy_id');
	}

	public function author()
	{
		return $this->belongsTo('WPNS\Database\Model\Author', 'post_author')->getResults()->all()->all()[0];
	}

	public function terms()
	{
		$terms = [];

		foreach ($this->taxonomies()->getResults()->all() as $tax) {

			$terms[] = '<a href="' . $tax->term()->getResults()->getTermUrl() . '">' . $tax->term()->getResults()->name . '</a>';

		}

		return $terms;
	}

	public function getPermalink()
	{
		$permalink = '';

		$setting = new Options;

		$url = $setting->where('option_name', 'home')->first()->option_value . '?p=' . $this->ID;

		$search = '/\?p=.*/';

		$structure = $setting->where('option_name', 'permalink_structure')->first()->option_value;

		if ($structure == '/%postname%/') {

			$permalink = preg_replace($search, $this->getSlugAttribute(), $url);

		}

		return $permalink;
	}
}