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

  //����SQL�R�O
  $sql = "INSERT INTO mix(title,content,update) VALUES ('$TITLE','$CONTENT','$CURRENT_TIME')";
  echo $sql;
  //mysql_query("SET NAMES 'utf8'");
  //$result = mysql_query($sql,$link);
  //if (!$result) die("����SQL�R�O����");
  
  //������Ʈw�s��
  //mysql_close($link);
  //echo 4;
  //�N�������s�ɦV��article1.html
  //header("location:article1.html");
  //exit();
//echo 5;

?>
