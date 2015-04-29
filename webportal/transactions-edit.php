<?php
    require_once 'includes/globals.php';
	require_once 'includes/requireSession.php';
    require_once 'includes/requirePenningmeester.php';
	require_once 'includes/functions.php';
    require_once 'includes/connectdb.php';
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <?php

        include_once 'includes/head.php';

    ?>

    <title><?php echo SITE_TITLE; ?> - Rubrieken</title>

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
                            <h1>Transacties <small>Wijzigen</small></h1>
                        </div>
                        <p>Op deze pagina kunt u gegevens van een transactie wijzigen.</p>

                        <ul class="nav nav-tabs">
                            <li role="presentation"><a href="transactions.php">Credit</a></li>
                            <li role="presentation"><a href="transactions-debet.php">Debet</a></li>
                            <li role="presentation"><a href="transactions-import.php">Importeer transacties</a></li>
                            <li role="presentation"><a href="transactions-search.php">Zoek transactie</a></li>
                        </ul>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">

                                <?php

                                    if(
                                        isset($_GET['action']) &&
                                        !empty($_GET['action']) &&
                                        isset($_GET['id']) &&
                                        is_numeric($_GET['id'])
                                    ) {
                                        // EDIT action
                                        if($_GET['action'] == "edit") {

                                            if($_SERVER['REQUEST_METHOD'] == "POST") {
                                                if(
                                                    isset($_POST['rekeningnummer']) &&
                                                    validateInput($_POST['rekeningnummer'], 0, 35) &&

                                                    isset($_POST['tegenrekening']) &&
                                                    validateInput($_POST['tegenrekening'], 0, 35) &&

                                                    isset($_POST['naam_ontvanger']) &&
                                                    validateInput($_POST['naam_ontvanger'], 0, 70) &&

                                                    isset($_POST['bedrag']) &&
                                                    validateNumber($_POST['bedrag'], 0, 10) &&

                                                    isset($_POST['omschrijving']) &&
                                                    validateInput($_POST['omschrijving'], 0, 210)
                                                ) {

                                                    if(isset($_POST['categorie']) && validateNumber($_POST['categorie'], 1, 1)) {
                                                        $categorie = cleanInput($_POST['categorie']);
                                                    }
                                                    else {
                                                        $categorie = "";
                                                    }
                                                    $rekeningnummer = cleanInput($_POST['rekeningnummer']);
                                                    $tegenrekening = cleanInput($_POST['tegenrekening']);
                                                    $naam_ontvanger = cleanInput($_POST['naam_ontvanger']);
                                                    $bedrag = cleanInput($_POST['bedrag']);
                                                    $omschrijving = cleanInput($_POST['omschrijving']);

                                                    $data = array(
                                                        'Categorie_ID' => $categorie,
                                                        'Rekeningnummer' => $rekeningnummer,
                                                        'Tegenrekening' => $tegenrekening,
                                                        'Naam_Ontvanger' => $naam_ontvanger,
                                                        'Bedrag' => $bedrag,
                                                        'Omschrijving' => $omschrijving
                                                    );

                                                    $dataManager->where('ID', $_GET['id']);
                                                    $result = $dataManager->update('oh_transactions', $data);

                                                    if($result) {
                                                        echo '<div class="alert alert-success" role="alert"><strong>1 transactie</strong> succesvol gewijzigd!</div>';
                                                    }
                                                    else {
                                                        echo '<div class="alert alert-danger" role="alert">Er trad een fout op bij het wijzigen van de transactie. Probeer het opnieuw.</div>';
                                                    }
                                                }
                                                else {
                                                    echo '<div class="alert alert-danger" role="alert">U gebruikte een ongeldig formulier of stuurde onjuiste gegevens. Probeer het opnieuw.</div>';
                                                }
                                            }

                                            $categories = $dataManager->get('oh_categories');

                                            $dataManager->where('ID', $_GET['id']);
                                            $transaction = $dataManager->getOne('oh_transactions');

                                            if($dataManager->count > 0) {
                                                echo '<form role="form" method="post">';
                                                    echo '<div class="form-group">';
                                                        echo '<label for="categorie">Rubriek:</label>';
                                                        echo '<select class="form-control" name="categorie" id="categorie">';
                                                            echo '<option value="">Geen rubriek</option>';

                                                            foreach($categories as $category) {
                                                                if($category['ID'] == $transaction['Categorie_ID']) {
                                                                    echo '<option value="' . $category['ID'] . '" selected>' . $category['Naam'] . '</option>';
                                                                }
                                                                else {
                                                                    echo '<option value="' . $category['ID'] . '">' . $category['Naam'] . '</option>';
                                                                }
                                                            }
                                                        echo '</select>';
                                                    echo '</div>';

                                                    echo '<div class="form-group">';
                                                        echo '<label for="rekeningnummer">Rekeningnummer:</label>';
                                                        echo '<input type="text" class="form-control" value="' . $transaction['Rekeningnummer'] . '" name="rekeningnummer" id="rekeningnummer">';
                                                    echo '</div>';

                                                    echo '<div class="form-group">';
                                                        echo '<label for="tegenrekening">Tegenrekening:</label>';
                                                        echo '<input type="text" class="form-control" value="' . $transaction['Tegenrekening'] . '" name="tegenrekening" id="tegenrekening">';
                                                    echo '</div>';

                                                    echo '<div class="form-group">';
                                                        echo '<label for="naam_ontvanger">Naam ontvanger:</label>';
                                                        echo '<input type="text" class="form-control" value="' . $transaction['Naam_Ontvanger'] . '" name="naam_ontvanger" id="naam_ontvanger">';
                                                    echo '</div>';

                                                    echo '<div class="form-group">';
                                                        echo '<label for="bedrag">Bedrag:</label>';
                                                        echo '<input type="text" class="form-control" value="' . $transaction['Bedrag'] . '" name="bedrag" id="bedrag">';
                                                    echo '</div>';

                                                    echo '<div class="form-group">';
                                                        echo '<label for="omschrijving">Omschrijving:</label>';
                                                        echo '<input type="text" class="form-control" value="' . $transaction['Omschrijving'] . '" name="omschrijving" id="omschrijving">';
                                                    echo '</div>';

                                                    echo '<button type="submit" class="btn btn-default">Wijzigen</button>';
                                                echo '</form>';
                                            }
                                            else {
                                                echo '<div class="alert alert-danger" role="alert">U heeft mogelijk op een ongeldige link geklikt.</div>';
                                            }
                                        }
                                        elseif($_GET['action'] == "delete") {
                                            $dataManager->where('ID', $_GET['id']);
                                            $result = $dataManager->delete('oh_transactions');

                                            if($result) {
                                                echo '<div class="alert alert-success"><strong>Succes!</strong> Transactie is succesvol verwijderd.</div>';
                                            }
                                            else {
                                                echo '<div class="alert alert-warning"><strong>Waarschuwing!</strong> Transactie kon niet verwijderd worden.</div>';
                                            }

                                            echo '<a href="transactions.php" class="btn btn-default">Ga terug naar het overzicht</a>';
                                        }
                                    }
                                    else {
                                        echo '<div class="alert alert-danger" role="alert">U heeft mogelijk op een ongeldige link geklikt.</div>';
                                    }

                                ?>

                            </table>
                        </div>
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