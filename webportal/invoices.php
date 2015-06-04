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

    <title><?php echo SITE_TITLE; ?> - Kasboek</title>
    
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
                    <h1>Facturen <small>Zoeken</small></h1>
                </div>
                <p>Op deze pagina kunt u gegevens in het kasboek zetten, deze worden direct opgeslagen wanneer u op volgende drukt</p>
                <p>Wanneer u meerdere kasboek gegevens wilt invoeren, kunt u kiezen voor "nog 1 toevoegen, wanneer u klaar bent kunt u weer op volgende drukken om verder te gaan</p>
                                
                    <ul class="nav nav-tabs">
                        <li role="presentation" class="active"><a href="invoices.php">Facturen</a></li>
                        <li role="presentation"  ><a href="invoices-add.php">Facturen toevoegen</a></li>
                        <li role="presentation"><a href="priceCategories-add.php">Prijs Categorieen toevoegen</a>  
                    </ul>

                <form class="clearfix horizontalSearchForm" id="searchInvoices" role="form" method="POST" enctype="multipart/form-data">
                    
                    
                        <div class="form-group col-md-5" id="selectMembers">
                            <label for="member">Selecteer lid</label>

                            <select class="form-control" name="member" id="member">
                                <option value="" selected></option>
                                <?php
                                $members = $dataManager->get('oh_members');

                                foreach ($members as $member) {
                                    $eigenaar = generateName($member['Voornaam'], $member['Tussenvoegsel'], $member['Achternaam']);

                                    echo '<option value="' . $member["ID"] . '">' . $eigenaar . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                    <div class="form-group col-md-2">
                        <label for="date">Datum uitgevoerd:</label>
                        <input type="text" value="" class="form-control formDate" name="date" id="date">
                    </div>
                    
                	<div class="form-group col-md-2">
                        <label for="date">Datum Betaald:</label>
                        <input type="text" value="" class="form-control formDate" name="datePaid" id="datePaid">
                    </div>
                    
                    <div class="form-group col-md-2">
                        <label for="paid">Betaald: </label>
                        <select class="form-control" name="paid" id="paid">
                            <option value="2"> </option>
                            <option value="0">Nee</option>
                            <option value="1">Ja</option>
                        </select>
                    </div>
                    
                    


                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary" id="search">Zoeken</button>
                    </div>
                </form>

                <hr/>
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="cashbookEntriesTable">
                            <thead>
                            <tr>
                                <th>Lid</th>
                                <th>FactuurNummer</th>
                                <th>Datum</th>
                           		
                                <th>Betaald</th>
                                <th>Datum Betaald</th>
                                <th>Optie</th>
                                
                            </tr>
                            </thead>
                            <tbody id="invoicesEntries">

                            </tbody>
                	</table>
                	
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
<script src="js/invoices-pagination.js"></script>
<?php

include_once 'includes/footer.php';

?>

</body>

</html>