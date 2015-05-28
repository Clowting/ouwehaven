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
                            <li role="presentation"><a href="ships-remove.php">Schip verwijderen</a></li>
                            <li role="presentation"><a href="ships-search.php">Zoek schip</a></li>
                        </ul>

                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                            $naam = cleanInput($_POST['naam']);
                            $lengte = $_POST['lengte'];
                            $trackingID = preg_replace('/\D/', '', $_POST['trackingID']);
                            $ligplaats = cleanInput($_POST['ligplaats']);
                            $imgURL;

                            if(isset($_FILES['afbeelding']['tmp_name']) && !empty($_FILES['afbeelding']['tmp_name'])) {
                                $tmp_name = $_FILES['afbeelding']['tmp_name'];
                                $name = $_FILES['afbeelding']['name'];

                                $allowedImageTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
                                $detectedImageType = exif_imagetype($tmp_name);

                                $shipsDir = "/webportal/images/ships";
                                $ext = pathinfo($name, PATHINFO_EXTENSION);
                                $imageName = sha1($naam . $memberID . time()) . '.' . $ext;
                                $fileUploaded = move_uploaded_file($tmp_name, $_SERVER['DOCUMENT_ROOT'] . "$shipsDir/$imageName");

                                if($fileUploaded) {
 
                                    $imgURL = "$shipsDir/$imageName";

                                }

                            }


                            if(($detectedImageType != null && in_array($detectedImageType, $allowedImageTypes)) || empty($imgURL)) {

                                if( validateInput($naam, 2, 128) &&
                                    validateNumber($lengte, 1, 16)) {

                                    $data = array(
                                        'Naam' => $naam,
                                        'Lengte' => $lengte,
                                        'ImgURL' => $imgURL,
                                        'TrackingID' => $trackingID
                                    );

                                    $insert = $dataManager->insert('oh_ships', $data);

                                    $data = array(
                                        'Member_ID' => $memberID,
                                        'Ship_ID' => $dataManager->getInsertId()
                                    );

                                    $insertLink = $dataManager->insert('oh_member_ship', $data);

                                    if($insert && $insertLink) {
                                        echo '<div class="alert alert-success" role="alert">Het schip is succesvol toegevoegd!</div>';
                                        echo '<p>Klik <a href="ships.php">hier</a> om verder te gaan.</p>';
                                    } else {
                                        echo '<div class="alert alert-danger" role="alert">Het lijkt er op alsof er een fout is met de verbinding van de database...</div>';
                                        echo '<p>Klik <a href="ships-add.php">hier</a> om het opnieuw te proberen.</p>';
                                    }

                                } else {
                                    echo '<div class="alert alert-danger" role="alert">Het lijkt er op alsof niet alle gegevens zijn ingevuld...</div>';
                                    echo '<p>Klik <a href="ships-add.php">hier</a> om het opnieuw te proberen.</p>';
                                }

                            } else {
                                echo '<div class="alert alert-danger" role="alert">De afbeelding die je probeert up te loaden is geen geldig type. PNG, JPEG en GIF zijn geldig.</div>';
                                echo '<p>Klik <a href="ships-add.php">hier</a> om het opnieuw te proberen.</p>';
                            }


                        } else {
                        ?>
                        <form id="addShipForm" role="form" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="naam">Naam schip:</label>
                                <input type="text" class="form-control" name="naam">
                            </div>
                            <div class="form-group">
                                <label for="lengte">Lengte:</label>
                                <input type="number" class="form-control" name="lengte">
                            </div>
                            <div class="form-group">
                                <label for="trackingID">Ship ID (Marine Traffic):</label>
                                <input type="number" class="form-control" name="trackingID">
                            </div>
                            <div class="form-group">
                                <label for="afbeelding">Kies een afbeelding:</label>
                                <input type="file" name="afbeelding" id="afbeelding">
                            </div>
                            <button type="submit" class="btn btn-primary">Verzenden
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