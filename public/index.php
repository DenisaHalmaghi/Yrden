<?php
session_start();
require_once("../app/init.php");
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = array();
  $_SESSION['itemsInCart'] = 0;
}
$app = new app();
