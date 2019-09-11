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
        $stmt = $dbh->prepare('UPDATE koncerti SET id_grada = :id_grada, id_izvodjaca = :id_izvodjaca, naziv_koncerta = :naziv_koncerta, datum_koncerta = :datum_koncerta, dvorana_stadion = :dvorana_stadion, opis = :opis, fotografija = :fotografija, cijena = :cijena WHERE id_koncerta = :id_koncerta');
        //Mo
        // Izvrši SQL upit
        $stmt->execute([
            ':id_koncerta' => $_GET['id'],
            ':id_grada' => $_POST['id_grada'],
            ':id_izvodjaca' => $_POST['id_izvodjaca'],
            ':naziv_koncerta' => $_POST['naziv_koncerta'],
            ':datum_koncerta' => $_POST['datum_koncerta'],
            ':dvorana_stadion' => $_POST['dvorana_stadion'],
            ':opis' => $_POST['opis'],
            ':fotografija' => $_POST['fotografija'],
            ':cijena' => $_POST['cijena']
        ]);

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
