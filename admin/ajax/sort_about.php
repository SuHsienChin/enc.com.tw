<?php
/**
 * Created by PhpStorm.
 * User: MayumiKing
 * Date: 2016/3/2
 * Time: 下午 05:12
 */


$arr=array();
for ($i=0;$i<=5;$i++){
    $arr["$i"]="$i";
}


echo json_encode($arr);
