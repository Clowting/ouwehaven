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

    <title><?php echo SITE_TITLE; ?> - Reserveringen - Aanvragen</title>

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
                    <h1>Reserveringen <small>Aanvragen</small></h1>
                </div>
                <p>Op deze pagina kunt u een reserveringen aanvragen.</p>

                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    $haven = cleanInput($_POST['haven']);
                    $eigenaar = cleanInput($_POST['eigenaar']);
                    $schip = cleanInput($_POST['schip']);

                    $nu = new DateTime();
                    $van = DateTime::createFromFormat('d/m/Y', $_POST['van']);
                    $tot = DateTime::createFromFormat('d/m/Y', $_POST['tot']);

                    $nu = $nu->format('Y-m-d');
                    $vanDatum = $van->format('Y-m-d');
                    $totDatum = $tot->format('Y-m-d');

                    if( validateNumber($haven, 1, 11) &&
                        validateNumber($schip, 1, 11) &&
                        validateDate($vanDatum, 'Y-m-d') &&
                        validateDate($totDatum, 'Y-m-d') &&
                        $vanDatum >= $nu &&
                        $totDatum > $nu &&
                        $vanDatum < $totDatum) {

                        $dataManager->where('Ship_ID', $schip);
                        $ms = $dataManager->get('oh_member_ship', 1);

                        if($ms[0]['Member_ID'] == $memberID) {

                            $sql = "SELECT *

                                FROM oh_moorings

                                WHERE oh_moorings.ID NOT IN (
                                    SELECT Ligplaats_ID
                                    FROM oh_mooring_reservations
                                    WHERE
                                        (Aankomstdatum BETWEEN CAST(? AS DATE) AND CAST(? AS DATE)) OR
                                        (Vertrekdatum BETWEEN CAST(? AS DATE) AND CAST(? AS DATE))
                                    )

                                    AND Haven_ID = ?

                                LIMIT 1
                                ";
                            $params = array($vanDatum, $totDatum, $vanDatum, $totDatum, $haven);

                            $ligplaatsen = $dataManager->rawQuery($sql, $params);
                            if (count($ligplaatsen) != 0) {

                                $ligplaatsID = $ligplaatsen[0]['ID'];

                                $data = array(
                                    'Lid_ID' => $memberID,
                                    'Ligplaats_ID' => $ligplaatsID,
                                    'Schip_ID' => $schip,
                                    'Aankomstdatum' => $vanDatum,
                                    'Vertrekdatum' => $totDatum,
                                    'Status' => '0'
                                );

                                $insert = $dataManager->insert('oh_mooring_reservations', $data);

                                if ($insert) {
                                    echo '<div class="alert alert-success" role="alert">De reservatie is succesvol toegevoegd!</div>';
                                    echo '<p>Klik <a href="reservations.php">hier</a> om verder te gaan.</p>';
                                } else {
                                    echo '<div class="alert alert-danger" role="alert">Het lijkt er op alsof er een fout is met de verbinding van de database...</div>';
                                    echo '<p>Klik <a href="reservations-request.php">hier</a> om het opnieuw te proberen.</p>';
                                }
                            } else {
                                echo '<div class="alert alert-warning" role="alert">Er zijn geen ligplaatsen meer beschikbaar op de ingegeven datum.</div>';
                                echo '<p>Klik <a href="reservations-request.php">hier</a> om het opnieuw te proberen.</p>';
                            }
                        } else {
                            echo '<div class="alert alert-danger" role="alert">Het lijkt er op alsof u een reservering probeert te maken voor iemand anders zijn schip.</div>';
                            echo '<p>Klik <a href="reservations-request.php">hier</a> om het opnieuw te proberen.</p>';
                        }
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Het lijkt er op alsof niet alle gegevens zijn ingevuld...</div>';
                        echo '<p>Klik <a href="reservations-request.php">hier</a> om het opnieuw te proberen.</p>';
                    }

                } else {
                    ?>
                    <form id="addReservationForm" role="form" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="haven">Kies een haven:</label>
                            <select class="form-control" name="haven" id="haven">
                                <option value="" selected disabled></option>
                                <?php

                                $harbors = $dataManager->get('oh_harbors');

                                foreach($harbors as $harbor) {
                                    echo '<option value="' . $harbor["ID"] . '">' . $harbor["Naam"] . '</option>';
                                }

                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="schip">Kies een schip:</label>
                            <select class="form-control" name="schip" id="schip">
                                <option value="" selected disabled></option>
                                <?php

                                $dataManager->join("oh_member_ship ms", "s.ID=ms.Ship_ID", "LEFT");
                                $dataManager->where("ms.Member_ID", $memberID);
                                $ships = $dataManager->get('oh_ships s', NULL, 's.ID, s.Naam');

                                foreach($ships as $ship) {
                                    echo '<option value="' . $ship["ID"] . '">' . $ship["Naam"] . '</option>';
                                }

                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="van">Van:</label>
                            <input type="text" value="<?php echo date("d/m/Y") ?>" class="form-control formDate" name="van" id="van">
                        </div>
                        <div class="form-group">
                            <label for="tot">Tot:</label>
                            <input type="text" value="<?php echo date("d/m/Y") ?>" class="form-control formDate" name="tot" id="tot">
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