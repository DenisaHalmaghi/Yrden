<?php
	$user="denisa.halmaghi";
	$pass="Hd299081";
	$host="localhost";
	$db="u_denisahalmaghi";
	
mysql_connect($host, $user, $pass) or die("Serverul nu functioneaza! Bubaaa");
mysql_select_db($db) or die("Nu exista baza de date! Bubaaa");
echo "Fara buba";

// $query="SELECT * FROM Studenti";
// $res=mysql_query ( $query );

// while($row=mysql_fetch_assoc($res))
// print_r(mysql_result($res));

echo "e";

?>