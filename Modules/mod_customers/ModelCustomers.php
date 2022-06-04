<?php
if (!defined('CONST_INCLUDE'))
    die('Acces denied !');
?>
<?php

include_once "conf_database/authDatabase.php";

class ModelCustomers extends authDatabse
{
    public function modelAddCustomer($array)
    {
        try {
            $req = self::$db->prepare("INSERT INTO customer (name_customer,city) VALUES (?,?);");
            $req->execute([$array['name_customer'], $array['city']]);
        } catch (PDOException $e) {
        }
    }

    public function modelCustomerExist($array)
    {
        try {
            $req = self::$db->prepare("SELECT name_customer FROM customer where name_customer = ? ;");
            $req->execute([$array['name_customer']]);
            $result = $req->fetch();
            return $result;
        } catch (PDOException $e) {
        }
    }

    public function modelListCustomer()
    {
        try {
            $req = self::$db->prepare("SELECT * FROM customer;");
            $req->execute();
            $result = $req->fetchAll();
            return $result;
        } catch (PDOException $e) {
        }
    }

    public function modelGetCustomerInformation($id_customer)
    {
        try {
            $req = self::$db->prepare("SELECT * FROM customer WHERE id_customer = ?");
            $req->execute([$id_customer]);
            $result = $req->fetch();
            return $result;
        } catch (PDOException $e) {
        }
    }

    public function modelUpdateCustomer($array)
    {
        try {
            $req = self::$db->prepare("UPDATE customer SET name_customer = ?, city = ? WHERE id_customer = ?;");
            $req->execute([$array['name_customer'], $array['city'], $array['id_customer']]);
        } catch (PDOException $e) {
        }
    }

    public function modelDeleteCustomer($id_customer)
    {
        try {
            $req = self::$db->prepare("DELETE FROM customer WHERE id_customer = ?");
            $req->execute([$id_customer]);
        } catch (PDOException $e) {
        }
    }

    public function modelCountNumberOfProject($id_customer)
    {
        try {
            $req = self::$db->prepare("SELECT COUNT(*) FROM project WHERE id_customer = ?");
            $req->execute([$id_customer]);
            $result = $req->fetch();
            return $result;
        } catch (PDOException $e) {
        }
    }
}
