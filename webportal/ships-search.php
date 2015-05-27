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
                                <input type="text" class="form-control" id="naam" name="naam">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group col-md-3">
                                <label for="minLengte">Lengte (min):</label>
                                <input type="number" class="form-control" id="minLengte" name="minLengte">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="maxLengte">Lengte (max):</label>
                                <input type="number" class="form-control" id="maxLengte" name="maxLengte">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="naamEigenaar">Naam eigenaar:</label>
                                <input type="text" class="form-control" id="naamEigenaar" name="naamEigenaar">
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary ">Zoeken</button>
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

                            <tbody id="ship-content">
                            <tr>
                                <td colspan="4">Zoek hierboven naar schepen.</td>
                            </tr>
                            </tbody>

                        </table>
                    </div>
                    <div class="text-center" id="page-selection">
                        <ul id="pagination"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Footer -->
    <script src="js/pagination.js"></script>
    <?php

        include_once 'includes/footer.php';

    ?>

</body>

</html>