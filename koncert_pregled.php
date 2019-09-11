<?php

session_start();

require 'konfiguracija.php';
require 'zaglavlje.php';

try
{
    //Mo
    // Stvori novi PDO objekt
    $dbh = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE, DB_USERNAME, DB_PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
	
	
   $sql = 'SELECT * FROM koncerti';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $koncerti = $stmt->fetchAll();

}
catch (PDOException $e)
{
    http_response_code(500);
    die($e->getMessage());
}

?>
<!-- gradovi -->
<br><br><br><br><br><br><br>
<div class="container">
            
	<table class="table table-reflow">
	  <thead>
		<tr>
		  <th>#</th>
		  <th>Naziv</th>
		  <th>Datum koncerta</th>
		  <th>Lokacija</th>
		  <th>Opis</th>
		  <th>Cijena</th>
		  <th>Fotografija</th>
		</tr>
	  </thead>
	  <tbody>
    <?php if(count($koncerti)): ?>
        <?php foreach($koncerti as $koncert): ?>
            <tr>
                <td><?php echo $koncert['id_koncerta']; ?></td>
                <td><?php echo $koncert['naziv_koncerta']; ?></td>
				<td><?php echo $koncert['datum_koncerta']; ?></td>
                <td><?php echo $koncert['dvorana_stadion']; ?></td>
				<td><?php echo $koncert['opis']; ?></td>
                <td><?php echo $koncert['cijena']; ?></td>
				<td><?php echo $koncert['fotografija']; ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <td colspan="6">Nema koncerata u bazi</td>
    <?php endif; ?>
  </tbody>
	 
	</table>
</div>
<br><br><br><br><br><br><br>

<?php require 'podnozje.php'; ?>
