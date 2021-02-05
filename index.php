<?php
session_start();
include('system/config.php');
include(__DIR__ . '/system/router/Routing.php');
include('system/traits/Redirect.php');
include('system/traits/View.php');
include('application/controller/Controller.php');
include('system/bootstrap/boot.php');

//include ('application/model/CreateDB.php');
//use application\model\CreateDB;
//
//$db = new CreateDB();
//$db->run();