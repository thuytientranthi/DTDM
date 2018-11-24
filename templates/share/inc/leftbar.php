<div class="single_sidebar">
  <h2><span>XEM NHIỀU</span></h2>
  <ul class="spost_nav">
  <?php
    $sql = "SELECT n.id as id, n.name as nameNews, c.name as nameCat, date_create, username, preview, picture, counter FROM news as n inner join cat_list as c on n.cat_id = c.id inner join users as u on n.created_by = u.id where n.active = 1 ORDER BY counter DESC LIMIT 5";
    $rs = mysql_query($sql);
    while($ar = mysql_fetch_assoc($rs)){
      $urldeta = '/detail.php?id='.$ar['id'];
      $sql1 = "SELECT COUNT(*) as total FROM comment where news_id = {$ar['id']} and active = 1";
      $rs1 = mysql_query($sql1);
      $arCm = mysql_fetch_assoc($rs1);
      $totalCm = $arCm['total'];
  ?>
    <li>
      <div class="media wow fadeInDown"><a title="<?php echo $ar['nameNews']; ?>" href="<?php echo $urldeta; ?>" class="media-left"><img alt="" src="/files/<?php echo $ar['picture']; ?>"></a>
        <div class="hid">
          <a title="<?php echo $ar['nameNews']; ?>" href="<?php echo $urldeta; ?>" class="catg_title"><?php echo $ar['nameNews']; ?></a>
        </div>
        <span class="inf"><i class="fa fa-tags"></i>&nbsp;<strong style="color:red;"><?php echo $ar['nameCat']; ?></strong>&nbsp;&nbsp;<i class="fa fa-user"></i>&nbsp;<strong style="color:green;"><?php echo $ar['username']; ?></strong>&nbsp;&nbsp;<i class="glyphicon glyphicon-eye-open"></i>&nbsp;<strong style="color:#d083cf;"><?php echo $ar['counter']; ?></strong></i>&nbsp;&nbsp;<?php if($totalCm > 0){?><i class="glyphicon glyphicon-comment"></i>&nbsp;<strong style="color:#111;"><?php echo $totalCm; ?></strong></i><?php } ?></span>
      </div>
    </li>
  <?php } ?>
  </ul>
</div>
<div class="single_sidebar">
  <h2 role="presentation">THỐNG KÊ</h2>
  <div class="tab-content">
    <?php
      $time_now = time();
      $ip_address = $_SERVER['REMOTE_ADDR'];
      if (!mysql_num_rows(mysql_query("SELECT ip_address FROM counter WHERE UNIX_TIMESTAMP(last_visit) > $time_now AND ip_address = '{$ip_address}'")))
          mysql_query("INSERT INTO counter(ip_address) VALUES ('$ip_address')");
      $day = mysql_num_rows(mysql_query("SELECT ip_address FROM counter WHERE DAYOFYEAR(last_visit) = " . (date('z') + 1) . " AND YEAR(last_visit) = " . date('Y')));
      $yesterday = mysql_num_rows(mysql_query("SELECT ip_address FROM counter WHERE DAYOFYEAR(last_visit) = " . (date('z') + 0) . " AND YEAR(last_visit) = " . date('Y')));
      $week = mysql_num_rows(mysql_query("SELECT ip_address FROM counter WHERE WEEKOFYEAR(last_visit) = " . date('W') . " AND YEAR(last_visit) = " . date('Y')));
      $lastweek = mysql_num_rows(mysql_query("SELECT ip_address FROM counter WHERE WEEKOFYEAR(last_visit) = " . (date('W') - 1). " AND YEAR(last_visit) = " . date('Y')));
      $month = mysql_num_rows(mysql_query("SELECT ip_address FROM counter WHERE MONTH(last_visit) = " . date('n') . " AND YEAR(last_visit) = " . date('Y')));
      $year = mysql_num_rows(mysql_query("SELECT ip_address FROM counter WHERE YEAR(last_visit) = " . date('Y')));
      $visit = mysql_num_rows(mysql_query("SELECT ip_address FROM counter"));
    ?>
    <div role="tabpanel" class="tab-pane active" id="category">
      <p>Hôm nay:<span class="homnay"><?php echo $day; ?></span></p>
      <p>Hôm qua:<span class="homqua"><?php echo $yesterday; ?></span></p>
      <p>Tuần này:<span class="tuannay"><?php echo $week; ?></span></p>
      <p>Tuần trước:<span class="tuantruoc"><?php echo $lastweek; ?></span></p>
      <p>Tháng này:<span class="thangnay"><?php echo $month; ?></span></p>
      <p>Năm này:<span class="thangtruoc"><?php echo $year; ?></span></p>
      <p>Lượt truy cập:<span class="luottruycap"><?php echo $visit; ?></span></p>
    </div>
  </div>
   <?php 
      $date = getdate();
    ?>
    <time datetime=<?php echo date('d/m/Y'); ?> class="icon">
      <em>Tháng: <?php echo $date['mon']; ?></em>
      <strong><?php echo $date['weekday']; ?></strong>
      <span><?php echo $date['mday']; ?></span>
    </time>
</div>

