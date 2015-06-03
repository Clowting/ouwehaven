<?php
session_start();
require_once '../includes/connectdb.php';
$date = date ( "d/m/Y" );

// Alle gegevens moeten uit een database worden gehaald
if(isset($_SESSION['pdf'])){
	$id = $_SESSION['pdf'];


$sql = 'SELECT DISTINCT m.Voornaam, m.Tussenvoegsel, m.Achternaam, m.Adres, m.Postcode, m.Woonplaats, m.IBAN, 
i.ID, i.Datum, i.Betaald, i.DatumBetaald, i.BetaalWijze 
FROM oh_invoices AS i
LEFT JOIN oh_members AS m
ON m.ID = i.Lid_ID
WHERE i.ID = ' . $id . '';

$sql2 = 'SELECT
		l.Aantal, l.Bedrag,
		p.Naam, p.PrijsPerEenheid, p.Prijs
		FROM oh_invoices_line AS l
	    LEFT JOIN oh_price_category AS p
		ON p.ID = l.Categorie_ID
		WHERE l.Factuur_ID = ' . $id . '';

$result = $dataManager->rawQuery ( $sql );
$result2 = $dataManager->rawQuery ( $sql2 );

$header = '
	<table cellspacing="0" width="100%">
		<tr>
			<td><img src="images/logo.png" width="126px" /></td>
		    <td class="header" align="right"> Geprint op: ' . $date . '</td>
		</tr>
	</table>
		';



 

$html = '
<h1>Factuur</h1>
    <br />
    <table style="width:100%;">
        <tr>
            <td style="width:80mm;">
                <h4>Dn Ouwe Haven</h4>
                <p>
                    Edisonweg 4<br />
                    4382 NW <br />
                    Vlissingen<br />
                     <br/>
                    Website : www.dnouwehaven.nl<br />
                    E-mail :  info@dnouwehaven.nl<br />
                    Telefoon : 0118 489 000
                </p>
            </td>
            <td rowspan="2" valign="top" align="right" style="padding:3mm;">
                <table>';
		foreach($result as $pers){
				$oldDate = DateTime::createFromFormat('Y-m-d', $pers['Datum']);
				$date = $oldDate->format('d/m/Y');
		
           $html.='<tr><td>FactuurNummer: </td><td>'.$pers['ID'].'</td></tr>';
           $html.='<tr><td>FactuurDatum: </td><td>'.$date.'</td></tr>';
           if($pers['Betaald'] == 1){
           	
           	$oldDatePaid = DateTime::createFromFormat('Y-m-d', $pers['DatumBetaald']);
           	$datePaid = $oldDatePaid->format('d/m/Y');
	           	$html.='<tr><td>Betaald: </td><td>Ja</td></tr>';
	           	$html.='<tr><td>Datum Betaald: </td><td>'.$datePaid.'</td></tr>';
	           	$html.='<tr><td>BetaalWijze: </td><td>'.$res['BetaaldWijze'].'</td></tr>';
           }
           
$html.='   </table>
            </td>
        </tr>
        <tr>
            <td style="background:WHITE;">';
	$html.='<h4>'.$pers['Voornaam'].' '.$pers['Tussenvoegsel'].' '.$pers['Achternaam'].'</h4><p>';		
	$html.= $pers['Adres'].'<br/>';
	$html.= $pers['Postcode'].'<br/>';
	$html.= $pers['Woonplaats'].'</p></td>';
$html.= '
        </tr>
    </table><br/>';
     }
     
     $totalArray = array();

$html.='<table cellspacing="0" width="100%">
     <thead>
     <tr>
	 <th width="30%">Naam</th>
     <th width="10%">Aantal</th>
     <th width="20%">Prijs per Eenheid</th>
     <th width="20%">Standaard Prijs</th>
     <th width="20%">TotaalBedrag</th>
     </tr>
     </thead>
     <tbody>';
     
foreach ( $result2 as $res ) {

	$total = $res['Prijs'] + $res['PrijsPerEenheid'] * $res['Aantal'];
	array_push($totalArray, $total);
	
	$html.='<tr>';
	$html.='<td>' . $res['Naam'] . '</td>';
	$html.='<td>' . $res['Aantal'] . '</td>';
	$html.='<td>&euro; ' . $res['PrijsPerEenheid'] . '</td>';
	$html.='<td>&euro; ' . $res['Prijs'] . '</td>';
	$html.='<td>&euro; ' . $total	. '</td>';
	$html.='</tr>';
}

$subTotal = array_sum($totalArray);
$html.='<tr>
			<td class="total" colspan="4">Subtotaal:</td>
			<td class="total">&euro; '.$subTotal.'</td>
		</tr>';
    
$html.='</tbody></table>';

include("mpdf60/mpdf.php");

$mpdf=new mPDF('c','A4','','',20,20,30,20,10,10);
$mpdf->SetHeader($header);
$mpdf->SetDisplayMode('fullpage');

// LOAD a stylesheet
$stylesheet = file_get_contents('style/style.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->WriteHTML($html,2);

$mpdf->Output('mpdf.pdf','I');
exit;
}else{
	echo "<h1>U heeft geen recht hier te zijn!</h1>";
}
?>