<?php
namespace WPNS\Controller;

use Illuminate\Http\Request as Request;
use Illuminate\Routing\Controller as Controller;
use WPNS\Database\Posts as Posts;

class UserController extends Controller
{
    protected $request;

    public function __construct()
    {
        $this->request = Request::capture();
    }

    /**
     * 
     *
     * @param  string  $name
     * @return 
     */
    public function store($name = '')
    {
        return $this->request->input('s');
    }

    public function getPost()
    {
        $posts = new Posts;
        //var_dump($this->store());
        $list = $posts->where('post_title', 'LIKE', '%' . $this->store() . '%')
                ->where('post_status', 'publish')
                ->get();

        $list->each(function ($item, $key) {
            var_dump($item->post_type);
        });
    }



}