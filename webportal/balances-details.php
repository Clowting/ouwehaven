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

    <title><?php echo SITE_TITLE; ?> - Saldi - Wijzig meting</title>

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
                            <h1>Saldi <small>Wijzig meting</small></h1>
                        </div>
                        <p>Op deze pagina kunt u een bestaande meting wijzigen.</p>

                        <ul class="nav nav-tabs">
                            <li role="presentation"><a href="balances.php">Overzicht</a></li>
                            <li role="presentation"><a href="balances-insert.php">Nieuwe meting</a></li>
                        </ul>

                        <?php

                            if(isset($_GET['id']) && is_numeric($_GET['id'])) {
                                $dataManager->where('ID', $_GET['id']);
                                $result = $dataManager->get('oh_balances', 1);

                                if($result !== false && !empty($result[0])) {
                                    $balance = $result[0];

                                    // Update function
                                    if($_SERVER['REQUEST_METHOD'] == 'POST') {
                                        if(
                                            isset($_POST['date']) &&
                                            isset($_POST['balance']) &&
                                            validateDate($_POST['date'], "d/m/Y") &&
                                            is_numeric($_POST['balance'])
                                        ) {

                                            $date = DateTime::createFromFormat("d/m/Y", $_POST['date']);
                                            $datum = $date->format("Y-m-d");
                                            $saldo = $_POST['balance'];
                                            $startmeting = ((isset($_POST['start']) && $_POST['start'] == 'on') ? 1 : 0);

                                            $data = array(
                                                'Datum' => $datum,
                                                'Saldo' => $saldo,
                                                'Startmeting' => $startmeting
                                            );

                                            // Update balance variable
                                            $balance = $data;

                                            $dataManager->where('ID', $_GET['id']);
                                            $result = $dataManager->update('oh_balances', $data);

                                            if($result) {
                                                echo '<div class="alert alert-success" role="alert">Balansmeting succesvol bijgewerkt!</div>';
                                            }
                                            else {
                                                echo '<div class="alert alert-danger" role="alert">Balansmeting kon niet worden gewijzigd. Probeer het opnieuw.</div>';
                                            }
                                        }
                                        else {
                                            echo '<div class="alert alert-danger" role="alert">U gebruikte een ongeldig formulier of stuurde onjuiste gegevens. Probeer het opnieuw.</div>';
                                        }
                                    }

                                    // Delete function
                                    if(isset($_GET['delete'])) {
                                        $dataManager->where('ID', $balance['ID']);
                                        $result = $dataManager->delete('oh_balances');

                                        if($result) {
                                            echo '<div class="alert alert-success"><strong>Succes!</strong> Balansmeting is succesvol verwijderd.</div>';

                                            echo '<a href="balances.php" class="btn btn-primary">Ga terug naar het overzicht</a>';
                                        }
                                        else {
                                            echo '<div class="alert alert-warning"><strong>Waarschuwing!</strong> Balansmeting kon niet verwijderd worden.</div>';

                                            echo '<a href="balances-details.php?id=' . $balance['ID'] . '" class="btn btn-primary">Ga terug naar de balansmeting</a>';
                                        }
                                    }
                                    else {

                        ?>

                        <div class="col-md-7">
                            <h4>Wijzig gegevens</h4>

                            <form id="changeBalanceForm" role="form" method="POST">
                                <div class="form-group">
                                    <label for="date">Meetdatum:</label>
                                    <input class="form-control formDate" type="text" name="date" value="<?php echo date("d/m/Y", strtotime($balance['Datum'])); ?>" id="date">
                                </div>

                                <div class="form-group">
                                    <label for="balance">Saldo:</label>
                                    &euro; <input class="form-control" type="number" min="0" step="1" name="balance" value="<?php echo $balance['Saldo']; ?>" id="balance">
                                </div>

                                <div class="form-group">
                                    <input type="checkbox" name="start" <?php echo (($balance["Startmeting"] == 1) ? "checked" : ""); ?> id="start"> Startmeting
                                </div>

                                <button type="submit" class="btn btn-primary">Opslaan</button>
                            </form>
                        </div>

                        <?php
                                    echo '<div class="col-md-5">';
                                        echo '<h4>Verwijder meting</h4>';
                                        echo '<a href="balances-details.php?id=' . $_GET['id'] . '&delete=1" class="btn btn-danger">Verwijderen</a>';
                                    echo '</div>';

                                    }
                                }
                                else {
                                    echo '<div class="alert alert-warning"><strong>Waarschuwing!</strong> Ongeldig balansmeting ID.</div>';
                                }
                            }
                            else {
                                echo '<div class="alert alert-info"><strong>Fout!</strong> U heeft waarschijnlijk op een verkeerde link geklikt.</div>';
                            }

                        ?>
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