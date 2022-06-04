<?php
if (!defined('CONST_INCLUDE'))
    die('Acces denied !');
?>
<?php

include_once "conf_database/authDatabase.php";

class ModelConnection extends authDatabse
{
    public function modelGetPassword($username)
    {
        try {
            $req = self::$db->prepare("SELECT password FROM user WHERE username = ?");
            $req->execute([$username]);
            $result = $req->fetch();
            return $result;
        } catch (PDOException $e) {
        }
    }

    public function modelUserExist($username, $password)
    {
        try {
            $req = self::$db->prepare("SELECT id_user, username, first_name, last_name, mail, isAdmin, isDev, isReporter FROM user WHERE username = ? AND password = ?;");
            $req->execute([$username, $password]);
            $result = $req->fetchAll();
            return $result;
        } catch (PDOException $e) {
        }
    }
}
