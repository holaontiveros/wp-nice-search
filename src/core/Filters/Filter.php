<?php
namespace core\Filters;

class Filter
{
	/**
	 * Initiliaze
	 */
	public function __construct()
	{
		$this->registerFilter();
	}

	/**
	 * register filters
	 */
	public function registerFilter()
	{
		$format = 'test';
		$test = apply_filters('format_date', $format);
		//var_dump($test);
	}

}