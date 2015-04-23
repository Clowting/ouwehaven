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

    <title><?php echo SITE_TITLE; ?> - Schepen - Mijn schepen</title>

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
                            <li role="presentation"><a href="ships-add.php">Schip toevoegen</a></li>
                            <li role="presentation"><a href="ships-remove.php">Schip verwijderen</a></li>
                            <li role="presentation"><a href="ships-search.php">Zoek schip</a></li>
                        </ul>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">

                                <thead>
                                    <tr>
                                        <th>Naam</th>
                                        <th>Lengte (m)</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php

                                        $sql = "SELECT s.ID AS ID, s.Naam AS Naam, s.Lengte AS Lengte
                                                FROM oh_members AS m, oh_member_ship AS ms, oh_ships AS s
                                                WHERE m.ID = ms.Member_ID AND s.ID = ms.Ship_ID AND m.ID = ?";
                                        $params = array($memberID);

                                        $ships = $dataManager->rawQuery($sql, $params);

                                        foreach($ships as $ship) {
                                            echo '<tr>';
                                                echo '<td>' . $ship["Naam"] . '</td>';
                                                echo '<td>' . round($ship["Lengte"], 2) . '</td>';
                                                echo '<td><a href="ships-details.php?id=' . $ship["ID"] . '"><i class="fa fa-arrow-right"></i></a></td>';
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