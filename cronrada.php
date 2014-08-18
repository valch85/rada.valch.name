<?php
#!/usr/bin/php
//var for MySQL DB
$hostname = "localhost";
$username = "root";
$password = "password";
$dbName = "rada";
// conect to DB
$db = mysql_connect ($hostname,$username,$password) OR DIE("no connection to DB");
mysql_select_db ($dbName, $db);
//select ifo from DB
$result2 = mysql_query ("SELECT * FROM zakoni", $db);
$myrow = mysql_fetch_array ($result2);
        do
		{
	//		echo $myrow ['url']."<br>";
			$url = $myrow['url'];
	//		echo "1 ".$url."    ";
			$date2 = $myrow['date'];
	//		echo "2 ".$date2."    ";
			error_reporting(E_ALL|E_STRICT); 
			//CURL - for 200 page  status code
			preg_match("/^http:\/\/?([^\/:]+)[:]*([0-9]*)/i",$url, $matches);
			$host =  $matches[1];
			$port =  (($matches[2] == null) ? "80":  $matches[2]);
			set_time_limit(0);
                	$query="HEAD ".$url." HTTP/1.0\r\n\r\n";
                	if($OpenSocket=@fsockopen($host,$port,$string,$body,5))
                        {
                        	fputs($OpenSocket,$query);
                        	feof($OpenSocket);
                        	$res =  fgets($OpenSocket);
                                fclose($OpenSocket);
                                if(preg_match("/^HTTP\/1.1 ([0-9]{3})/i",$res,$code))
                                {
                                        switch($code[1])
                                        {
                                                case 200:
							//echo "curl ".$url."     ";
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
        						//echo "4 ".$date."     ";
                					if ($date != $date2)
        						/*      {
                                					echo "5 show this text \n";
                        					}
                					else*/
                						{
        						//      echo "6 show this text \n";
                        					mysql_query ("UPDATE zakoni SET date='$date' WHERE url='$url'") or die(mysql_error());
                        					$to      = 'lena@valch.name val@valch.name';
                        					$subject = "rada old date: $date2 new date: $date";
                        					$message = "following urls was changed $url";
                        					$headers = 'From: rada@valch.name'."\r\n";
                        					mail ($to, $subject, $message, $headers);
                        					}       
 							break;
						case 404:
							//print ("net stranici");
                                                        break;
                                        }
                                }

			}
                        else
                                break;

		}
        while ($myrow = mysql_fetch_array ($result2));
?>
