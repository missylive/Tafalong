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
  $updateSQL = sprintf("UPDATE video SET type=%s, title=%s, website=%s, content=%s WHERE `no`=%s",
                       GetSQLValueString($_POST['type'], "text"),
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['webside'], "text"),
                       GetSQLValueString($_POST['content'], "text"),
                       GetSQLValueString($_POST['no'], "int"));

  mysql_select_db($database_dbconnect, $dbconnect);
  $Result1 = mysql_query($updateSQL, $dbconnect) or die(mysql_error());

  $updateGoTo = "video.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_EditVideo = "-1";
if (isset($_GET['no'])) {
  $colname_EditVideo = $_GET['no'];
}
mysql_select_db($database_dbconnect, $dbconnect);
$query_EditVideo = sprintf("SELECT `no`, type, title, website, content FROM video WHERE `no` = %s", GetSQLValueString($colname_EditVideo, "int"));
$EditVideo = mysql_query($query_EditVideo, $dbconnect) or die(mysql_error());
$row_EditVideo = mysql_fetch_assoc($EditVideo);
$totalRows_EditVideo = mysql_num_rows($EditVideo);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>後台管理 | 影音編輯</title>
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
		<li class="item middle" id="five"><a href="video.php" class="main current"><span class="outer"><span class="inner media_library">影片編輯</span></span></a></li>  
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
                     
                      <li><a href="video.php"><span>編輯影片分享</span></a></li>
                      <li><a href="videoAdd.php"><span>新增影片</span></a></li>
                      <li><a href="videoEdit.php" class="current"><span>修改影片資料</span></a></li>

          
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
    <h1 class="content_edit">修改影片資料</h1>
	   <p> 此頁面可一次新增十筆資料，請在選擇您要新增的類別，鍵入資料，網址列請提供完整網址。</p>
	   <p>有任何問題請聯絡系統管理員。 </p>

    </div>
	<div class="hidden">
        <p class="info" id="success"><span class="info_inner">修改成功！</span></p>
        <p class="info" id="error"><span class="info_inner">系統錯誤，無法修改！請聯絡管理員</span></p>
        <p class="info" id="warning"><span class="info_inner">網路錯誤無法上傳！</span></p>
      </div>
    <!-- CONTENT TITLE RIGHT BOX -->
    <div class="grid_6" id="eventbox"><a href="#" class="inline_tip">此頁面提供新增影音資料</a></div>
    <div class="clear">

    </div>
<!--    TEXT CONTENT OR ANY OTHER CONTENT START     -->
    <div class="grid_15" id="textcontent">
            <div style="margin:auto; width:900px;">
            <form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
            	<table width="100%" border="0" cellpadding="6" cellspacing="1" id="tb01" >
                  <tr style="text-align:left;">
                    <td height="38" align="right">&nbsp;</td>
                    <td colspan="3"><input  name="no"  type="text" id="no" value="<?php echo $row_EditVideo['no']; ?>" size="20"/>                    </td>
                  </tr>
                  <tr style="text-align:left;">
                    <td width="16%" height="38" align="right">類別</td>
                    <td colspan="3"><span class="even">
                      <select name="type" title="<?php echo $row_EditVideo['type']; ?>" type="text">
                        <option value="area">太巴朗社區影音</option>
                        <option value="festical">節慶類影音</option>
                        <option value="event">活動類影音</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td height="39" align="right" valign="top" class="even">影音標題</td>
                    <td width="30%" class="even"><input  name="title"  type="text" value="<?php echo $row_EditVideo['title']; ?>" size="40"/></td>
                    <td width="8%" align="right" valign="top" class="even">網址</td>
                    <td width="46%" class="even"><input  name="webside"  type="text" value="<?php echo $row_EditVideo['website']; ?>" size="40"/></td>
                  </tr>
                  <tr>
                    <td height="48" align="right" valign="top" class="even">簡介</td>
                    <td colspan="3" class="even"><textarea name="content" cols="75" rows="2"><?php echo $row_EditVideo['content']; ?></textarea></td>
                  </tr>
<tr>
              <td class="even"></td>
              <td class="even"></td>                    
              <td class="even"></td>
			  <td align="left" class="even"><input type="submit"   class="save" value=""/></td>				
              </tr>
              </table>
            	<input type="hidden" name="MM_insert" value="form1" />
            	<input type="hidden" name="MM_update" value="form1" />
              </form>
</div>
			 
      <div>
                  <div align="right"><a href="#"></a></div>
                </div>


   
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
mysql_free_result($EditVideo);
?>
