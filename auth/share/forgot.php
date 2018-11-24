<?php
    session_start();
    ob_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/util/DBConnectionUtil.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Form</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
    <link rel="icon" type="image/png" href="/templates/auth/images/icons/favicon.ico"/>
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/templates/auth/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/templates/auth/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/templates/auth/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/templates/auth/vendor/animate/animate.css">
<!--===============================================================================================-->  
    <link rel="stylesheet" type="text/css" href="/templates/auth/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/templates/auth/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/templates/auth/vendor/select2/select2.min.css">
<!--===============================================================================================-->  
    <link rel="stylesheet" type="text/css" href="/templates/auth/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/templates/auth/css/util.css">
    <link rel="stylesheet" type="text/css" href="/templates/auth/css/main.css">
<!--===============================================================================================-->
</head>
<body>
    <?php
        $sql = "SELECT picture FROM slide";
        $rs = mysql_query($sql);
        $num = mysql_num_rows($rs);
        while($arBackground = mysql_fetch_assoc($rs)){
            $ar[] = $arBackground['picture'];
        }
        $bk = array_rand($ar);
        $background = $ar[$bk];
    ?>
    <div class="limiter">
        <div class="container-login100" style="background-image: url('/files/<?php echo $background; ?>');">
            <div class="wrap-login100 p-t-30 p-b-50">
                <span class="login100-form-title p-b-41">
                    Forgot Password
                </span>
                <?php
                if(isset($_POST['submit'])){
                    $email = $_POST['email'];
                    $qr = "SELECT id from users where  email = '{$email}'";
                    $rsqr = mysql_query($qr);
                    $arr = mysql_fetch_assoc($rsqr);
                    $_SESSION['id'] = $arr['id'];
                    require $_SERVER['DOCUMENT_ROOT'].'/library/PHPMailer-master/PHPMailerAutoload.php';
                    $mail = new PHPMailer();
                    $mail->SMTPDebug = 1;
                    $mail->isSMTP(true);
                    $mail->Host = "smtp.gmail.com";
                    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );
                    $mail->SMTPAuth = TRUE;
                    $mail->Username = "chanhphuongqn@gmail.com";
                    $mail->Password = "chanhphuong";
                    $mail->SMTPSecure = "tsl";
                    $mail->Port = 587;

                    $mail->From = "chanhphuongqn@gmail.com";
                    $mail->FromName = "ShareIT-VNE";

                    $mail->addAddress($email);

                    $mail->isHTML(true);

                    $mail->Subject = "Forgot Password";
                    $mail->Body = 'Vui lòng <a href="https://helloworld-nhom2.appspot.com/auth/share/editpass.php?id="'.$_SESSION['id'].'" title="">click vào link</a> để lấy lại mật khẩu';
                    $mail->AltBody = "This is the plain text version of the email content";
                    $resultEmail = $mail->send();
                    if($resultEmail){
                        header("location:/auth/share/login.php?msgg=Bạn đã gửi yêu cầu thành công");
                        die();
                    }
                }  
                ?>
                <form class="login100-form validate-form p-b-33 p-t-5" action="" method="post">
                    <div class="wrap-input100 validate-input" data-validate="Enter email">
                        <input class="input100" type="email" name="email" placeholder="Email" />
                        <span class="focus-input100" data-placeholder="&#xe80f;"></span>
                    </div>
                    <div class="container-login100-form-btn m-t-32">
                        <input class="login100-form-btn" type="submit" name="submit" value="Send" />
                    </div>
                </form>
            </div>
        </div>
    </div>
    

    <div id="dropDownSelect1"></div>
    
<!--===============================================================================================-->
    <script src="/templates/auth/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
    <script src="/templates/auth/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
    <script src="/templates/auth/vendor/bootstrap/js/popper.js"></script>
    <script src="/templates/auth/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
    <script src="/templates/auth/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
    <script src="/templates/auth/vendor/daterangepicker/moment.min.js"></script>
    <script src="/templates/auth/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
    <script src="/templates/auth/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
    <script src="/templates/auth/js/main.js"></script>

</body>
</html>
<?php
    ob_end_flush();
?>