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

            //Get tickets number per months for js script
            $tab = array();
            $year = date('Y');
            for ($i = 1; $i <= 12; $i++) {
                $month = ($i < 10) ? "0" . $i : $i;
                if ($i == 2) {
                    $dayEnd = "28";
                } elseif ($i == 1 | $i == 3 | $i == 5 | $i == 7 | $i == 8 | $i == 10 | $i == 12) {
                    $dayEnd = "31";
                } else {
                    $dayEnd = "30";
                }
                $startDate = $year . "-" . $month . "-01";
                $endDate = $year . "-" . $month . "-" . $dayEnd;
                $tab[$i] = $this->modelStats->modelGetTicketNumberByMonth($startDate, $endDate)['numberTicket'];
            }
            foreach ($tab as $data) {
                $amount[] = $data;
            }

            // TODO
            //User number

            //Project number

            //Customer number


            $this->viewStats->viewStatsPage($amount);
        } else {
            $this->viewStats->viewAlertWarning("Access denied : You must be logged in to view this page.");
        }
    }
}
