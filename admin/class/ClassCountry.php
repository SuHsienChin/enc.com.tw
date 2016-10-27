<?php
/**
 * Created by PhpStorm.
 * User: MayumiKing
 * Date: 2016/2/22
 * Time: 下午 12:22
 */

include_once(INCLUDE_DIR . 'db.php');

class ClassCountry extends Database
{

    public $db;
    private $id;
    private $code;
    private $name;
    private $PicUrl;
    private $filename;
    private $size;
    private $type;
    private $path;


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

    // setSQL 方法定義存取資料表所需的各個 SQL 命令
    function setSQL()
    {
        $tableName = "country";
        $this->select_sql = "SELECT * FROM $tableName";

        $this->delete_sql = "DELETE FROM $tableName WHERE id='$this->id'";
        $this->retrieve_sql = "SELECT code FROM country WHERE code='$this->code'";

        $this->add_sql = "INSERT INTO country( name, code, picUrl, filename, size, type, path) VALUES (";
        $this->add_sql .= " '$this->name','$this->code','$this->PicUrl','$this->filename','$this->size','$this->type','$this->path' )";

        $this->do_sql = "SELECT * FROM $tableName WHERE id='$this->id'";

        $this->update_sql = "UPDATE $tableName SET name='$this->name',code='$this->code',picUrl='$this->PicUrl',filename='$this->filename',size='$this->size',type='$this->type' WHERE id='$this->id'";

    }

} 