<?php


namespace application\controller;

require_once 'application/model/Model.php';
require_once 'application/model/FileModel.php';
//session_start();

use application\model\Model;
use application\model\FileModel;

class download extends Controller
{
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

    public function file($id)
    {
        $fileModel = new FileModel();
        $file = $fileModel->findOne($id[2], $_SESSION['userId']);

        $path = realpath(dirname(__FILE__) . "/../../" . $file['path']);
        $fileSize = filesize($path);

        if (file_exists($path)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($path) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
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
                flush();
            }
            die();
        } else {
            http_response_code(404);
            die();
        }
    }

}