<?php
include_once(INCLUDE_DIR . 'db.php');

class ClassNews extends Database
{

    private $id;
    private $title;
    private $content;
    private $startDate;
    private $endDate;
    private $creater;
    private $creatDate;

    public $db;


    // 類別的建構方法
    public function __construct()
    {

        try {
            $this->db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            /*** echo a message saying we have connected ***/
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
        return $this;
    }

    // setProperties 方法用來連接表單的欄位以及類別的屬性
    public function setProperties()
    {
        $this->id = $_POST['id'];
        $this->title = $_POST['title'];
        $this->content = $_POST['content'];
        $this->startDate = $_POST['startDate'];
        $this->endDate = $_POST['endDate'];
        $this->creater = $_POST['creater'];
        $this->creatDate = date('Y-m-d');
    }

    // setSQL 方法定義存取資料表所需的各個 SQL 命令
    function setSQL()
    {
        $this->select_sql = "SELECT * FROM news";

        $this->add_sql = "INSERT INTO news ";
        $this->add_sql .= "(title, content, startDate, endDate, creater,creatDate)";
        $this->add_sql .= " VALUES ('$this->title','$this->content','$this->startDate',";
        $this->add_sql .= "'$this->endDate','$this->creater','$this->creatDate')";

        $this->delete_sql = "DELETE FROM news WHERE id='$this->id'";

        $this->update_sql = "UPDATE news SET title='$this->title',content='$this->content', ";
        $this->update_sql .= "startDate='$this->startDate', endDate='$this->endDate' ";
        $this->update_sql .= " WHERE id='$this->id'";

        $this->retrieve_sql = "SELECT * FROM news WHERE id=$this->id";
    }
}