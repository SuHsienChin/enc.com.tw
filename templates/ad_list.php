<?php
/**
 * Created by PhpStorm.
 * User: MayumiKing
 * Date: 2016/3/8
 * Time: 下午 05:30
 */

include_once('inc/webConfig.php');
include_once('inc/db.php');


try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

} catch (PDOException $e) {
    echo $e->getMessage();
}
try {
    $sql = "SELECT * FROM sidead WHERE flag='1'";
    $st = $db->prepare($sql);
    $st->execute();
    while($result = $st->fetch(PDO::FETCH_ASSOC)){
        echo "<p><a href=\"".URLStrMake(($result['url']))."\" target=\"_blank\"><img src=\"admin/upload/sidead/".$result['file']."\" alt=\"".$result['title']."\"></a></p>";
    }

} catch (PDOException $e) {

}


function URLStrMake($link){
    $scheme="";
    $link = strtolower( trim( $link));
    if( pereg ("^((http:|https:|ftp:)/*)",  $link, $res) ){
        $schemefull=$res[1];
        $scheme=$res[2];
        @$link= "{$scheme}//". pereg_replace  ( "^((http:|https:|ftp:)/*)" ,"" ,$link );
        return $link;
    }
    return "http://".$link;
}