<?php
if (!defined('CONST_INCLUDE'))
    die('Acces denied !');
?>
<?php

include_once "ContConnection.php";

class ModConnection
{
    private $contConnection;

    public function __construct()
    {
        $this->contConnection = new ContConnection();
        if (isset($_GET['action'])) {
            $action = htmlspecialchars($_GET['action']);
        } else {
            $action = "form_login";
        }

        $this->setAction($action);
    }

    public function setAction($action)
    {
        switch ($action) {
            case "form_login":
                $this->contConnection->loginPage();
                break;
            case "login":
                $this->contConnection->login();
                break;
            case "logout":
                $this->contConnection->logout();
                break;
        }
    }
}
