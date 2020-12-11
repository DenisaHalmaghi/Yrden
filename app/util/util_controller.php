<?php

class Util_Controller
{
  public  function sanitize($data)
  {
    if (is_array($data)) {
      foreach ($data as $var => $val) {
        $data[$var] = $this->sanitize($val);
      }
    } else {
      // remove whitespaces (not a must though)
      $data = trim($data);

      // apply stripslashes if magic_quotes_gpc is enabled
      if (get_magic_quotes_gpc()) {
        $data = stripslashes($data);
      }
      // curatire p. atacuri XSS cros site scripting 
      $data = $this->cleanInput($data);
      $data = htmlspecialchars($data);
      // transforma caracterele speciale in escape (\x00, \n, \r, \, ', " and \x1a.) 
      $data = mysql_escape_string($data);
    }

    return $data;
  }

  public function test_input($data)
  { // testare si curatire data intrare 
    $data = trim($data); // elimina spatii inceput si sfarsit
    $data = stripslashes($data); // elimina backslash
    $data = htmlspecialchars($data); // pune caractere speciale conform html
    return $data;
  }

  public  function cleanInput($input)
  {
    // curatire pt. atacuri XSS cros site scripting 
    $search = array(
      // Strip out javascript
      '/(<[\/\!]*?[^<>]*?>)+/', // Strip out HTML tags
'/<style[^>]*?>.*?<\ /style>/', // Strip style tags properly
    '/
    <![\s\S]*?--[ \t\n\r]*>/'
    );
    $output = preg_replace($search, 'fuck', $input);

    return $output;
  }
  public  function curata($data)
  { // curatire contra SQL Injection si XSS(cross site scripting)	
    $data  = $this->cleanInput($data); // curatire pt. atacuri XSS cros site scripting 
    // a mySQL connection is required before using this function
    // transforma caracterele speciale in escape (\x00, \n, \r, \, ', " and \x1a.) 
    // $data = mysql_real_escape_string($data);
    return $data;
  }

  public function checkPhone($phone)
  {
    $regExp = '/^\+?[0-9]{1,2}-?[0-9]{3}-?[0-9]{3}-?[0-9]{4}$/';
    return preg_match($regExp, $phone);
  }

  public function startSession($userData)
  {

    if ($userData["ID"]) {
      if (session_start()) {
        session_regenerate_id(true);
        $_SESSION['ID'] = $userData["ID"];
        $_SESSION['Type'] = $userData["UserType"];
      } else {
        echo "could not start session";
      }
    }
  }



  public function endSession()
  {
    session_destroy();
  }

  public function printQueryResult($rez)
  {
    while ($row = mysql_fetch_array($rez)) {
      print_r($row);
      echo "<br>";
    }
  }

  protected function checkPswValidity(&$userData, &$errors)
  {

    if (empty($_POST["passw"])) {
      $errors['psw'] = "The password is mandatory";
    } else {
      $userData['Psw'] = $this->sanitize($_POST["passw"]);
      if (strlen($userData['Psw']) < 6) {
        $errors['psw'] = "The password has to be at least 6 characters long";
      } elseif (!preg_match("/^[a-zA-Z1-9]*$/", $userData['Psw'])) {
        // check if name only contains letters and whitespace
        $errors['psw'] = "Only letters and numbers are allowed";
      }
    }
  }

