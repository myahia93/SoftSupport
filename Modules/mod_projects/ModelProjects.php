<?php
if (!defined('CONST_INCLUDE'))
    die('Acces denied !');
?>
<?php

include_once "conf_database/authDatabase.php";

class ModelProjects extends authDatabse
{
    public function modelGetCustomers()
    {
        try {
            $req = self::$db->prepare("SELECT id_customer, name_customer FROM customer;");
            $req->execute();
            $result = $req->fetchAll();
            return $result;
        } catch (PDOException $e) {
        }
    }

    public function modelProjectExist($array)
    {
        try {
            $req = self::$db->prepare("SELECT name_project FROM project where name_project = ?;");
            $req->execute([$array['name_project']]);
            $result = $req->fetch();
            return $result;
        } catch (PDOException $e) {
        }
    }

    public function modelCreateProject($array)
    {
        try {
            $req = self::$db->prepare("INSERT INTO project (name_project, description, status_project, id_customer) VALUES (?,?,?,?);");
            $req->execute([$array['name_project'], $array['description'], $array['status_project'], $array['id_customer']]);
        } catch (PDOException $e) {
        }
    }

    public function modelListProject()
    {
        try {
            $req = self::$db->prepare("SELECT * FROM project;");
            $req->execute();
            $result = $req->fetchAll();
            return $result;
        } catch (PDOException $e) {
        }
    }

    public function modelGetCustomerName($id_customer)
    {
        try {
            $req = self::$db->prepare("SELECT name_customer FROM customer where id_customer = ?;");
            $req->execute([$id_customer]);
            $result = $req->fetch();
            return $result;
        } catch (PDOException $e) {
        }
    }

    public function modelGetProjectInformation($id_project)
    {
        try {
            $req = self::$db->prepare("SELECT * FROM project WHERE id_project = ?");
            $req->execute([$id_project]);
            $result = $req->fetch();
            return $result;
        } catch (PDOException $e) {
        }
    }

    public function modelUpdateProject($array)
    {
        try {
            $req = self::$db->prepare("UPDATE project SET name_project = ?, description = ?, status_project = ?, id_customer = ? WHERE id_project = ?;");
            $req->execute([$array['name_project'], $array['description'], $array['status_project'], $array['id_customer'], $array['id_project']]);
        } catch (PDOException $e) {
        }
    }

    public function modelDeleteCustomer($id_project)
    {
        try {
            $req = self::$db->prepare("DELETE FROM project WHERE id_project = ?");
            $req->execute([$id_project]);
        } catch (PDOException $e) {
        }
    }
}
