<?php
if (!defined('CONST_INCLUDE'))
    die('Acces denied !');
?>
<?php

include_once "ViewStats.php";
include_once "ModelStats.php";

class ContStats
{
    private $viewStats;
    private $modelStats;

    public function __construct()
    {
        $this->viewStats = new ViewStats();
        $this->modelStats = new ModelStats();
    }

    public function listStats()
    {
        if (isset($_SESSION['id_user'])) {
            $this->viewStats->viewStatsPage();
        } else {
            $this->viewProjects->viewAlertWarning("Access denied : You must be logged in to view this page.");
        }
    }
}
