<?php
if (!defined('CONST_INCLUDE'))
    die('Acces denied !');
?>
<?php

//This class allows to connect to the database

class authDatabse
{
    protected static $db;

    public static function connectionDB()
    {
        $file = fopen('C:\Cred_SoftSupport\database_cred.txt', 'rb');
        $userContent = trim(fgets($file));
        $passwordContent = fgets($file);
        $dns = "mysql:host=localhost; dbname=softsupport_database";
        $user = $userContent;
        $password = $passwordContent;
        try {
            self::$db = new PDO($dns, $user, $password);
        } catch (PDOException $e) {
            echo "Not connected to web server";
        }
    }
}

?>
<?php
authDatabse::connectionDB();
?>