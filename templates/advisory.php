<?php
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');


//資料庫連線
try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
    echo $e->getMessage();
}
$getDate = date("Y-m-d");
//----
if (isset($_POST['adv_submit'])) {

    include("PHPMailer/class.phpmailer.php"); //匯入PHPMailer類別

    $sql = "INSERT INTO advisory (name,email,tel,content,date)";
    $sql .= " VALUES ('" . $_POST['name'] . "','" . $_POST['email'] . "','" . $_POST['tel'] . "','" . $_POST['content'] . "','" . $getDate . "')";
    $st = $db->prepare($sql);
    $st->execute();

    $infosql = "SELECT * FROM webinfo";
    $in = $db->prepare($infosql);
    $in->execute();
    $result = $in->fetch(PDO::FETCH_ASSOC);

    $html = "<html><head>";
    $html.= "<style>th, td {border:1px solid #aaa}table {border-collapse:collapse;background-color: #a3d7ff; width:500px; font-size: 18px;}</style>";
    $html.= "</head><body><table>";
    $html .= "<tr><td width=\"20%\">聯絡姓名</td><td>".$_POST['name']."</td></tr>";
    $html .= "<tr><td>email</td><td>".$_POST['email']."</td></tr>";
    $html .= "<tr><td>聯絡電話</td>".$_POST['tel']."<td></td></tr>";
    $html .= "<tr><td>諮詢內容</td><td>".$_POST['content']."</td></tr>";
    $html .= "</table></body></html>";
    $html .= "</body></html>";

    $mail = new PHPMailer(); //建立新物件
    $mail->IsSMTP(); //設定使用SMTP方式寄信
    $mail->SMTPAuth = true; //設定SMTP需要驗證
    $mail->Host = "mail.yabees.com.tw"; //設定SMTP主機
    $mail->Port = 25; //設定SMTP埠位，預設為25埠。
    $mail->CharSet = "utf-8"; //設定郵件編碼

    $mail->Username = "email@yabees.com.tw"; //設定驗證帳號
    $mail->Password = "27326852cc"; //設定驗證密碼

    $mail->From = "email@yabees.com.tw"; //設定寄件者信箱
    $mail->FromName = "維德國際Service"; //設定寄件者姓名

    $mail->Subject = "預約諮詢"; //設定郵件標題
    $mail->Body = $html; //設定郵件內容
    $mail->IsHTML(true); //設定郵件內容為HTML
    $mail->AddAddress($result['email1'],"維德國際Service"); //設定收件者郵件及名稱
    if($result['email2']<>""){
        $mail->AddCC($result['email2'],"維德國際Service"); //設定收件者郵件及名稱
    }
    if($result['email3']<>""){
        $mail->AddCC($result['email3'],"維德國際Service"); //設定收件者郵件及名稱
    }
    if($result['email4']<>""){
        $mail->AddCC($result['email4'],"維德國際Service"); //設定收件者郵件及名稱
    }
    if($result['email5']<>""){
        $mail->AddCC($result['email5'],"維德國際Service"); //設定收件者郵件及名稱
    }



    if (!$mail->Send()) {
        echo "<script>alert('寄件錯誤：".$mail->ErrorInfo."');</script>";
    } else {
        echo "<script>alert('寄件成功，請等待回覆');</script>";
    }

}
?>
<h3>預約諮詢</h3>
<form method="post" name="adv_form" id="adv_form">
    <p><span>聯絡姓名</span>
        <input name="name" id="adv_name" type="text" placeholder="聯絡姓名" class="required"></p>

    <p><span>聯絡mail</span>
        <input name="email" id="adv_email" type="text" placeholder="聯絡mail" class="required"></p>

    <p><span>聯絡電話</span>
        <input name="tel" id="adv_tel" type="text" placeholder="聯絡電話" class="required"></p>

    <p><span>詢問資訊</span>
        <textarea name="content" id="adv_content" placeholder="請輸入詢問資訊" class="required"></textarea>
    </p>

    <div class="po"><input id="adv_submit" name="adv_submit" type="submit" value="送出" class="btn_01">
        <input name="" type="reset" value="重設" class="btn_01">
    </div>
</form>
<script>
    $(function () {

        $("#adv_submit").click(function(){
            if($('#adv_name').val() == "" ){
                alert('請輸入預約諮詢姓名');
                $('#adv_name').focus();
                return false;
            }
            if($('#adv_email').val() == "" ){
                alert('請輸入預約諮詢email');
                $('#adv_email').focus();
                return false;
            }
            if($('#adv_tel').val() == "" ){
                alert('請輸入預約諮詢電話');
                $('#adv_tel').focus();
                return false;

            }
            if($('#adv_content').val() == "" ){
                alert('請輸入預約諮詢內容');
                $('#adv_content').focus();
                return false;

            }
        });


    })
</script>