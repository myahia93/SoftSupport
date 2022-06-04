<?php
if (!defined('CONST_INCLUDE'))
    die('Acces denied !');
?>
<?php

include_once "ViewProjects.php";
include_once "ModelProjects.php";

class ContProjects
{
    private $viewProjects;
    private $modelProjects;

    public function __construct()
    {
        $this->viewProjects = new ViewProjects();
        $this->modelProjects = new ModelProjects();
    }

    public function listProjects()
    {
        if (isset($_SESSION['id_user'])) {
            $tab = $this->modelProjects->modelListProject();
            for ($i = 0; $i < count($tab); $i++) {
                $tab[$i]['name_customer'] = $this->modelProjects->modelGetCustomerName($tab[$i]['id_customer'])['name_customer'];
            }
            $this->viewProjects->viewProjectsPage($tab);
        } else {
            $this->viewProjects->viewAlertWarning("Access denied : You must be logged in to view this page.");
        }
    }

    public function formCreateProject()
    {
        if (isset($_SESSION['isDev']) && ($_SESSION['isDev'] == 1 || $_SESSION['isAdmin'] == 1)) {
            $customers = $this->modelProjects->modelGetCustomers();
            $this->viewProjects->viewFormProjectCreation($customers);
        } else {
            $this->viewProjects->viewAlertWarning("Access denied : You must be logged in as an administrator or a developer to view this page.");
        }
    }

    public function createProject()
    {
        if (isset($_SESSION['isDev']) && ($_SESSION['isDev'] == 1 || $_SESSION['isAdmin'] == 1)) {
            if (isset($_POST['name_project'])) {
                $array = array();
                $array['name_project'] = $_POST['name_project'];
                $array['description'] = $_POST['description'];
                $array['status_project'] = "In development";
                $array['id_customer'] = $_POST['id_customer'];

                //Check if the project already exist
                $exist = $this->modelProjects->modelProjectExist($array);
                if (!empty($exist)) {
                    $this->viewProjects->viewAlertWarning("The project " . $array['name_project'] . " already exists");
                } else {
                    $this->modelProjects->modelCreateProject($array);
                    $this->viewProjects->viewAlertSuccess("The project " . $array['name_project'] . " has been created");
                }
                $this->listProjects();
            }
        } else {
            $this->viewProjects->viewAlertWarning("Access denied : You must be logged in as an administrator or a developer to view this page.");
        }
    }

    public function formEditProject()
    {
        if (isset($_SESSION['isDev']) && ($_SESSION['isDev'] == 1 || $_SESSION['isAdmin'] == 1)) {
            $id_project = isset($_POST['id_project']) ? $_POST['id_project'] : null;
            $tab = $this->modelProjects->modelGetProjectInformation($id_project);
            $tab['name_customer'] = $this->modelProjects->modelGetCustomerName($tab['id_customer'])['name_customer'];
            $tab['list_customer'] = $this->modelProjects->modelGetCustomers();
            $this->viewProjects->viewFormEditProject($tab);
        } else {
            $this->viewProjects->viewAlertWarning("Access denied : You must be logged in as an administrator or a developer to view this page.");
        }
    }

    public function updateProject()
    {
        if (isset($_SESSION['isDev']) && ($_SESSION['isDev'] == 1 || $_SESSION['isAdmin'] == 1)) {
            if (isset($_POST['name_project'])) {
                $array = array();
                $array['id_project'] = $_POST['id_project'];
                $array['name_project'] = $_POST['name_project'];
                $array['description'] = $_POST['description'];
                $array['status_project'] = $_POST['status_project'];
                $array['id_customer'] = $_POST['id_customer'];
            }

            //Project update
            $this->modelProjects->modelUpdateProject($array);
            $this->viewProjects->viewAlertSuccess("The project " . $array['name_project'] . " has been updated");
            $this->listProjects();
        } else {
            $this->viewProjects->viewAlertWarning("Access denied : You must be logged in as an administrator or a developer to view this page.");
        }
    }

    public function deleteProject()
    {
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {
            $id_project = isset($_GET['id']) ? $_GET['id'] : null;
            $this->modelProjects->modelDeleteCustomer($id_project);

            $this->viewProjects->viewAlertSuccess("The project #00" . $id_project . " has been deleted");
            $this->listProjects();
        } else {
            $this->viewProjects->viewAlertWarning("Access denied : You must be logged in as an administrator to view this page.");
        }
    }
}
