<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/header.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/leftbar.php'; ?>
<script type="text/javascript">
    document.title = "Edit Slide | VinaEnter Edu";
</script>
<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2>Sửa slide</h2>
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
                                    $message ="Id / page slide không phù hợp";
                                    header("Location: /admin/slide/index.php?msg=". urlencode($message));
                                    die();
                                }
                                $page = $_GET['page'];
                                $id = $_GET['id'];
                                $query = "SELECT * FROM slide WHERE id = {$id}";
                                $result = mysql_query($query);
                                $row = mysql_fetch_assoc($result);
                                $link = $row['link'];
                                $oldpicture = $row['picture'];
                                $sql1 = "SELECT COUNT(*) AS count FROM slide WHERE id = {$id}";
                                $rs1 = mysql_query($sql1);
                                $arCount1 = mysql_fetch_assoc($rs1);
                                if($arCount1['count'] == 0){
                                    $message ="Không tồn tại slide này";
                                    header("Location:/admin/slide/index.php?msg=". urlencode($message));
                                    die();
                                }
                                if(isset($_POST['submit'])){
                                    $link = $_POST['link'];
                                    $check = $_POST['checkpicture'];
                                    if(empty($link) || !preg_match("/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/", $link)){
                                        $message ="Vui lòng nhập link phù hợp";
                                        header("location:/admin/slide/edit.php?page={$page}&id={$id}&msg=". urlencode($message));
                                        die();
                                    }
                                    $newName = $oldpicture;
                                    if($check || $_FILES['newpicture']['name'] != ''){
                                        $path_root = $_SERVER['DOCUMENT_ROOT'];
                                        unlink($path_root.'/files/'.$newName);
                                        $newName = "";
                                    }
                                    if($_FILES['newpicture']['name'] != ''){
                                        $namePicture = $_FILES['newpicture']['name'];
                                        $arName = explode('.',$namePicture);
                                        $typeFile = end($arName);
                                        $newName = 'VNE-Story-'.time().'.'.$typeFile;
                                        $tmp_name = $_FILES['newpicture']['tmp_name'];
                                        $path_root = $_SERVER['DOCUMENT_ROOT'];
                                        $path_upload = $path_root.'/files/'.$newName;
                                        $move_upload = move_uploaded_file($tmp_name,$path_upload);
                                    }                                  

                                    $query2 = "UPDATE slide SET link = '{$link}', picture = '{$newName}' WHERE id = {$id}";
                                    $result2 = mysql_query($query2);
                                    if($result2){
                                        $message ="Sửa slide thành công";
                                        header("Location:/admin/slide/index.php?page={$page}&msg=". urlencode($message));
                                        die();
                                    }else{
                                        echo '<p>Có lỗi trong quá trình xử lý</p>';
                                        die();
                                    }
                                }
                            ?>
                            <div class="col-md-12">
                                <form role="form" action="" method="post" enctype="multipart/form-data" class="frEdit">
                                    <div class="form-group">
                                        <label>Link</label>
                                        <input type="text" name="link" value="<?php echo $link; ?>" class="form-control" />
                                    </div>
                                    <?php
                                        if($oldpicture != ""){
                                    ?>
                                    <div class="form-group">
                                        <label>Hình ảnh củ</label><br />
                                        <img src="/files/<?php echo $oldpicture ?>" alt="<?php echo $oldpicture ?>" width="90px" height="90px"><br />
                                        <input type="checkbox" name="checkpicture" /> Xóa ảnh
                                    </div>
                                    <?php
                                        }
                                    ?>
                                    <div class="form-group">
                                        <label>Hình ảnh mới</label>
                                        <input type="file" name="newpicture" class="form-control" />
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-success btn-md">Sửa</button>
                                </form>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        $('.frEdit').validate({
                                            rules:{
                                                "link": {
                                                    required: true,
                                                    url: true
                                                }
                                                },
                                                messages: {
                                                "link": {
                                                    required: 'Vui lòng nhập liên kết',
                                                    url: 'Vui lòng nhập đúng định dạng url'
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