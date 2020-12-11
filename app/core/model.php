<?php

class Model
{

  protected static $conn;
  protected $util;
  public function __construct()
  {

    $user = "root";
    $pass = "";
    $host = "localhost";
    $db = "proiect";

    if (self::$conn) {
      return;
    }
    self::$conn = mysqli_connect($host, $user, $pass) or die("Serverul nu functioneaza! Bubaaa");
    mysql_select_db($db) or die("Nu exista baza de date! Bubaaa");
  }

  function __destruct()
  {
    if (self::$conn) {
      mysql_close(self::$conn);
      self::$conn = null;
    }
  }

  function queryDb($sql)
  {
    $rez = mysql_query($sql) or die(mysql_error());
    return $rez;
  }

  protected function prepareInsertQuery($data, $table = "users")
  {
    $query_head = "INSERT INTO " . $table . "(";
    $query_body = " VALUES(";
    foreach ($data as $key => $value) {

      $query_body .= "'" . $value . "',";
      $query_head .= $key . ',';
    }
    $query_head = rtrim($query_head, ",") . ") ";
    $query_body = rtrim($query_body, ",") . ")";
    return $query_head . $query_body;
  }

  protected function getUserID($data)
  {
    $query = "SELECT MAX(ID) AS 'ID' FROM users WHERE Email='${data['Email']}' AND Psw='${data['Psw']}'";
    $rez = mysql_query($query) or die(mysql_error());

    $row = mysql_fetch_array($rez);
    return $row['ID'];
  }
}
