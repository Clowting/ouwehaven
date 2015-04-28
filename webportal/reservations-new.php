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
                    $member = cleanInput($_POST['member']);
                    $schip = cleanInput($_POST['schip']);

                    if( validateNumber($haven, 1, 11) &&
                        validateNumber($member, 1, 11) &&
                        validateNumber($schip, 1, 11)) {

                        $data = array(
                            'Lid_ID' => $member,
                            'Schip_ID' => $schip
                        );

                        $insert = $dataManager->insert('oh_ships', $data);

                        if($insert) {
                            echo '<div class="alert alert-success" role="alert">De reservatie is succesvol toegevoegd!</div>';
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