<?php
// $dns = "mysql:host=localhost; dbname=softsupport_database";
// $user = "admin_db";
// $password = "VxcQS6ZTGJRYqab1";
// try {
//     $db = new PDO($dns, $user, $password);
//     echo "co\n";
// } catch (PDOException $e) {
//     echo "Not connected to web server";
// }

// Admin creation
$username = "root";
$name1 = "Admin";
$name2 = "SoftSupport";
$mail = "admin.softsupport01@gmail.com";
$passwd = password_hash("root", PASSWORD_DEFAULT);

try {
    $req = $db->prepare("INSERT INTO user (username,first_name,last_name,mail,password,isAdmin,isDev,isReporter) VALUES (?,?,?,?,?,?,?,?);");
    $req->execute([$username, $name1, $name2, $mail, $passwd, 1, 0, 0]);
    echo "exec";
} catch (PDOException $e) {
    echo "no exec";
}
