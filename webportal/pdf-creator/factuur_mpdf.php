<?php

require_once '../includes/connectdb.php';

//Alle gegevens moeten uit een database worden gehaald
$date = "01/01/1980";
$name = "Henk";
$address = "Straat 21";
$postal = "7881AB";
$city = "De Grote Stad";
$ship = "Het blije bootje";

//Schip moet een for loop bij zodat eigenaren meerdere schepen kunnen hebben

$contrib = 15;
$boat_size = 15;
$price_per_meter = 20;
$total = $price_per_meter*$boat_size + $contrib;

$header = '
	<table border="0" width=100%>
		<tr>
			<td><img src="images/logo.png" width="126px" /></td>
		    <td class="header" align="right">'.$date.'</td>
		</tr>
	</table>
		';

$html = '
<h1>Factuur</h1>
<table cellspacing="0" cellpadding="1" border="0" width="100%">
	<tr>
		<td width="20%">Naam:</td>
		<td>'.$name.'</td>
	</tr>
	<tr>
		<td>Adres:</td>
		<td>'.$address.'</td>
	</tr>
	<tr>
		<td>Postcode:</td>
		<td>'.$postal.'</td>
	</tr>
	<tr>
		<td>Woonplaats:</td>
		<td>'.$city.'</td>
	</tr>
	<tr>
		<td>Schip:</td>
		<td>'.$ship.'</td>
	</tr>
</table>

<br/>

<table cellspacing="0" cellpadding="1" border="1">
	<tr>
		<td width="50%">Contributie</td>
		<td align="right"><b> &euro;'. $contrib .' </b></td>
	</tr>
	<tr>
		<td>Kosten per meter (aantal meter * prijs per meter(&euro; $price_per_meter,-)</td>
		<td align="right"><b>&euro;'. $boat_size*$price_per_meter .' </b></td>
	</tr>
	<tr class="total" bgcolor="GREY">
		<td>Totaal</td>
		<td align="right"><b>&euro;'.$total.' </b></td>
	</tr>
</table>
';

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
?>