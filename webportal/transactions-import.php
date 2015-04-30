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

    <title><?php echo SITE_TITLE; ?> - Transacties - Importeren</title>

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
                            <h1>Transacties <small>Importeer</small></h1>
                        </div>
                        <p>Importeer nieuwe transacties.</p>

                        <ul class="nav nav-tabs">
                            <li role="presentation"><a href="transactions.php">Credit</a></li>
                            <li role="presentation"><a href="transactions-debet.php">Debet</a></li>
                            <li role="presentation" class="active"><a href="transactions-import.php">Importeer transacties</a></li>
                            <li role="presentation"><a href="transactions-search.php">Zoek transactie</a></li>
                        </ul>

                        <?php

                            if($_SERVER["REQUEST_METHOD"] == "POST") {
                                if(isset($_FILES["transactions"]["tmp_name"]) && !empty($_FILES["transactions"]["tmp_name"])) {
                                    $file = file($_FILES["transactions"]["tmp_name"]);
                                    $csv = array_map('str_getcsv', $file);

                                    if($csv) {
                                        $transactions_success = 0;
                                        $transactions_failed = 0;

                                        foreach($csv as $transactie) {
                                            $data = array(
                                                'Rekeningnummer' => $transactie[0],
                                                'Muntsoort' => $transactie[1],
                                                'Rentedatum' => toTimestamp($transactie[2]),
                                                'Code' => $transactie[3],
                                                'Bedrag' => $transactie[4],
                                                'Tegenrekening' => $transactie[5],
                                                'Naam_Ontvanger' => $transactie[6],
                                                'Boekdatum' => toTimestamp($transactie[7]),
                                                'Boekcode' => $transactie[8],
                                                'Filler' => $transactie[9],
                                                'Omschrijving' => trim(implode(" ", array(
                                                                    $transactie[10],
                                                                    $transactie[11],
                                                                    $transactie[12],
                                                                    $transactie[13],
                                                                    $transactie[14],
                                                                    $transactie[15]
                                                                ))),
                                                'End_To_End_ID' => $transactie[16],
                                                'Tegenrekeninghouder_ID' => $transactie[17],
                                                'Mandaat_ID' => $transactie[18]
                                            );

                                            $result = $dataManager->insert('oh_transactions', $data);

                                            // Voer SQL statement uit
                                            if($result) {
                                                $transactions_success++;
                                            }
                                            else {
                                                $transactions_failed++;
                                            }
                                        }

                                        // Toon meldingen
                                        if($transactions_success > 0) {
                                            echo '<div class="alert alert-success" role="alert"><strong>' . $transactions_success . ' transacties</strong> succesvol geimporteerd!</div>';
                                        }

                                        if($transactions_failed > 0) {
                                            echo '<div class="alert alert-danger" role="alert"><strong>' . $transactions_failed . ' transacties</strong> konden niet worden geimporteerd.</div>';
                                        }
                                    }
                                    else {
                                        echo '<div class="alert alert-danger" role="alert">Er trad een fout op bij het uitlezen van het bestand.</div>';
                                    }
                                }
                                else {
                                    echo '<div class="alert alert-danger" role="alert">Er trad een fout op bij het uploaden van het bestand.</div>';
                                }
                            }

                        ?>

                        <form role="form" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="file">Kies CSV-bestand:</label>
                                <input type="file" name="transactions" id="transactions">
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