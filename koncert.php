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
    // Pripremi SQL upit
    $stmt = $dbh->prepare('SELECT koncerti.*, izvodjac.ime_izvodjaca, gradovi.ime_grada FROM koncerti LEFT JOIN izvodjac ON koncerti.id_izvodjaca = izvodjac.id_izvodjaca LEFT JOIN gradovi ON koncerti.id_grada = gradovi.id_grada WHERE id_koncerta = :id');

    // Izvrši SQL upit
    $stmt->execute([
        ':id' => $_GET['id']
    ]);

    // Vrati rezultat upita
    $koncert = $stmt->fetch();


    // Vrati sve izvođače

    $stmt = $dbh->prepare('SELECT * FROM izvodjac');
    $stmt->execute();
    $izvodjaci = $stmt->fetchAll();


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

<!-- Start Main Body Section -->
<div class="mainbody-section">
    <div class="container">

        <?php if(isset($_SESSION['korisnicko_ime']) && $_SESSION['razina'] == 'admin'): ?>
            <div class="row" style="margin-bottom: 30px;">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary btn-lg pull-right" data-toggle="modal" data-target="#izbrisiModal" style="background-color:rgba(0, 0, 0, 0.4);"><i class="glyphicon glyphicon-trash"></i></button>
                    <button type="button" class="btn btn-primary btn-lg pull-right" data-toggle="modal" data-target="#izmjeniModal" style="margin-right: 10px;background-color: rgba(0, 0, 0, 0.4);"><i class="fa fa-pencil-square-o"></i>Uredi</button>
                </div>
            </div>
        <?php endif; ?>

        <?php if(isset($_SESSION['korisnicko_ime']) && $_SESSION['razina'] == 'korisnik'): ?>
            <div class="row" style="margin-bottom: 30px;">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary btn-lg pull-right" data-toggle="modal" data-target="#rezervirajModal" style=" padding: 10px; background-color: rgba(0, 0, 0, 0.4);"><i class="fa fa-floppy-o" aria-hidden="true"></i>Rezerviraj</button>

                </div>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-12">
                <h2 style="color: #bbb; background-color: rgba(0, 0, 0, 0.6); padding: 20px; "><b>

                        <?php

                        echo $koncert['naziv_koncerta'];
                        echo '<br>';

                        ?>

                        <p>

                            <?php

                            echo date("d.m.Y", strtotime($koncert['datum_koncerta']));
                            echo  ', ' . $koncert['ime_grada'] . ', ' .$koncert['dvorana_stadion'];
					

                            ?>

                        </p>


                    </b></h2>

            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <img src="images/koncerti/<?php echo $koncert['fotografija']; ?>" class="img-responsive" alt="...">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <p style="color: #bbb; background-color: rgba(0, 0, 0, 0.6); padding: 20px;">

                    <?php

                    echo '<i style=font-size:2em; padding: 20px " class="fa fa-music"></i>';
                    echo '  '. $koncert['opis'];
                    echo '<br>';
					echo '<i style=font-size:2em; padding: 20px"  class="fa fa-credit-card"></i>';

					echo ' Cijene karata: <br>' . $koncert['cijena'];

                    ?>


                </p>
            </div>
        </div>
    </div>
</div>
<!-- End Main Body Section -->

<!-- Uredi koncert -->
<div class="modal fade customModal" id="izmjeniModal" tabindex="-1" role="dialog" aria-labelledby="izmjeniModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form class="form-horizontal" action="izmjeni_koncert.php?id=<?php echo $_GET['id']; ?>" method="post">

                <div class="modal-body">

                    <h1>Uredi koncert</h1>

                    <div class="form-group">
                        <label for="naziv_koncerta" class="control-label col-sm-2">Naziv</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="naziv_koncerta" name="naziv_koncerta" value="<?php echo $koncert['naziv_koncerta']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="id_izvodjaca" class="control-label col-sm-2">Izvođač</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="id_izvodjaca" name="id_izvodjaca">
                                <?php foreach($izvodjaci as $izvodjac): ?>
                                    <option value="<?php echo $izvodjac['id_izvodjaca']; ?>" <?php if($izvodjac['id_izvodjaca'] == $koncert['id_izvodjaca']) echo 'selected'; ?>><?php echo $izvodjac['ime_izvodjaca']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="id_grada" class="control-label col-sm-2">Grad</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="id_grada" name="id_grada">
                                <?php foreach($gradovi as $grad): ?>
                                    <option value="<?php echo $grad['id_grada']; ?>" <?php if($grad['id_grada'] == $koncert['id_grada']) echo 'selected'; ?>><?php echo $grad['ime_grada']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="datum_koncerta" class="control-label col-sm-2">Datum</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="datum_koncerta" name="datum_koncerta" value="<?php echo $koncert['datum_koncerta']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="dvorana_stadion" class="control-label col-sm-2">Dvorana</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="dvorana_stadion" name="dvorana_stadion" value="<?php echo $koncert['dvorana_stadion']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="opis" class="control-label col-sm-2">Opis</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="opis" name="opis" value="<?php echo $koncert['opis']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="fotografija" class="control-label col-sm-2">Fotografija</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="fotografija" name="fotografija" value="<?php echo $koncert['fotografija']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cijena" class="control-label col-sm-2">Cijena</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="cijena" name="cijena" value="<?php echo $koncert['cijena']; ?>">
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

<!-- Izbriši -->
<div class="modal fade customModal" id="izbrisiModal" tabindex="-1" role="dialog" aria-labelledby="izbrisiModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <h1>Jeste li sigurni?</h1>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Ne</button>
                <a href="izbrisi_koncert.php?id=<?php echo $_GET['id']; ?>"class="btn btn-primary">Da</a>
            </div>

        </div>
    </div>
</div>

<!-- Rezerviraj -->

<div class="modal fade customModal" id="rezervirajModal" tabindex="-1" role="dialog" aria-labelledby="rezervirajModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form class="form-horizontal" action="rezervacija.php?id=<?php echo $_GET['id']; ?>" method="post">

                <div class="modal-body">

                    <h1>Rezervacija</h1>
					<?php if(isset($_SESSION['poruka_rezervacija'])): ?>
							<div class="alert alert-danger" role="alert">
								<?php echo $_SESSION['poruka_rezervacija'] ?>
							</div>
							<script>
								$('#rezervirajModal').modal('show')
							</script>
							<?php unset($_SESSION['poruka_rezervacija']); ?>
					<?php endif; ?>

                    <input type="hidden" name="id_koncerta" value="<?php echo $koncert['id_koncerta']; ?>">

                    <div class="form-group">
                        <label for="tip" class="control-label col-sm-2">Vrsta karte</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="tip" name="tip">
                                <option value="VIP">VIP</option>
                                <option value="Tribina">Tribina</option>
                                <option value="Parter">Parter</option>
                            </select>
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

<?php

require 'podnozje.php';

?>
