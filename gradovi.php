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


    // Vrati sve gradove

    $stmt = $dbh->prepare('SELECT * FROM gradovi');
    $stmt->execute();
    $gradovi = $stmt->fetchAll();
    //Mo
    // Vrati sve izvođače

    $stmt = $dbh->prepare('SELECT * FROM izvodjac');
    $stmt->execute();
    $izvodjaci = $stmt->fetchAll();


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
				
                    <button type="button" class="btn btn-primary btn-lg pull-right" data-toggle="modal" data-target="#dodajGradModal" style ="margin-right: 10px; background-color: rgba(0, 0, 0, 0.4);">
                        <i class="fa fa-plus" aria-hidden="true" style="font-size: 1em;"></i>
                    </button>
                </div>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-12">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <?php for($i = 0; $i < count($gradovi); $i++): ?>
                        <li role="presentation" <?php if($i == 0) echo 'class="active"'; ?>><a href="#grad_<?php echo $gradovi[$i]['id_grada']; ?>" aria-controls="settings" role="tab" data-toggle="tab"><?php echo $gradovi[$i]['ime_grada']; ?></a></li>
                    <?php endfor; ?>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <?php for($i = 0; $i < count($gradovi); $i++): ?>
                        <div role="tabpanel" class="tab-pane <?php if($i == 0) echo 'active'; ?>" id="grad_<?php echo $gradovi[$i]['id_grada']; ?>">


                            <?php

                            try
                            {

                                /*

                                    Koncerti

                                */

                                // Pripremi SQL upit

                                $stmt = $dbh->prepare('SELECT koncerti.*, izvodjac.ime_izvodjaca, gradovi.ime_grada FROM koncerti LEFT JOIN izvodjac ON koncerti.id_izvodjaca = izvodjac.id_izvodjaca LEFT JOIN gradovi ON koncerti.id_grada = gradovi.id_grada WHERE gradovi.id_grada = :grad');

                                // Izvrši SQL upit
                                $stmt->execute([
                                    ':grad' => $gradovi[$i]['id_grada']
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
                                                        <!--  echo $koncert['ime_izvodjaca']; php treba povezat ime izvodjaca -->
                                                        <h4><?php echo $koncert['ime_izvodjaca']; ?><br><br> <?php echo date("d.m.Y", strtotime($koncert['datum_koncerta'])); ?></h4>
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

<!-- Dodaj grad -->
<div class="modal fade customModal" id="dodajGradModal" tabindex="-1" role="dialog" aria-labelledby="dodajGradModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form class="form-horizontal" action="dodaj_grad.php" method="post">
                <!--
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Dodaj Grad</h4>
                </div>
                -->
                <div class="modal-body">

                    <h1>Dodaj Grad</h1>

                    <div class="form-group">
                        <label for="ime_grada" class="control-label sr-only">Ime grada</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="ime_grada" name="ime_grada" placeholder="Ime grada">
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
