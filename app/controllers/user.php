<?php

class User extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $this->loadView("myAccount");
  }

  public function guard()
  {
    if ($this->util->isLoggedIn()) {
      return FALSE;
    }
    return "home/login";
  }


  public function logout()
  {

    $this->util->endSession();
    $this->redirect("home/login");
  }


  public function checkout()
  {
    if (!$_SESSION['itemsInCart']) {
      return $this->redirect('home/cart');
    }

    $model = $this->getModel("UserModel");
    $ids = "(";
    foreach ($_SESSION['cart'] as $key => $value) {

      $ids .= $key . ",";
    }

    $ids = rtrim($ids, ",") . ")";
    $data['products'] = $model->getProductsbyIDs($ids);
    $data['addresses'] = $model->getShippingAddresses();
    $data['countries'] = $this->getModel("General")->getCountries();

    $this->loadView("checkout", $data);
  }

  public function addShippingAddress()
  {

    $rez = $this->util->checkAddressInfo();
    if (!$rez) {
      return $this->redirect("user/checkout&showForm");
    }
    $model = $this->getModel("UserModel");
    $model->addShippingAddress($_SESSION['data']);
    return $this->redirect("user/checkout");
  }


  public function submitOrder()
  {
    $data['products'] = array();
    foreach ($_SESSION['cart'] as $id => $product) {
      array_push($data['products'], array("ProductID" => $id, "Qty" => $product['Qty'], "Price" => $product['Price']));
    }
    if (is_numeric($_POST['address'])) {
      $data['ShippingAddressID'] = $_POST['address'];
      $model = $this->getModel("UserModel");
      $model->checkout($data);
      unset($_SESSION['cart']);
      unset($_SESSION['itemsInCart']);
    } else {
      $_SESSION['errors']['ShippingAddressID'] = "You must select an address to ship to";
      return $this->redirect('user/checkout');
    }

    $this->redirect('user/orders');
  }

  public function orders($orderID = null)
  {
    $data['orders'] = null;
    $data['orderDetails'] = null;
    $model = $this->getModel("UserModel");

    if (!$orderID) {
      $data['orders'] = $model->getMyOrders();
    } else {
      if (is_numeric($orderID)) {
        $data['orderDetails'] = $model->getOrderDetails($orderID);
      }
    }
    $data['file'] = 'orders';
    $this->loadView("myAccount", $data);
  }

  public function settings()
  {

    if (!isset($_SESSION['data']) && !isset($_SESSION['data']['Email'])) {
      $rez = $this->getModel("UserModel")->getUserData();
      $row = mysql_fetch_array($rez);
      $_SESSION['data'] = $row;
    }

    $data['file'] = 'settings';

    $this->loadView("myAccount", $data);
  }

  public function updateInfo()
  {
    if ($this->util->checkUserInfo()) {
      if (!$this->getModel("General")->checkEmailDuplicate($_SESSION['data']["Email"])) {
        $this->getModel("UserModel")->updateUserData($_SESSION['data']);
        $_SESSION['data']['result'] = "Updated successfully!";
      } else {
        $_SESSION['errors']['email'] = "This email is already taken!";
      }
    }
    $this->redirect('user/settings');
  }

  public function addReview()
  {
    $bookmark = "";
    $data = $this->util->sanitize($_POST);
    $productID = $data['ProductID'];

    if (is_numeric($productID)) {
      $errors = array();
      if (!isset($data['Rating']) || !is_numeric($data['Rating'])) {
        $errors['Rating'] = "You must rate the product";
      }
      if (empty($data['Content'])) {
        $errors['Content'] = "You must provide some text for your review";
      }
      if (!count($errors)) {
        if ($data['Rating'] > 5) {
          $data['Rating'] = 5;
        }
        $bookmark = "#reviews";
        $this->getModel("UserModel")->addReview($data);
      } else {
        $_SESSION['errors'] = $errors;
        $_SESSION['data'] = $data;
      }
    }
    return $this->redirect('home/product/' . $productID . $bookmark);
  }


  public function addresses()
  {
    $data['addresses'] = $this->getModel("UserModel")->getShippingAddresses();

    $data['file'] = 'addresses';

    $this->loadView("myAccount", $data);
  }

  public function deleteAddress()
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addressID']) && is_numeric($_POST['addressID'])) {
      $this->getModel("UserModel")->deleteAddress($_POST['addressID']);
    }
    return $this->redirect('user/addresses');
  }
}
