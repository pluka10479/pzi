<!-- Prijava -->
<div class="modal fade customModal" id="prijavaModal" tabindex="-1" role="dialog" aria-labelledby="prijavaModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form class="form-horizontal" action="prijava.php" method="post">
                
                <div class="modal-body">

                    <h1>PRIJAVA</h1>

                    <?php if(isset($_SESSION['poruka_prijava'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $_SESSION['poruka_prijava'] ?>
                        </div>
                        <script>
                            $('#prijavaModal').modal('show')
                        </script>
                        <?php unset($_SESSION['poruka_prijava']); ?>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="korisnicko_ime" class="control-label sr-only">Korisničko ime</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="korisnicko_ime" name="korisnicko_ime" placeholder="Korisničko ime">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lozinka" class="control-label sr-only">Lozinka</label>
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="lozinka" name="lozinka" placeholder="Lozinka">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Odustani</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true" style="padding: 5px;"></i>Prijava</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Registracija -->
<div class="modal fade customModal" id="registracijaModal" tabindex="-1" role="dialog" aria-labelledby="registracijaModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form class="form-horizontal" action="registracija.php" method="post">
                
                <div class="modal-body">

                    <h1>REGISTRACIJA</h1>

                    <?php if(isset($_SESSION['poruka_registracija'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $_SESSION['poruka_registracija'] ?>
                        </div>
                        <script>
                            $('#registracijaModal').modal('show')
                        </script>
                        <?php unset($_SESSION['poruka_registracija']); ?>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="ime" class="control-label sr-only">Ime</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="ime" name="ime" placeholder="Ime">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="prezime" class="control-label sr-only">Prezime</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="prezime" name="prezime" placeholder="Prezime">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="korisnicko_ime" class="control-label sr-only">Korisničko ime</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="korisnicko_ime" name="korisnicko_ime" placeholder="Korisničko ime">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="lozinka" class="control-label sr-only">Lozinka</label>
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="lozinka" name="lozinka" placeholder="Lozinka">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="spol" class="control-label sr-only">Spol</label>
                        <div class="col-sm-12">
                            <select class="form-control" id="spol" name="spol">
                                <option value="muski">Muški</option>
                                <option value="zenski">Ženski</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="control-label sr-only">E-mail</label>
                        <div class="col-sm-12">
                            <input type="email" class="form-control" id="email" name="email" placeholder="E-mail">
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

<!-- Start Copyright Section -->
<div class="copyright text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div>Copyright &copy; 2019 Kupi Kartu</div>
            </div>
        </div>
    </div>
</div>
<!-- End Copyrigt Section -->

</body>
</html>
