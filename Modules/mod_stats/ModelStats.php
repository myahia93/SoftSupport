<?php
if (!defined('CONST_INCLUDE'))
    die('Acces denied !');
?>
<?php

include_once "conf_database/authDatabase.php";

class ModelStats extends authDatabse
{
    public function modelGetTicketNumberByMonth($startDate, $endDate)
    {
        try {
            $req = self::$db->prepare("SELECT COUNT(*) AS numberTicket FROM ticket WHERE creation_date >= ? AND creation_date <= ?;");
            $req->execute([$startDate, $endDate]);
            $result = $req->fetch();
            return $result;
        } catch (PDOException $e) {
        }
    }
}
