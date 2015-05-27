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

    <title><?php echo SITE_TITLE; ?> - Reserveringen - Nieuw</title>

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
                    <h1>Reserveringen <small>Nieuw</small></h1>
                </div>
                <p>Op deze pagina kunt u nieuwe reserveringen toevoegen.</p>

                <ul class="nav nav-tabs">
                    <li role="presentation"><a href="reservations.php">In afwachting</a></li>
                    <li role="presentation"><a href="reservations-denied.php">Geweigerd</a></li>
                    <li role="presentation"><a href="reservations-approved.php">Geaccepteerd</a></li>
                    <li role="presentation" class="active"><a href="reservations-new.php">Nieuw</a></li>
                </ul>

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
                        validateNumber($eigenaar, 1, 11) &&
                        validateNumber($schip, 1, 11) &&
                        validateDate($vanDatum, 'Y-m-d') &&
                        validateDate($totDatum, 'Y-m-d') &&
                        $vanDatum >= $nu &&
                        $totDatum > $nu &&
                        $vanDatum < $totDatum) {

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
                        if(count($ligplaatsen) != 0) {

                            $ligplaatsID = $ligplaatsen[0]['ID'];

                            $data = array(
                                'Lid_ID' => $eigenaar,
                                'Ligplaats_ID' => $ligplaatsID,
                                'Schip_ID' => $schip,
                                'Aankomstdatum' => $vanDatum,
                                'Vertrekdatum' => $totDatum,
                                'Status' => '2'
                            );

                            $insert = $dataManager->insert('oh_mooring_reservations', $data);

                            if ($insert) {
                                echo '<div class="alert alert-success" role="alert">De reservatie is succesvol toegevoegd!</div>';
                                echo '<p>Klik <a href="reservations.php">hier</a> om verder te gaan.</p>';
                            } else {
                                echo '<div class="alert alert-danger" role="alert">Het lijkt er op alsof er een fout is met de verbinding van de database...</div>';
                                echo '<p>Klik <a href="reservations-new.php">hier</a> om het opnieuw te proberen.</p>';
                            }
                        } else {
                            echo '<div class="alert alert-warning" role="alert">Er zijn geen ligplaatsen meer beschikbaar op de ingegeven datum.</div>';
                            echo '<p>Klik <a href="reservations-new.php">hier</a> om het opnieuw te proberen.</p>';
                        }
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Het lijkt er op alsof niet alle gegevens zijn ingevuld...</div>';
                        echo '<p>Klik <a href="reservations-new.php">hier</a> om het opnieuw te proberen.</p>';
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
                            <label for="eigenaar">Kies een eigenaar:</label>
                            <select class="form-control" name="eigenaar" id="eigenaar">
                                <option value="" selected disabled></option>
                                <?php

                                $members = $dataManager->get('oh_members');

                                foreach($members as $member) {
                                    $eigenaar = generateName($member['Voornaam'], $member['Tussenvoegsel'], $member['Achternaam']);

                                    echo '<option value="' . $member["ID"] . '">' . $eigenaar . '</option>';
                                }

                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="schip">Kies een schip:</label>
                            <select disabled class="form-control" name="schip" id="schip">

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