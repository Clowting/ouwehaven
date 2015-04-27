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

    <title><?php echo SITE_TITLE; ?> - Transacties - Rubriceer</title>

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
                            <h1>Transacties <small>Rubriceer</small></h1>
                        </div>
                        <p>Op deze pagina vindt u een overzicht van de transacties.</p>

                        <ul class="nav nav-tabs">
                            <li role="presentation"><a href="transactions.php">Credit</a></li>
                            <li role="presentation"><a href="transactions-debet.php">Debet</a></li>
                            <li role="presentation" class="active"><a href="transactions-sort.php">Rubriceer</a></li>
                            <li role="presentation"><a href="transactions-import.php">Importeer transacties</a></li>
                            <li role="presentation"><a href="transactions-search.php">Zoek transactie</a></li>
                        </ul>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">

                                <?php

                                    if(isset($_GET['year']) && !empty($_GET['year'])) {
                                        if(is_numeric($_GET['year'])) {
                                            $dataManager->where('YEAR(FROM_UNIXTIME(Boekdatum)) = ' . $_GET['year']);
                                            $transactions = $dataManager->get('oh_transactions');

                                            if($dataManager->count > 0) {
                                                echo '<thead>';
                                                echo '<tr>';
                                                echo '<th>#</th>';
                                                echo '<th>Boekdatum</th>';
                                                echo '<th>Rekeningnummer</th>';
                                                echo '<th>Tegenrekening</th>';
                                                echo '<th>Houder tegenrekening</th>';
                                                echo '<th colspan="2">Bedrag</th>';
                                                echo '</tr>';
                                                echo '</thead>';

                                                echo '<tbody>';
                                                    foreach ($transactions as $transaction) {
                                                        echo '<tr>';
                                                            echo '<td>' . $transaction["ID"] . '</td>';
                                                            echo '<td>' . $transaction["Boekdatum"] . '</td>';
                                                            echo '<td>' . $transaction["Rekeningnummer"] . '</td>';
                                                            echo '<td>' . $transaction["Tegenrekening"] . '</td>';
                                                            echo '<td>' . $transaction["Naam_Ontvanger"] . '</td>';
                                                            echo '<td>&euro; ' . round($transaction["Bedrag"], 2) . '</td>';
                                                            echo '<td><a href="transactions-details.php?id=' . $transaction["ID"] . '"><i class="fa fa-arrow-right"></i></a></td>';
                                                        echo '</tr>';
                                                    }
                                                echo '</tbody>';
                                            }
                                            else {
                                                echo '<div class="alert alert-danger" role="alert">U heeft mogelijk op een ongeldige link geklikt.</div>';
                                            }
                                        }
                                        else {
                                            echo '<div class="alert alert-danger" role="alert">U heeft mogelijk op een ongeldige link geklikt.</div>';
                                        }
                                    }
                                    else {
                                        $dataManager->groupBy('YEAR(FROM_UNIXTIME(Boekdatum))');
                                        $dataManager->orderBy('ID', 'DESC');
                                        $transactions = $dataManager->get('oh_transactions', null, 'COUNT(*) AS Aantal, YEAR(FROM_UNIXTIME(Boekdatum)) AS Jaar');

                                        echo '<thead>';
                                            echo '<tr>';
                                                echo '<th>Jaar</th>';
                                                echo '<th>Aantal transacties</th>';
                                                echo '<th>Bekijk transacties</th>';
                                            echo '</tr>';
                                        echo '</thead>';

                                        echo '<tbody>';
                                            foreach ($transactions as $transaction) {
                                                $transaction = formatTransaction($transaction);

                                                echo '<tr>';
                                                    echo '<td>' . $transaction["Jaar"] . '</td>';
                                                    echo '<td>' . $transaction["Aantal"] . '</td>';
                                                    echo '<td><a href="?year=' . $transaction["Jaar"] . '"><i class="fa fa-arrow-right"></i></a></td>';
                                                echo '</tr>';
                                            }
                                        echo '</tbody>';
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