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
                    <h1>Schepen <small>Zoek schepen</small></h1>
                </div>
                <p>Op deze pagina kunt u schepen zoeken.</p>

                <ul class="nav nav-tabs">
                    <li role="presentation"><a href="ships.php">Mijn schepen</a></li>
                    <li role="presentation"><a href="ships-add.php">Schip toevoegen</a></li>
                    <li role="presentation"><a href="ships-remove.php">Schip verwijderen</a></li>
                    <li role="presentation" class="active"><a href="ships-search.php">Zoek schip</a></li>
                </ul>

                <form class="clearfix horizontalSearchForm" id="searchShipForm" role="form" method="POST" enctype="multipart/form-data">
                    <div class="form-group col-md-3">
                        <label for="naam">Naam schip:</label>
                        <input type="text" class="form-control" name="naam">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="ligplaats">Kies een ligplaats:</label>
                        <select class="form-control" name="ligplaats" id="ligplaats">
                            <?php

                            $moorings = $dataManager->get('oh_moorings');

                            foreach($moorings as $mooring) {
                                echo '<option value="' . $mooring["ID"] . '">' . $mooring["Naam"] . '</option>';
                            }

                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-1">
                        <label for="minLengte">Lengte (min):</label>
                        <input type="number" class="form-control" name="minLengte">
                    </div>
                    <div class="form-group col-md-1">
                        <label for="maxLengte">Lengte (max):</label>
                        <input type="number" class="form-control" name="maxLengte">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="naamEigenaar">Naam eigenaar:</label>
                        <input type="text" class="form-control" name="naamEigenaar">
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-default ">Zoeken</button>
                    </div>
                </form>

                <hr/>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">

                        <thead>
                        <tr>
                            <th>Naam</th>
                            <th>Lengte (m)</th>
                            <th>Eigenaar</th>
                            <th>Details</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php

                        $sql = "SELECT s.ID AS ID, s.Naam AS Naam, s.Lengte AS Lengte, m.Voornaam AS Voornaam, m.Tussenvoegsel AS Tussenvoegsel, m.Achternaam AS Achternaam
                                FROM oh_members AS m, oh_member_ship AS ms, oh_ships AS s
                                WHERE m.ID = ms.Member_ID AND s.ID = ms.Ship_ID";

                        $ships = $dataManager->rawQuery($sql);

                        foreach($ships as $ship) {
                            if(!empty($ship['Tussenvoegsel'])) {
                                $eigenaar = $ship['Voornaam'] . ' ' . $ship['Tussenvoegsel'] . ' ' . $ship['Achternaam'];
                            } else {
                                $eigenaar = $ship['Voornaam'] . ' ' . $ship['Achternaam'];
                            }

                            echo '<tr>';;
                            echo '<td>' . $ship["Naam"] . '</td>';
                            echo '<td>' . round($ship["Lengte"], 2) . '</td>';
                            echo '<td>' . $eigenaar .'</td>';
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