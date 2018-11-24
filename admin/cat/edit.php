<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/header.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/leftbar.php'; ?>
<script type="text/javascript">
    document.title = "Edit Cat | VinaEnter Edu";
</script>
<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2>Sửa danh mục</h2>
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
                                if(!isset($_GET['id']) || !preg_match("/^[0-9]+$/", $_GET['id'])){
                                    $message ="Id danh mục không phù hợp";
                                    header("Location: /admin/cat/?msg=" . urlencode($message));
                                    die();
                                }
                                $id = $_GET['id'];
                                $query = "SELECT * FROM cat_list WHERE id = {$id}";
                                $result = mysql_query($query);
                                $row = mysql_fetch_assoc($result);
                                $name = $row['name'];
                                $parent_id = $row['parent_id'];
                                $sql1 = "SELECT COUNT(*) AS count FROM cat_list WHERE id = {$id}";
                                $rs1 = mysql_query($sql1);
                                $arCount1 = mysql_fetch_assoc($rs1);
                                if($arCount1['count'] == 0){
                                    $message ="Không tồn tại danh mục này";
                                    header("Location:/admin/cat/?msg=" . urlencode($message));
                                    die();
                                }
                                if(isset($_POST['submit'])){
                                    $name = $_POST['name'];
                                    $cat_id = $_POST['cat_id'];
                                    if(empty($name) || preg_match('/[@#$%*&]/', $name)){
                                        $message = "Vui lòng nhập tên danh mục phù hợp";
                                        header("Location:/admin/cat/edit.php?id={$id}&msg=" . urlencode($message));
                                        die();
                                    }
                                    $sql = "SELECT COUNT(*) AS count FROM cat_list WHERE name = '{$name}' AND id = {$id}";
                                    $rs = mysql_query($sql);
                                    $arCount = mysql_fetch_assoc($rs);
                                    if($arCount['count'] > 0){
                                        $query2 = "UPDATE cat_list SET name = '{$name}', parent_id = '{$cat_id}' WHERE id = {$id}";
                                        $result2 = mysql_query($query2);
                                        if($result2){
                                            $message="Sửa danh mục thành công";
                                            header("Location:/admin/cat/index.php?msg=" . urlencode($message));
                                            die();
                                        }else{
                                            echo '<p>Có lỗi trong quá trình xử lý</p>';
                                            die();
                                        }
                                    }else{
                                        $sql = "SELECT COUNT(*) AS count FROM cat_list WHERE name = '{$name}'";
                                        $rs = mysql_query($sql);
                                        $ar = mysql_fetch_assoc($rs);
                                        if($ar['count'] > 0){
                                            $message = "Tên danh mục đã tồn tại";
                                            header("Location:/admin/cat/edit.php?id={$id}&msg=" . urlencode($message));
                                            die();
                                        }else{
                                            $query2 = "UPDATE cat_list SET name = '{$name}', parent_id = '{$cat_id}' WHERE id = {$id}";
                                            $result2 = mysql_query($query2);
                                            if($result2){
                                                $message ="Sửa danh mục thành công";
                                                header("Location:/admin/cat/index.php?msg=" . urlencode($message));
                                                die();
                                            }else{
                                                echo '<p>Có lỗi trong quá trình xử lý</p>';
                                                die();
                                            }
                                        }
                                    }
                                }
                            ?>
                            <div class="col-md-12">
                                <form role="form" action="" method="post" class="frEdit">
                                    <div class="form-group">
                                        <label>Tên danh mục</label>
                                        <input type="text" name="name" value="<?php echo $name; ?>" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label>Danh mục cha</label>
                                        <select name="cat_id" class="form-control">
                                            <option value="0">Không</option>
                                        <?php
                                        $query2 = "SELECT * FROM cat_list WHERE parent_id = 0 and id != {$id}";
                                        $result2 = mysql_query($query2);
                                        while($row2 = mysql_fetch_assoc($result2)){
                                            if($row2['id'] == $parent_id){
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
                                    <button type="submit" name="submit" class="btn btn-success btn-md">Sửa</button>
                                </form>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        $(".frEdit").validate({
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