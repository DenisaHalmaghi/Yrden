<?php
$user = "root";
$pass = "";
$host = "localhost";
$db = "proiect";

mysql_connect($host, $user, $pass) or die("Serverul nu functioneaza! ");
mysql_select_db($db) or die("Nu exista baza de date! ");
