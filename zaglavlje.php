<!DOCTYPE html>
<html lang="hr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Kupi Kartu</title>

    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome CSS -->
    <link href="css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/animate.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>


    <!-- Tempate js -->
    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jquery.appear.js"></script>
    <!-- <script src="js/contact_me.js"></script> -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/modernizr.custom.js"></script>
    <script src="js/script.js"></script>

    
</head>
<body>

<!-- Start Logo Section -->
<section id="logo-section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="logo" style="margin-top: 20px;">
                    <a href="index.php">
                        <img src="images/logo.png" class="logo" alt="logo" style="width:140px; margin-right: 20px;">
                    </a>
                    <span>Concerts Just Feels Right</span>
                </div>
            </div>
            <div class="col-md-6">
                <div id="korisnik" class="pull-right">
                    <?php if(isset($_SESSION['korisnicko_ime'])): ?>
                        <span class="poruka">Prijavljeni ste kao</span> <a href="profil.php?id=<?php echo $_SESSION['id_korisnici']; ?>"><i style="font-size:1.73em; padding: 10px" class="fa fa-user" ></i><?php echo $_SESSION['korisnicko_ime']; ?></a> |
                        <a href="odjava.php"><i style="font-size:1.73em; padding: 10px" class="fa fa-sign-out" ></i>Odjava</a>
                    <?php else: ?>
                        <span class="poruka">Molimo prijavite se kako bi pristupili sustavu</span> |
                        <a href="#" data-toggle="modal" data-target="#registracijaModal"><i style="font-size:1.73em; padding: 10px" class="fa fa-sign-in"></i>Registracija</a> |
                        <a href="#" data-toggle="modal" data-target="#prijavaModal"><i style="font-size:1.73em; padding: 10px" class="fa fa-lock"></i>Prijava</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Logo Section -->
