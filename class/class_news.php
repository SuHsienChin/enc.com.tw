<?php
/**
 * Created by PhpStorm.
 * User: MayumiKing
 * Date: 2016/2/25
 * Time: 下午 06:16
 */
include_once(INCLUDE_DIR . 'db.php');

class class_news extends Database{

    public  $db;
    private $startPage;
    private $pageSize;
    private $id;



    // 類別的建構方法
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

    //取得property 使用magic word
    public function __get($property){
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    //設定property 使用magic word
    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
        return $this;
    }

    // setProperties 方法用來連接表單的欄位以及類別的屬性
    public function setProperties(){
        $this->id = $_GET['id'];
        $this->startPage = $_GET['startPage'];
        $this->pageSize = $_GET['pageSize'];
    }

    // setSQL 方法定義存取資料表所需的各個 SQL 命令
    function setSQL(){
        $tableName="news";
        $this->select_sql = "SELECT * FROM $tableName LIMIT 5";

        $this->retrieve_sql = "SELECT * FROM $tableName WHERE id='$this->id'";

        $this->countRecords_sql = "SELECT count(*) as count FROM $tableName ";
        $this->pages_sql = "SELECT * FROM $tableName ORDER BY id LIMIT $this->startPage , $this->pageSize";
    }

}