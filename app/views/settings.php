<form action="./?url=user/updateInfo" method='POST'>
    <?php
    if(isset($_SESSION['data']['result'])){
        $result= $_SESSION['data']['result'];
        echo "<p class='uppercase bold c-prm ta-c'>$result</p>";
    }


?>
    <div class="row wrap w-12 j-s-e  ">

        <div class="form__input  w-md-5 w-12">
            <label for="name">Name:</label>
            <input class="input" id="name" name="name" type="text"
                    <?php $viewUtil->printInputData('Name');?>>
            <?php $viewUtil->printError('name');?>
        </div>


        <div class="form__input  w-md-5 w-12">
            <label for="Surname">Surname:</label>
            <input class="input" id="Surname" name="surname" type="text"
                    <?php $viewUtil->printInputData('Surname');?>>
            <?php $viewUtil->printError('surname');?>
        </div>

    </div>


    <div class="row wrap w-12 j-s-e  ">

        <div class="form__input  w-md-5 w-12">
            <label for="phone">Phone Number:</label>
            <input class="input" id="phone" name="phone" type="tel"
                    <?php $viewUtil->printInputData('Phone');?>>
            <?php $viewUtil->printError('phone');?>
        </div>


            <div class=" form__input w-md-5 w-12">
            <label for="email">Email Address:</label>
            <input class="input" id="email" name="email" type="email"
            <?php $viewUtil->printInputData('Email');?>>
            <?php $viewUtil->printError('email');?>
        </div>

    </div>
     
    <div class="row wrap w-12 j-s-e  ">

        <div class="form__input w-md-5 w-12">
            <label for="c-psw">Password:</label>
            <input class="input" id="c-psw" name="passw" type="password">
            <?php $viewUtil->printError('psw');?>
        </div>

        <div class="form__input w-md-5 w-12">
            <label for="c-psw">Confirm Password:</label>
            <input class="input" id="c-psw" name="c_passw" type="password">
            <?php $viewUtil->printError('c_passw');?>
        </div>

    </div>

    <button class=" uppercase btn w-12 w-md-6 btn-primary mx-auto">Update data</button>
</form>

