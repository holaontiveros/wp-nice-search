<?php
/**
 * [Description]
 * 
 * @author Duy Nguyen
 * @since  1.1.0
 */

namespace WPNS\Database\Model;

use Corcel\User;
use Corcel\Options;

class Author extends User
{
	public function getAuthorFullName()
	{
		if ($this->first_name != '' && $this->last_name != '') {

			$authorName = $this->first_name . ' ' . $this->last_name;

		} else {

			$authorName = $this->login;

		}

		return $authorName;
	}

	public function getAuthorUrl()
	{
		$options = new Options;

		$url = $options->where('option_name', 'home')->first()->option_value . '?author=' . $this->ID;

		$search = '/\?author=.*/';

		$permalink = preg_replace($search, 'author/' . $this->getLoginAttribute(), $url);

		return $permalink;
	}

}