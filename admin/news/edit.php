<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/header.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/leftbar.php'; ?>
<script type="text/javascript">
    document.title = "Edit News | VinaEnter Edu";
</script>
<?php use google\appengine\api\cloud_storage\CloudStorageTools; ?>
<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2>Sửa tin</h2>
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
                                    $message = "Id / page tin không phù hợp";
                                    header("Location: /admin/news/?msg=". urlencode($message));
                                    die();
                                }
                                $page = $_GET['page'];
                                $id = $_GET['id'];
                                $query = "SELECT * FROM news WHERE id = {$id}";
                                $result = mysql_query($query);
                                $row = mysql_fetch_assoc($result);
                                $name = $row['name'];
                                $cat_id = $row['cat_id'];
                                $oldpicture = $row['picture'];
                                $preview_text = $row['preview'];
                                $detail_text = $row['detail'];
                                $sql1 = "SELECT COUNT(*) AS count FROM news WHERE id = {$id}";
                                $rs1 = mysql_query($sql1);
                                $arCount1 = mysql_fetch_assoc($rs1);
                                if($arCount1['count'] == 0){
                                    $message = "Không tồn tại tin này";
                                    header("Location:/admin/news/?msg=". urlencode($message));
                                    die();
                                }
                                $query2 = "SELECT username FROM users AS m INNER JOIN news AS n ON m.id = n.created_by WHERE n.id = {$id}";
                                $ketqua2 = mysql_query($query2);
                                $arUser = mysql_fetch_assoc($ketqua2);
                                if($arUser['username'] != $_SESSION['userInfo']['username'] && $_SESSION['userInfo']['username'] != 'admin'){
                                    $message = "Bạn không có quyền sửa bài viết của user khác";
                                    header('Location:/admin/news/?msg='. urlencode($message));
                                    die();
                                }
                            if($_SESSION['userInfo']['username'] == 'admin' || $_SESSION['userInfo']['username'] == $arUser['username']){
                                if(isset($_POST['submit'])){
                                    $name2 = $_POST['name'];
                                    $cat_id2 = $_POST['cat_id'];
                                    $preview_text = $_POST['preview_text'];
                                    $detail_text = $_POST['detail_text'];
                                    if(empty($name2) || empty($cat_id2) || preg_match('/[@#$*]/', $name2) || empty($preview_text) || empty($detail_text)){
                                        $message = "Vui lòng nhập thông tin phù hợp";
                                        header("location:/admin/news/edit.php?page={$page}&id={$id}&msg=". urlencode($message));
                                        die();
                                    }
                                    $checkpicture = $_POST['checkpicture'];
                                    $newName = $oldpicture;
                                    if($checkpicture || $_FILES['newpicture']['name'] != ''){
                                        $path_root = $_SERVER['DOCUMENT_ROOT'];
                                        unlink($path_root.'/files/'.$newName);
                                        $newName = "";
                                    }
                                    if($_FILES['newpicture']['name'] != ''){
                                        $namePicture = $_FILES['newpicture']['name'];
                                        $arName = explode('.',$namePicture);
                                        $typeFile = end($arName);
                                        $newName = 'Edit-'.time().'.'.$typeFile;
                                        $tmp_name = $_FILES['newpicture']['tmp_name'];
                                        $path_root = $_SERVER['DOCUMENT_ROOT'];
                                        $path_upload = $path_root.'/files/'.$newName;
                                        $move_upload = move_uploaded_file($tmp_name,$path_upload);
                                    }
                                    $query2 = "UPDATE news SET name = '{$name2}', preview = '{$preview_text}', detail = '{$detail_text}', picture = '{$newName}', cat_id = {$cat_id2} WHERE id = {$id}";
                                    $result2 = mysql_query($query2);
                                    if($result2){
                                        $message = "Sửa tin thành công";
                                        header("Location:/admin/news/?page={$page}&msg=". urlencode($message));
                                        die();
                                    }else{
                                        echo '<p>Có lỗi trong quá trình xử lý</p>';
                                        die();
                                    }
                                }
                            }
                            ?>
                            <div class="col-md-12">
                                <form role="form" action="" method="post" enctype="multipart/form-data" class="frEdit">
                                    <div class="form-group">
                                        <label>Tên tin</label>
                                        <input type="text" name="name" value="<?php echo $name; ?>" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label>Danh mục tin</label>
                                        <select name="cat_id" class="form-control">
                                        <?php
                                        $query2 = "SELECT * FROM cat_list";
                                        $result2 = mysql_query($query2);
                                        while($row2 = mysql_fetch_assoc($result2)){
                                            if($row2['id'] == $cat_id){
                                        ?>
                                            <option selected="selected" value="<?php echo $row2['id'] ?>" selected ><?php echo $row2['name'] ?></option>
                                        <?php
                                        }else{
                                        ?>
                                            <option value="<?php echo $row2['id'] ?>" ><?php echo $row2['name'] ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                        </select>
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
                                    <div class="form-group">
                                        <label>Mô tả</label>
                                        <textarea name="preview_text" class="form-control" rows="4"><?php echo $preview_text ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Chi tiết</label>
                                        <textarea name="detail_text" class="form-control ckeditor" rows="4"><?php echo $detail_text ?></textarea>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-success btn-md">Sửa</button>
                                </form>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        $('.frEdit').validate({
                                            rules:{
                                                "name": {
                                                    required: true
                                                },
                                                "cat_id": {
                                                    required: true
                                                },
                                                "preview_text": {
                                                    required: true
                                                },
                                                "detail_text": {
                                                    required: true
                                                }
                                            },
                                            messages: {
                                                "name": {
                                                    required: "Vui lòng nhập tên truyện"
                                                },
                                                "cat_id": {
                                                    required: "Vui lòng chọn danh mục"
                                                },
                                                "preview_text": {
                                                    required: "Vui lòng nhập mô tả"
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