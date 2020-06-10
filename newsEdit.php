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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE news SET type=%s, title=%s, content=%s, pic=%s, startdate=%s, endate=%s, place=%s, `update`=%s WHERE `no`=%s",
                       GetSQLValueString($_POST['type'], "text"),
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['content'], "text"),
                       GetSQLValueString($_POST['pic'], "text"),
                       GetSQLValueString($_POST['startdate'], "date"),
                       GetSQLValueString($_POST['endate'], "date"),
                       GetSQLValueString($_POST['place'], "text"),
                       GetSQLValueString($_POST['update'], "date"),
                       GetSQLValueString($_POST['no'], "int"));

  mysql_select_db($database_dbconnect, $dbconnect);
  $Result1 = mysql_query($updateSQL, $dbconnect) or die(mysql_error());
}

mysql_select_db($database_dbconnect, $dbconnect);
$query_EditNews = "SELECT * FROM news";
$EditNews = mysql_query($query_EditNews, $dbconnect) or die(mysql_error());
$row_EditNews = mysql_fetch_assoc($EditNews);
$totalRows_EditNews = mysql_num_rows($EditNews);$colname_EditNews = "-1";
if (isset($_GET['no'])) {
  $colname_EditNews = $_GET['no'];
}
mysql_select_db($database_dbconnect, $dbconnect);
$query_EditNews = sprintf("SELECT * FROM news WHERE `no` = %s", GetSQLValueString($colname_EditNews, "int"));
$EditNews = mysql_query($query_EditNews, $dbconnect) or die(mysql_error());
$row_EditNews = mysql_fetch_assoc($EditNews);
$totalRows_EditNews = mysql_num_rows($EditNews);
?>
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
	<script type="text/javascript" src="js/wysiwyg/jquery.wysiwyg.js"></script>
	<script type="text/javascript" src="js/jquery.ui.core.js"></script>
	<script type="text/javascript" src="js/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="js/jquery.ui.mouse.js"></script>
	<script type="text/javascript" src="js/ajaxfileupload.js"></script> 
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css" /> 

    <script type="text/javascript">
	$(function() {
      $( "#datepicker" ).datepicker();
    });
	$(function() {
      $( "#datepicker1" ).datepicker();
    });
	$(function() {
      $( "#datepicker2" ).datepicker();
    });
    </script>
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
				<li class="item middle" id="seven"><a href="news.php" class="main current"><span class="outer"><span class="inner newsletter">最新消息</span></span></a></li> 
        <li class="item middle" id="two"><a href="article_area.php" class="main"><span class="outer"><span class="inner content">文案編輯</span></span></a></li>
				<li class="item middle" id="six"><a href="article_event.php" class="main"><span class="outer"><span class="inner event_manager">活動管理</span></span></a></li> 
		<li class="item middle" id="five"><a href="picture.php" class="main"><span class="outer"><span class="inner media_library">影視編輯</span></span></a></li>  
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
                      <li><a href="news.php"><span>編輯最新消息</span></a></li>
                      <li><a href="newsAdd.php"><span>新增最新消息及活動</span></a></li>
                      <li><a href="newsAdd.php" class="current"><span>最新消息活動資料修改</span></a></li>

          
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
    <h1 class="content_edit">最新消息及活動資料修改

	</h1>

    <p> 最新消息標題限制三十個中文字元。最新消息內容不限字元。請確認您的文章無誤再上傳。建議先在別的地方打好文章再貼到這邊上傳。有任何問題請聯絡系統管理員。 </p>

    </div>
    <!-- CONTENT TITLE RIGHT BOX -->
    <div class="grid_6" id="eventbox"><a href="#" class="inline_tip">此頁面只提供新增最新消息資料</a></div>
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
              <form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1" enctype="multipart/form-data">
                <table width="900" height="363" align="center">
                  <tr valign="baseline">
                    <td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
                    <td colspan="3"><input type="text" name="no" value="<?php echo $row_EditNews['no']; ?>" size="20" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td width="97" align="right" valign="middle" nowrap="nowrap">類別:</td>
                    <td colspan="3">
                      <select name="type" title="<?php echo $row_EditNews['type']; ?>" type="text">
                        <option value="news">最新消息</option>
                        <option value="event">最新活動</option>
                      </select></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" valign="middle" nowrap="nowrap">標題:</td>
                    <td colspan="3"><input type="text" name="title" value="<?php echo $row_EditNews['title']; ?>" size="116" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" valign="middle" nowrap="nowrap">內容:</td>
                    <td colspan="3"><textarea name="content" cols="88" rows="6"><?php echo $row_EditNews['content']; ?></textarea></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" valign="middle" nowrap="nowrap">圖片:</td>
                    <td colspan="3"><input name="pic" type="file"  id="pic" value="<?php echo $row_EditNews['pic']; ?>"/></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" valign="middle" nowrap="nowrap">開始日期:</td>
                    <td width="346"><input type="text" name="startdate" value="<?php echo $row_EditNews['startdate']; ?>" size="46" id="datepicker"/></td>
                    <td width="66" align="right" valign="middle">結束日期:</td>
                    <td width="371"><input type="text" name="endate" value="<?php echo $row_EditNews['endate']; ?>" size="46" id="datepicker1"/></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" valign="middle" nowrap="nowrap">地點:</td>
                    <td><input type="text" name="place" value="<?php echo $row_EditNews['place']; ?>" size="46" /></td>
                    <td align="right" valign="middle" >上傳日期:</td>
                    <td><input type="text" name="update" value="<?php echo $row_EditNews['update']; ?>" size="46" id="datepicker2"/></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
                    <td align="right" valign="middle">&nbsp;</td>
                    <td><input type="submit" class="button" value="上傳" /></td>
                    <td align="left" valign="bottom">按下儲存即上傳文章，請確認您的文章無誤。</td>
                  </tr>
                </table>
                <input type="hidden" name="MM_insert" value="form1" />
                <input type="hidden" name="MM_update" value="form1" />
              </form>
              <p>&nbsp;</p></div>





   
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
mysql_free_result($EditNews);
?>
