<?php
    session_start();
    ob_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/util/DBConnectionUtil.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Resign Form</title>
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
					Resign Account
				</span>
				<?php
					$err = "";
					$name = "";
					$password = "";
					$email = "";
					if(isset($_POST['submit'])){
						$name = $_POST['username'];
						$password = $_POST['password'];
						$email = $_POST['email'];
						if(empty($name) || empty($password) || empty($email) || preg_match('/[@#$%*!]/', $name)){
							$err = "Vui lòng nhập username / password / email phù hợp";
						}elseif(!preg_match("/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/", $email) || !preg_match("/^[a-z0-9_-]{6,18}$/", $password)){
							$err = "Vui lòng nhập đúng địa chỉ email / password";
						}else{
							$fileName = "";
							$password = md5($password);
	                        if($_FILES['avatar']['name'] != ''){
	                        	var_dump($_FILES['avatar']['name']);
	                        	$fileName = $_FILES['avatar']['name'];
	                            $arName = explode('.',$fileName);
	                            $typeFile = end($arName); 
	                            $newName = 'bstory-'.time().'.'.$typeFile;
	                            $tmp_name = $_FILES['avatar']['tmp_name'];
	                            $path_upload = './files/'.$newName;
	                            $move_upload = move_uploaded_file($tmp_name,$path_upload);
	                        }
	                        var_dump($name.' - '.$password.' - '.$email);
	                        $sql = "SELECT * FROM users WHERE username = '{$name}' or email = '{$email}'";
	                        $rs = mysql_query($sql);
	                        $row_cnt = mysql_num_rows($rs);
	                        if($row_cnt > 0){
	                        	$message = "Username / Email đã tồn tại";
	                            header("location:/auth/share/resign.php?msg=".urlencode($message));
	                            die();
	                        }
	                        $sql = "INSERT INTO users(username, password, email, avatar, member,fullname,google_id) VALUES ('{$name}','{$password}','{$email}', '{$fileName}', 0,'','')";
	                        $result = mysql_query($sql);
	                        if($result){
	                        	$message = "Đăng ký thành công";
	                            header("location:/index.php?msg=".urlencode($message));
	                            die();
	                        }else{
	                            echo '<p>Có lỗi trong quá trình xử lý</p>';
	                            die();
	                        }
						}
					}
				?>
				<?php
	                if(isset($_GET['msg'])){
	            ?>
	            <p style="color: red; text-align: center;"><?php echo urldecode($_GET['msg']); ?></p>
	            <?php
	                }
	            ?>
				<form class="login100-form validate-form p-b-33 p-t-5" action="" method="post" enctype="multipart/form-data">
					<p style="color:red;text-align:center"><?php echo $err; ?></p>
					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input class="input100" type="text" name="username" minlength="4" placeholder="User name" />
						<span class="focus-input100" data-placeholder="&#xe82a;"></span>
					</div>
					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="password" minlength="6" placeholder="Password" />
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
					</div>
					<div class="wrap-input100 validate-input" data-validate="Enter email">
						<input class="input100" type="email" name="email" placeholder="Email" />
					</div>
					<div class="wrap-input100">
						<input class="input100" type="file" name="avatar" />
					</div>
					<div class="container-login100-form-btn m-t-32">
						<input class="login100-form-btn" type="submit" name="submit" value="Resign" />
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