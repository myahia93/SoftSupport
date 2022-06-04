<?php
if (!defined('CONST_INCLUDE'))
    die('Acces denied !');
?>
<?php

include_once "ContProjects.php";

class ModProjects
{
    private $contProjects;

    public function __construct()
    {
        $this->contProjects = new ContProjects();
        if (isset($_GET['action'])) {
            $action = htmlspecialchars($_GET['action']);
        } else {
            $action = "list_Projects";
        }

        $this->setAction($action);
    }

    public function setAction($action)
    {
        switch ($action) {
            case "list_Projects":
                $this->contProjects->listProjects();
                break;
            case "form_create_project":
                $this->contProjects->formCreateProject();
                break;
            case "create_project":
                $this->contProjects->createProject();
                break;
            case "form_edit_project":
                $this->contProjects->formEditProject();
                break;
            case "edit_project":
                $this->contProjects->updateProject();
                break;
            case "delete_project":
                $this->contProjects->deleteProject();
                break;
        }
    }
}
