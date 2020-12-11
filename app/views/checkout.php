<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo ASSET_URL . "css/index.css" ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo ASSET_URL . "css/cart.css" ?>" type="text/css">
    <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" type="text/css">
    <title>Cart</title>
</head>

<body class="underHeader">

    <?php include_once "../app/views/components/header.php"; ?>

    <div class="fit-footer">

        <div class=" w-sm-11 w-lg-8 w-xl-6 pageContainer mx-auto fit-Footer wrap">
            <h1 class="c-prm  mb-1 ta-c">Checkout</h1>
            <br>
            <div class=" mb-1 mt-1">

                <!-- <h4 class='mt-1 mb-1'></h4> -->

                <?php
                if (isset($_GET['showForm'])) {
                    echo "
                    <form method='POST' action='./?url=user/addShippingAddress'>
                        
                        <div class='form__input'>
                            <label for='cid'>Country:</label>
                            <select id='cid' class='select' name='country'>
                                " . $viewUtil->buildOptions($data['countries'], $viewUtil->checkIfDataExists('CountryID'), "Country") . " 
                            </select>
                            " . $viewUtil->getError('country') . "
                        </div>
                
                        <div class='form__input '>
                            <label for='City'>City:</label>
                            <input class='input' id='City' name='city' type='text' value='" . $viewUtil->checkIfDataExists('City') . "'>
                            " . $viewUtil->getError('city') . " 
                        </div>

                        <div class='form__input'>
                            <label for='state'>State:</label>
                            <input class='input' id='state' name='state' type='text' value='" . $viewUtil->checkIfDataExists('State') . "'>
                            " . $viewUtil->getError('state') . "
                        </div>


                        <div class='form__input'>
                            <label for='address'>Address:</label>
                            <input class='input' id='address' name='address' type='text' value='" . $viewUtil->checkIfDataExists('Address') . "'>
                            " . $viewUtil->getError('address') . "
                        </div>

                        <div class='form__input'>
                            <label for='county'>County:</label>
                            <input class='input' id='county' name='county' type='text' value='" . $viewUtil->checkIfDataExists('County') . "'>
                            " . $viewUtil->getError('county') . " </div>

                        <div class='form__input'>
                            <label for='state'>Zip Code:</label>
                            <input class='input' id='state' name='zip' type='text' value='" . $viewUtil->checkIfDataExists('ZipCode') . "'>
                            " . $viewUtil->getError('zip') . "
                        </div>


                        <button type='submit' class='w-12 uppercase btn btn-primary mx-auto mb-1 mt-1'>Use this address</button>
                        
                    </form>";
                } else {
                    $options = '';
                    while ($row = mysql_fetch_array($data['addresses'])) {
                        $text = $viewUtil->buildAddressString($row);
                        $id = $row['ID'];
                        $options .= "<option value='$id'>$text</option>";
                    }
                    echo "
                  <form id='checkout-form' class='w-12 row wrap' method='POST' action='./?url=user/submitOrder'>

                        <label for='shadd'>Shipping Details:</label>
                        <select class='select w-12' id='shadd' name='address'>
                            $options;
                        </select>
                        " . $viewUtil->getError('ShippingAddressID') . "
                    </form>
                   
                <a href='./?url=user/checkout&showForm' class='btn btn-primary mb-1 mt-1'>I want to ship to another address</a>";
                }
                ?>
                <br>
                <h3 class='mt-1 mb-1'><span class="c-prm">Payment type:</span> Cash upon delivery</h3>
            </div>
            <h3 class="c-prm">Order summary:</h3>
            <div>
                <table class="cart-table mx-auto w-12">
                    <thead class="c-prm">
                        <tr>
                            <th>Item</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cartItems = "";
                        // if(!$_SESSION['itemsInCart'] ){
                        //   //  echo "";
                        //    $cartItems="<tr><td></td><td colspan='2' class='ta-c'>No items in cart</td><td></td></tr>";
                        // }
                        // else{
                        while ($row = mysql_fetch_array($data['products'])) {
                            $id = $row['ID'];
                            $item = $_SESSION['cart'][$id];
                            $itemName = $item['name'];
                            $itemPrice = $viewUtil->calculateCurrentPrice($item['Price'], $item['discount']);
                            $itemQty = $item['Qty'];
                            $totalPrice += $itemPrice * $itemQty;
                            $total = $itemQty * $itemPrice;
                            $availability = ($row['Qty'] >= $itemQty) ? "In stock" : "Not in stock";
                            $cartItems .= "<tr>
                                <td> $itemName <b>($availability)</b> </td>
                                <td>$$itemPrice</td>
                                <td> $itemQty</td>
                                <td align=right>$$total</td>
                            </tr>";
                        }
                        $cartItems .= "
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td >TOTAL :</td>
                                    <td align=right colspan=3>$$totalPrice</td>
                                </tr>
                            </tfoot>";


                        // $cartItems=array_reduce($_SESSION['cart'],"createCartItem");
                        echo $cartItems; ?>


                </table>
                <button type="submit" form="checkout-form" class="btn btn-primary mx-auto w-12 w-md-6 w-lg-5">Checkout</button>
            </div>

        </div>
    </div>
    </div>
    <?php include_once "../app/views/components/footer.php"; ?>
</body>

</html>