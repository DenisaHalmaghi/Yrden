<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo ASSET_URL . "css/index.css" ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo ASSET_URL . "css/account.css" ?>" type="text/css">
    <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" type="text/css">

    <title>Admin panel</title>
</head>

<body class="underHeader">

    <?php include_once "../app/views/components/header.php"; ?>

    <div class="fit-footer">

        <div class=" w-sm-11 w-lg-8 w-xl-6 mx-auto wrap column">

            <h1 class="c-prm ta-c mb-1">Admin panel</h1>
            <ul class='c-prm uppercase ta-c centeredRow jtf-c myAccList'>
                <li><a href="./?url=admin/getProducts">Products</a></li>
                <li><a href="./?url=admin/orders">Orders</a></li>
                <li><a href="./?url=admin/categories">Categories</a></li>
                <!-- <li><a href="./?url=user/addresses">Addresses</a></li>
                    <li><a href="./?url=user/settings/1">Settings</a></li> -->
            </ul>

            <?php
            $file = $data['header'];
            $permitted = array("products", 'orders', 'categories');
            if (in_array($file, $permitted)) {
                include_once "../app/views/admin/headers/$file.php";
            }
            ?>

            <div class="content">
                <?php
                $file = $data['file'];
                $permitted = array("productForm", 'products', 'orders', "categoryForm", "categories");
                if (in_array($file, $permitted)) {
                    include_once "../app/views/admin/$file.php";
                }
                ?>
            </div>
        </div>
    </div>
    <?php include_once "../app/views/components/footer.php"; ?>
</body>

</html>