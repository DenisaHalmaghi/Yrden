<?php

class Util_View
{

  public function printQueryResult($rez)
  {
    while ($row = mysql_fetch_array($rez)) {
      print_r($row);
      echo "<br>";
    }
  }

  public function calculateCurrentPrice($fullPrice, $discount)
  {
    return $fullPrice * (1 - $discount / 100);
  }



  public function checkIfErrorExists($errorName)
  {
    if (isset($_SESSION['errors']) && isset($_SESSION['errors'][$errorName])) {
      return $_SESSION['errors'][$errorName];
    }
    return FALSE;
  }

  public function checkIfDataExists($dataName)
  {
    if (isset($_SESSION['data']) && isset($_SESSION['data'][$dataName])) {
      return $_SESSION['data'][$dataName];
    }
    return FALSE;
  }

  public function printError($errorName)
  {

    if ($error = $this->checkIfErrorExists($errorName)) {

      echo "<p class='invalid'>$error</p>";
    }
  }

  public function printInputData($dataname)
  {
    if (($data = $this->checkIfDataExists($dataname)) !== FALSE) {

      echo "value='$data'";
    }
  }

  public function getError($errorName)
  {

    if ($error = $this->checkIfErrorExists($errorName)) {

      return "<p class='invalid'>$error</p>";
    }
  }

  public function getInputData($dataname)
  {

    if ($data = $this->checkIfDataExists($dataname)) {

      echo "value='$data'";
    }
  }

  public function buildAddressString($row)
  {
    $state = $row['State'];

    if ($state) {
      $state .= ", ";
    }
    return "${row['Address']}, ${row['County']}, $state ${row['City']},\n ${row['Country']} ${row['ZipCode']}";
  }

  public function buildOptions($data, $selected, $textKey)
  {
    $options = '<option value="" selected>Select your option</option>';

    while ($row = mysql_fetch_array($data)) {

      $id = $row['ID'];
      $selectedAttr = "";
      if ($id == $selected) {
        $selectedAttr = "selected";
      }
      $options .= "<option value='$id' $selectedAttr>${row[$textKey]}</option>";
    }

    return  $options;
  }

  function displayOrders($orders)
  {

    echo $data['orders'];
    $statuses = array("Pending", "Complete");
    if (!mysql_num_rows($orders)) {
      echo " <p class='ta-c c-prm bold'>There are no orders here yet</p>";
      return;
    }
    while ($row = mysql_fetch_array($orders)) {
      $address = $this->buildAddressString($row);
      $orderID = $row['OrderID'];
      $status = $statuses[$row['OrderStatus']];
      echo "
        <div class='card mb-1'>
            <div class='card__header centeredRow space-between'>
                <p>
                    <span class='badge'>$status</span> 
                    <span>$${row['Total']}</span>
                   
                </p>
                <a class='btn btn-primary btn--xsmall d-ib' href='./?url=user/orders/$orderID'>
                        <i class='fas fa-list'></i>
                    </a>
            </div>
            <div class='card__body'>
                <p class='card-text'><span class='eti'>Shipping address:</span> $address</p>
                <p><span class='eti'>Order Creation Time:</span> <time>${row['OrderDate']}</time> </p>

            </div>
        </div>
        ";
    }
  }

  function displayOrderDetails($details)
  {
    $oDet = "";
    if (!$details) {
      return  $oDet;
    }
    while ($product = mysql_fetch_array($details)) {

      $image = PRODUCTS_URL . $product['Image'];
      $productName = $product['ProductName'];
      $qty = $product['Qty'];
      $price = $product['Price'];
      $oDet .= "
        <div class='borderBottom order centeredRow'>
                    <img src='$image' height=90 alt='$productName'>
                    <p> $productName</p>
                    <p>$qty x $$price </p>                
        </div>
        ";
    }

    return $oDet;
  }
}
