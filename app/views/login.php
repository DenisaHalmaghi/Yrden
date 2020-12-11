<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo ASSET_URL . "css/index.css" ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo ASSET_URL . "css/registration.css" ?>" type="text/css">
    <title>LogIn</title>
    <style>
        .form-title{
            margin-bottom: 5%;
        }
    </style>
</head>

<body class="underHeader">

    <?php include_once "../app/views/components/header.php";
    // print_r($_SESSION['errors']);

    ?>
    <div class="fit-footer">
        <h1 class="ta-c w-sm-6 form-title h1 uppercase c-p2">Login</h1>

        <div class="row wrap w-11 mt-1 mx-auto">

            <form class="form w-12 w-lg-6" method="POST" action="./?url=home/login">

                <?php $viewUtil->printError('login'); ?>
                <div class=" form__input">
                    <label for="email">Email:</label>
                    <input class="input" id="email" name="email" type="email" <?php $viewUtil->printInputData('Email'); ?>>
                </div>
                <?php $viewUtil->printError('email'); ?>
                <div class="form__input">
                    <label for="psw">Password:</label>
                    <input class="input" id="psw" name="passw" type="password">
                </div>
                <?php $viewUtil->printError('psw'); ?>
                <button class=" uppercase btn w-12 w-md-8 mx-auto btn-primary">login</button>
            </form>

            <div class="panel chatty column w-12 w-lg-5 mx-auto ali-c new-customer">
                <div class="panel__header">
                    <h2 class="c-p h1">New Customer?</h2>
                </div>

                <div class="panel__body">
                    <p class="italic c-p2">Create an account with us and you'll be able to:</p>
                    <ul class="bulleted-list mb-1">
                        <li class="">Check out</li>
                        <li class="">Save multiple shipping addresses</li>
                        <li class="">Access your order history</li>
                        <li class="">Track your orders</li>
                    </ul>
                    <a class="btn btn-primary w-12" href="./?url=home/signup">Create
                        Account</a>

                </div>
            </div>
        </div>
    </div>


    <?php include_once "../app/views/components/footer.php"; ?>
</body>

</html>