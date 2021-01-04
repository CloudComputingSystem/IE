<?php


namespace application\model;
require_once 'application/model/Model.php';

use application\model\Model;

class UserModel extends Model
{
    private $userId;
    private $userName;
    private $email;
    private $password;
    private $volume;

    // select user from DB to check if user exists or not
    public function checkUserExists($field, $value)
    {
        $db = new Model();
        $result = $db->select("SELECT `id`,`user_name`,`email`,`password` FROM `users` WHERE (" . $field . " = ?); ", [$value])->fetch();
        return $result;
    }

    public function checkUser($field, $value)
    {
        $db = new Model();
        $result = $db->select("SELECT * FROM `users` WHERE (" . $field[0] . " = ? or $field[1]=? ); ", $value)->fetch();
        return $result;
    }

    // store user in DB
    public function storeUser($request)
    {
        $db = new Model();
        $db->insert('users', ['user_name', 'email', 'password'], [$_POST['username'], $_POST['email'], $_POST['password']]);
        return true;
    }

    public function getVolume($userId)
    {
        $query = "SELECT `content_length` FROM `files` WHERE user_id = ? ";
        $result = $this->query($query, array($userId))->fetchAll();
        $this->closeConnection();
        return $result;
    }

//    public function updateUser($id, $fields, $values)
//    {
//        $db = new Model();
//        $changed = $db->update('users', $id, $fields, $values);
//        if ($changed == true)
//            return true;
//        else
//            return false;
//    }
//
//    public function updateUserProfile($id, $user)
//    {
//        $db = new Model();
//        $changed = $db->update('users', $id, ['first_name', 'last_name'], [$user['first_name'], $user['last_name']]);
//        if ($changed != null)
//            return true;
//        else
//            return false;
//    }
}