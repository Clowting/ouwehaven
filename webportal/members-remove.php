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

    <title><?php echo SITE_TITLE; ?> - Leden - Verwijderen</title>

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
                    <h1>Leden
                        <small>Verwijderen</small>
                    </h1>
                </div>
                <p>Op deze pagina kunt u nieuwe mensen uit het systeem verwijderen.</p>

                <ul class="nav nav-tabs">
                    <li role="presentation"><a href="members-add.php">Toevoegen</a></li>
                    <li role="presentation" class="active"><a href="members-remove.php">Verwijderen</a></li>
                </ul>

                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    $member = cleanInput($_POST['member']);

                    if (validateNumber($member, 1, 11)) {

                        $dataManager->where('ID', $member);
                        $remove = $dataManager->delete('oh_members');

                        if ($remove) {
                            echo '<div class="alert alert-success" role="alert">Het lid is succesvol verwijderd!</div>';
                        } else {
                            echo '<div class="alert alert-danger" role="alert">Het lijkt er op alsof er een fout is met de verbinding van de database...</div>';
                            echo '<p>Klik <a href="members-remove.php">hier</a> om het opnieuw te proberen.</p>';
                        }

                    } else {
                        echo '<div class="alert alert-danger" role="alert">Het lijkt er op alsof niet alle gegevens zijn ingevuld...</div>';
                        echo '<p>Klik <a href="members-remove.php">hier</a> om het opnieuw te proberen.</p>';
                    }

                } else {
                    ?>
                    <form role="form" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="ID">Kies een lid om te verwijderen:</label>
                            <select class="form-control" name="member" id="member">
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