<?php
require_once 'includes/globals.php';
require_once 'includes/requireSession.php';
require_once 'includes/functions.php';
require_once 'includes/connectdb.php';

if($_POST['date'] != null){
	$oldDate = DateTime::createFromFormat('d/m/Y', $_POST['date']);
	$date = $oldDate->format('Y-m-d');
}

if($_POST['datePaid'] != null){
	$oldDate = DateTime::createFromFormat('d/m/Y', $_POST['datePaid']);
	$datePaid = $oldDate->format('Y-m-d');
}

$member = cleanInput($_POST['member']);
$paid = cleanInput($_POST['paid']);
$page = $_POST['page'];

if(validateInput($paid, 1, 2)) {
	$dataManager->orWhere('Betaald', '%' . $paid . '%', 'LIKE');
}

if(validateDate($date, 'Y-m-d')) {
	$dataManager->orWhere('Datum', '%' . $date . '%', 'LIKE');
}

if(validateInput($datePaid, 2, 128)) {
	$dataManager->orWhere('DatumBetaald', '%' . $datePaid . '%', 'LIKE');
}

if(validateInput($member, 2, 512)) {
    $naamArray = explode(' ', $member);
    array_walk($naamArray, function(&$value) {
        $value = '%' . $value . '%';
    });

    foreach ($naamArray as $naam) {
        $dataManager->orWhere('Voornaam', $naam, 'LIKE');
        $dataManager->orWhere('Achternaam', $naam, 'LIKE');
        $dataManager->orWhere('Tussenvoegsel', $naam, 'LIKE');
    }
}

$data = $dataManager->get('oh_search_ship');
$totalCount = $dataManager->count;
$result = array();

for($i = $page*50-50; $i < $page*50 && $i < $totalCount; $i++) {
    $result['items'][] = $data[$i];
}

$result['totalCount'] = $totalCount;

echo json_encode($result);
?>