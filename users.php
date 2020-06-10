<?php 
session_start();
  if (strtolower($_SESSION['MM_Username'])!='admin'){
	  header("Location:UserEdit.php");
  }
?>
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

$maxRows_show_users = 10;
$pageNum_show_users = 0;
if (isset($_GET['pageNum_show_users'])) {
  $pageNum_show_users = $_GET['pageNum_show_users'];
}
$startRow_show_users = $pageNum_show_users * $maxRows_show_users;

mysql_select_db($database_dbconnect, $dbconnect);
$query_show_users = "SELECT `no`, id, name, mobile, email FROM `user` ORDER BY `no` ASC";
$query_limit_show_users = sprintf("%s LIMIT %d, %d", $query_show_users, $startRow_show_users, $maxRows_show_users);
$show_users = mysql_query($query_limit_show_users, $dbconnect) or die(mysql_error());
$row_show_users = mysql_fetch_assoc($show_users);

if (isset($_GET['totalRows_show_users'])) {
  $totalRows_show_users = $_GET['totalRows_show_users'];
} else {
  $all_show_users = mysql_query($query_show_users);
  $totalRows_show_users = mysql_num_rows($all_show_users);
}
$totalPages_show_users = ceil($totalRows_show_users/$maxRows_show_users)-1;

$queryString_show_users = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_show_users") == false && 
        stristr($param, "totalRows_show_users") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_show_users = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_show_users = sprintf("&totalRows_show_users=%d%s", $totalRows_show_users, $queryString_show_users);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>後台管理 |  編輯網站管理員</title>
<link rel="stylesheet" type="text/css" href="css/960.css" />
<link rel="stylesheet" type="text/css" href="css/reset.css" />
<link rel="stylesheet" type="text/css" href="css/text.css" />
<link rel="stylesheet" type="text/css" href="css/blue.css" />
<link type="text/css" href="css/smoothness/ui.css" rel="stylesheet" />  
    <script type="text/javascript" src="../../ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
    <script type="text/javascript" src="js/blend/jquery.blend.js"></script>
	<script type="text/javascript" src="js/ui.core.js"></script>
	<script type="text/javascript" src="js/ui.sortable.js"></script>    
    <script type="text/javascript" src="js/ui.dialog.js"></script>
    <script type="text/javascript" src="js/ui.datepicker.js"></script>
    <script type="text/javascript" src="js/effects.js"></script>
    <script type="text/javascript" src="js/flot/jquery.flot.pack.js"></script>
    <!--[if IE]>
    <script language="javascript" type="text/javascript" src="js/flot/excanvas.pack.js"></script>
    <![endif]-->
	<!--[if IE 6]>
	<link rel="stylesheet" type="text/css" href="css/iefix.css" />
	<script src="js/pngfix.js"></script>
    <script>
        DD_belatedPNG.fix('#menu ul li a span span');
    </script>        
    <![endif]-->
    <script id="source" language="javascript" type="text/javascript" src="js/graphs.js"></script>
    <script type="text/javascript">
function tfm_confirmLink(message) { //v1.0
	if(message == "") message = "Ok to continue?";	
	document.MM_returnValue = confirm(message);
}
    </script>
</head>

<body>
<!-- WRAPPER START -->
<div class="container_16" id="wrapper">	
<!-- HIDDEN COLOR CHANGER -->      

  	<!--LOGO-->
	<div class="grid_8" id="logo"><img src="images/logo-1.png" width="80" height="75" alt="TafalongLogo" longdesc="dashboard.php" /></a><a href="dashboard.php"><img src="images/TafaLOGO.png" width="293" height="79" alt="TAFALONG" longdesc="dashboard.php" /><br/></div>
    <div class="grid_8">
<!-- USER TOOLS START -->
      <div id="user_tools"><span><a href="#" class="mail">(1)</a> 歡迎來到後台管理 <a href="#">Admin Username</a>  |  <a class="dropdown" href="#">Change Theme</a>  |  <a href="#">登出</a></span></div>
    </div>
<!-- USER TOOLS END -->    
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
        <li class="item middle" id="four"><a href="users.php" class="main current"><span class="outer"><span class="inner users">網站管理員</span></span></a></li>
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
                      <li><a href="users.php" class="current"><span>編輯管理員</span></a></li>
                      <li><a href="AddUsers.php"><span>新增管理員</span></a></li>
           
           </ul>
        </div>
    </div>
<!-- TABS END -->    
</div>
<!-- HIDDEN SUBMENU START -->


