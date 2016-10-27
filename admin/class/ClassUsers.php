<?php

class users
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    public function login($account, $pwd)
    {

        $sql = "Select * from users WHERE account = ?";
        $query = $this->db->prepare($sql);
        $query->bindValue(1, $account);

        try {
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $stored_password = $result['pwd'];
            $id = $result['id'];
            $account = $result['account'];
            $name = $result['name'];
            $arr = array(
                "id" => $id,
                "account" => $account,
                "name" => $name
            );
            if ($stored_password === $pwd) {
                return $arr;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function readAll()
    {
        $sql = "SELECT * FROM users ";
        $query = $this->db->prepare($sql);
        $results = array();
        try {
            $query->execute();
            while ($row = $query->fetch()) {
                array_push($results, $row);
            }
            return $results;
        } catch (PDOException $e) {
            die($e->getMessage());
        }

    }

    public function Add()
    {
        $sql = "SELECT * FROM users ";
        $query = $this->db->prepare($sql);
        $results = array();
        try {
            $query->execute();
            while ($row = $query->fetch()) {
                array_push($results, $row);
            }
            return $results;
        } catch (PDOException $e) {
            die($e->getMessage());
        }

    }

    public function del($id)
    {
        $sql = "DELETE FROM users WHERE id=" . $id;
        $result = $this->db->prepare($sql);

        try {
            $result->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }

    }

}