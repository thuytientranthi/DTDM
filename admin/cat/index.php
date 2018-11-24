<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/header.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/leftbar.php'; ?>
<script type="text/javascript">
    document.title = "Cat | VinaEnter Edu";
</script>
<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2>Quản lý danh mục</h2>
            </div>
        </div>
        <!-- /. ROW  -->
        <hr />

        <div class="row">
            <div class="col-md-12">
                <!-- Advanced Tables -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <div class="row" style="margin-bottom: 15px;">
                                <div class="col-sm-6">
                                    <a href="/admin/cat/add.php" class="btn btn-success btn-md">Thêm</a>
                                </div>
                            </div>
                            <?php
                                if(isset($_GET['msg'])){
                            ?>
                            <p style="color: red; text-align: center;"><?php echo urldecode($_GET['msg']); ?></p>
                            <?php
                                }
                            ?>
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên danh mục</th>
                                        <th width="160px">Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $queryCat = "SELECT * FROM cat_list WHERE parent_id = 0";
                                        $resultCat = mysql_query($queryCat);
                                        while ($row = mysql_fetch_assoc($resultCat)){
                                            $catId = $row['id'];
                                            $carName = $row['name'];
                                            $urlDel = "/admin/cat/del.php?id={$catId}";
                                            $urlEdit = "/admin/cat/edit.php?id={$catId}";
                                    ?>
                                    <tr class="gradeX">
                                        <td><?php echo $catId; ?></td>
                                        <td>
                                        <?php  
                                            echo $carName;
                                            $query = "SELECT * FROM cat_list WHERE parent_id = {$catId} ";
                                            $result = mysql_query($query);
                                            while ($ro = mysql_fetch_assoc($result)){
                                                $id = $ro['id'];
                                                $Del = "/admin/cat/del.php?id=${id}";
                                                $Edit = "/admin/cat/edit.php?id={$id}";
                                        ?>
                                        <ul><li><?php echo $ro['name']; ?><a title="Xóa" onclick="return confirm('Tin thuộc danh mục này sẽ bị xóa theo. Bạn có chắc chắn xóa không?')" href="<?php echo $Del; ?>">&nbsp;<i class="fa fa-trash-o"></i></a>&nbsp;|&nbsp;<a href title="Sửa" data-toggle="modal" data-target="#myModalEdit<?php echo $id; ?>"><i class="fa fa-edit "></i></a>
                                        <div class="modal fade" id="myModalEdit<?php echo $id; ?>" role="dialog">
                                            <div class="modal-dialog" style="width: 20%;">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Sửa danh mục</h4>
                                                    </div>
                                                    <form action="/admin/cat/edit.php?id=<?php echo $id; ?>" method="post">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="name">Tên danh mục:</label>
                                                                <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="<?php echo $ro['name']; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Danh mục cha</label>
                                                                <select name="cat_id" class="form-control">
                                                                    <option value="0">Không</option>
                                                                <?php
                                                                $query2 = "SELECT * FROM cat_list WHERE parent_id = 0";
                                                                $result2 = mysql_query($query2);
                                                                while($row2 = mysql_fetch_assoc($result2)){
                                                                    if($row2['id'] == $catId){
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
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                            <input type="submit" name="submit" class="btn btn-success" value="Lưu" />
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        </li></ul>
                                        <?php } ?>
                                        </td>
                                        <td class="center">
                                            <a href="<?php echo $urlEdit; ?>" title="Sửa" class="btn btn-primary"><i class="fa fa-edit "></i> Sửa</a>
                                            <a href="<?php echo $urlDel; ?>" title="Xóa" onclick="return confirm('Tin thuộc danh mục này sẽ bị xóa theo. Bạn có chắc chắn xóa không?')" class="btn btn-danger"><i class="fa fa-trash-o"></i> Xóa</a>
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--End Advanced Tables -->
            </div>
        </div>
    </div>

</div>
<!-- /. PAGE INNER  -->
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/footer.php'; ?>