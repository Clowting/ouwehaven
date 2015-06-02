<?php
require_once 'includes/globals.php';
require_once 'includes/requireSession.php';
require_once 'includes/functions.php';
require_once 'includes/connectdb.php';


if(isset($_POST['date'])) {
	$oldDate = DateTime::createFromFormat('d/m/Y', $_POST['date']);
    if(isset($oldDate) && !empty($oldDate)) {
        $date = $oldDate->format('Y-m-d');
    }
}

if(isset($_POST['datePaid'])) {
	$oldDate = DateTime::createFromFormat('d/m/Y', $_POST['datePaid']);
    if(isset($oldDate) && !empty($oldDate)) {
        $datePaid = $oldDate->format('Y-m-d');
    }
}

$member = cleanInput($_POST['member']);
$paid = cleanInput($_POST['paid']);
$page = $_POST['page'];

if(validateNumber($paid, 1, 2)) {
	$dataManager->orWhere('Betaald', $paid);
}

if(validateDate($date, 'Y-m-d')) {
	$dataManager->orWhere('Datum', $date);
}

if(validateDate($datePaid, 'Y-m-d')) {
	$dataManager->orWhere('DatumBetaald', $datePaid);
}

if(validateNumber($member, 1, 11)) {
    $dataManager->orWhere('Lid_ID', $member);
}


$dataManager->join("oh_members m", "m.ID=i.Lid_ID", "LEFT");
$data = $dataManager->get('oh_invoices i');
$totalCount = $dataManager->count;
$result = array();

for($i = $page*50-50; $i < $page*50 && $i < $totalCount; $i++) {
    $result['items'][] = $data[$i];
}

$result['totalCount'] = $totalCount;

echo json_encode($result);