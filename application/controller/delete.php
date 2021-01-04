<?php


namespace application\controller;
session_start();
require_once 'application/model/Model.php';
require_once 'application/model/FileModel.php';

use application\model\Model;
use application\model\FileModel;

class delete extends Controller
{
    public function file($id)
    {
        $fileModel = new FileModel();
        $result = $fileModel->delete('files', $id[2]);
        $response = array("id" => $result['file_id'], "message" => "Record deleted successfully!");
        echo $response;
        $this->redirectBack();
    }
}