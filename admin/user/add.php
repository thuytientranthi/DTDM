<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/header.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/leftbar.php'; ?>
<script type="text/javascript">
    document.title = "Add User | VinaEnter Edu";
</script>
<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2>Thêm người dùng</h2>
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
                            <?php
                                if(isset($_POST['submit'])){
                                    $username = $_POST['username'];
                                    $password = $_POST['password'];
                                    $fullname = $_POST['fullname'];
                                    if(empty($username) || empty($password) || empty($fullname)){
                                        $message = "Vui lòng nhập đầy đủ thông tin";
                                        header("Location:/admin/user/?msg=". urlencode($message));
                                        die();
                                    }elseif(!preg_match("/^[a-z0-9_-]{3,16}$/", $username) || !preg_match("/^[a-z0-9_-]{6,18}$/", $password) || preg_match("/[@#$%!&*]/", $fullname)){
                                        $message ="Vui lòng nhập username / password / fullname phù hợp";
                                        header("Location:/admin/user/?msg=". urlencode($message));
                                        die();
                                    }
                                    $password = md5($password);
                                    $query = "SELECT * FROM users WHERE username = '{$username}'";
                                    $result = mysql_query($query);
                                    $row_cnt = mysql_num_rows($result);
                                    if($row_cnt > 0){
                                        $message ="Username đã tồn tại";
                                        header("Location:/admin/user/?msg=". urlencode($message));
                                        die();
                                    }
                                    $queryAddUser = "INSERT INTO users(username,password,fullname,email,avatar,google_id) VALUES ('{$username}','{$password}','{$fullname}','','','')";
                                    $resultAddUser = mysql_query($queryAddUser);

                                    if($resultAddUser){
                                        $message ="Thêm người dùng thành công";
                                        header("Location:/admin/user/?msg=". urlencode($message));
                                        die();
                                    }else{
                                        $message ="Có lỗi trong quá trình xử lý";
                                        header("Location:/admin/user/?msg=". urlencode($message));
                                        die();
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
                            <div class="col-md-12">
                                <form role="form" action="" method="post" class="frAdd">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" name="username" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label>Fullname</label>
                                        <input type="text" name="fullname" class="form-control" />
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-success btn-md">Thêm</button>
                                </form>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        $('.frAdd').validate({
                                            rules:{
                                                "username": {
                                                    required: true,
                                                    minlength: 3,
                                                    maxlength: 16
                                                },
                                                "password": {
                                                    required: true,
                                                    minlength: 6,
                                                    maxlength: 18
                                                },
                                                "fullname": {
                                                    required: true
                                                }
                                            },
                                            messages: {
                                                "username": {
                                                    required: "Vui lòng nhập tên người dùng",
                                                    minlength: "Vui lòng nhập tối đa 3 kí tự",
                                                    maxlength: "Vui lòng nhập tối đa 16 kí tự"
                                                },
                                                "password": {
                                                    required: "Vui lòng nhập password",
                                                    minlength: "Vui lòng nhập tối đa 6 kí tự",
                                                    maxlength: "Vui lòng nhập tối đa 18 kí tự"
                                                },
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