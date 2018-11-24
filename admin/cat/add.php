<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/header.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/leftbar.php'; ?>
<script type="text/javascript">
    document.title = "Add Cat | VinaEnter Edu";
</script>
<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2>Thêm danh mục</h2>
            </div>
        </div>
        <!-- /. ROW  -->
        <hr />
        <?php
            if(isset($_GET['msg'])){
        ?>
        <p style="color: red; text-align: center;"><?php echo urldecode($_GET['message']); ?></p>
        <?php
            }
        ?>
        <div class="row">
            <div class="col-md-12">
                <!-- Form Elements -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <?php
                                if(isset($_POST['submit'])){
                                    $name = $_POST['name'];
                                    $cat_id = $_POST['cat_id'];
                                    if(empty($name) || preg_match("/[@#$%&*]/", $name)){
                                        $message = "Vui lòng nhập đầy đủ và phù hợp thông tin";
                                        header("Location:/admin/cat/add.php?msg=" . urlencode($message));
                                        die();
                                    }else{
                                        $sql = "SELECT COUNT(*) AS count FROM cat_list WHERE name = '{$name}'";
                                        $rs = mysql_query($sql);
                                        $arCount = mysql_fetch_assoc($rs);
                                        if($arCount['count'] > 0){
                                            $message = "Tên danh mục đã tồn tại";
                                            header("Location:/admin/cat/add.php?msg=". urlencode($message));
                                            die();
                                        }else{
                                            $queryAddCat = "INSERT INTO cat_list(name, parent_id) VALUES ('{$name}', '{$cat_id}')";
                                            $resultAddCat = mysql_query($queryAddCat);
                                            if($resultAddCat){
                                                $message = "Thêm danh mục thành công";
                                                header("Location:/admin/cat/?msg=" . urlencode($message));
                                                die();
                                            }else{
                                                $message = "Có lỗi trong quá trình xử lý";
                                                header("Location:/admin/cat/add.php?msg=". urlencode($message));
                                                die();
                                            }
                                        }
                                    }
                                }
                            ?>
                            <div class="col-md-12">
                                <form role="form" action="" method="post" class="frAdd">
                                    <div class="form-group">
                                        <label>Tên danh mục</label>
                                        <input type="text" name="name" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label>Danh mục cha</label>
                                        <select class="form-control" name="cat_id">
                                            <option value="0">Không</option>
                                            <?php 
                                                $query2 = "SELECT * FROM cat_list WHERE parent_id = 0 ORDER BY id DESC";
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
                                    <button type="submit" name="submit" class="btn btn-success btn-md">Thêm</button>
                                </form>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        $(".frAdd").validate({
                                            rules:{
                                                name:{
                                                    required: true
                                                }
                                            },
                                            messages:{
                                                name:{
                                                    required: "Vui lòng nhập name"
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