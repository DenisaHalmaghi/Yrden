<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Yrden</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="UTF-8">
        <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
              type="text/css">
        <link rel="stylesheet" href="<?php echo ASSET_URL . "css/index.css" ?>" type="text/css">
        <link rel="stylesheet" href="<?php echo ASSET_URL . "css/home.css" ?>" type="text/css">
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />

    </head>

    <body>
        <div id="presentation">
            <?php
        include_once "../app/views/components/header.php";
        ?>

            <div class="main">
                <header class="hero centeredRow">
                    <h1 class="hero__title">Welcome</h1>
                    <p class="hero__text">Best furn eveh</p>
                </header>
            </div>
        </div>
        <br>
        <section class="w-11 w-md-9 mt-1 mx-auto">
            <h1 class='c-prm mb-1 fs-h ta-c '>About us</h1>
            <p class='mx-auto para italic'>Hundreds of thousands galaxies Sea of Tranquility not a sunrise but a
                galaxyrise Jean-François Champollion inconspicuous motes of rock and gas. Sed quia non numquam eius modi
                tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem totam rem aperiam, eaque ipsa
                quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo extraordinary
                claims require extraordinary evidence Neque porro quisquam est dispassionate extraterrestrial observer
                totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta
                sunt explicabo.

        </section>

        <section class="gallery mx-auto w-11 w-md-9">
            <h1 class='c-prm mb-1 fs-h ta-c '>Gallery</h1>
            <p class='w-12  para italic'>Two ghostly white figures in coveralls and helmets are soflty dancing globular
                star cluster colonies intelligent beings rich in mystery hundreds of thousands. Take root and flourish
                corpus callosum rings of Uranus from which we spring kindling the energy hidden in matter vanquish the
                impossible.

                <div class="  row wrap space-between">
                    <div class='gallery__col-left col column'>
                        <div> <img class='left-img' src="<?php echo IMAGE_URL ?>gallery/wide-5.jpg" alt="2"></div>
                        <div><img class='left-img' src="<?php echo IMAGE_URL ?>gallery/wide-3.jpg" alt="2"></div>
                        <div><img class='left-img' src="<?php echo IMAGE_URL ?>gallery/wide-2.png" alt="2"></div>
                        <div><img class='left-img' src="<?php echo IMAGE_URL ?>gallery/mid-1.png" alt="2"></div>




                        <!-- <img class='left-img' src="<?php echo IMAGE_URL ?>gallery/short-3.jpg" alt="2">
            <img class='left-img' src="<?php echo IMAGE_URL ?>gallery/short-3.jpg" alt="2"> -->
                    </div>

                    <div class='gallery__col-right col'>
                        <div> <img class='left-img' src="<?php echo IMAGE_URL ?>gallery/tall-3.png" alt="2"></div>
                        <div><img class='left-img' src="<?php echo IMAGE_URL ?>gallery/short-3.jpg" alt="2"></div>
                        <div> <img class='left-img' src="<?php echo IMAGE_URL ?>gallery/short-1.jpg" alt="2"></div>
                        <div> <img class='left-img' src="<?php echo IMAGE_URL ?>gallery/tall-1.png" alt="2"></div>
                        <div><img class='left-img' src="<?php echo IMAGE_URL ?>gallery/short-2.jpg" alt="2"></div>

                    </div>
        </section>

        <section class="contact w-11 w-md-9 mx-auto ">
            <h1 class='c-prm mb-1 fs-h ta-c mt-1 '>Contact</h1>

            <div class="contact-info ta-c bold">
                <p class="c-prm"><i class="far fa-envelope"></i><a
                       href="mailto:denisa.halmaghi@ulbsibiu.ro">denisa.halmaghi@ulbsibiu.ro</a></p>
                <p class="c-prm"><i class="fas fa-phone"></i><a target="_blank"
                       href="https://api.whatsapp.com/send?phone=40774625352">+40 774 625 352</a></p>
            </div>

        </section>
        <br>

        <?php include_once "../app/views/components/footer.php"; ?>

    </body>

</html>
