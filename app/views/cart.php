<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?php echo ASSET_URL."css/index.css" ?>" type="text/css">
        <link rel="stylesheet" href="<?php echo ASSET_URL."css/cart.css" ?>" type="text/css">
        <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
              type="text/css">

        <title>Cart</title>
    </head>

    <body class="underHeader">

        <?php include_once "../app/views/components/header.php";?>

        <div class="fit-footer">

            <div class=" w-sm-11 w-lg-8 w-xl-6 mx-auto wrap">
                <div class="w-12">
                    <h1 class="c-prm ta-c mb-1">Cart</h1>
                    <br>
                    
                    <?php 
                        $cartItems="";
                        if(!$_SESSION['itemsInCart'] ){
                            // echo "<tr ><td></td><td colspan='3' class='ta-c'>No items in cart</td><td></td></tr>";
                             $cartItems="<p class='ta-c c-prm bold uppercase'>No items in cart</p>";
                        }
                        else
                        {
                            $totalPrice=0;
                            $cartItems="<table class='cart-table mx-auto w-12'>
                            <thead class='c-prm'>
                                <tr>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>

                            </thead>
                            <tbody>";
                            foreach ($_SESSION['cart'] as $id => $item)
                            {
                                $itemImg=PRODUCTS_URL.$item['image'];
                                $itemName=$item['name'];
                                $itemPrice=$viewUtil->calculateCurrentPrice($item['Price'],$item['discount']);
                                $itemQty=$item['Qty'];
                                $totalPrice+=$itemPrice*$itemQty;
                                $total=$itemQty*$itemPrice;
                                $cartItems.=
                                "<tr>
                                    <td>
                                        <a href='./?url=home/product/$id'><img src='$itemImg' alt='$itemName'></a>
                                        <span>$itemName</span>
                                    </td>
                                    <td>$$itemPrice</td>
                                    <td>
                                        <form method='POST' action='./?url=home/updateCart'> 
                                            <input value='$id' name='id' type='number' hidden>
                                            <div class='input centeredRow'>
                                                <input type='number' name='Qty' min=1 value='$itemQty'> 
                                                <button type='submit' class='cart__submitBtn'><i class='fas fa-check'></i></button>
                                            </div>
                                        </form>
                                    </td>
                                    <td>$$total</td>
                                    <td> 
                                        <form method='POST' action='./?url=home/updateCart'> 
                                            <input name='deletedID' min='1' type='number' value='$id' hidden>
                                            <button type='submit' class='cart__submitBtn'><i class='fas fa-times'></i></button>
                                        </form>
                                    </td>
                                </tr>";
                            }
                        
                            $cartItems.="
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>TOTAL :</td>
                                        <td></td>
                                        <td></td>
                                        <td>$$totalPrice</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <a href='./?url=user/checkout' class='btn btn-primary mx-auto w-12'>Checkout</a>";
                        }
                        echo $cartItems;
                    ?>
                    
                </div>
            </div>
        </div>
        <?php include_once "../app/views/components/footer.php";?>
    </body>

</html>
