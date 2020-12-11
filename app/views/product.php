<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo ASSET_URL . "css/index.css" ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo ASSET_URL . "css/product.css" ?>" type="text/css">
    <title>Document</title>
</head>

<body class="underHeader">

    <?php include_once "../app/views/components/header.php"; ?>

    <div class="fit-footer w-11 mx-auto">

        <div class="row  wrap">

            <?php

            function buildStars($rating)
            {
                $rating = round($rating);
                $stars = "";
                for ($i = 0; $i < $rating; $i++) {
                    $stars .= "<i class='fas fa-star'></i>";
                }
                for ($i = $rating; $i < 5; $i++) {
                    $stars .= "<i class='far fa-star'></i>";
                }
                return $stars;
            }
            //  print_r($_SESSION);

            // print_r($_POST['Qty']);
            $row = mysql_fetch_array($data['products']);
            // print_r($row);
            $imgUrl = PRODUCTS_URL . $row['Image'];
            $price = "";
            $productID = $row['ID'];
            //generate price section
            if ($row['Discount']) {
                $price = "<span class='product__price--old'>$${row['Price']}</span>";
            }
            $price .= "<span>$" . $viewUtil->calculateCurrentPrice($row['Price'], $row['Discount']) . "</span>";
            // $btnText="see details";
            $availability = "Not in stock. Might take more time for the order to arrive.";
            $qtyInCart = 0;
            if (isset($_SESSION['cart'][$productID])) {
                $qtyInCart = $_SESSION['cart'][$productID]['Qty'];
            }
            $max = $row['Qty'] - $qtyInCart;
            if ($row['Qty']) {
                $availability = " In stock: ${row['Qty']}";
            }

            if($_SESSION['Type']=="admin"){
                $actions="
                <div class='centeredRow icon_holder'>
                    <a href='./?url=admin/updateProduct/$productID ' class='btn btn--xsmall btn-primary'><i class='fas fa-pen'></i></a>
                    <a href='./?url=admin/". ($row['Deleted']?"restore":"delete")."Product/$productID ' class='btn btn--xsmall btn-primary'><i class='fas fa-trash" . ($row['Deleted'] ? "-restore" : "") . "'></i></a>
                </div>
                ";
            }
            echo "
                <div class='w-md-5'>
                    <img src='$imgUrl' class='wm-100 product__img' alt='product'>
                </div>
                <div class='w-md-7 product__details column jtf-c'>
                    <input type='number' name='ProductID' value='$productID' hidden>
                    <h2 class='product__name h1 wrap-r centeredRow'><span>${row['Product']}</span> <span class='product__stars'>" . buildStars($row['Rating']) . "</span></h2>
                    <p class='product__price'>$price</p>
                    $actions
                    <p class='product__dimensions'>${row['Dimensions']}</p>
                    <p class='product__description'>${row['Description']}</p>
                    <p class='product__availability'><b> $availability</b></p>
                       <form method='POST' action='./?url=home/addProductToCart'>
                        <input type='number' name='ProductID' value='$productID' hidden>
                        <div class='qtyInput'>
                          <label class='mt-1' for='qty'>Quantity:</label>
                            <input name='Qty' class='input w-12 w-sm-6' id='qty' type='number' min=1 >
                             " . $viewUtil->getError('qty') . "
                        </div>
                      
                            <button type='submit' class='btn btn-primary w-12 w-sm-6 uppercase ta-c'>Add to cart</button>
                        </form>
                </div>";
            ?>
        </div>
        <br>
        <?php
        if (isset($_SESSION['ID']) && $_SESSION['ID']) {

            $inputStars = "";
            $text = array("Very Poor", "Poor", "Ok", "Good", "Very Good");
            for ($i = 5; $i >= 1; $i--) {
                $checked = "";
                if ($i == $_SESSION['data']['Rating']) {
                    $checked = "checked";
                }
                $index = $i - 1;
                $inputStars .= "
                    <input type='radio' id='star$i' name='Rating' value='$i' $checked />
                    <label for='star$i' title='${text[$index]}' class='star' > </label>
                    ";
            }
            echo "  <form method='POST' action='./?url=user/addReview'>
                <input type='number' name='ProductID' value='$productID' hidden>
            <div class='stars'>
                $inputStars
               
            </div>
             " . $viewUtil->getError('Rating') . "
            <div>
                <label for='reviewContent'>Your review:</label>
                <textarea class='textarea w-md-8 w-12 w-lg-6' name='Content' id='reviewContent' rows='10'>" . $viewUtil->checkIfDataExists('Content') . "</textarea>
                " . $viewUtil->getError('Content') . "
            </div>
            <button type='submit' id='reviews' class='btn btn-primary uppercase'>submit</button>

            </form>";
        } ?>

        <div class='w-lg-9 reviews'>
            <h2 class='c-prm'>Reviews:</h2>
            <?php
            $reviews = "";
            if (mysql_num_rows($data['reviews'])) {

                $imgurl = ASSET_URL . "images/user.png";
                while ($row = mysql_fetch_array($data['reviews'])) {
                    // print_r($row);
                    $id = $row['ID'];
                    if ($_SESSION['Type'] == "admin") {
                        $delBtn = "<a class='badge' href='./?url=admin/deleteReview/$id'><i class='fas fa-times'></i></a>";
                    }
                    $stars = "<div>" . buildStars($row['Rating']) . "</div>";
                    $reviews .= "
                        <div class='review'>
                            <img src=' $imgurl' alt='Avatar'>
                            <div class='review__content'>
                            <div class='stars_time centeredRow'>$stars <p class='centeredRow'><time>${row['TimeStamp']}</time>$delBtn </p></div>
                            <p class='bold'><span>${row['ReviewerName']}</span> </p>
                            <div class='review__text'>${row['Content']}</div>
                            </div>
                        </div>";
                }
            } else {
                $reviews = "<p class='no_results'>There are no reviews for this product yet. Be the first one to leave a review!</p>";
            }

            echo "<div >$reviews</div>";
            ?>
        </div>



        <!-- <span class="paint_stripe">Add to Basket</span> -->
    </div>
    <?php include_once "../app/views/components/footer.php"; ?>

</body>

</html>