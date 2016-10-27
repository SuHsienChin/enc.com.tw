<?php
/**
 * Created by PhpStorm.
 * User: MayumiKing
 * Date: 2016/2/22
 * Time: 下午 12:22
 */

include_once(INCLUDE_DIR . 'db.php');

class ClassArticle extends Database
{

    public $db;
    private $id;
    private $countryCode;
    private $countryName;
    private $PicUrl;
    private $branchCode;
    private $branchName;
    private $title;
    private $content;

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

    //取得property 使用magic word
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    //設定property 使用magic word
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
        $this->countryCode = $_POST['countryCode'];
        $this->countryName = $_POST['countryName'];
        $this->PicUrl = $_POST['PicUrl'];
        $this->branchCode = $_POST['branchCode'];
        $this->branchName = $_POST['branchName'];
        $this->title = $_POST['title'];
        $this->content = $_POST['content'];
    }

    // setSQL 方法定義存取資料表所需的各個 SQL 命令
    function setSQL()
    {
        $tableName = "articles";
        $this->select_sql = "SELECT * FROM $tableName ";
        $this->selectClass_sql = "SELECT * FROM $tableName WHERE branchCode= '$this->branchCode'";

        $this->add_sql = "INSERT INTO $tableName  ";
        $this->add_sql .= " (countryCode, countryName, PicUrl, branchCode, branchName, title,content) ";
        $this->add_sql .= " VALUES ('$this->countryCode','$this->countryName','$this->PicUrl','$this->branchCode','$this->branchName' , ";
        $this->add_sql .= " '$this->title', '$this->content' ) ";

        $this->delete_sql = "DELETE FROM $tableName  WHERE id='$this->id'";

        $this->update_sql = "UPDATE $tableName  SET countryCode='$this->countryCode', countryName='$this->countryName',PicUrl='$this->PicUrl',branchCode='$this->branchCode',branchName='$this->branchName',  ";
        $this->update_sql .= " title='$this->title', content='$this->content' WHERE id='$this->id'";

        $this->retrieve_sql = "SELECT * FROM $tableName WHERE id='$this->id'";

        $this->countRecordsById_sql = "SELECT count(*) as count FROM $tableName WHERE id='$this->id' ";

    }

} 