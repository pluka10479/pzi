-<?php

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

    /*

        Žanrovi

     */

    // Pripremi SQL upit
    $stmt = $dbh->prepare('SELECT * FROM glazba');

    // Izvrši SQL upit
    $stmt->execute();

    // Vrati rezultat upita
    $zanrovi = $stmt->fetchAll();




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
<div class="mainbody-section koncerti">
    <div class="container">

        <?php if(isset($_SESSION['korisnicko_ime']) && $_SESSION['razina'] == 'admin'): ?>
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary btn-lg pull-right" style ="background-color: rgba(0, 0, 0, 0.4);" data-toggle="modal" data-target="#dodajKoncertModal">
                       <i class="fa fa-plus" aria-hidden="true" style="font-size: 1em;"></i>
						
                    </button>
                </div>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-12">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <?php for($i = 0; $i < count($zanrovi); $i++): ?>
                        <li role="presentation" <?php if($i == 0) echo 'class="active"'; ?>><a href="#zanr_<?php echo $zanrovi[$i]['id_glazba']; ?>" aria-controls="settings" role="tab" data-toggle="tab"><?php echo $zanrovi[$i]['naziv_glazbe']; ?></a></li>
                    <?php endfor; ?>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <?php for($i = 0; $i < count($zanrovi); $i++): ?>
                        <div role="tabpanel" class="tab-pane <?php if($i == 0) echo 'active'; ?>" id="zanr_<?php echo $zanrovi[$i]['id_glazba']; ?>">


                            <?php

                            try
                            {

                                /*

                                    Koncerti

                                */

                                // Pripremi SQL upit
                                $stmt = $dbh->prepare('SELECT koncerti.*, izvodjac.ime_izvodjaca FROM koncerti LEFT JOIN izvodjac ON koncerti.id_izvodjaca = izvodjac.id_izvodjaca WHERE izvodjac.id_glazba = :zanr');
                                //Mo
                                // Izvrši SQL upit
                                $stmt->execute([
                                    ':zanr' => $zanrovi[$i]['id_glazba']
                                ]);

                                // Vrati rezultat upita
                                $koncerti = $stmt->fetchAll();

                            }
                            catch (PDOException $e)
                            {
                                http_response_code(500);
                                die($e->getMessage());
                            }

                            ?>

                            <div class="row">

                                <?php if(count($koncerti)): ?>
                                    <?php foreach($koncerti as $koncert): ?>
                                        <div class="col-md-4">
                                            <div class="portfolio-item">
                                                <a href="koncert.php?id=<?php echo $koncert['id_koncerta']; ?>">
                                                    <img src="images/koncerti/<?php echo $koncert['fotografija']; ?>" class="img-responsive" alt="...">
                                                    <div class="portfolio-details text-center">
                                                        <h4><?php echo $koncert['ime_izvodjaca']; ?> <br><br> <?php echo date("d.m.Y", strtotime($koncert['datum_koncerta'])); ?></h4>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="col-md-12">
                                        <p style="color: #bbb; background-color: rgba(0, 0, 0, 0.6); padding: 20px;">Nema koncerata u ovoj kategoriji.</p>
                                    </div>
                                <?php endif; ?>

                            </div>

                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Main Body Section -->

<!-- Dodaj koncert -->
<div class="modal fade customModal" id="dodajKoncertModal" tabindex="-1" role="dialog" aria-labelledby="dodajKoncertModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form class="form-horizontal" action="dodaj_koncert.php" method="post">
                
                <div class="modal-body">

                    <h1>Dodaj Koncert</h1>


                    <div class="form-group">
                        <label for="naziv_koncerta" class="control-label sr-only">Naziv</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="naziv_koncerta" name="naziv_koncerta" placeholder="Naziv koncerta">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="datum_koncerta" class="control-label sr-only">Datum koncerta</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="datum_koncerta" name="datum_koncerta" placeholder="Datum koncerta">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="dvorana_stadion" class="control-label sr-only">Lokacija</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="dvorana_stadion" name="dvorana_stadion" placeholder="Lokacija">
                        </div>
                    </div>

					<div class="form-group">
                        <label for="opis" class="control-label sr-only">Opis</label>
                        <div class="col-sm-12">
                            <input type="opis" class="form-control" id="opis" name="opis" placeholder="Opis">
                        </div>
                    </div>

					<div class="form-group">
                        <label for="fotografija" class="control-label sr-only">Fotografija</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="fotografija" name="fotografija" placeholder="Fotografija">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cijena" class="control-label sr-only">Cijena</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="cijena" name="cijena" placeholder="Cijena">
                        </div>
                    </div>

					 <div class="form-group">
                        <label for="id_izvodjaca" class="control-label col-sm-2">Izvođač</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="id_izvodjaca" name="id_izvodjaca">
                                <?php foreach($izvodjaci as $izvodjac): ?>
                                    <option value="<?php echo $izvodjac['id_izvodjaca']; ?>"><?php echo $izvodjac['ime_izvodjaca']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>


					  <div class="form-group">
                        <label for="id_grada" class="control-label col-sm-2">Grad</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="id_grada" name="id_grada">
                                <?php foreach($gradovi as $grad): ?>
                                    <option value="<?php echo $grad['id_grada']; ?>"><?php echo $grad['ime_grada']; ?></option>
                                <?php endforeach; ?>
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
