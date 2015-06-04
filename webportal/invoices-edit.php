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
    <script type="text/javascript">
        $(document).ready(function () {

            $('#addInvoice #add').click(function () {
                var selectBox = '<tr> <td class="form-group"> <select class="form-control" name="invoiceLines[]" class="form-control"> <?php $categories = $dataManager->get('oh_price_category'); foreach ($categories as $category) { echo '<option value="' . $category['ID'] . '" id="Categorie_ID">' . $category['Naam'] . '</option>'; } ?> </select> </td> <td class="form-group"> <input type="number" class="form-control" name="invoiceAmounts[]"> </td> <td> <input type="text" class="form-control" name="invoicePrices[]"> </td> <td> <i class="fa fa-minus-circle remove-line"></i> </td> </tr>';
                selectBox = $(selectBox);

                selectBox.hide();
                $('#invoices tr:last').after(selectBox);

                selectBox.fadeIn('slow');
                return false;
            });


            $('#addInvoice').on('click', '.remove-line', function () {

                $(this).parent().parent().fadeOut("slow", function () {
                    $(this).remove();
                    $('.number').each(function (index) {
                        $(this).text(index + 1);
                    });
                });
                return false;
            });
        });
    </script>

    <title><?php echo SITE_TITLE; ?> - Facturen aanpassen</title>
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
                    <h1>Facturen</h1>
                </div>
                <p>Op deze pagina kunt u een factuur aanpassen voor de leden.</p>
                    <ul class="nav nav-tabs">
                        <li role="presentation"><a href="invoices.php">Facturen</a></li>
                        <li role="presentation"><a href="invoices-add.php">Facturen toevoegen</a></li>
                        <li role="presentation"><a href="priceCategories-add.php">Prijs Categorieen toevoegen</a>
                    </ul>

                <?php

                if(isset($_GET['id']) && is_numeric($_GET['id'])) {
                    $id = $_GET['id'];

                    $dataManager->where('ID', $id);
                    $data = $dataManager->getOne('oh_invoices');

                    if(!empty($data)) {
                    	
                        $oudGebruikerID = $data['Lid_ID'];
						if($data['Datum'] != null){
	                        $oudDatum = DateTime::createFromFormat('Y-m-d', $data['Datum']);
	                        $datum = $oudDatum->format('d/m/Y');
						}

                        
                        $betaald = $data['Betaald'];

                        if ($_SERVER ['REQUEST_METHOD'] == 'POST') {

                            $nieuwGebruikerID = cleanInput($_POST['member']);

                            $nieuwDatum = DateTime::createFromFormat('d/m/Y', $_POST['date']);
                            $date = $nieuwDatum->format('Y-m-d');                           
                            
                            $invoiceCategories = cleanInput($_POST['invoiceLines']);
                            $invoiceAmounts = cleanInput($_POST['invoiceAmounts']);
                            $invoicePrices = cleanInput($_POST['invoicePrices']);

							$paid = $_POST['paid'];
                            	
                            if (validateDate($date, 'Y-m-d') &&
                            	validateNumber($nieuwGebruikerID, 1, 11)
                            		) {

                                $data = array(
                                    'Lid_ID' => $nieuwGebruikerID,
                                    'Datum' => $date,
                                	'Betaald' => $paid
                                );
                                
                                if(isset($_POST['DatumBetaald']) && !empty($_POST['DatumBetaald'])){
                                	$nieuwDatumBetaald = DateTime::createFromFormat('d/m/Y', $_POST['datePaid']);
                                	$datePaid = $nieuwDatumBetaald->format('Y-m-d');
                                	$data['DatumBetaald'] = $datePaid;
                                }

                                $dataManager->where('ID', $id);
                                $update = $dataManager->update('oh_invoices', $data);

                                $lines_success = 0;
                                $lines_failed = 0;

                                // Remove old invoice lines
                                $dataManager->where('Factuur_ID', $id);
                                $dataManager->delete('oh_invoices_line');

                                foreach ($invoiceCategories as $key => $category) {

                                    $data = array(
                                        'Factuur_ID' => $id,
                                        'Categorie_ID' => $category,
                                        'Aantal' => $invoiceAmounts[$key],
                                        'Bedrag' => $invoicePrices[$key]
                                    );

                                    $insertLine = $dataManager->insert('oh_invoices_line', $data);

                                    if ($insertLine) {
                                        $lines_success++;
                                    }
                                    else {
                                        $lines_failed++;
                                    }
                                }

                                if ($update) {
                                    echo '<div class="alert alert-success" role="alert">De factuur is succesvol bijgewerkt!</div>';

                                    if ($lines_success > 0) {
                                        echo '<div class="alert alert-success" role="alert"><strong>' . $lines_success . ' factuurregels</strong> succesvol bijgewerkt!</div>';
                                    }

                                    if ($lines_failed > 0) {
                                        echo '<div class="alert alert-danger" role="alert"><strong>' . $lines_failed . ' factuurregels</strong> konden niet worden bijgewerkt.</div>';
                                    }

                                    echo '<p>Klik <a href="/webportal">hier</a> om naar de hoofdpagina te gaan.</p>';
                                    echo "<p>Of klik <a href=" . $_SERVER ['REQUEST_URI'] . ">hier</a> om de wijzigingen te bekijken.</p>";
                                } else {
                                    echo '<div class="alert alert-danger" role="alert">Het lijkt er op alsof er een fout is met de verbinding van de database...</div>';
                                    echo "<p>Klik <a href=" . $_SERVER ['REQUEST_URI'] . ">hier</a> om het opnieuw te proberen.</p>";
                                }
                            } else {
                                echo '<div class="alert alert-danger" role="alert">Het lijkt er op alsof niet alle gegevens zijn ingevuld...</div>';
                                echo "<p>Klik <a href=" . $_SERVER ['REQUEST_URI'] . ">hier</a> om het opnieuw te proberen.</p>";
                            }
                        } else {

                            ?>

                            <form class="clearfix horizontalSearchForm" id="addInvoice" role="form" method="POST"
                                  enctype="multipart/form-data">

                                <div class="form-group col-md-4" id="selectMembers">
                                    <label for="member">Selecteer lid</label>

                                    <select class="form-control" name="member" id="member">
                                        <option value="" selected></option>
                                        <?php

                                            $members = $dataManager->get('oh_members');

                                            foreach ($members as $member) {
                                                $eigenaar = generateName($member['Voornaam'], $member['Tussenvoegsel'], $member['Achternaam']);

                                                if ($member['ID'] == $oudGebruikerID) {
                                                    echo '<option value="' . $member["ID"] . '" selected>' . $eigenaar . '</option>';
                                                }
                                                else {
                                                    echo '<option value="' . $member["ID"] . '">' . $eigenaar . '</option>';
                                                }
                                            }

                                        ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="date">Datum uitgevoerd:</label>
                                    <input type="text" value="<?php echo $datum ?>" class="form-control formDate" name="date" id="date">
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="date">Datum Betaald:</label>
                                    <input type="text" value="<?php echo $datumBetaald ?>" class="form-control formDate" name="datePaid" id="datePaid">
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="paid">Betaald:</label>
                                    <select class="form-control" name="paid" id="paid">
                                        <option value="1" <?php echo ($betaald == 1 ? 'selected' : '') ?>>Ja</option>
                                        <option value="0" <?php echo ($betaald == 0 ? 'selected' : '') ?>>Nee</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-1" id="add">
                                    <button type="button" class="btn btn-primary" name="add" id="add">Voeg extra regel toe</button>
                                </div>


                                <div class="table-responsive col-md-12">
                                    <table class="table table-striped" id="invoices">
                                        <thead>
                                        <tr>
                                            <th>Categorie</th>
                                            <th>Aantal</th>
                                            <th>Prijs</th>
                                            <th>Actie</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $dataManager->where('Factuur_ID', $id);
                                            $dataManager->join("oh_price_category p", "l.Categorie_ID=p.ID", "LEFT");
                                            $invoiceLines = $dataManager->get("oh_invoices_line l", null, " l.ID, l.Aantal, l.Bedrag, p.ID AS prijsID, p.Naam, p.PrijsPerEenheid, p.Prijs");

                                            foreach($invoiceLines as $invoiceLine) {

                                            ?>
                                            <tr>
                                            <input type="hidden" id="ID" value="<?php echo $invoiceLine['ID']; ?>">
                                                <td class="form-group">
                                                    <select class="form-control" name="invoiceLines[]"
                                                            class="form-control">
                                                        <?php
                                                        $categories = $dataManager->get('oh_price_category');

                                                        foreach ($categories as $category) {
                                                            if ($category['ID'] == $invoiceLine['prijsID']) {

                                                                echo '<option value="' . $category['ID'] . '" id="Categorie_ID" selected>' . $category['Naam'] . '</option>';
                                                            } else {
                                                                echo '<option value="' . $category['ID'] . '" id="Categorie_ID">' . $category['Naam'] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                                <td class="form-group">
                                                    <input type="number" value="<?php echo $invoiceLine['Aantal']; ?>"
                                                           class="form-control" name="invoiceAmounts[]">
                                                </td>
                                                <td>
                                                    <input type="text" value="<?php echo $invoiceLine['Bedrag']; ?>"
                                                           class="form-control" name="invoicePrices[]">
                                                </td>
                                                <td>
                                                    <i class="fa fa-minus-circle remove-line"></i>
                                                </td>
                                            </tr>
                                                <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-primary">Bijwerken</button>
                                </div>

                            </form>

                        <?php
                        }
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Het opgegeven factuurnummer is kan niet worden gevonden!</div>';
                    }
                } else {
                    echo '<div class="alert alert-danger" role="alert">Het opgegeven factuurnummer is niet geldig!</div>';
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