<?php
if (!defined('CONST_INCLUDE'))
    die('Acces denied !');
?>
<?php

include_once "conf_database/authDatabase.php";

class ModelTickets extends authDatabse
{
    public function modelGetProjects()
    {
        try {
            $req = self::$db->prepare("SELECT id_project, name_project FROM project;");
            $req->execute();
            $result = $req->fetchAll();
            return $result;
        } catch (PDOException $e) {
        }
    }

    public function modelCreateTicket($array)
    {
        try {
            $req = self::$db->prepare("INSERT INTO ticket (name_ticket, incident_details, status, creation_date, id_reporter, id_project) VALUES (?,?,?,?,?,?);");
            $req->execute([$array['name_ticket'], $array['incident_details'], $array['status'], $array['creation_date'], $array['id_reporter'], $array['id_project']]);
        } catch (PDOException $e) {
        }
    }

    public function modelGetTicketsByReporter($id_reporter)
    {
        try {
            $req = self::$db->prepare("SELECT * FROM ticket WHERE id_reporter = ?;");
            $req->execute([$id_reporter]);
            $result = $req->fetchAll();
            return $result;
        } catch (PDOException $e) {
        }
    }

    public function modelGetTicketsByDev($id_dev)
    {
        try {
            $req = self::$db->prepare("SELECT * FROM ticket WHERE id_dev = ?;");
            $req->execute([$id_dev]);
            $result = $req->fetchAll();
            return $result;
        } catch (PDOException $e) {
        }
    }

    public function modelGetProjectByID($id_project)
    {
        try {
            $req = self::$db->prepare("SELECT name_project FROM project WHERE id_project = ?;");
            $req->execute([$id_project]);
            $result = $req->fetch();
            return $result;
        } catch (PDOException $e) {
        }
    }

    public function modelGetTicketsUnassigned()
    {
        try {
            $req = self::$db->prepare("SELECT * FROM ticket WHERE id_dev IS NULL;");
            $req->execute([]);
            $result = $req->fetchAll();
            return $result;
        } catch (PDOException $e) {
        }
    }

    public function modelGetUserByID($id_user)
    {
        try {
            $req = self::$db->prepare("SELECT first_name, last_name FROM user WHERE id_user = ?;");
            $req->execute([$id_user]);
            $result = $req->fetch();
            return $result;
        } catch (PDOException $e) {
        }
    }

    public function modelAssignTicket($array)
    {
        try {
            $req = self::$db->prepare("UPDATE ticket SET id_dev = ?, status = ? WHERE id_ticket = ?;");
            $req->execute([$array['id_dev'], $array['status'], $array['id_ticket']]);
        } catch (PDOException $e) {
        }
    }

    public function modelGetTicketByID($id_ticket)
    {
        try {
            $req = self::$db->prepare("SELECT * FROM ticket WHERE id_ticket = ?;");
            $req->execute([$id_ticket]);
            $result = $req->fetch();
            return $result;
        } catch (PDOException $e) {
        }
    }

    public function modelUpdateTicketStatus($array)
    {
        try {
            $req = self::$db->prepare("UPDATE ticket SET status = ? WHERE id_ticket = ?;");
            $req->execute([$array['status'], $array['id_ticket']]);
        } catch (PDOException $e) {
        }
    }

    public function modelGetTickets()
    {
        try {
            $req = self::$db->prepare("SELECT * FROM ticket ORDER BY creation_date DESC;");
            $req->execute();
            $result = $req->fetchAll();
            return $result;
        } catch (PDOException $e) {
        }
    }

    public function modelDeleteTicket($id_ticket)
    {
        try {
            $req = self::$db->prepare("DELETE FROM ticket WHERE id_ticket = ?");
            $req->execute([$id_ticket]);
        } catch (PDOException $e) {
        }
    }
}
