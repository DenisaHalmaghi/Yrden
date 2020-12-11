<?php

class UserModel extends Model
{
  public function __construct()
  {
    parent::__construct();
  }

  function queryDb($sql)
  {
    if (isset($_SESSION['ID'])) {
      $rez = mysql_query($sql) or die(mysql_error());

      return $rez;
    }
    echo "trebuie sa fi logat";
  }

  public function signup_procedure($data)
  {
    $sql = "CALL `userSignup`('John','DOE','John','John','John','1','John','John','John','John','John')";
    echo $sql;

    $rez = mysql_query($sql) or die(mysql_error());
  }

  public function prepareParameters($data)
  {
    $parameters = "(";
    foreach ($data as $key => $value) {
      $parameters .= "@in_${key}='" . $value . "',";
    }

    return rtrim($parameters, ",") . ") ";
  }

  public function getShippingAddresses()
  {
    $id = $_SESSION['ID'];
    $sql = "SELECT *,`a`.ID AS ID FROM shipping_addresses `a` INNER JOIN countries `b` ON (`b`.ID=`a`.CountryID) WHERE `a`.UserID='$id' AND `a`.`Deleted`=0 order by `a`.id desc";

    return $this->queryDb($sql);
  }

  public function addShippingAddress($data)
  {

    $data["UserID"] = $_SESSION['ID'];
    $sql = $this->prepareInsertQuery($data, "shipping_addresses");
    return $this->queryDb($sql);
  }

  public function getMyOrders()
  {
    $sql = "SELECT OrderID,OrderStatus,OrderDate,Country,County,State,Address,ZipCode,City, SUM(Price*Qty) as Total FROM orders_view WHERE UserID=${_SESSION['ID']} GROUP BY ORDERID ORDER BY OrderDate DESC";
    return $this->queryDb($sql);
  }

  public function checkout($data)
  {
    $sql = "INSERT INTO user_orders (UserID,ShippingAddressID) VALUES (${_SESSION['ID']},${data['ShippingAddressID']})";

    $this->queryDb($sql);
    $orderid = $this->getLastInsertedID();
    $sql = "INSERT INTO order_details (OrderID,ProductID,Qty,Price) VALUES " . $this->prepareOrderDetailsInsertion($data['products'], $orderid);

    $this->queryDb($sql);
  }

  public function getLastInsertedID()
  {
    $sql = "SELECT LAST_INSERT_ID()";
    $rez = mysql_fetch_array($this->queryDb($sql));
    return $rez["LAST_INSERT_ID()"];
  }

  public function prepareOrderDetailsInsertion($data, $orderID)
  {
    $values = "";
    for ($i = 0; $i < sizeof($data); $i++) {
      $productInfo = $data[$i];
      $qty = $productInfo['Qty'];
      $id = $productInfo['ProductID'];
      //update stock qty for each product
      $sql = "Update products SET QTY=QTY-LEAST(QTY, $qty) WHERE ID =$id";
      $this->queryDb($sql);

      $values .= "($orderID,$id,$qty,${productInfo['Price']}),";
    }
    return rtrim($values, ",");
  }

  public function getOrderDetails($data)
  {
    $sql = "SELECT Qty,ProductName,Image,Price FROM orders_view WHERE OrderID=${data['OrderID']}";
    return $this->queryDb($sql);
  }


  public function addReview($data)
  {
    $data["UserID"] = $_SESSION['ID'];

    $this->queryDb($this->prepareInsertQuery($data, "reviews"));
    $sql = "UPDATE products set Rating = (SELECT AVG (`Rating`) from reviews WHERE ProductID=${data['ProductID']}) WHERE ID=${data['ProductID']}";
    $this->queryDb($sql);
  }

  public function getUserData()
  {
    $sql = "SELECT Name,Surname,Phone,Email FROM users WHERE ID=${_SESSION['ID']}";
    return $this->queryDb($sql);
  }

  public function getProductsbyIDs($ids)
  {

    $sql = "SELECT * FROM PRODUCTS WHERE ID IN $ids";
    return $this->queryDb($sql);
  }


  public function updateUserData($data)
  {
    $email = $data['Email'];
    $name = $data['Name'];
    $surname = $data['Surname'];
    $phone = $data['Phone'];
    $psw = $data['Psw'];
    $sql = "UPDATE users SET Email='$email',Name='$name',Surname='$surname',Phone='$phone',Psw='$psw' WHERE ID=${_SESSION['ID']}";

    return $this->queryDb($sql);
  }

  public function deleteAddress($id)
  {
    $sql = "UPDATE shipping_addresses SET `Deleted`=1 WHERE UserID=${_SESSION['ID']} and ID=$id";

    return $this->queryDb($sql);
  }
}
