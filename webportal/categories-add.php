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
                            <h1>Rubrieken <small>Overzicht</small></h1>
                        </div>
                        <p>Op deze pagina vindt u een overzicht van de rubrieken.</p>

                        <ul class="nav nav-tabs">
                            <li role="presentation"><a href="categories.php">Overzicht</a></li>
                            <li role="presentation" class="active"><a href="categories-add.php">Rubriek toevoegen</a></li>
                        </ul>

                        <?php

                        if($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if(
                                isset($_POST['name']) &&
                                validateInput($_POST['name'], 0, 128)
                            ) {

                                $name = cleanInput($_POST['name']);

                                $data = array(
                                    'Naam' => $name
                                );

                                $result = $dataManager->insert('oh_categories', $data);

                                if($result) {
                                    echo '<div class="alert alert-success" role="alert"><strong>1 rubriek</strong> succesvol toegevoegd!</div>';
                                }
                                else {
                                    echo '<div class="alert alert-danger" role="alert">Er trad een fout op bij het aanmaken van de rubriek. Probeer het opnieuw.</div>';
                                }
                            }
                            else {
                                echo '<div class="alert alert-danger" role="alert">U gebruikte een ongeldig formulier of stuurde onjuiste gegevens. Probeer het opnieuw.</div>';
                            }
                        }

                        ?>

                        <form role="form" method="post">
                            <div class="form-group">
                                <label for="name">Naam:</label>
                                <input type="text" class="form-control" name="name" id="name">
                            </div>

                            <button type="submit" class="btn btn-primary">Rubriek toevoegen</button>
                        </form>
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