<!-- CONTENT START -->
    <div class="grid_16" id="content">
    <!--  TITLE START  --> 
    <div class="grid_9">
    <a href="AddUsers.php" class="newmember"></a>
    </div>
    <!--RIGHT TEXT/CALENDAR-->
    <div class="grid_6" id="eventbox"><a href="#" class="inline_calendar">You don't have any events for today! Yay!</a>
    	<div class="hidden_calendar"></div>
    </div>
    <!--RIGHT TEXT/CALENDAR END-->
    <div class="clear">
    </div>
    <!--  TITLE END  -->    
    <!-- #PORTLETS START -->
    <div id="portlets">
    <!-- FIRST SORTABLE COLUMN START -->
      
      <!-- FIRST SORTABLE COLUMN END -->
      <!-- SECOND SORTABLE COLUMN START -->

	<!--  SECOND SORTABLE COLUMN END -->
    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <div class="portlet-header fixed"><img src="images/icons/user.gif" width="16" height="16" alt="Latest Registered Users" /> 管理網站管理者介面</div>
		
		      <div class="column">
      <!--THIS IS A PORTLET        
      <div class="portlet">
		<div class="portlet-header"><img src="images/icons/comments.gif" width="16" height="16" alt="Comments" />Latest Comments</div>
		<div class="portlet-content">
         <p class="info" id="success"><span class="info_inner">Lorem ipsum dolor sit amet, consectetuer adipiscing elit</span></p>
         <p class="info" id="error"><span class="info_inner">Lorem ipsum dolor sit amet, consectetuer adipiscing elit</span></p>
         <p class="info" id="warning"><span class="info_inner">Lorem ipsum dolor sit amet, consectetuer adipiscing elit</span></p>
         <p class="info" id="info"><span class="info_inner">Lorem ipsum dolor sit amet, consectetuer adipiscing elit</span></p>
        </div>
-->
       </div>    
      <!--THIS IS A PORTLET--> 
                        
    </div>
    
		<div class="portlet-content nopadding">
        
        <form action="" method="post">
          <table width="100%" cellpadding="0" cellspacing="0" id="box-table-a" summary="Employee Pay Sheet">
            <thead>
              <tr>

				<th width="105" scope="col">編號</th>
                <th width="141" scope="col">管理員名稱</th>
                <th width="122" scope="col">管理員帳號</th>
                <th width="109" scope="col">建立日期</th>
                <th width="162" scope="col">E-mail</th>
                <th width="127" scope="col">電話</th>
                <th width="150" scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
        <?php do { ?>

              <tr>

				<td><?php echo $row_show_users['no']; ?></td>
                <td><?php echo $row_show_users['name']; ?></td>
                <td><?php echo $row_show_users['id']; ?></td>
                <td>&nbsp;</td>
                <td><?php echo $row_show_users['email']; ?></td>
                <td><?php echo $row_show_users['mobile']; ?></td>
                <td width="150">
                <a href="#" class="edit_icon" title="Edit">編輯</a> 
                <a href="Delete/DeleteUser.php?no=<?php echo $row_show_users['no']; ?>" title="Delete" class="delete_icon" onclick="tfm_confirmLink('確定刪除使用者?');return document.MM_returnValue">刪除</a>
                </td>
              </tr>
			  <?php } while ($row_show_users = mysql_fetch_assoc($show_users)); ?>
              <tr class="footer">
                <td colspan="3"><a href="#" class="edit_inline"></a><a href="#" class="delete_inline"></a><a href="#" class="approve_inline">Approve all</a><a href="#" class="reject_inline">Reject all</a></td>
                <td align="right">&nbsp;</td>
                <td colspan="3" align="left">
				<!--  PAGINATION START  -->             
                    <div class="pagination">
                    <span class="previous-off"><a href="<?php printf("%s?pageNum_show_users=%d%s", $currentPage, max(0, $pageNum_show_users - 1), $queryString_show_users); ?>">上一頁<img src="images/icons/back.png" /></a><a href="<?php printf("%s?pageNum_show_users=%d%s", $currentPage, min($totalPages_show_users, $pageNum_show_users + 1), $queryString_show_users); ?>"><img src="images/icons/next.png" />下一頁</a>
                    </div>  
                <!--  PAGINATION END  -->       
                </td>
              </tr>
            </tbody>
          </table>
        </form>
		</div>
      </div>
<!--  END #PORTLETS -->  
   </div>
    <div class="clear"> </div>
<!-- END CONTENT-->    
  </div>
<div class="clear"> </div>

		<!-- This contains the hidden content for modal box calls -->
		<div class='hidden'>
			<div id="inline_example1" title="This is a modal box" style='padding:10px; background:#fff;'>
			<p><strong>This content comes from a hidden element on this page.</strong></p>
            			
			<p><strong>Try testing yourself!</strong></p>
            <p>You can call as many dialogs you want with jQuery UI.</p>
			</div>
		</div>
</div>
<!-- WRAPPER END -->
<!-- FOOTER START -->
<div class="container_16" id="footer">
	Website Administration by <a href="../index.htm">Missy Chu</a></div>
<!-- FOOTER END -->
</body>
</html>
<?php
mysql_free_result($show_users);
?>
