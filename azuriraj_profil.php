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
        $stmt = $dbh->prepare('UPDATE korisnici SET ime = :ime, prezime = :prezime, korisnicko_ime = :korisnicko_ime,lozinka = :lozinka, spol = :spol, email = :email WHERE id_korisnici = :id_korisnici');

        // Izvrši SQL upit
        $stmt->execute([
            ':id_korisnici' => $_GET['id'],
            ':ime' => $_POST['ime'],
            ':prezime' => $_POST['prezime'],
            ':korisnicko_ime' => $_POST['korisnicko_ime'],
			':lozinka' => $_POST['lozinka'],
            ':spol' => $_POST['spol'],
            ':email' => $_POST['email']
            
        ]);
        //Mo
        // Preusmjeri na početnu stranicu
        header('Location: profil.php?id=' . $_GET['id']);
        exit();
    }
    catch (PDOException $e)
    {
        http_response_code(500);
        die($e->getMessage());
    }
}
?>
