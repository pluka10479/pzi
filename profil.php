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

    // Pripremi SQL upit
    $stmt = $dbh->prepare('SELECT * FROM korisnici WHERE id_korisnici = :id');
    //Mo
    // Izvrši SQL upit
    $stmt->execute([
        ':id' => $_GET['id']
    ]);

    // Vrati rezultat upita
    $korisnik = $stmt->fetch();

    /*

        Rezervacije

     */

    // Pripremi SQL upit
    $stmt = $dbh->prepare('SELECT rezervacija.*, koncerti.naziv_koncerta, koncerti.fotografija FROM rezervacija LEFT JOIN koncerti ON rezervacija.id_koncerta = koncerti.id_koncerta WHERE id_korisnici = :id');

    // Izvrši SQL upit
    $stmt->execute([
        ':id' => $_GET['id']
    ]);

    // Vrati rezultat upita
    $rezervacije = $stmt->fetchAll();

}
catch (PDOException $e)
{
    http_response_code(500);
    die($e->getMessage());
}

?>
<br><br>
<div class="row" style="margin-left: 155px;">
    <div class="col-md-12">
       
			<div class="main container-fluid well col-lg-4" style="color: #bbb; background-color: rgba(0, 0, 0, 0.6); padding: 20px; ">
				<div class="row-fluid" >
					<div class="col-lg-3"  >
						<img src="http://www.fashatude.com/static/fashatude/img/user_icon.png" 
							class="img-circle img-responsive">
					</div>
					
					<div class="col-lg-6">
						<h2>Vaš profil</h2>
						<h5>Korisničko ime: <?php echo $korisnik['korisnicko_ime'];?></h5>
						<h5>Ime: <?php echo $korisnik['ime'];?></h5>
						<h5>Prezime: <?php echo $korisnik['prezime'];?></h5>
						<h5>Lozinka: <?php echo $korisnik['lozinka'];?></h5>
						<h5>Email: <?php echo $korisnik['email'];?></h5>
						<h5>Spol: <?php echo $korisnik['spol'];?></h5>
					 
						
					</div>
					
					<div class="col-lg-3">
						<div class="btn-group">
							<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
								<i class="glyphicon glyphicon-cog glyphicon-white"></i>
								 
								<i class="caret"></i>
							</a>
							<ul class="dropdown-menu">
								<li><a href="type="button" class="btn btn-primary " data-toggle="modal" data-target="#azurirajProfilModal""><i class="fa fa-pencil-square-o"></i> Ažuriraj</a></li>
								<li><a href="type="button" class="btn btn-primary " data-toggle="modal" data-target="#obrisiProfilModal""><i style= "padding: 5px" class="glyphicon glyphicon-trash"></i> Obriši</a></li>
								<?php if(isset($_SESSION['korisnicko_ime']) && $_SESSION['razina'] == 'admin'): ?>
								<li><a href ="izvjesca.php" type="button" class="btn btn-primary"><i class="fa fa-th-list"></i> Izvješća</a></li>
								<?php endif; ?>

							</ul>
						</div>
					</div>
				</div>
			</div>
		
	</div>
</div>
<?php if(isset($_SESSION['korisnicko_ime']) && $_SESSION['razina'] == 'korisnik'): ?>
<br>

<div class="row" style="margin-left: 155px;">
    <div class="col-md-12">
		<div class="main container-fluid well col-lg-4" style="color: #bbb; background-color: rgba(0, 0, 0, 0.6); padding: 20px; " style="width:500px">
			<div class="row-fluid" >
			
					<h2 style="color:#ffffff;">Vaše rezervacije</h2>
						<?php foreach ($rezervacije as $rezervacija) : ?>
							<table>
								<td style="color:#ffffff;"><?php echo "Naziv koncerta: " .$rezervacija['naziv_koncerta'] . "<br>" . "Karta: " .$rezervacija['tip'] ."<br>". "Datum rezervacije: " .$rezervacija['datum_rezervacije'] . "<br>" . '<a href="type="button" class="btn btn-primary " data-toggle="modal" data-target="#obrisiRezervacijuModal""><i style= "padding: 5px"class="glyphicon glyphicon-trash"></i> Obriši</a>' ; ?></td>
								<td style="color:#ffffff;"><img src="images/koncerti/<?php echo $rezervacija['fotografija']; ?>"  style="width:250px; height:150px;" class="img-responsive" alt="..."><?php echo "<br><br><br>"?></td>
								
							</table>
						<?php endforeach ?>
				
			</div>
		</div>
	</div>			
</div>

 
<?php endif; ?>

<!-- Ažuriraj profil -->

<div class="modal fade customModal" id="azurirajProfilModal" tabindex="-1" role="dialog" aria-labelledby="azurirajProfilModalLabel">
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
                    <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true" style="padding: 5px;"></i>Spremi</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- obriši profil -->

<div class="modal fade customModal" id="obrisiProfilModal" tabindex="-1" role="dialog" aria-labelledby="obrisiProfilModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <h1>Jeste li sigurni?</h1>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Ne</button>
                <a href="obrisiProfil.php?id=<?php echo $_GET['id']; ?>"class="btn btn-primary">Da</a>
            </div>

        </div>
    </div>
</div>
<!--obrisi rezervaciju -->
<div class="modal fade customModal" id="obrisiRezervacijuModal" tabindex="-1" role="dialog" aria-labelledby="obrisiRezervacijuModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <h1>Jeste li sigurni?</h1>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Ne</button>
                <a href="obrisiRezervaciju.php?id=<?php echo $_GET['id']; ?>"class="btn btn-primary">Da</a>
            </div>

        </div>
    </div>
</div>



<?php


require 'podnozje.php';

?>
