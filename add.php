<?php
//var2 for MySQL DB
$hostname = "localhost";
$username = "root";
$password = "password";
$dbName = "rada";
//catch sending URL
$url = $_REQUEST["url"];
// conect to DB
$db = mysql_connect ($hostname,$username,$password) OR DIE("no connection to DB");
mysql_select_db ($dbName, $db);
//select ifo from DB
$result2 = mysql_query ("SELECT * FROM zakoni where url = '$url'", $db);
$myrow = mysql_fetch_array ($result2);
	do
	{
		$url2 = $myrow['url'];
		if ($url != $url2)
		{
			//error reporting
			error_reporting(E_ALL|E_STRICT); 
			$ch=curl_init("$url");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);
			curl_close($ch);
			//parsing for date
			preg_match ('/\(\d{1,2}\.\d{1,2}\.\d{4}\)/', $output, $matches);
			$datetemp1 = $matches[0];
			$datetemp1 = preg_replace('/(\d{2}).(\d{2}).(\d{4})/', '$3-$2-$1', $datetemp1);
			$datetemp2 = preg_replace("/(.*).$/", "\\1", $datetemp1);
			$date = substr($datetemp2, 1);
			//insert url, date, state into MySQL
			$state = 1;
			if ($date != '') 
			{
				$result = mysql_query ("INSERT INTO zakoni (url,date,state) VALUES ('$url','$date','$state')" );
			}
			else
			{
				echo "<br>URL isn't correct<br>";
			}
			//redirect
			//header('Location: http://rada.valch.name');
			exit;
		}
		else
		{
		//	header('Location: http://rada.valch.name/presenturl.html');
			echo "<br>$url2 - url is present in DB<br>";
		}
	}
	while ($myrow = mysql_fetch_array ($result2));
?>
