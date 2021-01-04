<?php


namespace application\controller;
session_start();
require_once 'application/model/Model.php';
require_once 'application/model/FileModel.php';

use application\model\Model;
use application\model\FileModel;

class upload extends Controller
{
    public function uploadFile()
    {
        $count = count($_FILES['file']['name']);
        $fileModel = new FileModel();
        for ($i = 0; $i < $count; $i++) {
            echo "waiting!";
            $file_name = $_FILES['file']['name'][$i];
            $file_tmp = $_FILES['file']['tmp_name'][$i];
            $file_size = $_FILES['file']['size'][$i];
            $file_error = $_FILES['file']['error'][$i];
            $file_type = $_FILES['file']['type'][$i];
            $file_ext = explode('.', $file_name);
            $file_act_ext = strtolower(end($file_ext));
            $allowed = ['jpg', 'png', 'jpeg', 'gif', 'txt', 'pdf', 'docx', 'mp4', 'json', 'xml', 'html', 'pptx', 'zip', 'rar'];
            $path = 'resource\\' . $_SESSION['userName'] . '_dir';

            if (!in_array($file_act_ext, $allowed))
                return 'Only .jpg Files Are Allowed!';

            if ($file_error != 0)
                return 'Image Size Should Be Be Than 2mb.';

            if ($file_size > 900000000)
                return 'Image Size Should Be Be Than 2mb.';

            $file_des = $path . "\\" . $file_name;

            $move = move_uploaded_file($file_tmp, $file_des);

            if (!$move) {
                return "Sorry Failed To Upload Image!";
            }
            $file = array("name" => $file_name, "contentLength" => $file_size, "contentType" => $file_type, "path" => $file_des, "userID" => $_SESSION['userId']);
            $fileModel->uploadFile($file);
        }
        echo "successfully uploaded!";
        $this->redirect('home/home');
    }

}