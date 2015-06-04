<?php
require_once 'includes/globals.php';
require_once 'includes/requireSession.php';
require_once 'includes/requirePenningmeester.php';
require_once 'includes/functions.php';
require_once 'includes/connectdb.php';
$date = date ( "d/m/Y" );

// Alle gegevens moeten uit een database worden gehaald
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $dataManager->where('i.ID', $id);
    $dataManager->join("oh_members AS m", "m.ID=i.Lid_ID", "LEFT");
    $details = $dataManager->getOne('oh_invoices AS i', "i.Datum, i.Betaald, i.DatumBetaald, m.ID, m.Voornaam, m.Tussenvoegsel, m.Achternaam, m.Adres, m.Postcode, m.Woonplaats");

    $dataManager->where('Factuur_ID', $id);
    $dataManager->join("oh_price_category p", "l.Categorie_ID=p.ID", "LEFT");
    $invoiceLines = $dataManager->get("oh_invoices_line l", null, " l.ID, l.Aantal, l.Bedrag, p.ID AS prijsID, p.Naam, p.PrijsPerEenheid, p.Prijs");

    $header = '
        <table cellspacing="0" width="100%">
            <tr>
                <td><img src="pdf-creator/images/logo_new.jpg" width="126px" /></td>
                <td class="header" align="right"> Geprint op: ' . $date . '</td>
            </tr>
        </table>
            ';


    $html = '
    <h1>Factuur</h1>
        <br/>
        <table style="width:100%;">
            <tr>
                <td style="width:80mm;">
                    <h4>De \'n Ouwe Haven</h4>
                    <p>
                        Edisonweg 4<br />
                        4382 NW <br />
                        Vlissingen<br />
                         <br/>
                        Website: www.dnouwehaven.nl<br />
                        E-mail:  info@dnouwehaven.nl<br />
                        Telefoon: 0118 48 90 00
                    </p>
                </td>
                <td rowspan="2" valign="top" align="right" style="padding:3mm;">
                    <table>';

        $oldDate = DateTime::createFromFormat('Y-m-d', $details['Datum']);
        $date = $oldDate->format('d/m/Y');

        $html .= '<tr><td>Factuurnummer: </td><td>' . $details['ID'] . '</td></tr>';
        $html .= '<tr><td>Factuurdatum: </td><td>' . $date . '</td></tr>';
        if ($details['Betaald'] == 1) {

            $oldDatePaid = DateTime::createFromFormat('Y-m-d', $details['DatumBetaald']);
            $datePaid = $oldDatePaid->format('d/m/Y');
            $html .= '<tr><td>Betaald: </td><td>Ja</td></tr>';
            $html .= '<tr><td>Datum betaald: </td><td>' . $datePaid . '</td></tr>';
        }

        $html .= '   </table>
                </td>
            </tr>
            <tr>
                <td style="background:WHITE;">';
        $eigenaar = generateName($details['Voornaam'], $details['Tussenvoegsel'], $details['Achternaam']);
        $html .= '<h4>' . $eigenaar . '</h4><p>';
        $html .= $details['Adres'] . '<br/>';
        $html .= $details['Postcode'] . '<br/>';
        $html .= $details['Woonplaats'] . '</p></td>';
        $html .= '
            </tr>
        </table><br/>';

    $totalArray = array();

    $html .= '<table cellspacing="0" width="100%">
         <thead>
         <tr>
         <th width="30%">Naam</th>
         <th width="10%">Aantal</th>
         <th width="20%">Prijs per eenheid</th>
         <th width="20%">Standaard prijs</th>
         <th width="20%">Totaal bedrag</th>
         </tr>
         </thead>
         <tbody>';

    foreach ($invoiceLines as $res) {

        $total = $res['Prijs'] + $res['PrijsPerEenheid'] * $res['Aantal'];
        array_push($totalArray, $total);

        $html .= '<tr>';
        $html .= '<td>' . $res['Naam'] . '</td>';
        $html .= '<td>' . $res['Aantal'] . '</td>';
        $html .= '<td>&euro; ' . $res['PrijsPerEenheid'] . '</td>';
        $html .= '<td>&euro; ' . $res['Prijs'] . '</td>';
        $html .= '<td>&euro; ' . $total . '</td>';
        $html .= '</tr>';
    }

    $subTotal = array_sum($totalArray);
    $html .= '<tr>
                <td class="total" colspan="4">Subtotaal:</td>
                <td class="total">&euro; ' . $subTotal . '</td>
            </tr>';

    $html .= '</tbody></table>';

    include("pdf-creator/mpdf60/mpdf.php");

    $mpdf = new mPDF('c', 'A4', '', '', 20, 20, 30, 20, 10, 10);
    $mpdf->SetHeader($header);
    $mpdf->SetDisplayMode('fullpage');

    // LOAD a stylesheet
    $stylesheet = file_get_contents('pdf-creator/style/style.css');
    $mpdf->WriteHTML($stylesheet, 1);    // The parameter 1 tells that this is css/style only and no body/html/text

    $mpdf->WriteHTML($html, 2);

    $mpdf->Output('mpdf.pdf', 'I');
}