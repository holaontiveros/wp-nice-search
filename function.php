<?php
use Illuminate\Http\Request as Request;
use WPNS\Controller\SearchController as SearchController;
use WPNS\Controller\ListController as ListController;

require __DIR__ . '/vendor/autoload.php';

$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];

$fileUrl = pathinfo(str_replace($_SERVER['DOCUMENT_ROOT'], $root, $_SERVER['SCRIPT_FILENAME']));

define('ROOT_URL', $fileUrl['dirname']);
define('IMAGE_URL', ROOT_URL . '/assist/images');

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