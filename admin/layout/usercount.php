<?php
$ipCount = 99999999; // 設定要紀錄幾組ip
$fileName = 'D:\htdocs\count.txt'; // 計數器紀錄檔
$c = 0;

if (file_exists($fileName)){  // 確認紀錄檔是否存在 若存在就讀取內容 不存在則創造空白檔案
    $fp = fopen($fileName,'r+');
    $countArray = unserialize(fgets($fp));
    fclose($fp);
}else{
    $fp = fopen($fileName,'w');
    $countArray = null;
    fclose($fp);
}

$ipcheck = array('127.0.0.1','192.168.1.1','192.168.1.2'); //直接略過不計的ip
if(is_array($countArray)){ // 讀出檔案中紀錄的ip 加上略過不計的ip 存入$ipcheck陣列中
    $c = $countArray[0];
    for($x = 1;$x <= $ipCount;$x++){
        if($x >= count($countArray)){
            break;
        }
        @$ipcheck[] = $countArray[$x];
    }
}

// 取得訪問者ip 如果訪問者ip 經過forwarded 則取得 forwarded的ip
if (empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $guestip = $_SERVER['REMOTE_ADDR'];
} else {
    $guestip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
    $guestip = $guestip[0];
}
// 校驗ip是否重複
$ipsame = false;
foreach ($ipcheck as $v){
    if ($v == $guestip){
        $ipsame = true;
        break;
    }
}
// 如果ip未重覆 則將本新ip 寫回紀錄檔中
if (!$ipsame){

    $c++;
    $temp = ($c%($ipCount))+1;
    $countArray[$temp] = $guestip;
    $countArray[0] = $c;
    $fp = fopen($fileName,'w+');
    fwrite($fp,serialize($countArray));
    fclose($fp);

}

// $c 就是計數器該顯示的數字

?>