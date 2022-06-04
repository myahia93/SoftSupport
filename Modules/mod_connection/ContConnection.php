<?php
if (!defined('CONST_INCLUDE'))
    die('Acces denied !');
?>
<?php

include_once "ViewConnection.php";
include_once "ModelConnection.php";

class ContConnection
{
    private $viewConnection;
    private $modelConnection;

    public function __construct()
    {
        $this->viewConnection = new ViewConnection();
        $this->modelConnection = new ModelConnection();
    }

    public function loginPage()
    {
        $this->viewConnection->viewLoginPage();
    }

    //Verify the user and password, log in and redirect to home page
    public function login()
    {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $hash = $this->modelConnection->modelGetPassword($username);
            if (!empty($hash)) {
                $isTrue = password_verify($password, $hash[0]);
                if ($isTrue) {
                    $tab = $this->modelConnection->modelUserExist($username, $hash[0]);

                    //Session creation
                    $_SESSION['username'] = $username;
                    $_SESSION['id_user'] = $tab[0]['id_user'];
                    $_SESSION['first_name'] = $tab[0]['first_name'];
                    $_SESSION['last_name'] = $tab[0]['last_name'];
                    $_SESSION['mail'] = $tab[0]['mail'];
                    $_SESSION['isAdmin'] = $tab[0]['isAdmin'];
                    $_SESSION['isDev'] = $tab[0]['isDev'];
                    $_SESSION['isReporter'] = $tab[0]['isReporter'];

                    // code to show array in details :
                    // print("<pre>" . print_r($_SESSION, true) . "</pre>");
                    header("Location: index.php?module=home");
                } else {
                    $msg = "You have entered an invalid password";
                    $this->viewConnection->viewAlertWarning($msg);
                    $this->viewConnection->viewLoginPage();
                }
            } else {
                $msg = "You have entered an invalid username";
                $this->viewConnection->viewAlertWarning($msg);
                $this->viewConnection->viewLoginPage();
            }
        }
    }

    public function logout()
    {
        $_SESSION = array();
        session_destroy();
        header("Location: index.php?module=home");
    }
}
