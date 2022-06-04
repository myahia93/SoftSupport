<?php
if (!defined('CONST_INCLUDE'))
    die('Acces denied !');
?>
<?php

include_once "ContCustomers.php";

class ModCustomers
{
    private $contCustomers;

    public function __construct()
    {
        $this->contCustomers = new ContCustomers();
        if (isset($_GET['action'])) {
            $action = htmlspecialchars($_GET['action']);
        } else {
            $action = "list_customers";
        }

        $this->setAction($action);
    }

    public function setAction($action)
    {
        switch ($action) {
            case "list_customers":
                $this->contCustomers->listCustomers();
                break;
            case "form_create_customer":
                $this->contCustomers->formCreateCustomers();
                break;
            case "create_customer":
                $this->contCustomers->createCustomers();
                break;
            case "form_edit_customer":
                $this->contCustomers->formEditCustomers();
                break;
            case "edit_customer":
                $this->contCustomers->updateCustomers();
                break;
            case "delete_customer":
                $this->contCustomers->deleteCustomer();
                break;
        }
    }
}
