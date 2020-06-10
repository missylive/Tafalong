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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE shop_ord_main SET ord_name=%s, ord_email=%s, ord_tel=%s, ord_address=%s, ord_total=%s, ord_status=%s WHERE ord_id=%s",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['ord_total'], "int"),
                       GetSQLValueString($_POST['ord_status'], "text"),
                       GetSQLValueString($_POST['ord_id'], "text"));

  mysql_select_db($database_dbconnect, $dbconnect);
  $Result1 = mysql_query($updateSQL, $dbconnect) or die(mysql_error());

  $updateGoTo = "shop_Ord.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_OrdMainRec = "-1";
if (isset($_GET['ord_id'])) {
  $colname_OrdMainRec = $_GET['ord_id'];
}
mysql_select_db($database_dbconnect, $dbconnect);
$query_OrdMainRec = sprintf("SELECT * FROM shop_ord_main WHERE ord_id = %s", GetSQLValueString($colname_OrdMainRec, "text"));
$OrdMainRec = mysql_query($query_OrdMainRec, $dbconnect) or die(mysql_error());
$row_OrdMainRec = mysql_fetch_assoc($OrdMainRec);
$totalRows_OrdMainRec = mysql_num_rows($OrdMainRec);

$colname_OrdSubRec = "-1";
if (isset($_GET['ord_id'])) {
  $colname_OrdSubRec = $_GET['ord_id'];
}
mysql_select_db($database_dbconnect, $dbconnect);
$query_OrdSubRec = sprintf("SELECT * FROM shop_ord_sub WHERE ord_id = %s", GetSQLValueString($colname_OrdSubRec, "text"));
$OrdSubRec = mysql_query($query_OrdSubRec, $dbconnect) or die(mysql_error());
$row_OrdSubRec = mysql_fetch_assoc($OrdSubRec);
$totalRows_OrdSubRec = mysql_num_rows($OrdSubRec);


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
                      <li><a href="shop_Ord.php"><span>客戶訂單管理</span></a></li>
                      <li><a href="shop_Ord.php" class="current"><span>客戶訂單明細管理</span></a></li>

          
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
    <h1 class="content_edit">客戶訂單明細管理</h1>
    <!-- CONTENT TITLE RIGHT BOX -->
    <div >
      
<p>&nbsp;</p>
    </div>
<!--    TEXT CONTENT OR ANY OTHER CONTENT START     -->
    <div>
      <table width="100%" border="3" cellspacing="2">
       <form id="form2" name="form2" method="POST" action="<?php echo $editFormAction; ?>">
  <tr>
    <td width="11%">訂單編號</td>
    <td width="39%"><input name="ord_id" type="text" value="<?php echo $row_OrdMainRec['ord_id']; ?>"/></td>
    <td width="11%">訂單日期</td>
    <td width="39%"><?php echo $row_OrdMainRec['ord_date']; ?></td>
  </tr>
  <tr>
    <td>訂單總金額</td>
    <td><input name="ord_total" type="text" value="<?php echo $row_OrdMainRec['ord_total']; ?>"/></td>
    <td>訂單狀態</td>
    <td><input name="ord_status" type="text" value="<?php echo $row_OrdMainRec['ord_status']; ?>" /></td>
  </tr>
  <tr>
    <td>訂購者姓名</td>
    <td><input name="name" type="text" value="<?php echo $row_OrdMainRec['ord_name']; ?>" /></td>
    <td>訂購者電話</td>
    <td><input name="phone" type="text" value="<?php echo $row_OrdMainRec['ord_tel']; ?>" /></td>
  </tr>
  <tr>
    <td>訂購者地址</td>
    <td><input name="address" type="text" value="<?php echo $row_OrdMainRec['ord_address']; ?>" /></td>
    <td>訂購者信箱</td>
    <td><input name="Email" type="text" value="<?php echo $row_OrdMainRec['ord_email']; ?>" /></td>
  </tr>
  <tr>
    <td><input name="order_no" type="hidden" id="order_no" value="<?php echo $row_OrdMainRec['ord_id']; ?>" /></td>
    <td>
      <input type="submit" name="update" id="update" value="更新" />
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <input type="hidden" name="MM_update" value="form2" />
       </form>
</table>

    </div>
    <div>
    <table width="100%" border="3" cellspacing="2">
  <tr>
    <td>訂單狀態</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>商品貨號</td>
    <td>商品名稱</td>
    <td>商品數量</td>
    <td>商品售價</td>
    <td>小計</td>
    
  </tr>
  <?php do { ?>
    <tr>
      <td><a><?php echo $row_OrdSubRec['goods_id']; ?></a></td>
      <td><a><?php echo $row_OrdSubRec['goods_name']; ?></a></td>
      <td><?php echo $row_OrdSubRec['ord_num']; ?></td>
      <td><?php echo $row_OrdSubRec['goods_price']; ?></td>
      <td><?php echo $row_OrdSubRec['ord_sum']; ?></td>
    </tr>
    <?php } while ($row_OrdSubRec = mysql_fetch_assoc($OrdSubRec)); ?>
<tr>
  <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;
      </td>
    <td> 共訂購   筆商品</td>
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
mysql_free_result($OrdMainRec);

mysql_free_result($OrdSubRec);
?>
