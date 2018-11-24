<nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">
            <li class="text-center">
                <img src="/templates/admin/assets/img/find_user.png" class="user-image img-responsive" />
            </li>
            <?php
                $active = $_SERVER['PHP_SELF'];
                $string = explode("/", $active);
                $current = $string[2];
            ?>
            <li>
                <a class="<?php if($current == '' || $current == 'index.php'){ echo 'active-menu'; }else{ echo 'noactive'; } ?>" href="/admin/" title="Trang chủ"><i class="glyphicon glyphicon-home "></i> Trang chủ</a>
            </li>
            <li>
                <a class="<?php if($current == 'cat'){ echo 'active-menu'; }else{ echo 'noactive'; } ?>" href="/admin/cat/" title="Quản lý danh mục"><i class="glyphicon glyphicon-tasks "></i> Quản lý danh mục</a>
            </li>
            <li>
                <a class="<?php if($current == 'news'){ echo 'active-menu'; }else{ echo 'noactive'; } ?>" href="/admin/news/" title="Quản lý tin tức"><i class="glyphicon glyphicon-book "></i> Quản lý tin tức
                <?php
                    $sql = "SELECT count(*) as totalNews from news where active = 0";
                    $rs = mysql_query($sql);
                    $arNews = mysql_fetch_assoc($rs);
                    $totalNews = $arNews['totalNews'];
                    if($totalNews == 0){
                        $a = "none";
                    }else{
                        $a = "";
                    }
                ?>
                <span title="Có bài viết đang chờ kiểm duyệt" style="display: <?php echo $a; ?>; color: #fff;" class="badge newsdeactive" id="resultdeactive"><?php echo $totalNews; ?></span>
                </a>
            </li>
            <li>
                <a class="<?php if($current == 'user'){ echo 'active-menu'; }else{ echo 'noactive'; } ?>" href="/admin/user/" title="Quản lý người dùng"><i class="glyphicon glyphicon-user "></i> Quản lý người dùng
                <?php
                    $sql1 = "SELECT count(*) as totalUser from users where active = 0";
                    $rs1 = mysql_query($sql1);
                    $arUser = mysql_fetch_assoc($rs1);
                    $totalUser = $arUser['totalUser'];
                    if($totalUser == 0){
                        $a = "none";
                    }else{
                        $a = "";
                    }
                ?>
                <span title="Có user đang chờ kiểm duyệt" style="display: <?php echo $a; ?>; color: #fff;" class="badge newsdeactive" id="resultuser"><?php echo $totalUser; ?></span>
                </a>
            </li>
            <li>
                <a class="<?php if($current == 'contact'){ echo 'active-menu'; }else{ echo 'noactive'; } ?>" href="/admin/contact/" title="Quản lý liên hệ"><i class="fa fa-comments "></i> Quản lý liên hệ
                <?php
                    $sql2 = "SELECT count(*) as totalContact from contact where active = 0";
                    $rs2 = mysql_query($sql2);
                    $arContact = mysql_fetch_assoc($rs2);
                    $totalContact = $arContact['totalContact'];
                    if($totalContact == 0){
                        $a = "none";
                    }else{
                        $a = "";
                    }
                ?>
                <span title="Có liên hệ chờ được phản hồi" style="display: <?php echo $a; ?>; color: #fff;" class="badge newsdeactive" id="resultuser"><?php echo $totalContact; ?></span>
                </a>
            </li>
            <li>
                <a class="<?php if($current == 'slide'){ echo 'active-menu'; }else{ echo 'noactive'; } ?>" href="/admin/slide/" title="Quản lý slide"><i class="fa fa-desktop "></i> Quản lý slide</a>
            </li>
            <li>
                <a class="<?php if($current == 'comment'){ echo 'active-menu'; }else{ echo 'noactive'; } ?>" href="/admin/comment/" title="Quản lý comment"><i class="glyphicon glyphicon-comment "></i> Quản lý comment
                <?php
                    $sql = "SELECT count(*) as totalComment from comment where active = 0";
                    $rs = mysql_query($sql);
                    $arComment = mysql_fetch_assoc($rs);
                    $totalComment = $arComment['totalComment'];
                    if($totalComment == 0){
                        $a = "none";
                    }else{
                        $a = "";
                    }
                ?>
                <span title="Có bình luận đang chờ kiểm duyệt" style="display: <?php echo $a; ?>; color: #fff;" class="badge newsdeactive" id="resultcomment"><?php echo $totalComment; ?></span>
                </a>
            </li>
        </ul>

    </div>

</nav>
<!-- /. NAV SIDE  -->