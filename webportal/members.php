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

    <title><?php echo SITE_TITLE; ?> - Leden - Overzicht</title>

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
                        <h1>Leden <small>Overzicht</small></h1>
                    </div>
                    <p>Op deze pagina kunt u leden zoeken.</p>

                    <ul class="nav nav-tabs">
                        <li role="presentation" class="active"><a href="members.php">Overzicht</a></li>
                        <li role="presentation"><a href="members-add.php">Toevoegen</a></li>
                        <li role="presentation"><a href="members-remove.php">Verwijderen</a></li>
                    </ul>

                    <form class="clearfix horizontalSearchForm" id="searchMemberForm" role="form" method="POST" enctype="multipart/form-data">
                        <div class="col-md-12">
                            <div class="form-group col-md-12">
                                <label for="naam">Naam:</label>
                                <input type="text" class="form-control" id="naam" name="naam">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group col-md-3">
                                <label for="adres">Adres:</label>
                                <input type="text" class="form-control" id="adres" name="adres">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="postcode">Postcode:</label>
                                <input type="text" class="form-control" id="postcode" name="postcode">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="woonplaats">Woonplaats:</label>
                                <input type="text" class="form-control" id="woonplaats" name="woonplaats">
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
                                <th>Adres</th>
                                <th>Postcode</th>
                                <th>Woonplaats</th>
                                <th>Opties</th>
                            </tr>
                            </thead>

                            <tbody id="member-content">
                            <tr>
                                <td colspan=5">Zoek hierboven naar leden.</td>
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
    <script src="js/members-pagination.js"></script>
    <?php

        include_once 'includes/footer.php';

    ?>

</body>

</html>