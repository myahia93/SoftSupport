<?php
if (!defined('CONST_INCLUDE'))
    die('Acces denied !');
?>
<?php

include_once "ContUsers.php";

class ModUsers
{
    private $contUsers;

    public function __construct()
    {
        $this->contUsers = new ContUsers();
        if (isset($_GET['action'])) {
            $action = htmlspecialchars($_GET['action']);
        } else {
            $action = "list_users";
        }

        $this->setAction($action);
    }

    public function setAction($action)
    {
        switch ($action) {
            case "list_users":
                $this->contUsers->listUsers();
                break;
            case "form_create_user":
                $this->contUsers->formCreateUsers();
                break;
            case "create_user":
                $this->contUsers->createUsers();
                break;
            case "form_edit_user":
                $this->contUsers->formEditUsers();
                break;
            case "edit_user":
                $this->contUsers->formUpdateUser();
                break;
            case "delete_user":
                $this->contUsers->deleteUser();
                break;
        }
    }
}
