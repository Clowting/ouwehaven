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
                            <h1>Rubrieken <small>Toon rubriek</small></h1>
                        </div>
                        <p>Op deze pagina vindt u een overzicht van de transacties in deze rubriek.</p>

                        <ul class="nav nav-tabs">
                            <li role="presentation" class="active"><a href="categories.php">Overzicht</a></li>
                            <li role="presentation"><a href="categories-add.php">Rubriek toevoegen</a></li>
                        </ul>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">

                                <?php

                                    if(isset($_GET['id']) && !empty($_GET['id'])) {
                                        if(is_numeric($_GET['id'])) {
                                            $dataManager->where('Categorie_ID = ' . $_GET['id']);
                                            $dataManager->orderBy('ID', 'DESC');
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
                                                echo '<div class="alert alert-info" role="alert">Er zijn geen transacties gevonden in deze rubriek.</div>';
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

                            </table>
                        </div>

                        <a href="categories.php" class="btn btn-primary">Ga terug naar het overzicht</a>
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