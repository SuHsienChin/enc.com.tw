<?php
/**
 * Created by PhpStorm.
 * User: MayumiKing
 * Date: 2016/2/19
 * Time: 上午 01:26
 */

class ClassAboutUs {

    private $db;

    public function __construct($database){
        $this->db=$database;
    }

    public function add($sql){
        $result=$this->db->prepare($sql);

        try{
            $result->execute();
            return true;
        }
        catch (PDOException $e){
            return false;
        }

    }
    public function read(){
        $sql="SELECT * FROM aboutus ";
        $query=$this->db->prepare($sql);

        try{
            $query->execute();
            $results = $query->fetch();
            return $results;
        }
        catch (PDOException $e){
            die($e->getMessage());
        }
    }

} 