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
                    <h1>Schepen
                        <small>Schip verwijderen</small>
                    </h1>
                </div>
                <p>Op deze pagina kunt u een schip verwijderen.</p>

                <ul class="nav nav-tabs">
                    <li role="presentation"><a href="ships.php">Mijn schepen</a></li>
                    <li role="presentation"><a href="ships-add.php">Schip toevoegen</a></li>
                    <li role="presentation" class="active"><a href="ships-remove.php">Schip verwijderen</a></li>
                    <li role="presentation"><a href="ships-search.php">Zoek schip</a></li>
                </ul>

                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    $id = cleanInput($_POST['ID']);

                    if (validateNumber($id, 1, 11)) {

                        $dataManager->where('Ship_ID', $id);
                        $ms = $dataManager->get('oh_member_ship', 1);

                        if($ms[0]['Member_ID'] == $memberID) {

                            $dataManager->where('ID', $id);
                            $ship = $dataManager->get('oh_ships', 1);

                            if(!empty($ship[0]['ImgURL'])) {
                                $path = $_SERVER['DOCUMENT_ROOT'] . $ship[0]['ImgURL'];
                                if(file_exists($path)) {
                                    $removeImage = unlink($path);
                                }

                            }

                            $dataManager->where('Ship_ID', $id);
                            $removeLink = $dataManager->delete('oh_member_ship');

                            $dataManager->where('ID', $id);
                            $remove = $dataManager->delete('oh_ships');

                            if ($remove && $removeLink) {
                                echo '<div class="alert alert-success" role="alert">Het schip is succesvol verwijderd!</div>';
                                echo '<p>Klik <a href="ships.php">hier</a> om verder te gaan.</p>';
                            } else {
                                echo '<div class="alert alert-danger" role="alert">Het lijkt er op alsof er een fout is met de verbinding van de database...</div>';
                                echo '<p>Klik <a href="ships-remove.php">hier</a> om het opnieuw te proberen.</p>';
                            }

                        } else {
                            echo '<div class="alert alert-danger" role="alert">Het lijkt er op alsof u iemand anders zijn schip probeert te verwijderen.</div>';
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
                            <label for="ID">Kies een schip om te verwijderen:</label>
                            <select class="form-control" name="ID" id="ID">
                                <?php

                                $sql = "SELECT s.ID AS ID, s.ImgURL AS Afbeelding, s.Naam AS Naam, s.Lengte AS Lengte
                                        FROM oh_members AS m, oh_member_ship AS ms, oh_ships AS s
                                        WHERE m.ID = ms.Member_ID AND s.ID = ms.Ship_ID AND m.ID = ?";
                                $params = array($memberID);

                                $ships = $dataManager->rawQuery($sql, $params);

                                foreach ($ships as $ship) {
                                    echo '<option value="' . $ship["ID"] . '">' . $ship["Naam"] . '</option>';
                                }

                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-default">Verwijder
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