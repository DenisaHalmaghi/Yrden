<?php

class General extends Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public function login($data)
  {

    $query = "SELECT * FROM users WHERE Email='${data['Email']}' AND Psw='${data['Psw']}'";

    $rez = $this->queryDb($query);
    if (mysql_num_rows($rez)) {
      $row = mysql_fetch_array($rez);

      return $row;
    }

    return 0;
  }

  public function signup($data)
  {

    $user_data = array_slice($data, 0, 5);
    $shipping_data = array_slice($data, 5);

    $finalQuery = $this->prepareInsertQuery($user_data);
    $this->queryDb($finalQuery);
    $id = $this->getUserID($user_data);

    $shipping_data["UserID"] = $id;
    $finalQuery = $this->prepareInsertQuery($shipping_data, "shipping_addresses");

    $this->queryDb($finalQuery);
  }

  public function checkEmailDuplicate($email)
  {
    $sql = "SELECT Name FROM users WHERE Email='$email' LIMIT 1";
    $rez = $this->queryDb($sql);
    if (mysql_num_rows($rez)) {
      return TRUE;
    }
    return FALSE;
  }

  public function getAllProducts()
  {
    $sql = "SELECT * FROM products WHERE Deleted=0";
    return $this->queryDb($sql);
  }

  public function getProductsByCategory($category)
  {
    $sql = "SELECT * FROM products WHERE Deleted=0 AND CategoryID=" . $category . " ORDER BY ID desc";
    return $this->queryDb($sql);
  }

  public function getProductByID($id)
  {

    $sql = "SELECT * FROM products WHERE Deleted=0 AND ID=" . $id;
    return $this->queryDb($sql);
  }

  public function getProducts($filters)
  {
    $name = $filters['name'];
    $min = $filters['min'];
    $max = $filters['max'];

    if (!$min && $min !== 0) {
      $min = -1;
    }

    if (!$max) {
      $max = PHP_INT_MAX;
    }
    $cat = $filters['cat'];
    if (!$cat) {
      $cat = "%%";
    }

    $sql = "SELECT * FROM products WHERE Deleted=0 AND Product like '%$name%' AND Price*(1-Discount/100)>=$min AND Price*(1-Discount/100)<=$max and CategoryID like '$cat' order by id desc";

    return $this->queryDb($sql);
  }

  public function checkStockAvailability($id, $qty)
  {

    $sql = "SELECT ID FROM products WHERE ID=$id AND Qty>=$qty";
    return $this->queryDb($sql);
  }


  public function getCategories()
  {
    $sql = "SELECT * FROM categories";
    return $this->queryDb($sql);
  }

  public function getCountries()
  {
    $sql = "SELECT ID,Country FROM countries";
    return $this->queryDb($sql);
  }

  public function getProductReviews($productID)
  {
    $sql = "SELECT Content,Rating,`TimeStamp`,`a`.ID,CONCAT(`b`.`Name`,' ',`b`.`Surname`) AS `ReviewerName`  FROM `reviews` `a` join `users` `b` ON(`a`.uSERid=`b`.ID) WHERE ProductID='$productID' ORDER BY  `TimeStamp` DESC";
    return $this->queryDb($sql);
  }
}
