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

    <title><?php echo SITE_TITLE; ?> - Schepen</title>

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
                            <h1>Schepen <small>Mijn schepen</small></h1>
                        </div>
                        <p>Op deze pagina kunt u uw schepen beheren.</p>

                        <ul class="nav nav-tabs">
                            <li role="presentation" class="active"><a href="ships.php">Mijn schepen</a></li>
                            <li role="presentation"><a href="#">Schip toevoegen</a></li>
                            <li role="presentation"><a href="#">Schip verwijderen</a></li>
                            <li role="presentation"><a href="#">Zoek schip</a></li>
                        </ul>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">

                                <thead>
                                    <tr>
                                        <th colspan="2">Afbeelding</th>
                                        <th colspan="2">Naam</th>
                                        <th>Lengte (m)</th>
                                        <th>Ligplaats</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php

                                        $ships = getShips($mysqli, $memberID);

                                        foreach($ships as $ship) {
                                            echo '<tr>';
                                                echo '<td colspan="2">' . $ship["Afbeelding"] . '</td>';
                                                echo '<td colspan="2">' . $ship["Naam"] . '</td>';
                                                echo '<td>' . $ship["Lengte"] . '</td>';
                                                echo '<td><a href="moorings-details.php?id=' . $ship["Ligplaats"] . '"><i class="fa fa-arrow-right"></i></a></td>';
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