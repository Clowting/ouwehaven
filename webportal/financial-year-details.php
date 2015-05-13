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

    <title><?php echo SITE_TITLE; ?> - Transacties - Credit</title>

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
                            <h1>Financieel jaarverslag <small>Details</small></h1>
                        </div>
                        <p>Op deze pagina kunt u het financieel jaarverslag controleren.</p>

                        <?php

                        if(isset($_GET['year']) && !empty($_GET['year'])) {
                            if (is_numeric($_GET['year'])) {
                                $dataManager->where('YEAR(FROM_UNIXTIME(Boekdatum)) = ' . $_GET['year']);
                                $dataManager->groupBy('YEAR(FROM_UNIXTIME(Boekdatum))');
                                $dataManager->orderBy('YEAR(FROM_UNIXTIME(Boekdatum))');
                                $year = $dataManager->getOne('oh_transactions', 'YEAR(FROM_UNIXTIME(Boekdatum)) AS Boekjaar, COUNT(*) AS AantalTransacties, SUM(Bedrag) AS TotaalBedrag');

                                if(!empty($year)) {
                                    echo '<div class="col-xs-12 col-md-5">';
                                        echo '<h4>' . $year["Boekjaar"] . '</h4>';

                                        echo '<div class="table-responsive">';
                                            echo '<table class="table table-condensed">';
                                                echo '<tr>';
                                                    echo '<td>Aantal transacties</td>';
                                                    echo '<td>' . $year["AantalTransacties"] . '</td>';
                                                echo '</tr>';
                                                echo '<tr>';
                                                    echo '<td>Totaal bedrag</td>';
                                                    echo '<td>&euro; ' . round($year["TotaalBedrag"], 2) . '</td>';
                                                echo '</tr>';
                                            echo '</table>';
                                        echo '</div>';
                                    echo '</div>';

                                    echo '<div class="col-xs-12 col-md-7">';
                                        echo '<h4>Overzicht</h4>';

                                        $dataManager->join('oh_categories', 'oh_transactions.Categorie_ID = oh_categories.ID', 'LEFT OUTER');
                                        $dataManager->groupBy('Categorie_ID');
                                        $transactions = $dataManager->get('oh_transactions', NULL, 'oh_categories.Naam, SUM(Bedrag) AS TotaalBedrag');

                                        echo '<div class="table-responsive">';
                                            echo '<table class="table table-condensed table-striped">';
                                                foreach($transactions as $transaction) {
                                                    echo '<tr>';
                                                        echo '<td>' . (!empty($transaction['Naam']) ? $transaction['Naam'] : 'Onbekend') . '</td>';
                                                    echo '<td>&euro; ' . round($transaction["TotaalBedrag"], 2) . '</td>';
                                                    echo '</tr>';
                                                }
                                            echo '</table>';
                                        echo '</div>';
                                    echo '</div>';

                                    echo '<a href="financial-year.php" class="btn btn-primary">Terug naar het overzicht</a>';
                                }
                                else {
                                    echo '<div class="alert alert-info" role="alert">Er zijn geen transacties gevonden in dit jaar.</div>';
                                }
                            }
                            else {
                                echo '<div class="alert alert-danger" role="alert">U heeft mogelijk op een ongeldige link geklikt.</div>';
                            }
                        }
                        else {
                            echo '<div class="alert alert-danger" role="alert">U heeft mogelijk op een ongeldige link geklikt.</div>';
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