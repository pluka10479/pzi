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

        // Pri registraciji korisnika moramo prvo provjeriti je li korisničko ime zauzeto.

        // Pripremi SQL upit
        $stmt = $dbh->prepare('SELECT * FROM korisnici WHERE korisnicko_ime = :korisnicko_ime');
        //Mo
        // Izvrši SQL upit
        $stmt->execute([
            ':korisnicko_ime' => $_POST['korisnicko_ime']
        ]);

        // Vrati rezultat upita
        $korisnik = $stmt->fetch();

        // Provjeri rezultat upita
        if(empty($korisnik))
        {
            // Ne postoji korisnik s ovim korisničkim imenom, kreiraj novog korisnika

            // Pripremi SQL upit
            $stmt = $dbh->prepare('INSERT INTO korisnici (ime, prezime, korisnicko_ime, lozinka, spol, email) VALUES (:ime, :prezime, :korisnicko_ime, :lozinka, :spol, :email)');

            // Izvrši SQL upit
            $stmt->execute([
                ':ime' => $_POST['ime'],
                ':prezime' => $_POST['prezime'],
                ':korisnicko_ime' => $_POST['korisnicko_ime'],
                ':lozinka' => $_POST['lozinka'],
                ':spol' => $_POST['spol'],
                ':email' => $_POST['email']
            ]);

            // Prikaži poruku o uspješnoj registraciji
            $_SESSION['poruka_registracija'] = 'Uspješno ste registrirani. Molimo prijavite se kako bi pristupili sustavu.';

            // Preusmjeri na početnu stranicu
            header('Location: index.php');
            exit();
        }
        else
        {
            // Već postoji korisnik s ovim korisničkim imenom

            // Prikaži poruku o grešci
            $_SESSION['poruka_registracija'] = 'Već postoji korisnik s ovim korisničkim imenom. Molimo odaberite neko drugo korisničko ime.';

            // Preusmjeri na početnu stranicu
            header('Location: index.php');
            exit();
        }
    }
    catch (PDOException $e)
    {
        http_response_code(500);
        die($e->getMessage());
    }
}
