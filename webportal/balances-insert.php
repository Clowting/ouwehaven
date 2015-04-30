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

    <title><?php echo SITE_TITLE; ?> - Saldi - Nieuwe meting</title>

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
                            <h1>Saldi <small>Nieuwe meting</small></h1>
                        </div>
                        <p>Op deze pagina kunt u begin- en eindsaldi vastleggen.</p>

                        <ul class="nav nav-tabs">
                            <li role="presentation"><a href="balances.php">Overzicht</a></li>
                            <li role="presentation" class="active"><a href="balances-insert.php">Nieuwe meting</a></li>
                        </ul>

                        <?php

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

                                    $result = $dataManager->insert('oh_balances', $data);

                                    if($result) {
                                        echo '<div class="alert alert-success" role="alert"><strong>1 nieuwe balansmeting</strong> succesvol geimporteerd!</div>';
                                    }
                                    else {
                                        echo '<div class="alert alert-danger" role="alert">Er trad een fout op bij het invoeren van het saldo. Probeer het opnieuw.</div>';
                                    }
                                }
                                else {
                                    echo '<div class="alert alert-danger" role="alert">U gebruikte een ongeldig formulier of stuurde onjuiste gegevens. Probeer het opnieuw.</div>';
                                }
                            }

                        ?>

                        <form role="form" method="post">
                            <div class="form-group">
                                <label for="date">Meetdatum:</label>
                                <input class="form-control formDate" type="text" name="date" id="date">
                            </div>

                            <div class="form-group">
                                <label for="balance">Saldo:</label>
                                &euro; <input class="form-control" type="number" min="0" step="1" name="balance" id="balance">
                            </div>

                            <div class="form-group">
                                <input type="checkbox" name="start" id="start"> Startmeting
                            </div>

                            <button type="submit" class="btn btn-default">Importeren</button>
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