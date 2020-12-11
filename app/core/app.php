<?php


class app
{

  protected $controller = "home";
  protected $method = "index";
  protected $params = array();
  public function __construct()
  {

    $url_parts = $this->parseUrl();
    if ($url_parts && file_exists("../app/controllers/${url_parts[0]}.php")) {
      $this->controller = $url_parts[0];
      unset($url_parts[0]);
    } else {
      $url_parts = array();
    }

    require_once "../app/controllers/" . $this->controller . ".php";

    $this->controller = new $this->controller;

    if (sizeof($url_parts)) {
      if (method_exists($this->controller, $url_parts[1])) {

        $this->method = $url_parts[1];
        unset($url_parts[1]);
      }
    }

    if ($url_parts) $this->params = $url_parts;

    if (!$red = $this->controller->guard()) {
      call_user_func_array(array($this->controller, $this->method), $this->params);
    } else {

      $this->controller->redirect($red);
    }
  }

  protected function parseUrl()
  {
    if (isset($_GET['url'])) {
      $url = $_GET['url'];

      if (!$url) {
        return array();
      }
      return  explode("/", filter_var(rtrim($url, "/"), FILTER_SANITIZE_URL));
    }
  }
}
