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

        Izvođači

     */

    // Pripremi SQL upit
    $stmt = $dbh->prepare('SELECT * FROM izvodjac');

    // Izvrši SQL upit
    $stmt->execute();
    //Mo
    // Vrati rezultat upita
    $izvodjaci = $stmt->fetchAll();


    // Vrati sve žanrove

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

<!-- Start Main Body Section -->
<div class="mainbody-section koncerti">
    <div class="container">

        <?php if(isset($_SESSION['korisnicko_ime']) && $_SESSION['razina'] == 'admin'): ?>
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-md-12">
				    
                    <button type="button" class="btn btn-primary btn-lg pull-right" data-toggle="modal" data-target="#dodajIzvodjacModal"style ="margin-right: 10px; background-color: rgba(0, 0, 0, 0.4);">
                      <i class="fa fa-plus" aria-hidden="true" style="font-size: 1em;"></i>
                    </button>
					
                </div>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-12">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <?php for($i = 0; $i < count($izvodjaci); $i++): ?>
                        <li role="presentation" <?php if($i == 0) echo 'class="active"'; ?>><a href="#izvodjac_<?php echo $izvodjaci[$i]['id_izvodjaca']; ?>" aria-controls="settings" role="tab" data-toggle="tab"><?php echo $izvodjaci[$i]['ime_izvodjaca']; ?></a></li>
                    <?php endfor; ?>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <?php for($i = 0; $i < count($izvodjaci); $i++): ?>
                        <div role="tabpanel" class="tab-pane <?php if($i == 0) echo 'active'; ?>" id="izvodjac_<?php echo $izvodjaci[$i]['id_izvodjaca']; ?>">


                            <?php

                            try
                            {

                                /*

                                    Koncerti

                                */

                                // Pripremi SQL upit
                                $stmt = $dbh->prepare('SELECT koncerti.*, izvodjac.ime_izvodjaca FROM koncerti LEFT JOIN izvodjac ON koncerti.id_izvodjaca = izvodjac.id_izvodjaca WHERE izvodjac.id_izvodjaca = :izvodjac');

                                // Izvrši SQL upit
                                $stmt->execute([
                                    ':izvodjac' => $izvodjaci[$i]['id_izvodjaca']
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

<!-- Dodaj izvođača -->
<div class="modal fade customModal" id="dodajIzvodjacModal" tabindex="-1" role="dialog" aria-labelledby="dodajIzvodjacModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form class="form-horizontal" action="dodaj_izvodjaca.php" method="post">
                
                <div class="modal-body">

                    <h1>Dodaj izvođača</h1>

                    <div class="form-group">
                        <label for="ime_izvodjaca" class="control-label sr-only">Ime izvođača</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="ime_izvodjaca" name="ime_izvodjaca" placeholder="Ime izvođača">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="opis" class="control-label sr-only">Opis</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="opis" name="opis" placeholder="Opis">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="fotografija" class="control-label sr-only">Fotografija</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="fotografija" name="fotografija" placeholder="Fotografija">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="id_glazba" class="control-label col-sm-2">Žanr</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="id_glazba" name="id_glazba">
                                <?php foreach($zanrovi as $zanr): ?>
                                    <option value="<?php echo $zanr['id_glazba']; ?>"><?php echo $zanr['naziv_glazbe']; ?></option>
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
