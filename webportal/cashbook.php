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

    <title><?php echo SITE_TITLE; ?> - Kasboek </title>

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
                    <h1>Kasboek
                        <small>Zoeken</small>
                    </h1>


                </div>

                <p>Op deze pagina kunt u gegevens in het kasboek zetten, deze worden direct opgeslagen wanneer u op
                    volgende drukt</p>

                <p>Wanneer u meerdere kasboek gegevens wilt invoeren, kunt u kiezen voor "nog 1 toevoegen, wanneer u
                    klaar bent kunt u weer op volgende drukken om verder te gaan</p>

                <ul class="nav nav-tabs">
                    <li role="presentation" class="active"><a href="cashbook.php">Alle Kasboektransacties</a></li>
                    <li role="presentation"><a href="cashbook-add.php">Voeg toe aan Kasboek</a></li>

                </ul>
                <form class="clearfix horizontalSearchForm" id="searchCashBook" role="form" method="POST"
                      enctype="multipart/form-data">


                    <div class="form-group col-md-8">
                        <label for="desc">Beschrijving:</label>
                        <input type="text" class="form-control" name="desc" id="desc">
                    </div>

                    <div class="form-group col-md-2">
                        <label for="code">Debet/Credit:</label>
                        <select class="form-control" name="code" id="code">
                            <option value=""></option>
                            <option value="D">Debet</option>
                            <option value="C">Credit</option>
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="date">Datum uitgevoerd:</label>
                        <input type="text" value="" class="form-control formDate" name="date" id="date">
                    </div>


                    <div class="form-group col-md-5">
                        <label for="sender">Van:</label>
                        <input type="text" class="form-control" name="sender" id="sender">
                    </div>

                    <!-- Misschien moet van en voor een dropdown menu worden waar eventueel iets aan kan worden toegevoegd, dit om verschillende namen tegen te gaan -->

                    <div class="form-group col-md-5">
                        <label for="receiver">Voor:</label>
                        <input type="text" class="form-control" name="receiver" id="receiver">
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary" id="search">Zoeken</button>
                    </div>
                </form>

                <hr/>

                <div class="table-responsive">
                    <form id="toPDFForm" method="POST" action="pdf-creator/cashbookPDF.php">
                        <table class="table table-striped table-hover" id="cashbookEntriesTable">

                            <thead>
                            <tr>
                                <th>Beschrijving</th>
                                <th width="10%">Datum</th>
                                <th>Bedrag</th>
                                <th>Code</th>
                                <th>Van</th>
                                <th>Voor</th>
                                <th width="5%">
                                    <button type="submit" class="btn btn-primary">Maken PDF</button>
                                </th>

                            </tr>
                            </thead>

                            <tbody id="cashbookEntries">


                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="text-center" id="page-selection">
                    <ul id="pagination"></ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /#page-content-wrapper -->


<!-- /#wrapper -->

<!-- Footer -->
<script src="js/cashbook-pagination.js"></script>
<?php

include_once 'includes/footer.php';

?>

</body>

</html>