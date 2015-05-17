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
                    <h1>Kasboek <small>Voeg toe</small></h1>
                </div>
                <p>Op deze pagina kunt u gegevens in het kasboek zetten, deze worden direct opgeslagen wanneer u op volgende drukt</p>
                <p>Wanneer u meerdere kasboek gegevens wilt invoeren, kunt u kiezen voor "nog 1 toevoegen, wanneer u klaar bent kunt u weer op volgende drukken om verder te gaan</p>
                
                    <ul class="nav nav-tabs">
                        <li role="presentation" class="active"><a href="cashbook.php">Alle Kasboektransacties</a></li>
                        <li role="presentation" ><a href="cashbook-add.php">Voeg toe aan Kasboek</a></li>
                        
                    </ul>

                     <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        	
        	$newDate = DateTime::createFromFormat('d/m/Y', $_POST['date']);
        	        
            $desc = cleanInput($_POST['desc']);
            $date = $newDate->format('Y-m-d');
            $amount = cleanInput($_POST['amount']);
            $sender = cleanInput($_POST['sender']);
            $receiver = cleanInput($_POST['receiver']);
            $code = cleanInput($_POST['code']);
            
            if( validateInput($desc, 2, 64) &&
                validateInput($amount, 2, 64) &&
                validateInput($date, 2, 64) &&
            	validateInput($sender, 2, 50) &&
            	validateInput($receiver, 2, 50) &&
            	validateInput($code, 1, 2))  {

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
                <form class="clearfix horizontalSearchForm" id="addEntriesToCashBookForm" role="form" method="POST" enctype="multipart/form-data">
                    <div class="form-group col-md-12">
                        <label for="desc">Beschrijving:</label>
                        <input type="text" class="form-control" name="desc" id="desc" required data-progression="" data-helper="Vul hier uw beschrijving in.">
                    </div>
                    <div class="col-md-14" align="left">
                        
                        <div align="left"  class="form-group col-md-10">
                        	<label for="amount">Bedrag:</label>
                        	<input type="text" class="form-control" name="amount" id="amount" number required data-progression="" data-helper="Vul hier uw bedrag in.">
                        </div>


                            <div class="form-group col-md-2">
                                <label for="code">Debet/Credit:</label>
                                <select class="form-control" name="code" id="code">
                                    <option value="D">Debet</option>
                                    <option value="C">Credit</option>                               
                                </select>
                            </div>
                    	
                    </div>
                    
                    <div class="form-group col-md-12">
                        <label for="date">Datum uitgevoerd:</label>
                        <input type="text" value="<?php echo date("d/m/Y") ?>" class="form-control formDate" name="date" id="date">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="amount">Van:</label>
                        <input type="text" class="form-control" name="sender" id="sender" required  data-progression="" data-helper="Vul hier uw beschrijving in.>
                    </div>
                    
                    <!-- Misschien moet van en voor een dropdown menu worden waar eventueel iets aan kan worden toegevoegd, dit om verschillende namen tegen te gaan -->
                    <div class="form-group col-md-12">
                        <label for="amount">Voor:</label>
                        <input type="text" class="form-control" name="receiver" id="receiver" required data-progression="" data-helper="Vul hier uw beschrijving in.>
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