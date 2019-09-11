-<?php

session_start();

require 'konfiguracija.php';
require 'zaglavlje.php';

try
{

    // Stvori novi PDO objekt
    $dbh = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE, DB_USERNAME, DB_PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

	/*koncerti*/
	$sql = 'SELECT * FROM koncerti';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $koncerti = $stmt->fetchAll();
    // Pripremi SQL upit
    //Mo
	//glazba
	
	$stmt = $dbh->prepare('SELECT * FROM glazba');
    $stmt->execute();
    $zanrovi = $stmt->fetchAll();

    
	// Vrati sve izvođače

    $stmt = $dbh->prepare('SELECT * FROM izvodjac');
    $stmt->execute();
    $izvodjaci = $stmt->fetchAll();


    // Vrati sve gradove

    $stmt = $dbh->prepare('SELECT * FROM gradovi');
    $stmt->execute();
    $gradovi = $stmt->fetchAll();
	
	//rezervacije
    $stmt = $dbh->prepare('SELECT * FROM rezervacija');
    $stmt->execute();
    $rezervacije = $stmt->fetchAll();

}
catch (PDOException $e)
{
    http_response_code(500);
    die($e->getMessage());
}

?>

<div class="mainbody-section koncerti">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="korisnik_pregled.php">Korisnici</a></li>
						<li role="presentation"><a href="koncert_pregled.php" >Koncerti</a></li>
						<li role="presentation"><a href="izvodjac_pregled.php">Izvođači</a></li>
                        <li role="presentation"><a href="glazba_pregled.php" >Glazba</a></li>
						<li role="presentation"><a href="grad_pregled.php">Gradovi</a></li>
						<li role="presentation"><a href="rezervacija_pregled.php" >Rezervacije</a></li>
                    
                </ul>

               
                    
                
            </div>
        </div>
    </div>
</div>


<?php

require 'podnozje.php';

?>
