<?php

session_start();

require 'konfiguracija.php';

    try
    {
        // Stvori novi PDO objekt
        $dbh = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE, DB_USERNAME, DB_PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);

        // Pripremi SQL upit
        $stmt = $dbh->prepare('DELETE FROM rezervacija  WHERE id_korisnici = :id');

        // Izvrši SQL upit
        $stmt->execute([
            ':id' => $_GET['id']
        ]);
        //Mo
        // Preusmjeri na početnu stranicu
        header('Location: profil.php?id=$_GET["id"]');
        exit();
		
		
    }
    catch (PDOException $e)
    {
        http_response_code(500);
        die($e->getMessage());
    }
