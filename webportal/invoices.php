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
	$(document).ready(function(){
		
	    $('#addInvoice #add').click(function(){
	    	var n = $('div#selectInvoiceRule').length + 1;
	        
	        if( 10 < n ) {
	            alert('Stop it!');
	            return false;
	        }
	        var selectBox = $('<div class="form-group col-md-6" id="selectInvoiceRule"><label for="invoiceRule' + n + '">Extra Factuurregel <span class="number">' + n + '</span></label> <select class="form-control" name="invoiceRule[]" value="" id="invoiceRule' + n + '">	<?php $sql = 'SELECT * FROM oh_price_category';$result = $dataManager->rawQuery($sql);foreach($result as $res){echo '<option value="'.$res['ID'].'">'.$res['Naam'].'</option>';}?></select> <a href="#" class="remove-box">Remove</a></div>');
	       
	        selectBox.hide();
	        $('#addInvoice div#selectInvoiceRule:last').after(selectBox);

	        selectBox.fadeIn('slow');
	        return false;
	    });

	   
	    $('#addInvoice').on('click', '.remove-box', function(){
	        
	        $(this).parent().fadeOut("slow", function() {
	            $(this).remove();
	            $('.number').each(function(index){
	                $(this).text( index + 1 );
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
							Facturen</small>
						</h1>
					</div>
					<p>Op deze pagina kunt u een factuur aanmaken voor de leden.</p>
    
                     <?php
						if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
							
							$newDate = DateTime::createFromFormat ( 'd/m/Y', $_POST ['date'] );
							
							$member = cleanInput ( $_POST ['member'] );
							$date = $newDate->format ( 'Y-m-d' );
							$amount = cleanInput ( $_POST ['amount'] );
							
							if (validateInput ( $desc, 2, 64 ) && validateInput ( $amount, 1, 32 ) && validateDate ( $date, 'Y-m-d' )) {
								
								$data = array (
										'Beschrijving' => $desc,
										'Datum' => $date,
										'Bedrag' => $amount 
								);
								
								$insert = $dataManager->insert ( 'oh_cashbook', $data );
								
								if ($insert) {
									echo '<div class="alert alert-success" role="alert">Bedankt voor het aanvullen van de gegevens, ze zijn succesvol verwerkt!</div>';
									echo '<p>Klik <a href="/webportal">hier</a> om naar de hoofdpagina te gaan.</p>';
									echo "<p>Of klik <a href=" . $_SERVER ['REQUEST_URI'] . ">hier</a> om nog een bedrag toe te voegen.";
								} else {
									echo '<div class="alert alert-danger" role="alert">Het lijkt er op alsof er een fout is met de verbinding van de database...</div>';
									echo "<p>Klik <a href=" . $_SERVER ['REQUEST_URI'] . ">hier</a> om het opnieuw te proberen.</p>";
								}
							} else {
								echo '<div class="alert alert-danger" role="alert">Het lijkt er op alsof niet alle gegevens zijn ingevuld...</div>';
								var_dump ( $data );
								echo "<p>Klik <a href=" . $_SERVER ['REQUEST_URI'] . ">hier</a> om het opnieuw te proberen.</p>";
							}
						} else {
					?>
						
						    <form class="clearfix horizontalSearchForm" id="addInvoice" role="form" method="POST" enctype="multipart/form-data">
						    
						<div class="form-group col-md-5" id="selectMembers">
							<label for="selectMember">Selecteer lid</label> 
							
							<select class="form-control" name="selectMember" id="selectMember">
								<?php 
									$sql = 'SELECT ID, Voornaam, Tussenvoegsel, Achternaam FROM oh_members';
									$result = $dataManager->rawQuery($sql);
									
									foreach($result as $res){
										echo '<option value="'.$res['ID'].'">'.$res['Voornaam'].' '.$res['Tussenvoegsel'].' '.$res['Achternaam'].'</option>';
									}
								?>
	                        </select>
						</div>
					    
					    <div class="form-group col-md-5">
                        <label for="date">Factuurdatum:</label>
                        <input type="text" value="<?php echo date("d/m/Y") ?>" class="form-control formDate" name="date" id="date">
                    </div>
                    
						<div class="form-group col-md1 id="add">
							<button type="button" class="btn btn-default " name="add" id="add">Voeg extra regel toe</button>
						</div>
						
						<div class="form-group col-md-4" id="selectInvoiceRule">
							<label for="invoiceRule1">FactuurRegel 1</label> 
							
						<select class="form-control" name="invoiceRules[]" id="invoiceRule1" class="form-control">
							<?php 
								$sql = 'SELECT ID, Naam FROM oh_price_category';
								$result = $dataManager->rawQuery($sql);
								
								foreach($result as $res){
									echo '<option value="'.$res['ID'].'">'.$res['Naam'].'</option>';
								}
							?>
                        </select>
                        
                        
						</div>

					</form>
					
                <?php
																					}
																					?>

                <hr />

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