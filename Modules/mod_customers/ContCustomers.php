<?php
if (!defined('CONST_INCLUDE'))
    die('Acces denied !');
?>
<?php

include_once "ViewCustomers.php";
include_once "ModelCustomers.php";

class ContCustomers
{
    private $viewCustomers;
    private $modelCustomers;

    public function __construct()
    {
        $this->viewCustomers = new ViewCustomers();
        $this->modelCustomers = new ModelCustomers();
    }

    public function listCustomers()
    {
        if (isset($_SESSION['id_user'])) {
            $tab = $this->modelCustomers->modelListCustomer();
            for ($i = 0; $i < count($tab); $i++) {
                $tab[$i]['projects'] = $this->modelCustomers->modelCountNumberOfProject($tab[$i]['id_customer'])['COUNT(*)'];
            }
            $this->viewCustomers->viewCustomersPage($tab);
        } else {
            $this->viewCustomers->viewAlertWarning("Access denied : You must be logged in to view this page.");
        }
    }

    public function formCreateCustomers()
    {
        if (isset($_SESSION['isDev']) && ($_SESSION['isDev'] == 1 || $_SESSION['isAdmin'] == 1)) {
            $this->viewCustomers->viewFormCustomerCreation();
        } else {
            $this->viewCustomers->viewAlertWarning("Access denied : You must be logged in as an administrator or a developer to view this page.");
        }
    }

    public function createCustomers()
    {
        if (isset($_SESSION['isDev']) && ($_SESSION['isDev'] == 1 || $_SESSION['isAdmin'] == 1)) {
            if (isset($_POST['name_customer'])) {
                $array = array();
                $array['name_customer'] = $_POST['name_customer'];
                $array['city'] = $_POST['city'];

                //Check if the customer already exist
                $exist = $this->modelCustomers->modelCustomerExist($array);
                if (!empty($exist)) {
                    $this->viewCustomers->viewAlertWarning("The customer " . $array['name_customer'] . " already exists");
                } else {
                    $this->modelCustomers->modelAddCustomer($array);
                    $this->viewCustomers->viewAlertSuccess("The company " . $array['name_customer'] . " has been added to the customers");
                }
                $this->listCustomers();
            }
        } else {
            $this->viewCustomers->viewAlertWarning("Access denied : You must be logged in as an administrator or a developer to view this page.");
        }
    }

    public function formEditCustomers()
    {
        if (isset($_SESSION['isDev']) && ($_SESSION['isDev'] == 1 || $_SESSION['isAdmin'] == 1)) {
            $id_customer = isset($_POST['id_customer']) ? $_POST['id_customer'] : null;
            $tab = $this->modelCustomers->modelGetCustomerInformation($id_customer);
            $this->viewCustomers->viewFormEditCustomer($tab);
        } else {
            $this->viewCustomers->viewAlertWarning("Access denied : You must be logged in as an administrator or a developer to view this page.");
        }
    }

    public function updateCustomers()
    {
        if (isset($_SESSION['isDev']) && ($_SESSION['isDev'] == 1 || $_SESSION['isAdmin'] == 1)) {
            if (isset($_POST['name_customer'])) {
                $array = array();
                $array['name_customer'] = $_POST['name_customer'];
                $array['id_customer'] = $_POST['id_customer'];
                $array['city'] = $_POST['city'];
            }

            //Customer update
            $this->modelCustomers->modelUpdateCustomer($array);
            $this->viewCustomers->viewAlertSuccess("The customer " . $array['name_customer'] . " has been updated");
            $this->listCustomers();
        } else {
            $this->viewCustomers->viewAlertWarning("Access denied : You must be logged in as an administrator or a developer to view this page.");
        }
    }

    public function deleteCustomer()
    {
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {
            $id_customer = isset($_GET['id']) ? $_GET['id'] : null;
            $this->modelCustomers->modelDeleteCustomer($id_customer);

            $this->viewCustomers->viewAlertSuccess("The customer #00" . $id_customer . " has been deleted");
            $this->listCustomers();
        } else {
            $this->viewCustomers->viewAlertWarning("Access denied : You must be logged in as an administrator to view this page.");
        }
    }
}
