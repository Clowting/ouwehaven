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

    <title><?php echo SITE_TITLE; ?> - Reserveringen - Details</title>

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
                    <h1>Reserveringen <small>Details</small></h1>
                </div>
                <p>Op deze pagina vindt u de details van een reservering.</p>

                <ul class="nav nav-tabs">
                    <li role="presentation"><a href="reservations.php">In afwachting</a></li>
                    <li role="presentation"><a href="reservations-denied.php">Geweigerd</a></li>
                    <li role="presentation"><a href="reservations-approved.php">Geaccepteerd</a></li>
                    <li role="presentation"><a href="reservations-new.php">Nieuw</a></li>
                </ul>

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