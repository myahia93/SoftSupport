<?php
if (!defined('CONST_INCLUDE'))
    die('Acces denied !');
?>
<?php

include_once "ViewTickets.php";
include_once "ModelTickets.php";

class ContTickets
{
    private $viewTickets;
    private $modelTickets;

    public function __construct()
    {
        $this->viewTickets = new ViewTickets();
        $this->modelTickets = new ModelTickets();
    }

    public function listTickets()
    {
        if (isset($_SESSION['id_user'])) {
            $tab = array();

            if ($_SESSION['isReporter'] == 1) {
                $tab['my_tickets'] = $this->modelTickets->modelGetTicketsByReporter($_SESSION['id_user']);
                for ($i = 0; $i < count($tab['my_tickets']); $i++) {
                    $tab['my_tickets'][$i]['name_project'] = $this->modelTickets->modelGetProjectByID($tab['my_tickets'][$i]['id_project'])['name_project'];
                    $tab['my_tickets'][$i]['name_reporter'] = $_SESSION['first_name'] . " " . strtoupper($_SESSION['last_name']);
                    if (empty($tab['my_tickets'][$i]['id_dev'])) {
                        $tab['my_tickets'][$i]['name_dev'] = "Unassigned";
                    } else {
                        $dev = $this->modelTickets->modelGetUserByID($tab['my_tickets'][$i]['id_dev']);
                        $tab['my_tickets'][$i]['name_dev'] = $dev['first_name'] . " " . strtoupper($dev['last_name']);
                    }
                }
            }
            if ($_SESSION['isDev'] == 1) {
                // Pending Ticket
                $tab['my_tickets'] = $this->modelTickets->modelGetTicketsUnassigned();
                for ($i = 0; $i < count($tab['my_tickets']); $i++) {
                    $tab['my_tickets'][$i]['name_project'] = $this->modelTickets->modelGetProjectByID($tab['my_tickets'][$i]['id_project'])['name_project'];
                    $reporter = $this->modelTickets->modelGetUserByID($tab['my_tickets'][$i]['id_reporter']);
                    $tab['my_tickets'][$i]['name_reporter'] = $reporter['first_name'] . " " . strtoupper($reporter['last_name']);
                }


                // Assigned Ticket
                $tab['assigned_tickets'] = $this->modelTickets->modelGetTicketsByDev($_SESSION['id_user']);
                for ($i = 0; $i < count($tab['assigned_tickets']); $i++) {
                    $tab['assigned_tickets'][$i]['name_project'] = $this->modelTickets->modelGetProjectByID($tab['assigned_tickets'][$i]['id_project'])['name_project'];
                    $reporter = $this->modelTickets->modelGetUserByID($tab['assigned_tickets'][$i]['id_reporter']);
                    $tab['assigned_tickets'][$i]['name_reporter'] = $reporter['first_name'] . " " . strtoupper($reporter['last_name']);
                }
            }

            // List Ticket
            $tab['all_tickets'] = $this->modelTickets->modelGetTickets();
            for ($i = 0; $i < count($tab['all_tickets']); $i++) {
                $tab['all_tickets'][$i]['name_project'] = $this->modelTickets->modelGetProjectByID($tab['all_tickets'][$i]['id_project'])['name_project'];
                $reporter = $this->modelTickets->modelGetUserByID($tab['all_tickets'][$i]['id_reporter']);
                $tab['all_tickets'][$i]['name_reporter'] = $reporter['first_name'] . " " . strtoupper($reporter['last_name']);
                if (empty($tab['all_tickets'][$i]['id_dev'])) {
                    $tab['all_tickets'][$i]['name_dev'] = "Unassigned";
                } else {
                    $dev = $this->modelTickets->modelGetUserByID($tab['all_tickets'][$i]['id_dev']);
                    $tab['all_tickets'][$i]['name_dev'] = $dev['first_name'] . " " . strtoupper($dev['last_name']);
                }
            }

            $this->viewTickets->viewTicketsPage($tab);
        } else {
            $this->viewTickets->viewAlertWarning("Access denied : You must be logged in to view this page.");
        }
    }

