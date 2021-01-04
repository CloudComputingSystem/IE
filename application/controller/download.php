<?php


namespace application\controller;

require_once 'application/model/Model.php';
require_once 'application/model/FileModel.php';
session_start();

use application\model\Model;
use application\model\FileModel;

class download extends Controller
{
    public function test()
    {
        $fileModel = new FileModel();
        $file = $fileModel->findOne('14', '11');
        $path = realpath(dirname(__FILE__) . "/../../" . $file['path']);
        $content = file_get_contents($path);
        $fileDetail = array('name' => $file['name'], 'body' => $content);
        $jsonResponse = json_encode($fileDetail);
        var_dump($jsonResponse);
    }

    public function files()
    {
        $fileModel = new FileModel();
        $files = $fileModel->findAll($_SESSION['userId']);
        if ($files != null) {
            $jsonResponse = json_encode($files);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($files);
            http_response_code(200);
        } else {
            http_response_code(404);
            $jsonResponse = json_encode(array('message' => 'No File Is Found!'));
        }

        echo $jsonResponse;
    }

//    function file($id) {
//        $fileModel = new FileModel();
//        $file = $fileModel->findOne($id[2], $_SESSION['userId']);
//
//        $path1 = str_replace("\\", "/", $file['path']);
//        var_dump("http://localhost/CloudComputingSystem/".$path1);
////        $path = realpath(dirname(__FILE__) . "/../../" . $file['path']);
//        $ch = curl_init();
//        $timeout = 5;
////        var_dump($path1);
//        curl_setopt($ch, CURLOPT_URL, "http://localhost/CloudComputingSystem/".$path1);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
//        $data = curl_exec($ch);
//        var_dump($data);
//        curl_close($ch);
//        return $data;
//    }
    public function file($id)
    {
        $fileModel = new FileModel();
        $file = $fileModel->findOne($id[2], $_SESSION['userId']);

        $path = realpath(dirname(__FILE__) . "/../../" . $file['path']);
        $fileSize = filesize($path);
        header('Content-Description: File Transfer');
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: PUT, GET, POST");
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');

        if (file_exists($path) and session_status() != PHP_SESSION_NONE) {
//            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($path) . '"');
            header('Content-Length: ' . $fileSize);

            $begin = 0;
            $end = $fileSize;
            if (isset($_SERVER['HTTP_RANGE'])) {
                if (preg_match('/bytes=\h*(\d+)-(\d*)[\D.*]?/i', $_SERVER['HTTP_RANGE'], $matches)) {
                    $begin = intval($matches[0]);
                    if (!empty($matches[1]))
                        $end = intval($matches[1]);
                }
            }

            if ($begin < 0 || $end > $fileSize)
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
            else
                header('HTTP/1.0 200 OK');

            http_response_code(200);
            set_time_limit(0);
            $fileRead = @fopen($path, "rb");
            while (!feof($fileRead)) {
                if ($fileSize < 1024 * 8)
                    print @fread($fileRead, $fileSize);
                else
                    print @fread($fileRead, 1024 * 8);
                ob_flush();
                flush(); // Flush system output buffer
            }
            die();
        } else {
            http_response_code(404);
            die();
        }
    }


//    public function file($id)
//    {
//        $fileModel = new FileModel();
//        $file = $fileModel->findOne($id[2], $_SESSION['userId']);
//
//        $path = realpath(dirname(__FILE__) . "/../../" . $file['path']);
//        $fileSize = filesize($path);
//
//        if (file_exists($path) and session_status() != PHP_SESSION_NONE) {
//            header('Content-Description: File Transfer');
//            header('Content-Type: application/octet-stream');
//            header('Content-Disposition: attachment; filename="' . basename($path) . '"');
//            header('Expires: 0');
//            header('Cache-Control: must-revalidate');
//            header('Pragma: public');
//            header('Content-Length: ' . $fileSize);
//
//            $begin = 0;
//            $end = $fileSize;
//            if (isset($_SERVER['HTTP_RANGE'])) {
//                if (preg_match('/bytes=\h*(\d+)-(\d*)[\D.*]?/i', $_SERVER['HTTP_RANGE'], $matches)) {
//                    $begin = intval($matches[0]);
//                    if (!empty($matches[1]))
//                        $end = intval($matches[1]);
//                }
//            }
//
//            if ($begin < 0 || $end > $fileSize)
//                header('HTTP/1.1 416 Requested Range Not Satisfiable');
//            else
//                header('HTTP/1.0 200 OK');
//
//            http_response_code(200);
//            set_time_limit(0);
//            $fileRead = @fopen($path, "rb");
//            while (!feof($fileRead)) {
//                if ($fileSize < 1024 * 8)
//                    print @fread($fileRead, $fileSize);
//                else
//                    print @fread($fileRead, 1024 * 8);
//                ob_flush();
//                flush(); // Flush system output buffer
//            }
//            die();
//        } else {
//            http_response_code(404);
//            die();
//        }
//    }
}