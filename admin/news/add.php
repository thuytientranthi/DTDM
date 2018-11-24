<?php use google\appengine\api\cloud_storage\CloudStorageTools; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/header.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/leftbar.php'; ?>
<script type="text/javascript">
    document.title = "Add News | VinaEnter Edu";
</script>
<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2>Thêm tin tức</h2>
            </div>
        </div>
        <!-- /. ROW  -->
        <hr />
        <div class="row">
            <div class="col-md-12">
                <?php
                    if(isset($_GET['msg'])){
                ?>
                <p style="color: red; text-align: center;"><?php echo urldecode($_GET['msg']); ?></p>
                <?php
                    }
                ?>
                <!-- Form Elements -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <?php
                                if(isset($_POST['submit'])){
                                    $news_name = $_POST['name'];
                                    $cat_id = $_POST['cat_id'];
                                    $preview_text = $_POST['preview_text'];
                                    $detail_text = $_POST['detail_text'];
                                    if(empty($news_name) || empty($cat_id) || empty($preview_text) || empty($detail_text) || preg_match('/[@#$*!]/', $news_name)){
                                        $message ="Vui lòng nhập đầy đủ và phù hợp thông tin";
                                        header("location:/admin/news/add.php?msg=". urlencode($message));
                                        die();
                                    }
                                    $fileName = $_FILES['picture']['name'];
                                    $bucket = 'helloworld-nhom2.appspot.com';
                                    $path_root = 'gs://' .$bucket.'/';
                                    if($fileName != ''){
                                        $arName = explode('.',$fileName);
                                        $typeFile = end($arName);
                                        $newName = 'image-'.time().'.'.$typeFile;
                                        $tmp_name = $_FILES['picture']['tmp_name'];
                                        $path_upload = $path_root.'files/'.$newName;
                                        $move_upload = move_uploaded_file($tmp_name,$path_upload);
                                        //$_url=CloudStorageTools::getImageServingUrl($path_upload);
                                        // var_dump($move_upload);
                                        // die();
                                    }
                                    $query = "INSERT INTO news(name, preview, detail, created_by, picture, cat_id) VALUES ('{$news_name}','{$preview_text}','{$detail_text}',{$_SESSION['userInfo']['id']},'{$newName}',{$cat_id})";
                                    $result = mysql_query($query);
                               
                                    if($result){
                                        $message ="Thêm tin thành công";
                                        header('Location:/admin/news/index.php?msg='. urlencode($message));
                                        die();
                                    }else{
                                        echo '<p>Có lỗi trong quá trình xử lý</p>';
                                        die();
                                    }
                                }
                            ?>
                            <div class="col-md-12">
                                <form role="form" action="" method="post" enctype="multipart/form-data" class="frAdd">
                                    <div class="form-group">
                                        <label>Tên tin</label>
                                        <input type="text" name="name" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label>Danh mục tin</label>
                                        <select class="form-control" name="cat_id" id="">
                                            <option value="">--Chọn danh mục--</option>
                                            <?php 
                                                $query2 = "SELECT * FROM cat_list ORDER BY id DESC";
                                                $result2 = mysql_query($query2);
                                                while($row2 = mysql_fetch_assoc($result2)){
                                                    $cat_id = $row2['id'];
                                                    $cat_name = $row2['name']; 
                                            ?>
                                                <option value="<?php echo $cat_id ?>"><?php echo $cat_name ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Hình ảnh</label>
                                        <input type="file" name="picture" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label>Mô tả</label>
                                        <textarea name="preview_text" class="form-control" rows="4"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Chi tiết</label>
                                        <textarea id="noidung" name="detail_text" class="form-control ckeditor" rows="10"></textarea>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-success btn-md">Thêm</button>
                                </form>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        $('.frAdd').validate({
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