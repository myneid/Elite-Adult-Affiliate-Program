<?php

require_once('../phpinclude/classAffiliateProgramDB.inc.php');


$host = "66.63.172.152"; 
$username = "pinkpays"; 
$password = "eaff9929"; 
$database = "gaypink"; 

$server = mysql_connect($host, $username, $password) or die(mysql_error()); 

// Select the database now: 
$connection = mysql_select_db($database, $server);


/*	$res = 	$db->query("show databases");
	if(DB::isError($res))
		print_r($res);
*/
echo "<table width=500>";
$sql = "desc Affiliate ";  
$result = mysql_query($sql); 
if(mysql_num_rows($result)){ 
    while($row = mysql_fetch_row($result)){ 
         echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td></tr><br>";   
} } else { echo 'No records exist.'; } 



echo "</table><p><br></p><table width=500>";

$sql = "desc AffiliateLogin ";  
$result = mysql_query($sql); 
if(mysql_num_rows($result)){ 
    while($row = mysql_fetch_row($result)){ 
         echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td></tr><br>";   
} } else { echo 'No records exist.'; } 


echo "</table>";



echo "<table width=500>";
$sql = "select * from Affiliate ";  
$result = mysql_query($sql); 
if(mysql_num_rows($result)){ 
    while($row = mysql_fetch_row($result)){ 
         echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td></tr><br>";   
} } else { echo 'No records exist.'; } 



echo "</table>";


mysql_close($server); 

?>