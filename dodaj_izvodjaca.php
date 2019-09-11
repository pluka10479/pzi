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
        $stmt = $dbh->prepare('INSERT INTO izvodjac(id_glazba, ime_izvodjaca, opis, fotografija) VALUES (:id_glazba, :ime_izvodjaca, :opis, :fotografija)');

        // Izvrši SQL upit
        $stmt->execute([
            ':id_glazba' => $_POST['id_glazba'],
            ':ime_izvodjaca' => $_POST['ime_izvodjaca'],
            ':opis' => $_POST['opis'],
            ':fotografija' => $_POST['fotografija']
        ]);
        // Mo
        // Preusmjeri na početnu stranicu
        header('Location: izvodjaci.php');
        exit();
    }
    catch (PDOException $e)
    {
        http_response_code(500);
        die($e->getMessage());
    }
}
