<?php

class Home extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {

    $this->loadView("index");
  }

  public function products()
  {
    $model = $this->getModel("General");
    $data = $this->util->sanitize($_GET);

    if ($this->util->checkFilters($data)) {
      $data["products"] = $model->getProducts($data);
      $_SESSION['data'] = $data;
    } else {
      $this->redirect($this->util->getPrevURL());
    }

    $data["categories"] = $model->getCategories();
    $this->loadView("products", $data);
  }

  public function product($productID)
  {
    if ($this->util->is_positive_integer($productID)) {
      $model = $this->getModel("General");
      $data["products"] = $model->getProductByID($productID);
      if (mysql_num_rows($data["products"])) {
        $data["reviews"] = $model->getProductReviews($productID);
        $this->loadView("product", $data);
      } else {
        $this->redirect($this->util->getPrevURL());
      }
    }
  }

  public function addProductToCart()
  {

    $data = $this->util->sanitize($_POST);

    $productID = $data['ProductID'];
    if (!$this->util->is_positive_integer(($productID))) {
      return $this->redirect($this->util->getPrevURL());
    }
    $qty = $data['Qty'];

    if (!$this->util->is_positive_integer($qty) || $qty > 10000) {
      $_SESSION['errors']['qty'] = "Please choose a valid quantity";
      return $this->redirect("home/product/$productID");
    }

    if (!isset($_SESSION['cart'][$productID])) {
      //query db for product info
      $_SESSION['cart'][$productID] = array();
      $_SESSION['cart'][$productID]['Qty'] = 0;
      $model = $this->getModel("General");
      $rez = $model->getProductByID($productID);
      $productInfo = mysql_fetch_array($rez);
      $_SESSION['cart'][$productID]['image'] = $productInfo['Image'];
      $_SESSION['cart'][$productID]['name'] = $productInfo['Product'];
      $_SESSION['cart'][$productID]['Price'] = $this->util->calculateCurrentPrice($productInfo['Price'], $productInfo['Discount']);
    }

    $_SESSION['cart'][$productID]['Qty'] += $qty;
    $_SESSION['itemsInCart'] += $qty;
    return $this->redirect('home/cart');
  }


  public function login($data = null)
  {
    if ($this->util->isLoggedIn()) {
      return $this->redirect($_SESSION['Type']);
    }
    if (sizeof($_POST)) {
      if (!$this->util->checkLoginInfo()) {
        return $this->redirect("home/login");
      }
      $model = $this->getModel("General");
      if ($rez = $model->login($_SESSION['data'])) {
        $this->util->startSession($rez);
        unset($_SESSION['data']);
        return $this->redirect($_SESSION['Type']);
      } else {
        $_SESSION['errors']['login'] = "This user doesn\'t exist";
        return $this->redirect("home/login");
      }

      return;
    }

    $this->loadView("login", $data);
  }

  public function signup($data = null)
  {
    if ($this->util->isLoggedIn()) {
      return $this->redirect($_SESSION['Type']);
    }
    $model = $this->getModel("General");
    $data['countries'] = $model->getCountries();
    if (sizeof($_POST)) {
      if (!$this->util->checkSignUpInfo()) {
        return $this->redirect("home/signup");
      }
      if (!$model->checkEmailDuplicate($_SESSION['data']["Email"])) {
        $model->signup($_SESSION['data']);
        return $this->redirect("home/login");
      }
      $_SESSION['errors']["email"] = "This email has already been registered";
      $this->redirect("home/signup");

      return;
    }

    $this->loadView("signup", $data);
  }

  public function cart()
  {
    $this->loadView("cart");
  }



  public function updateCart()
  {
    if (isset($_POST['deletedID'])) {
      $id = $_POST['deletedID'];

      if (($this->util->is_positive_integer($id)) && isset($_SESSION['cart'][$id])) {
        $qty = $_SESSION['cart'][$id]['Qty'];
        unset($_SESSION['cart'][$id]);
        $_SESSION['itemsInCart'] -= $qty;
      }
    } else if (isset($_POST['id']) && $this->util->is_positive_integer($_POST['id'])) {

      $data = $this->util->sanitize($_POST);
      $id = $data['id'];
      $qty = $data['Qty'];
      if ($this->util->is_positive_integer($qty)) {
        $diff = $qty - $_SESSION['cart'][$id]['Qty'];

        $_SESSION['cart'][$id]['Qty'] += $diff;
        $_SESSION['itemsInCart'] += $diff;
      }
    }
    $this->redirect('home/cart');
  }
}
