<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/header.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/leftbar.php'; ?>
<script type="text/javascript">
    document.title = "Rep Contact | VinaEnter Edu";
</script>
<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2>Phản hồi liên hệ</h2>
            </div>
        </div>
        <!-- /. ROW  -->
        <hr />
        <div class="row">
            <div class="col-md-12">
                <!-- Form Elements -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                if(!isset($_GET['id']) || !preg_match("/^[0-9]+$/", $_GET['id']) || !isset($_GET['email']) || !preg_match("/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/", $_GET['email'])){
                                    $message = "Id / email không phù hợp";
                                    header("Location: /admin/contact/?msg=". urlencode($message));
                                    die();
                                }
                                $id = $_GET['id'];
                                $email = $_GET['email'];
                                $qr = "SELECT count(*) as total from contact where id = {$id} and email = '{$email}'";
                                $rsqr = mysql_query($qr);
                                $arr = mysql_fetch_assoc($rsqr);
                                $count = $arr['total'];
                                if($count > 0){
                                    if(isset($_POST['submit'])){
                                        $content = $_POST['content'];
                                        require 'library/PHPMailer-master/PHPMailerAutoload.php';
                                        $mail = new PHPMailer();
                                        $mail->SMTPDebug = 1;
                                        $mail->isSMTP();
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
                                        $mail->SMTPSecure = "false";
                                        $mail->Port = 587;

                                        $mail->From = "chanhphuongqn@gmail.com";
                                        $mail->FromName = "ShareIT-VNE";

                                        $mail->addAddress($email);

                                        $mail->isHTML(true);

                                        $mail->Subject = "Thank your contact";
                                        $mail->Body = $content;
                                        $mail->AltBody = "This is the plain text version of the email content";
                                        $resultEmail = $mail->send();
                                        if($resultEmail){
                                            $sql = "UPDATE contact set active = 1 where id = {$id}";
                                            $rs = mysql_query($sql);
                                            $message ="Bạn đã phản hồi liên hệ thành công";
                                            header("location:/admin/contact/?msg=". urlencode($message));
                                        }
                                    } 
                                }else{
                                    $message ="Id / email không đúng";
                                    header("location:/admin/contact/?msg=". urlencode($message));
                                    die();
                                } 
                                ?>

                                <form role="form" action="" method="post" class="frRep">
                                    <div class="form-group">
                                        <label>Nội dung</label>
                                        <textarea class="form-control" cols="4" rows="4" name="content"></textarea>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-success btn-md">Gửi</button>
                                </form>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        $(".frRep").validate({
                                            rules:{
                                                content:{
                                                    required: true
                                                }
                                            },
                                            messages:{
                                                content:{
                                                    required: "Vui lòng nhập nội dung"
                                                }
                                            }
                                        });
                                    });
                                </script>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- End Form Elements -->
            </div>
        </div>
        <!-- /. ROW  -->
    </div>
    <!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/footer.php'; ?>