<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/header.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/leftbar.php'; ?>
<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="slider">
                <div id="coin-slider">
                  <?php
                    $query = "SELECT * FROM slide ORDER BY id DESC LIMIT 3,5";
                    $result = mysql_query($query);
                    while($row = mysql_fetch_assoc($result)){
                      $link = $row['link'];
                      $picture = $row['picture'];
                  ?> 
                  <a href="<?php echo $link ?>" target="_blank" ><img src="/files/<?php echo $picture ?>" alt="<?php echo $picture ?>" /> </a> 
                  <?php
                    }
                  ?>
                </div>
                <div class="clr"></div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-12">
                <h2>TRANG QUẢN TRỊ VIÊN</h2>
            </div>
        </div>
        <!-- /. ROW  -->
        <hr />
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="panel panel-back noti-box">
                    <span class="icon-box bg-color-green set-icon">
                        <i class="glyphicon glyphicon-tasks"></i>
                    </span>
                    <div class="text-box">
                        <p class="main-text"><a href="/admin/cat/" title="Quản lý danh mục">Quản lý danh mục</a></p>
                        <?php
                        $query = "SELECT * FROM cat_list";
                        $result = mysql_query($query);
                        $row_count = mysql_num_rows($result);
                        ?>
                        <p class="text-muted">Có <?php echo $row_count ?> danh mục</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="panel panel-back noti-box">
                    <span class="icon-box bg-color-blue set-icon">
                        <i class="glyphicon glyphicon-book"></i>
                    </span>
                    <div class="text-box">
                        <p class="main-text"><a href="/admin/news/" title="Quản lý tin tức">Quản lý tin tức</a></p>
                        <?php
                        $query = "SELECT * FROM news";
                        $result = mysql_query($query);
                        $row_count = mysql_num_rows($result);
                        ?>
                        <p class="text-muted">Có <?php echo $row_count ?> tin tức</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="panel panel-back noti-box">
                    <span class="icon-box bg-color-brown set-icon">
                        <i class="glyphicon glyphicon-user"></i>
                    </span>
                    <div class="text-box">
                        <p class="main-text"><a href="/admin/user/" title="Quản lý người dùng">Quản lý người dùng</a></p>
                        <?php
                        $query = "SELECT * FROM users";
                        $result = mysql_query($query);
                        $row_count = mysql_num_rows($result);
                        ?>
                        <p class="text-muted">Có <?php echo $row_count ?> người dùng</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="panel panel-back noti-box">
                    <span class="icon-box bg-color-red set-icon">
                        <i class="fa fa-comments"></i>
                    </span>
                    <div class="text-box">
                        <p class="main-text"><a href="/admin/contact/" title="Quản lý liên hệ">Quản lý liên hệ</a></p>
                        <?php
                        $query = "SELECT * FROM contact";
                        $result = mysql_query($query);
                        $row_count = mysql_num_rows($result);
                        ?>
                        <p class="text-muted">Có <?php echo $row_count ?> liên hệ</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="panel panel-back noti-box">
                    <span class="icon-box bg-color-green set-icon">
                        <i class="fa fa-desktop"></i>
                    </span>
                    <div class="text-box">
                        <p class="main-text"><a href="/admin/slide/" title="Quản lý slide">Quản lý slide</a></p>
                        <?php
                        $query = "SELECT * FROM slide";
                        $result = mysql_query($query);
                        $row_count = mysql_num_rows($result);
                        ?>
                        <p class="text-muted">Có <?php echo $row_count ?> slide</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="panel panel-back noti-box">
                    <span class="icon-box bg-color-blue set-icon">
                        <i class="glyphicon glyphicon-comment"></i>
                    </span>
                    <div class="text-box">
                        <p class="main-text"><a href="/admin/comment/" title="Quản lý comment">Quản lý comment</a></p>
                        <?php
                        $query = "SELECT * FROM comment";
                        $result = mysql_query($query);
                        $row_count = mysql_num_rows($result);
                        ?>
                        <p class="text-muted">Có <?php echo $row_count ?> comment</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- /. PAGE WRAPPER  -->
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/footer.php'; ?>