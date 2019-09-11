<?php

session_start();

require 'konfiguracija.php';
require 'zaglavlje.php';

try
{

    // Stvori novi PDO objekt
    $dbh = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE, DB_USERNAME, DB_PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
	//Mo
	// korisnici
	$stmt = $dbh->prepare('SELECT * FROM rezervacija');
    $stmt->execute();
    $rezervacije = $stmt->fetchAll();

}
catch (PDOException $e)
{
    http_response_code(500);
    die($e->getMessage());
}
?>

<!-- korisnici -->
<br><br><br><br><br><br><br>
<div class="container">
            
	<table class="table table-reflow">
	<thead>
	  <tr>
		  <th>#</th>
		  <th>Datum rezervacije</th>
		  <th>Tip rezervacije</th>
		  <th></th>
		  <th></th>
		</tr>
  </thead>
  <tbody>
      <?php if(count($rezervacije)): ?>
        <?php foreach($rezervacije as $rezerv): ?>
            <tr>
                <td><?php echo $rezerv['id_rezervacije']; ?></td>
                <td><?php echo $rezerv['datum_rezervacije']; ?></td>
				<td><?php echo $rezerv['tip']; ?></td>
				
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <td colspan="6">Nema rezervacija u bazi</td>
    <?php endif; ?>
            
  </tbody>
  </table>
</div>
<br><br><br><br><br><br><br>

<?php require 'podnozje.php'; ?>