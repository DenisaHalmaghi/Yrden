<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo ASSET_URL . "css/index.css" ?>" type="text/css">

    <link rel="stylesheet" href="<?php echo ASSET_URL . "css/products.css" ?>" type="text/css">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />

    <title>Products</title>
</head>

<body class="underHeader">


    <?php
    include_once "../app/views/components/header.php";
    // print_r($data);
    $viewUtil = new Util_View;
    //$viewUtil->printQueryResult($data["products"]);
    ?>
    <div class="fit-footer">
        <form method='GET' class='w-10 w-sm-5 w-lg-3 w-xl-2  mx-auto' action="./">
            <input type="text" name="url" value="home/products" hidden>
            <div class='mb-1 '>
                <label for="name">Name</label>
                <input id='name' name='name' class='input w-12' type="text" <?php $viewUtil->printInputData('name'); ?>>
            </div>

            <div class='centeredRow mb-1'>
                <div>
                    <label for="min">Min price</label>
                    <input id='min' name='min' step=0.1 class='input w-11' type="number" <?php $viewUtil->printInputData('min'); ?>>
                </div>

                <div>
                    <label for="max">Max price</label>
                    <input id='max' name='max' step=0.1 class='input w-11' type="number" <?php $viewUtil->printInputData('max'); ?>>
                </div>
            </div>


            <div class='mb-1 '>
                <label for="name">Category</label>
                <select class='select w-12' name="cat" id="cat">
                    <?php echo $viewUtil->buildOptions($data['categories'], $viewUtil->checkIfDataExists('cat'), "Category") ?>
                </select>

            </div>

            <button type="submit" class="btn btn-primary btn--small mx-auto"><span>Filter </span><i class="fas fa-filter"></i></button>
        </form>
        <br>
        <div class="row mx-auto w-xl-11 wrap">
            <?php
            while ($row = mysql_fetch_array($data['products'])) {
                $imgUrl = PRODUCTS_URL . $row['Image'];
                $id = $row['ID'];
                $productURL = './?url=home/product/' . $id;
                $price = "";

                if ($row['Discount']) {
                    $price = "<span class='product__price--old'>$${row['Price']}</span>";
                }
                $price .= "<span>$" . $viewUtil->calculateCurrentPrice($row['Price'], $row['Discount']) . "</span>";
                $btn = "<a href='./?url=home/product/$id' class='btn btn-primary w-12 uppercase'>see details</a>";

                if ($_SESSION['cart'][$id]) {
                    $btn = "<a class='btn btn-primary w-12 uppercase'><span>In cart</span><i class='fas fa-cart-arrow-down'></i></a>";
                }
                if ($row['Qty'] && !$_SESSION['cart'][$id]) {
                    $btn = "  
                    <form method='POST' action='./?url=home/addProductToCart'>
                        <input type='number' name='ProductID' value='$id' hidden>
                        <input name='Qty' class='input w-12 w-sm-6' type='number' value=1 hidden>
                        <button type='submit' class='btn btn-primary w-12 uppercase'>Add to cart</button>
                    </form>";
                }
                //print_r($row);
                echo "
        <div class='product w-sm-6 w-md-4 w-lg-3'>
                <div  class='product__header'>
                    <img src='$imgUrl' class='product__image w-12'
                        alt='product'>
                    <a href='$productURL' class='product__details'>
                        <h3 class='product__name'>${row['Product']}</h3>
                        <p class='product__price'>$price</p>
                    </a>
                </div>
                $btn
              
            </div>";
            }

            ?>

        </div>
    </div>



    <!-- <div class="row">
        <div class='product w-3'>
            <img src='http://localhost/mvc/app/assets/images/products/French-Louis-Bed.jpg' class='product__image w-12'
                alt='e'>
            <p class='product__name'>Numeeeeeee</p>
            <p class='product__price'><span class='product__price--old'>$10</span><span>$4</span></p>


            <button class='btn btn-grad'>Add to basket</button>
        </div>

    </div> -->



    <?php
    include_once "../app/views/components/footer.php";

    ?>
</body>

</html>