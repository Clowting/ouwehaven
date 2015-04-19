<?php
    require_once 'includes/globals.php';
	require_once 'includes/requireSession.php';
    require_once 'includes/requirePenningmeester.php';
	require_once 'includes/functions.php';
    require_once 'includes/connectdb.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php

        include_once 'includes/head.php';

    ?>

    <title><?php echo SITE_TITLE; ?> - Transacties - Details</title>

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
                            <h1>Transacties <small>Details</small></h1>
                        </div>
                        <p>Op deze pagina vindt u details van een transactie.</p>

                        <ul class="nav nav-tabs">
                            <li role="presentation"><a href="transactions.php">Credit</a></li>
                            <li role="presentation"><a href="transactions-debet.php">Debet</a></li>
                            <li role="presentation"><a href="transactions-import.php">Importeer transacties</a></li>
                            <li role="presentation"><a href="transactions-search.php">Zoek transactie</a></li>
                        </ul>

                        <?php

                            if(isset($_GET['id'])) {
                                $transactie = getTransaction($mysqli, $_GET['id']);

                                if($transactie !== false) {
                                    echo '<div class="col-xs-12 col-md-7">';
                                        // Details
                                        echo '<h4>Details</h4>';
                                        echo '<div class="table-responsive">';
                                            echo '<table class="table table-condensed">';
                                                echo '<tr>';
                                                    echo '<td>Transactie ID</td>';
                                                    echo '<td>' . $transactie["ID"] . '</td>';
                                                echo '</tr>';

                                                echo '<tr>';
                                                    echo '<td>Rekeningnummer</td>';
                                                    echo '<td>' . $transactie["Rekeningnummer"] . '</td>';
                                                echo '</tr>';

                                                echo '<tr>';
                                                    echo '<td>Rentedatum</td>';
                                                    echo '<td>' . $transactie["Rentedatum"] . '</td>';
                                                echo '</tr>';

                                                echo '<tr>';
                                                    echo '<td>Boekdatum</td>';
                                                    echo '<td>' . $transactie["Boekdatum"] . '</td>';
                                                echo '</tr>';

                                                echo '<tr>';
                                                    echo '<td>Boekcode</td>';
                                                    echo '<td>' . $transactie["Boekcode"] . '</td>';
                                                echo '</tr>';

                                                if(!empty($transactie["Mandaat_ID"])) {
                                                    echo '<tr>';
                                                        echo '<td>Mandaat ID</td>';
                                                        echo '<td>' . $transactie["Mandaat_ID"] . '</td>';
                                                    echo '</tr>';
                                                }
                                            echo '</table>';
                                        echo '</div>';

                                        // Tegenrekeninghouder
                                        echo '<h4>Tegenrekeninghouder</h4>';
                                        echo '<div class="table-responsive">';
                                            echo '<table class="table table-condensed">';
                                                echo '<tr>';
                                                    echo '<td>Houder</td>';
                                                    echo '<td>' . $transactie["Naam_Ontvanger"] . '</td>';
                                                echo '</tr>';

                                                echo '<tr>';
                                                    echo '<td>Rekeningnummer</td>';
                                                    echo '<td>' . $transactie["Tegenrekening"] . '</td>';
                                                echo '</tr>';

                                                if(!empty($transactie["Tegenrekeninghouder_ID"])) {
                                                    echo '<tr>';
                                                        echo '<td>Tegenrekeninghouder ID</td>';
                                                        echo '<td>' . $transactie["Tegenrekeninghouder_ID"] . '</td>';
                                                    echo '</tr>';
                                                }
                                            echo '</table>';
                                        echo '</div>';
                                    echo '</div>';

                                    echo '<div class="col-xs-12 col-md-5">';
                                        if($transactie["Code"] == "C") {
                                            echo '<h2 class="amount amount-credit align-right">&euro; ' . $transactie["Bedrag"] . ' <i class="fa fa-angle-up"></i></h2>';
                                        }
                                        else {
                                            echo '<h2 class="amount amount-debit align-right">&euro; ' . $transactie["Bedrag"] . ' <i class="fa fa-angle-down"></i></h2>';
                                        }

                                        echo '<h4>Omschrijving</h4>';
                                        echo '<p>' . $transactie["Omschrijving"] . '</p>';
                                    echo '</div>';
                                }
                                else {
                                    echo '<div class="alert alert-warning"><strong>Waarschuwing!</strong> Ongeldig transactie ID.</div>';
                                }
                            }
                            else {
                                echo '<div class="alert alert-info"><strong>Fout!</strong> U heeft waarschijnlijk op een verkeerde link geklikt.</div>';
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