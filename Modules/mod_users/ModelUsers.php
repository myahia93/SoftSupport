<?php
if (!defined('CONST_INCLUDE'))
    die('Acces denied !');
?>
<?php

include_once "conf_database/authDatabase.php";

class ModelUsers extends authDatabse
{

    public function modelCreateUser($array)
    {
        try {
            $req = self::$db->prepare("INSERT INTO user (username,first_name,last_name,mail,password,isAdmin,isDev,isReporter) VALUES (?,?,?,?,?,?,?,?);");
            $req->execute([$array['username'], $array['first_name'], $array['last_name'], $array['mail'], $array['password'], $array['isAdmin'], $array['isDev'], $array['isReporter']]);
        } catch (PDOException $e) {
        }
    }

    public function modelUserExist($array)
    {
        try {
            $req = self::$db->prepare("SELECT username FROM user where username = ? ;");
            $req->execute([$array['username']]);
            $result = $req->fetch();
            return $result;
        } catch (PDOException $e) {
        }
    }

    public function modelGetUsers($id)
    {
        try {
            $req = self::$db->prepare("SELECT id_user,username,first_name,last_name,mail,isAdmin,isDev,isReporter FROM user WHERE id_user != ? ORDER BY id_user ASC");
            $req->execute([$id]);
            $result = $req->fetchAll();
            return $result;
        } catch (PDOException $e) {
        }
    }

    public function modelGetUserInformation($id_user)
    {
        try {
            $req = self::$db->prepare("SELECT id_user,username,first_name,last_name,mail,isAdmin,isDev,isReporter FROM user WHERE id_user = ?");
            $req->execute([$id_user]);
            $result = $req->fetch();
            return $result;
        } catch (PDOException $e) {
        }
    }

    public function modelUpdateUser($array)
    {
        try {
            $req = self::$db->prepare("UPDATE user SET first_name = ?, last_name = ?, mail = ?, isAdmin = ?, isDev = ?, isReporter = ? WHERE id_user = ?");
            $req->execute([$array['first_name'], $array['last_name'], $array['mail'], $array['isAdmin'], $array['isDev'], $array['isReporter'], $array['id_user']]);
        } catch (PDOException $e) {
        }
    }

    public function modelDeleteUser($id_user)
    {
        try {
            $req = self::$db->prepare("DELETE FROM user WHERE id_user = ?");
            $req->execute([$id_user]);
        } catch (PDOException $e) {
        }
    }
}
