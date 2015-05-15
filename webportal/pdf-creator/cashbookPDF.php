<?php
$date = date("d/m/Y");


if(isset($_POST)){
	$result = $_POST;
}

var_dump($result);

$header = '
	<table border="0" width=100%>
		<tr>
			<td><img src="images/logo.png" width="126px" /></td>
		    <td class="header" align="right"> Printed on:' . $date . '</td>
		</tr>
	</table>
		';

$html = ' <h1>Rapport Kasgegevens</h1>
		<br/><br/>
           <table border ="1" width ="100%">                            
		     <thead>
               <tr>
                 <th width="30%">Beschrijving</th>
                 <th width="15%">Datum</th>
                 <th width="15%">Bedrag</th>
                 <th width="10%">Code</th>
                 <th width="15%">Van</th>
                 <th width="15%">Voor</th>
                </tr>
               </thead>
		       <tbody>';

foreach ( $result as $res ) {
	$html.='<tr>';
	$html.='<td>' . $res['desc'] . '</td>';
	$html.='<td>' . $res['date'] . '</td>';
	$html.='<td>' . $res['amount'] . '</td>';
	$html.='<td>' . $res['code'] . '</td>';
	$html.='<td>' . $res['sender'] . '</td>';
	$html.='<td>' . $res['receiver'] . '</td>';
	
}

$html.='</tr></tbody></table>';


include ("mpdf60/mpdf.php");

$mpdf = new mPDF ( 'c', 'A4', '', '', 20, 20, 30, 20, 10, 10 );
$mpdf->SetHeader ( $header );
$mpdf->SetDisplayMode ( 'fullpage' );

// LOAD a stylesheet
$stylesheet = file_get_contents('style/style.css');
$mpdf->WriteHTML ( $stylesheet, 1 ); // The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->WriteHTML ( $html, 2 );

$mpdf->Output ( 'mpdf.pdf', 'I' );
exit ();
?>