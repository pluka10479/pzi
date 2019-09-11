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
	$sql = 'SELECT * FROM korisnici';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $korisnici = $stmt->fetchAll();
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
		  <th>Ime </th>
		  <th>Prezime </th>
		  <th>Korisničko ime </th>
		  <th>Lozinka </th>
		  <th>Spol</th>
		  <th>E-mail</th>
		  <th></th>
		  <th></th>
		</tr>
  </thead>
  <tbody>
   <?php if(count($korisnici)): ?>
        <?php foreach($korisnici as $korisnik): ?>
            <tr>
                <td><?php echo $korisnik['id_korisnici']; ?></td>
                <td><?php echo $korisnik['ime']; ?></td>
                <td><?php echo $korisnik['prezime']; ?></td>
                <td><?php echo $korisnik['korisnicko_ime']; ?></td>
                <td><?php echo $korisnik['lozinka']; ?></td>
				<td><?php echo $korisnik['spol']; ?></td>
                <td><?php echo $korisnik['email']; ?></td>
				
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <td colspan="6">Nema korisnika u bazi</td>
    <?php endif; ?>
            
  </tbody>
  </table>
</div>
<!-- Ažuriraj profil -->

<div class="modal fade customModal" id="azurirajKorisnikaModal" tabindex="-1" role="dialog" aria-labelledby="azurirajKorisnikaModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form class="form-horizontal" action="azuriraj_profil.php?id=<?php echo $_SESSION['id_korisnici']; ?>" method="post">

                <div class="modal-body">

                    <h1>Ažuriranje profila</h1>

                    <div class="form-group">
                        <label for="ime" class="control-label col-sm-2">Ime</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="ime" name="ime" value="<?php echo $korisnik['ime']; ?>">
                        </div>
                    </div>
					
					<div class="form-group">
                        <label for="prezime" class="control-label col-sm-2">Prezime</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="prezime" name="prezime" value="<?php echo $korisnik['prezime']; ?>">
                        </div>
                    </div>
					
					<div class="form-group">
                        <label for="korisnicko_ime" class="control-label col-sm-2">Korisničko ime</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="korisnicko_ime" name="korisnicko_ime" value="<?php echo $korisnik['korisnicko_ime']; ?>">
                        </div>
                    </div>
					
					<div class="form-group">
                        <label for="lozinka" class="control-label col-sm-2">Lozinka</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="lozinka" name="lozinka" value="<?php echo $korisnik['lozinka']; ?>">
                        </div>
                    </div>
					
					<div class="form-group">
                        <label for="spol" class="control-label col-sm-2">Spol</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="spol" name="spol" value="<?php echo $korisnik['spol']; ?>">
                        </div>
                    </div>
					
					<div class="form-group">
                        <label for="email" class="control-label col-sm-2">E-mail</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="email" name="email" value="<?php echo $korisnik['email']; ?>">
                        </div>
                    </div>

                    

                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Odustani</button>
                    <button type="submit" class="btn btn-primary">Ažuriraj</button>
                </div>
            </form>

        </div>
    </div>
</div>

<br><br><br><br><br><br><br><br><br><br><br><br>


<?php require 'podnozje.php'; ?>