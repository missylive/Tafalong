<?php
$dbname="tt";
$dbuser="root";
$dbpass="02294774";
$link=mysql_connect(localhost,$dbuser,$dbpass);
mysql_query("SET NAMES utf8");
mysql_query('SET CHARACTER_SET_CLIENT=utf8');
mysql_query('SET CHARACTER_SET_RESULTS=utf8');
if($link){ 
    mysql_select_db($dbname,$link);
}else{ 
    die("��Ʈw�Ȱ��ϥΤ��A�о��t�s�����ޤH���״_�C"); 
} 
?>