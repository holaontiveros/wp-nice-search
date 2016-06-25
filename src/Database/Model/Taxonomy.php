<?php
/**
 * [Description]
 * 
 * @author Duy Nguyen
 * @since  1.1.0
 */

namespace WPNS\Database\Model;

use Corcel\TermTaxonomy;

class Taxonomy extends TermTaxonomy
{
	public function term()
	{
		return $this->belongsTo('WPNS\Database\Model\Terms', 'term_id');
	}
}