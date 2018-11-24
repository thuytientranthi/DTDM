<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/util/DBConnectionUtil.php';
	date_default_timezone_set('Asia/Ho_Chi_Minh');
  	$idnews = $_POST['aidnews'];
	$content = $_POST['acontentrep'];
	$useridrep = $_POST['auseridrep'];
	$member = $_POST['amember'];
	$idcmt = $_POST['aidcmtrep'];
	$total = $_POST['atotal'];
	$output = "";
	if($member > 0){
		$active = 1;
	}else{
		$active = 0;
	}
	$sql = "INSERT INTO comment(content, news_id, parent_id, user_id, active) VALUES('{$content}', '{$idnews}', '{$idcmt}', '{$useridrep}', '{$active}')";
	$result = mysql_query($sql);
	$totalcm = $total;
	if($result){
		$totalcm = $totalcm + 1;
	}
?>
<?php
	if($member == 0){
?>
<div class="xetduyetrep"><i class="glyphicon glyphicon-pushpin"></i>&nbsp;&nbsp;<span>Bình luận của bạn đang chờ xét duyệt.</span></div>
<fieldset id="replay_cmt" style="display: none;">
	<legend>Your Replay</legend>
	<form style="display: none;" action="javascript:void(0)">
		<table>
			<tr>
				<td>Content</td>
				<td class="replay"><textarea id="content_replay" class="content_replay" style="width: 470px; height: 24px"></textarea></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="submit" class="submit_replay" value="Replay"></td>
			</tr>
		</table>
	</form> 
</fieldset>
<?php 
	}else{ 
		$sql = "SELECT username, avatar, c.date_create as date_create, content FROM comment AS c inner join users as u on c.user_id = u.id order by c.id desc limit 1";
		$rs = mysql_query($sql);
		$ar = mysql_fetch_assoc($rs);
		$messageRep = nl2br($content);
		if($ar['avatar'] != ""){
			$img = $ar['avatar'];
		}elseif($member == 1){
			$img = "find_user.png";
		}elseif($member == 0){
			$img = "userpic.gif";
		} 
	$output = 
	'	<li>
		<img class="img_rep" src="/files/'.$img.'" width="30" height="30"/>
		<div>
			<b>'.$ar['username'].'</b><small>&nbsp;'.$ar["date_create"].'</small>
			<p class="cmt_replay">'.$messageRep.'</p>
		</div>
	</li>';
	
	$kq = $output."**".$totalcm;
	echo $kq;
	} 
?>