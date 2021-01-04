<?php
include('system/config.php');
include(__DIR__ . '/system/router/Routing.php');
include('system/traits/Redirect.php');
include('system/traits/View.php');
include('application/controller/Controller.php');
include('system/bootstrap/boot.php');

//include ('model/CreateDB.php');
//use model\CreateDB;

//$db = new CreateDB();
//$db->run();

//use \Psr\Http\Message\ServerRequestInterface as Request;
//use \Psr\Http\Message\ResponseInterface as Response;
//
//$app = new \Slim\App;
//
//$app->get('/api/customers', function (Request $request, Response $response) {
//    echo 'Customers';
//});