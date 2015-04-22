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

    <title><?php echo SITE_TITLE; ?> - Schepen - Verwijderen</title>

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
                            <h1>Schepen <small>Schip verwijderen</small></h1>
                        </div>
                        <p>Op deze pagina kunt u een schip verwijderen.</p>

                        <ul class="nav nav-tabs">
                            <li role="presentation"><a href="ships.php">Mijn schepen</a></li>
                            <li role="presentation"><a href="ships-add.php">Schip toevoegen</a></li>
                            <li role="presentation" class="active"><a href="ships-remove.php">Schip verwijderen</a></li>
                            <li role="presentation"><a href="#">Zoek schip</a></li>
                        </ul>

                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                            $id = cleanInput($_POST['ID']);

                            if(validateNumber($id, 1, 11)) {

                                $sql = "DELETE FROM oh_member_ship
                                        WHERE Ship_ID=" . $id;

                                $removeLink = $mysqli->query($sql);


                                $sql = "DELETE FROM oh_ships
                                        WHERE ID=" . $id;

                                $remove = $mysqli->query($sql);

                                if($remove && $removeLink) {
                                    echo '<div class="alert alert-success" role="alert">Het schip is succesvol verwijderd!</div>';
                                    echo '<p>Klik <a href="ships.php">hier</a> om verder te gaan.</p>';
                                } else {
                                    echo '<div class="alert alert-danger" role="alert">Het lijkt er op alsof er een fout is met de verbinding van de database...</div>';
                                    echo '<p>Klik <a href="ships-remove.php">hier</a> om het opnieuw te proberen.</p>';
                                }

                            } else {
                                echo '<div class="alert alert-danger" role="alert">Het lijkt er op alsof niet alle gegevens zijn ingevuld...</div>';
                                echo '<p>Klik <a href="ships-remove.php">hier</a> om het opnieuw te proberen.</p>';
                            }

                        } else {
                        ?>
                        <form role="form" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="ID">Kies een ligplaats:</label>
                                <select class="form-control" name="ID" id="ID">
                                    <?php

                                        $ships = getShips($mysqli, $memberID);

                                        foreach($ships as $ship) {
                                            echo '<option value="' . $ship["ID"] . '">' . $ship["Naam"] . '</option>';
                                        }

                                    ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-default">Verzenden
                            </button>
                        </form>
                        <?php
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