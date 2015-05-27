<?php
    require_once 'includes/globals.php';
	require_once 'includes/requireSession.php';
	require_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <?php

        include_once 'includes/head.php';

    ?>

    <title><?php echo SITE_TITLE; ?> - Webportal</title>

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
                        <h1>Welkom bij De 'n Ouwe Haven</h1>
                        <p>
                            Op dit portaal kunt u onder andere uw persoonlijke gegevens wijzigen, schepen toevoegen en havenplaatsen reserveren.<br>
                            Daarnaast kunt u hier al uw betalingen en facturen terugvinden.
                        </p>
                        <img src="images/zee.jpg" alt="Zee" />
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