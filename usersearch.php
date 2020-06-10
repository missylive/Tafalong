<?php require_once('Connections/dbconnect.php');  ?>
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

$colname_usersearch = "-1";
if (isset($_SESSION['username'])) {
  $colname_usersearch = $_SESSION['username'];
}
mysql_select_db($database_dbconnect, $dbconnect);
$query_usersearch = sprintf("SELECT * FROM `user` WHERE id = %s", GetSQLValueString($colname_usersearch, "text"));
$usersearch = mysql_query($query_usersearch, $dbconnect) or die(mysql_error());
$row_usersearch = mysql_fetch_assoc($usersearch);
$totalRows_usersearch = mysql_num_rows($usersearch);

mysql_free_result($usersearch);
?>
