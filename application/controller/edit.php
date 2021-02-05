<?php

namespace application\controller;

require_once 'application/model/Model.php';
require_once 'application/model/FileModel.php';

use application\model\Model;
use application\model\FileModel;

include('home.php');

class edit extends Controller
{
    public function file($fileId)
    {
        $id = $fileId[2];
        return $this->view('edit', compact('id'));
    }
//    public  function editFile(){
//        $tmp = explode('/', strtolower($_SERVER['REQUEST_URI']));
//        $id = $tmp[sizeof($tmp) - 1];
//        $fileModel = new FileModel();
//        $fileModel->edit($id, $_POST['text']);
//        $file = $fileModel->findOne($id, $_SESSION['userId']);
//        $path = $file['path'];
//        var_dump($path);
//        str_replace(BASE_DIR, '', $tmp[0]);
//        $exp = explode('\\', $path);
//        $exp[2] = $_POST['text'];
//        $newPath = join("\\", $exp);
//        $response = json_encode(array("message" => "Record edited successfully!", 'file' => $file));
////        var_dump($response);
//
//        $home = new home();
//        $home->home();
//    }

    public function editFile()
    {
        $tmp = explode('/', strtolower($_SERVER['REQUEST_URI']));
        $id = $tmp[sizeof($tmp) - 1];
        $fileModel = new FileModel();
        $file = $fileModel->findOne($id, $_SESSION['userId']);
        $path = $file['path'];
        $fileName = basename($path);
        $ext = explode('.', $fileName);
        $ext = '.' . $ext[sizeof($ext) - 1];
        $exp = explode('\\', $path);
        $exp[2] = $_POST['text'] . $ext;
        $newPath = join("\\", $exp);

        $fileModel->edit($id, basename($newPath), $newPath);

        if (file_exists($path)) {
            rename($path, $newPath);
        }
        $response = json_encode(array("message" => "Record edited successfully!", 'file' => $file));
//        echo ($response);

//        $home = new home();
//        $home->home();
    }
}