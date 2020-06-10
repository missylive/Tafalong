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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_show_advertising = 10;
$pageNum_show_advertising = 0;
if (isset($_GET['pageNum_show_advertising'])) {
  $pageNum_show_advertising = $_GET['pageNum_show_advertising'];
}
$startRow_show_advertising = $pageNum_show_advertising * $maxRows_show_advertising;

mysql_select_db($database_dbconnect, $dbconnect);
$query_show_advertising = "SELECT `no`, title, website, pic FROM advertising ORDER BY `no` ASC";
$query_limit_show_advertising = sprintf("%s LIMIT %d, %d", $query_show_advertising, $startRow_show_advertising, $maxRows_show_advertising);
$show_advertising = mysql_query($query_limit_show_advertising, $dbconnect) or die(mysql_error());
$row_show_advertising = mysql_fetch_assoc($show_advertising);

if (isset($_GET['totalRows_show_advertising'])) {
  $totalRows_show_advertising = $_GET['totalRows_show_advertising'];
} else {
  $all_show_advertising = mysql_query($query_show_advertising);
  $totalRows_show_advertising = mysql_num_rows($all_show_advertising);
}
$totalPages_show_advertising = ceil($totalRows_show_advertising/$maxRows_show_advertising)-1;

$queryString_show_advertising = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_show_advertising") == false && 
        stristr($param, "totalRows_show_advertising") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_show_advertising = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_show_advertising = sprintf("&totalRows_show_advertising=%d%s", $totalRows_show_advertising, $queryString_show_advertising);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>後台管理 | 廣告</title>
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
function tfm_confirmLink(message) { //v1.0
	if(message == "") message = "Ok to continue?";	
	document.MM_returnValue = confirm(message);
}
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
				<li class="item middle" id="six"><a href="picture.php" class="main"><span class="outer"><span class="inner event_manager">照片編輯</span></span></a></li> 
		<li class="item middle" id="five"><a href="video.php" class="main"><span class="outer"><span class="inner media_library">影片編輯</span></span></a></li>  
              <li class="item middle" id="three"><a href="advertising.php" class="main current"><span class="outer"><span class="inner reports"></span>企業廣告</span></a></li>
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
                      <li><a href="advertising.php" class="current"><span>友站連結</span></a></li>
                      <li><a href="advertisingAdd.php"><span>新增友站連結</span></a></li>
                      <li><a href="company.php"><span>合作企業</span></a></li>
                      <li><a href="companyAdd.php"><span>新增合作企業</span></a></li>
          
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
    <h1 class="content_edit">編輯友站連結資料</h1>
	   <p> 選擇您要修改的資料，編輯修改它。或按以下按鈕進入新增廣告頁面。有任何問題請聯絡系統管理員。 </p>
   	   <p>刪除廣告即無法復原，請確認您的廣告必須刪除，刪除即無法救回資料。</p>
	   <a href="advertisingAdd.php" class="newdata"></a>
    </div>
	<div class="hidden">
        <p class="info" id="success"><span class="info_inner">修改成功！</span></p>
        <p class="info" id="error"><span class="info_inner">系統錯誤，無法修改！請聯絡管理員</span></p>
        <p class="info" id="warning"><span class="info_inner">網路錯誤無法上傳！</span></p>
      </div>
    <!-- CONTENT TITLE RIGHT BOX -->
    <div class="grid_6" id="eventbox"><a href="#" class="inline_tip">此頁面提供編輯及刪除廣告</a></div>
    <div class="clear">
    </div>
<!--    TEXT CONTENT OR ANY OTHER CONTENT START     -->
    <div class="grid_15" id="textcontent">
            <div style="margin:auto; width:900px;">
            <div style="margin:auto; width:900px;">
              
<table width="100%" height="487" border="0" cellpadding="6" cellspacing="1" id="tb01" style="height:450px;">
            <tr style="text-align:left;">
              <th width="10%">編號</th>
              <th width="20%">廣告標題</th>
              <th width="20%">連結</th>
			  <th width="10%">&nbsp;</th>
			  <th width="10%">&nbsp;</th>
            </tr><?php do { ?>


            <tr>
              <td class="even"><?php echo $row_show_advertising['no']; ?></td>
              <td class="even"><?php echo $row_show_advertising['title']; ?></td>
              <td class="even"><?php echo $row_show_advertising['website']; ?></td>                    
              <td class="even"><a class="button" href="advertisingEdit.php?no=<?php echo $row_show_advertising['no']; ?>"><img src="i/icon_settings2s.png" width="16" height="17" border="0" style="vertical-align: middle;"/>編輯</a></td>
              <td class="even">
              <a href="Delete/deleteAdvertising.php?no=<?php echo $row_show_advertising['no']; ?>" title="Delete" class="button_grey" onclick="tfm_confirmLink('確定刪除廣告?');return document.MM_returnValue">刪除<img src="i/icon_trash.png" width="16" height="16" border="0"  style="vertical-align: middle;"/></a></td>
            </tr>
            <?php } while ($row_show_advertising = mysql_fetch_assoc($show_advertising)); ?>
          <tr>
            <td colspan="2" align="right" class="even">&nbsp;<?php echo ($startRow_show_advertising + 1) ?> 到 <?php echo min($startRow_show_advertising + $maxRows_show_advertising, $totalRows_show_advertising) ?> 共 <?php echo $totalRows_show_advertising ?></td>
                  <td colspan="3" align="left" valign="bottom" class="even">
                  <a href="<?php printf("%s?pageNum_show_advertising=%d%s", $currentPage, 0, $queryString_show_advertising); ?>"><img src="images/icons/fast_left.png" /></a>
                  <a href="<?php printf("%s?pageNum_show_advertising=%d%s", $currentPage, max(0, $pageNum_show_advertising - 1), $queryString_show_advertising); ?>"><img src="images/icons/back.png" /></a>
                  <a href="<?php printf("%s?pageNum_show_advertising=%d%s", $currentPage, min($totalPages_show_advertising, $pageNum_show_advertising + 1), $queryString_show_advertising); ?>"><img src="images/icons/next.png" /></a>
                  <a href="<?php printf("%s?pageNum_show_advertising=%d%s", $currentPage, $totalPages_show_advertising, $queryString_show_advertising); ?>"><img src="images/icons/fast_right.png" /></a></td>
          </tr>
			
          </table>
          <table width="100%" >
            <tr>
              <th scope="col">&nbsp;</th>
              <th scope="col">&nbsp;</th>
            </tr>
            <tr>
              
            </tr>
          </table>
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
mysql_free_result($show_advertising);
?>
