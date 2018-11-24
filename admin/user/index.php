<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/header.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/leftbar.php'; ?>
<script type="text/javascript">
    document.title = "User | VinaEnter Edu";
</script>
<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2>Quản lý người dùng</h2>
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
                                    <a href="/admin/user/add.php" class="btn btn-success btn-md">Thêm</a>
                                </div><br />
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
                                        <th>Username</th>
                                        <th>Fullname</th>
                                        <th>Member</th>
                                        <th>Trạng thái</th>
                                        <th width="160px">Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sql = "SELECT COUNT(*) AS total FROM users";
                                        $rs = mysql_query($sql);
                                        $arTotal = mysql_fetch_assoc($rs);
                                        $total = $arTotal['total'];
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
                                        $query = "SELECT * FROM users LIMIT {$offset}, {$row_count}";
                                        $result = mysql_query($query);
                                        while($arUser = mysql_fetch_assoc($result)){
                                            $id = $arUser['id'];
                                            $username = $arUser['username'];
                                            $fullname = $arUser['fullname'];
                                            $active = $arUser['active'];
                                            $member = $arUser['member'];
                                    ?>
                                    <tr class="gradeX">
                                        <td><?php echo $id ?></td>
                                        <td><?php echo $username ?></td>
                                        <td><?php echo $fullname ?></td>
                                        <?php
                                            if($member == 0){
                                                $mb = "New";
                                            }else{
                                                $mb = "VIP";
                                            }
                                        ?>
                                        <td><?php echo $mb; ?></td>
                                        <?php
                                            if($active == 1){
                                                $img = "active.gif";
                                            }else{
                                                $img = "deactive.gif";
                                            }
                                        ?>
                                        <td>
                                            <?php if($_SESSION['userInfo']['username'] == 'admin'){ ?>
                                            <a href="javascript:void(0)" class="activeuser" active="<?php echo $active; ?>" id="<?php echo $id; ?>"><img src="/templates/admin/assets/img/<?php echo $img; ?>" alt="<?php echo $img; ?>" ></a>
                                            <?php }elseif($_SESSION['userInfo']['username'] == $username || $arUser['member'] == 0){ ?>
                                            <a href="javascript:void(0)" class="activeuser" active="<?php echo $active; ?>" id="<?php echo $id; ?>"><img src="/templates/admin/assets/img/<?php echo $img; ?>" alt="<?php echo $img; ?>" ></a>
                                            <?php } ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if($_SESSION['userInfo']['username'] == 'admin'){ ?>   
                                                <?php if(($username != 'admin' || $_SESSION['userInfo']['username'] == 'admin') && $arUser['member'] != 0){ ?>
                                                <a href="/admin/user/edit.php?id=<?php echo $id ?>&page=<?php echo $current_page; ?>" title="Sửa" class="btn btn-primary"><i class="fa fa-edit "></i> Sửa</a>
                                                <?php } ?>
                                                <?php if($username != 'admin'){ ?>
                                                <a href="/admin/user/del.php?id=<?php echo $id ?>&page=<?php echo $current_page; ?>" title="Xóa" onclick="return confirm('Bạn có chắc chắn xóa không?')" class="btn btn-danger"><i class="fa fa-pencil"></i> Xóa</a>
                                                <?php } ?>
                                            <?php }elseif($_SESSION['userInfo']['username'] == $username){ ?>
                                            <a href="/admin/user/edit.php?id=<?php echo $id ?>&page=<?php echo $current_page; ?>" title="Sửa" class="btn btn-primary"><i class="fa fa-edit "></i> Sửa</a>
                                            <?php }elseif($arUser['member'] == 0){ ?>  
                                            <a href="/admin/user/del.php?id=<?php echo $id ?>&page=<?php echo $current_page; ?>" title="Xóa" onclick="return confirm('Bạn có chắc chắn xóa không?')" class="btn btn-danger"><i class="fa fa-pencil"></i> Xóa</a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="dataTables_info" id="dataTables-example_info" style="margin-top:27px">Hiển thị từ 1 đến <?php echo $row_count; ?> của <?php echo $total; ?> người dùng</div>
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
                                            <li class="paginate_button <?php echo $active ?>"><a href="/admin/user/index.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                                            <?php
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