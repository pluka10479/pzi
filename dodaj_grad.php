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
        $stmt = $dbh->prepare('INSERT INTO gradovi(ime_grada) VALUES (:ime_grada)');

        // Izvrši SQL upit
        $stmt->execute([
            ':ime_grada' => $_POST['ime_grada']
        ]);
        //Mo
        // Preusmjeri na početnu stranicu
        header('Location: gradovi.php');
        exit();
    }
    catch (PDOException $e)
    {
        http_response_code(500);
        die($e->getMessage());
    }
}