  protected function checkEmailValidity(&$userData, &$errors)
  {
    if (empty($_POST["email"])) {
      $errors['email'] = "The E-mail is mandatory";
    } else {
      $userData['Email'] = $this->sanitize($_POST["email"]);

      if (!filter_var($userData['Email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid E-mail format";
      }
    }
  }

  public function isLoggedIn()
  {
    return isset($_SESSION['ID']);
  }

  public function checkName($name)
  {
    return preg_match("/^[a-zA-Z]{3,}([- ]{1}){0,1}(?(1)[a-zA-Z]{3,})$/", $name);
  }

  public function checkLoginInfo()
  {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $errors = array();
      $userData = array();
      $this->checkPswValidity($userData, $errors);
      $this->checkEmailValidity($userData, $errors);


      if (!count($errors)) {
        $userData['Psw'] = md5($userData['Psw']);
        $_SESSION['data'] = $userData;
        return 1;
      } else {
        if (isset($userData['Psw'])) {
          unset($userData['Psw']);
        }

        $_SESSION['errors'] = $errors;
        $_SESSION['data'] = $userData;
        return 0;
      }
    }
  }


  public function checkAddressInfo()
  {
    $errors = array();
    $userData = array();
    $this->sanitizeAddressInfo($userData, $errors);

    if (!count($errors)) {
      $_SESSION['data'] = $userData;
      return 1;
    } else {

      $_SESSION['errors'] = $errors;
      $_SESSION['data'] = $userData;
      return 0;
    }
  }

  public function sanitizeAddressInfo(&$userData, &$errors)
  {
    if (empty($_POST["country"])) {
      $errors['country'] = "Country is mandatory";
    } else {
      $userData['CountryID'] = $this->sanitize($_POST["country"]);
      if (!is_numeric($userData['CountryID'])) {
        $errors['country'] = "Invalid country format";
      }
    }

    if (!empty($_POST["state"])) {
      $userData['State'] = $this->sanitize($_POST["state"]);

      if (!preg_match("/^[a-zA-Z]{3,}$/", $userData['State'])) {
        $errors['state'] = "Invalid state format";
      }
    }

    if (empty($_POST["county"])) {
      $errors['county'] = "County is mandatory";
    } else {
      $userData['County'] = $this->sanitize($_POST["county"]);
      if (!preg_match("/^[a-zA-Z]{3,}$/", $userData['County'])) {
        $errors['county'] = "Invalid county format";
      }
    }

    if (empty($_POST["city"])) {
      $errors['city'] = "City is madatory";
    } else {
      $userData['City'] = $this->sanitize($_POST["city"]);
      if (!preg_match("/^[a-zA-Z]{3,}$/", $userData['City'])) {
        $errors['city'] = "Invalid city format";
      }
    }

    if (empty($_POST["address"])) {
      $errors['address'] = "Address is mandatory";
    } else {
      $userData['Address'] = $this->sanitize($_POST["address"]);

      if (!preg_match("/^[a-zA-Z 1-9]{6,}$/", $userData['Address'])) {
        $errors['address'] = "Invalid address format";
      }
    }

    if (empty($_POST["zip"])) {
      $errors['zip'] = "Zip Code is mandatory";
    } else {
      $userData['ZipCode'] = $this->sanitize($_POST["zip"]);

      if (!preg_match("/^[1-9]{6,9}$/", $userData['ZipCode'])) {
        $errors['zip'] = "Invalid Zip code";
      }
    }
  }

  public function sanitizeUserInfo(&$userData, &$errors)
  {
    if (empty($_POST["name"])) {
      $errors['name'] = "Name is mandatory";
    } else {
      $userData['Name'] = $this->sanitize($_POST["name"]);
      // check if name only contains letters and whitespace
      if (!$this->checkName($userData['Name'])) {
        $errors['name'] = "Name must be valid";
      }
    }

    if (empty($_POST["surname"])) {
      $errors['surname'] = "Surname is mandatory";
    } else {
      $userData['Surname'] = $this->sanitize($_POST["surname"]);
      // check if name only contains letters and whitespace
      if (!$this->checkName($userData['Surname'])) {
        $errors['surname'] = "Surname must be valid";
      }
    }

    if (empty($_POST["c_passw"])) {
      $errors['c_passw'] = "Password must be confirmed";
    } else {
      $cp = $_POST["c_passw"];
      $p = $_POST["passw"];
      if ($p != $cp) {
        $errors['c_passw'] = "Passwords must match";
      }
    }

    $this->checkPswValidity($userData, $errors);
    $this->checkEmailValidity($userData, $errors);

    if (empty($_POST["phone"])) {
      $errors['phone'] = "Phone number is mandatory";
    } else {
      $userData['Phone'] = $this->sanitize($_POST["phone"]);

      if (!$this->checkPhone($userData['Phone'])) {
        $errors['phone'] = "Invalid phone format";
      }
    }
  }

  public function checkUserInfo()
  {
    $errors = array();
    $userData = array();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $this->sanitizeUserInfo($userData, $errors);


      if (!count($errors)) {

        $userData['Psw'] = md5($userData['Psw']);
        $_SESSION['data'] = $userData;
        unset($userData['Psw']);
        return 1;
      } else {
        if (isset($userData['Psw'])) {
          unset($userData['Psw']);
        }
        $_SESSION['errors'] = $errors;
        $_SESSION['data'] = $userData;
        return 0;
      }
    }
  }

