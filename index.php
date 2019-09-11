<?php

session_start();

require 'zaglavlje.php';

?>

<!-- Start Main Body Section -->
<div class="mainbody-section text-center">
    <div class="container">
        <div class="row">

            <div class="col-md-3">

                <div class="menu-item">
                    <a href="koncerti.php">
                        <i class="fa fa-music"></i>
                        <p>Koncerti</p>
                    </a>
                </div>

                <div class="menu-item">
                    <a href="izvodjaci.php">
                        <i class="fa fa-users"></i>
                        <p>Izvođači</p>
                    </a>
                </div>

                <div class="menu-item">
                    <a href="gradovi.php">
                        <i class="fa fa-university"></i>
                        <p>Gradovi</p>
                    </a>
                </div>

            </div>

            <div class="col-md-6">

                <!-- Start Carousel Section -->
                <div class="home-slider" style="margin-top: 50px;">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" style="padding-bottom: 30px;">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
							<li data-target="#carousel-example-generic" data-slide-to="2"></li>
							<li data-target="#carousel-example-generic" data-slide-to="3"></li>
							<li data-target="#carousel-example-generic" data-slide-to="4"></li>
                            <!--
                            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                            -->
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">
                            <div class="item active">
                                <img src="images/koncerti/elemental.jpg" class="img-responsive" alt="">
                            </div>
                            <div class="item">
                                <img src="images/koncerti/cellos.jpg" class="img-responsive" alt="">
                            </div>
							<div class="item ">
                                <img src="images/koncerti/hladnopivo.jpg" class="img-responsive" alt="">
                            </div>
                            <div class="item">
                                <img src="images/koncerti/sars.jpg" class="img-responsive" alt="">
                            </div>
                            <div class="item">
                                <img src="images/koncerti/elemental.jpg" class="img-responsive" alt="">
                            </div>
							
                           
                            <!--
                            <div class="item">
                                <img src="images/about-01.jpg" class="img-responsive" alt="">
                            </div>
                            -->

                        </div>

                    </div>
                </div>
                <!-- End Carousel Section -->

            </div>

            <div class="col-md-3">

                <div class="menu-item light-red">
                    <a href="kontakt.php" >
                        <i class="fa fa-envelope-o"></i>
                        <p>Kontakt</p>
                    </a>
                </div>

                

                

            </div>
        </div>
    </div>
</div>
<!-- End Main Body Section -->
<!-- Wrapper for slides -->
<?php

require 'modali.php';
require 'podnozje.php';

?>
