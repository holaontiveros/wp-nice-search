<?php
/**
 * 
 *
 * @author Duy Nguyen
 * @since  1.1.0
 */

namespace WPNS\Controller;

use Illuminate\Http\Request as Request;
use Illuminate\Routing\Controller as Controller;
use Corcel\Post as Post;
use Corcel\Options as Options;

class SearchController extends Controller
{
    protected $request;

    public function __construct()
    {
        $this->request = Request::capture();
    }

    /**
     * 
     *
     * @param  string $name
     * @return string 
     */
    public function searchKeyword($name = '')
    {
        return $this->request->input('s');
    }

    public function search()
    {
        $options = $this->getOptions();

        $list = Post::where('post_title', 'LIKE', '%' . $this->searchKeyword() . '%');

        if ((array_key_exists('wpns_in_post', $options) && array_key_exists('wpns_in_page', $options) && array_key_exists('wpns_in_cpt', $options)) || array_key_exists('wpns_in_all', $options)) {
            
            $list = $list->whereNotIn('post_type', ['nav_menu_item', 'revision', 'attachment']);
          
        } elseif (array_key_exists('wpns_in_post', $options) && array_key_exists('wpns_in_page', $options)) {
            
            $list = $list->whereIn('post_type', ['post', 'page']);

        } elseif (array_key_exists('wpns_in_post', $options) && array_key_exists('wpns_in_cpt', $options)) {
            
            $list = $list->whereNotIn('post_type', ['page', 'nav_menu_item', 'revision', 'attachment']);

        } elseif (array_key_exists('wpns_in_page', $options) && array_key_exists('wpns_in_cpt', $options)) {
            
            $list = $list->whereNotIn('post_type', ['post', 'nav_menu_item', 'revision', 'attachment']);

        } elseif (array_key_exists('wpns_in_post', $options)) {

            $list = $list->where('post_type', 'post');

        } elseif (array_key_exists('wpns_in_page', $options)) {

            $list = $list->where('post_type', 'page');

        } else {

            $list = $list->whereNotIn('post_type', ['page', 'post', 'nav_menu_item', 'revision', 'attachment']);

        }


        $list = $list->where('post_status', 'publish')->pluck('ID')->all();

        return $list;

    }

    public function getOptions()
    {
        return Options::get('wpns_options');
    }

}