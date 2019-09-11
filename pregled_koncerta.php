<?php

require 'konfiguracija.php';
require 'zaglavlje.php';

try
{
    // Povezivanje na bazu
    $dbh = new PDO('mysql:host=' . $host . ';dbname=' . $database, $username, $password, [

        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC

    ]);
    //Mo
    // SQL upit
    $sql = 'SELECT * FROM koncerti';

    // Izvršavanje upita
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    // Spremanje rezultata u asocijativni niz
    $koncerti = $stmt->fetchAll();
}
catch (PDOException $e)
{
    echo $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="hr">
<head>

    <meta charset="utf-8">
    <title>Pregled koncerta</title>

</head>
<body>

<h1>Pregled koncerta</h1>

<table>
    <tr>
        <th>#</th>
		  <th>Naziv</th>
		  <th>Datum </th>
		  <th>Lokacija </th>
		  <th>Fotografija </th>
		  <th>Opis</th>
		  <th>Cijena</th>
		  <th></th>
		  <th></th>
       
    </tr>
    <?php if(count($koncerti)): ?>
        <?php foreach($koncerti as $koncert): ?>
            <tr>
                <td><?php echo $koncert['id_koncerta']; ?></td>
                <td><?php echo $koncert['naziv_koncerta']; ?></td>
                <td><?php echo $koncert['datum_koncerta']; ?></td>
                <td><?php echo $koncert['dvorana_stadion']; ?></td>
                <td><?php echo $koncert['fotografija']; ?></td>
				<td><?php echo $koncert['opis']; ?></td>
                <td><?php echo $koncert['cijena']; ?></td>
				<td><?php echo '<a href="type="button" class="btn btn-primary " data-toggle="modal" data-target="#izmjeniKoncertModal""><i class="fa fa-pencil-square-o"></i> </a>'?></td>
				<td><?php echo '<a href="type="button" class="btn btn-primary " data-toggle="modal" data-target="#azurirajProfilModal""><i class="glyphicon glyphicon-trash"></i> </a>'?></td>
			</tr>
        <?php endforeach; ?>
    <?php else: ?>
        <td colspan="4">Nema koncerta u bazi</td>
    <?php endif; ?>
</table>

</body>
</html>
<?php
require 'podnozje.php';
?>