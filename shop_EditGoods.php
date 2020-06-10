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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "Editgoods")) {
	move_uploaded_file($_FILES["goods_img"]["tmp_name"],"shop\\" .$_FILES["goods_img"]["name"]);
	
  $updateSQL = sprintf("UPDATE shop_goods SET goods_id=%s, goods_name=%s, goods_price=%s, goods_stand=%s, goods_desc=%s, goods_img=%s, item_id=%s WHERE goods_no=%s",
                       GetSQLValueString($_POST['goods_id'], "text"),
                       GetSQLValueString($_POST['goods_name'], "text"),
                       GetSQLValueString($_POST['goods_price'], "int"),
                       GetSQLValueString($_POST['goods_stand'], "text"),
                       GetSQLValueString($_POST['goods_desc'], "text"),
                       GetSQLValueString($_FILES["goods_img"]["name"], "text"),
                       GetSQLValueString($_POST['item_id'], "int"),
                       GetSQLValueString($_POST['goods_no'], "int"));

  mysql_select_db($database_dbconnect, $dbconnect);
  $Result1 = mysql_query($updateSQL, $dbconnect) or die(mysql_error());

  $updateGoTo = "shop_goods.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$cloume_showgoodsRec = "%";
if (isset($_GET['goods_id'])) {
  $cloume_showgoodsRec = $_GET['goods_id'];
}
mysql_select_db($database_dbconnect, $dbconnect);
$query_showgoodsRec = sprintf("SELECT shop_goods.*, shop_item.item_name FROM shop_goods INNER JOIN shop_item ON shop_item.item_id=shop_goods.item_id WHERE shop_goods.goods_id=%s", GetSQLValueString($cloume_showgoodsRec, "text"));
$showgoodsRec = mysql_query($query_showgoodsRec, $dbconnect) or die(mysql_error());
$row_showgoodsRec = mysql_fetch_assoc($showgoodsRec);
$totalRows_showgoodsRec = mysql_num_rows($showgoodsRec);

mysql_select_db($database_dbconnect, $dbconnect);
$query_itemRec = "SELECT * FROM shop_item";
$itemRec = mysql_query($query_itemRec, $dbconnect) or die(mysql_error());
$row_itemRec = mysql_fetch_assoc($itemRec);
$totalRows_itemRec = mysql_num_rows($itemRec);


/*move_uploaded_file($_FILES["goods_img"]["tmp_name"],"shop\\" .$_FILES["goods_img"]["name"]);*/
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
                      <li><a href="shop_EditGoods.php" class="current"><span>修改商品上架資料</span></a></li>
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
    <h1 class="content_edit">修改商品上架資料</h1>
    <!-- CONTENT TITLE RIGHT BOX -->
    <div >
      
<p>&nbsp;</p>
    </div>
<!--    TEXT CONTENT OR ANY OTHER CONTENT START     -->
    <div>
    新增商品分類
      <form action="<?php echo $editFormAction; ?>" id="Editgoods" name="Editgoods" method="POST" enctype="multipart/form-data">
    <table width="100%" border="3" cellspacing="2">
  <tr>
    <td>商品分類:</td>
    <td>
    <select type="text" name="item_id">
      <option value="area" <?php if (!(strcmp("area", $row_showgoodsRec['item_id']))) {echo "selected=\"selected\"";} ?>>太巴朗社區文章</option>
      <option value="festival" <?php if (!(strcmp("festival", $row_showgoodsRec['item_id']))) {echo "selected=\"selected\"";} ?>>節慶類文章</option>
      <option value="event" <?php if (!(strcmp("event", $row_showgoodsRec['item_id']))) {echo "selected=\"selected\"";} ?>>活動類文章</option>
      <?php
do {  
?>
      <option value="<?php echo $row_itemRec['item_id']?>"<?php if (!(strcmp($row_itemRec['item_id'], $row_showgoodsRec['item_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_itemRec['item_name']?></option>
      <?php
} while ($row_itemRec = mysql_fetch_assoc($itemRec));
  $rows = mysql_num_rows($itemRec);
  if($rows > 0) {
      mysql_data_seek($itemRec, 0);
	  $row_itemRec = mysql_fetch_assoc($itemRec);
  }
?>
    </select>
    </td>
    <td>商品貨號:</td>
    <td><input name="goods_id" type="text" id="goods_id" value="<?php echo $row_showgoodsRec['goods_id']; ?>" /></td>
  </tr>
  <tr>
    <td>商品名稱:</td>
    <td><input name="goods_name" type="text" value="<?php echo $row_showgoodsRec['goods_name']; ?>" /></td>
    <td>商品售價:</td>
    <td><input name="goods_price" type="text" value="<?php echo $row_showgoodsRec['goods_price']; ?>" /></td>
  </tr>
  <tr>
    <td>商品圖片:</td>
    <td><input name="goods_img" type="file"  id="goods_img" value="<?php echo $row_showgoodsRec['goods_img']; ?>"/></td>
    <td>商品規格:</td>
    <td><input name="goods_stand" type="text" value="<?php echo $row_showgoodsRec['goods_stand']; ?>" /></td>
  </tr>
  <tr>
    <td>商品說明:</td>
    <td colspan="3"><textarea name="goods_desc" cols="100" rows="5" wrap="physical"><?php echo $row_showgoodsRec['goods_desc']; ?></textarea></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input name="submit" type="submit" id="submit" value="新增" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

</table>
    <input name="goods_no" type="hidden" id="goods_no" value="<?php echo $row_showgoodsRec['goods_no']; ?>" />
    <input type="hidden" name="MM_update" value="Editgoods" />
      </form>

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
mysql_free_result($showgoodsRec);

mysql_free_result($itemRec);
?>
