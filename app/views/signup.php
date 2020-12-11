<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?php echo ASSET_URL . "css/index.css" ?>" type="text/css">
    <title>SignUP</title>
</head>

<body class="underHeader">

    <?php include_once "../app/views/components/header.php";
    // print_r($_SESSION['errors']);

    ?>
    <div class="fit-footer">
        <h1 class="ta-c mb-1 c-p2">Signup</h1>

        <form class="form w-12 " method="POST" action="./?url=home/signup">
            <!-- <div class="row wrap w-12 j-s-e">
                <div class=" w-md-5 w-12 ">
                    <?php $viewUtil->printError('signup'); ?>
                    <div class=" form__input">
                        <label for="email">Email Address:</label>
                        <input class="input" id="email" name="email" type="email"
                            <?php $viewUtil->printInputData('Email'); ?>>
                    </div>
                    <?php $viewUtil->printError('email'); ?>

                    <div class="form__input">
                        <label for="c-psw">Confirm Password:</label>
                        <input class="input" id="c-psw" name="c_passw" type="password">
                    </div>
                    <?php $viewUtil->printError('confirm'); ?>

                    <div class="form__input">
                        <label for="name">Name:</label>
                        <input class="input" id="name" name="name" type="text"
                            <?php $viewUtil->printInputData('Name'); ?>>
                    </div>
                    <?php $viewUtil->printError('name'); ?>

                    <div class="form__input">
                        <label for="phone">Phone Number:</label>
                        <input class="input" id="phone" name="phone" type="tel"
                            <?php $viewUtil->printInputData('Phone'); ?>>
                    </div>
                    <?php $viewUtil->printError('phone'); ?>

                    <div class="form__input">
                        <label for="state">State:</label>
                        <input class="input" id="state" name="State" type="text">
                    </div>
                    <?php $viewUtil->printError('address'); ?>

                    <div class="form__input">
                        <label for="Zip">Zip Code:</label>
                        <input class="input" id="Zip" name="ZipCode" type="text">
                    </div>
                    <?php $viewUtil->printError('zip'); ?>

                </div>
                <div class="w-md-5 w-12  ">
                    <div class="form__input">
                        <label for="c-psw">Password:</label>
                        <input class="input" id="c-psw" name="Psw" type="password">
                    </div>
                    <?php $viewUtil->printError('psw'); ?>

                    <div class="form__input">
                        <label for="cid">Country:</label>
                        <input class="input" id="cid" name="CountryID" type="text">
                    </div>
                    <?php $viewUtil->printError('country'); ?>

                    <div class="form__input">
                        <label for="Surname">Surname:</label>
                        <input class="input" id="Surname" name="Surname" type="text">
                    </div>
                    <?php $viewUtil->printError('surname'); ?>

                    <div class="form__input">
                        <label for="City">City:</label>
                        <input class="input" id="City" name="City" type="text">
                    </div>
                    <?php $viewUtil->printError('city'); ?>

                    <div class="form__input">
                        <label for="address">Address:</label>
                        <input class="input" id="address" name="Address" type="text">
                    </div>
                    <?php $viewUtil->printError('address'); ?>
                </div>
            </div> -->


            <?php $viewUtil->printError('signup'); ?>
            <div class="row wrap w-12 j-s-e  ">

                <div class=" form__input w-md-5 w-12">
                    <label for="email">Email Address:</label>
                    <input class="input" id="email" name="email" type="email" <?php $viewUtil->printInputData('Email'); ?>>
                    <?php $viewUtil->printError('email'); ?>
                </div>


                <div class="form__input w-md-5 w-12">
                    <label for="c-psw">Password:</label>
                    <input class="input" id="c-psw" name="passw" type="password">
                    <?php $viewUtil->printError('psw'); ?>
                </div>

            </div>

            <div class="row wrap w-12 j-s-e  ">

                <div class="form__input w-md-5 w-12">
                    <label for="c-psw">Confirm Password:</label>
                    <input class="input" id="c-psw" name="c_passw" type="password">
                    <?php $viewUtil->printError('c_passw'); ?>
                </div>


                <div class="form__input w-md-5 w-12">
                    <label for="cid">Country:</label>
                    <select id='cid' class='select' name='country'>
                        <?php echo $viewUtil->buildOptions($data['countries'], $viewUtil->checkIfDataExists('CountryID'),"Country") ?>
                    </select>

                    <?php $viewUtil->printError('country'); ?>
                </div>

            </div>


            <div class="row wrap w-12 j-s-e  ">

                <div class="form__input  w-md-5 w-12">
                    <label for="name">Name:</label>
                    <input class="input" id="name" name="name" type="text" <?php $viewUtil->printInputData('Name'); ?>>
                    <?php $viewUtil->printError('name'); ?>
                </div>



                <div class="form__input  w-md-5 w-12">
                    <label for="Surname">Surname:</label>
                    <input class="input" id="Surname" name="surname" type="text" <?php $viewUtil->printInputData('Surname'); ?>>
                    <?php $viewUtil->printError('surname'); ?>
                </div>

            </div>


            <div class="row wrap w-12 j-s-e  ">

                <div class="form__input  w-md-5 w-12">
                    <label for="phone">Phone Number:</label>
                    <input class="input" id="phone" name="phone" type="tel" <?php $viewUtil->printInputData('Phone'); ?>>
                    <?php $viewUtil->printError('phone'); ?>
                </div>


                <div class="form__input  w-md-5 w-12">
                    <label for="City">City:</label>
                    <input class="input" id="City" name="city" type="text" <?php $viewUtil->printInputData('City'); ?>>
                    <?php $viewUtil->printError('city'); ?>
                </div>

            </div>

            <div class="row wrap w-12 j-s-e  ">


                <div class="form__input w-md-5 w-12">
                    <label for="state">State:</label>
                    <input class="input" id="state" name="state" type="text" <?php $viewUtil->printInputData('State'); ?>>
                    <?php $viewUtil->printError('state'); ?>
                </div>


                <div class="form__input w-md-5 w-12">
                    <label for="address">Address:</label>
                    <input class="input" id="address" name="address" type="text" <?php $viewUtil->printInputData('Address') ?>>
                    <?php $viewUtil->printError('address'); ?>
                </div>

            </div>

            <div class="row wrap w-12 j-s-e  ">

                <div class="form__input w-md-5 w-12">
                    <label for="county">County:</label>
                    <input class="input" id="county" name="county" type="text" <?php $viewUtil->printInputData('County') ?>>
                    <?php $viewUtil->printError('county'); ?> </div>

                <div class="form__input w-md-5 w-12">
                    <label for="state">Zip Code:</label>
                    <input class="input" id="state" name="zip" type="text" <?php $viewUtil->printInputData('ZipCode') ?>>
                    <?php $viewUtil->printError('zip'); ?>
                </div>

            </div>

            <button class=" uppercase btn btn-primary mx-auto">signup</button>
        </form>

    </div>



    <?php include_once "../app/views/components/footer.php"; ?>
</body>

</html>