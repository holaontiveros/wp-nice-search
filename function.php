<?php
ini_set('display_errors', 'On');
use Illuminate\Http\Request as Request;
use WPNS\Controller\UserController as UserController;

require __DIR__ . '/vendor/autoload.php';

$params = array(
    'database'  => 'thebest',
    'username'  => 'root',
    'password'  => 'root',
    'prefix'    => 'wp_'
);

Corcel\Database::connect($params);

$data = new UserController;

$ids = $data->search();

var_dump($ids);

exit();