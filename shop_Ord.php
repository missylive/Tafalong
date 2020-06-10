<?php require_once('Connections/dbconnect.php'); ?>
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

if ((isset($_POST['ord_id'])) && ($_POST['ord_id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM shop_ord_main WHERE ord_id=%s",
                       GetSQLValueString($_POST['ord_id'], "text"));

  mysql_select_db($database_dbconnect, $dbconnect);
  $Result1 = mysql_query($deleteSQL, $dbconnect) or die(mysql_error());
  
     $deleteSQL = sprintf("DELETE FROM shop_ord_sub WHERE ord_id=%s",
               GetSQLValueString($_POST['ord_id'],"text"));
	    MySQL_select_db($database_dbconnect, $dbconnect);
		$Result2 = MySQL_query($deleteSQL,$dbconnect) or die (MySQL_error());

  $deleteGoTo = "shop_Ord.php";
  /*if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  header(sprintf("Location: %s", $deleteGoTo));
}

$maxRows_showOrdRec = 10;
$pageNum_showOrdRec = 0;
if (isset($_GET['pageNum_showOrdRec'])) {
  $pageNum_showOrdRec = $_GET['pageNum_showOrdRec'];
}
$startRow_showOrdRec = $pageNum_showOrdRec * $maxRows_showOrdRec;

mysql_select_db($database_dbconnect, $dbconnect);
$query_showOrdRec = "SELECT * FROM shop_ord_main ORDER BY ord_date DESC";
$query_limit_showOrdRec = sprintf("%s LIMIT %d, %d", $query_showOrdRec, $startRow_showOrdRec, $maxRows_showOrdRec);
$showOrdRec = mysql_query($query_limit_showOrdRec, $dbconnect) or die(mysql_error());
$row_showOrdRec = mysql_fetch_assoc($showOrdRec);

if (isset($_GET['totalRows_showOrdRec'])) {
  $totalRows_showOrdRec = $_GET['totalRows_showOrdRec'];
} else {
  $all_showOrdRec = mysql_query($query_showOrdRec);
  $totalRows_showOrdRec = mysql_num_rows($all_showOrdRec);
}
$totalPages_showOrdRec = ceil($totalRows_showOrdRec/$maxRows_showOrdRec)-1;

$queryString_showOrdRec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_showOrdRec") == false && 
        stristr($param, "totalRows_showOrdRec") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_showOrdRec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_showOrdRec = sprintf("&totalRows_showOrdRec=%d%s", $totalRows_showOrdRec, $queryString_showOrdRec);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>後台管理 | 商店</title>
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
      <div id="user_tools"><span><a href="#" class="mail">(1)</a> 歡迎來到後台管理 <a href="#">Admin Username</a>  |  <a class="dropdown" href="#">Change Theme</a>  |  <a>登出</a></span></div>
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
              <li class="item middle" id="three"><a href="advertising.php" class="main"><span class="outer"><span class="inner reports"></span>企業廣告</span></a></li>
        <li class="item middle" id="four"><a href="users.php" class="main"><span class="outer"><span class="inner users">網站管理員</span></span></a></li>
  		<li class="item last" id="eight"><a href="setting.php" class="main current"><span class="outer"><span class="inner settings">購物管理</span></span></a></li>    
		    </ul>
</div>
<!-- MENU END -->
</div>
<div class="grid_16">
<!-- TABS START -->
    <div id="tabs">
         <div class="container">
            <ul>
                      <li><a href="shop.php"><span>商品分類管理</span></a></li>
                      <li><a href="shop_goods.php"><span>新增商品上架</span></a></li>
                      <li><a href="shop_manage.php"><span>商品上架管理</span></a></li>
                      <li><a href="shop_EditGoods.php"><span>修改商品上架資料</span></a></li>
                      <li><a href="shop_Ord.php" class="current"><span>客戶訂單管理</span></a></li>
                      <li><a href="shop_Ord.php"><span>客戶訂單明細管理</span></a></li>
          
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
    <h1 class="content_edit">客戶訂單管理</h1>
    <!-- CONTENT TITLE RIGHT BOX -->
    <div >
      
<p>&nbsp;</p>
    </div>
<!--    TEXT CONTENT OR ANY OTHER CONTENT START     -->
    <div>
    <table width="100%" border="3" cellspacing="2">
  <tr>
    <td>商品上架管理</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>訂單編號</td>
    <td>訂單金額</td>
    <td>訂單日期</td>
    
    <td>動作</td>
  </tr>
  <?php do { ?>
      <?php if ($totalRows_showOrdRec > 0) { // Show if recordset not empty ?>
        <tr>
          <td><a href="shop_EditOrd.php?ord_id=<?php echo $row_showOrdRec['ord_id']; ?>"><?php echo $row_showOrdRec['ord_id']; ?></a></td>
          <td><a><?php echo $row_showOrdRec['ord_total']; ?></a></td>
          <td><?php echo $row_showOrdRec['ord_date']; ?></td>
          <td><img src="images/garbage.png" width="32" height="32" alt="garbage" />
            <form id="form1" name="form1" method="post" action="">
              <input name="goods_id" type="hidden" id="goods_id" value="<?php echo $row_showOrdRec['ord_id']; ?>" />
            </form></td>
        </tr>
        <?php } // Show if recordset not empty ?>
<?php } while ($row_showOrdRec = mysql_fetch_assoc($showOrdRec)); ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;
      <table border="0">
        <tr>
          <td><?php if ($pageNum_showOrdRec > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_showOrdRec=%d%s", $currentPage, 0, $queryString_showOrdRec); ?>"><img src="First.gif" /></a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_showOrdRec > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_showOrdRec=%d%s", $currentPage, max(0, $pageNum_showOrdRec - 1), $queryString_showOrdRec); ?>"><img src="Previous.gif" /></a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_showOrdRec < $totalPages_showOrdRec) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_showOrdRec=%d%s", $currentPage, min($totalPages_showOrdRec, $pageNum_showOrdRec + 1), $queryString_showOrdRec); ?>"><img src="Next.gif" /></a>
              <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_showOrdRec < $totalPages_showOrdRec) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_showOrdRec=%d%s", $currentPage, $totalPages_showOrdRec, $queryString_showOrdRec); ?>"><img src="Last.gif" /></a>
              <?php } // Show if not last page ?></td>
        </tr>
      </table></td>
    <td>  共  <?php echo $totalRows_showOrdRec ?> 筆訂單</td>
    <td>&nbsp;</td>
</tr>
</table>

    新增商品分類
      

    </div>
    <div > 

    </div>
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
mysql_free_result($showOrdRec);
?>
