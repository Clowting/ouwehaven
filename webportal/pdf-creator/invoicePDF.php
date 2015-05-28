<?php
require_once '../includes/connectdb.php';
$date = date("d/m/Y");

// Alle gegevens moeten uit een database worden gehaald
// $id = $_POST['id'];
$id = 3;

$sql = 'SELECT DISTINCT m.Voornaam, m.Tussenvoegsel, m.Achternaam, m.Adres, m.Postcode, m.Woonplaats, m.IBAN, 
i.Datum, i.Betaald, i.DatumBetaald, 
l.Aantal, l.Bedrag,
c.Naam, c.PrijsPerEenheid, c.Prijs
FROM oh_invoices AS i
LEFT JOIN oh_invoices_line AS l
ON l.Factuur_ID=i.ID
LEFT JOIN oh_price_category AS c
ON c.ID=l.Categorie_ID
LEFT JOIN oh_members AS m
ON m.ID = i.Lid_ID
WHERE i.ID = '.$id.'
';

$result = $dataManager->rawQuery($sql);

$header = '
	<table cellspacing="0" width="100%">
		<tr>
			<td><img src="images/logo.png" width="126px" /></td>
		    <td class="header" align="right"> Printed on: ' . $date . '</td>
		</tr>
	</table>
		';

$html = '
<h1>Factuur</h1>
<table cellspacing="0" cellpadding="1" border="0" width="50%">';

foreach ( $result as $res ) {
	$html.='<tr><td>' . $res['Voornaam'] . ' '.$res['Tussenvoegsel'].' '.$res['Achternaam'].'</td></tr>';
	$html.='<tr><td>' . $res['Adres'] . '</td></tr>';
	$html.='<tr><td>' . $res['Postcode'] . '</td></tr>';
	$html.='<tr><td>' . $res['Woonplaats'] . '</td></tr>';
	$html.='<tr><td>' . $res['IBAN'] . '</td></tr>';
}


// include("mpdf60/mpdf.php");

// $mpdf=new mPDF('c','A4','','',20,20,30,20,10,10);
// $mpdf->SetHeader($header);
// $mpdf->SetDisplayMode('fullpage');

// // LOAD a stylesheet
// $stylesheet = file_get_contents('style/style.css');
// $mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

// $mpdf->WriteHTML($html,2);

// $mpdf->Output('mpdf.pdf','I');
// exit;
?>