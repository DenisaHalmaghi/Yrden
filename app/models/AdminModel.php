<?php

class AdminModel extends Model
{
  public function __construct()
  {
    parent::__construct();
  }

  function queryDb($sql)
  {
    if (isset($_SESSION['Type']) && $_SESSION['Type'] == "admin") {
      $rez = mysql_query($sql) or die(mysql_error());
      return $rez;
    }

    echo "<p>Nu esti admin!!</p>";
  }

  public function deleteReview($id)
  {

    $sql = "SELECT ProductID from reviews WHERE ID=$id";

    $rez = $this->queryDb($sql);
    $rez = mysql_fetch_array($rez);
    $prID = $rez['ProductID'];
    $sql = "DELETE FROM reviews WHERE ID = $id";
    $this->queryDb($sql);

    $sql = "UPDATE products SET Rating = (SELECT AVG(Rating) from reviews WHERE ProductID =$prID) WHERE ID=$prID";

    $this->queryDb($sql);
  }

  public function getAllUserOrders($status)
  {
    $sql = "SELECT *,SUM(Price*Qty) as Total FROM orders_view WHERE  OrderStatus like '%$status%' GROUP BY ORDERID";
    return $this->queryDb($sql);
  }

  public function deleteCategory($id)
  {
    $sql = "DELETE FROM categories WHERE ID=$id";
    return $this->queryDb($sql);
  }

  public function updateOrderStatus($id, $status)
  {
    $sql = "UPDATE user_orders SET OrderStatus=$status WHERE ID=$id";
    return $this->queryDb($sql);
  }

  public function getAllUsers()
  {
    $sql = "SELECT * FROM users";
    return $this->queryDb($sql);
  }

  public function getCategories()
  {
    $sql = "SELECT * FROM categories";
    return $this->queryDb($sql);
  }

  public function addProduct($data)
  {
    return $this->queryDb($this->prepareInsertQuery($data, "products"));
  }

  public function updateProduct($data, $id)
  {
    return $this->queryDb($this->buildUpdateQuery($data, "products", $id));
  }

  public function buildUpdateQuery($data, $table, $id)
  {
    $sql = "Update $table SET ";
    foreach ($data as $key => $value) {
      $sql .= "$key= '$value',";
    }
    return rtrim($sql, ",") . "WHERE ID=$id";
  }

  public function getProductByID($id)
  {

    $sql = "SELECT * FROM products WHERE ID=" . $id;
    return $this->queryDb($sql);
  }

  public function getProducts($product, $category = null)
  {
    if ($category) {
      $condition = "AND CategoryID=$category";
    }
    $sql = "SELECT * FROM products WHERE Product LIKE '%" . $product . "%' $condition order by id desc";

    return $this->queryDb($sql);
  }

  public function getProduct($id)
  {

    $sql = "SELECT * FROM products WHERE ID=$id";
    return $this->queryDb($sql);
  }

  public function deleteProduct($id)
  {
    $sql = "UPDATE products SET Deleted=1 WHERE ID=$id";
    return $this->queryDb($sql);
  }

  public function restoreProduct($id)
  {
    $sql = "UPDATE products SET Deleted=0 WHERE ID=$id";
    return $this->queryDb($sql);
  }

  public function addCategory($data)
  {
    $sql = "INSERT INTO categories (Category) VALUES ('" . $data['Category'] . "')";
    return $this->queryDb($sql);
  }

  public function updateCategory($data)
  {
    $id = $data['ID'];
    $name = $data['Category'];
    $sql = "UPDATE categories SET Category='$name' WHERE ID=$id";
    return $this->queryDb($sql);
  }

  public function getCategory($id)
  {
    $sql = "SELECT * FROM categories WHERE ID=$id";
    return $this->queryDb($sql);
  }
}
