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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO shop_item (item_name) VALUES (%s)",
                       GetSQLValueString($_POST['type'], "text"));

  mysql_select_db($database_dbconnect, $dbconnect);
  $Result1 = mysql_query($insertSQL, $dbconnect) or die(mysql_error());

  $insertGoTo = "shop.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE shop_item SET item_name=%s WHERE item_id=%s",
                       GetSQLValueString($_POST['textfield2'], "text"),
                       GetSQLValueString($_POST['reflash'], "int"));

  mysql_select_db($database_dbconnect, $dbconnect);
  $Result1 = mysql_query($updateSQL, $dbconnect) or die(mysql_error());

  $updateGoTo = "shop.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_GET['item_id'])) && ($_GET['item_id'] != "") && (isset($_GET['del']))) {
  $deleteSQL = sprintf("DELETE FROM shop_item WHERE item_id=%s",
                       GetSQLValueString($_GET['item_id'], "int"));

  mysql_select_db($database_dbconnect, $dbconnect);
  $Result1 = mysql_query($deleteSQL, $dbconnect) or die(mysql_error());

  $deleteGoTo = "shop.php";
  /*
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  */
  header(sprintf("Location: %s", $deleteGoTo));
}

mysql_select_db($database_dbconnect, $dbconnect);
$query_showitemRec = "SELECT shop_item.item_id, shop_item.item_name,count(shop_goods.item_id) as num FROM shop_item LEFT OUTER JOIN shop_goods ON shop_item.item_id=shop_goods.item_id GROUP BY shop_item.item_id";
$showitemRec = mysql_query($query_showitemRec, $dbconnect) or die(mysql_error());
$row_showitemRec = mysql_fetch_assoc($showitemRec);
$totalRows_showitemRec = mysql_num_rows($showitemRec);
 require_once('Connections/UserVerification.php'); ?>
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
                      <li><a href="shop.php" class="current"><span>商品分類管理</span></a></li>
                      <li><a href="shop_goods.php"><span>新增商品上架</span></a></li>
                      <li><a href="shop_manage.php"><span>商品上架管理</span></a></li>
                      <li><a href="shop_EditGoods.php"><span>修改商品上架資料</span></a></li>
                      <li><a href="shop_Ord.php"><span>客戶訂單管理</span></a></li>
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
    <h1 class="content_edit">商品分類管理</h1>
    <!-- CONTENT TITLE RIGHT BOX -->
    <div >
      
<p>&nbsp;</p>
    </div>
<!--    TEXT CONTENT OR ANY OTHER CONTENT START     -->
    <div>
    新增商品分類
      <form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>"><table width="676" border="5" cellspacing="2">
        <tr>
          <td width="108">新增類別 : </td>
          <td width="181">
            <input type="text" name="type" id="type" />
          </td>
          <td width="357"><input type="button" name="textfield" id="textfield" /></td>
        </tr>
      </table>
        <input type="hidden" name="MM_insert" value="form1" />
      </form>
    </div>
    <div > 
      <?php do { ?>
        <table width="100%" border="3" cellspacing="2">
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td>分類名稱</td>
            <td>現有商品數</td>
            <td>動作</td>
          </tr>
          <tr><form id="form2" name="form2" method="POST" action="<?php echo $editFormAction; ?>">
            <td>
              <input name="textfield2" type="text" id="textfield2" value="<?php echo $row_showitemRec['item_name']; ?>" />
              </td>
            <td><label><?php echo $row_showitemRec['num']; ?></label></td>
            <td><input type="button" name="reflash" value="更新" />
              <?php if ($row_showitemRec['num']<=0) {?><a href="shop.php?del=true& item_id=<?php echo $row_showitemRec['item_id']; ?>"><img src="images/icon_info.gif" alt="刪除類別" width="60" height="30" border="0"/></a>  <?php }?>    
              </td>
            <input type="hidden" name="MM_update" value="form2" />
          </form></tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3">共<?php echo $totalRows_showitemRec ?> 種分類</td>
          </tr>
  </table>
        <?php } while ($row_showitemRec = mysql_fetch_assoc($showitemRec)); ?>

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
mysql_free_result($showitemRec);
?>
