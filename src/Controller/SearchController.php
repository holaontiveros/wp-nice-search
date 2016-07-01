<?php
/**
 * 
 *
 * @author Duy Nguyen
 * @since  1.1.0
 */

namespace WPNS\Controller;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use WPNS\Database\Model\Entry;
use WPNS\Database\Model\Settings;
use Corcel\Options;

class SearchController extends Controller
{
    protected $request;

    public function __construct()
    {
        $this->request = Request::capture();
    }

    public function getInput($name)
    {
        return $this->request->input($name);
    }

    public function search()
    {
        $options = $this->getOptions();

        $list = Entry::where('post_title', 'LIKE', '%' . $this->getInput('s') . '%');

        if ($this->getInput('onlySearch') != '') {

            $list = $list->where('post_type', $this->getInput('onlySearch'));

        } else {

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
        }

        $list = $list->where('post_status', 'publish');

        //$list = $list->where('post_status', 'publish')->pluck('ID')->all();

        //var_dump($list->where('post_status', 'publish')->take(1)->paged(1)->all());

        // $list = $list->where('post_status', 'publish')->get()->all();

        $list = $list->take(0)->paged(1, $this->getInput('page'))->all();

        return $list;

    }

    public function getOptions()
    {
        $settings = new Options;

        return unserialize($settings->where('option_name', 'wpns_options')->first()->option_value);
    }

}