    public function formCreateTicket()
    {
        if (isset($_SESSION['isReporter']) && ($_SESSION['isReporter'] == 1 || $_SESSION['isAdmin'] == 1)) {
            $projects = $this->modelTickets->modelGetProjects();
            $this->viewTickets->viewAlertSuccess("The ticket #0" . $_POST['id_ticket'] . " has been created");
            $this->viewTickets->viewFormTicketCreation($projects);
        } else {
            $this->viewTickets->viewAlertWarning("Access denied : You must be logged in as a reporter to view this page.");
        }
    }

    public function createTicket()
    {
        if (isset($_SESSION['isReporter']) && ($_SESSION['isReporter'] == 1 || $_SESSION['isAdmin'] == 1)) {
            if (isset($_POST['name_ticket'])) {
                $array = array();
                $array['name_ticket'] = $_POST['name_ticket'];
                $array['incident_details'] = $_POST['incident_details'];
                $array['status'] = "Waiting for support";
                $array['creation_date'] = date('Y-m-d');
                $array['id_reporter'] = $_SESSION['id_user'];
                $array['id_project'] = $_POST['id_project'];
                $this->modelTickets->modelCreateTicket($array);
                $this->listTickets();
            }
        } else {
            $this->viewTickets->viewAlertWarning("Access denied : You must be logged in as a reporter to view this page.");
        }
    }

    public function assignTicket()
    {
        if (isset($_SESSION['isDev']) && ($_SESSION['isDev'] == 1 || $_SESSION['isAdmin'] == 1)) {
            if (isset($_POST['id_ticket'])) {
                $array = array();
                $array['id_ticket'] = $_POST['id_ticket'];
                $array['id_dev'] = $_POST['id_dev'];
                $array['status'] = "Work in progress";
                $this->modelTickets->modelAssignTicket($array);
                $this->viewTickets->viewAlertSuccess("You have been successfully assigned to ticket #0" . $_POST['id_ticket']);
                $this->listTickets();
            }
        } else {
            $this->viewTickets->viewAlertWarning("Access denied : You must be logged in as a developer to view this page.");
        }
    }

    public function formUpdateTicket()
    {
        if (isset($_SESSION['isDev']) && ($_SESSION['isDev'] == 1 || $_SESSION['isAdmin'] == 1)) {
            if (isset($_POST['id_ticket'])) {
                $tab = $this->modelTickets->modelGetTicketByID($_POST['id_ticket']);
                $this->viewTickets->viewUpdateTicketStatus($tab);
            }
        } else {
            $this->viewTickets->viewAlertWarning("Access denied : You must be logged in as a developer to view this page.");
        }
    }

    public function updateTicket()
    {
        if (isset($_SESSION['isDev']) && ($_SESSION['isDev'] == 1 || $_SESSION['isAdmin'] == 1)) {
            if (isset($_POST['id_ticket'])) {
                $array = array();
                $array['id_ticket'] = $_POST['id_ticket'];
                $array['status'] = $_POST['status'];
                $this->modelTickets->modelUpdateTicketStatus($array);
                $this->viewTickets->viewAlertSuccess("The ticket #0" . $_POST['id_ticket'] . " status has been updated");
                $this->listTickets();
            }
        } else {
            $this->viewTickets->viewAlertWarning("Access denied : You must be logged in as a developer to view this page.");
        }
    }

    public function deleteTicket()
    {
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {
            $id_ticket = isset($_GET['id']) ? $_GET['id'] : null;
            $this->modelTickets->modelDeleteTicket($id_ticket);

            $this->viewTickets->viewAlertSuccess("The ticket #0" . $id_ticket . " has been deleted");
            $this->listTickets();
        } else {
            $this->viewTickets->viewAlertWarning("Access denied : You must be logged in as an administrator to view this page.");
        }
    }
}
