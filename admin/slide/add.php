<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/header.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/leftbar.php'; ?>
<script type="text/javascript">
    document.title = "Add Slide | VinaEnter Edu";
</script>
<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2>Thêm slide</h2>
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
                                if(isset($_POST['submit'])){
                                    $link = $_POST['link'];
                                    if(empty($link) || !preg_match("/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/", $link)){
                                        $message ="Vui lòng nhập link phù hợp";
                                        header("location:/admin/slide/add.php?msg=". urlencode($message));
                                        die();
                                    }
                                    $fileName = $_FILES['slide_picture']['name'];
                                    if($fileName != ''){
                                        $arName = explode('.',$fileName);
                                        $typeFile = end($arName); 
                                        $newName = 'bstory-'.time().'.'.$typeFile;
                                        $tmp_name = $_FILES['slide_picture']['tmp_name'];
                                        $path_root = $_SERVER['DOCUMENT_ROOT'];
                                        $path_upload = $path_root.'/files/'.$newName;
                                        $move_upload = move_uploaded_file($tmp_name,$path_upload);
                                    }
                                    $query = "INSERT INTO slide(link,picture) VALUES ('{$link}','{$newName}')";
                                    $result = mysql_query($query);
                                    if($result){
                                        $message ="Thêm slide thành công";
                                        header('Location:/admin/slide/index.php?msg='. urlencode($message));
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
                                        <label>Link</label>
                                        <input type="text" name="link" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label>Hình ảnh</label>
                                        <input type="file" name="slide_picture" class="form-control" />
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-success btn-md">Thêm</button>
                                </form>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        $('.frAdd').validate({
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