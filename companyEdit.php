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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "insert_company")) {
  $updateSQL = sprintf("UPDATE company SET name=%s, type=%s, phone=%s, email=%s, website=%s, address=%s, pic=%s, content=%s, other=%s WHERE `no`=%s",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['type'], "text"),
                       GetSQLValueString($_POST['phone'], "int"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['website'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['pic'], "text"),
                       GetSQLValueString($_POST['content'], "text"),
                       GetSQLValueString($_POST['other'], "text"),
                       GetSQLValueString($_POST['no'], "int"));

  mysql_select_db($database_dbconnect, $dbconnect);
  $Result1 = mysql_query($updateSQL, $dbconnect) or die(mysql_error());

  $updateGoTo = "company.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_ComEdit = "-1";
if (isset($_GET['no'])) {
  $colname_ComEdit = $_GET['no'];
}
mysql_select_db($database_dbconnect, $dbconnect);
$query_ComEdit = sprintf("SELECT * FROM company WHERE `no` = %s", GetSQLValueString($colname_ComEdit, "int"));
$ComEdit = mysql_query($query_ComEdit, $dbconnect) or die(mysql_error());
$row_ComEdit = mysql_fetch_assoc($ComEdit);
$totalRows_ComEdit = mysql_num_rows($ComEdit);
 require_once('Connections/UserVerification.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>後台管理 | 編輯太巴塱社區文章</title>
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
                      <li><a href="advertising.php"><span>友站連結</span></a></li>
                      <li><a href="advertisingAdd.php"><span>新增友站連結</span></a></li>
              <li><a href="company.php"><span>合作企業</span></a></li>
                      <li><a href="companyAdd.php"><span>新增合作企業</span></a></li>
                      <li><a href="companyEdit.php" class="current"><span>修改合作企業資料</span></a></li>
          
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
    <h1 class="content_edit">修改合作企業資料

	</h1>

    <p> 標題限制三十個中文字元。文章內容不限字元。請確認您的資料無誤再上傳。文字部分建議先在別的地方打好再貼到這邊上傳。有任何問題請聯絡系統管理員。 </p>

    </div>
    <!-- CONTENT TITLE RIGHT BOX -->
    <div class="grid_6" id="eventbox"><a href="#" class="inline_tip">此頁面只提供新增企業資料</a></div>
    <div class="clear">
    </div>
	<div class="hidden">
        <p class="info" id="success"><span class="info_inner">修改成功！</span></p>
        <p class="info" id="error"><span class="info_inner">系統錯誤，無法修改！請聯絡管理員</span></p>
        <p class="info" id="warning"><span class="info_inner">網路錯誤無法上傳！</span></p>
      </div> 
<!--    TEXT CONTENT OR ANY OTHER CONTENT START     -->
    <div class="grid_15" id="textcontent">
            <div style="margin:auto; width:900px;">
<form id="insert_company" name="insert_company" action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data">
            	<table width="100%">
                  <tr >
                    <td width="13%">行業類別</td>
                    <td width="34%">
                      <select name="type" title="<?php echo $row_ComEdit['type']; ?>" type="text">
                        <option value="news">公會,協會,機構</option>
                        <option value="restaurant">餐廳,咖啡廳,酒吧</option>
                        <option value="company">公司行號</option>
                        <option value="store">店面</option>
                    </select></td>
                    <td width="8%">&nbsp;</td>
                    <td width="45%"><input name="no" type="text" id="no" value="<?php echo $row_ComEdit['no']; ?>" size="20" /></td>
                  </tr>
				  <tr><td>&nbsp;</td></tr>
				  <tr>
				    <td>企業名稱</td>
					<td colspan="3"><input name="name" type="text" value="<?php echo $row_ComEdit['name']; ?>" size="100%" /></td>
				  </tr>
				  <tr><td>&nbsp;</td></tr>
				  <tr>
				    <td>電話</td>
					<td><input name="phone" type="text" value="<?php echo $row_ComEdit['phone']; ?>" size="40%" /></td>
					<td>電子信箱</td>
					<td><input name="email" type="text" value="<?php echo $row_ComEdit['email']; ?>" size="50%" /></td>
				  </tr>
				  <tr><td>&nbsp;</td></tr>
				  <tr>
				    <td>企業網站</td>
					<td colspan="3"><input name="website" type="text" value="<?php echo $row_ComEdit['website']; ?>" size="100%" /></td>
				  </tr>
				  <tr><td>&nbsp;</td></tr>
				  <tr>
				    <td>地址</td>
					<td colspan="3"><input name="address" type="text" value="<?php echo $row_ComEdit['address']; ?>" size="100%" /></td>
				  </tr>
				  
				  <tr><td>&nbsp;</td></tr>
				  <tr>
				    <td>圖片</td>
					<td colspan="3"><input name="pic" type="file"  id="pic" value="<?php echo $row_ComEdit['pic']; ?>" size="90%" /></td>
				  </tr>
				  
                </table>


        <!--WYSIWYG Editor is linked to the textarea with id: #wysiwyg-->
        <label>企業簡介</label>
        <textarea type="text" name="content" id="wysiwyg" class="smallInput wide" rows="2" cols="30"><?php echo $row_ComEdit['content']; ?></textarea>
        <label>企業備註</label>
        <textarea type="text" name="other" id="wysiwyg" class="smallInput wide" rows="2" cols="30"><?php echo $row_ComEdit['other']; ?></textarea>
        <label>按下儲存即上傳文章，請確認您的文章無誤。</label>

       <!-- BUTTONS -->
        <input type="submit" name="save" class="button" value="儲存"/>
        <input type="hidden" name="MM_insert" value="insert_company" />
        <input type="hidden" name="MM_update" value="insert_company" />

    </form>

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
mysql_free_result($ComEdit);
?>
