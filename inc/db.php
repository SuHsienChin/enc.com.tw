<?php
/**
*定義資料庫父類別，供其他需要存取資料庫的類別繼承之用。
*/
class Database{
    public $db;
    public $add_sql;
    public $update_sql;
    public $delete_sql;
    public $select_sql;
    public $selectClass_sql;
    public $retrieve_sql;
    public $countRecordsById_sql;
    public $countRecords_sql;
    public $pages_sql;
    public $do_sql;

    public function __construct(){
        try {
            $this->db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DATABASE, DB_USER, DB_PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            /*** echo a message saying we have connected ***/
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function Add(){
        $this->setSQL();
        $result=$this->db->prepare($this->add_sql);
        try{
            return $result->execute();
        }catch (PDOException $e){
            return false;
        }
    }

    public function Del(){
        $this->setSQL();
        $result=$this->db->prepare($this->delete_sql);
        try{
            return $result->execute();
        }catch (PDOException $e){
            return false;
        }
    }

    public function update(){
        $this->setSQL();
        $result=$this->db->prepare($this->update_sql);
        try{
            return $result->execute();
        }catch (PDOException $e){
            return false;
        }
    }

    public function getDb() {
        if ($this->db instanceof PDO) {
            return $this->db;
        }
    }

    public function select(){
        $this->setSQL();
        return $this->recordset($this->select_sql);
    }

    public function selectClass(){
        $this->setSQL();
        return $this->recordset($this->selectClass_sql);
    }

    public function recordset($sql){
        $rs = array();
        $result=$this->db->prepare($sql);
        try{
            $result->execute();
            if($result){
                while($record = $result->fetch()){
                    array_push($rs, $record);
                }
            }
            return $rs;
        }catch (PDOException $e){
            return false;
        }
    }

    public function DoSql(){
        $this->setSQL();
        $result=$this->db->prepare($this->do_sql);
        try{
            $result->execute();
            return $result->fetch();
        }catch (PDOException $e){
            return false;
        }
    }

    public function Retrieve(){
        $this->setSQL();
        $result=$this->db->prepare($this->retrieve_sql);
        try{
            $result->execute();
            return $result->fetch();
        }catch (PDOException $e){
            return false;
        }
    }

    public function countRecrodsById(){
        $this->setSQL();
        $result=$this->db->prepare($this->countRecordsById_sql);
        try{
            $result->execute();
            $count = $result->fetch();
            return $count;
        }catch (PDOException $e){
            return 0;
        }
    }
    public function countRecrods(){
        $this->setSQL();
        $result=$this->db->prepare($this->countRecords_sql);
        try{
            $result->execute();
            $count = $result->fetch();
            return $count;
        }catch (PDOException $e){
            return 0;
        }
    }

    public function pages(){
        $this->setSQL();
        return $this->recordset($this->pages_sql);
    }


}
?>