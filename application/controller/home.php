<?php


namespace application\controller;

//session_start();
require_once 'application/model/Model.php';
require_once 'application/model/FileModel.php';

use application\model\Model;
use application\model\FileModel;

//include('download.php');
include('user.php');

class home extends Controller
{
    private $dbPath;

    public function getPicture($file)
    {
        $fileModel = new FileModel();
        $file = $fileModel->findOne($file[2], $_SESSION['userId']);

        $path = str_replace("\\", "/", $file['path']);
        $file['dbPath'] = $path;
        $path = "../../" . $path;
        $file['path'] = $path;
        return $file;
    }

    // resize picture
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
        return $this->view('resize', compact('file', 'size'));
    }

    // get path of picture
//    public function getPicture($file)
//    {
//        $fileModel = new FileModel();
//        $file = $fileModel->findOne($file[2], $_SESSION['userId']);
//        $dbPath = $file['path'];
//        $path = str_replace("\\", "/", $file['path']);
//        $path = "../../" . $path;
//        $file['path'] = $path;
//        $file['dbPath'] = $dbPath;
//
//
//        $image = null;
//        if ($file['content_type'] == "image/jpg" or $file['content_type'] == "image/jpeg") {
//            $image = imagecreatefromjpeg(substr($file['path'], 6, strlen($file['path'])));
//        } elseif ($file['content_type'] == "image/png") {
//            $image = imagecreatefrompng(substr($file['path'], 6, strlen($file['path'])));
//        }
//        $size = array("x" => imagesx($image), "y" => imagesy($image));
//        $this->view('resize', compact('file', 'size'));
//        var_dump($file);
//        return $image;
////        $path = realpath(dirname(__FILE__) . "/../../" . $file['dbPath']);
////        var_dump($file['dbPath']);
////        $fileSize = filesize($file['dbPath']);
////        return $file;
//    }
//
//    // resize picture
//    public function resize($file)
//    {
//        $file = $this->getPicture($file);
//        var_dump($file);
//
////        $image = null;
////        if ($file['content_type'] == "image/jpg" or $file['content_type'] == "image/jpeg") {
////            $image = imagecreatefromjpeg(substr($file['path'], 6, strlen($file['path'])));
////        } elseif ($file['content_type'] == "image/png") {
////            $image = imagecreatefrompng(substr($file['path'], 6, strlen($file['path'])));
////        }
////        $size = array("x" => imagesx($image), "y" => imagesy($image));
////        $this->view('resize', compact('file', 'size'));
//
////        $path = realpath(dirname(__FILE__) . "/../../" . $file['dbPath']);
////        var_dump($file['dbPath']);
////        $fileSize = filesize($file['dbPath']);
////        if (file_exists($file['dbPath'])) {
////            var_dump("yesss");
////            header('Content-Description: File Transfer');
////            header('Content-Type: application/octet-stream');
////            header('Content-Disposition: attachment; filename="'  . 'x.png"');
////            header('Expires: 0');
////            header('Cache-Control: must-revalidate');
////            header('Pragma: public');
//////            header('Content-Length: ' . $fileSize);
////            readfile($file);
////            exit;
////        }
////        return $this->view('resize', compact('file', 'size'));
//    }

    // crop profile of user
    public function crop($postedFile)
    {
        $file = $this->getPicture($postedFile);
//        var_dump($file);
        $image = null;
        if ($file['content_type'] == "image/jpg" or $file['content_type'] == "image/jpeg") {
            $image = imagecreatefromjpeg(substr($file['path'], 6, strlen($file['path'])));
        } elseif ($file['content_type'] == "image/png") {
            $image = imagecreatefrompng(substr($file['path'], 6, strlen($file['path'])));
        }
        $size = min(imagesx($image), imagesy($image));
        $image2 = imagecrop($image, ['x' => 110, 'y' => 110, 'width' => $_POST['width'], 'height' => $_POST['height']]);
        if ($image2 !== FALSE and $file['content_type'] == "image/png")
            imagepng($image2, 'resource/resize/' . $file['name']);
        elseif ($image2 !== FALSE and $file['content_type'] == "image/jpg" or $file['content_type'] == "image/jpeg")
            imagejpeg($image2, 'resource/resize/' . $file['name']);
        else
            $this->redirectBack();

//        $x = explode('/', $file['path']);
        $name = basename($file['path']);
        var_dump("--" . $name);

//        $path = "resource/resize/" . $name;
        $path = realpath(dirname(__FILE__) . "/../../resource/resize/" . $name);
        var_dump("db=" . $path);

        if (file_exists($path)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $name . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($path));
            readfile($path);
            exit;
        }
    }

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
        $arr = json_encode(array('message' => 'files return successfully.', 'files' => $files, 'volume' => $volume));
//        echo $arr;
        return $this->view('home', compact('files', 'volume'));
    }

    public function search($file)
    {
        $db = new FileModel();
        $files = $db->search($_POST['text'], $_SESSION['userId']);
        $user = new user();
        $volume = $user->volume($_SESSION['userId']);
        $arr = array('message' => 'success', 'files' => $files);
//        var_dump(json_encode($arr));

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
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . $size);
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
    }
}