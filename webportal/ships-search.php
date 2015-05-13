<?php
require_once 'includes/globals.php';
require_once 'includes/requireSession.php';
require_once 'includes/functions.php';
require_once 'includes/connectdb.php';
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <?php

        include_once 'includes/head.php';

    ?>

    <title><?php echo SITE_TITLE; ?> - Schepen - Zoeken</title>

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
                        <div class="col-md-12">
                            <div class="form-group col-md-12">
                                <label for="naam">Naam schip:</label>
                                <input type="text" class="form-control" name="naam">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group col-md-3">
                                <label for="minLengte">Lengte (min):</label>
                                <input type="number" class="form-control" name="minLengte">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="maxLengte">Lengte (max):</label>
                                <input type="number" class="form-control" name="maxLengte">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="naamEigenaar">Naam eigenaar:</label>
                                <input type="text" class="form-control" name="naamEigenaar">
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-default ">Zoeken</button>
                            </div>
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

                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                                $naamSchip = cleanInput($_POST['naam']);
                                $minLengte = $_POST['minLengte'];
                                $maxLengte = $_POST['maxLengte'];
                                $naamEigenaar = $_POST['naamEigenaar'];

                                if(validateInput($naamSchip, 2, 128)) {
                                    $dataManager->orWhere('Naam', '%' . $naamSchip . '%', 'LIKE');
                                }

                                if(validateNumber($minLengte, 1, 16) && validateNumber($maxLengte, 1, 16)) {
                                    $dataManager->orWhere('Lengte', Array($minLengte, $maxLengte), 'BETWEEN');
                                } else if (validateNumber($minLengte, 1, 16)) {
                                    $dataManager->orWhere('Lengte', $minLengte, '>=');
                                } else if (validateNumber($maxLengte, 1, 16)) {
                                    $dataManager->orWhere('Lengte', $maxLengte, '<=');
                                }

                                if(validateInput($naamEigenaar, 2, 512)) {
                                    $naamArray = explode(' ', $naamEigenaar);
                                    array_walk($naamArray, function(&$value) {
                                        $value = '%' . $value . '%';
                                    });

                                    foreach ($naamArray as $naam) {
                                        $dataManager->orWhere('Voornaam', $naam, 'LIKE');
                                        $dataManager->orWhere('Achternaam', $naam, 'LIKE');
                                        $dataManager->orWhere('Tussenvoegsel', $naam, 'LIKE');
                                    }
                                }

                            }

                            $ships = $dataManager->get('oh_search_ship');

                            foreach ($ships as $ship) {

                                $eigenaar = generateName($ship['Voornaam'], $ship['Tussenvoegsel'], $ship['Achternaam']);

                                echo '<tr>';;
                                echo '<td>' . $ship["Naam"] . '</td>';
                                echo '<td>' . round($ship["Lengte"], 2) . '</td>';
                                echo '<td>' . $eigenaar . '</td>';
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