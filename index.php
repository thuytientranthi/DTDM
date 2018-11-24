<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/share/inc/header.php'; ?>
  <section id="sliderSection">
    <?php
      if(isset($_GET['msg'])){
    ?>
    <p style="color: red; text-align: center;"><?php echo urldecode($_GET['msg']); ?></p>
    <?php
      }
    ?>
    <div class="row">
      <div class="col-lg-8 col-md-8 col-sm-8">
        <div class="slick_slider">
          <?php
          $sql = "SELECT n.id as id, n.name as nameNews, c.name as nameCat, date_create, username, preview, picture FROM news as n inner join cat_list as c on n.cat_id = c.id inner join users as u on n.created_by = u.id where n.active = 1 ORDER BY n.counter DESC LIMIT 4";
          $rs = mysql_query($sql);
          while($row = mysql_fetch_assoc($rs)){
            $url = '/detail.php?id='.$row['id'];
          ?>
          <div class="single_iteam"> <a href="<?php echo $url; ?>" title="<?php echo $row['nameNews']; ?>"><?php if($row['picture'] != ""){ ?><img src="/files/<?php echo $row['picture']; ?>" alt="" /><?php } ?></a>
            <div class="slider_article">
              <h2>
                <a class="slider_tittle" href="<?php echo $url; ?>" title="<?php echo $row['nameNews']; ?>"><?php echo $row['nameNews']; ?><br /><span class="inf"><strong style="color:red;"><?php echo $row['nameCat']; ?></strong><label>&nbsp;|&nbsp;</label>By <strong style="color:green;"><?php echo $row['username']; ?></strong><label>&nbsp;|&nbsp;</label><i><?php echo date("d/m/Y", strtotime($row['date_create'])) ?></i></span></a>
              </h2>
              <p><?php echo $row['preview']; ?></p>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4">
        <div class="latest_post">
          <h2><span>TIN MỚI</span></h2>
          <div class="latest_post_container">
            <div id="prev-button"><i class="fa fa-chevron-up"></i></div>
            <ul class="latest_postnav">
            <?php
              $sql = "SELECT n.id as id, n.name as nameNews, c.name as nameCat, date_create, username, preview, picture, counter FROM news as n inner join cat_list as c on n.cat_id = c.id inner join users as u on n.created_by = u.id where n.active = 1 ORDER BY id DESC LIMIT 5";
              $rs = mysql_query($sql);
              while($arNews = mysql_fetch_assoc($rs)){
                $urldet = '/detail.php?id='.$arNews['id'];
            ?>
              <li>
                <div class="media"> <a href="<?php echo $urldet; ?>" class="media-left" title="<?php echo $arNews['nameNews']; ?>"><?php if($arNews['picture'] != ""){ ?><img alt="" src="/files/<?php echo $arNews['picture']; ?>" /><?php } ?></a>
                  <div class="media-body">
                    <div class="hid"><a href="<?php echo $urldet; ?>" class="catg_title" title="<?php echo $arNews['nameNews']; ?>"><?php echo $arNews['nameNews']; ?></a></div>
                    <span class="inf"><i class="fa fa-tags"></i>&nbsp;<strong style="color:red;"><?php echo $arNews['nameCat']; ?></strong>&nbsp;&nbsp;<i class="fa fa-user"></i>&nbsp;<strong style="color:green;"><?php echo $arNews['username']; ?></strong>&nbsp;&nbsp;<i class="fa fa-clock-o"></i>&nbsp;<strong style="color:#d083cf;"><?php echo date("d/m/Y", strtotime($arNews['date_create'])) ?></strong></i></span>
                  </div>
                </div>
              </li>
            <?php } ?>
            </ul>
            <div id="next-button"><i class="fa  fa-chevron-down"></i></div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section id="contentSection">
    <div class="row">
      <div class="col-lg-8 col-md-8 col-sm-8">
        <div class="left_content">
          <?php
            $sql = "SELECT cat_list.id as id, cat_list.name as nameCat, count(cat_id) as total from news inner join cat_list on news.cat_id = cat_list.id where news.active = 1 group by news.cat_id order by total desc limit 1";
            $rs = mysql_query($sql);
            $arCat = mysql_fetch_assoc($rs);
            $idCat = $arCat['id'];
            $ur = "/cat.php?id=".$idCat;
          ?>
          <div class="single_post_content">
            <h2><span><?php echo $arCat['nameCat']; ?></span></h2>
            <div class="single_post_content_left">
              <ul class="business_catgnav  wow fadeInDown">
                <li>
                  <?php
                    $sql = "SELECT n.id as id, name, picture, date_create, counter, preview, username from news as n inner join users as u on n.created_by = u.id where n.cat_id = {$idCat} and n.active = 1 order by n.counter desc limit 1";
                    $rs = mysql_query($sql);
                    $ar = mysql_fetch_assoc($rs);
                    $urlDetail = '/detail.php?id='.$ar['id'];
                  ?>
                  <figure class="bsbig_fig"> <a title="<?php echo $ar['name']; ?>" href="<?php echo $urlDetail; ?>" class="featured_img"><?php if($ar['picture'] != ""){ ?><img alt="" src="/files/<?php echo $ar['picture']; ?>" /><?php } ?><span class="overlay"></span> </a>
                    <figcaption> <a title="<?php echo $ar['name']; ?>" href="<?php echo $urlDetail; ?>"><?php echo $ar['name']; ?></a> </figcaption>
                    <span class="inf"><i class="fa fa-user"></i>&nbsp;<strong style="color:green;"><?php echo $ar['username']; ?></strong>&nbsp;&nbsp;<i class="fa fa-clock-o"></i>&nbsp;<strong style="color:#d083cf;"><?php echo date("d/m/Y", strtotime($ar['date_create'])) ?></strong></i></span>
                    <p><?php echo $ar['preview']; ?></p>
                  </figure>
                </li>
              </ul>
            </div>
            <div class="single_post_content_right">
              <ul class="spost_nav">
              <?php
                $sql = "SELECT n.id as id, name, picture, date_create, counter, username from news as n inner join users as u on n.created_by = u.id where n.cat_id = {$idCat} AND n.id !={$ar['id']} and n.active = 1 order by n.id desc limit 4";
                $rs = mysql_query($sql);
                while($arNews = mysql_fetch_assoc($rs)){
                  $url = '/detail.php?id='.$arNews['id'];
              ?>
                <li>
                  <div class="media wow fadeInDown"> <a title="<?php echo $arNews['name']; ?>" href="<?php echo $url; ?>" class="media-left"><?php if($arNews['picture'] != ""){ ?><img alt="" src="/files/<?php echo $arNews['picture']; ?>" /><?php } ?></a>
                    <div class="media-body"> <a title="<?php echo $arNews['name']; ?>" href="<?php echo $url; ?>" class="catg_title"><?php echo $arNews['name']; ?></a><br /><span class="inf"><i class="fa fa-user"></i>&nbsp;<strong style="color:green;"><?php echo $arNews['username']; ?></strong>&nbsp;&nbsp;<i class="fa fa-clock-o"></i>&nbsp;<strong style="color:#d083cf;"><?php echo date("d/m/Y", strtotime($arNews['date_create'])) ?></strong></i></span></div>
                  </div>
                </li>
              <?php } ?>
              </ul>
            </div>
            <a class="more" href="<?php echo $ur; ?>" title="Xem thêm">MORE&raquo;</a>
          </div>
          <div class="fashion_technology_area">
            <div class="fashion">
              <?php
                $sql = "SELECT cat_list.id as id, cat_list.name as nameCat, count(cat_id) as total from news inner join cat_list on news.cat_id = cat_list.id where cat_list.id != {$idCat} and news.active = 1 group by news.cat_id order by total desc limit 1";
                $rs = mysql_query($sql);
                $arCat1 = mysql_fetch_assoc($rs);
                $idCat1 = $arCat1['id'];
                $ur1 = '/cat.php?id='.$idCat1;
              ?>
              <div class="single_post_content">
                <h2><span><?php echo $arCat1['nameCat']; ?></span></h2>
                <ul class="business_catgnav wow fadeInDown">
                  <li>
                  <?php
                    $sql = "SELECT n.id as id, name, picture, date_create, counter, preview, username from news as n inner join users as u on n.created_by = u.id where n.cat_id = {$idCat1} and n.active = 1 order by n.counter desc limit 1";
                    $rs = mysql_query($sql);
                    $ar1 = mysql_fetch_assoc($rs);
                    $urlDetail1 = '/detail.php?id='.$ar1['id'];
                  ?>
                    <figure class="bsbig_fig"> <a title="<?php echo $ar1['name']; ?>" href="<?php echo $urlDetail1; ?>" class="featured_img"><?php if($ar1['picture'] != ""){ ?><img alt="" src="/files/<?php echo $ar1['picture']; ?>" /><?php } ?><span class="overlay"></span> </a>
                      <figcaption> <div class="hid1"><a title="<?php echo $ar1['name']; ?>" href="<?php echo $urlDetail1; ?>"><?php echo $ar1['name']; ?></a> </div></figcaption>
                      <span class="inf"><i class="fa fa-user"></i>&nbsp;<strong style="color:green;"><?php echo $ar1['username']; ?></strong>&nbsp;&nbsp;<i class="fa fa-clock-o"></i>&nbsp;<strong style="color:#d083cf;"><?php echo date("d/m/Y", strtotime($ar1['date_create'])) ?></strong></i></span>
                      <p><?php echo $ar1['preview']; ?></p>
                    </figure>
                  </li>
                </ul>
                <ul class="spost_nav">
                <?php
                  $sql = "SELECT n.id as id, name, picture, date_create, counter, username from news as n inner join users as u on n.created_by = u.id where n.cat_id = {$idCat1} AND n.id != {$ar1['id']} and n.active = 1 order by n.id desc limit 4";
                  $rs = mysql_query($sql);
                  while($arNews1 = mysql_fetch_assoc($rs)){
                    $url1 = '/detail.php?id='.$arNews1['id'];
                ?>
                  <li>
                    <div class="media wow fadeInDown"> <a title="<?php echo $arNews1['name']; ?>" href="<?php echo $url1; ?>" class="media-left"><?php if($arNews1['picture'] != ""){ ?><img alt="" src="/files/<?php echo $arNews1['picture']; ?>"><?php } ?></a>
                      <div class="media-body">
                        <a title="<?php echo $arNews1['name']; ?>" href="<?php echo $url1; ?>" class="catg_title"><?php echo $arNews1['name']; ?></a><br /><span class="inf"><i class="fa fa-user"></i>&nbsp;<strong style="color:green;"><?php echo $arNews1['username']; ?></strong>&nbsp;&nbsp;<i class="fa fa-clock-o"></i>&nbsp;<strong style="color:#d083cf;"><?php echo date("d/m/Y", strtotime($arNews1['date_create'])) ?></strong></i></span>
                      </div>
                    </div>
                  </li>
                <?php } ?>
                </ul>
              </div>
              <a class="more1" href="<?php echo $ur1; ?>" title="Xem thêm">MORE&raquo;</a>
            </div>
            <div class="technology">
              <?php
                $sql = "SELECT cat_list.id as id, cat_list.name as nameCat, count(cat_id) as total from news inner join cat_list on news.cat_id = cat_list.id where cat_list.id NOT IN($idCat, $idCat1) and news.active = 1 group by news.cat_id order by total desc limit 1";
                $rs = mysql_query($sql);
                $arCat2 = mysql_fetch_assoc($rs);
                $idCat2 = $arCat2['id'];
                $ur2 = '/cat.php?id='.$idCat2;
              ?>
              <div class="single_post_content">
                <h2><span><?php echo $arCat2['nameCat']; ?></span></h2>
                <ul class="business_catgnav">
                  <li>
                  <?php
                    $sql = "SELECT n.id as id, name, picture, date_create, counter, preview, username from news as n inner join users as u on n.created_by = u.id where n.cat_id = {$idCat2} and n.active = 1 order by n.counter desc limit 1";
                    $rs = mysql_query($sql);
                    $ar2 = mysql_fetch_assoc($rs);
                    $urlDetail2 = '/detail.php?id='.$ar2['id'];
                  ?>
                    <figure class="bsbig_fig wow fadeInDown"> <a title="<?php echo $ar2['name']; ?>" href="<?php echo $urlDetail2; ?>" class="featured_img"><?php if($ar2['picture'] != ""){ ?><img alt="" src="/files/<?php echo $ar2['picture']; ?>" /><?php } ?><span class="overlay"></span> </a>
                      <figcaption> <div class="hid1"><a title="<?php echo $ar2['name']; ?>" href="<?php echo $urlDetail2; ?>"><?php echo $ar2['name']; ?></a></div> </figcaption>
                      <span class="inf"><i class="fa fa-user"></i>&nbsp;<strong style="color:green;"><?php echo $ar2['username']; ?></strong>&nbsp;&nbsp;<i class="fa fa-clock-o"></i>&nbsp;<strong style="color:#d083cf;"><?php echo date("d/m/Y", strtotime($ar2['date_create'])) ?></strong></i></span>
                      <p><?php echo $ar2['preview']; ?></p>
                    </figure>
                  </li>
                </ul>
                <ul class="spost_nav">
                <?php
                  $sql = "SELECT n.id as id, name, picture, date_create, counter, username from news as n inner join users as u on n.created_by = u.id where n.cat_id = {$idCat2} and n.id !={$ar2['id']} and n.active = 1 order by n.id desc limit 4";
                  $rs = mysql_query($sql);
                  while($arNews2 = mysql_fetch_assoc($rs)){
                    $url2 = '/detail.php?id='.$arNews2['id'];
                ?> 
                  <li>
                    <div class="media wow fadeInDown"> <a title="<?php echo $arNews2['name']; ?>" href="<?php echo $url2; ?>" class="media-left"><?php if($arNews2['picture'] != ""){ ?><img alt="" src="/files/<?php echo $arNews2['picture']; ?>" /><?php } ?></a>
                      <div class="media-body"> <a title="<?php echo $arNews2['name']; ?>" href="<?php echo $url2; ?>" class="catg_title"><?php echo $arNews2['name']; ?></a><br /><span class="inf"><i class="fa fa-user"></i>&nbsp;<strong style="color:green;"><?php echo $arNews2['username']; ?></strong>&nbsp;&nbsp;<i class="fa fa-clock-o"></i>&nbsp;<strong style="color:#d083cf;"><?php echo date("d/m/Y", strtotime($arNews2['date_create'])) ?></strong></i></span></div>
                    </div>
                  </li>
                <?php } ?>
                </ul>
              </div>
              <a class="more1" href="<?php echo $ur2; ?>" title="Xem thêm">MORE&raquo;</a><br />
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4">
        <aside class="right_content">
          <?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/share/inc/leftbar.php'; ?>
        </aside>
      </div>
    </div>
  </section>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/share/inc/footer.php'; ?>