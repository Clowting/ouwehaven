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

    <title><?php echo SITE_TITLE; ?> - Schepen - Toevoegen</title>

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
                            <h1>Schepen <small>Schip toevoegen</small></h1>
                        </div>
                        <p>Op deze pagina kunt u een schip toevoegen.</p>

                        <ul class="nav nav-tabs">
                            <li role="presentation"><a href="ships.php">Mijn schepen</a></li>
                            <li role="presentation" class="active"><a href="ships-add.php">Schip toevoegen</a></li>
                            <li role="presentation"><a href="#">Schip verwijderen</a></li>
                            <li role="presentation"><a href="#">Zoek schip</a></li>
                        </ul>

                        <form id="addShipForm" role="form" method="POST">
                            <div class="form-group">
                                <label for="naam">Naam schip:</label>
                                <input type="text" class="form-control" name="naam">
                            </div>
                            <div class="form-group">
                                <label for="lengte">Lengte:</label>
                                <input type="number" class="form-control" name="lengte">
                            </div>
                            <div class="form-group">
                                <label for="afbeelding">Kies een afbeelding:</label>
                                <input type="file" name="afbeelding" id="afbeelding">
                            </div>
                            <div class="form-group">
                                <label for="ligplaats">Kies een ligplaats:</label>
                                <select class="form-control" name="ligplaats" id="ligplaats">
                                    <?php

                                        $moorings = getMoorings($mysqli);

                                        foreach($moorings as $mooring) {
                                            echo '<option value="' . $mooring["ID"] . '">' . $mooring["Naam"] . '</option>';
                                        }

                                    ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-default">Verzenden
                            </button>
                        </form>

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