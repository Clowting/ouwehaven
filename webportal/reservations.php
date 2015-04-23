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
                        <li role="presentation"><a href="#">123</a></li>
                        <li role="presentation"><a href="#">456</a></li>
                        <li role="presentation"><a href="#">789</a></li>
                    </ul>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">

                            <thead>
                            <tr>
                                <th>1</th>
                                <th>2</th>
                                <th>3</th>
                                <th>4</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php

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