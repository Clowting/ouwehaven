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
                            <li role="presentation" class="active"><a href="categories.php">Overzicht</a></li>
                            <li role="presentation"><a href="categories-add.php">Rubriek toevoegen</a></li>
                        </ul>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">

                                <?php

                                    $dataManager->join('oh_transactions', 'oh_categories.ID = oh_transactions.Categorie_ID', 'LEFT');
                                    $dataManager->groupBy('oh_categories.ID');
                                    $categories = $dataManager->get('oh_categories', NULL,
                                        'oh_categories.ID AS Categorie_ID,
                                        oh_categories.Naam AS Categorie_Naam,
                                        COUNT(oh_transactions.ID) AS AantalTransacties,
                                        MAX(oh_transactions.Boekdatum) AS LaatsteBoekdatum');

                                    echo '<thead>';
                                        echo '<tr>';
                                            echo '<th>#</th>';
                                            echo '<th>Naam</th>';
                                            echo '<th>Aantal transacties</th>';
                                            echo '<th>Laatste transactie</th>';
                                            echo '<th colspan="2">Aanpassen</th>';
                                            echo '<th>Bekijk rubriek</th>';
                                        echo '</tr>';
                                    echo '</thead>';

                                    echo '<tbody>';
                                        foreach ($categories as $category) {
                                            echo '<tr>';
                                                echo '<td>' . $category["Categorie_ID"] . '</td>';
                                                echo '<td>' . $category["Categorie_Naam"] . '</td>';
                                                echo '<td>' . $category["AantalTransacties"] . '</td>';
                                                echo '<td>' . (!empty($category["LaatsteBoekdatum"]) ? date("d-m-Y", $category["LaatsteBoekdatum"]) : "Onbekend") . '</td>';
                                                echo '<td><a href="categories-edit.php?action=edit&id=' . $category["Categorie_ID"] . '"><i class="fa fa-pencil"></i></a></td>';
                                                echo '<td><a href="categories-edit.php?action=delete&id=' . $category["Categorie_ID"] . '"><i class="fa fa-trash"></i></a></td>';
                                                echo '<td><a href="categories-details.php?id=' . $category["Categorie_ID"] . '"><i class="fa fa-arrow-right"></i></a></td>';
                                            echo '</tr>';
                                        }
                                    echo '</tbody>';

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