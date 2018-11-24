<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/header.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/leftbar.php'; ?>
<script type="text/javascript">
    document.title = "Slide | VinaEnter Edu";
</script>
<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2>Quản lý slide</h2>
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
                                    <a href="/admin/slide/add.php" class="btn btn-success btn-md">Thêm</a>
                                </div>
                            </div>
                            
                            <?php
                                if(isset($_GET['msg'])){
                            ?>
                            <p style="color: red; text-align: center;"><?php echo urldecode($_GET['msg']); ?></p>
                            <?php
                                }
                            ?>
                            <form action="/admin/slide/del.php" method="post">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><input type="checkbox" id="checkall"/></th>
                                            <th>ID</th>
                                            <th>Link</th>
                                            <th>Ảnh</th>
                                            <th width="160px">Chức năng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $sql = "SELECT COUNT(*) AS total FROM slide";
                                            $rs =mysql_query($sql);
                                            $arTotal = mysql_fetch_assoc($rs);
                                            $total = $arTotal['total'];
                                            if($total > 0){
                                            $row_count = ROW_COUNT5;
                                            $total_page = ceil($total / $row_count);
                                            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                                            if($current_page < 1){
                                                $current_page = 1;
                                            }elseif($current_page > $total_page){
                                                $current_page = $total_page;
                                            }elseif(preg_match("/\D/", $current_page)){
                                                $current_page = 1;
                                            }
                                            $offset = ($current_page - 1) * $row_count;
                                            $query = "SELECT * FROM slide ORDER BY id DESC LIMIT {$offset}, {$row_count}";
                                            $result =mysql_query($query);
                                            while($row = mysql_fetch_assoc($result)){
                                                $id = $row['id'];
                                                $link = $row['link'];
                                                $picture = $row['picture'];
                                        ?>
                                        <tr class="gradeX">
                                            <td class="text-center"><input type="checkbox" name="checkid[]" value="<?php echo $id; ?>" /></td>
                                            <td><?php echo $id ?></td>
                                            <td><?php echo $link ?></td>
                                            <td class="text-center">
                                            <?php
                                                if($picture != ""){
                                            ?>
                                            <img src="/files/<?php echo $picture ?>" alt="<?php echo $picture ?>" height="100px" width="100px">
                                            <?php
                                                }else{
                                            ?>
                                            <strong>Không có hình</strong>
                                            <?php
                                                }
                                            ?>
                                            </td>
                                            <td class="center">
                                                <a href="/admin/slide/edit.php?id=<?php echo $id ?>&page=<?php echo $current_page; ?>" title="Sửa" class="btn btn-primary"><i class="fa fa-edit "></i> Sửa</a>
                                                <a href="/admin/slide/del.php?id=<?php echo $id ?>&page=<?php echo $current_page; ?>" onclick="return confirm('Bạn có chắc chắn xóa không?')" title="Xóa" class="btn btn-danger"><i class="fa fa-pencil"></i> Xóa</a>
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                <input type="submit" name="submit" class="btn btn-danger" value="Xóa">
                            </form>    
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="dataTables_info" id="dataTables-example_info" style="margin-top:27px">Hiển thị từ 1 đến <?php echo ROW_COUNT; ?> của <?php echo $total; ?> slide</div>
                                </div>
                                <div class="col-sm-6" style="text-align: right;">
                                    <div class="dataTables_paginate paging_simple_numbers" id="dataTables-example_paginate">
                                        <ul class="pagination1">
                                            <?php
                                                for($i = 1; $i <= $total_page; $i++){
                                                    $active = '';
                                                    if($i == $current_page){
                                                        $active = 'active';
                                            ?>
                                            <li class="paginate_button <?php echo $active ?>"><span><?php echo $i ?></span></li>
                                            <?php            
                                                    }else{
                                            ?>
                                            <li class="paginate_button <?php echo $active ?>"><a href="/admin/slide/index.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                                            <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
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