<?php

namespace application\controller;


require_once 'application/model/UserModel.php';
require 'system/vendor/autoload.php';

use application\model\UserModel;
use \Firebase\JWT\JWT;
use PDOException;

class user extends Controller
{
    function __construct()
    {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
    }

    public function auth($user)
    {
        $privateKey = "privateKey";
        $iat = time();
        $exp = $iat + 60 * 60;
        $token = array(
            "iss" => "http://localhost/CloudComputingSystem/user/login",
            "aud" => "http://localhost/CloudComputingSystemttest/",
            "iat" => $iat,
            "nbf" => $iat + 10,
            "exp" => $exp,
            "data" => array(
                "id" => $user['id'],
                "userName" => $user['user_name'],
                "email" => $user['email']
            ));
        $jwt = JWT::encode($token, $privateKey, 'HS512');
        return array('token' => $jwt, 'expires' => $exp);
    }

    public function registration()
    {
        return $this->view('register');
    }

    public function register()
    {
        if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['repeatPassword'])) {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to register the user."));
            $this->redirectBack();
        } else if (strlen($_POST['password'] < 8)) {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to register the user."));
            $this->redirectBack();
        } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to register the user."));
            $this->redirectBack();
        } else if ($_POST['password'] != $_POST['repeatPassword'])
            $this->redirectBack();
        else {
            $user = new UserModel();
            $checkUser = $user->checkUser(['email', 'user_name'], [$_POST['email'], $_POST['username']]);
            if ($checkUser == true) {
                http_response_code(400);
                $this->redirectBack();
            } else {
                $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $user->storeUser($_POST);
                $checkUser = $user->checkUser(['email', 'user_name'], [$_POST['email'], $_POST['username']]);
                $this->setSession($checkUser);
                $path = "resource\\" . $_POST['username'] . "_dir";
                mkdir($path);
                http_response_code(200);
                echo json_encode(array("message" => "user registered successfully."));
                $this->redirect('home/home');
            }
        }
    }

    public function login()
    {
        return $this->view('login');
    }

    public function userLogin()
    {
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: PUT, GET, POST");
        if (empty($_POST['email']) || empty($_POST['password'])) {
            echo json_encode(array("message" => "login failed!"));
            $this->redirectBack();
        } else {
            $userModel = new UserModel();
            $user = $userModel->checkUserExists('email', $_POST['email']);
            if ($user != null) {
                if (password_verify($_POST['password'], $user['password'])) {
                    $this->setSession($user);
                    if ($this->auth($user)) {
                        http_response_code(200);

                        echo json_encode(array("status" => 200, "message" => "you login"));
//                        echo json_encode(array("message" => "successful login!", "jwt" => $jwt, "expireAt" => $exp));

                        $this->redirect('home/home');
                    }
                }
            } else {
                http_response_code(401);
                echo json_encode(array("message" => "login failed!"));
                $this->redirectBack();
            }
        }
    }

    public function volume($userId)
    {
        $maxVolume = 1024 * 1024 * 1024;
//        $maxVolume = 4 * 1024 * 1024 * 1024;
        $totalVolume = 0;
        $userModel = new UserModel();
        $file = $userModel->getVolume($userId);
        foreach ($file as $key => $value) {
            if ($value != null)
                $totalVolume = $totalVolume + $value['content_length'];
        }
        $remindedVolume = ($totalVolume * 100) / $maxVolume;
        if ($remindedVolume < 1)
            $remindedVolume = 1;
        return $remindedVolume;
    }

    public function setSession($user)
    {
        $_SESSION['loggedIn'] = true;
        $_SESSION['userId'] = $user['id'];
        $_SESSION['userName'] = $user['user_name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['message'] = "you are logged in!";
        $_SESSION['logIn_time'] = time();
        setcookie($_SESSION['userName'], 'imdb', time() + 3600);
    }
}