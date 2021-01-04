<?php

namespace application\controller;

require_once 'application/model/UserModel.php';
require 'system/vendor/autoload.php';
// generate json web token
include_once 'system/vendor/firebase/php-jwt/src/BeforeValidException.php';
include_once 'system/vendor/firebase/php-jwt/src/ExpiredException.php';
include_once 'system/vendor/firebase/php-jwt/src/SignatureInvalidException.php';
include_once 'system/vendor/firebase/php-jwt/src/JWT.php';

use application\model\UserModel;
use \Firebase\JWT\JWT;

class user extends Controller
{
    function __construct()
    {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
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
//            if ($_SERVER['REQUEST_METHOD'] === "POST") {
//                $this->redirect('home/home');
//                $data = json_decode(file_get_contents("php://input"));
//                if (!empty($data->jwt)) {
//                    http_response_code(200);
//                    echo json_encode(array("status" => 1, "message" => "we got jwt token."));
//                }
//            }
            $userModel = new UserModel();
            $user = $userModel->checkUserExists('email', $_POST['email']);
            if ($user != null) {
                if (password_verify($_POST['password'], $user['password'])) {
                    $this->setSession($user);
                    if ($this->auth($user)) {
                        http_response_code(200);

                        echo json_encode(array("status" => 200, "message" => "you login"));
//                        echo json_encode(array("message" => "successful login!", "jwt" => $jwt, "expireAt" => $exp));

// echo json_encode($this->auth($user));
 $this->redirect('home/home');
                    }
                }
            } else {
                http_response_code(401);
                echo json_encode(array("message" => "login failed!"));
// $this->redirectBack();
            }
        }
    }


    function jwt_request($token, $post) {

        header('Content-Type: application/json'); // Specify the type of data
        $ch = curl_init('http://localhost/CloudComputingSystem/user/login'); // Initialise cURL
        $post = json_encode($post); // Encode the data array into a JSON string
        $authorization = "Authorization: Bearer ".$token; // Prepare the authorisation token
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization )); // Inject the token into the header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1); // Specify the request method as POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post); // Set the posted fields
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // This will follow any redirects
        $result = curl_exec($ch); // Execute the cURL statement
        curl_close($ch); // Close the cURL connection
        return json_decode($result); // Return the received data

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

    public function volume($userId)
    {
        $maxVolume = 4 * 1024 * 1024 * 1024;
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
}