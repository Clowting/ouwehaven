<?php
    require_once 'includes/globals.php';
	require_once 'includes/requireSession.php';
    require_once 'includes/requirePenningmeester.php';
	require_once 'includes/functions.php';
    require_once 'includes/connectdb.php';
?>
<!DOCTYPE html>
<html lang="en">

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

                            print_r($details);

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