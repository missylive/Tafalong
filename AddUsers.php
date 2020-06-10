<?php require_once('Connections/dbconnect.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "dashboard.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
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
  $insertSQL = sprintf("INSERT INTO `user` (id, password, name, phone, mobile, email, email2, address, other) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                      
                       GetSQLValueString($_POST['id'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['phone'], "int"),
                       GetSQLValueString($_POST['mobile'], "int"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['email2'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['other'], "text"));

  mysql_select_db($database_dbconnect, $dbconnect);
  $Result1 = mysql_query($insertSQL, $dbconnect) or die(mysql_error());

  $insertGoTo = "users.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_dbconnect, $dbconnect);
$query_users = "SELECT * FROM `user` ORDER BY `no` ASC";
$users = mysql_query($query_users, $dbconnect) or die(mysql_error());
$row_users = mysql_fetch_assoc($users);
$totalRows_users = mysql_num_rows($users);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>後台管理 |  編輯網站管理員</title>
<link rel="stylesheet" type="text/css" href="css/960.css" />
<link rel="stylesheet" type="text/css" href="css/reset.css" />
<link rel="stylesheet" type="text/css" href="css/text.css" />
<link rel="stylesheet" type="text/css" href="css/blue.css" />
<link type="text/css" href="css/smoothness/ui.css" rel="stylesheet" />
<link type="text/css" href="js/wysiwyg/jquery.wysiwyg.css" rel="stylesheet" />
<link href="../SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="js/wysiwyg/jquery.wysiwyg.js"></script>
	<script src="../SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
	<script src="../SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
	<script type="text/javascript">
$(function(){
				
		$("#submit").click(function(){
		  
		    alert("ok");
		  
		  var id = $("#id").val();
		  var password = $("#password").val();
		  var name = $("#name").val();
		  var phone = $("#phone").val();
		  var mobile = $("#mobile").val();
		  var email = $("#email").val();
		  var email2 = $("#email2").val();
		  var address = $("#address").val();
		  var other = $("#other").val();
		  
		  if(id == "" )
		  {
		    alert("標題不可為空白！ 請填入標題");
			return 0; 
		  }
		  
		  if(password == "" )
		  {
		    alert("內容不可為空白！ 請輸入內容！");
			return 0; 
		  }
		  
		  if(name == "" )
		  {
		    alert("標題不可為空白！ 請填入標題");
			return 0; 
		  }
		   
		   if(mobile == "" )
		  {
		    alert("標題不可為空白！ 請填入標題");
			return 0; 
		  }
		  if(email == "" )
		  {
		    alert("標題不可為空白！ 請填入標題");
			return 0; 
		  }
		  if(address == "" )
		  {
		    alert("標題不可為空白！ 請填入標題");
			return 0; 
		  }	

		
		  if(confirm("確定新增管理員？"))
		  {
		    
			 var url = "createuser.php?ID=" + id + "&PASSWORD=" + password + "&NAME=" + name + "&PHONE=" + phone + "&MOBILE=" + mobile + "&EMAIL=" + email + "&EMAIL2=" + email2 + "&ADDRESS=" + address + "&OTHER=" + other;
			 url=encodeURI(url); 
			 $.get(url,function(DATA){
			  
			  if(DATA == "OK")
			  {
			    alert("新增成功")
				location.reload()
			  }
			  else
			  {
			     alert(DATA)
			  }
			 
			 });
		     
		  }
		
		
			
				  


		});
		
	   })
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
    } if (errors) alert('The following error(s) occurred:\n'+errors);
    document.MM_returnValue = (errors == '');
} }
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
	<div class="grid_8" id="logo">後台管理 - 編輯網站管理員</div>
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
                      <li><a href="users.php"><span>編輯管理員</span></a></li>
                      <li><a href="AddUsers.php" class="current"><span>新增管理員</span></a></li>
           
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
    <h1 class="content_edit">新增網站管理員資料

	</h1>

    <p> 文章標題限制三十個中文字元。文章內容不限字元。請確認您的文章無誤再上傳。建議先在別的地方打好文章再貼到這邊上傳。有任何問題請聯絡系統管理員。 </p>

    </div>
    <!-- CONTENT TITLE RIGHT BOX -->
    <div class="grid_6" id="eventbox"><a href="#" class="inline_tip">此頁面只提供新增文章資料</a></div>
    <div class="clear">
    <?php if($_GET[Err]=="y")  { ?>
    <p class="info" id="warning"><span class="info_inner">使用者帳號衝突!!! 已有相同使用者ID帳號，請重新輸入帳號！</span></p>
	<?php }?>
    </div>
	<div class="hidden">
        <p class="info" id="success"><span class="info_inner">修改成功！</span></p>
        <p class="info" id="error"><span class="info_inner">系統錯誤，無法修改！請聯絡管理員</span></p>
        
      </div> 
<!--    TEXT CONTENT OR ANY OTHER CONTENT START     -->
    <div class="grid_15" id="textcontent" onfocus="MM_validateForm('id','','R','UserPWD','','R','password','','R','name','','R','mobile','','R','email','','RisEmail');return document.MM_returnValue">
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table width="872" height="453" align="center">
          <tr valign="baseline">
            <td width="288" align="right" nowrap="nowrap"><a class="me">管理員帳號</a></td>
            <td width="572"><input name="id" type="text" id="id" value="" size="40" /></td>
          </tr>
          <tr valign="baseline">
            <td><a class="me">密碼</a></td>
            <td><span id="sprypassword1">
              <input name="UserPWD" type="PASSWORD" id="UserPWD" value="" size="40"/>
            <span class="passwordRequiredMsg">需要有一個值。</span></span></td>
          </tr>
          <tr valign="baseline">

            <td nowrap="nowrap" align="right"><a class="me">重複輸入密碼</a></td>
            <td><span id="spryconfirm1">
              <input name="password" type="PASSWORD" id="password" value="" size="40" />
            <span class="confirmRequiredMsg">需要有一個值。</span><span class="confirmInvalidMsg">值不相符。</span></span></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right"><a class="me">管理員名稱</a></td>
            <td><input name="name" type="text" id="name" value="" size="40" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right"><a class="me">電話</a></td>
            <td><input type="text" name="phone" value="" size="40" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right"><a class="me">手機</a></td>
            <td><input name="mobile" type="text" id="mobile" value="" size="40" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right"><a class="me">電子信箱</a></td>
            <td><input name="email" type="text" id="email" value="" size="40" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right"><a class="me">備用信箱</a></td>
            <td><input type="text" name="email2" value="" size="40" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right"><a class="me">居住地址</a></td>
            <td><input type="text" name="address" value="" size="80" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">備註Other:</td>
            <td><textarea name="other" cols="61" rows="3" type="text" value="" ></textarea></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td align="center" valign="middle"> <input class="button" type="submit" value="新增管理員" />按下儲存即新增網站後台管理員，請確認資料無誤。可隨時刪除管理員帳號。</td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1" />
      </form>
      <p>&nbsp;</p>

      <!--WYSIWYG Editor is linked to the textarea with id: #wysiwyg-->
    
      <label></label>

       <!-- BUTTONS -->
       <div class='hidden'><a class="button_ok"><span>上傳完成</span></a>
        <a class="button_notok"><span>無法上傳</span></a></div>
    <br />




   
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
<script type="text/javascript">
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1");
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "UserPWD");
</script>
</body>
</html>
<?php
mysql_free_result($users);
?>
