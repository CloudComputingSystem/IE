<?php


namespace application\controller;

session_start();
require_once 'application/model/Model.php';
require_once 'application/model/FileModel.php';
include('user.php');

use application\model\Model;
use application\model\FileModel;


class home extends Controller
{
    public function getPicture($file)
    {
        $fileModel = new FileModel();
        $file = $fileModel->findOne($file[2], $_SESSION['userId']);
        $path = str_replace("\\", "/", $file['path']);
        $path = "../../" . $path;
        $file['path'] = $path;
        return $file;
    }

    public function resize($file)
    {
        $file = $this->getPicture($file);
        $image = null;
        if ($file['content_type'] == "image/jpg" or $file['content_type'] == "image/jpeg") {
            $image = imagecreatefromjpeg(substr($file['path'], 6, strlen($file['path'])));
        } elseif ($file['content_type'] == "image/png") {
            $image = imagecreatefrompng(substr($file['path'], 6, strlen($file['path'])));
        }
        $size = array("x" => imagesx($image), "y" => imagesy($image));
        return $this->view('index', compact('file', 'size'));
    }

    public function crop($postedFile)
    {
        $file = $this->getPicture($postedFile);
        $image = null;
        if ($file['content_type'] == "image/jpg" or $file['content_type'] == "image/jpeg") {
            $image = imagecreatefromjpeg(substr($file['path'], 6, strlen($file['path'])));
        } elseif ($file['content_type'] == "image/png") {
            $image = imagecreatefrompng(substr($file['path'], 6, strlen($file['path'])));
        }
        $size = min(imagesx($image), imagesy($image));
        $image2 = imagecrop($image, ['x' => 110, 'y' => 110, 'width' => $_POST['width'], 'height' => $_POST['height']]);
        if ($image2 !== FALSE and $file['content_type'] == "image/png")
            imagepng($image2, '1' . $file['name']);
        elseif ($image2 !== FALSE and $file['content_type'] == "image/jpg" or $file['content_type'] == "image/jpeg")
            imagejpeg($image2, 1. . $file['name']);
        else
            $this->redirectBack();

        header("Content-Type: application/octet-stream");
        header('Content-Disposition: attachment; filename="' . $file['path'] . '"');
        readfile($image);

        $this->redirect('home/message');
//        $this->redirectBack();
    }

//    public function crop($postedFile)
//    {
//        $file = $this->getPicture($postedFile);
//        $im = imagecreatefrompng(substr($file['path'], 6, strlen($file['path'])));
//        if (mime_content_type($file['name']) == "application/png") {
//            $size = min(imagesx($im), imagesy($im));
//            $im2 = imagecrop($im, ['x' => 110, 'y' => 110, 'width' => $_POST['width'], 'height' => $_POST['height']]);
////        $im2 = imagecrop($im, ['x' => 110, 'y' => 110, 'width' => $size, 'height' => $size]);
//            if ($im2 !== FALSE) {
//                imagepng($im2, '1' . $file['name']);
//                imagedestroy($im2);
//            }
//            header("Content-Type: application/octet-stream");
//            header('Content-Disposition: attachment; filename="' . $file['path'] . '"');
//            readfile($im);
//            imagedestroy($im);
//        }
//
//        $this->redirect('home/message');
////        $this->redirectBack();
//    }

    public function message()
    {
        return $this->view('message');
    }

    public function home()
    {
        $fileModel = new FileModel();
        $files = $fileModel->findAll($_SESSION['userId']);
        $user = new user();
        $volume = $user->volume($_SESSION['userId']);

//        if ($files != null) {
//            $jsonResponse = json_encode($files);
//            $response['status_code_header'] = 'HTTP/1.1 200 OK';
//            $response['body'] = json_encode($files);
//            http_response_code(200);
//        } else {
//            http_response_code(404);
//            $jsonResponse = json_encode(array('message' => 'No File Is Found!'));
//        }
//        echo $jsonResponse;

        return $this->view('home', compact('files', 'volume'));
    }

    public function edit($fileId)
    {
        $fileModel = new FileModel();
        $fileModel->edit($fileId[2], $_POST['text']);
        $response = array("message" => "Record edited successfully!");
        echo $response;
        $this->redirectBack();

    }

    public function search($file)
    {
        $db = new FileModel();
        $files = $db->search($_POST['text'], $_SESSION['userId']);
        $user = new user();
        $volume = $user->volume($_SESSION['userId']);

//        var_dump($result);
        return $this->view("home", compact('files', 'volume'));
    }

    public function viewFile($fileId)
    {
        $fileModel = new FileModel();
        $file = $fileModel->findOne($fileId[2], $_SESSION['userId']);

        $path = realpath(dirname(__FILE__) . "/../../" . $file['path']);
        $filename = basename($path);
        $fileType = mime_content_type($path);

        $size = filesize($path);
        header('Content-Length: ' . $size);
        if ($fileType == 'application/pdf') {
            header("Content-type: application/pdf");
            readfile($path);
        } else if ($fileType == 'image/png') {
            header("Content-type: image/png");
            $im = imagecreatefrompng($path);
            imagepng($im);
            imagedestroy($im);
        } else if ($fileType == 'image/jpeg') {
            header('Content-Type: image/jpeg');
            $im = imagecreatefromjpeg($path);
            imagejpeg($im, NULL, 100);
            imagedestroy($im);
        } else {
            header("Content-Type: application/octet-stream");
            $fileRead = @fopen($path, "rb");
            while (!feof($fileRead)) {
                if ($size < 1024 * 16)
                    print @fread($fileRead, $size);
                else
                    print @fread($fileRead, 1024 * 16);
                ob_flush();
                flush();
            }
        }


//        header("Content-Type: application/octet-stream");
//        header('Cache-Control: public, must-revalidate, max-age=0');
//        header('Pragma: no-cache');
//        header('Accept-Ranges: bytes');
//        header('Content-Length:' . (($end - $begin) + 1));
//        if (isset($_SERVER['HTTP_RANGE'])) {
//
//            header("Content-Range: bytes $begin-$end/$size");
//        }
//        header("Content-Disposition: inline; filename=$filename");
//        header("Content-Transfer-Encoding: binary");
//        header("Last-Modified: $time");
//
//        $cur = $begin;
//        fseek($fm, $begin, 0);
//
//        while (!feof($fm) && $cur <= $end && (connection_status() == 0)) {
//            print fread($fm, min(1024 * 16, ($end - $cur) + 1));
//            $cur += 1024 * 16;
//        }
//        $this->redirectBack();
    }

    public function viewFile1($fileId)
    {
        $fileModel = new FileModel();
        $file = $fileModel->findOne($fileId[2], $_SESSION['userId']);

        $path = realpath(dirname(__FILE__) . "/../../" . $file['path']);
        $filename = basename($path);
        $fileSize = filesize($path);
//        header('Content-Description: File Transfer');
//        header('Content-Type: application/octet-stream');
////        header('Content-Disposition: attachment; filename="' . basename($path) . '"');
//        header('Expires: 0');
//        header('Cache-Control: must-revalidate');
//        header('Pragma: public');
//        header('Content-Length: ' . $fileSize);


        $fileRead = @fopen($path, "rb");
        $content = @fread($fileRead, 10);
        $myfile = fopen($filename, "w");

        fwrite($myfile, "test");
        fclose($myfile);
        ob_flush();
        flush(); // Flush system output buffer

//        $this->redirectBack();
    }
}