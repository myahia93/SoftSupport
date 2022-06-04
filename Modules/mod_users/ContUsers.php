<?php
if (!defined('CONST_INCLUDE'))
    die('Acces denied !');
?>
<?php

include_once "ViewUsers.php";
include_once "ModelUsers.php";

class ContUsers
{
    private $viewUsers;
    private $modelUsers;

    public function __construct()
    {
        $this->viewUsers = new ViewUsers();
        $this->modelUsers = new ModelUsers();
    }

    public function listUsers()
    {
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {
            $tab = $this->modelUsers->modelGetUsers($_SESSION['id_user']);
            $this->viewUsers->viewUsersPage($tab);
        } else {
            $this->viewUsers->viewAlertWarning("Access denied : You must be logged in as an administrator to view this page.");
        }
    }

    public function formCreateUsers()
    {
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {
            $this->viewUsers->viewFormUserCreation();
        } else {
            $this->viewUsers->viewAlertWarning("Access denied : You must be logged in as an administrator to view this page.");
        }
    }

    public function createUsers()
    {
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {
            if (isset($_POST['first_name'])) {
                if ($_POST['password'] == $_POST['password_confirmed']) {
                    $array = array();
                    $array['username'] = strtolower($_POST['username']);

                    //Check if user already exist
                    $exist = $this->modelUsers->modelUserExist($array);
                    if (!empty($exist)) {
                        $this->viewUsers->viewAlertWarning("The user " . $array['username'] . " already exists");
                    } else {

                        $array['first_name'] = $_POST['first_name'];
                        $array['last_name'] = strtoupper($_POST['last_name']);
                        $array['mail'] = $_POST['mail'];
                        $array['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                        $array['type'] = $_POST['type'];
                        switch ($array['type']) {
                            case '1':
                                $array['isAdmin'] = 0;
                                $array['isDev'] = 1;
                                $array['isReporter'] = 0;
                                break;
                            case '2':
                                $array['isAdmin'] = 0;
                                $array['isDev'] = 0;
                                $array['isReporter'] = 1;
                                break;
                            case '3':
                                $array['isAdmin'] = 1;
                                $array['isDev'] = 0;
                                $array['isReporter'] = 0;
                                break;
                        }

                        //User creation
                        $this->modelUsers->modelCreateUser($array);
                        $this->viewUsers->viewAlertSuccess("The user " . $array['username'] . " has been created");
                    }
                    $this->listUsers();
                } else {
                    $this->viewUsers->viewAlertWarning("Passwords don't match");
                    $this->formCreateUsers();
                }
            }
        } else {
            $this->viewUsers->viewAlertWarning("Access denied : You must be logged in as an administrator to view this page.");
        }
    }

    public function formEditUsers()
    {
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {
            $id_user = isset($_POST['id_user']) ? $_POST['id_user'] : null;
            $tab = $this->modelUsers->modelGetUserInformation($id_user);
            $this->viewUsers->viewFormUserEditor($tab);
        } else {
            $this->viewUsers->viewAlertWarning("Access denied : You must be logged in as an administrator to view this page.");
        }
    }

    public function formUpdateUser()
    {
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {
            if (isset($_POST['first_name'])) {
                $array = array();
                $array['username'] = $_POST['username'];
                $array['id_user'] = $_POST['id_user'];
                $array['first_name'] = $_POST['first_name'];
                $array['last_name'] = strtoupper($_POST['last_name']);
                $array['mail'] = $_POST['mail'];
                $array['type'] = $_POST['type'];
                switch ($array['type']) {
                    case '1':
                        $array['isAdmin'] = 0;
                        $array['isDev'] = 1;
                        $array['isReporter'] = 0;
                        break;
                    case '2':
                        $array['isAdmin'] = 0;
                        $array['isDev'] = 0;
                        $array['isReporter'] = 1;
                        break;
                    case '3':
                        $array['isAdmin'] = 1;
                        $array['isDev'] = 0;
                        $array['isReporter'] = 0;
                        break;
                }

                //User update
                $this->modelUsers->modelUpdateUser($array);
                $this->viewUsers->viewAlertSuccess("The user " . $array['username'] . " has been updated");
                $this->listUsers();
            }
        } else {
            $this->viewUsers->viewAlertWarning("Access denied : You must be logged in as an administrator to view this page.");
        }
    }

    public function deleteUser()
    {
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {
            $id_user = isset($_GET['id']) ? $_GET['id'] : null;
            $this->modelUsers->modelDeleteUser($id_user);

            $this->viewUsers->viewAlertSuccess("The user #00" . $id_user . " has been deleted");
            $this->listUsers();
        } else {
            $this->viewUsers->viewAlertWarning("Access denied : You must be logged in as an administrator to view this page.");
        }
    }
}
