<?php

session_start();

require 'konfiguracija.php';

// Provjeri pristupamo li stranici preko POST zahtjeva
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    try
    {
        // Stvori novi PDO objekt
        $dbh = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE, DB_USERNAME, DB_PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);

        // Pripremi SQL upit
        $stmt = $dbh->prepare('INSERT INTO rezervacija(id_korisnici, id_koncerta, tip, datum_rezervacije) VALUES (:id_korisnici, :id_koncerta, :tip, :datum_rezervacije)');
        //Mo
        // Izvrši SQL upit
        $stmt->execute([
            ':id_korisnici' => $_SESSION['id_korisnici'],
            ':id_koncerta' => $_POST['id_koncerta'],
            ':tip' => $_POST['tip'],
            ':datum_rezervacije' => date('Y-m-d')

        ]);
		
		//Poruka
		 $_SESSION['poruka_rezervacija'] = 'Uspješno ste rezervirali kartu.';

        // Preusmjeri na početnu stranicu
		header('Location: koncert.php?id=' . $_GET['id']);
        exit();
    }
	
    catch (PDOException $e)
    {
        http_response_code(500);
        die($e->getMessage());
    }
}
