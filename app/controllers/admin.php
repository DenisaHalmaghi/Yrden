<?php

class Admin extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $this->loadView("admin/dashboard");
  }

  public function guard()
  {
    if ($_SESSION['Type'] == 'admin') {
      return FALSE;
    }
    return "home/login";
  }


  public function logout()
  {

    $this->util->endSession();
    $this->redirect("home/login");
  }

  public function addProduct()
  {
    $model = $this->getModel("AdminModel");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if ($this->util->checkProductInfo()) {
        $model->addProduct($_SESSION['data']);
        unset($_SESSION['data']);
        $_SESSION['data']['result'] = "Added successfully!";
        return $this->redirect("admin/getProducts");
      }
      return $this->redirect("admin/addProduct");
    }
    $data['categories'] = $model->getCategories();
    $data['file'] = 'productForm';
    $data['operation'] = "add";
    $data['header'] = 'products';

    $this->loadView("admin/dashboard", $data);
  }

  public function updateProduct($productID)
  {
    $model = $this->getModel("AdminModel");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if ($this->util->checkProductInfo()) {
        $model->updateProduct($_SESSION['data'], $productID);

        $_SESSION['data']['result'] = "Updated successfully!";

        return $this->redirect("admin/product/$productID");
      }

      return $this->redirect($this->util->getPrevURL());
    }

    $data['categories'] = $model->getCategories();
    $rez = $model->getProductByID($productID);
    $_SESSION['data'] = mysql_fetch_array($rez);
    $data['id'] = $productID;
    $data['file'] = 'productForm';
    $data['header'] = 'products';
    $data['operation'] = "update";
    $this->loadView("admin/dashboard", $data);
  }

  public function getProducts()
  {
    $model = $this->getModel("AdminModel");
    if (isset($_GET['Product'])) {
      $data['product'] = $this->util->sanitize($_GET['Product']);
    }
    if (isset($_GET['CategoryID']) && $this->util->is_positive_integer($_GET['CategoryID'])) {
      $data['category']  = $_GET['CategoryID'];
    }

    $data['categories'] = $model->getCategories();
    $data['products'] = $model->getProducts($data['product'], $data['category']);
    $data['file'] = 'products';
    $data['header'] = 'products';
    $this->loadView("admin/dashboard", $data);
  }

  public function deleteProduct($id)
  {

    if ($this->util->is_positive_integer($id)) {
      $this->getModel("AdminModel")->deleteProduct($id);
    }
    $prev = $this->util->getPrevURL_preserveQueries();
    $prev = str_replace("home/", "admin/", $prev);

    return $this->redirect($prev);
  }

  public function restoreProduct($id)
  {

    if ($this->util->is_positive_integer($id)) {
      $this->getModel("AdminModel")->restoreProduct($id);
    }
    $prev = $this->util->getPrevURL_preserveQueries();
    $prev = str_replace("home/", "admin/", $prev);
    return $this->redirect($prev);
  }

  public function deleteReview($id)
  {
    $prev = $this->util->getPrevURL();

    if ($this->util->is_positive_integer($id)) {
      $this->getModel("AdminModel")->deleteReview($id);
    }

    return $this->redirect($prev . "#reviews");
  }

  public function product($productID)
  {
    if ($this->util->is_positive_integer($productID)) {

      $data["products"] = $this->getModel("AdminModel")->getProduct($productID);
      $data["reviews"] = $this->getModel("General")->getProductReviews($productID);
      $this->loadView("product", $data);
    }
  }


  public function orders($status = "")
  {

    $data['orders'] = $this->getModel("AdminModel")->getAllUserOrders($status);
    $data['file'] = 'orders';
    $data['header'] = 'orders';

    $this->loadView("admin/dashboard", $data);
  }

  public function updateOrder($orderID, $status = 0)
  {
    if ($this->util->is_positive_integer($orderID) && in_array($status, array(0, 1))) {
      $this->getModel("AdminModel")->updateOrderStatus($orderID, $status);
    }

    $this->redirect($this->util->getPrevURL());
  }

  public function categories($status = "")
  {

    $data['orders'] = $this->getModel("AdminModel")->getAllUserOrders($status);
    $data['file'] = 'categories';
    $data['header'] = 'categories';

    $data['categories'] = $this->getModel("General")->getCategories();
    $this->loadView("admin/dashboard", $data);
  }


  public function addCategory()
  {
    $model = $this->getModel("AdminModel");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if ($this->util->checkCategoryInfo()) {
        $model->addCategory($_SESSION['data']);
        unset($_SESSION['data']);
        $_SESSION['data']['result'] = "Added successfully!";
      }
      return $this->redirect("admin/addCategory");
    }

    $data['file'] = 'categoryForm';
    $data['operation'] = "add";
    $data['header'] = 'categories';

    $this->loadView("admin/dashboard", $data);
  }

  public function updateCategory($id)
  {
    $model = $this->getModel("AdminModel");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if ($this->util->checkCategoryInfo()) {
        $_SESSION['data']['ID'] = $id;
        $model->updateCategory($_SESSION['data']);
        unset($_SESSION['data']);
        $_SESSION['data']['result'] = "Updated successfully!";
      } else {
        return $this->redirect("admin/updateCategory/$id");
      }
      return $this->redirect("admin/categories");
    }

    if (!isset($_SESSION['data'])) {
      $rez = $model->getCategory($id);

      $_SESSION['data'] = mysql_fetch_array($rez);
    }

    $data['file'] = 'categoryForm';
    $data['id'] = $id;
    $data['operation'] = "update";
    $data['header'] = 'categories';

    $this->loadView("admin/dashboard", $data);
  }

  public function deleteCategory($id)
  {
    if ($this->util->is_positive_integer($id)) {
      $this->getModel("AdminModel")->deleteCategory($id);
    }
    $this->redirect("admin/categories/");
  }
}
