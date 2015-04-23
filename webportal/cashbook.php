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

    <title><?php echo SITE_TITLE; ?> - Kasboek -</title>

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
                    <h1>Kasboek <small>Voeg toe</small></h1>
                </div>
                <p>Op deze pagina kunt u schepen zoeken.</p>


                <form class="clearfix horizontalSearchForm" id="searchShipForm" role="form" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="desc">Beschrijving:</label>
                        <input type="text" class="form-control" name="desc">
                    </div>
                    <div class="form-group">
                        <label for="minLengte">Bedrag:</label>
                        <input type="text" class="form-control" name="minLengte">
                    </div>
                    <div class="form-group">
                        <label for="maxLengte">Lengte (max):</label>
                        <input type="number" class="form-control" name="maxLengte">
                    </div>
                    <div class="form-group">
                        <label for="naamEigenaar">Naam eigenaar:</label>
                        <input type="text" class="form-control" name="naamEigenaar">
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-default ">Zoeken</button>
                    </div>
                </form>

                <hr/>
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