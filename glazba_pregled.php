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
	
	// MO
    // Vrati sve gradove

	$stmt = $dbh->prepare('SELECT * FROM glazba');
    $stmt->execute();
    $zanrovi = $stmt->fetchAll();
	

}
catch (PDOException $e)
{
    http_response_code(500);
    die($e->getMessage());
}

?>
<!-- glazba -->
<br><br><br><br><br><br><br>
<div class="container">
            
	<table class="table table-reflow">
	  <thead>
		<tr>
		  <th>#</th>
		  <th>Naziv</th>
		  <th></th>
		  <th></th>
		</tr>
	  </thead>
	  <tbody>
    <?php if(count($zanrovi)): ?>
        <?php foreach($zanrovi as $zanr): ?>
            <tr>
                <td><?php echo $zanr['id_glazba']; ?></td>
                <td><?php echo $zanr['naziv_glazbe']; ?></td>
				
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <td colspan="6">Nema žanrova u bazi</td>
    <?php endif; ?>
  </tbody>
	 
	</table>
</div>
<br><br><br><br><br><br><br>

<?php require 'podnozje.php'; ?>
