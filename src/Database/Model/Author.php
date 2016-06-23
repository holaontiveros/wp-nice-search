<?php
/**
 * [Description]
 * 
 * @author Duy Nguyen
 * @since  1.1.0
 */

namespace WPNS\Database\Model;

use Corcel\User;

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
		return $this->url;	
	}

}