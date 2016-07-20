<?php
ini_set('display_errors', 'On');
use Illuminate\Http\Request as Request;
use WPNS\Controller\SearchController as SearchController;
use WPNS\Controller\ListController as ListController;

require __DIR__ . '/vendor/autoload.php';

var_dump($_SERVER);

$imageUrl = $_SERVER['HTTP_REFERER'] . 'wp-content/plugins/wp-nice-search/assist/images/';

define('WPNS_IMAGES', $imageUrl);

$params = array(
    'database'  => 'thebest',
    'username'  => 'root',
    'password'  => 'root',
    'prefix'    => 'wp_'
);

Corcel\Database::connect($params);

$list = new ListController;

$html = $list->createList(new SearchController);

echo json_encode($html);

exit;

