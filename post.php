<?
/*
   var_dump($_POST); var_dump($_POST);
  $TITLE = $_POST["title"];
  $CONTENT = $_POST["content"];
  
  $CURRENT_TIME = date("Y-M-D H:I:S");
  $sql = "INSERT INTO mix(`title`,`content`,`update`) VALUES ('$TITLE','$CONTENT','$CURRENT_TIME')";
  echo $sql;
*/
  require_once('dbconnect.php');
  
  $TITLE = $_GET["TITLE"];
  $CONTENT = $_GET["CONTENT"];
  $CURRENT_TIME = DATE("Y-M-D H:I:S");

  //執行SQL命令
  $sql = "INSERT INTO mix(title,content,update) VALUES ('$TITLE','$CONTENT','$CURRENT_TIME')";
  echo $sql;
  //mysql_query("SET NAMES 'utf8'");
  //$result = mysql_query($sql,$link);
  //if (!$result) die("執行SQL命令失敗");
  
  //關閉資料庫連接
  //mysql_close($link);
  //echo 4;
  //將網頁重新導向到article1.html
  //header("location:article1.html");
  //exit();
//echo 5;

?>
