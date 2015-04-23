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

    <title><?php echo SITE_TITLE; ?> - Schepen - Details</title>

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
                    <h1>Schepen <small>Details</small></h1>
                </div>
                <p>Op deze pagina kunt u details van schepen bekijken.</p>

                <ul class="nav nav-tabs">
                    <li role="presentation"><a href="ships.php">Mijn schepen</a></li>
                    <li role="presentation"><a href="ships-add.php">Schip toevoegen</a></li>
                    <li role="presentation"><a href="ships-remove.php">Schip verwijderen</a></li>
                    <li role="presentation"><a href="ships-search.php">Zoek schip</a></li>
                </ul>
                <?php

                    if(isset($_GET['id']) && is_numeric($_GET['id'])) {
                        $dataManager->join("oh_moorings m", "s.Ligplaats_ID=m.ID", "LEFT");
                        $dataManager->where('s.ID', $_GET['id']);
                        $result = $dataManager->get('oh_ships s', 1, 's.Naam, s.Lengte, s.ImgURL, m.Breedtegraad, m.Lengtegraad');

                        if($result !== false && !empty($result[0])) {
                            $ship = $result[0];

                            echo '<div class="col-md-6">';
                            // Details
                                echo '<h4>Details</h4>';
                                echo '<div class="table-responsive">';
                                echo '<table class="table table-condensed">';
                                echo '<tr>';
                                echo '<td>Naam</td>';
                                echo '<td>' . $ship["Naam"] . '</td>';
                                echo '</tr>';

                                echo '<tr>';
                                echo '<td>Lengte</td>';
                                echo '<td>' . $ship["Lengte"] . 'm</td>';
                                echo '</tr>';

                                echo '</table>';
                                echo '</div>';

                                echo '<h4>Locatie</h4>';
                                echo '<div id="map-canvas"></div>';
                                echo '<script>generateMap(' . $ship["Breedtegraad"] . ',' . $ship["Lengtegraad"] . ')</script>';

                            echo '</div>';

                            echo '<div class="col-md-6">';
                                echo '<h4>Afbeelding</h4>';
                                echo '<img src="timthumb.php?src=' . $ship["ImgURL"] . '&q=100&w=960"/>';
                            echo '</div>';
                        }
                    }

                ?>
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