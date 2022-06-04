<?php
if (!defined('CONST_INCLUDE'))
    die('Acces denied !');
?>
<?php

include_once "ContTickets.php";

class ModTickets
{
    private $contTickets;

    public function __construct()
    {
        $this->contTickets = new ContTickets();
        if (isset($_GET['action'])) {
            $action = htmlspecialchars($_GET['action']);
        } else {
            $action = "list_tickets";
        }

        $this->setAction($action);
    }

    public function setAction($action)
    {
        switch ($action) {
            case "list_tickets":
                $this->contTickets->listTickets();
                break;
            case "form_create_ticket":
                $this->contTickets->formCreateTicket();
                break;
            case "create_ticket":
                $this->contTickets->createTicket();
                break;
            case "assign_ticket":
                $this->contTickets->assignTicket();
                break;
            case "form_update_ticket":
                $this->contTickets->formUpdateTicket();
                break;
            case "update_ticket":
                $this->contTickets->updateTicket();
                break;
            case "delete_ticket":
                $this->contTickets->deleteTicket();
                break;
        }
    }
}
