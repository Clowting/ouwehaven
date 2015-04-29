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

    <title><?php echo SITE_TITLE; ?> - Rubrieken</title>

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
                            <h1>Rubrieken <small>Wijzigen</small></h1>
                        </div>
                        <p>Op deze pagina kunt u een rubriek wijzigen.</p>

                        <ul class="nav nav-tabs">
                            <li role="presentation"><a href="categories.php">Overzicht</a></li>
                            <li role="presentation"><a href="categories-add.php">Rubriek toevoegen</a></li>
                        </ul>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">

                                <?php

                                    if(
                                        isset($_GET['action']) &&
                                        !empty($_GET['action']) &&
                                        isset($_GET['id']) &&
                                        is_numeric($_GET['id'])
                                    ) {
                                        // EDIT action
                                        if($_GET['action'] == "edit") {

                                            if($_SERVER['REQUEST_METHOD'] == "POST") {
                                                if(
                                                    isset($_POST['name']) &&
                                                    validateInput($_POST['name'], 0, 128)
                                                ) {

                                                    $name = cleanInput($_POST['name']);

                                                    $data = array(
                                                        'Naam' => $name
                                                    );

                                                    $dataManager->where('ID', $_GET['id']);
                                                    $result = $dataManager->update('oh_categories', $data);

                                                    if($result) {
                                                        echo '<div class="alert alert-success" role="alert"><strong>1 rubriek</strong> succesvol gewijzigd!</div>';
                                                    }
                                                    else {
                                                        echo '<div class="alert alert-danger" role="alert">Er trad een fout op bij het wijzigen van de rubriek. Probeer het opnieuw.</div>';
                                                    }
                                                }
                                                else {
                                                    echo '<div class="alert alert-danger" role="alert">U gebruikte een ongeldig formulier of stuurde onjuiste gegevens. Probeer het opnieuw.</div>';
                                                }
                                            }

                                            $dataManager->where('ID', $_GET['id']);
                                            $category = $dataManager->getOne('oh_categories');

                                            if($dataManager->count > 0) {
                                                echo '<form role="form" method="post">';
                                                    echo '<div class="form-group">';
                                                        echo '<label for="name">Naam:</label>';
                                                        echo '<input type="text" class="form-control" value="' . $category['Naam'] . '" name="name" id="name">';
                                                    echo '</div>';

                                                    echo '<button type="submit" class="btn btn-default">Wijzigen</button>';
                                                echo '</form>';
                                            }
                                            else {
                                                echo '<div class="alert alert-danger" role="alert">U heeft mogelijk op een ongeldige link geklikt.</div>';
                                            }
                                        }
                                        elseif($_GET['action'] == "delete") {
                                            $dataManager->where('ID', $_GET['id']);
                                            $result = $dataManager->delete('oh_categories');

                                            if($result) {
                                                echo '<div class="alert alert-success"><strong>Succes!</strong> Rubriek is succesvol verwijderd.</div>';
                                            }
                                            else {
                                                echo '<div class="alert alert-warning"><strong>Waarschuwing!</strong> Rubriek kon niet verwijderd worden.</div>';
                                            }

                                            echo '<a href="categories.php" class="btn btn-default">Ga terug naar het overzicht</a>';
                                        }
                                    }
                                    else {
                                        echo '<div class="alert alert-danger" role="alert">U heeft mogelijk op een ongeldige link geklikt.</div>';
                                    }

                                ?>

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