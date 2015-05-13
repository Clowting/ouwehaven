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
                            <h1>Financieel jaarverslag <small>Controleren</small></h1>
                        </div>
                        <p>Op deze pagina kunt u het financieel jaarverslag controleren.</p>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">

                                <thead>
                                    <tr>
                                        <th>Jaar</th>
                                        <th>Aantal transacties</th>
                                        <th>Totaal</th>
                                        <th>Toon jaarverslag</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php

                                        $dataManager->groupBy('YEAR(FROM_UNIXTIME(Boekdatum))');
                                        $dataManager->orderBy('YEAR(FROM_UNIXTIME(Boekdatum))');
                                        $years = $dataManager->get('oh_transactions', NULL, 'YEAR(FROM_UNIXTIME(Boekdatum)) AS Boekjaar, COUNT(*) AS AantalTransacties, SUM(Bedrag) AS TotaalBedrag');

                                        foreach($years as $year) {
                                            echo '<tr>';
                                                echo '<td>' . $year["Boekjaar"] . '</td>';
                                                echo '<td>' . $year["AantalTransacties"] . '</td>';
                                                echo '<td>&euro; ' . round($year["TotaalBedrag"], 2) . '</td>';
                                                echo '<td><a href="financial-year-details.php?year=' . $year["Boekjaar"] . '"><i class="fa fa-arrow-right"></i></a></td>';
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