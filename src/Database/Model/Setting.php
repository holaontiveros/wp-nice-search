<?php
/**
 * [Description]
 * 
 * @author Duy Nguyen
 * @since  1.1.0
 */

namespace WPNS\Database\Model;

use Corcel\Options;

class Settings extends Options
{
	public function getSettings($key)
	{
		var_dump($key);
		var_dump($this->option_value);
		var_dump(unserialize($this->where('option_name', $key)->first()->option_value));
		return unserialize($this->where('option_name', $key)->first()->option_value);
	}	
}