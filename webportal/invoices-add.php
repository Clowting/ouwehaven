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

    <title><?php echo SITE_TITLE; ?> - Facturen </title>
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
                <p>Op deze pagina kunt u een factuur aanmaken voor de leden.</p>
                                    <ul class="nav nav-tabs">
                        <li role="presentation" ><a href="invoices.php">Facturen</a></li>
                        <li role="presentation"  class="active"><a href="invoices-add.php">Facturen toevoegen</a></li>
                        <li role="presentation"><a href="priceCategories-add.php">Prijs Categorieen toevoegen</a>  
                    </ul>

                <?php
                if ($_SERVER ['REQUEST_METHOD'] == 'POST') {

                    $newDate = DateTime::createFromFormat('d/m/Y', $_POST ['date']);

                    $date = $newDate->format('Y-m-d');
                    $invoiceCategories = $_POST['invoiceLines'];
                    $invoiceAmounts = $_POST['invoiceAmounts'];
                    $invoicePrices = $_POST['invoicePrices'];

                    if (validateDate($date, 'Y-m-d')) {

                        $data = array(
                            'Lid_ID' => $memberID,
                            'Datum' => $date,
                        );

                        $insert = $dataManager->insert('oh_invoices', $data);

                        $factuurID = $dataManager->getInsertId();
                        $successCount = 0;
                        $failCount = 0;

                        foreach($invoiceCategories as $key => $category) {
                            $data = array(
                                'Factuur_ID' => $factuurID,
                                'Categorie_ID' => $category,
                                'Aantal' => $invoiceAmounts[$key],
                                'Bedrag' => $invoicePrices[$key]
                            );

                            $insertLine = $dataManager->insert('oh_invoices_line', $data);

                            if($insertLine) {
                                $successCount++;
                            } else {

                            }
                        }

                        if ($insert) {
                            echo '<div class="alert alert-success" role="alert">De factuur is succesvol toegevoegd!</div>';
                            echo $_POST['ID'];

                            if($successCount > 0) {
                                echo '<div class="alert alert-success" role="alert"><strong>' . $successCount . ' factuurregels</strong> succesvol toegevoegd!</div>';
                            }

                            if($failCount > 0) {
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

                    <form class="clearfix horizontalSearchForm" id="addInvoice" role="form"  method="POST" enctype="multipart/form-data">

                        <div class="form-group col-md-5" id="selectMembers">
                            <label for="selectMember">Selecteer lid</label>

                            <select class="form-control" name="selectMember" id="selectMember">
                                <?php
                                $members = $dataManager->get('oh_members');

                                foreach ($members as $member) {
                                    $eigenaar = generateName($member['Voornaam'], $member['Tussenvoegsel'], $member['Achternaam']);

                                    echo '<option value="' . $member["ID"] . '">' . $eigenaar . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group col-md-5">
                            <label for="date">Factuurdatum:</label>
                            <input type="text" value="<?php echo date("d/m/Y") ?>" class="form-control formDate"
                                   name="date"
                                   id="date">
                        </div>

                        <div class="form-group col-md-1" id="add">
                            <button type="button" class="btn btn-default " name="add" id="add">Voeg extra regel toe
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
                                    <tr>
                                        <td class="form-group">
                                            <select class="form-control" name="invoiceLines[]" class="form-control">
                                                <?php
                                                    $categories = $dataManager->get('oh_price_category');

                                                    foreach ($categories as $category) {
                                                        echo '<option value="' . $category['ID'] . '" id="Categorie_ID">' . $category['Naam'] . '</option>';
                                                    }
                                                ?>
                                            </select>
                                        </td>
                                        <td class="form-group">
                                            <input type="number" class="form-control" name="invoiceAmounts[]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="invoicePrices[]">
                                        </td>
                                        <td>
                                            <i class="fa fa-minus-circle remove-line"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-default ">Aanmaken</button>
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