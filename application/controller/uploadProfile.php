<?php


namespace application\controller;
//session_start();
require_once 'application/model/Model.php';
require_once 'application/model/FileModel.php';

use application\model\Model;
use application\model\FileModel;

class uploadProfile extends Controller
{
    public function file()
    {
        return $this->view('resize');
    }

    public function upload()
    {
        if (isset($_POST['image'])) {
            $data = $_POST['image'];
            $image_array_1 = explode(";", $data);
            $image_array_2 = explode(",", $image_array_1[1]);
            $data = base64_decode($image_array_2[1]);
            $image_name = 'public\userProfile\\' . $_SESSION['userName'] . '.png';
            file_put_contents($image_name, $data);
            $this->redirect('home/home');
        }
    }
}