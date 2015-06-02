<?php
require_once 'includes/globals.php';
require_once 'includes/requireSession.php';
require_once 'includes/requireHavenmeester.php';
require_once 'includes/functions.php';
require_once 'includes/connectdb.php';
require_once 'includes/PHPMailer/PHPMailerAutoload.php';
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <?php

    include_once 'includes/head.php';

    ?>

    <title><?php echo SITE_TITLE; ?> - Reserveringen - Details</title>
    <script src="js/getShipLocation.js"></script>

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
                <?php

                if( isset($_GET['lidID']) && is_numeric($_GET['lidID']) &&
                    isset($_GET['ligplaatsID']) && is_numeric($_GET['ligplaatsID'])) {

                    $dataManager->join("oh_ships s", "s.ID=mr.Schip_ID", "LEFT");
                    $dataManager->join("oh_members m", "m.ID=mr.Lid_ID", "LEFT");
                    $dataManager->join("oh_users u", "m.User_ID=u.ID", "LEFT");
                    $dataManager->join("oh_moorings mo", "mo.ID=mr.Ligplaats_ID", "LEFT");
                    $dataManager->join("oh_harbors h", "h.ID=mo.Haven_ID", "LEFT");
                    $dataManager->where("mr.Lid_ID", $_GET['lidID']);
                    $dataManager->where("mr.Ligplaats_ID", $_GET['ligplaatsID']);
                    $result = $dataManager->getOne('oh_mooring_reservations mr', 's.Naam AS SchipNaam, s.Lengte, m.Voornaam, m.Tussenvoegsel, m.Achternaam, u.user_email, h.Naam AS HavenNaam, h.Breedtegraad, h.Lengtegraad, mo.Nummer, mr.Status, mr.Aankomstdatum, mr.Vertrekdatum');

                    if ($result) {

                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                            if (isset($_POST['btnApprove'])) {
                                $data = Array(
                                    'Status' => '2'
                                );
                            } else if (isset($_POST['btnPending'])) {
                                $data = Array(
                                    'Status' => '0'
                                );
                            } else if(isset($_POST['btnDeny'])) {
                                $data = Array (
                                    'Status' => '1'
                                );
                            }

                            $dataManager->where("Lid_ID", $_GET['lidID']);
                            $dataManager->where("Ligplaats_ID", $_GET['ligplaatsID']);

                            if ($dataManager->update('oh_mooring_reservations', $data)) {
                                echo '<div class="alert alert-success" role="alert">De reservatie is succesvol verwerkt!</div>';

                                if(isset($result["user_email"]) && !empty($result["user_email"])) {

                                    $mail = new PHPMailer;

                                    $mail->From = 'ouwehaven@clowting.me';
                                    $mail->FromName = "De 'n Ouwe Haven";
                                    $mail->addAddress($result["user_email"], $eigenaar);

                                    $mail->isHTML(true);
                                    $mail->Subject = 'Reservatie schip ' . date("d-m-Y", strtotime($result["Aankomstdatum"]));

                                    $mailBody    =  'Beste ' . $eigenaar . ',';
                                    $mailBody    .= '<br/>';
                                    $mailBody    .= '<br/>';
                                    $mailBody    .= 'De status van uw reservatie voor <b>' . $result["SchipNaam"] . '</b> is gewijzigd.';
                                    $mailBody    .= '<br/>';
                                    $mailBody    .= 'De nieuwe status is: <b>' . translateReservationStatus($result["Status"]) . '</b>.';
                                    $mailBody    .= '<br/>';
                                    $mailBody    .= '<br/>';
                                    $mailBody    .= 'Dit betreft de reservatie van <b>' . date("d-m-Y", strtotime($result["Aankomstdatum"])) . '</b> t/m <b>' . date("d-m-Y", strtotime($result["Vertrekdatum"])) . '</b>.';
                                    $mailBody    .= '<br/>';
                                    $mailBody    .= '<br/>';
                                    $mailBody    .= 'We hopen u hiermee voldoende te hebben geinformeerd.';
                                    $mailBody    .= '<br/>';
                                    $mailBody    .= '<br/>';
                                    $mailBody    .= 'Met vriendelijke groet,';
                                    $mailBody    .= '<br/>';
                                    $mailBody    .= '<br/>';
                                    $mailBody    .= "De 'n Ouwe Haven ";

                                    $mail->Body = $mailBody;

                                    if(!$mail->send()) {
                                        echo '<div class="alert alert-warning" role="alert">Er kon geen reservatie bevestiging worden verzonden. U kunt dit handmatig alsnog een mail sturen naar: ' . $result["user_email"] . '</div>';
                                        echo $mail->ErrorInfo;
                                    }

                                } else {
                                    echo '<div class="alert alert-warning" role="alert">Aangezien deze gebruiker geen e-mailadres heeft opgegeven kon deze niet op de hoogte worden gesteld van de statuswijziging.</div>';
                                }


                            } else {
                                echo '<div class="alert alert-danger" role="alert">Het lijkt er op alsof er een fout is met de verbinding van de database...</div>';
                            }

                        }

                        $eigenaar = generateName($result['Voornaam'], $result['Tussenvoegsel'], $result['Achternaam']);

                        echo '<div class="col-md-6">';
                            echo '<h4>Eigenaar & Schip</h4>';
                            echo '<div class="table-responsive">';
                                echo '<table class="table table-condensed">';

                                    echo '<tr>';
                                        echo '<td>Eigenaar</td>';
                                        echo '<td>' . $eigenaar . '</td>';
                                    echo '</tr>';

                                    echo '<tr>';
                                        echo '<td>Schip</td>';
                                        echo '<td>' . $result["SchipNaam"] . '</td>';
                                    echo '</tr>';

                                    echo '<tr>';
                                        echo '<td>Lengte</td>';
                                        echo '<td>' . round($result["Lengte"], 2) . 'm</td>';
                                    echo '</tr>';

                                echo '</table>';
                            echo '</div>';

                            echo '<h4>Haven & Ligplaats</h4>';
                            echo '<div class="table-responsive">';
                                echo '<table class="table table-condensed">';

                                    echo '<tr>';
                                        echo '<td>Haven</td>';
                                        echo '<td>' . $result["HavenNaam"] . '</td>';
                                    echo '</tr>';

                                    echo '<tr>';
                                        echo '<td>Ligplaats</td>';
                                        echo '<td>' . $result["Nummer"] . '</td>';
                                    echo '</tr>';

                                echo '</table>';
                            echo '</div>';

                            echo '<h4>Details</h4>';
                            echo '<div class="table-responsive">';
                                echo '<table class="table table-condensed">';

                                    echo '<tr>';
                                        echo '<td>Status</td>';
                                        echo '<td>' . translateReservationStatus($result["Status"]) . '</td>';
                                    echo '</tr>';

                                    echo '<tr>';
                                        echo '<td>Aankomstdatum</td>';
                                        echo '<td>' . date("d-m-Y", strtotime($result["Aankomstdatum"])) . '</td>';
                                    echo '</tr>';

                                    echo '<tr>';
                                        echo '<td>Vertrekdatum</td>';
                                        echo '<td>' . date("d-m-Y", strtotime($result["Vertrekdatum"])) . '</td>';
                                    echo '</tr>';

                                echo '</table>';
                            echo '</div>';

                            echo '<form id="processReservationForm" role="form" method="POST" enctype="multipart/form-data">';
                                echo '<div class="btn-group">';
                                    echo '<button type="submit" name="btnApprove" class="btn btn-success">Goedkeuren</button>';
                                    echo '<button type="submit" name="btnPending" class="btn btn-warning">Afwachten</button>';
                                    echo '<button type="submit" name="btnDeny" class="btn btn-danger">Afkeuren</button>';
                                echo '</div>';
                            echo '</form>';

                        echo '</div>'
                        ;
                        echo '<div class="col-md-6">';
                            echo '<h4>Locatie</h4>';
                            echo '<div id="map-canvas"></div>';
                            echo '<script>generateMap(' . $result["Breedtegraad"] . ', ' . $result["Lengtegraad"] . ', 18)</script>';
                        echo '</div>';

                    }
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