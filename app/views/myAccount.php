<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo ASSET_URL . "css/index.css" ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo ASSET_URL . "css/account.css" ?>" type="text/css">
    <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" type="text/css">

    <title>Cart</title>
</head>

<body class="underHeader">

    <?php include_once "../app/views/components/header.php"; ?>

    <div class="fit-footer">

        <div class=" w-lg-9 w-xl-7 mx-auto wrap">

            <h1 class="c-prm ta-c mb-1">My account</h1>
            <ul class='centeredRow c-prm uppercase ta-c mb-1 jtf-c myAccList pi wrap'>
                <li><a href="./?url=user/orders">Orders</a> </li>
                <li><a href="./?url=user/addresses">Addresses<i class="fas fa-map-marker-alt"></i></a></li>
                <li><a href="./?url=user/settings/1"><span>Settings</span><i class="fas fa-user-edit"></i></a></li>
            </ul>
            <div class="content">

                <?php
                $file = $data['file'];
                $permitted = array("orders", 'settings', 'addresses');
                if (in_array($file, $permitted)) {
                    include_once "../app/views/$file.php";
                }
                ?>


            </div>
        </div>
    </div>
    <?php include_once "../app/views/components/footer.php"; ?>
</body>

</html>