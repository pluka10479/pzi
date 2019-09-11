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
    // Vrati sve gradove

    $stmt = $dbh->prepare('SELECT * FROM gradovi');
    $stmt->execute();
    $gradovi = $stmt->fetchAll();
	

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
		  <th></th>
		  <th></th>
		</tr>
	  </thead>
	  <tbody>
    <?php if(count($gradovi)): ?>
        <?php foreach($gradovi as $grad): ?>
            <tr>
                <td><?php echo $grad['id_grada']; ?></td>
                <td><?php echo $grad['ime_grada']; ?></td>
				
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <td colspan="6">Nema gradova u bazi</td>
    <?php endif; ?>
  </tbody>
	 
	</table>
</div>
<br><br><br><br><br><br><br>

<?php require 'podnozje.php'; ?>
