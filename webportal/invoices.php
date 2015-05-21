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
                    <h1>Facturen</small></h1>
                </div>
                <p>Op deze pagina kunt u een factuur aanmaken voor de leden.</p>
    
                     <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        	
        	$newDate = DateTime::createFromFormat('d/m/Y', $_POST['date']);
        	        
            $member = cleanInput($_POST['member']);
            $date = $newDate->format('Y-m-d');
            $amount = cleanInput($_POST['amount']);

            
            if( validateInput($desc, 2, 64) &&
                validateInput($amount, 1, 32) &&
                validateDate($date, 'Y-m-d')  {

                $data = array(
                    'Beschrijving' => $desc,
                	'Datum' => $date,
                	'Bedrag' => $amount,
                	'Afzender' => $sender,
                	'Ontvanger' => $receiver,
                	'Code' => $code);

                $insert = $dataManager->insert('oh_cashbook', $data);
                
                if($insert) {
                    echo '<div class="alert alert-success" role="alert">Bedankt voor het aanvullen van de gegevens, ze zijn succesvol verwerkt!</div>';
                    echo '<p>Klik <a href="/webportal">hier</a> om naar de hoofdpagina te gaan.</p>';
                    echo "<p>Of klik <a href=".$_SERVER['REQUEST_URI'].">hier</a> om nog een bedrag toe te voegen.";
                } else {
                    echo '<div class="alert alert-danger" role="alert">Het lijkt er op alsof er een fout is met de verbinding van de database...</div>';
                    echo "<p>Klik <a href=".$_SERVER['REQUEST_URI'].">hier</a> om het opnieuw te proberen.</p>";
                }

            } else {
                echo '<div class="alert alert-danger" role="alert">Het lijkt er op alsof niet alle gegevens zijn ingevuld...</div>';
                var_dump($data);
                echo "<p>Klik <a href=".$_SERVER['REQUEST_URI'].">hier</a> om het opnieuw te proberen.</p>";
            }


        } else {
        	?>
<form class="clearfix horizontalSearchForm" id="addInvoicesForm" role="form" method="POST" enctype="multipart/form-data action="pdf-creator/invoicePDF.php">
                    
                    
                      <div class="form-group col-md-5">
                         <label for="code">Lid:</label>
                           <select class="form-control" name="member" id="member">
								<?php
								$sql = 'SELECT ID, Voornaam, Tussenvoegsel, Achternaam FROM oh_members';
								$result = $dataManager->rawQuery($sql);
								
								foreach($result as $res){
									echo '<option value="'.$res['ID'].'">'.$res['Voornaam'].' ' .$res['Tussenvoegsel'].' ' .$res['Achternaam'].'</option>';
								}
								
								
								?>                              
                           </select>
                       </div>
                        
                      <div class="form-group col-md-5">
                         <label for="code">Lid:</label>
                           <select class="form-control" name="member" id="member">
								<?php
								$sql = 'SELECT ID, CategorieNaam FROM oh_price_category';
								$result = $dataManager->rawQuery($sql);
								
								foreach($result as $res){
									echo '<option value="'.$res['ID'].'">'.$res[''].'</option>';
								}
								
								
								?>                              
                           </select>
                       </div>
                        
                	<div class="form-group col-md-5">
                        <label for="date">FactuurDatum:</label>
                        <input type="text" value="<?php echo date("d/m/Y") ?>" class="form-control formDate" name="date" id="date">
                    </div>

                    
                    <div class="col-md-2">
                       
                        <button type="submit" class="btn btn-default " name="add" value="add" id="add">Opslaan</button>
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