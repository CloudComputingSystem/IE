<?php


namespace application\model;

//header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Methods: POST");
//header("Access-Control-Max-Age: 3600");
//header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


class FileModel extends Model
{
    public function findAll($userId)
    {
        $query = "SELECT * FROM `files` WHERE `user_id` = ? ; ";
        $result = $this->query($query, [$userId])->fetchAll();
        $this->closeConnection();
        return $result;
    }

    public function findOne($id, $userId)
    {
        $db = new Model();
        $file = $db->select("SELECT * FROM `files` WHERE `file_id`=? and user_id = ?  ;", [$id, $userId])->fetchAll();
        return $file[0];
    }

    public function search($name, $userId)
    {
        $db = new Model();
        $file = $db->select("SELECT * FROM `files` WHERE `name`=? and user_id = ?  ;", [$name, $userId])->fetchAll();
        return $file;
    }

    public function uploadFile($file)
    {
        $db = new Model();
        $db->insert('files', ['name', 'content_length', 'content_type', 'path', 'user_id'], [trim($file['name']), $file['contentLength'] / 1024, $file['contentType'], $file['path'], $file['userID']]);
        return true;
    }

    public function delete($tableName, $id)
    {
        echo "yesss";
        $db = new Model();
        $result = $db->delete('files', $id);
        var_dump($result);
        return $result;
    }

    public function edit($id, $name)
    {
        $db = new Model();
        $result = $db->update('files', $id, ['name'], [$name]);
        return $result;
    }
}