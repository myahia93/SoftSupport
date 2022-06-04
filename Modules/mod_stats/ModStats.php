<?php
if (!defined('CONST_INCLUDE'))
    die('Acces denied !');
?>
<?php

include_once "ContStats.php";

class ModStats
{
    private $contStats;

    public function __construct()
    {
        $this->contStats = new ContStats();
        if (isset($_GET['action'])) {
            $action = htmlspecialchars($_GET['action']);
        } else {
            $action = "list_stats";
        }

        $this->setAction($action);
    }

    public function setAction($action)
    {
        switch ($action) {
            case "list_stats":
                $this->contStats->listStats();
                break;
        }
    }
}
