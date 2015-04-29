<?php
    require_once 'includes/globals.php';
	require_once 'includes/requireSession.php';
	require_once 'includes/functions.php';
    require_once 'includes/connectdb.php';
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <?php

        include_once 'includes/head.php';

    ?>

    <title><?php echo SITE_TITLE; ?> - Instellingen - Persoonlijke gegevens</title>

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
                            <h1>Instellingen <small>Persoonlijke gegevens</small></h1>
                        </div>
                        <p>Op deze pagina vindt u een overzicht van uw gegevens. U kunt hier ook uw gegevens direct veranderen.</p>

                        <?php

                            $details = $_SESSION['member_details'];

                            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                                $voornaam = cleanInput($_POST['voornaam']);
                                $tussenvoegsel = cleanInput($_POST['tussenvoegsel']);
                                $achternaam = cleanInput($_POST['achternaam']);
                                $adres = cleanInput($_POST['adres']);
                                $postcode = cleanInput($_POST['postcode']);
                                $woonplaats = cleanInput($_POST['woonplaats']);

                                if( validateInput($voornaam, 2, 64) &&
                                    validateInput($achternaam, 2, 64) &&
                                    validateInput($adres, 4, 128) &&
                                    validateInput($postcode, 6, 7) &&
                                    validateInput($woonplaats, 2, 128)) {

                                    $data = array(
                                        'User_ID' => $userID,
                                        'Voornaam' => $voornaam,
                                        'Achternaam' => $achternaam,
                                        'Adres' => $adres,
                                        'Postcode' => $postcode,
                                        'Woonplaats' => $woonplaats
                                    );

                                    if(validateInput($tussenvoegsel, 1, 16)) {
                                        $data['Tussenvoegsel'] = $tussenvoegsel;
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
                                <input type="text" class="form-control" name="voornaam" value="<?php echo $details['Voornaam']; ?>" required data-progression="" data-helper="Vul hier uw voornaam in.">
                            </div>
                            <div class="form-group">
                                <label for="tussenvoegsel">Tussenvoegsel:</label>
                                <input type="text" class="form-control" name="tussenvoegsel" value="<?php echo $details['Tussenvoegsel']; ?>" data-progression="" data-helper="Vul hier uw tussenvoegsel in indien u die heeft.">
                            </div>
                            <div class="form-group">
                                <label for="achternaam">Achternaam:</label>
                                <input type="text" class="form-control" name="achternaam" value="<?php echo $details['Achternaam']; ?>" required data-progression="" data-helper="Vul hier uw achternaam in.">
                            </div>
                            <div class="form-group">
                                <label for="adres">Adres:</label>
                                <input type="text" class="form-control" name="adres" value="<?php echo $details['Adres']; ?>" required data-progression="" data-helper="Vul hier uw straat en huisnummer in.">
                            </div>
                            <div class="form-group">
                                <label for="postcode">Postcode:</label>
                                <input type="text" class="form-control" name="postcode" value="<?php echo $details['Postcode']; ?>" required maxlength="7" data-progression="" data-helper="Vul hier uw postcode in.">
                            </div>
                            <div class="form-group">
                                <label for="woonplaats">Woonplaats:</label>
                                <input type="text" class="form-control" name="woonplaats" value="<?php echo $details['Woonplaats']; ?>" required data-progression="" data-helper="Vul hier uw woonplaats in.">
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