<?php
session_start();
header("Content-type: text/html; charset=utf-8");
require_once('dbconnect.php');


$ID = $_GET['ID'];
$PASSWORD = $_GET['PASSWORD'];
$NAME = $_GET['NAME'];
$PHONE = $_GET['PHONE'];
$MOBILE = $_GET['MOBILE'];
$EMAIL = $_GET['EMAIL'];
$EMAIL2 = $_GET['EMAIL2'];
$ADDRESS = $_GET['ADDRESS'];
$OTHER = $_GET['OTHER'];

$INSERT = "INSERT INTO user (id,password,name,phone,mobile,email,email2,address,other) VALUES ('$TITLE','$PASSWORD','$NAME','$PHONE','$MOBILE','$EMAIL','$EMAIL2','$ADDRESS','$OTHER')";
mysql_query($INSERT);

echo $INSERT;

  
?>