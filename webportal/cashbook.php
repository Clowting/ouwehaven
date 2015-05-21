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
    
<!--           <script type="text/javascript"> --> 
<!-- //             -->
 
               
<!-- //                $("#searchCashBook").on('input', function(){ -->
<!-- //                      var desc=$("#desc").val(); -->
<!-- //                      var date=$("#date").val(); -->
<!-- //                      var code=$("#code").val(); -->
<!-- //                      var receiver=$("#receiver").val(); -->
<!-- //                      var sender=$("#sender").val(); -->
<!-- //                      $.ajax({ -->
<!-- //                         type:"post", -->
                       
<!-- //                         data: {desc: desc, date: date, code: code, receiver: receiver, sender: sender}, -->
<!-- //                         //data:"desc="+desc+"date="+date+"code="+code+"receiver="+receiver+"sender="+sender, -->
<!-- //                         success:function(data){ -->
<!-- //                               $("#foundEntries").html(data); -->
<!-- //                         } -->
<!-- //                      }); -->
<!-- //                }); -->
<!-- //            }); -->
	<!--       </script> -->

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
                        <li role="presentation"><a href="cashbook-add.php">Voeg toe aan Kasboek</a></li>
                        
                    </ul>
                     <?php

        		?>
                <form class="clearfix horizontalSearchForm" id="searchCashBook" role="form" method="POST" enctype="multipart/form-data">
                    
                    
                    <div class="form-group col-md-8">
                        <label for="desc">Beschrijving:</label>
                        <input type="text" class="form-control" name="desc" id="desc">
                    </div>
                   
                    <div class="form-group col-md-2">
                        <label for="code">Debet/Credit:</label>
                        <select class="form-control" name="code" id="code">
                            <option value=""> </option>
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
                        <button type="submit" class="btn btn-default " name="search" value="search" id="search">Zoeken</button>
                    </div>
                </form>
                <?php 
                        
                ?>

                <hr/>
                
                <div class="table-responsive">
                	<form id="toPDFForm" method="POST" action="pdf-creator/cashbookPDF.php">
                    <table class="table table-striped table-hover" id="foundEntries">

                            <thead>
                            <tr>
                                <th>Beschrijving</th>
                                <th width="10%">Datum</th>
                                <th>Bedrag</th>
                                <th>Code</th>
                                <th>Van</th>
                                <th>Voor</th>
                                <th width="5%"><button type="submit" class="btn btn-default">Maken PDF</button></th>
                                
                            </tr>
                            </thead>
                            
                            <tbody>
                            
                            <?php
                            
                            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search']) ) {
                            	
                            	if($_POST['date'] != null){
                            		$newDate = DateTime::createFromFormat('d/m/Y', $_POST['date']);
                            		$date = $newDate->format('Y-m-d');
                            	}
                            	
               
					            $desc = cleanInput($_POST['desc']);
					            $sender = cleanInput($_POST['sender']);
					            $receiver = cleanInput($_POST['receiver']);
					            $code = cleanInput($_POST['code']);
					            
					            $sql = "SELECT * FROM oh_cashbook 
										WHERE Beschrijving = '".$desc."' 
										OR Datum ='".$date."' OR Afzender ='".$sender."' 
										OR Ontvanger ='".$receiver."' OR Code ='".$code."'
										ORDER BY Datum DESC";
					            
					            $result = $dataManager->rawQuery($sql);
					            
					            $i = 0;
					            foreach($result as $res){
					            	$i++;
					            	$resultDate = DateTime::createFromFormat('Y-m-d', $res['Datum']);
					            	$resDate = $resultDate->format('d/m/Y');
					            	$oldCode = (string)$res['Code'];
					            	
					           
					            	
					            	if(strcmp($oldCode,"D")){
					            		$code = "Credit";
					            	}else{
					            		$code = "Debet";
					            	}
					            	
					            	echo '<tr id="'.$res['ID'].'">';
					            	echo '<td><input type="hidden"  name="'.$i.'[desc]" value="'.$res['Beschrijving'].'"</input>'.$res['Beschrijving'].'</td>';
					            	echo '<td><input type="hidden"  name="'.$i.'[date]" value="'.$resDate.'"</input>'.$resDate.'</td>';
					            	echo '<td><input type="hidden"  name="'.$i.'[amount]" value="&euro;'.$res['Bedrag'].'"</input>&euro; '.$res['Bedrag'].'</td>';
					            	echo '<td><input type="hidden"  name="'.$i.'[code]" value="'.$code.'"</input>'.$code.'</td>';
					            	echo '<td><input type="hidden"  name="'.$i.'[sender]" value="'.$res['Afzender'].'"</input>'.$res['Afzender'].'</td>';
					            	echo '<td><input type="hidden"  name="'.$i.'[receiver]" value="'.$res['Ontvanger'].'"</input>'.$res['Ontvanger'].'</td>';
					            	echo '<td>';
                                    echo '<a class="btn" id="delete" value="delete"><i class="fa fa-trash-o "></i> Verwijderen</a>';
                                    echo '<a class="btn id="edit" value="edit" href="hoi.php"><i class="fa fa-pencil "></i> Bewerken</a>';
                                    echo '</td>';
					            }

					            
                            }

                            ?>

                            </tbody>
                	</table>
                	</form>
                </div>
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