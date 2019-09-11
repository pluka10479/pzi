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
        $stmt = $dbh->prepare('SELECT * FROM korisnici WHERE korisnicko_ime = :korisnicko_ime AND lozinka = :lozinka');

        // Izvrši SQL upit
        $stmt->execute([
            ':korisnicko_ime' => $_POST['korisnicko_ime'],
            ':lozinka' => $_POST['lozinka']
        ]);

        // Vrati rezultat upita
        $korisnik = $stmt->fetch();

        // Provjeri rezultat upita
        if(empty($korisnik))
        {
            // Korisnik s ovim pristupnim podacima ne postoji u bazi, prijava je neuspješna

            // Prikaži poruku o grešci
            $_SESSION['poruka_prijava'] = 'Neispravno korisničko ime i/ili lozinka.';

            // Preusmjeri na početnu stranicu
            header('Location: index.php');
            exit();
        }
        else
        {
            // Korisnik s ovim pristupnim podacima postoji u bazi, prijava je uspješna

            // Postavi sesijske varijable
            $_SESSION['id_korisnici'] = $korisnik['id_korisnici'];
            $_SESSION['korisnicko_ime'] = $korisnik['korisnicko_ime'];
            $_SESSION['ime'] = $korisnik['ime'];
            $_SESSION['prezime'] = $korisnik['prezime'];
            $_SESSION['email'] = $korisnik['email'];
            $_SESSION['spol'] = $korisnik['spol'];
            $_SESSION['razina'] = $korisnik['razina'];
            //Mo
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
