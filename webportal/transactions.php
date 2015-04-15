<?php
	require 'includes/requireSession.php';
	require 'includes/functions.php';
    require 'includes/connectdb.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>D'n ouwe haven - Transacties</title>

    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

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
                            <h1>Transacties <small>Credit</small></h1>
                        </div>
                        <p>Op deze pagina vindt u een overzicht van de transacties.</p>

                        <ul class="nav nav-tabs">
                            <li role="presentation" class="active"><a href="transactions.php">Credit</a></li>
                            <li role="presentation"><a href="transactions-debet.php">Debet</a></li>
                            <li role="presentation"><a href="transactions-import.php">Importeer transacties</a></li>
                            <li role="presentation"><a href="transactions-search.php">Zoek transactie</a></li>
                        </ul>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Boekdatum</th>
                                        <th>Rekeningnummer</th>
                                        <th>Tegenrekening</th>
                                        <th>Houder tegenrekening</th>
                                        <th>Bedrag</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php

                                        $transactions = getTransactions($mysqli, 'C');

                                        foreach($transactions as $transaction) {
                                            echo '<tr>';
                                                echo '<td>' . $transaction["ID"] . '</td>';
                                                echo '<td>' . $transaction["Boekdatum"] . '</td>';
                                                echo '<td>' . $transaction["Rekeningnummer"] . '</td>';
                                                echo '<td>' . $transaction["Tegenrekening"] . '</td>';
                                                echo '<td>' . $transaction["Naam_Ontvanger"] . '</td>';
                                                echo '<td>&euro;' . $transaction["Bedrag"] . '</td>';
                                            echo '</tr>';
                                        }

                                    ?>
                                </tbody>

                            </table>
                        </div>

                        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
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