  public function checkSignUpInfo()
  {
    $errors = array();
    $userData = array();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

      $this->sanitizeUserInfo($userData, $errors);
      $this->sanitizeAddressInfo($userData, $errors);

      if (!count($errors)) {
        $userData['Psw'] = md5($userData['Psw']);
        $_SESSION['data'] = $userData;
        return 1;
      } else {
        if (isset($userData['Psw'])) {
          unset($userData['Psw']);
        }
        $_SESSION['errors'] = $errors;
        $_SESSION['data'] = $userData;
        return 0;
      }
    }
  }

  public function calculateCurrentPrice($fullPrice, $discount)
  {
    return $fullPrice * (1 - $discount / 100);
  }

  public function checkProductInfo()
  {
    $errors = array();
    $userData = array();

    if (empty($_POST["Product"])) {
      $errors['product'] = "Product name is madatory";
    } else {
      $userData['Product'] = $this->sanitize($_POST["Product"]);

      if (!preg_match("/^[a-zA-Z]+[a-zA-Z ]{2,}$/", $userData['Product'])) {
        $errors['product'] = "Invalid product name";
      }
    }

    if (empty($_POST["Price"])) {
      $errors['price'] = "Price is madatory";
    } else {
      $userData['Price'] = $this->sanitize($_POST["Price"]);

      if (!preg_match("/^[1-9]+[.]?[0-9]*$/", $userData['Price'])) {
        $errors['price'] = "Price can only contain digits and \".\"";
      }
    }


    $userData['Discount'] = $this->sanitize($_POST["Discount"]);
    if (!preg_match("/^[0-9]*[.]?[0-9]{0,2}$/", $userData['Price'])) {
      $errors['discount'] = "Discount can only contain digits and \".\"";
    }

    if (!isset($_POST["Qty"])) {
      $errors['qty'] = "Qty is madatory";
    } else {
      $userData['Qty'] = $this->sanitize($_POST["Qty"]);

      if (!preg_match("/^[0-9]{1,6}$/", $userData['Qty'])) {
        $errors['qty'] = "Quantity can only be an integer";
      }
    }

    if (empty($_POST["CategoryID"])) {
      $errors['category'] = "CategoryID is madatory";
    } else {
      $userData['CategoryID'] = $this->sanitize($_POST["CategoryID"]);

      if (!preg_match("/^[1-9]+[0-9]*$/", $userData['CategoryID'])) {
        $errors['category'] = "CategoryID can only be an integer";
      }
    }

    if (empty($_POST["Image"])) {
      $errors['image'] = "Image is madatory";
    } else {
      $userData['Image'] = $this->sanitize($_POST["Image"]);

      if (!preg_match("/^[a-zA-Z_-]+[.]{1}[a-z]{3,4}$/", $userData['Image'])) {
        $errors['image'] = "Invalid image name";
      }
    }

    if (empty($_POST["Dimensions"])) {
      $errors['dimensions'] = "Dimensions are madatory";
    } else {
      $userData['Dimensions'] = $this->sanitize($_POST["Dimensions"]);

      if (!preg_match("/^(([1-9]+[0-9]*)[x]{1})(?1){1}(?2)$/", $userData['Dimensions'])) {
        $errors['dimensions'] = "Invalid dimensions";
      }
    }

    $userData['Description'] = $this->sanitize($_POST["Description"]);

    if (!count($errors)) {
      $_SESSION['data'] = $userData;
      return 1;
    } else {

      $_SESSION['errors'] = $errors;
      $_SESSION['data'] = $userData;
      return 0;
    }
  }

  public function is_positive_integer($str)
  {
    return (is_numeric($str) && $str > 0 && $str == round($str));
  }

  public function getPrevURL()
  {

    $url = explode("?", $_SERVER['HTTP_REFERER']);
    $url = explode("url=", $url[1]);
    $url = explode("&", $url[1]);
    return $url[0];
  }

  public function getPrevURL_preserveQueries()
  {

    $url = explode("?", $_SERVER['HTTP_REFERER']);

    $url = explode("url=", $url[1]);

    return $url[1];
  }

  public function checkCategoryInfo()
  {

    if (empty($_POST["Category"])) {
      $errors['cat'] = "Category name is madatory";
    } else {
      $userData['Category'] = $this->sanitize($_POST["Category"]);

      if (!preg_match("/^[a-zA-z]{3,}[a-zA-z -&]*$/", $userData['Category'])) {
        $errors['cat'] = "Invalid category name";
      }
    }

    if (!count($errors)) {
      $_SESSION['data'] = $userData;
      return 1;
    } else {
      $_SESSION['errors'] = $errors;
      $_SESSION['data'] = $userData;
      return 0;
    }
  }
  public function checkFilters($data)
  {
    if (!empty($data['min']) && !is_numeric($data['min'])) {
      return FALSE;
    }

    if (!empty($data['max']) && !is_numeric($data['max'])) {
      return FALSE;
    }

    if (!empty($data['cat']) && !$this->is_positive_integer($data['cat'])) {
      return FALSE;
    }
    $regExp = '/^[a-zA-z ]+$/';

    if (!empty($data['name']) && !preg_match($regExp, $data['name'])) {
      return FALSE;
    }
    return TRUE;
  }
}
