<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/header.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/leftbar.php'; ?>
<script type="text/javascript">
    document.title = "Edit User | VinaEnter Edu";
</script>
<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2>Sửa người dùng</h2>
            </div>
        </div>
        <!-- /. ROW  -->
        <hr />
        <div class="row">
            <div class="col-md-12">
                <!-- Form Elements -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?php
                        if(isset($_GET['msg'])){
                            ?>
                            <p style="color: red; text-align: center;"><?php echo urldecode($_GET['msg']); ?></p>
                            <?php
                        }
                        ?>
                        <div class="row">
                            <?php
                            if(!isset($_GET['id']) || !preg_match("/^[0-9]+$/", $_GET['id']) || !isset($_GET['page']) || !preg_match("/^[0-9]+$/", $_GET['page'])){
                                $message ="Id / page người dùng không phù hợp";
                                header("Location: /admin/user/?msg=". urlencode($message));
                                die();
                            }
                            $page = $_GET['page'];
                            $id = $_GET['id'];
                            $query2 = "SELECT * FROM users WHERE id = {$id}";
                            $ketqua2 = mysql_query($query2);
                            $arUser = mysql_fetch_assoc($ketqua2);
                            $sql1 = "SELECT COUNT(*) AS count FROM users WHERE id = {$id}";
                            $rs1 = mysql_query($sql1);
                            $arCount1 = mysql_fetch_assoc($rs1);
                            if($arCount1['count'] == 0){
                                $message ="Không tồn tại người dùng này";
                                header("Location:/admin/user/?msg=". urlencode($message));
                                die();
                            }

                            if($arUser['username'] == 'admin' && $_SESSION['userInfo']['username'] != 'admin'){
                               $message ="Bạn không có quyền sửa admin";
                               header("Location:/admin/user/?msg=". urlencode($message));
                               die();
                           }
                           if((($arUser['username'] == $_SESSION['userInfo']['username']) || $_SESSION['userInfo']['username'] == "admin") && $arUser['member'] != 0){
                            if(isset($_POST['submit'])){
                                $username = $_POST['username'];
                                $password = $_POST['password'];
                                $fullname = $_POST['fullname'];
                                if($password == ''){
                                    if(empty($fullname) || preg_match("/[@#$%!&*]/", $fullname)){
                                       $message ="Vui lòng nhập thông tin phù hợp";
                                       header("Location:/admin/user/edit.php?page={$page}&id={$id}&msg=". urlencode($message));
                                       die();
                                   }
                                   $query = "UPDATE users SET fullname = '{$fullname}' WHERE id = {$id}";
                                   $result = mysql_query($query);
                                   if($result){
                                       $message ="Sửa người dùng thành công";
                                       header("Location:/admin/user/?page={$page}&msg=". urlencode($message));
                                       die();
                                   }else{
                                       $message ="Có lỗi trong quá trình xử lý";
                                       header("Location:/admin/user/?msg=". urlencode($message));
                                       die();
                                   }
                               }else{
                                if(empty($fullname) || preg_match("/[@#$%!&*]/", $fullname) || !preg_match("/^[a-z0-9_-]{6,18}$/", $password)){
                                   $message ="Vui lòng nhập password / fullname phù hợp";
                                   header("Location:/admin/user/edit.php?page={$page}&id={$id}&msg=". urlencode($message));
                                   die();
                               }
                               $password = md5($password);
                               $query3 = "UPDATE users SET fullname = '{$fullname}', password = '{$password}' WHERE id = {$id}";
                               $result3 = mysql_query($query3);
                               if($result3){
                                   $message ="Sửa người dùng thành công";
                                   header("Location:/admin/user/?page={$page}&msg=". urlencode($message));
                                   die();
                               }else{
                                   $message ="Có lỗi trong quá trình xử lý";
                                   header("Location:/admin/user/?msg=". urlencode($message));
                                   die();
                               }
                           }

                       }
                   }else{
                       $message ="Bạn không có quyền sửa user khác";
                       header("Location:/admin/user/?msg=". urlencode($message));
                       die();
                   }
                   ?>
                   <div class="col-md-12">
                    <form role="form" action="" method="post" class="frEdit">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" value="<?php echo $arUser['username'] ?>" readonly class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Fullname</label>
                            <input type="text" name="fullname" value="<?php echo $arUser['fullname'] ?>" class="form-control" />
                        </div>
                        <button type="submit" name="submit" class="btn btn-success btn-md">Sửa</button>
                    </form>
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $('.frEdit').validate({
                                rules:{
                                    "fullname": {
                                        required: true
                                    }
                                },
                                messages: {
                                    "fullname": {
                                        required: "Vui lòng nhập fullname"
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