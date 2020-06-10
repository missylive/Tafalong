<?php require_once('../Connections/dbconnect.php'); ?>
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
  $updateSQL = sprintf("UPDATE mix SET type=%s, title=%s, content=%s, pic=%s, uptime=%s WHERE `no`=%s",
                       GetSQLValueString($_POST['type'], "text"),
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['content'], "text"),
                       GetSQLValueString($_POST['pic'], "text"),
                       GetSQLValueString($_POST['uptime'], "date"),
                       GetSQLValueString($_POST['no'], "int"));

  mysql_select_db($database_dbconnect, $dbconnect);
  $Result1 = mysql_query($updateSQL, $dbconnect) or die(mysql_error());
}

$colname_Recordset1 = "-1";
if (isset($_GET['no'])) {
  $colname_Recordset1 = $_GET['no'];
}
mysql_select_db($database_dbconnect, $dbconnect);
$query_Recordset1 = sprintf("SELECT * FROM mix WHERE `no` = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $dbconnect) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>後台管理 | 編輯太巴塱社區文章</title>
<link rel="stylesheet" type="text/css" href="css/960.css" />
<link rel="stylesheet" type="text/css" href="css/reset.css" />
<link rel="stylesheet" type="text/css" href="css/text.css" />
<link rel="stylesheet" type="text/css" href="css/blue.css" />
<link rel="stylesheet" type="text/css" href="css/upfile.css" />

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
	   

	function ajaxFileUpload(value)
	{
		$("#loading")
		.ajaxStart(function(){
			$(this).show();
		})
		.ajaxComplete(function(){
			$(this).hide();
			
		});

		$.ajaxFileUpload
		(
			{   
			    
				url:'UploadFile.php',
				secureuri:false,
				fileElementId:'fileToUpload',
				dataType: 'text',
				success: function (data, status)
				{
					//alert(data);
					
					if(data != "error")
					{
					  $("#BigPhoto").attr("src","pic/" + data);
					  $("#smallphoto_1").attr("src","pic_130/" + data);
					  alert(data + "上傳成功");
					}
					else
					{
					  alert("上傳失敗");
					}
				},
				error: function (data, status, e)
				{
					alert(e);
				}
			}
		)
		
		return false;

	};
	
	

    /* $(document).ready(function){
     timestamp = 0;
	 update();
	 alert("ok");
	 $("form#").submit(function(){/*Code});*/
	 
	 /*
	 $.post("Sendmixmsg.php",{message: $(#"ccontent").val(), title:$("#ctitle").val(), action: "posting", time: timestamp }, fuction(xml){
alert("ok");
      addMessages(xml);
	  
	  if($("status",xml).text() == "2")return;
	  
	  timestamp = $("time",xml).text();
	  
	  $("message",xml)each(function(id) {
	    message = $("ccontent",xml).get(id);
	  $("messagewindow".prepend("<b>"+$("ctitle",message).text()+ "</b>: "+$("ccontent",message).text()+"<br/>");
	  
	  });
	  }
	  
	  function updateMsg(){
	   $.post("Sendmixmsg.php",{ time: timestamp }, function(xml){
	     $("#loading").remove();
		 addMessages(xml);
		 });
		alert("ok");
		setTimeout('updateMsg()',4000);
	  }
	  
		*/

	$(function(){
	   $("#submit").click(function(){
		  var title = $("#title").val();
		  var content = $("#content").val();
		  if(title == "" )
		  {
		    alert("標題不可為空白！ 請填入標題");
			return 0; 
		  }
		  
		  if(content == "" )
		  {
		    alert("內容不可為空白！ 請輸入內容！");
			return 0; 
		  }
		    if(confirm("確定送出資料？"))
		  {
		    alert("ok");
			 var url = "Sendmixmsg.php?TITLE=" + ctitle + "&CONTENT=" + ccontent;
			 get=encodeURI(url); 
			 $.get(get,function(DATA){
			  
			  if(DATA == "OK")
			  {
			    alert("傳送成功")
				location.reload()
			  }
			  else
			  {
			     alert(DATA)
			  }
			 
			 });
		     
		  };	

		

		
		
			
				  
		});

		
	   })
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
      <div id="user_tools"><span><a href="#" class="mail">(1)</a> 歡迎來到後台管理 <a href="#">Admin Username</a>  |  <a class="dropdown" href="#">Change Theme</a>  |  <a href="#">登出</a></span></div>
    </div>
<div class="grid_16" id="header">
<!-- MENU START -->
<div id="menu">
	<ul class="group" id="menu_group_main">
		<li class="item first" id="one"><a href="dashboard.php" class="main"><span class="outer"><span class="inner dashboard">首頁</span></span></a></li>
				<li class="item middle" id="seven"><a href="news.php" class="main"><span class="outer"><span class="inner newsletter">最新消息</span></span></a></li> 
        <li class="item middle" id="two"><a href="article_area.php" class="main current"><span class="outer"><span class="inner content">文案編輯</span></span></a></li>
				<li class="item middle" id="six"><a href="picture.php" class="main"><span class="outer"><span class="inner event_manager">照片編輯</span></span></a></li> 
		<li class="item middle" id="five"><a href="video.php" class="main"><span class="outer"><span class="inner media_library">影片編輯</span></span></a></li>  
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
             <li><a href="article_area.php"><span>太巴塱社區文章</span></a></li>
             <li><a href="article_festival.php"><span>節慶類文章</span></a></li>
             <li><a href="article_event.php"><span>活動類文章</span></a></li>
             <li><a href="article_Add.php"><span>新增文章</span></a></li>
             <li><a href="article_Add.php" class="current"><span>文章修改</span></a></li>

          
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
    <h1 class="content_edit">文章修改

	</h1>

    <p> 請先選擇您要發表的文章類別，後再新增文章。文章標題限制三十個中文字元。文章內容不限字元。請確認您的文章無誤再上傳。建議先在別的地方打好文章再貼到這邊上傳。有任何問題請聯絡系統管理員。 </p>

    </div>
    <!-- CONTENT TITLE RIGHT BOX -->
    <div class="grid_6" id="eventbox"><a href="#" class="inline_tip">此頁面只提供新增文章資料</a></div>
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


      <!-- BUTTONS -->
            <!--<a class="button" id="submit"><span>儲存</span></a>-->
            <div class='hidden'><a class="button_ok"><span>上傳完成</span></a> <a class="button_notok"><span>無法上傳</span></a></div>
            
        <form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1"  enctype="multipart/form-data">
          <table width="819"  align="center">
            <tr valign="baseline">
              <td align="right" nowrap="nowrap">&nbsp;</td>
              <td><input type="text" name="no" value="<?php echo $row_Recordset1['no']; ?>" size="20" /></td>
            </tr>
            <tr valign="baseline">
              <td width="84" align="right" nowrap="nowrap"><strong>類別:</strong></td>
              <td width="723">
              <select name="type" title="<?php echo $row_Recordset1['type']; ?>" type="text">
                        <option value="area">太巴朗社區文章</option>
                        <option value="festival">節慶類文章</option>
                        <option value="event">活動類文章</option>
              </select>

              </td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right"><strong>文章標題:</strong></td>
              <td><input type="text" name="title" value="<?php echo $row_Recordset1['title']; ?>" size="120" /></td>
            </tr>
            <tr valign="baseline">
              <td align="center" valign="middle" nowrap="nowrap"><strong>文章內容:</strong></td>
              <td><textarea name="content" cols="91" rows="20"  ><?php echo $row_Recordset1['content']; ?></textarea></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right"><strong>上傳圖片:</strong></td>
              <td>
                     <input name="pic" type="file"  id="pic" value="<?php echo $row_Recordset1['pic']; ?>" size="30" >

                </td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right"><strong>發表時間:</strong></td>
              <td><input type="text" name="uptime" value="<?php echo $row_Recordset1['no']; ?>" size="120" id="datepicker"/></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">&nbsp;</td>
              <td><input type="submit" class="button" value="儲存" />
              按下儲存即上傳文章，請確認您的文章無誤。</td>
            </tr>
          </table>
          <input type="hidden" name="MM_insert" value="form1" />
          <input type="hidden" name="MM_update" value="form1" />
        </form>
        
 




   
    </div></div>
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
mysql_free_result($Recordset1);
?>
