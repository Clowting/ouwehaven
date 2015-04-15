<?php

// Include the main TCPDF library (search for installation path).
require_once('tcpdf/tcpdf.php');

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

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Lennart');
$pdf->SetTitle('Factuur');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.'Factuur', PDF_HEADER_STRING.$date);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set font
$pdf->SetFont('helvetica', 'B', 20);

// add a page
$pdf->AddPage();

$pdf->Write(0,'Factuur', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('helvetica', '', 8);

//External css file
//$html = '<style>'.file.get_contents(_BASE_PATH.'style.css').'</style>';

$html = 	
<<<EOD
<br/>
<br/>

<table cellspacing="0" cellpadding="1" border="0">
    <tr>
        <td width="10%">Naam:</td>
        <td>$name</td>
    </tr>
     <tr>
    	<td width="10%">Adres:</td>
        <td>$address</td>
    </tr>
    <tr>
        <td width="10%">Postcode:</td>
        <td>$postal</td>
    </tr>
    <tr>
    	<td width="10%">Woonplaats:</td>
        <td>$city</td>
    </tr>
    <tr>
    	<td width="10%">Schip:</td>
        <td>$ship</td>
    </tr>
</table>



<br/>
<br/>
<br/>
EOD;

$complete_price = $boat_size*$price_per_meter;
$total = $complete_price + $contrib;

$html .= <<<EOD
<table cellspacing="0" cellpadding="1" border="1">
    <tr>
        <td width="30%">Contributie</td>
        <td align="right"><b> &euro; $contrib  </b></td>
    </tr>
    <tr>
    	<td>Kosten per meter (aantal meter * prijs per meter(&euro; $price_per_meter,-)</td>
    	<td align="right"><b>&euro; $complete_price </b></td>
    </tr>
    <tr bgcolor="GREY">
    	<td>Totaal</td>
    	<td align="right"><b>&euro; $total </b></td>
    </tr>

</table>
EOD;

$pdf->writeHTML($html);

// -----------------------------------------------------------------------------



//Close and output PDF document
$pdf->Output('example_048.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
