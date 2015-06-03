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
                    <h1>
                        Facturen
                    </h1>
                </div>
                <p>Op deze pagina kunt u een factuur aanpassen voor de leden.</p>
                    <ul class="nav nav-tabs">
                        <li role="presentation" ><a href="invoices.php">Facturen</a></li>
                        <li role="presentation"><a href="invoices-add.php">Facturen toevoegen</a></li>
                        <li role="presentation"><a href="priceCategories-add.php">Prijs Categorieen toevoegen</a>  
                    </ul>

                <?php

                if(isset($_GET['id']) && is_numeric($_GET['id'])) {
                    $ID = $_GET['id'];

                    $dataManager->where('i.ID', $ID);
                    $dataManager->join("oh_members AS m", "m.ID=i.Lid_ID", "LEFT");
                    $data = $dataManager->getOne('oh_invoices AS i', "i.Datum, i.Betaald, i.DatumBetaald, m.ID, m.Voornaam, m.Tussenvoegsel, m.Achternaam");

                    if(!empty($data)) {
                        $gebruikerID = $data['ID'];

                        $oudDatum = DateTime::createFromFormat('Y-m-d', $data['Datum']);
                        $datum = $oudDatum->format('d/m/Y');

                        $oudDatumBetaald = DateTime::createFromFormat('Y-m-d', $data['DatumBetaald']);
                        $datumBetaald = $oudDatumBetaald->format('d/m/Y');

                        $betaald = $data['Betaald'];

                        if ($_SERVER ['REQUEST_METHOD'] == 'POST') {

                            $newDate = DateTime::createFromFormat('d/m/Y', $_POST ['date']);
                            $date = $newDate->format('Y-m-d');
                            
                            $oldDatePaid = DateTime::createFromFormat('d/m/Y', $_POST['datePaid']);
                            $datePaid = $oldDatePaid->format('Y-m-d');
                            $invoiceCategories = $_POST['invoiceLines'];
                            $invoiceAmounts = $_POST['invoiceAmounts'];
                            $invoicePrices = $_POST['invoicePrices'];
							$paid = $_POST['paid'];
                            	
                            if (validateDate($date, 'Y-m-d')) {

                                $data = array(
                                    'Lid_ID' => $gebruikerID,
                                    'Datum' => $date,
                                	'DatumBetaald' => $datePaid,
                                	'Betaald' => $paid
                                );

                                $dataManager->where('ID', $ID);
                                $insert = $dataManager->update('oh_invoices', $data);

                                $factuurID = $dataManager->getInsertId();
                                $successCount = 0;
                                $failCount = 0;

                                foreach ($invoiceCategories as $key => $category) {
                                    $data = array(
                                        
                                        'Categorie_ID' => $category,
                                        'Aantal' => $invoiceAmounts[$key],
                                        'Bedrag' => $invoicePrices[$key]
                                    );
                                    
                                    

                                    $dataManager->where('Factuur_ID', $ID);
                                    $insertLine = $dataManager->insert('oh_invoices_line', $data);

                                    if ($insertLine) {
                                        $successCount++;
                                    } else {

                                    }
                                }

                                if ($insert) {
                                    echo '<div class="alert alert-success" role="alert">De factuur is succesvol toegevoegd!</div>';
                                    echo $_POST['ID'];

                                    if ($successCount > 0) {
                                        echo '<div class="alert alert-success" role="alert"><strong>' . $successCount . ' factuurregels</strong> succesvol toegevoegd!</div>';
                                    }

                                    if ($failCount > 0) {
                                        echo '<div class="alert alert-danger" role="alert"><strong>' . $failCount . ' factuurregels</strong> konden niet worden toegevoegd.</div>';
                                    }

                                    echo '<p>Klik <a href="/webportal">hier</a> om naar de hoofdpagina te gaan.</p>';
                                    echo "<p>Of klik <a href=" . $_SERVER ['REQUEST_URI'] . ">hier</a> om nog een factuur toe te voegen.";
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
                                            if ($member['ID'] == $gebruikerID) {
                                                echo '<option value="' . $member["ID"] . '" selected>' . $eigenaar . '</option>';
                                            } else {
                                                echo '<option value="' . $member["ID"] . '">' . $eigenaar . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="date">Datum uitgevoerd:</label>
                                    <input type="text" value="<?php echo $datum ?>" class="form-control formDate"
                                           name="date"
                                           id="date">
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="date">Datum Betaald:</label>
                                    <input type="text" value="<?php echo $datumBetaald ?>" class="form-control formDate"
                                           name="datePaid" id="datePaid">
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="paid">Betaald: </label>
                                    <select class="form-control" name="paid" id="paid">
                                        <?php
                                        if ($betaald == 1) {
                                            echo '<option value="1" selected>Ja</option>';
                                            echo '<option value="0">Nee</option> ';
                                        } else if ($betaald == 0) {
                                            echo '<option value="1">Ja</option>';
                                            echo '<option value="0" selected>Nee</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-1" id="add">
                                    <button type="button" class="btn btn-default " name="add" id="add">Voeg extra regel
                                        toe
                                    </button>
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
                                            $dataManager->where('Factuur_ID', $ID);
                                            $dataManager->join("oh_price_category p", "l.Categorie_ID=p.ID", "LEFT");
                                            $invoiceLines = $dataManager->get("oh_invoices_line l", null, "l.Aantal, l.Bedrag, p.ID, p.Naam, p.PrijsPerEenheid, p.Prijs");

                                            foreach($invoiceLines as $invoiceLine) {

                                            ?>
                                            <tr>
                                                <td class="form-group">
                                                    <select class="form-control" name="invoiceLines[]"
                                                            class="form-control">
                                                        <?php
                                                        $categories = $dataManager->get('oh_price_category');

                                                        foreach ($categories as $category) {
                                                            if ($category['ID'] == $invoiceLine['ID']) {

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
                                    <button type="submit" class="btn btn-default ">Aanmaken</button>
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