<?php
use Illuminate\Http\Request as Request;
use WPNS\Controller\UserController as UserController;
use WPNS\Database\Posts as Posts;

require __DIR__ . '/vendor/autoload.php';

$params = array(
    'database'  => 'thebest',
    'username'  => 'root',
    'password'  => 'root',
    'prefix'    => 'wp_'
);

Corcel\Database::connect($params);

$data = new UserController;

$data->getPost();

exit();