<?php
/**
 * Created by PhpStorm.
 * User: MayumiKing
 * Date: 2016/2/22
 * Time: 下午 12:22
 */

include_once(INCLUDE_DIR . 'db.php');

class ClassQandA extends Database
{

    public $db;
    private $id;
    private $classId;
    private $name;
    private $content;
    private $sort;
    private $creater;
    private $flag;

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
        $this->classId = $_POST['classId'];
        $this->name = $_POST['name'];
        $this->content = $_POST['content'];
        $this->sort = $_POST['sort'];
        $this->creater = $_POST['creater'];
        $this->flag = $_POST['flag'];
    }

    // setSQL 方法定義存取資料表所需的各個 SQL 命令
    function setSQL()
    {
        $tableName = "qanda";
        $this->select_sql = "SELECT qandaclass.name as className,qandaclass.id,qanda.id,qanda.classId,qanda.name,qanda.content,qanda.sort,qanda.flag FROM qandaclass,qanda WHERE qandaclass.id=qanda.classId ";

        $this->add_sql = "INSERT INTO $tableName  ";
        $this->add_sql .= " (classId, name, content, sort, creater, flag) ";
        $this->add_sql .= " VALUES ('$this->classId','$this->name','$this->content','$this->sort','$this->creater' , ";
        $this->add_sql .= " '$this->flag' ) ";

        $this->delete_sql = "DELETE FROM $tableName  WHERE id='$this->id'";

        $this->update_sql = "UPDATE $tableName  SET classId='$this->classId', name='$this->name',content='$this->content',sort='$this->sort',flag='$this->flag'  ";
        $this->update_sql .= " WHERE id='$this->id'";

        $this->retrieve_sql = "SELECT qandaclass.name as className,qandaclass.id,qanda.id,qanda.classId,qanda.name,qanda.content,qanda.sort,qanda.flag,qanda.creater,qanda.creatDate FROM qandaclass,qanda WHERE qandaclass.id=qanda.classId AND qanda.id='$this->id' ";

        $this->countRecordsById_sql = "SELECT count(*) as count FROM qandaclass,qanda WHERE qandaclass.id=qanda.classId AND qandaclass.id='$this->classId' ";


    }

} 