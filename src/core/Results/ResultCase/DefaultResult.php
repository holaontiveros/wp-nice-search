<?php
namespace core\Results\ResultCase;

use core\Results\Results as Results;

/**
 * This class create a default list with title and icons
 * @package wpns
 * @since 1.0.6
 */
class DefaultResult extends Results
{
	/**
	 * Initiliaze
	 * @since 1.0.7
	 */
	public function __construct($s = '')
	{
		$this->keyword = $s;
		parent::__construct();
	}
	
	/**
	 * create a list results with featured image
	 * @return string $lists
	 */
	public function createList()
	{
		$list_style = $this->resultsWrap();
		$lists = '';
		$lists .= '<' . $list_style['heading_tag'] . '>';
		$lists .= $list_style['heading_text'];
		$lists .= '</' . $list_style['heading_tag'] .'>';
		$post_ids = parent::getPosts();
		if (empty($post_ids)) { 
			$lists .= '<p>No results are found.</p>';
			return $lists;
		}
		$lists .= '<ul class="list-results">';
		foreach ($post_ids as $id) {
			$post_title = get_the_title($id);
			$post_url = get_permalink($id);
			$lists .= '<li class="post-row">';
			$lists .= '<a class="post-title" href="' . $post_url . '">';
			$lists .= '<i class="fa fa-file-o"></i> ' . $post_title . '</a></li>';
		}
		$lists .= '</ul>';
		return $lists;
	}
}