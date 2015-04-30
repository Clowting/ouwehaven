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

    <title><?php echo SITE_TITLE; ?> - Saldi</title>

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
                            <h1>Saldi</h1>
                        </div>
                        <p>Op deze pagina kunt u begin- en eindsaldi vastleggen.</p>

                        <ul class="nav nav-tabs">
                            <li role="presentation" class="active"><a href="balances.php">Overzicht</a></li>
                            <li role="presentation"><a href="balances-insert.php">Nieuwe meting</a></li>
                        </ul>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">

                                <thead>
                                    <tr>
                                        <th>Datum vastgesteld</th>
                                        <th>Startmeting</th>
                                        <th>Saldo</th>
                                        <th>Wijzigen</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php

                                        $dataManager->orderBy('ID', 'DESC');
                                        $balances = $dataManager->get('oh_balances');

                                        foreach($balances as $balance) {
                                            echo '<tr>';
                                                echo '<td>' . date("d/m/Y", strtotime($balance["Datum"])) . '</td>';
                                                echo '<td>' . (($balance["Startmeting"] == 1) ? "Ja" : "Nee") . '</td>';
                                                echo '<td>&euro; ' . round($balance["Saldo"], 2) . '</td>';
                                                echo '<td><a href="balances-details.php?id=' . $balance["ID"] . '"><i class="fa fa-arrow-right"></i></a></td>';
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