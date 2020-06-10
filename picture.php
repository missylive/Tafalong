<?php require_once('Connections/dbconnect.php'); ?>
<?php require_once('Connections/UserVerification.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$maxRows_show_pic = 15;
$pageNum_show_pic = 0;
if (isset($_GET['pageNum_show_pic'])) {
  $pageNum_show_pic = $_GET['pageNum_show_pic'];
}
$startRow_show_pic = $pageNum_show_pic * $maxRows_show_pic;

mysql_select_db($database_dbconnect, $dbconnect);
$query_show_pic = "SELECT `no`, title, content, pic FROM picture ORDER BY `no` DESC";
$query_limit_show_pic = sprintf("%s LIMIT %d, %d", $query_show_pic, $startRow_show_pic, $maxRows_show_pic);
$show_pic = mysql_query($query_limit_show_pic, $dbconnect) or die(mysql_error());
$row_show_pic = mysql_fetch_assoc($show_pic);

if (isset($_GET['totalRows_show_pic'])) {
  $totalRows_show_pic = $_GET['totalRows_show_pic'];
} else {
  $all_show_pic = mysql_query($query_show_pic);
  $totalRows_show_pic = mysql_num_rows($all_show_pic);
}
$totalPages_show_pic = ceil($totalRows_show_pic/$maxRows_show_pic)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>後台管理 | 照片編輯</title>
<link rel="stylesheet" type="text/css" href="css/960.css" />
<link rel="stylesheet" type="text/css" href="css/reset.css" />
<link rel="stylesheet" type="text/css" href="css/text.css" />
<link rel="stylesheet" type="text/css" href="css/blue.css" />
<link type="text/css" href="css/smoothness/ui.css" rel="stylesheet" />
<link type="text/css" href="js/wysiwyg/jquery.wysiwyg.css" rel="stylesheet" />
    <script type="text/javascript" src="../../ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<script type="text/javascript" src="js/wysiwyg/jquery.wysiwyg.js"></script>
    <script type="text/javascript">
	$(document).ready(function() {
		$('#wysiwyg').wysiwyg();
	});
    </script>    
    <script type="text/javascript" src="js/blend/jquery.blend.js"></script>
	<script type="text/javascript" src="js/ui.core.js"></script>
	<script type="text/javascript" src="js/ui.sortable.js"></script>    
    <script type="text/javascript" src="js/ui.dialog.js"></script>
    <script type="text/javascript" src="js/effects.js"></script>
    <!--[if IE6]>
	<link rel="stylesheet" type="text/css" href="css/iefix.css" />
    <![endif]-->
    <!--[if IE 6]>
	<link rel="stylesheet" type="text/css" href="css/iefix.css" />
	<script src="js/pngfix.js"></script>
    <script>
        DD_belatedPNG.fix('#menu ul li a span span');
    </script>    
    <![endif]-->
</head>

<body>
<!-- WRAPPER START -->
<div class="container_16" id="wrapper">	
<!-- HIDDEN COLOR CHANGER -->
      
    <!--LOGO-->
	<div class="grid_8" id="logo"><img src="images/logo-1.png" width="80" height="75" alt="TafalongLogo" longdesc="dashboard.php" /></a><a href="dashboard.php"><img src="images/TafaLOGO.png" width="293" height="79" alt="TAFALONG" longdesc="dashboard.php" /><br/></div>
    <div class="grid_8">
<!-- USER TOOLS START -->      
      <div id="user_tools"><span><a href="#" class="mail">(1)</a> 歡迎來到後台管理 <a href="#">Admin Username</a>  |  <a class="dropdown" href="#">Change Theme</a>  |  <a href="<?php echo $logoutAction ?>">登出</a></span></div>
    </div>
<div class="grid_16" id="header">
<!-- MENU START -->
<div id="menu">
	<ul class="group" id="menu_group_main">
		<li class="item first" id="one"><a href="dashboard.php" class="main"><span class="outer"><span class="inner dashboard">首頁</span></span></a></li>
				<li class="item middle" id="seven"><a href="news.php" class="main"><span class="outer"><span class="inner newsletter">最新消息</span></span></a></li> 
        <li class="item middle" id="two"><a href="article_area.php" class="main"><span class="outer"><span class="inner content">文案編輯</span></span></a></li>
				<li class="item middle" id="six"><a href="picture.php" class="main current"><span class="outer"><span class="inner event_manager">照片編輯</span></span></a></li> 
		<li class="item middle" id="five"><a href="video.php" class="main"><span class="outer"><span class="inner media_library">影片編輯</span></span></a></li>  
              <li class="item middle" id="three"><a href="advertising.php" class="main"><span class="outer"><span class="inner reports"></span>企業廣告</span></a></li>
        <li class="item middle" id="four"><a href="users.php" class="main"><span class="outer"><span class="inner users">網站管理員</span></span></a></li>
  		<li class="item last" id="eight"><a href="shop.php" class="main"><span class="outer"><span class="inner settings">購物管理</span></span></a></li>    
      </ul>
</div>
<!-- MENU END -->
</div>
<div class="grid_16">
<!-- TABS START -->
    <div id="tabs">
         <div class="container">
            <ul>
                      <li><a href="picture.php" class="current"><span>編輯照片分享</span></a></li>
                      <li><a href="pictureUpload.php"><span>新增照片圖片</span></a></li>

          
           </ul>
        </div>
    </div>
<!-- TABS END -->    
</div>
<!-- HIDDEN SUBMENU START -->

<!-- HIDDEN SUBMENU END -->  

<!-- CONTENT START -->
    <div class="grid_16" id="content">
   <!-- CONTENT TITLE -->
    <div class="grid_9">
    <h1 class="content_edit">編輯照片分享</h1>
	   <p> 選擇您要修改的圖片，編輯它。或按以下按鈕進入新增圖片頁面。有任何問題請聯絡系統管理員。 </p>
   	   <p>刪除圖片即無法復原，請確認您的圖片必須刪除，<strong>刪除即無法救回資料</strong>。</p>
	   <a href="pictureUpload.php" class="newdata"></a>
    </div>
	<div class="hidden">
        <p class="info" id="success"><span class="info_inner">修改成功！</span></p>
        <p class="info" id="error"><span class="info_inner">系統錯誤，無法修改！請聯絡管理員</span></p>
        <p class="info" id="warning"><span class="info_inner">網路錯誤無法上傳！</span></p>
      </div>
    <!-- CONTENT TITLE RIGHT BOX -->
    <div class="grid_6" id="eventbox"><a href="#" class="inline_tip">此頁面提供編輯及刪除圖片資料</a></div>
    <div class="clear">
    </div>
<!--    TEXT CONTENT OR ANY OTHER CONTENT START     -->
    <div class="grid_15" id="textcontent">
            <div style="margin:auto; width:900px;">
            	<table width="100%" border="0" cellspacing="1" cellpadding="6" id="tb01" style="height:500px;">
                  <tr style="text-align:left;">
                    <th width="7%" align="center" style="text-align: left">總編號</th>
                    <th width="25%" align="center" style="text-align: left">圖片標題</th>
                    <th width="25%" align="center" style="text-align: left">簡介</th>
                  </tr>
                  <tr>
                    <?php do { ?>
                    <td class="even"><?php echo $row_show_pic['no']; ?></td>
                    <td class="even"><?php echo $row_show_pic['title']; ?></td>                    
                    <td class="even"><?php echo $row_show_pic['content']; ?></td>
                    <td width="15%" class="even"><a href="Delete/DeletePicture.php?no=<?php echo $row_show_pic['no']; ?>"  title="Delete" class="button_grey" onclick="tfm_confirmLink('確定刪除資料?');return document.MM_returnValue"><img src="i/icon_trash.png" width="16" height="16" border="0"  style="vertical-align: middle;"/>&nbsp;刪除</a></td>
                      <?php } while ($row_show_pic = mysql_fetch_assoc($show_pic)); ?>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td class="even">&nbsp;</td>
                    <td class="even">&nbsp;</td>
                  </tr>  
              </table>
</div>
			 <div style="width:702px; margin:auto; clear:both;">
                <div style=" height:10px;"></div>
                <div style=" float:left; width:80px; margin:auto; text-align:left; margin-top:3px;">共15筆 </div>
                <div style=" float:left; width:400px; text-align:left;">
                <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)"  style="font-size:12px;">
                  <option>第1頁</option>
                </select>
                </div>
                <div style="float:left; width:61px; text-align: right;  margin-top:3px;">
			    <img src="images/icons/icon_arrow_01.png" width="14" height="13" border="0" /><img src="images/icons/icon_arrow_02.png" width="17" height="13" border="0" /><img src="images/icons/icon_arrow_03.png" width="17" height="13" border="0" /><img src="images/icons/icon_arrow_04.png" width="13" height="13" border="0" />
				</div>
   			 </div>



   
    </div>
    <div class="clear"> </div>
<!-- END CONTENT-->    
  </div>
<div class="clear"> </div>

		<!-- This contains the hidden content for inline calls -->

        <!--Second hidden element called from the tip message right of the title-->

</div>
<!-- WRAPPER END -->
<!-- FOOTER START -->
<div class="container_16" id="footer">
	Website Administration by <a href="../index.htm">Missy Chu</a></div>
<!-- FOOTER END -->
</body>
</html>
<?php
mysql_free_result($show_pic);
?>
