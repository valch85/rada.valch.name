<html>
<head>
<title>url rada checker</title>
<link rel="shortcut icon" href="/var/www/rada.valch.name/favicon.ico"  type="image/x-icon" />
</head>
<form method="post" action="add.php">
<input type="text" name="url" size="50" maxlength="255" value="insert url"> <br>
<!--<input type="text" name="date" size="50" maxlength="255" value="insert date"> <br>
<input type="text" name="state" size="50" maxlength="255" value="insert state"> <br>-->
<input type="submit" name="save" value="Save">
</form>
<html>

<?php
//var for MySQL DB
$hostname = "localhost";
$username = "root";
$password = "password";
$dbName = "rada";
// conect to DB
$db = mysql_connect ($hostname,$username,$password) OR DIE("no connection to DB");
mysql_select_db ($dbName, $db);
//show data from table
$result2 = mysql_query ("SELECT * FROM zakoni", $db);
$myrow = mysql_fetch_array ($result2);
        do
           {
           echo $myrow['id']." ";
           echo $myrow['url']." ";
           echo $myrow['date']." ";
           echo $myrow['state']."<br>";
           }
        while ($myrow = mysql_fetch_array ($result2));
?>
