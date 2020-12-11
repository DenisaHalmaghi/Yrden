<?php

class Controller
{

  protected $util;
  protected $homeUrl;
  public function __construct()
  {
    $this->util = new Util_Controller;
    require_once "../app/constants/urls.php";
  }

  protected function getModel($name)
  {

    if (file_exists("../app/models/$name.php")) {
      require_once "../app/models/" . $name . ".php";
      return new $name;
    } else {
      echo "nu exista modelul";
    }
  }

  protected function loadView($view, $data = array())
  {
    if (file_exists("../app/views/$view.php")) {
      $viewUtil = new Util_View;
      require_once "../app/views/" . $view . ".php";
    } else {
      echo "nu exista view-ul";
    }
    unset($_SESSION['errors']);
    unset($_SESSION['data']);
  }

  public function redirect($path)
  {
    header("Location:./?url=$path");
  }

  public function guard()
  {
    return FALSE;
  }
}
