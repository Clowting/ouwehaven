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

    <title><?php echo SITE_TITLE; ?> - Prijs Categorieeen</title>
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
                    <h1>Prijs Categorieeen <small>Voeg toe</small></h1>
                </div>
                <p>Op deze pagina kunt u gegevens in het kasboek zetten, deze worden direct opgeslagen wanneer u op volgende drukt</p>
                <p>Wanneer u meerdere kasboek gegevens wilt invoeren, kunt u kiezen voor "nog 1 toevoegen, wanneer u klaar bent kunt u weer op volgende drukken om verder te gaan</p>
                
                    <ul class="nav nav-tabs">
                        <li role="presentation" ><a href="invoices.php">Facturen</a></li>
                        <li role="presentation"  ><a href="invoices-add.php">Facturen toevoegen</a></li>
                        <li role="presentation" class="active"><a href="priceCategories-add.php">Prijs Categorieen toevoegen</a>  
                    </ul>

                     <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        	$naam = cleanInput($_POST['naam']);
            $ppe = cleanInput($_POST['ppe']);
            $prijs = cleanInput($_POST['prijs']);
            
            if( validateInput($naam, 2, 64) &&
                validateNumber($ppe, 0, 32) &&
            	validateNumber($prijs, 0, 32))  {

                $data = array(
                    'Naam' => $naam,
                	'PrijsPerEenheid' => $ppe,
                	'Prijs' => $prijs);

                $insert = $dataManager->insert('oh_price_category', $data);
                
                if($insert) {
                    echo '<div class="alert alert-success" role="alert">Bedankt voor het aanvullen van de gegevens, ze zijn succesvol verwerkt!</div>';
                    echo '<p>Klik <a href="/webportal">hier</a> om naar de hoofdpagina te gaan.</p>';
                    echo "<p>Of klik <a href=".$_SERVER['REQUEST_URI'].">hier</a> om nog een categorie toe te voegen.";
                } else {
                    echo '<div class="alert alert-danger" role="alert">Het lijkt er op alsof er een fout is met de verbinding van de database...</div>';
                    echo "<p>Klik <a href=".$_SERVER['REQUEST_URI'].">hier</a> om het opnieuw te proberen.</p>";
                }

            } else {
                echo '<div class="alert alert-danger" role="alert">Het lijkt er op alsof niet alle gegevens zijn ingevuld...</div>';
                echo "<p>Klik <a href=".$_SERVER['REQUEST_URI'].">hier</a> om het opnieuw te proberen.</p>";
            }


        } else {
        	?>
                <form class="clearfix horizontalSearchForm" id="addPriceCategory" role="form" method="POST" enctype="multipart/form-data">

							<div class="form-group">
                                <label for="naam">Naam:</label>
                                <input type="text" class="form-control" name="naam">
                            </div>
                             <div class="form-group">
                                <label for="ppe">Prijs per Eenheid:</label>
                                <input type="number" class="form-control" name="ppe">
                            </div>
                            <div class="form-group">
                                <label for="lengte">Prijs:</label>
                                <input type="number" class="form-control" name="prijs">
                            </div>
                       <div class="form-group">
                        <button type="submit" class="btn btn-primary">Opslaan</button>
                    </div>
                </form>
                <?php 
                        }
                ?>

                <hr/>
                
                </div>
            </div>
        </div>
    </div>

<!-- /#page-content-wrapper -->


<!-- /#wrapper -->

<!-- Footer -->
<?php

include_once 'includes/footer.php';

?>

</body>

</html>