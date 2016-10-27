<?php
include_once('inc/webConfig.php');
include_once('inc/db.php');


try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

} catch (PDOException $e) {
    echo $e->getMessage();
}
try {
    $sql = "SELECT * FROM copyright";
    $st = $db->prepare($sql);
    $st->execute();
    $result = $st->fetch(PDO::FETCH_ASSOC);
    echo "<p class=\"copyright\">" . $result['text'] . "</p>";
} catch (PDOException $e) {

}
