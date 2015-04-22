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
                        <p>Op deze pagina vindt u een overzicht van uw gegevens.</p>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Boekdatum</th>
                                        <th>Rekeningnummer</th>
                                        <th>Tegenrekening</th>
                                        <th>Houder tegenrekening</th>
                                        <th colspan="2">Bedrag</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php

                                        $transactions = getTransactions($mysqli, 'C');

                                        foreach($transactions as $transaction) {
                                            echo '<tr>';
                                                echo '<td>' . $transaction["ID"] . '</td>';
                                                echo '<td>' . $transaction["Boekdatum"] . '</td>';
                                                echo '<td>' . $transaction["Rekeningnummer"] . '</td>';
                                                echo '<td>' . $transaction["Tegenrekening"] . '</td>';
                                                echo '<td>' . $transaction["Naam_Ontvanger"] . '</td>';
                                                echo '<td>&euro; ' . $transaction["Bedrag"] . '</td>';
                                                echo '<td><a href="transactions-details.php?id=' . $transaction["ID"] . '"><i class="fa fa-arrow-right"></i></a></td>';
                                            echo '</tr>';
                                        }

                                    ?>
                                </tbody>

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