<?php
if (!defined('CONST_INCLUDE'))
    die('Acces denied !');
?>
<?php

include_once "ViewUsers.php";
include_once "ModelUsers.php";
require '../SoftSupport/vendor/autoload.php';

use \Mailjet\Resources;

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
                                $typeForMail = "Developer";
                                break;
                            case '2':
                                $array['isAdmin'] = 0;
                                $array['isDev'] = 0;
                                $array['isReporter'] = 1;
                                $typeForMail = "Reporter";
                                break;
                            case '3':
                                $array['isAdmin'] = 1;
                                $array['isDev'] = 0;
                                $array['isReporter'] = 0;
                                $typeForMail = "Administrator";
                                break;
                        }

                        //User creation
                        $this->modelUsers->modelCreateUser($array);

                        //Sending mail
                        $file = fopen('C:\Cred_SoftSupport\mailjet_cred.txt', 'rb');
                        $mj = new \Mailjet\Client(trim(fgets($file)), fgets($file), true, ['version' => 'v3.1']);
                        $body = [
                            'Messages' => [
                                [
                                    'From' => [
                                        'Email' => "mohcine.yahia@efrei.net",
                                        'Name' => "SoftSupport Administrator"
                                    ],
                                    'To' => [
                                        [
                                            'Email' => $array['mail'],
                                            'Name' => $array['first_name']
                                        ]
                                    ],
                                    'Subject' => "Welcome to SoftSupport",
                                    'TextPart' => "New account created",
                                    'HTMLPart' => "<h1>Hello " . $array['first_name'] . ", Welcome to SoftSupport !!</h1><br />
                                    <h3>You have been assigned to SoftSupport as a " . $typeForMail . ".</h3><br />
                                    Username : " . $array['username'] . "<br>
                                    Password : " . $_POST['password'] . '<br />
                                    <h4><a href="http://localhost/SoftSupport">SoftSupport</a></h4>'
                                ]
                            ]
                        ];
                        $response = $mj->post(Resources::$Email, ['body' => $body]);
                        // $response->success() && var_dump($response->getData());

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
