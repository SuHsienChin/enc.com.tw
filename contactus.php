<?php
header("Content-Type:text/html; charset=utf-8");
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
if (isset($_POST['cont_submit'])) {
    include("PHPMailer/class.phpmailer.php"); //匯入PHPMailer類別
    $sql = "INSERT INTO contactus(company, department, contact, sex, tel, extension, email, addr, content, mobi, date)";
    $sql .= " VALUES ('" . $_POST['company'] . "','" . $_POST['department'] . "','" . $_POST['contact'] . "','" . $_POST['sex'] . "',";
    $sql .= " '" . $_POST['tel'] . "','" . $_POST['extension'] . "','" . $_POST['email'] . "','" . $_POST['addr'] . "',";
    $sql .= "'" . $_POST['content'] . "','" . $_POST['mobi'] . "','" . $getDate . "')";
    $st = $db->prepare($sql);
    $st->execute();

    $infosql = "SELECT * FROM webinfo";
    $in = $db->prepare($infosql);
    $in->execute();
    $result = $in->fetch(PDO::FETCH_ASSOC);

    $html = "<html><head>";
    $html .= "<style>th, td {border:1px solid #aaa}table {border-collapse:collapse;background-color: #a3d7ff; width:500px; font-size: 18px;}</style>";
    $html .= "</head><body><table>";
    $html .= "<tr><td width=\"20%\">公司名稱</td><td>" . $_POST['company'] . "-" . $_POST['department'] . "</td></tr>";
    $html .= "<tr><td>聯絡人</td><td>" . $_POST['contact'] . "-" . $_POST['sex'] . "</td></tr>";
    $html .= "<tr><td>聯絡電話</td>" . $_POST['tel'] . "-" . $_POST['extension'] . "<td></td></tr>";
    $html .= "<tr><td>手機</td>" . $_POST['mobi'] . "<td></td></tr>";
    $html .= "<tr><td>email</td><td>" . $_POST['email'] . "</td></tr>";
    $html .= "<tr><td>公司地址</td>" . $_POST['addr'] . "<td></td></tr>";
    $html .= "<tr><td>諮詢內容</td><td>" . $_POST['content'] . "</td></tr>";
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
    $mail->AddAddress($result['email1'], "維德國際Service"); //設定收件者郵件及名稱
    if ($result['email2'] <> "") {
        $mail->AddCC($result['email2'], "維德國際Service"); //設定收件者郵件及名稱
    }
    if ($result['email3'] <> "") {
        $mail->AddCC($result['email3'], "維德國際Service"); //設定收件者郵件及名稱
    }
    if ($result['email4'] <> "") {
        $mail->AddCC($result['email4'], "維德國際Service"); //設定收件者郵件及名稱
    }
    if ($result['email5'] <> "") {
        $mail->AddCC($result['email5'], "維德國際Service"); //設定收件者郵件及名稱
    }


    if (!$mail->Send()) {
        echo "<script>alert('寄件錯誤：".$mail->ErrorInfo."');</script>";
    } else {
        echo "<script>alert('寄件成功，請等待回覆');</script>";
    }

}
include_once('templates/header.php');

?>
<!--右頁面-->
<div class="righr_page">
    <div class="title_02">
        <h2><span>聯絡我們</span></h2>
    </div>

    <form method="post" name="cont_form" id="cont_form">
        <div class="page_body">
            <ul class="contactus_tb">
                <li>
                    <h3>公司名稱</h3>

                    <p><input name="company" type="text" class="w_274 required"></p>
                    <h4>單位</h4>

                    <p><input name="department" type="text" class="w_190 required"></p>
                </li>
                <li>
                    <h3><span class="txt-red">*</span>聯絡人</h3>

                    <p><input id="contact" name="contact" type="text" class="w_274 required"></p>
                    <h4>性別</h4>

                    <p>
                        <label class="w_s2">
                            <input type="radio" name="sex" value="先生" id="sex1">
                            先生</label>

                        <input type="radio" name="sex" value="女士" id="sex2">
                        女士</label>


                    </p>

                </li>
                <li>
                    <h3>電話</h3>

                    <p><input name="tel" type="text" class="w_274 "></p>
                    <h4>分機</h4>

                    <p><input name="extension" type="text" class="w_190"></p>
                </li>
                <li>
                    <h3><span class="txt-red">*</span>手機</h3>

                    <p><input id="mobi" name="mobi" type="text" class="w_274 required"></p>
                </li>
                <li>
                    <h3><span class="txt-red">*</span>E-MAIL</h3>

                    <p><input id="email" name="email" type="text" class="w_540 required email"></p>
                </li>
                <li>
                    <h3>公司地址</h3>

                    <p><input name="addr" type="text" class="w_540 "></p>
                </li>
                <li>
                    <h3><span class="txt-red">*</span>聯絡內容</h3>

                    <p>
                        <textarea id="content" name="content" rows="5" class="w_540 h_240 required"></textarea>
                    </p>
                </li>

            </ul>

            <div class="homeback2">
                <input id="cont_rew" name="submit" type="submit" value="重新填寫" class="btn_01">
                <input id="cont_submit" name="cont_submit" type="submit" value="送出" class="btn_01">
            </div>
    </form>
</div>
<?php include_once('templates/homeback.php'); ?>

</div>
<?php include_once('templates/footer.php'); ?>
<script>
    $(function () {

        $("#cont_form").validate();


    })
</script>