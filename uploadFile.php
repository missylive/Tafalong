<?php 
echo "<table border=\"1\">";
echo "<tr><td>Client Filename: </td>
   <td>" . $_FILES["goods_img"]["name"] . "</td></tr>";
echo "<tr><td>File Type: </td>
   <td>" . $_FILES["goods_img"]["type"] . "</td></tr>";
echo "<tr><td>File Size: </td>
   <td>" . ($_FILES["goods_img"]["size"] / 1024) . " Kb</td></tr>";
echo "<tr><td>Name of Temp File: </td>
   <td>" . $_FILES["goods_img"]["tmp_name"] . "</td></tr>";
echo "</table>";

if ($_FILES["goods_img"]["error"] > 0)
   {
   echo "Apologies, an error has occurred.";
   echo "Error Code: " . $_FILES["goods_img"]["error"];
   }
else
   {

   move_uploaded_file($_FILES["goods_img"]["tmp_name"],
  "C:/upload/" . $_FILES["goods_img"]["name"]);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>

<body>

<form enctype="multipart/form-data" method="post" action="uploadFile.php">
<input type="file" name="goods_img" /><br />
<input type="submit" value="Upload File" />
</form>

</body>
</html>