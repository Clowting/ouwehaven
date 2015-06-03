<?php
    require_once 'includes/globals.php';
    require_once 'includes/requireSession.php';
    require_once 'includes/requireHavenmeester.php';
    require_once 'includes/functions.php';
    require_once 'includes/iban.php';
    require_once 'includes/connectdb.php';
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <?php

        include_once 'includes/head.php';

    ?>

    <title><?php echo SITE_TITLE; ?> - Leden - Aanpassen</title>

</head>

<body>

    <?php include_once 'includes/wrapper.php'; ?>

        <!-- Sidebar -->
        <?php

            include_once 'includes/sidebar.php';

        ?>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-header">
                            <h1>Leden
                                <small>Aanpassen</small>
                            </h1>
                        </div>
                        <p>Op deze pagina kunt u mensen uit het systeem aanpassen.</p>

                        <ul class="nav nav-tabs">
                            <li role="presentation"><a href="members-add.php">Toevoegen</a></li>
                            <li role="presentation"><a href="members-remove.php">Verwijderen</a></li>
                        </ul>

                        <?php

                            if(isset($_GET['id']) && is_numeric($_GET['id'])) {
                                $ID = $_GET['id'];
                                $dataManager->where('ID', $ID);
                                $details = $dataManager->getOne('oh_members');
                            }

                            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                                $voornaam = cleanInput($_POST['voornaam']);
                                $tussenvoegsel = cleanInput($_POST['tussenvoegsel']);
                                $achternaam = cleanInput($_POST['achternaam']);
                                $adres = cleanInput($_POST['adres']);
                                $postcode = cleanInput($_POST['postcode']);
                                $woonplaats = cleanInput($_POST['woonplaats']);
                                $telefoonnummer = cleanInput($_POST['telefoonnummer']);
                                $iban = str_replace(' ', '', cleanInput($_POST['iban']));

                                if( validateInput($voornaam, 2, 64) &&
                                    validateInput($achternaam, 2, 64) &&
                                    validateInput($adres, 4, 128) &&
                                    validateInput($postcode, 6, 7) &&
                                    validateInput($woonplaats, 2, 128)) {

                                    $data = array(
                                        'Voornaam' => $voornaam,
                                        'Achternaam' => $achternaam,
                                        'Adres' => $adres,
                                        'Postcode' => $postcode,
                                        'Woonplaats' => $woonplaats
                                    );

                                    if(validateInput($tussenvoegsel, 1, 16)) {
                                        $data['Tussenvoegsel'] = $tussenvoegsel;
                                    }

                                    // Telefoonnummer
                                    if(validateInput($telefoonnummer, 1, 16)) {
                                        $data['Telefoonnummer'] = $telefoonnummer;
                                    }
                                    elseif(empty($telefoonnummer)) {
                                        $data['Telefoonnummer'] = '';
                                    }
                                    else {
                                        echo '<div class="alert alert-warning" role="alert">U heeft geen geldig telefoonnummer opgegeven.</div>';
                                    }

                                    // IBAN
                                    if (verify_iban($iban)) {
                                        $data['IBAN'] = $iban;
                                    }
                                    elseif(empty($iban)) {
                                        $data['IBAN'] = '';
                                    }
                                    else {
                                        echo '<div class="alert alert-warning" role="alert">Het IBAN nummer kon niet worden gevalideerd.</div>';
                                    }

                                    $dataManager->where('ID', $details['ID']);
                                    $update = $dataManager->update('oh_members', $data);

                                    if($update) {
                                        echo '<div class="alert alert-success" role="alert">Uw gegevens zijn bijgewerkt.</div>';

                                        // Update session variable
                                        $_SESSION['member_details'] = $data;
                                        $details = $data;
                                    }
                                    else {
                                        echo '<div class="alert alert-danger" role="alert">Uw gegevens konden niet worden gewijzigd.</div>';
                                    }

                                }
                                else {
                                    echo '<div class="alert alert-danger" role="alert">Het lijkt er op alsof niet alle gegevens zijn ingevuld...</div>';
                                }
                            }

                        ?>

                        <form id="changeDetailsForm" role="form" method="POST">
                            <div class="form-group">
                                <label for="voornaam">Voornaam:</label>
                                <input type="text" class="form-control" name="voornaam" value="<?php echo $details['Voornaam']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="tussenvoegsel">Tussenvoegsel:</label>
                                <input type="text" class="form-control" name="tussenvoegsel" value="<?php echo $details['Tussenvoegsel']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="achternaam">Achternaam:</label>
                                <input type="text" class="form-control" name="achternaam" value="<?php echo $details['Achternaam']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="adres">Adres:</label>
                                <input type="text" class="form-control" name="adres" value="<?php echo $details['Adres']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="postcode">Postcode:</label>
                                <input type="text" class="form-control" name="postcode" value="<?php echo $details['Postcode']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="woonplaats">Woonplaats:</label>
                                <input type="text" class="form-control" name="woonplaats" value="<?php echo $details['Woonplaats']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="iban">Telefoonnummer:</label>
                                <input type="text" class="form-control" name="telefoonnummer" value="<?php echo $details['Telefoonnummer']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="iban">IBAN:</label>
                                <input type="text" class="form-control" name="iban" value="<?php echo $details['IBAN']; ?>">
                            </div>

                            <button type="submit" class="btn btn-primary">Opslaan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Footer -->
    <?php

        include_once 'includes/footer.php';

    ?>

</body>

</html>