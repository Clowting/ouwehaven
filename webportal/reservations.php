<?php
    require_once 'includes/globals.php';
    require_once 'includes/requireSession.php';
    require_once 'includes/requireHavenmeester.php';
    require_once 'includes/functions.php';
    require_once 'includes/connectdb.php';
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <?php

        include_once 'includes/head.php';

    ?>

    <title><?php echo SITE_TITLE; ?> - Reserveringen - In afwachting</title>

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
                        <h1>Reserveringen <small>In afwachting</small></h1>
                    </div>
                    <p>Op deze pagina vindt u de reserveringen in afwachting.</p>

                    <ul class="nav nav-tabs">
                        <li role="presentation" class="active"><a href="reservations.php">In afwachting</a></li>
                        <li role="presentation"><a href="reservations-denied.php">Geweigerd</a></li>
                        <li role="presentation"><a href="reservations-approved.php">Geaccepteerd</a></li>
                        <li role="presentation"><a href="reservations-new.php">Nieuw</a></li>
                    </ul>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">

                            <thead>
                            <tr>
                                <th>Lid</th>
                                <th>Schip</th>
                                <th>Van</th>
                                <th>Tot</th>
                                <th>Beoordeel</th>
                            </tr>
                            </thead>

                            <tbody>
                                <?php
                                $dataManager->join("oh_ships s", "s.ID=mr.Schip_ID", "LEFT");
                                $dataManager->join("oh_members m", "m.ID=mr.Lid_ID", "LEFT");
                                $dataManager->where("mr.Status", 0);
                                $reservations = $dataManager->get('oh_mooring_reservations mr', NULL, 's.Naam, m.Voornaam, m.Tussenvoegsel, m.Achternaam, mr.Lid_ID, mr.Ligplaats_ID, mr.Aankomstdatum, mr.Vertrekdatum');

                                    foreach($reservations as $reservation) {

                                        $lid = generateName($reservation['Voornaam'], $reservation['Tussenvoegsel'], $reservation['Achternaam']);

                                        echo '<tr>';
                                            echo '<td>' . $lid . '</td>';
                                            echo '<td>' . $reservation["Naam"] . '</td>';
                                            echo '<td>' . $reservation["Aankomstdatum"] . '</td>';
                                            echo '<td>' . $reservation["Vertrekdatum"] . '</td>';
                                            echo '<td><a href="reservations-details.php?lidID=' . $reservation["Lid_ID"] . '&ligplaatID=' . $reservation["Ligplaats_ID"] . '"><i class="fa fa-arrow-right"></i></a></td>';
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